<?php

namespace ZenifyTests\DoctrineQueryStats;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;
use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Zenify\DoctrineQueryStats\Analytics\Query;


require_once __DIR__ . '/../../bootstrap.php';


class QueryTest extends TestCase
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
		Assert::same(self::SQL, $this->query->getSql());
	}


	public function testSqlWithParameters()
	{
		Assert::same(
			'SELECT * FROM product WHERE id = 25',
			$this->query->getSqlWithParameters()
		);
	}


	public function testSqlHash()
	{
		Assert::same(sha1(self::SQL), $this->query->getSqlHash());
	}


	public function testSqlAndParametersHash()
	{
		Assert::same(
			sha1(self::SQL) . ':' . sha1(serialize([self::PARAMETER])),
			$this->query->getSqlAndParametersHash()
		);
	}


	public function testSqlWithParametersHighlighted()
	{
		Assert::contains(
			'<pre class="dump"><strong style="color:blue">SELECT</strong> *',
			$this->query->getSqlWithParametersHighlighted()
		);
	}

}


(new QueryTest)->run();
