<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\IInformeDiarioComisionDAO;

use Casa\Core\model\InformeDiarioComision;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para InformeDiarioComision
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class InformeDiarioComisionDoctrineDAO extends CrudDAO implements IInformeDiarioComisionDAO{

	protected function getClazz(){
		return get_class( new InformeDiarioComision() );
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('i'))
	   				->from( $this->getClazz(), "i");

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(i.oid)')
	   				->from( $this->getClazz(), "i");

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

		$emConfig = $this->getEntityManager()->getConfiguration();
    	$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    	$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');


		$oid = $criteria->getOidNotEqual();
		if( !empty($oid) ){
			$queryBuilder->andWhere( "i.oid <> $oid");
		}

    	$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "i.fecha = '" . $fecha->format("Y-m-d") . "'");
		}

    	$mes = $criteria->getMes();
		if( !empty($mes) ){
			$queryBuilder->andWhere( "MONTH(i.fecha) = " . $mes);
		}

		$anio = $criteria->getAnio();
		if( !empty($anio) ){
			$queryBuilder->andWhere( "YEAR(i.fecha) = " . $anio);
		}



	}

	protected function getFieldName($name){

		$hash = array();

		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "i.$name";
		}

	}


	public function getInformeAnualPorMes($anio){

		try {
			$informeClass = get_class( new InformeDiarioComision() );

			$emConfig = $this->getEntityManager()->getConfiguration();
    		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

			$q = $this->getEntityManager()->createQuery(
				"SELECT MONTH(i.fecha) as mes,
					COUNT(i.oid) as cantidad
					, SUM(i.comision) as comision
					FROM $informeClass i
					WHERE YEAR(i.fecha) = $anio
					GROUP BY mes");


			$r = $q->getResult();

			return $r;

		} catch (\Doctrine\ORM\Query\QueryException $e) {

			throw new DAOException( $e->getMessage() );

		} catch (\Exception $e) {

			throw new DAOException( $e->getMessage() );

		}


	}

	public function getInformeMes( \DateTime $fecha ){

		try {
			$informeClass = get_class( new InformeDiarioComision() );

			$emConfig = $this->getEntityManager()->getConfiguration();
    		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
     		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');


     		$mes = $fecha->format("m");
     		$anio = $fecha->format("Y");

			$q = $this->getEntityManager()->createQuery(
				"SELECT DAY(i.fecha) as dia,
					COUNT(i.oid) as cantidad
					, SUM(i.comision) as comision
					FROM $informeClass i
					WHERE YEAR(i.fecha) = $anio AND MONTH(i.fecha) = $mes
					GROUP BY dia");

			$r = $q->getScalarResult();

			return $r;

		} catch (\Doctrine\ORM\Query\QueryException $e) {

			throw new DAOException( $e->getMessage() );

		} catch (\Exception $e) {

			throw new DAOException( $e->getMessage() );

		}


	}
}
