<?php

namespace Casa\Core\model;

use Casa\Core\utils\CasaUtils;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Transferencia
 *
 * Transferencia entre casa
 *
 * @Entity @Table(name="casa_transferencia")
 *
*  @author Marcos
 * @since 02-08-2018
 */

class Transferencia extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="datetime")
	 * @var \Datetime
	 */
	private $fechaHora;


	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $monto;

	/**
	 * @Column(type="integer")
	 * @var EstadoTransferencia
	 */
	private $estado;

	/**
	 * @Column(type="string", nullable=true)
	 * @var string
	 */
	private $observaciones;

	/**
     * @ManyToOne(targetEntity="Cuenta",cascade={"merge"})
     * @JoinColumn(name="origen_oid", referencedColumnName="oid")
     * @var Cuenta
     **/
	private $origen;

	/**
     * @ManyToOne(targetEntity="Cuenta",cascade={"merge"})
     * @JoinColumn(name="destino_oid", referencedColumnName="oid")
     * @var Cuenta
     **/
	private $destino;

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
		 return $this->getOrigen() . " -> " . $this->getDestino() . " : " . CasaUtils::formatMontoToView( $this->getMonto() );
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

	public function getOrigen()
	{
	    return $this->origen;
	}

	public function setOrigen($origen)
	{
	    $this->origen = $origen;
	}

	public function getDestino()
	{
	    return $this->destino;
	}

	public function setDestino($destino)
	{
	    $this->destino = $destino;
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
