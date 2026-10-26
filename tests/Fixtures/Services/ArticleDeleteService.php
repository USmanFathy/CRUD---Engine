<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Tests\Fixtures\Services;

use Illuminate\Database\Eloquent\Collection;
use UsmanAhmed\CrudEngine\Services\Crud\AbstractDeleteService;
use UsmanAhmed\CrudEngine\Tests\Fixtures\Models\Article;

final class ArticleDeleteService extends AbstractDeleteService
{
    private ?Collection $targets = null;

    public function forTargets(Collection $targets): static
    {
        $this->targets = $targets;

        return $this;
    }

    public function model(): string
    {
        return Article::class;
    }

    public function resolveTargets(): Collection
    {
        return $this->targets ?? new Collection();
    }
}
