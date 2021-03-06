<?php
namespace Casa\Core\dao\impl;

use Casa\Core\model\MovimientoGasto;

use Casa\Core\dao\IMovimientoCuentaDAO;

use Casa\Core\dao\IMovimientoVentaDAO;

use Casa\Core\model\MovimientoVenta;

use Casa\Core\model\ConceptoMovimiento;

use Casa\Core\dao\IConceptoMovimientoDAO;

use Casa\Core\criteria\ConceptoMovimientoCriteria;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para MovimientoCuenta
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class MovimientoCuentaDoctrineDAO extends CrudDAO implements IMovimientoCuentaDAO{

	protected function getClazz(){
		return "Casa\Core\model\MovimientoCuenta";
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('mc', 'cu', 'co'))
	   				->from( $this->getClazz(), "mc")
					->leftJoin('mc.cuenta', 'cu')
					->leftJoin('mc.concepto', 'co');

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(mc.oid)')
	   				->from( $this->getClazz(), "mc")
					->leftJoin('mc.cuenta', 'cu')
					->leftJoin('mc.concepto', 'co');

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

//		$oid = $criteria->getOidNotEqual();
//		if( !empty($oid) ){
//			$queryBuilder->andWhere( "mv.oid <> $oid");
//		}

		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "mc.fechaHora = '" . $fecha->format("Y-m-d") . "'");
		}

		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "mc.fechaHora >= '" . $fechaDesde->format("Y-m-d") . "'");
		}

		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "mc.fechaHora <= '" . $fechaHasta->format("Y-m-d") . "'");
		}


		$cuenta = $criteria->getCuenta();
		if( !empty($cuenta) && $cuenta!=null){
			$cuentaOid = $cuenta->getOid();
			if(!empty($cuentaOid))
				$queryBuilder->andWhere( "cu.oid= $cuentaOid" );
		}
	}

//	public function getTotales(Cuenta $cuenta, \Datetime $fecha = null){
//
//		try {
//
//			$movimientoClass = get_class( new MovimientoGasto() );
//
//			$emConfig = $this->getEntityManager()->getConfiguration();
//			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
//    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
//    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');
//
//			$q = $this->getEntityManager()->createQuery(
//				"SELECT
//					SUM(mc.debe) as debe,
//					SUM(mc.haber) as haber
//					FROM $movimientoClass mc
//					WHERE cuenta_oid= " . $cuenta->getOid() . " AND
//					MONTH(mc.fechaHora) = " . $fecha->format("m") . " AND
//					YEAR(mc.fechaHora) = " . $fecha->format("Y")  . " AND
//					DAY(mc.fechaHora) = " . $fecha->format("d")
//			);
//
//			$r = $q->getScalarResult();
//
//			return $r;
//
//		} catch (\Doctrine\ORM\Query\QueryException $e) {
//
//			throw new DAOException( $e->getMessage() );
//
//		} catch (\Exception $e) {
//
//			throw new DAOException( $e->getMessage() );
//
//		}
//	}

	protected function getFieldName($name){

		$hash = array();

		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "mc.$name";
		}

	}
}
