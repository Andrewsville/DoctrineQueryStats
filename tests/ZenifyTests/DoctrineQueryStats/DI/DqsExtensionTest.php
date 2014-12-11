<?php

namespace ZenifyTests\DoctrineQueryStats;

use Nette;
use Nette\DI\Container;
use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Zenify\DoctrineQueryStats\Tracy\Panel;
use ZenifyTests\ContainerFactory;


class ExtensionTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Container
	 */
	private $container;


	protected function setUp()
	{
		$this->container = (new ContainerFactory())->create();
	}


	public function testServices()
	{
		$this->assertInstanceOf(DataCollector::class, $this->container->getByType(DataCollector::class));
		$this->assertInstanceOf(Panel::class, $this->container->getByType(Panel::class));
	}

}
