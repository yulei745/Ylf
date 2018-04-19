<?php


require './vendor/autoload.php';


use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

$finder = new Finder();
$files = $finder->files()->name('api.php')->in('routes');

dd($files->getIterator()->current());