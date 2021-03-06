<?php

namespace Casa\Core\model;

use Casa\Core\utils\CasaUtils;

use Cose\model\impl\Entity;

use Cose\Security\model\User;

use Cose\utils\Logger;

/**
 * Caja
 *
 * @Entity @Table(name="casa_caja")
 *
 *  @author Marcos
 * @since 02-08-2018
 */

class Caja extends Cuenta{

	//variables de instancia.

	/**
	 * @Column(type="time")
	 * @var \Datetime
	 */
	private $horaApertura;

	/**
	 * @Column(type="time", nullable=true)
	 * @var \Datetime
	 */
	private $horaCierre;







	public function __construct(){
	}

	public function __toString(){
		 return  "Caja " . $this->getNumero();// . " - " .CasaUtils::formatDateToView($this->getFecha());// . " - " .CasaUtils::formatTimeToView($this->getHoraApertura()) . " - " .CasaUtils::formatMontoToView($this->getSaldo()) ;
	}


	protected function doEncrypt(){

//		if( $this->getCajero() != null )
//			$this->getCajero()->doEncrypt();

	}

	protected function doDecrypt(){

//		if( $this->getCajero() != null )
//			$this->getCajero()->doDecrypt();
	}


	public function getHoraApertura()
	{
	    return $this->horaApertura;
	}

	public function setHoraApertura($horaApertura)
	{
	    $this->horaApertura = $horaApertura;
	}

	public function getHoraCierre()
	{
	    return $this->horaCierre;
	}

	public function setHoraCierre($horaCierre)
	{
	    $this->horaCierre = $horaCierre;
	}



    public function isAbierta(){
    	return empty($this->horaCierre);
    }

    public function getRecaudacion(){

    	return $this->getSaldo() - $this->getSaldoInicial();
    }

}
?>
