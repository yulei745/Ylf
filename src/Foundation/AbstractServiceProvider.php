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

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

use Ylf\Http\RouteCollection;
use Ylf\Http\Handler\RouteHandlerFactory;

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
        $config = $this->app->make('ylf.config');

        $routename = Str::lower($this->getRootesName());

        if(!empty($config['routes'][$routename])) {
            foreach ($config['routes'][$routename] as $k => $v) {
                list($controller, $name) = explode('@', $v[1]);
                $routes->get($v[0], $name, $route->toController("Ylf\\{$routename}\Controller\\{$controller}"));
            }
        }
    }
}
