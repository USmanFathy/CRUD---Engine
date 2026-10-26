<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Contracts\Services;

use UsmanAhmed\CrudEngine\DTOs\CrudOperationResult;

/**
 * Contract for an "update" Crud operation.
 */
interface UpdatesRecords
{
    public function update(): CrudOperationResult;
}
