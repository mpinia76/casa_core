<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de banco
 *
 * @author Marcos
 * @since 02-08-2018
 *
 */
class BancoCriteria extends CuentaCriteria{

	private $nombre;


	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}
}
