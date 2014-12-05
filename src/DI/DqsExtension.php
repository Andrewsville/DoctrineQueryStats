<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineQueryStats\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;


class DqsExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();
		$services = $this->loadFromFile(__DIR__ . '/services.neon');
		$this->compiler->parseServices($builder, $services);
	}


	public function afterCompile(ClassType $class)
	{
		$initialize = $class->getMethods()['initialize'];
		$initialize->addBody(
			'Tracy\Debugger::getBar()->addPanel($this->getByType(?));',
			['Zenify\DoctrineQueryStats\Tracy\Panel']
		);
	}

}
