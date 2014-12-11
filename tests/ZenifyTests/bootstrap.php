<?php

/** @var Composer\Autoload\ClassLoader $loader */
$classLoader = include __DIR__ . '/../../vendor/autoload.php';
$classLoader->addPsr4('ZenifyTests\\', __DIR__);
