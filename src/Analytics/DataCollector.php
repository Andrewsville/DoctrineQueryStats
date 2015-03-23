<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineQueryStats\Analytics;


class DataCollector
{

	/**
	 * @var LoggerDataExtractor
	 */
	private $loggerDataExtractor;

	/**
	 * @var QueryAnalyzer
	 */
	private $queryAnalyzer;

	/**
	 * @var bool
	 */
	private $queriesCollected = FALSE;


	public function __construct(LoggerDataExtractor $loggerDataExtractor, QueryAnalyzer $queryAnalyzer)
	{
		$this->loggerDataExtractor = $loggerDataExtractor;
		$this->queryAnalyzer = $queryAnalyzer;
	}


	/**
	 * @return Query[]
	 */
	public function getIdenticalQueries()
	{
		$this->sortQueries();
		return $this->queryAnalyzer->getIdenticalQueries();
	}


	/**
	 * @return Query[]
	 */
	public function getSimilarQueries()
	{
		$this->sortQueries();
		return $this->queryAnalyzer->getSimilarQueries();
	}


	/**
	 * @return int
	 */
	public function getQueriesCount()
	{
		$this->sortQueries();
		return $this->countGroupedQueries($this->queryAnalyzer->getQueries());
	}


	/**
	 * @return int
	 */
	public function getIdenticalQueriesCount()
	{
		return $this->countGroupedQueries($this->getIdenticalQueries());
	}


	/**
	 * @return int
	 */
	public function getSimilarQueriesCount()
	{
		return $this->countGroupedQueries($this->getSimilarQueries());
	}


	private function sortQueries()
	{
		if ($this->queriesCollected === FALSE) {
			foreach ($this->loggerDataExtractor->getLoggedQueries() as $query) {
				$this->queryAnalyzer->addQuery($query);
			}

			$this->queriesCollected = TRUE;
		}
	}


	/**
	 * @return int
	 */
	private function countGroupedQueries(array $queries)
	{
		return array_sum(array_map('count', $queries));
	}

}
