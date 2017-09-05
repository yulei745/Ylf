<?php
/*
 * This file is part of Ylf.
 *
 * (c) Toby Zerner <yleimm@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ylf\Foundation;

use Exception;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use Ylf\Http\RouteCollection;
use Ylf\Http\Handler\RouteHandlerFactory;

use Ylf\Event\ConfigureFrontRoutes;

use Symfony\Component\Finder\Finder;

abstract class AbstractServiceProvider extends ServiceProvider
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function register(){}

    public function boot(){}

    public function getRootesName() {}

    /**
     * @param RouteCollection $routes
     */
    protected function populateRoutes(RouteCollection $routes)
    {
        $route = $this->app->make(RouteHandlerFactory::class);
        $routename = Str::lower($this->getRootesName());

        $routeConfigPath = realpath($this->app->basePath().'/routes');

        if (! $routeConfigPath) {
            throw new Exception('Unable to load the "routes" configuration file.');
        }

        foreach (Finder::create()->files()->name($routename.'.php')->in($routeConfigPath) as $file) {
            require $file->getRealPath();break;
        }

//        $config = $this->app->make('ylf.config');
//
//        $routename = Str::lower($this->getRootesName());
//
//        if(!empty($config['routes'][$routename])) {
//            foreach ($config['routes'][$routename] as $k => $v) {
//                list($controller, $name) = explode('@', $v[1]);
//                $routes->get($v[0], $name, $route->toController("Ylf\\{$routename}\Controller\\{$controller}"));
//            }
//        }

//        $this->app->make('events')->fire(
//            new ConfigureFrontRoutes($routes, $route)
//        );
    }
}
