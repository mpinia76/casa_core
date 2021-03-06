<?php

namespace Casa\Core\model;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Cuenta
 *
 * Representa una cuenta (caja, cuenta bancaria, cuenta corriente, etc)
 *
 * @Entity @Table(name="casa_cuenta")
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"caja" = "Caja", "caja_chica" = "CajaChica", "banco" = "Banco"})
 *
 *  @author Marcos
 * @since 02-08-2018
 */

abstract class Cuenta extends Entity{

	//variables de instancia.

	/**
	 * @Column(type="string")
	 * @var string
	 */
	private $numero;

	/**
	 * @Column(type="date")
	 * @var \DateTime
	 */
	private $fecha;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $saldoInicial;

	/**
	 * @Column(type="float")
	 * @var float
	 */
	private $saldo;

	public function __construct(){
	}

	public function __toString(){
		 return $this->getNumero();
	}



	public function getNumero()
	{
	    return $this->numero;
	}

	public function setNumero($numero)
	{
	    $this->numero = $numero;
	}

	public function getFecha()
	{
	    return $this->fecha;
	}

	public function setFecha($fecha)
	{
	    $this->fecha = $fecha;
	}

	public function getSaldoInicial()
	{
	    return $this->saldoInicial;
	}

	public function setSaldoInicial($saldoInicial)
	{
	    $this->saldoInicial = $saldoInicial;
	}

	public function getSaldo()
	{
	    return $this->saldo;
	}

	public function setSaldo($saldo)
	{
	    $this->saldo = $saldo;
	}
}
?>
