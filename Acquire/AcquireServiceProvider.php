<?php

namespace Acquire;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;

class AcquireServiceProvider extends ServiceProvider
{
    /**
     * Define the Application Modules
     *
     * @var array<string>
     */
    protected array $modules = [
        'Auth',
        'User',
        'Customer',
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        $this->registerAcquireModules();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    private function registerAcquireModules()
    {
        // Register routes
        Route::group([
            'as' => 'acquire.api.',
            'prefix' => 'api',
            'middleware' => ['api'],
            'namespace' => 'Acquire\Modules',
        ], function () {
            foreach ($this->modules as $module) {
                Route::group([
                    //'as' => strtolower($module),
                    'namespace' => $module,
                    'middleware' => $module == 'Auth' ? [] : ['auth:api'],
                ], function () use ($module) {
                    $file = base_path("Acquire/Modules/{$module}/routes.php");
                    if (file_exists($file)) {
                        $this->loadRoutesFrom($file);
                    }
                });
            }
        });

        // Register commands
        foreach ($this->modules as $module) {
            $basePath = base_path("Acquire/Modules/{$module}");
            $commandsPath = $basePath . '/Commands';
            if (is_dir($commandsPath)) {
                $this->commands(
                    array_map(
                        function ($file) use ($module) {
                            return "Acquire\\Modules\\{$module}\\Commands\\" . pathinfo($file, PATHINFO_FILENAME);
                        },
                        File::files($commandsPath)
                    )
                );
            }

            // ...
        }
    }
}
