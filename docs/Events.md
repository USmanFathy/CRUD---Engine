# Events

The package dispatches seven domain events across the Crud, file, and relation lifecycles. All events are `final` classes with `readonly` public properties. They are dispatched via the injected `Illuminate\Contracts\Events\Dispatcher`, never via the `event()` helper.

The default `LogCrudOperationListener` subscribes to all seven. See [Listeners.md](Listeners.md) for logging details.

---

## `RecordCreated`

**Namespace:** `UsmanAhmed\CrudEngine\Events\RecordCreated`

**Dispatched by:** `AbstractStoreService::store()` — after the DB transaction commits, after files are handled, after relations are synced.

**Properties:**

```php
public readonly Model $model;          // the newly created model instance
public readonly StoreContext $context; // contains modelClass and validated attributes
```

**Use cases:**
- Bust cache for resource listings
- Send a "new record" notification
- Write to an audit log with the full attribute set

**Example listener:**

```php
Event::listen(RecordCreated::class, function (RecordCreated $event) {
    cache()->forget("posts.index");
    logger()->info('Post created', ['id' => $event->model->getKey()]);
});
```

---

## `RecordUpdated`

**Namespace:** `UsmanAhmed\CrudEngine\Events\RecordUpdated`

**Dispatched by:** `AbstractUpdateService::update()` — after the DB transaction commits, after files are handled, after relations are synced.

**Properties:**

```php
public readonly Model $model;           // the updated model instance
public readonly UpdateContext $context; // contains the model and validated attributes
```

**Use cases:**
- Invalidate per-record caches
- Push a real-time update via broadcast

---

## `RecordDeleted`

**Namespace:** `UsmanAhmed\CrudEngine\Events\RecordDeleted`

**Dispatched by:** `AbstractDeleteService::delete()` — once per successfully deleted record. In a bulk operation, this fires once per successful deletion.

**Properties:**

```php
public readonly Model $model;  // the model that was deleted (key is still accessible)
```

**Use cases:**
- Remove the record's cache entry
- Clean up related external resources (e.g. CDN purge)

---

## `RecordDeletionFailed`

**Namespace:** `UsmanAhmed\CrudEngine\Events\RecordDeletionFailed`

**Dispatched by:** `AbstractDeleteService::delete()` — once per failed deletion attempt. The exception is caught, this event is dispatched, and the operation continues with the next record.

**Properties:**

```php
public readonly Model $model;
public readonly \Throwable $exception;  // the exception that caused the failure
```

This event is the direct fix for Bug 4.7 from the original codebase, which caught every `\Throwable` in `deleteModelWithFiles()` and returned `false` with no logging whatsoever.

**Example listener — alert on failure:**

```php
Event::listen(RecordDeletionFailed::class, function (RecordDeletionFailed $event) {
    app('slack')->send(
        "⚠️ Failed to delete {$event->model::class} #{$event->model->getKey()}: "
        . $event->exception->getMessage()
    );
});
```

---

## `FileStored`

**Namespace:** `UsmanAhmed\CrudEngine\Events\FileStored`

**Dispatched by:** `FileLifecycleService::store()` — after the file is written to disk and the model attribute is saved.

**Properties:**

```php
public readonly Model $model;
public readonly FileOperation $operation;
// $operation->type     === FileOperationType::Stored
// $operation->attribute === 'cover_image'
// $operation->fileName  === 'a1b2c3.jpg'
// $operation->url       === 'https://...'
```

**Use cases:**
- Dispatch an image-processing job (resizing, thumbnailing)
- Index the file URL in a search engine

```php
Event::listen(FileStored::class, function (FileStored $event) {
    ProcessImageJob::dispatch($event->model, $event->operation->attribute);
});
```

---

## `FileDeleted`

**Namespace:** `UsmanAhmed\CrudEngine\Events\FileDeleted`

**Dispatched by:** `FileLifecycleService::delete()` — after the physical file is removed and the model attribute is nulled and saved.

**Properties:**

```php
public readonly Model $model;
public readonly FileOperation $operation;
// $operation->type      === FileOperationType::Deleted
// $operation->attribute === 'cover_image'
// $operation->fileName  === 'a1b2c3.jpg' (filename before deletion)
// $operation->url       === null
```

**Use cases:**
- Purge a CDN edge cache for the deleted file URL
- Remove the filename from a search index

---

## `RelationSynced`

**Namespace:** `UsmanAhmed\CrudEngine\Events\RelationSynced`

**Dispatched by:** `RelationSyncManager::dispatchEach()` — once per relation successfully synced.

**Properties:**

```php
public readonly Model $model;
public readonly string $relationName;    // e.g. 'comments'
public readonly RelationType $type;      // HasMany | HasOne | ManyToMany
```

**Use cases:**
- Invalidate cache for a specific relation on a parent model
- Emit a granular audit log entry per relation change

```php
Event::listen(RelationSynced::class, function (RelationSynced $event) {
    cache()->forget("post:{$event->model->getKey()}:{$event->relationName}");
});
```

---

## Registering Listeners

Register in your `EventServiceProvider`:

```php
protected $listen = [
    \UsmanAhmed\CrudEngine\Events\RecordCreated::class => [
        \App\Listeners\InvalidatePostCache::class,
        \App\Listeners\NotifyAdminOfNewPost::class,
    ],
    \UsmanAhmed\CrudEngine\Events\RecordDeletionFailed::class => [
        \App\Listeners\AlertOnDeletionFailure::class,
    ],
];
```

Or use closures in a service provider's `boot()`:

```php
use Illuminate\Support\Facades\Event;
use UsmanAhmed\CrudEngine\Events\FileStored;

Event::listen(FileStored::class, function (FileStored $event) {
    ProcessImageJob::dispatch($event->model, $event->operation);
});
```

The default `LogCrudOperationListener` fires alongside your listeners unless you disable it via `crud-engine.log_operations = false`.
