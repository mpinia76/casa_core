<?php
namespace Casa\Core\service\impl;


use Casa\Core\service\IConceptoMovimientoService;

use Casa\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

/**
 * servicio para ConceptoMovimiento
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class ConceptoMovimientoServiceImpl extends CrudService implements IConceptoMovimientoService {


	protected function getDAO(){
		return DAOFactory::getConceptoMovimientoDAO();
	}


	function validateOnAdd( $entity ){

		//que tenga nombre
		$nombre = $entity->getNombre();
		if( empty($nombre) )
			throw new ServiceException("conceptoMovimiento.nombre.required");

		//unicidad (nombre )

	}


	function validateOnUpdate( $entity ){

		$this->validateOnAdd($entity);
	}

	function validateOnDelete( $oid ){}


}
