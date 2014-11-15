<?php

/**
 * This file is part of Lekarna
 * Copyright (c) 2014 Pears Health Cyber, s.r.o. (http://pearshealthcyber.cz)
 */

namespace Lekarna\DoctrineQueryStats\Analytics;

use Nette;


/**
 * @method Query[] getQueries()
 */
class QueryAnalyzer extends Nette\Object
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
			if (count($queries) > 1) {
				$queries[0]->setSisterQueriesCount(count($queries));
				$indistinctQueries[$queryKey] = $queries[0];
			}
		}
		return $indistinctQueries;
	}

}
