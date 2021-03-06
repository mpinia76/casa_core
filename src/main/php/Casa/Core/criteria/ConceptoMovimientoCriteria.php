<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de ConceptoMovimiento
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class ConceptoMovimientoCriteria extends Criteria{

	private $nombre;

	private $oidNotEqual;


	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
	}
}
