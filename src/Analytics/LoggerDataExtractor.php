<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineQueryStats\Analytics;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Logging\LoggerChain;
use Doctrine\DBAL\Logging\SQLLogger;
use Kdyby\Doctrine\Diagnostics\Panel;
use ReflectionClass;


class LoggerDataExtractor
{

	/**
	 * @var SQLLogger|LoggerChain
	 */
	private $sqlLogger;


	public function __construct(Connection $connection)
	{
		$this->sqlLogger = $connection->getConfiguration()->getSQLLogger();
	}


	/**
	 * @return Query[]
	 */
	public function getLoggedQueries()
	{
		if ($this->sqlLogger instanceof LoggerChain) {
			return $this->getQueriesFromLoggerChain($this->sqlLogger);

		} else {
			return $this->getQueriesFromLogger($this->sqlLogger);
		}
	}


	/**
	 * @param LoggerChain $sqlLogger
	 * @return array
	 */
	private function getQueriesFromLoggerChain(LoggerChain $sqlLogger)
	{
		$loggers = $this->getPrivatePropertyFromObject($sqlLogger, 'loggers');
		$queries = [];
		foreach ($loggers as $logger) {
			$queries = array_merge($queries, $this->getQueriesFromLogger($logger));
		}
		return $queries;
	}


	/**
	 * @param $logger
	 * @return array
	 */
	private function getQueriesFromLogger($logger)
	{
		if ($logger instanceof Panel) {
			return $this->formatKdybyPanelQueries($logger->queries);
		}
		return [];
	}


	/**
	 * @return Query[]
	 */
	private function formatKdybyPanelQueries(array $queries)
	{
		$formattedQueries = [];
		foreach ($queries as $query) {
			$parameters = $query[1] ?: [];
			$types = $query[3] ?: [];
			$formattedQueries[] = $query = new Query($query[0], $parameters, $types);
		}
		return $formattedQueries;
	}


	/**
	 * @param object $object
	 * @param string $property
	 * @return mixed
	 */
	private function getPrivatePropertyFromObject($object, $property)
	{
		$reflectionClass = new ReflectionClass($object);
		$propertyReflection = $reflectionClass->getProperty($property);
		$propertyReflection->setAccessible(TRUE);
		return $propertyReflection->getValue($object);
	}

}
