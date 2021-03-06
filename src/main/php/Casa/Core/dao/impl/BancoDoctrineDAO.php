<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\IBancoDAO;

use Casa\Core\model\Banco;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Banco
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class BancoDoctrineDAO extends CrudDAO implements IBancoDAO{

	protected function getClazz(){
		return get_class( new Banco() );
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('b'))
	   				->from( $this->getClazz(), "b");

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(b.oid)')
	   				->from( $this->getClazz(), "b");

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "b.oid <> $oid");
		}

		$numero = $criteria->getNumero();
		if( !empty($numero) ){
			$queryBuilder->andWhere( "b.numero = '$numero'");
		}

		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere( "b.nombre = '$nombre'");
		}

	}

	protected function getFieldName($name){

		$hash = array();

		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "b.$name";
		}

	}
}
