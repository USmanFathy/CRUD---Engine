<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Contracts\Services;

use UsmanAhmed\CrudEngine\DTOs\CrudOperationResult;

/**
 * Contract for a "create" Crud operation. Consuming applications type-hint
 * against this in controllers (rather than a concrete class) so the
 * implementation can be swapped or faked in tests.
 */
interface CreatesRecords
{
    public function store(): CrudOperationResult;
}
