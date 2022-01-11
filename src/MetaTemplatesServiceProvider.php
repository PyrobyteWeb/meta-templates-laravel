<?php

namespace PyrobyteWeb\MetaTemplates;

use Carbon\Laravel\ServiceProvider;
use Illuminate\Routing\Router;
use PyrobyteWeb\MetaTemplates\Console\MetaTemplateAddCommand;
use PyrobyteWeb\MetaTemplates\Console\MetaTemplateCustomCommand;
use PyrobyteWeb\MetaTemplates\Database\Migrations\MetaTemplateCreator;
use PyrobyteWeb\MetaTemplates\Http\Middleware\MetaTemplateMiddleware;

class MetaTemplatesServiceProvider extends ServiceProvider
{
    protected array $commands = [
        'MetaTemplateAdd' => 'command.meta-template.add',
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('meta', function($app) {
            return new MetaTemplate();
        });


        if ($this->app->runningInConsole()) {
            $this->registerConsole();
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('migration.meta-template.creator', function ($app) {
            return new MetaTemplateCreator($app['files'], $app->basePath('stubs'));
        });

        $this->registerCommands($this->commands);
        $this->publishFiles();
    }

    protected function registerMetaTemplateAddCommand()
    {
        $this->app->singleton('command.meta-template.add', function ($app) {
            $creator = $app['migration.meta-template.creator'];

            $composer = $app['composer'];

            return new MetaTemplateAddCommand($creator, $composer);
        });
    }

    protected function configureMiddleware(Router $router)
    {
        $router->aliasMiddleware('meta-templates', MetaTemplateMiddleware::class);
    }

    protected function publishFiles()
    {
        $this->publishes([
            __DIR__ . '/../config/meta-templates.php' => $this->app->configPath() . '/meta-templates.php',
        ], 'config');

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'migrations');
    }

    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $this->{"register{$command}Command"}();
        }

        $this->commands(array_values($commands));
    }

    public function registerConsole(): void
    {
        $this->commands(MetaTemplateCustomCommand::class);
    }
}
