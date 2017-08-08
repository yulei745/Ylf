<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/7
 * Time: 18:06
 */

namespace Ylf\Console\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCommand extends Command
{

    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * @var OutputInterface
     */
    protected $output;


    protected function configure()
    {
        $this->setting();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $this->fire();
    }

    /**
     * @return mixed
     */
    abstract protected function setting();

    /**
     * @return mixed
     */
    abstract protected function fire();

    /**
     * Send an info string to the user.
     *
     * @param string $string
     */
    protected function info($string)
    {
        $this->output->writeln("<info>$string</info>");
    }

    protected function comment($string)
    {
        $this->output->writeln("<comment>$string</comment>");
    }

}