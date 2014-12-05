<?php

namespace ZenifyTests\DoctrineQueryStats;

use Nette;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Zenify\DoctrineQueryStats\Tracy\Panel;


$container = require_once __DIR__ . '/../../bootstrap.php';


class ExtensionTest extends TestCase
{

	/**
	 * @var Container
	 */
	private $container;


	public function __construct(Container $container)
	{
		$this->container = $container;
	}


	public function testServices()
	{
		Assert::type(DataCollector::class, $this->container->getByType(DataCollector::class));
		Assert::type(Panel::class, $this->container->getByType(Panel::class));
	}

}


(new ExtensionTest($container))->run();
