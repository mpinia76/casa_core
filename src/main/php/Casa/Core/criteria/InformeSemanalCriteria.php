<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de InformeSemanal
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class InformeSemanalCriteria extends Criteria{

	private $mes;

	private $anio;

	public function getMes()
	{
	    return $this->mes;
	}

	public function setMes($mes)
	{
	    $this->mes = $mes;
	}

	public function getAnio()
	{
	    return $this->anio;
	}

	public function setAnio($anio)
	{
	    $this->anio = $anio;
	}
}
