<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\ICuentaDAO;

use Casa\Core\model\Cuenta;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Cuenta
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class CuentaDoctrineDAO extends CrudDAO implements ICuentaDAO{

	protected function getClazz(){
		return "Casa\Core\model\Cuenta";
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('c'))
	   				->from( $this->getClazz(), "c");

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(c.oid)')
	   				->from( $this->getClazz(), "c");

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "c.oid <> $oid");
		}

		$numero = $criteria->getNumero();
		if( !empty($numero) ){
			$queryBuilder->andWhere( "c.numero LIKE '%$numero%'");
		}

		/*$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "c.fecha = '" . $fecha->format("Y-m-d") . "'");
		}*/


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
