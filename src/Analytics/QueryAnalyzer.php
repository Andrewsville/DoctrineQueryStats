<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineQueryStats\Analytics;


class QueryAnalyzer
{

	/**
	 * @var Query[]
	 */
	private $queries = [];

	/**
	 * @var Query[]
	 */
	private $similarQueries;

	/**
	 * @var Query[]
	 */
	private $identicalQueries;


	public function addQuery(Query $query)
	{
		$this->queries[] = $query;
	}


	/**
	 * @return Query[]
	 */
	public function getQueries()
	{
		return $this->queries;
	}


	/**
	 * @return Query[]
	 */
	public function getIdenticalQueries()
	{
		if ($this->identicalQueries === NULL) {
			$groupedQueries = [];
			foreach ($this->queries as $query) {
				$groupedQueries[$query->getSqlAndParametersHash()][] = $query;
			}
			$this->identicalQueries = $this->filterIndistinctQueries($groupedQueries);
		}
		return $this->identicalQueries;
	}


	/**
	 * @return Query[]
	 */
	public function getSimilarQueries()
	{
		if ($this->similarQueries === NULL) {
			$groupedQueries = [];
			foreach ($this->queries as $query) {
				$groupedQueries[$query->getSqlHash()][] = $query;
			}
			$this->identicalQueries = $this->filterIndistinctQueries($groupedQueries);
		}
		return $this->identicalQueries;
	}


	/**
	 * @param Query[][] $allQueries
	 * @return Query[]
	 */
	private function filterIndistinctQueries(array $allQueries)
	{
		$indistinctQueries = [];
		foreach ($allQueries as $queryKey => $queries) {
			$queryCount = count($queries);
			if ($queryCount > 1) {
				$query = array_pop($queries);
				$query->setSisterQueriesCount($queryCount);
				$indistinctQueries[$queryKey] = $query;
			}
		}
		return $indistinctQueries;
	}

}
