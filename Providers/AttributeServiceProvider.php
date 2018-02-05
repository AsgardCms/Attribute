<?php

namespace Modules\Attribute\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Attribute\Blade\AttributesDirective;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Normalisers\AttributeOptionsNormaliser;
use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Attribute\Repositories\AttributesManager;
use Modules\Attribute\Repositories\AttributesManagerRepository;
use Modules\Attribute\Repositories\Cache\CacheAttributeDecorator;
use Modules\Attribute\Repositories\Eloquent\EloquentAttributeRepository;
use Modules\Attribute\Types\CheckboxType;
use Modules\Attribute\Types\InputType;
use Modules\Attribute\Types\MultiSelectType;
use Modules\Attribute\Types\RadioType;
use Modules\Attribute\Types\SelectType;
use Modules\Attribute\Types\TextareaType;
use Modules\Core\Traits\CanPublishConfiguration;

class AttributeServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();

        $this->app[AttributesManager::class]->registerType(new InputType());
        $this->app[AttributesManager::class]->registerType(new CheckboxType());
        $this->app[AttributesManager::class]->registerType(new MultiSelectType());
        $this->app[AttributesManager::class]->registerType(new RadioType());
        $this->app[AttributesManager::class]->registerType(new SelectType());
        $this->app[AttributesManager::class]->registerType(new TextareaType());

        $this->app->singleton('options.normaliser', function () {
            return new AttributeOptionsNormaliser();
        });

        $this->app->bind('attribute.attributes.directive', function ($app) {
            return new AttributesDirective($app[AttributeRepository::class], $app[AttributesManager::class]);
        });
    }

    public function boot()
    {
        $this->publishConfig('attribute', 'permissions');
        $this->registerBladeTags();
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(AttributeRepository::class, function () {
            $repository = new EloquentAttributeRepository(new Attribute());

            if (! config('app.cache')) {
                return $repository;
            }

            return new CacheAttributeDecorator($repository);
        });

        $this->app->singleton(AttributesManager::class, function () {
            return new AttributesManagerRepository();
        });
    }

    private function registerBladeTags()
    {
        if (app()->environment() === 'testing') {
            return;
        }
        $this->app['blade.compiler']->directive('attributes', function ($value) {
            return "<?php echo AttributesDirective::show([$value]); ?>";
        });
    }
}
