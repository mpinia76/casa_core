<?php
namespace Casa\Core\service\impl;


use Casa\Core\criteria\MovimientoTransferenciaCriteria;

use Casa\Core\model\EstadoTransferencia;

use Casa\Core\service\ITransferenciaService;

use Casa\Core\model\Transferencia;

use Casa\Core\service\ServiceFactory;

use Casa\Core\model\MovimientoTransferencia;

use Casa\Core\utils\CasaUtils;

use Casa\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

use Cose\Security\model\User;

/**
 * servicio para transferencia
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class TransferenciaServiceImpl extends CrudService implements ITransferenciaService {


	protected function getDAO(){
		return DAOFactory::getTransferenciaDAO();
	}

	function add( $entity ){

		$entity->setEstado( EstadoTransferencia::Realizada );

		parent::add( $entity );

		if ($entity->getOrigen()) {
			//generamos un movimiento debe en la cuenta origen.
			$movimiento = new MovimientoTransferencia();
			$movimiento->setFechaHora( $entity->getFechaHora() );
			$movimiento->setDebe($entity->getMonto() );
			$movimiento->setHaber( 0 );
			$movimiento->setObservaciones( $entity->getObservaciones() );
			$movimiento->setTransferencia($entity);
			$movimiento->setCuenta($entity->getOrigen());
			$movimiento->setConcepto( CasaUtils::getConceptoMovimientoTransferencia() );
			$movimiento->setUser( $entity->getUser() );
			ServiceFactory::getMovimientoTransferenciaService()->add( $movimiento );
		}


		//generamos un movimiento haber en la cuenta destino.
		$movimiento = new MovimientoTransferencia();
		$movimiento->setFechaHora( $entity->getFechaHora() );
		$movimiento->setDebe( 0 );
		$movimiento->setHaber( $entity->getMonto() );
		$movimiento->setObservaciones($entity->getObservaciones());
		$movimiento->setTransferencia($entity);
		$movimiento->setCuenta($entity->getDestino());
		$movimiento->setConcepto( CasaUtils::getConceptoMovimientoTransferencia() );
		$movimiento->setUser( $entity->getUser() );
		ServiceFactory::getMovimientoTransferenciaService()->add( $movimiento );

	}

	function validateOnAdd( $entity ){

		//TODO que tenga origen, destino y monto

	}


	function validateOnUpdate( $entity ){

		$this->validateOnAdd($entity);
	}

	function validateOnDelete( $oid ){}

	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Casa/Core/service/Casa\Core\service.ITransferenciaService::anular()
	 */
	public function anular(Transferencia $transferencia, User $user){


		//validamos si se puede
		$this->validateOnAnular($transferencia);


		//generar contramovimiento para cuenta origen.

		//hay que buscar el movimiento de cuenta realizado para la cuenta origen
		//de la transferencia
		$criteria = new MovimientoTransferenciaCriteria();
		$criteria->setTransferencia($transferencia);
		$criteria->setCuenta($transferencia->getOrigen());
		$movimiento = ServiceFactory::getMovimientoTransferenciaService()->getSingleResult( $criteria );

		$contramovimiento = $movimiento->buildContramovimiento();
		$contramovimiento->setConcepto( CasaUtils::getConceptoMovimientoAnulacionTransferencia() );
		$contramovimiento->setUser($user);

		ServiceFactory::getMovimientoTransferenciaService()->add( $contramovimiento );

		//generar contramovimiento para cuenta destino.

		//hay que buscar el movimiento de cuenta realizado para la cuenta origen
		//de la transferencia
		$criteria = new MovimientoTransferenciaCriteria();
		$criteria->setTransferencia($transferencia);
		$criteria->setCuenta($transferencia->getDestino());
		$movimiento = ServiceFactory::getMovimientoTransferenciaService()->getSingleResult( $criteria );

		$contramovimiento = $movimiento->buildContramovimiento();
		$contramovimiento->setConcepto( CasaUtils::getConceptoMovimientoAnulacionTransferencia() );
		$contramovimiento->setUser($user);

		ServiceFactory::getMovimientoTransferenciaService()->add( $contramovimiento );



		//modificamos el estado de la transferencia
		$transferencia->setEstado(EstadoTransferencia::Anulada);

		//persistimos los cambios.
		try {

			$this->getDAO()->update( $transferencia );

		} catch (DAOException $e){

			throw new ServiceException( $e->getMessage() );

		} catch (\Exception $e) {

			throw new ServiceException( $e->getMessage() );

		}

	}

}
