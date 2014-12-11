<?php

namespace ZenifyTests\DoctrineQueryStats;

use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\LoggerDataExtractor;
use Zenify\DoctrineQueryStats\Analytics\Query;
use ZenifyTests\ContainerFactory;
use ZenifyTests\DatabaseLoader;


class LoggerDataExtractorTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var LoggerDataExtractor
	 */
	private $loggerDataExtractor;


	protected function setUp()
	{
		$container = (new ContainerFactory())->create();
		$this->loggerDataExtractor = $container->getByType(LoggerDataExtractor::class);

		/** @var DatabaseLoader  $databaseLoader */
		$databaseLoader = $container->getByType(DatabaseLoader::class);
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
