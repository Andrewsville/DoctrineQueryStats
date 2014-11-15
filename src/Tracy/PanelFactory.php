<?php

/**
 * This file is part of Lekarna
 * Copyright (c) 2014 Pears Health Cyber, s.r.o. (http://pearshealthcyber.cz)
 */

namespace Lekarna\DoctrineQueryStats\Tracy;

use Nette;


interface PanelFactory
{

	/**
	 * @return Panel
	 */
	function create();

}
