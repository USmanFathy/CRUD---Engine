<?php

declare(strict_types=1);

namespace UsmanAhmed\CrudEngine\Console;

use Illuminate\Console\Command;

/**
 * `php artisan crud-engine:install` — publishes the config and
 * translation files in one step and prints a short quick-start.
 */
final class InstallCommand extends Command
{
    protected $signature = 'crud-engine:install';

    protected $description = 'Publish the Usman Ahmed CRUD Engine config and translation files.';

    public function handle(): int
    {
        $this->call('vendor:publish', ['--tag' => 'crud-engine-config']);
        $this->call('vendor:publish', ['--tag' => 'crud-engine-lang']);

        $this->newLine();
        $this->info('Usman Ahmed CRUD Engine is installed.');
        $this->line('Next steps:');
        $this->line('  1. Implement UsmanAhmed\CrudEngine\Contracts\Capabilities\* on your Eloquent models as needed.');
        $this->line('  2. Extend UsmanAhmed\CrudEngine\Services\Crud\Abstract*Service for each resource.');
        $this->line('  3. Review the published config/crud-engine.php for disk, caching, and validation settings.');

        return self::SUCCESS;
    }
}
