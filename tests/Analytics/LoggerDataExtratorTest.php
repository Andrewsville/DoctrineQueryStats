<?php

namespace Zenify\DoctrineQueryStats\Tests\Analytics;

use Nette\DI\Container;
use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\LoggerDataExtractor;
use Zenify\DoctrineQueryStats\Analytics\Query;
use Zenify\DoctrineQueryStats\Tests\ContainerFactory;
use Zenify\DoctrineQueryStats\Tests\DatabaseLoader;


class LoggerDataExtractorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var LoggerDataExtractor
	 */
	private $loggerDataExtractor;


	public function __construct()
	{
		$this->container = (new ContainerFactory)->create();
	}


	protected function setUp()
	{
		$this->loggerDataExtractor = $this->container->getByType(LoggerDataExtractor::class);

		/** @var DatabaseLoader $databaseLoader */
		$databaseLoader = $this->container->getByType(DatabaseLoader::class);
		$databaseLoader->prepareProductTable();
	}


	public function testQueryExtraction()
	{
		$queries = $this->loggerDataExtractor->getLoggedQueries();
		$this->assertCount(1, $queries);

		$query = $queries[0];
		$this->assertInstanceOf(Query::class, $query);

		$this->assertSame(
			'CREATE TABLE product (id INTEGER NOT NULL, name string, PRIMARY KEY(id))',
			trim($query->getSqlWithParameters())
		);
	}

}
