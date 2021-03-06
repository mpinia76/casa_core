<?php
namespace Casa\Core\service\impl;


use Casa\Core\service\IInformeSemanalService;

use Casa\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

/**
 * servicio para InformeSemanal
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class InformeSemanalServiceImpl extends CrudService implements IInformeSemanalService {


	protected function getDAO(){
		return DAOFactory::getInformeSemanalDAO();
	}


	function validateOnAdd( $entity ){

		//TODO

	}


	function validateOnUpdate( $entity ){

		$this->validateOnAdd($entity);
	}

	function validateOnDelete( $oid ){}

	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Casa/Core/service/Casa\Core\service.IInformeSemanalService::getInformeAnualPorMes()
	 */
	public function getInformeAnualPorMes($anio){

		try{

			//inicializamos el
			$result = array();
			$resultDAO = $this->getDAO()->getInformeAnualPorMes($anio);

			foreach ($resultDAO as $next) {
				$result[ $next["mes"] ] = array("ventas" => $next["ventas"]
												, "pagos" => $next["pagos"]
												, "comisiones" => $next["comisiones"] );
			}

			//completamos los meses vacíos.
			$mes = 1;
			while($mes <= 12){
				if(!array_key_exists($mes, $result))
					$result[ $mes ] = array("ventas" => 0
										, "pagos" => 0
										, "comisiones" => 0 );
				$mes++;
			}

			ksort($result);
			return $result;

		} catch (\Doctrine\ORM\NonUniqueResultException $e){
			return null;
		} catch (\Exception $e) {
			throw new DAOException( $e->getMessage() );
		}

	}

	/**
	 * (non-PHPdoc)
	 * @see src/main/php/Casa/Core/service/Casa\Core\service.IInformeSemanalService::getInformeAnualPorSemana()
	 */
	public function getInformeAnualPorSemana($anio){

		try{

			//inicializamos el
			$result = array();


			$resultDAO = $this->getDAO()->getInformeAnualPorSemana($anio);


			foreach ($resultDAO as $next) {

				$result[ $next["semana"] ] = array("ventas" => $next["ventas"]
												, "pagos" => $next["pagos"]
												, "mes" => $next["mes"]
												, "fecha" => $next["fecha"]
												, "comisiones" => $next["comisiones"] );

			}

			//completamos las semanas vacías.
			$ultimoDiaAño = new \DateTime();
			$ultimoDiaAño->setDate( $ultimoDiaAño->format("Y"), 12, 31 );

			$semana = 1;
			$fechaSemana = new \DateTime();
			$fechaSemana->setDate( $ultimoDiaAño->format("Y"), 1, 1 );
			$semana = $fechaSemana->format("W");
			$totalSemanas = $ultimoDiaAño->format("W");

			while($semana <= $totalSemanas){

//				if(!array_key_exists($semana, $result))
//					$result[ $semana ] = array("ventas" => 0
//										, "pagos" => 0
//										, "mes" => $next["mes"]
//										, "fecha" => $fechaSemana->format("Y-m-d")
//										, "comisiones" => 0 );
//
				$fechaSemana->modify("+7 day");
				$semana++; //= $fechaSemana->format("W");
			}

			ksort($result);

			return $result;

		} catch (\Doctrine\ORM\NonUniqueResultException $e){

			return null;


		} catch (\Exception $e) {

			throw new DAOException( $e->getMessage() );

		}
	}
}
