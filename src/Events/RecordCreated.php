<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Events;

use Illuminate\Database\Eloquent\Model;
use UsmanAhmed\CrudEngine\DTOs\StoreContext;

/**
 * Dispatched after a record is successfully created.
 *
 * Replaces the inline `Log::info()` calls baked into the original
 * `AbstractClassHandleStoreData::createNewRecord()`. The package's
 * default {@see \UsmanAhmed\CrudEngine\Listeners\LogCrudOperationListener}
 * subscribes to this for equivalent logging; consuming applications can
 * add their own listeners for cache invalidation, audit trails, etc.
 */
final class RecordCreated
{
    public function __construct(
        public readonly Model $model,
        public readonly StoreContext $context,
    ) {
    }
}
