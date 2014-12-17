<?php

namespace Zenify\DoctrineQueryStats\Tests;

use Doctrine\DBAL\Connection;


class DatabaseLoader
{

	/**
	 * @var Connection
	 */
	private $connection;

	/**
	 * @var bool
	 */
	private $isDbSchemaPrepared;


	public function __construct(Connection $connection)
	{
		$this->connection = $connection;
	}


	public function prepareProductTable()
	{
		if ( ! $this->isDbSchemaPrepared) {
			$this->connection->query('CREATE TABLE product (id INTEGER NOT NULL, name string, PRIMARY KEY(id))');
			$this->isDbSchemaPrepared = TRUE;
		}
	}

}
