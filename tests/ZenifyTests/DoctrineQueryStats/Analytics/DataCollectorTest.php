<?php

namespace ZenifyTests\DoctrineQueryStats;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use ZenifyTests\ContainerFactory;
use ZenifyTests\DatabaseLoader;
use ZenifyTests\DoctrineQueryStats\Entities\Product;


class DataCollectorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var DataCollector
	 */
	private $dataCollector;

	/**
	 * @var EntityRepository
	 */
	private $productRepository;


	protected function setUp()
	{
		$container = (new ContainerFactory())->create();
		/** @var EntityManager $entityManager */
		$entityManager = $container->getByType(EntityManager::class);
		$this->productRepository = $entityManager->getRepository(Product::class);
		$this->dataCollector = $container->getByType(DataCollector::class);

		/** @var DatabaseLoader  $databaseLoader */
		$databaseLoader = $container->getByType(DatabaseLoader::class);
		$databaseLoader->prepareProductTable();
	}


	public function testGetQueriesCount()
	{
		$this->productRepository->findAll();
		$this->assertSame(2, $this->dataCollector->getQueriesCount());
	}

}
