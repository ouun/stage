<?php

namespace Stage\Providers;

use ReflectionClass;
use Illuminate\Support\Str;
use Roots\Acorn\View\Composer;
use Roots\Acorn\ServiceProvider;
use Symfony\Component\Finder\Finder;

class StageServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * Note: As parent theme no effect
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('stage', function () {
            return [
                'path' => get_template_directory() . '/app',
                'namespace' => 'Stage\\',
            ];
        });
    }

    /**
     * Bootstrap any application services.
     * Note: As parent theme no effect
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Return an instance of View.
     *
     * @return \Illuminate\View\View
     */
    protected function view()
    {
        return $this->app['view'];
    }

    /**
     * Attach Stage View Composers
     *
     * @return void
     * @throws \ReflectionException
     */
    public function attachStageComposers()
    {
        if (! isset($this->app['stage']) || ! is_dir($path = $this->app['stage']['path']  . '/View/Composers')) {
            return;
        }

        $namespace = $this->app['stage']['namespace'];

        // TODO: This should be cacheable, perhaps via `wp acorn` command
        foreach ((new Finder())->in($path)->files() as $composer) {
            $composer = $namespace . str_replace(
                ['/', '.php'],
                ['\\', ''],
                Str::after($composer->getPathname(), $this->app['stage']['path'] . DIRECTORY_SEPARATOR)
            );

            if (
                is_subclass_of($composer, Composer::class) &&
                ! (new ReflectionClass($composer))->isAbstract()
            ) {
                $this->view()->composer($composer::views(), $composer);
            }
        }
    }
}
