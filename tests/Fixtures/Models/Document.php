<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use UsmanAhmed\CrudEngine\Contracts\Capabilities\FileUpload;
use UsmanAhmed\CrudEngine\Contracts\Capabilities\OriginalName;

/**
 * Implements both FileUpload and OriginalName, so the file lifecycle
 * service selects {@see \UsmanAhmed\CrudEngine\Strategies\Files\OriginalFilenameStrategy}
 * for it — the strategy under test for the Security Finding S4
 * (path-traversal) regression.
 */
class Document extends Model implements FileUpload, OriginalName
{
    protected $guarded = [];

    public function documentFullPathStore(): string
    {
        return 'documents/'.$this->getKey();
    }

    public function requestKeysForFile(): array
    {
        return ['original_file'];
    }
}
