<?php

namespace ZenifyTests\DoctrineQueryStats;

use Doctrine\DBAL\Connection;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;
use Zenify\DoctrineQueryStats\Analytics\LoggerDataExtractor;
use Zenify\DoctrineQueryStats\Analytics\Query;


$container = require_once __DIR__ . '/../../bootstrap.php';


class LoggerDataExtractorTest extends TestCase
{

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var LoggerDataExtractor
	 */
	private $loggerDataExtractor;


	public function __construct(Container $container)
	{
		$this->container = $container;
	}


	protected function setUp()
	{
		$this->loggerDataExtractor = $this->container->getByType(LoggerDataExtractor::class);
	}


	public function testQueryExtraction()
	{
		$this->prepareDbSchema();

		$queries = $this->loggerDataExtractor->getLoggedQueries();
		Assert::count(1, $queries);

		$query = $queries[0];
		Assert::type(Query::class, $query);

		Assert::same(
			'CREATE TABLE product (id INTEGER NOT NULL, name string, PRIMARY KEY(id))',
			trim($query->getSqlWithParameters())
		);
	}


	private function prepareDbSchema()
	{
		/** @var Connection $connection */
		$connection = $this->container->getByType(Connection::class);
		$connection->query('CREATE TABLE product (id INTEGER NOT NULL, name string, PRIMARY KEY(id))');
	}

}


(new LoggerDataExtractorTest($container))->run();
