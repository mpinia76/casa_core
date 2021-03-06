<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de MovimientoGasto
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class MovimientoGastoCriteria extends MovimientoCuentaCriteria{

	private $gasto;



	public function getGasto()
	{
	    return $this->gasto;
	}

	public function setGasto($gasto)
	{
	    $this->gasto = $gasto;
	}
}
