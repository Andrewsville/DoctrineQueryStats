<?php

namespace Zenify\DoctrineQueryStats\Tests\Analytics;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Nette\DI\Container;
use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Zenify\DoctrineQueryStats\Tests\ContainerFactory;
use Zenify\DoctrineQueryStats\Tests\DatabaseLoader;
use Zenify\DoctrineQueryStats\Tests\Entities\Product;


class DataCollectorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var DataCollector
	 */
	private $dataCollector;

	/**
	 * @var EntityRepository
	 */
	private $productRepository;


	public function __construct()
	{
		$this->container = (new ContainerFactory)->create();
	}


	protected function setUp()
	{
		/** @var EntityManager $entityManager */
		$entityManager = $this->container->getByType(EntityManager::class);
		$this->productRepository = $entityManager->getRepository(Product::class);
		$this->dataCollector = $this->container->getByType(DataCollector::class);

		/** @var DatabaseLoader $databaseLoader */
		$databaseLoader = $this->container->getByType(DatabaseLoader::class);
		$databaseLoader->prepareProductTable();
	}


	public function testGetQueriesCount()
	{
		$this->productRepository->findAll();
		$this->assertSame(2, $this->dataCollector->getQueriesCount());
	}

}
