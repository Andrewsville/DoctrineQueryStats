<?php

namespace Zenify\DoctrineQueryStats\Tests\Tracy;

use Nette;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\DI\Container;
use PHPUnit_Framework_TestCase;
use Tracy\IBarPanel;
use Zenify\DoctrineQueryStats\Tests\ContainerFactory;
use Zenify\DoctrineQueryStats\Tracy\Panel;


class PanelTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Panel
	 */
	private $panel;

	/**
	 * @var Container
	 */
	private $container;


	public function __construct()
	{
		$this->container = (new ContainerFactory)->create();
	}


	protected function setUp()
	{
		$this->panel = $this->container->getByType(Panel::class);
	}


	public function testInstance()
	{
		$this->assertInstanceOf(Panel::class, $this->panel);
		$this->assertInstanceOf(IBarPanel::class, $this->panel);
	}


	public function testPanelAndTab()
	{
		$this->assertInstanceOf(Template::class, $this->panel->getPanel());
		$this->assertInstanceOf(Template::class, $this->panel->getTab());
	}

}
