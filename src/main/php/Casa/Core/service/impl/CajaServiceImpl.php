<?php
namespace Casa\Core\service\impl;


use Casa\Core\model\Transferencia;

use Casa\Core\utils\CasaUtils;

use Casa\Core\service\ServiceFactory;

use Casa\Core\model\MovimientoCuenta;

use Casa\Core\model\Caja;

use Casa\Core\criteria\CajaCriteria;

use Casa\Core\model\Empleado;

use Casa\Core\service\ICajaService;

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
 * servicio para caja
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class CajaServiceImpl extends CrudService implements ICajaService {


	protected function getDAO(){
		return DAOFactory::getCajaDAO();
	}

	function add( $entity ){

		$entity->setSaldo( 0 );

		parent::add( $entity );

	}

	function abrirCaja( Caja $caja, User $user ){

		//$entity->setSaldo( $entity->getSaldoInicial() );

		$this->add( $caja );

		//cuando abrimos la caja el saldo inicial se toma desde la caja chica
		//por lo tanto generamos una transferencia desde la caja chica.
		$transferencia = new Transferencia();
		$transferencia->setOrigen( CasaUtils::getCuentaCajaChica() );
		$transferencia->setDestino( $caja );
		$transferencia->setMonto( $caja->getSaldoInicial() );
		$transferencia->setFechaHora( new \Datetime() );
		$transferencia->setObservaciones( "Apertura de caja" );
		$transferencia->setUser( $user );

		ServiceFactory::getTransferenciaService()->add( $transferencia );

	}

	function validateOnAdd( $entity ){

		//que tenga número
		$numero = $entity->getNumero();
		if( empty($numero) )
			throw new ServiceException("caja.numero.required");

		//unicidad (numero + fecha + horaApertura )

	}


	function validateOnUpdate( $entity ){

		$this->validateOnAdd($entity);
	}

	function validateOnDelete( $oid ){}


	function getCajaAbiertaByEmpleado(Empleado $empleado){

		$criteria = new CajaCriteria();
		$criteria->setCajero($empleado);
		$criteria->setFecha( new \Datetime() );
		$criteria->setAbierta( true );

		try {

			$caja = $this->getDAO()->getSingleResult($criteria);
			return $caja;

		} catch (DAOException $e) {

			throw new ServiceException( $e->getMessage() );

		} catch (\Exception $e) {

			throw new ServiceException( $e->getMessage() );
		}

	}

	function getCajasAbiertas( \Datetime $fecha = null ){

		$criteria = new CajaCriteria();

		//if( CasaUtils::is)

		$criteria->setFecha( $fecha );
		$criteria->setAbierta( true );

		$cajas = $this->getList($criteria);
		return $cajas;


	}

	function cerrarCaja(Caja $caja, User $user){

		//TODO validaciones.

		$horaCierre = new \Datetime();

		$caja->setHoraCierre($horaCierre);

		try {

			$this->getDAO()->update($caja);

			//cuando cerramos la caja el saldo lo mandamos a la caja chica
			$transferencia = new Transferencia();
			$transferencia->setOrigen( $caja );
			$transferencia->setDestino( CasaUtils::getCuentaCajaChica() );
			$transferencia->setMonto( $caja->getSaldo() );
			$transferencia->setFechaHora( new \Datetime() );
			$transferencia->setObservaciones( "Cierre de caja" );
			$transferencia->setUser( $user );

			ServiceFactory::getTransferenciaService()->add( $transferencia );



		} catch (DAOException $e) {

			throw new ServiceException( $e->getMessage() );

		} catch (Exception $e) {

			throw new ServiceException( $e->getMessage() );
		}
	}


	function getCajasFecha( \Datetime $fecha ){

		$criteria = new CajaCriteria();
		$criteria->setFecha( $fecha );

		$cajas = $this->getList($criteria);
		return $cajas;


	}



}
