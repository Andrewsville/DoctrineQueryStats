<?php

namespace ZenifyTests\DoctrineQueryStats;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Zenify\DoctrineQueryStats\Analytics\Query;
use ZenifyTests\DoctrineQueryStats\Entities\Product;


$container = require_once __DIR__ . '/../../bootstrap.php';


class DataCollectorSimilarQueriesTest extends TestCase
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


	public function __construct(Container $container)
	{
		$this->container = $container;
	}


	protected function setUp()
	{
		/** @var EntityManager $entityManager */
		$entityManager = $this->container->getByType(EntityManager::class);
		$this->productRepository = $entityManager->getRepository(Product::class);
		$this->dataCollector = $this->container->getByType(DataCollector::class);

		$this->prepareDbSchema();
	}


	public function testGetSimilarQueries()
	{
		$this->productRepository->findBy(['id' => 1]);
		$this->productRepository->findBy(['id' => 2]);
		$this->productRepository->findBy(['id' => 3]);
		Assert::same(1, $this->dataCollector->getSimilarQueriesCount());

		/** @var Query $query */
		$similarQueries = $this->dataCollector->getSimilarQueries();
		$query = array_pop($similarQueries);
		Assert::type(Query::class, $query);
		Assert::same('SELECT t0.id AS id1, t0.name AS name2 FROM product t0 WHERE t0.id = ?', $query->getSql());
		Assert::same(
			'SELECT t0.id AS id1, t0.name AS name2 FROM product t0 WHERE t0.id = 1', $query->getSqlWithParameters()
		);
	}


	private function prepareDbSchema()
	{
		/** @var Connection $connection */
		$connection = $this->container->getByType(Connection::class);
		$connection->query('CREATE TABLE product (id INTEGER NOT NULL, name string, PRIMARY KEY(id))');
	}

}


(new DataCollectorSimilarQueriesTest($container))->run();
