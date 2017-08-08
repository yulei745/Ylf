<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/7
 * Time: 18:05
 */

namespace Ylf\Console\Command;

use Ylf\Foundation\Application;


class InfoCommand extends AbstractCommand
{
    protected $config;

    public function __construct(array $config = null)
    {
        $this->config = $config;
        parent::__construct();
    }

    /**
     * @return mixed
     */
    protected function setting()
    {
        // TODO: Implement config() method.
        $this->setName('info')->setDescription('info ylf')->setHelp('allalalal');
    }

    /**
     * @return mixed
     */
    protected function fire()
    {
        // TODO: Implement fire() method.
        $coreVersion = $this->findPackageVersion(__DIR__.'/../../../', Application::VERSION);

        $this->info("Flarum core $coreVersion");

        $this->info('PHP '.PHP_VERSION);

        $phpExtensions = implode(', ', get_loaded_extensions());
        $this->info("Loaded extensions: $phpExtensions");

        $this->info('Base URL: '.$this->config['url']);
        $this->info('Installation path: '.getcwd());
    }

    protected function findPackageVersion($path, $fallback)
    {
        if (file_exists("$path/.git")) {
            $cwd = getcwd();
            chdir($path);

            $output = [];
            $status = null;
            exec('git rev-parse HEAD', $output, $status);

            chdir($cwd);

            if ($status == 0) {
                return "$fallback ($output[0])";
            }
        }

        return $fallback;
    }
}