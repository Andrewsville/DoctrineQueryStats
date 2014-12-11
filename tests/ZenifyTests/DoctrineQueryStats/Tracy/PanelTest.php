<?php

namespace ZenifyTests\DoctrineQueryStats\Tracy;

use Nette;
use Nette\Bridges\ApplicationLatte\Template;
use PHPUnit_Framework_TestCase;
use Tracy\IBarPanel;
use Zenify\DoctrineQueryStats\Tracy\Panel;
use ZenifyTests\ContainerFactory;


class PanelTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Panel
	 */
	private $panel;


	protected function setUp()
	{
		$container = (new ContainerFactory())->create();
		$this->panel = $container->getByType(Panel::class);
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
