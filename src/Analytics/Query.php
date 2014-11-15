<?php

/**
 * This file is part of Lekarna
 * Copyright (c) 2014 Pears Health Cyber, s.r.o. (http://pearshealthcyber.cz)
 */

namespace Lekarna\DoctrineQueryStats\Analytics;

use Kdyby\Doctrine\Diagnostics\Panel;
use Nette;


/**
 * @method string   getSql()
 * @method array    getParameters()
 * @method int      getSisterQueriesCount()
 * @method array    setSisterQueriesCount()
 */
class Query extends Nette\Object
{

	/**
	 * @var string
	 */
	private $sql;

	/**
	 * @var array
	 */
	private $parameters;

	/**
	 * @var array
	 */
	private $types;

	/**
	 * Count of similar/same queries to this one.
	 *
	 * @var int
	 */
	private $sisterQueriesCount;


	/**
	 * @param string $sql
	 * @param array $parameters
	 * @param array $types
	 */
	public function __construct($sql, $parameters = [], $types = [])
	{
		$this->sql = $sql;
		$this->parameters = $parameters ?: [];
		$this->types = $types ?: [];
	}


	/**
	 * @return string
	 */
	public function getSqlHash()
	{
		return sha1($this->sql);
	}


	/**
	 * @return string
	 */
	public function getSqlAndParametersHash()
	{
		$key = $this->getSqlHash();
		$key .= ':' . sha1(serialize($this->parameters));
		return $key;
	}


	/**
	 * @return string
	 */
	public function getSqlWithParameters()
	{
		return Panel::highlightQuery(
			Panel::formatQuery($this->sql, $this->parameters, $this->types)
		);
	}

}
