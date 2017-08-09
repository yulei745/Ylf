<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 12:58
 */

namespace Ylf\Foundation;

use Illuminate\Config\Repository as ConfigRepository;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

abstract class AbstractServer
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var string
     */
    protected $publicPath;

    /**
     * @var string
     */
    protected $storagePath;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var callable[]
     */
    protected $extendCallbacks = [];

    /**
     * @param null $basePath
     * @param null $publicPath
     */
    public function __construct($basePath = null)
    {
        if($basePath === null) {
            $basePath = getcwd();
        }

        $this->basePath = $basePath;
    }

    /**
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath(string $basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return string
     */
    public function getPublicPath()
    {
        return $this->publicPath;
    }

    /**
     * @param string $publicPath
     */
    public function setPublicPath(string $publicPath)
    {
        $this->publicPath = $publicPath;
    }

    /**
     * @return string
     */
    public function getStoragePath()
    {
        return $this->storagePath;
    }

    /**
     * @param string $storagePath
     */
    public function setStoragePath(string $storagePath)
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
    }


    protected function getApp()
    {
        if($this->app !== null)
        {
            return $this->app;
        }

        date_default_timezone_set('UTC');

        $app = new Application($this->basePath);

        if ($this->storagePath) {
            $app->useStoragePath($this->storagePath);
        }

        if (file_exists($file = $this->basePath.'/config/config_global.php')) {
            $this->config = include $file;
        }

        $app->instance('env', 'production');
        $app->instance('ylf.config', $this->config);
        $app->instance('config', $config = $this->getIlluminateConfig($app));

        $this->registerLogger($app);

        $app->register('Illuminate\Filesystem\FilesystemServiceProvider');
        $app->register('Illuminate\View\ViewServiceProvider');


        $app->register('Ylf\Api\ApiServiceProvider');
        $app->register('Ylf\Front\FrontServiceProvider');

        foreach ($this->extendCallbacks as $callback) {
            $app->call($callback);
        }

        $app->boot();

        $this->app = $app;

        return $app;
    }


    /**
     * @param Application $app
     * @return ConfigRepository
     */
    protected function getIlluminateConfig(Application $app)
    {
        return new ConfigRepository($app['ylf.config']);
    }

    /**
     * @param Application $app
     */
    protected function registerLogger(Application $app)
    {

        $logger = new Logger($app->environment());
        $logPath = $app->storagePath().'/logs/ylf-runtime.log';

        $handler = new StreamHandler($logPath, Logger::DEBUG);
        $handler->setFormatter(new LineFormatter(null, null, true, true));

        $logger->pushHandler($handler);

        $app->instance('log', $logger);
        $app->alias('log', 'Psr\Log\LoggerInterface');
    }
}