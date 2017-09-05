<?php

/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/7
 * Time: 17:39
 */

namespace Ylf\Console;

use Ylf\Foundation\AbstractServer;
use Ylf\Console\Command\TestCmd;
use Ylf\Console\Command\InfoCommand;

use Symfony\Component\Console\Application;


class Server extends AbstractServer
{
    public function listen()
    {
        $console = $this->getConsoleApplication();

        exit($console->run());
    }


    protected function getConsoleApplication()
    {
        $app = $this->getApp();

        $console = new Application('Ylf', $app->version());

        $commands = [
            InfoCommand::class
        ];

        foreach ($commands as $command)
        {
            $console->add($app->make($command, $app->make('ylf.config')));
        }

        return $console;
    }
}