<?php
namespace Casa\Core\criteria;

use Cose\criteria\impl\Criteria;

/**
 * criteria de persona
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class PersonaCriteria extends Criteria{

	private $nombre;

	private $apellido;

	private $nombreApellido;

	private $oidNotEqual;

	private $nroDocumento;

	private $tipoDocumento;

	private $nombreEqual;

	private $apellidoEqual;


	public function getNombre()
	{
	    return $this->nombre;
	}

	public function setNombre($nombre)
	{
	    $this->nombre = $nombre;
	}

	public function getApellido()
	{
	    return $this->apellido;
	}

	public function setApellido($apellido)
	{
	    $this->apellido = $apellido;
	}

	public function getNombreApellido()
	{
	    return $this->nombreApellido;
	}

	public function setNombreApellido($nombreApellido)
	{
	    $this->nombreApellido = $nombreApellido;
	}

	public function getOidNotEqual()
	{
	    return $this->oidNotEqual;
	}

	public function setOidNotEqual($oidNotEqual)
	{
	    $this->oidNotEqual = $oidNotEqual;
	}

	public function getNroDocumento()
	{
	    return $this->nroDocumento;
	}

	public function setNroDocumento($nroDocumento)
	{
	    $this->nroDocumento = $nroDocumento;
	}

	public function getTipoDocumento()
	{
	    return $this->tipoDocumento;
	}

	public function setTipoDocumento($tipoDocumento)
	{
	    $this->tipoDocumento = $tipoDocumento;
	}

	public function getNombreEqual()
	{
	    return $this->nombreEqual;
	}

	public function setNombreEqual($nombreEqual)
	{
	    $this->nombreEqual = $nombreEqual;
	}

	public function getApellidoEqual()
	{
	    return $this->apellidoEqual;
	}

	public function setApellidoEqual($apellidoEqual)
	{
	    $this->apellidoEqual = $apellidoEqual;
	}
}
