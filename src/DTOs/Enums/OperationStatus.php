<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\DTOs\Enums;

enum OperationStatus: string
{
    case Success = 'success';
    case PartialSuccess = 'partial_success';
    case Error = 'error';
}
