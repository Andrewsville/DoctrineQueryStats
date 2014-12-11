<?php

namespace ZenifyTests\DoctrineQueryStats;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Zenify\DoctrineQueryStats\Analytics\Query;
use ZenifyTests\ContainerFactory;
use ZenifyTests\DatabaseLoader;
use ZenifyTests\DoctrineQueryStats\Entities\Product;


class DataCollectorSimilarQueriesTest extends PHPUnit_Framework_TestCase
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
		$container = (new ContainerFactory)->create();

		/** @var EntityManager $entityManager */
		$entityManager = $container->getByType(EntityManager::class);
		$this->productRepository = $entityManager->getRepository(Product::class);
		$this->dataCollector = $container->getByType(DataCollector::class);

		/** @var DatabaseLoader  $databaseLoader */
		$databaseLoader = $container->getByType(DatabaseLoader::class);
		$databaseLoader->prepareProductTable();
	}


	public function testGetSimilarQueries()
	{
		$this->productRepository->findBy(['id' => 1]);
		$this->productRepository->findBy(['id' => 2]);
		$this->productRepository->findBy(['id' => 3]);
		$this->assertSame(1, $this->dataCollector->getSimilarQueriesCount());

		/** @var Query $query */
		$similarQueries = $this->dataCollector->getSimilarQueries();
		$query = array_pop($similarQueries);
		$this->assertInstanceOf(Query::class, $query);
		$this->assertSame('SELECT t0.id AS id1, t0.name AS name2 FROM product t0 WHERE t0.id = ?', $query->getSql());
		$this->assertSame(
			'SELECT t0.id AS id1, t0.name AS name2 FROM product t0 WHERE t0.id = 3', $query->getSqlWithParameters()
		);
	}

}
