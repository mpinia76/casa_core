<?php

namespace Casa\Core\model;

use Cose\utils\Logger;

/**
 * Movimiento de cuenta por pago
 *
 * @Entity
 *
*  @author Marcos
 * @since 02-08-2018
 */

class MovimientoPago extends MovimientoCuenta{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Pago",cascade={"merge"})
     * @JoinColumn(name="pago_oid", referencedColumnName="oid", nullable=true)
     * @var Pago
     **/
	private $pago;


	public function __construct(){
	}


	public function getDescripcion(){

		$descripcion = parent::getDescripcion();

		$cliente = $this->getPago()->getCliente();

		$observaciones = $this->getObservaciones();

		return parent::getDescripcion() . " / " . $cliente . " " .  (!empty($observaciones)?" / $observaciones" :"");

	}
	public function __toString(){
		 return "oid de pago";
	}


	public function getPago()
	{
	    return $this->pago;
	}

	public function setPago($pago)
	{
	    $this->pago = $pago;
	}

	protected function buildInstance(){
		return new MovimientoPago();
	}

	public function buildContramovimiento(){

		$movimiento = parent::buildContramovimiento();
		$movimiento->setPago( $this->getPago() );

		return $movimiento;
	}


}
?>
