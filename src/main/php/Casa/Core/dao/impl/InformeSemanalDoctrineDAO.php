<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\IInformeSemanalDAO;

use Casa\Core\model\InformeSemanal;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para InformeSemanal
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class InformeSemanalDoctrineDAO extends CrudDAO implements IInformeSemanalDAO{

	protected function getClazz(){
		return get_class( new InformeSemanal() );
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


		$mes = $criteria->getMes();
		if( !empty($mes) ){
			$queryBuilder->andWhere( "MONTH(i.fechaDesde) = " . $mes);
		}

		$anio = $criteria->getAnio();
		if( !empty($anio) ){
			$queryBuilder->andWhere( "YEAR(i.fechaDesde) = " . $anio);
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
			$informeClass = get_class( new InformeSemanal() );

			$emConfig = $this->getEntityManager()->getConfiguration();
    		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

			$q = $this->getEntityManager()->createQuery(
				"SELECT MONTH(t.fechaDesde) as mes,
					COUNT(t.oid) as cantidad
					, SUM(t.ventas) as ventas
					, SUM(t.pagos) as pagos
					, SUM(t.comision) as comisiones
					FROM $informeClass t
					WHERE YEAR(t.fechaDesde) = $anio
					GROUP BY mes");

			$r = $q->getScalarResult();

			return $r;

		} catch (\Doctrine\ORM\Query\QueryException $e) {

			throw new DAOException( $e->getMessage() );

		} catch (\Exception $e) {

			throw new DAOException( $e->getMessage() );

		}


	}


	public function getInformeAnualPorSemana($anio){

		try {
			$informeClass = get_class( new InformeSemanal() );

			$emConfig = $this->getEntityManager()->getConfiguration();
    		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

    		$emConfig->addCustomDatetimeFunction('WEEK', 'DoctrineExtensions\Query\Mysql\Week');

			$q = $this->getEntityManager()->createQuery(
				"SELECT WEEK(t.fechaDesde) as semana,
					MONTH(t.fechaDesde) as mes,
					COUNT(t.oid) as cantidad,
					t.fechaDesde as fecha
					, SUM(t.ventas) as ventas
					, SUM(t.pagos) as pagos
					, SUM(t.comision) as comisiones
					FROM $informeClass t
					WHERE YEAR(t.fechaDesde) = $anio
					GROUP BY semana");

			$r = $q->getScalarResult();

			return $r;

		} catch (\Doctrine\ORM\Query\QueryException $e) {

			throw new DAOException( $e->getMessage() );

		} catch (\Exception $e) {

			throw new DAOException( $e->getMessage() );

		}


	}

}
