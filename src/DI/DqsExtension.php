<?php

/**
 * This file is part of Lekarna
 * Copyright (c) 2014 Pears Health Cyber, s.r.o. (http://pearshealthcyber.cz)
 */

namespace Lekarna\DoctrineQueryStats\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;


class DqsExtension extends CompilerExtension
{

	public function loadConfiguration()
	{
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('dataCollector'))
			->setClass('Lekarna\DoctrineQueryStats\Analytics\DataCollector');

		$builder->addDefinition($this->prefix('queryAnalyzer'))
			->setClass('Lekarna\DoctrineQueryStats\Analytics\QueryAnalyzer');

		$builder->addDefinition($this->prefix('loggerDataExtractor'))
			->setClass('Lekarna\DoctrineQueryStats\Analytics\LoggerDataExtractor');

		$builder->addDefinition($this->prefix('bar'))
			->setClass('Lekarna\DoctrineQueryStats\Tracy\Panel')
			->setImplement('Lekarna\DoctrineQueryStats\Tracy\PanelFactory');
	}


	public function afterCompile(ClassType $class)
	{
		$initialize = $class->getMethods()['initialize'];
		$initialize->addBody(
			'Tracy\Debugger::getBar()->addPanel($this->getByType(?)->create());',
			array('Lekarna\DoctrineQueryStats\Tracy\PanelFactory')
		);
	}

}
