<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Tests\Fixtures\Services;

use UsmanAhmed\CrudEngine\Services\Statistics\AbstractStatisticsService;
use UsmanAhmed\CrudEngine\Tests\Fixtures\Models\Article;

final class ArticleStatisticsService extends AbstractStatisticsService
{
    public function getModelClass(): string
    {
        return Article::class;
    }

    public function getDateColumn(): string
    {
        return 'created_at';
    }
}
