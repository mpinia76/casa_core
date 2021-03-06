<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de caja chica
 *
 * @author Marcos
 * @since 02-08-2018
 *
 */
class CajaCriteria extends CuentaCriteria{

	private $oidNotEqual;

	private $numero;

	private $fecha;

	private $fechaDesde;

	private $fechaHasta;

	private $sucursal;


	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
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

	public function getSucursal()
	{
	    return $this->sucursal;
	}

	public function setSucursal($sucursal)
	{
	    $this->sucursal = $sucursal;
	}
}
