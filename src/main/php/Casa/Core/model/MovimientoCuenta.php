<?php

namespace Casa\Core\model;

use Cose\model\impl\Entity;

use Cose\utils\Logger;

/**
 * Movimiento de cuenta
 *
 * @Entity @Table(name="casa_movimiento_cuenta")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"pago" = "MovimientoPago",
 * 					  "gasto" = "MovimientoGasto",
 * 					  "transferencia" = "MovimientoTransferencia"})
 *
 *  @author Marcos
 * @since 02-08-2018
 */

abstract class MovimientoCuenta extends Entity{

	//variables de instancia.

	/**
     * @ManyToOne(targetEntity="Cuenta",cascade={"persist"})
     * @JoinColumn(name="cuenta_oid", referencedColumnName="oid")
     * @var Cuenta
     **/
	private $cuenta;

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fechaHora;


	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $haber;


	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $debe;


	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $saldo;


	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $observaciones;

	/**
     * @ManyToOne(targetEntity="ConceptoMovimiento",cascade={"merge"})
     * @JoinColumn(name="concepto_oid", referencedColumnName="oid")
     * @var ConceptoMovimiento
     **/
	private $concepto;

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
		 return $this->getNombre();
	}


	public function getFechaHora()
	{
	    return $this->fechaHora;
	}

	public function setFechaHora($fechaHora)
	{
	    $this->fechaHora = $fechaHora;
	}

	public function getHaber()
	{
	    return $this->haber;
	}

	public function setHaber($haber)
	{
	    $this->haber = $haber;
	}

	public function getDebe()
	{
	    return $this->debe;
	}

	public function setDebe($debe)
	{
	    $this->debe = $debe;
	}

	public function getSaldo()
	{
	    return $this->saldo;
	}

	public function setSaldo($saldo)
	{
	    $this->saldo = $saldo;
	}

	public function getObservaciones()
	{
	    return $this->observaciones;
	}

	public function setObservaciones($observaciones)
	{
	    $this->observaciones = $observaciones;
	}

	public function getConcepto()
	{
	    return $this->concepto;
	}

	public function setConcepto($concepto)
	{
	    $this->concepto = $concepto;
	}

	public function getUser()
	{
	    return $this->user;
	}

	public function setUser($user)
	{
	    $this->user = $user;
	}

	public function getCuenta()
	{
	    return $this->cuenta;
	}

	public function setCuenta($cuenta)
	{
	    $this->cuenta = $cuenta;
	}

	public function getMonto(){

		if( $this->getDebe() > 0 )
			return $this->getDebe();
		else
			return $this->getHaber();

	}

	public function getDescripcion(){

		return $this->getConcepto()->__toString();

	}

	public function buildContramovimiento(){

		$movimiento = $this->buildInstance();
		$movimiento->setCuenta( $this->getCuenta() );
		$movimiento->setFechaHora( new \Datetime() );
		$movimiento->setDebe( $this->getHaber() );
		$movimiento->setHaber( $this->getDebe() );
		//$movimiento->setCaja( $this->getCaja() );

		return $movimiento;

	}

	protected abstract function buildInstance();


	public function podesAnularte(){

		return true;

	}


}
?>
