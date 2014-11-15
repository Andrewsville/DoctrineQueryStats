<?php

/**
 * This file is part of Lekarna
 * Copyright (c) 2014 Pears Health Cyber, s.r.o. (http://pearshealthcyber.cz)
 */

namespace Lekarna\DoctrineQueryStats\Tracy;

use Lekarna\DoctrineQueryStats\Analytics\DataCollector;
use Nette;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\ApplicationLatte\Template;
use Tracy\IBarPanel;


class Panel extends Nette\Object implements IBarPanel
{

	/**
	 * @var ILatteFactory
	 */
	private $latteFactory;

	/**
	 * @var DataCollector
	 */
	private $dataCollector;


	public function __construct(ILatteFactory $latteFactory, DataCollector $dataCollector)
	{
		$this->latteFactory = $latteFactory;
		$this->dataCollector = $dataCollector;
	}


	/**
	 * @return string
	 */
	public function getTab()
	{
		$template = new Template($this->latteFactory->create());
		$template->setFile(__DIR__ . '/templates/tab.latte');
		return $template;
	}


	/**
	 * @return string
	 */
	public function getPanel()
	{
		/** @var Template|\stdClass $template */
		$template = new Template($this->latteFactory->create());
		$template->setFile(__DIR__ . '/templates/panel.latte');
		$template->setParameters([
			'dataCollector' => $this->dataCollector
		]);
		return $template;
	}

}
