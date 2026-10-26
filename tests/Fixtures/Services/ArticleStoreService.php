<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Tests\Fixtures\Services;

use UsmanAhmed\CrudEngine\Services\Crud\AbstractStoreService;
use UsmanAhmed\CrudEngine\Tests\Fixtures\Models\Article;
use UsmanAhmed\CrudEngine\Tests\Fixtures\Requests\ArticleRequest;

/**
 * Matches the shape your clarification #5 described: a concrete
 * service that only defines the model, the request class, and (here,
 * inherited defaults for) success/error messages — proving the
 * abstract base class still supports that minimal subclass pattern
 * after the refactor.
 */
final class ArticleStoreService extends AbstractStoreService
{
    public function model(): string
    {
        return Article::class;
    }

    public function requestFile(): string
    {
        return ArticleRequest::class;
    }
}
