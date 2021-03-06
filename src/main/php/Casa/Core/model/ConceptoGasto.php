<?php

namespace Casa\Core\model;

use Cose\model\impl\Entity;


use Cose\utils\Logger;

/**
 * Concepto de gasto
 *
 * @Entity @Table(name="casa_concepto_gasto")
 *
 *  @author Marcos
 * @since 02-08-2018
 */

class ConceptoGasto extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $nombre;

	public function __construct(){
	}

	public function __toString(){
		 return $this->getNombre();
	}


	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
}
?>
