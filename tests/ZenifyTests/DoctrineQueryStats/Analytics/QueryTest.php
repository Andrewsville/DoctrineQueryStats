<?php

namespace ZenifyTests\DoctrineQueryStats;

use PHPUnit_Framework_TestCase;
use Zenify\DoctrineQueryStats\Analytics\Query;


class QueryTest extends PHPUnit_Framework_TestCase
{

	const SQL = 'SELECT * FROM product WHERE id = ?';
	const PARAMETER = 25;

	/**
	 * @var Query
	 */
	private $query;


	protected function setUp()
	{
		$this->query = new Query(self::SQL, [self::PARAMETER], ['integer']);
	}


	public function testSql()
	{
		$this->assertSame(self::SQL, $this->query->getSql());
	}


	public function testSqlWithParameters()
	{
		$this->assertSame(
			'SELECT * FROM product WHERE id = 25',
			$this->query->getSqlWithParameters()
		);
	}


	public function testSqlHash()
	{
		$this->assertSame(sha1(self::SQL), $this->query->getSqlHash());
	}


	public function testSqlAndParametersHash()
	{
		$this->assertSame(
			sha1(self::SQL) . ':' . sha1(serialize([self::PARAMETER])),
			$this->query->getSqlAndParametersHash()
		);
	}


	public function testSqlWithParametersHighlighted()
	{
		$this->assertContains(
			'<pre class="dump"><strong style="color:blue">SELECT</strong> *',
			$this->query->getSqlWithParametersHighlighted()
		);
	}

}
