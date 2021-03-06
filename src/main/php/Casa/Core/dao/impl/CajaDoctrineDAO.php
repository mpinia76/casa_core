<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\ICajaDAO;

use Casa\Core\model\Caja;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Caja
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class CajaDoctrineDAO extends CrudDAO implements ICajaDAO{

	protected function getClazz(){
		return get_class( new Caja() );
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('c', 'caje'))
	   				->from( $this->getClazz(), "c")
					->leftJoin('c.sucursal', 's')
					->leftJoin('c.cajero', 'caje');

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(c.oid)')
	   				->from( $this->getClazz(), "c")
					->leftJoin('c.sucursal', 's')
					->leftJoin('c.cajero', 'caje');

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "c.oid <> $oid");
		}

		$numero = $criteria->getNumero();
		if( !empty($numero) ){
			$queryBuilder->andWhere( "c.numero = '$numero'");
		}

		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "c.fecha = '" . $fecha->format("Y-m-d") . "'");
		}

		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "c.fecha >= '" . $fechaDesde->format("Y-m-d") . "'");
		}

		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "c.fecha <= '" . $fechaHasta->format("Y-m-d") . "'");
		}

		$cajero = $criteria->getCajero();
		if( !empty($cajero) && $cajero!=null){
			$cajeroOid = $cajero->getOid();
			if(!empty($cajeroOid))
				$queryBuilder->andWhere( "caje.oid= $cajeroOid" );
		}

		$sucursal = $criteria->getSucursal();
		if( !empty($sucursal) && $sucursal!=null){
			$sucursalOid = $sucursal->getOid();
			if(!empty($sucursalOid))
				$queryBuilder->andWhere( "s.oid= $sucursalOid" );
		}

		$abierta = $criteria->getAbierta();
		if( $abierta ){
			$queryBuilder->andWhere( "c.horaCierre is null");
		}

	}

	protected function getFieldName($name){

		$hash = array();

		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "c.$name";
		}

	}
}
