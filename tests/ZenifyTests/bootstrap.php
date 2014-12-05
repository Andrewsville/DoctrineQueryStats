<?php

/** @var Composer\Autoload\ClassLoader $loader */
if (@ ! $classLoader = include __DIR__ . '/../../vendor/autoload.php') {
	echo "Install Nette Tester using  'composer update'";
	exit(1);
}
$classLoader->addPsr4('ZenifyTests\\', __DIR__);


// configure environment
Tester\Environment::setup();
date_default_timezone_set('Europe/Prague');


// create temporary directory
define('TEMP_DIR', createAndReturnTempDir());


/** @return string */
function createAndReturnTempDir() {
	@mkdir(__DIR__ . '/../tmp'); // @ - directory may exists
	@mkdir($tempDir = __DIR__ . '/../tmp/' . (isset($_SERVER['argv']) ? md5(serialize($_SERVER['argv'])) : getmypid()));
	Tester\Helpers::purge($tempDir);
	return realpath($tempDir);
}


$_SERVER = array_intersect_key($_SERVER, array_flip(array(
	'PHP_SELF', 'SCRIPT_NAME', 'SERVER_ADDR', 'SERVER_SOFTWARE', 'HTTP_HOST', 'DOCUMENT_ROOT', 'OS', 'argc', 'argv')));
$_SERVER['REQUEST_TIME'] = 1234567890;
$_ENV = $_GET = $_POST = [];


$configurator = new Nette\Configurator;
$configurator->setTempDirectory(TEMP_DIR);
$configurator->addConfig(__DIR__ . '/config/default.neon');
return $configurator->createContainer();
