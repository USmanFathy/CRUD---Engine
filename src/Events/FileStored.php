<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Events;

use Illuminate\Database\Eloquent\Model;
use UsmanAhmed\CrudEngine\DTOs\FileOperation;

/**
 * Dispatched after a file is successfully stored for a model attribute.
 */
final class FileStored
{
    public function __construct(
        public readonly Model $model,
        public readonly FileOperation $operation,
    ) {
    }
}
