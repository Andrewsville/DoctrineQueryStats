<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineQueryStats\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Tracy\Debugger;
use Zenify\DoctrineQueryStats\Tracy\Panel;


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
			Debugger::class . '::getBar()->addPanel($this->getByType(?));',
			[Panel::class]
		);
	}

}
