<?php

namespace Zenify\DoctrineQueryStats\Tests\Analytics;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Nette\DI\Container;
use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Zenify\DoctrineQueryStats\Analytics\Query;
use Zenify\DoctrineQueryStats\Tests\ContainerFactory;
use Zenify\DoctrineQueryStats\Tests\DatabaseLoader;
use Zenify\DoctrineQueryStats\Tests\Entities\Product;


class DataCollectorSimilarQueriesTest extends PHPUnit_Framework_TestCase
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
