<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\ICajaChicaDAO;

use Casa\Core\model\CajaChica;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para CajaChica
 *
 *  @author Marcos
 * @since 02-08-2018
 */
class CajaChicaDoctrineDAO extends CrudDAO implements ICajaChicaDAO{

	protected function getClazz(){
		return get_class( new CajaChica() );
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('c', 's'))
	   				->from( $this->getClazz(), "c")
					->leftJoin('c.sucursal', 's');

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(c.oid)')
	   				->from( $this->getClazz(), "c")
					->leftJoin('c.sucursal', 's');

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

		$sucursal = $criteria->getSucursal();
		if( !empty($sucursal) && $sucursal!=null){
			$sucursalOid = $sucursal->getOid();
			if(!empty($sucursalOid))
				$queryBuilder->andWhere( "s.oid= $sucursalOid" );
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
