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


class DataCollectorIdenticalQueriesTest extends TestCase
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

	/**
	 * @var bool
	 */
	private $isDbSchemaPrepared = FALSE;


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


	public function testGetIdenticalQueries()
	{
		$this->productRepository->findAll();
		$this->productRepository->findAll();
		Assert::count(1, $this->dataCollector->getIdenticalQueries());

		/** @var Query $query */
		$identicalQueries = $this->dataCollector->getIdenticalQueries();
		$query = array_pop($identicalQueries);
		Assert::type(Query::class, $query);
		Assert::same('SELECT t0.id AS id1, t0.name AS name2 FROM product t0', $query->getSqlWithParameters());
	}


	public function testGetIdenticalQueriesCount()
	{
		$this->productRepository->findAll();
		$this->productRepository->findAll();
		Assert::same(1, $this->dataCollector->getIdenticalQueriesCount());
	}


	private function prepareDbSchema()
	{
		if ( ! $this->isDbSchemaPrepared) {
			/** @var Connection $connection */
			$connection = $this->container->getByType(Connection::class);
			$connection->query('CREATE TABLE product (id INTEGER NOT NULL, name string, PRIMARY KEY(id))');
			$this->isDbSchemaPrepared = TRUE;
		}
	}

}


(new DataCollectorIdenticalQueriesTest($container))->run();
