<?php
namespace Casa\Core\dao\impl;

use Casa\Core\model\ConceptoMovimiento;

use Casa\Core\dao\IConceptoMovimientoDAO;

use Casa\Core\criteria\ConceptoMovimientoCriteria;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para ConceptoMovimiento
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class ConceptoMovimientoDoctrineDAO extends CrudDAO implements IConceptoMovimientoDAO{

	protected function getClazz(){
		return get_class( new ConceptoMovimiento() );
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('cm'))
	   				->from( $this->getClazz(), "cm");

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(cm.oid)')
	   				->from( $this->getClazz(), "cm");

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "cm.oid <> $oid");
		}

		$nombre = $criteria->getNombre();
		if( !empty($nombre) ){
			$queryBuilder->andWhere( "cm.nombre like '%$nombre%'");
		}

	}

	protected function getFieldName($name){

		$hash = array();

		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "cm.$name";
		}

	}
}
