<?php

namespace ZenifyTests\DoctrineQueryStats\Tracy;

use Nette;
use Nette\Bridges\ApplicationLatte\Template;
use Nette\DI\Container;
use Tester\Assert;
use Tester\TestCase;
use Tracy\IBarPanel;
use Zenify\DoctrineQueryStats\Tracy\Panel;


$container = require_once __DIR__ . '/../../bootstrap.php';


class PanelTest extends TestCase
{

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var Panel
	 */
	private $panel;


	public function __construct(Container $container)
	{
		$this->container = $container;
	}


	protected function setUp()
	{
		$this->panel = $this->container->getByType(Panel::class);
	}


	public function testInstance()
	{
		Assert::type(Panel::class, $this->panel);
		Assert::type(IBarPanel::class, $this->panel);
	}


	public function testPanelAndTab()
	{
		Assert::type(Template::class, $this->panel->getPanel());
		Assert::type(Template::class, $this->panel->getTab());
	}

}


(new PanelTest($container))->run();
