<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de MovimientoPago
 *
 *  @author Marcos
 * @since 02-08-2018
 */
class MovimientoPagoCriteria extends MovimientoCuentaCriteria{

	private $pago;



	public function getPago()
	{
	    return $this->pago;
	}

	public function setPago($pago)
	{
	    $this->pago = $pago;
	}
}
