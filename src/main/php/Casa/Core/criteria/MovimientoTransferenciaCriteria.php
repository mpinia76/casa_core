<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de MovimientoTransferencia
 *
 *  @author Marcos
 * @since 02-08-2018
 */
class MovimientoTransferenciaCriteria extends MovimientoCuentaCriteria{

	private $transferencia;



	public function getTransferencia()
	{
	    return $this->transferencia;
	}

	public function setTransferencia($transferencia)
	{
	    $this->transferencia = $transferencia;
	}
}
