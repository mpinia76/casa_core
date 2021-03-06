<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de gasto
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class GastoCriteria extends Criteria{

	private $fecha;

	private $fechaDesde;

	private $fechaHasta;

	private $concepto;

	private $fechaVencimientoHasta;

	private $estadoNotEqual;

	private $estado;

	private $observaciones;

	private $estadosIn;

	private $estadosNotIn;


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

	public function getConcepto()
	{
	    return $this->concepto;
	}

	public function setConcepto($concepto)
	{
	    $this->concepto = $concepto;
	}

    public function getFechaVencimientoHasta()
    {
        return $this->fechaVencimientoHasta;
    }

    public function setFechaVencimientoHasta($fechaVencimientoHasta)
    {
        $this->fechaVencimientoHasta = $fechaVencimientoHasta;
    }

    public function getEstadoNotEqual()
    {
        return $this->estadoNotEqual;
    }

    public function setEstadoNotEqual($estadoNotEqual)
    {
        $this->estadoNotEqual = $estadoNotEqual;
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

	public function getEstadosIn()
	{
	    return $this->estadosIn;
	}

	public function setEstadosIn($estadosIn)
	{
	    $this->estadosIn = $estadosIn;
	}

	public function getEstadosNotIn()
	{
	    return $this->estadosNotIn;
	}

	public function setEstadosNotIn($estadosNotIn)
	{
	    $this->estadosNotIn = $estadosNotIn;
	}
}
