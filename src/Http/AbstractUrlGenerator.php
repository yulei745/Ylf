<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/10
 * Time: 18:01
 */

namespace Ylf\Http;

use Ylf\Foundation\Application;

class AbstractUrlGenerator
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var RouteCollection
     */
    protected $routes;

    /**
     * @var string|null
     */
    protected $path;

    /**
     * @param Application $app
     * @param RouteCollection $routes
     */
    public function __construct(Application $app, RouteCollection $routes)
    {
        $this->app = $app;
        $this->routes = $routes;
    }

    /**
     * Generate a URL to a named route.
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function toRoute($name, $parameters = [])
    {
        $path = $this->routes->getPath($name, $parameters);
        $path = ltrim($path, '/');

        return $this->toBase().'/'.$path;
    }

    /**
     * Generate a URL to a path.
     *
     * @param string $path
     * @return string
     */
    public function toPath($path)
    {
        return $this->toBase().'/'.$path;
    }

    /**
     * Generate a URL to base with UrlGenerator's prefix.
     *
     * @return string
     */
    public function toBase()
    {
        return $this->app->url($this->path);
    }
}