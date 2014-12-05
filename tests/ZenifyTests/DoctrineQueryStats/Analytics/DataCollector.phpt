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


class DataCollectorTest extends TestCase
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


	public function testGetQueriesCount()
	{
		$this->productRepository->findAll();
		Assert::same(2, $this->dataCollector->getQueriesCount());
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


(new DataCollectorTest($container))->run();
