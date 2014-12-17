<?php

namespace Zenify\DoctrineQueryStats\Tests;

use Nette\Configurator;
use Nette\DI\Container;
use Nette\Utils\FileSystem;


class ContainerFactory
{

	/**
	 * @return Container
	 */
	public function create()
	{
		$configurator = new Configurator;
		$configurator->setTempDirectory($this->createAndReturnTempDir());
		$configurator->addConfig(__DIR__ . '/config/default.neon');
		return $configurator->createContainer();
	}


	/**
	 * @return string
	 */
	private function createAndReturnTempDir()
	{
		$tempDir = __DIR__ . '/temp/';
		FileSystem::delete($tempDir);
		@mkdir($tempDir); // @ - directory may exists
		return realpath($tempDir);
	}

}
