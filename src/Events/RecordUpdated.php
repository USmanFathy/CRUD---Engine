<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Events;

use Illuminate\Database\Eloquent\Model;
use UsmanAhmed\CrudEngine\DTOs\UpdateContext;

/**
 * Dispatched after a record is successfully updated.
 */
final class RecordUpdated
{
    public function __construct(
        public readonly Model $model,
        public readonly UpdateContext $context,
    ) {
    }
}
