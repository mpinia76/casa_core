<?php

namespace Casa\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * InformeSemanal
 *
 * Informe Semanal de la máquina de loterías
 *
 *
 * @Entity @Table(name="casa_informe_semanal")
 *
 *  @author Marcos
 * @since 02-08-2018
 */

class InformeSemanal extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="date")
	 * @var \Datetime
	 */
	private $fechaDesde;

	/**
	 * @Column(type="date")
	 * @var \Datetime
	 */
	private $fechaHasta;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $ventas;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $cancelaciones;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $pagos;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $pagoPorLoteria;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $comision;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $ajustes;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $deuda;



	/**
     * @ManyToOne(targetEntity="Cose\Security\model\User",cascade={"detach"})
     * @JoinColumn(name="user_oid", referencedColumnName="oid")
     *
     * usuario q generó la operación
     **/
    private $user;


	public function __construct(){
	}

	public function __toString(){
		 return "";
	}



	public function getFechaDesde()
	{
	    return $this->fechaDesde;
	}

	public function setFechaDesde($fechaDesde)
	{
	    $this->fechaDesde = $fechaDesde;
	}

	public function getFechaHasta()
	{
	    return $this->fechaHasta;
	}

	public function setFechaHasta($fechaHasta)
	{
	    $this->fechaHasta = $fechaHasta;
	}

	public function getVentas()
	{
	    return $this->ventas;
	}

	public function setVentas($ventas)
	{
	    $this->ventas = $ventas;
	}

	public function getCancelaciones()
	{
	    return $this->cancelaciones;
	}

	public function setCancelaciones($cancelaciones)
	{
	    $this->cancelaciones = $cancelaciones;
	}

	public function getPagos()
	{
	    return $this->pagos;
	}

	public function setPagos($pagos)
	{
	    $this->pagos = $pagos;
	}

	public function getPagoPorLoteria()
	{
	    return $this->pagoPorLoteria;
	}

	public function setPagoPorLoteria($pagoPorLoteria)
	{
	    $this->pagoPorLoteria = $pagoPorLoteria;
	}

	public function getComision()
	{
	    return $this->comision;
	}

	public function setComision($comision)
	{
	    $this->comision = $comision;
	}

	public function getAjustes()
	{
	    return $this->ajustes;
	}

	public function setAjustes($ajustes)
	{
	    $this->ajustes = $ajustes;
	}

	public function getDeuda()
	{
	    return $this->deuda;
	}

	public function setDeuda($deuda)
	{
	    $this->deuda = $deuda;
	}



	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}
}
?>
