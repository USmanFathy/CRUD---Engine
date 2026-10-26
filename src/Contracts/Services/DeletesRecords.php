<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Contracts\Services;

use UsmanAhmed\CrudEngine\DTOs\CrudOperationResult;

/**
 * Contract for a "delete" Crud operation (single or bulk).
 */
interface DeletesRecords
{
    public function delete(): CrudOperationResult;
}
