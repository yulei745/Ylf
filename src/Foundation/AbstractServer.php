<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/3
 * Time: 12:58
 */

namespace Ylf\Foundation;

use Exception;
use Illuminate\Support\Facades\App;
use SplFileInfo;

use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Config\Repository as RepositoryContract;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use Symfony\Component\Finder\Finder;

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

        $app = new Application($this->basePath);

        $this->getIlluminateConfig($app);

        $this->registerLogger($app);

        $this->registerProviders($app);

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
        $app->instance('config', $config = new ConfigRepository([]));
        $this->loadConfigurationFiles($app, $config);
        $app->instance('env', $config->get('app.env', 'production'));
        date_default_timezone_set($config->get('app.timezone', 'Asia/Shanghai'));
    }

    /**
     * Load the configuration items from all of the files.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Config\Repository  $repository
     * @return void
     * @throws \Exception
     */
    protected function loadConfigurationFiles(Application $app, RepositoryContract $repository)
    {
        $files = $this->getConfigurationFiles($app);

        if (! isset($files['app'])) {
            throw new Exception('Unable to load the "app" configuration file.');
        }

        foreach ($files as $key => $path) {
            $repository->set($key, require $path);
        }
    }

    /**
     * Get all of the configuration files for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return array
     */
    protected function getConfigurationFiles(Application $app)
    {
        $files = [];

        $configPath = realpath($app->configPath());

        foreach (Finder::create()->files()->name('*.php')->in($configPath) as $file) {
            $directory = $this->getNestedDirectory($file, $configPath);

            $files[$directory.basename($file->getRealPath(), '.php')] = $file->getRealPath();
        }

        return $files;
    }

    /**
     * Get the configuration file nesting path.
     *
     * @param  \SplFileInfo  $file
     * @param  string  $configPath
     * @return string
     */
    protected function getNestedDirectory(SplFileInfo $file, $configPath)
    {
        $directory = $file->getPath();

        if ($nested = trim(str_replace($configPath, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }

        return $nested;
    }

    /**
     * @param Application $app
     */
    protected function registerLogger(Application $app)
    {

        $logger = new Logger($app->environment());
        $logPath = $app->make('config')->get('app.log_path', $app->storagePath().'logs/runtime.log');
        $level = $app->make('config')->get('app.log_level', Logger::DEBUG);

        $handler = new StreamHandler($logPath, $level);
        $handler->setFormatter(new LineFormatter(null, null, true, true));

        $logger->pushHandler($handler);

        $app->instance('log', $logger);
        $app->alias('log', 'Psr\Log\LoggerInterface');
    }

    /**
     * @param Application $app
     */
    protected function registerProviders(Application $app)
    {

        $providers = $app->make('config')->get('app.providers');
        foreach ($providers as $provider)
        {
            $app->register($provider);
        }
    }
}