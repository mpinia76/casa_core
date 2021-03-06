<?php

namespace Casa\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Gasto
 *
 * Le vamos a indicar una fecha de vencimiento para poder cargar
 * gastos "por pagar". Nos serviría, por ejemplo, para cargar una factura de
 * luz no bien llega y así tener un registro de las cosas a pagar con su fecha
 * de vencimiento.
 * Cuando se carga un gasto se crea en estado "Impago". Luego, se elije pagar
 * el gasto con una de las casa disponibles (Caja, Banco, Cta Cte, etc).
 *
 *
 * @Entity @Table(name="casa_gasto")
 *
 *  @author Marcos
 * @since 02-08-2018
 */

class Gasto extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fechaHora;


	/**
	 * @Column(type="datetime", nullable=true)
	 * @var \Datetime
	 */
	private $fechaVencimiento;


	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $monto;

	/**
	 * @Column(type="integer")
	 * @var EstadoGasto
	 */
	private $estado;

	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $observaciones;



	/**
     * @ManyToOne(targetEntity="Cose\Security\model\User",cascade={"detach"})
     * @JoinColumn(name="user_oid", referencedColumnName="oid")
     *
     * usuario q generó la operación
     **/
    private $user;

    /**
     * @ManyToOne(targetEntity="ConceptoGasto",cascade={"merge"})
     * @JoinColumn(name="concepto_oid", referencedColumnName="oid")
     * @var ConceptoGasto
     **/
	private $concepto;


	public function __construct(){
	}

	public function __toString(){
		 return "";
	}



	public function getFechaHora()
	{
	    return $this->fechaHora;
	}

	public function setFechaHora($fechaHora)
	{
	    $this->fechaHora = $fechaHora;
	}


	public function getMonto()
	{
	    return $this->monto;
	}

	public function setMonto($monto)
	{
	    $this->monto = $monto;
	}

	public function getEstado()
	{
	    return $this->estado;
	}

	public function setEstado($estado)
	{
	    $this->estado = $estado;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}



	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}

	public function getConcepto()
	{
	    return $this->concepto;
	}

	public function setConcepto($concepto)
	{
	    $this->concepto = $concepto;
	}

	public function getFechaVencimiento()
	{
	    return $this->fechaVencimiento;
	}

	public function setFechaVencimiento($fechaVencimiento)
	{
	    $this->fechaVencimiento = $fechaVencimiento;
	}

	public  function podesAnularte(){

		return $this->getEstado() != EstadoGasto::Anulado;

	}

	public  function podesPagarte(){

		return $this->getEstado() != EstadoGasto::Anulado && ($this->getEstado() != EstadoGasto::Pagado);

	}
}
?>
