<?php

namespace Zenify\DoctrineQueryStats\Tests\Entities;

use Doctrine\ORM\Mapping as ORM;
use Nette;


/**
 * @ORM\Entity
 *
 * @method  int     getId()
 * @method  string  getName()
 * @method  Product setName()
 */
class Product extends Nette\Object
{

	/**
	 * @ORM\Column(type="integer")
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 */
	public $id;

	/**
	 * @ORM\Column(type="string", nullable=TRUE)
	 * @var string
	 */
	protected $name;

}
