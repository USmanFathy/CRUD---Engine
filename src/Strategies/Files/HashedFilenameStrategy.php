<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Strategies\Files;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use UsmanAhmed\CrudEngine\Contracts\Files\FileNamingStrategyInterface;

/**
 * Default file naming strategy: delegates to Laravel's own collision-safe
 * hashed filename generation. Used for every model unless it implements
 * {@see \UsmanAhmed\CrudEngine\Contracts\Capabilities\OriginalName}.
 */
final class HashedFilenameStrategy implements FileNamingStrategyInterface
{
    public function generateName(UploadedFile $file, Model $model): string
    {
        return $file->hashName();
    }
}
