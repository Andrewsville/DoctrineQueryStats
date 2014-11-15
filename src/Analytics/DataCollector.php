<?php

/**
 * This file is part of Lekarna
 * Copyright (c) 2014 Pears Health Cyber, s.r.o. (http://pearshealthcyber.cz)
 */

namespace Lekarna\DoctrineQueryStats\Analytics;

use Nette;


class DataCollector extends Nette\Object
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
	private $areQueriesLoaded = FALSE;


	public function __construct(LoggerDataExtractor $loggerDataExtractor, QueryAnalyzer $queryAnalyzer)
	{
		$this->loggerDataExtractor = $loggerDataExtractor;
		$this->queryAnalyzer = $queryAnalyzer;
	}


	private function sortQueries()
	{
		if ($this->areQueriesLoaded === FALSE) {
			foreach ($this->loggerDataExtractor->getLoggedQueries() as $query) {
				$this->queryAnalyzer->addQuery($query);
			}
			$this->areQueriesLoaded = TRUE;
		}
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


	/**
	 * @return int
	 */
	private function countGroupedQueries(array $queries)
	{
		return array_sum(array_map('count', $queries));
	}

}
