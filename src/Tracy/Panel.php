<?php

/**
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace Zenify\DoctrineQueryStats\Tracy;

use Zenify\DoctrineQueryStats\Analytics\DataCollector;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\ApplicationLatte\Template;
use Tracy\IBarPanel;


class Panel implements IBarPanel
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
	 * @return Template|string
	 */
	public function getTab()
	{
		return $this->createTemplateWithFile(__DIR__ . '/templates/tab.latte');
	}


	/**
	 * @return Template|string
	 */
	public function getPanel()
	{
		$template = $this->createTemplateWithFile(__DIR__ . '/templates/panel.latte');
		$template->setParameters([
			'dataCollector' => $this->dataCollector
		]);
		return $template;
	}


	/**
	 * @param string $file
	 * @return Template
	 */
	private function createTemplateWithFile($file)
	{
		$template = new Template($this->latteFactory->create());
		$template->setFile($file);
		return $template;
	}

}
