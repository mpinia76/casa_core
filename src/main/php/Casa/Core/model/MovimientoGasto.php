<?php

namespace Casa\Core\model;

use Cose\utils\Logger;

/**
 * Movimiento de cuenta por gasto
 *
 * @Entity
 *
 *  @author Marcos
 * @since 02-08-2018
 */

class MovimientoGasto extends MovimientoCuenta{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Gasto",cascade={"merge"})
     * @JoinColumn(name="gasto_oid", referencedColumnName="oid", nullable=true)
     * @var Gasto
     **/
	private $gasto;


	public function __construct(){
	}

	public function __toString(){
		 return "oid de gasto";
	}


	public function getGasto()
	{
	    return $this->gasto;
	}

	public function setGasto($gasto)
	{
	    $this->gasto = $gasto;
	}

	public function getDescripcion(){

		return parent::getDescripcion() . " - " . $this->getGasto()->getConcepto()->__toString(). " - " . $this->getGasto()->getObservaciones();

	}

	protected function buildInstance(){
		return new MovimientoGasto();
	}

	public function buildContramovimiento(){

		$movimiento = parent::buildContramovimiento();
		$movimiento->setGasto( $this->getGasto() );

		return $movimiento;
	}

	public  function podesAnularte(){

		return $this->getGasto()->getEstado() != EstadoGasto::Anulado;

	}
}
?>
