<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\IInformeDiarioDebitoCreditoDAO;

use Casa\Core\model\InformeDiarioDebitoCredito;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

/**
 * dao para InformeDiarioDebitoCredito
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class InformeDiarioDebitoCreditoDoctrineDAO extends CrudDAO implements IInformeDiarioDebitoCreditoDAO{

	protected function getClazz(){
		return get_class( new InformeDiarioDebitoCredito() );
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
			$queryBuilder->andWhere( "MONTH(i.fecha) = " . $mes);
		}

		$anio = $criteria->getAnio();
		if( !empty($anio) ){
			$queryBuilder->andWhere( "YEAR(i.fecha) = " . $anio);
		}

		$estado = $criteria->getEstado();
		if( !empty($estado) ){
			$queryBuilder->andWhere( "i.estado = " . $estado);
		}

		$fechaVencimiento = $criteria->getFechaVencimiento();
		if( !empty($fechaVencimiento) ){
			$queryBuilder->andWhere( "i.fechaVencimiento = '" . $fechaVencimiento->format("Y-m-d") . "'");
		}

		$fechaVencimientoMenorIgual = $criteria->getFechaVencimientoMenorIgual();
		if( !empty($fechaVencimientoMenorIgual) ){
			$queryBuilder->andWhere( "i.fechaVencimiento <= '" . $fechaVencimientoMenorIgual->format("Y-m-d") . "'");
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
			$informeClass = get_class( new InformeDiarioDebitoCredito() );

			$emConfig = $this->getEntityManager()->getConfiguration();
    		$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');

			$q = $this->getEntityManager()->createQuery(
				"SELECT MONTH(t.fechaDesde) as mes,
					COUNT(t.oid) as cantidad
					, SUM(t.ventas) as ventas
					, SUM(t.pagos) as pagos
					, SUM(t.comision) as comision
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

}
