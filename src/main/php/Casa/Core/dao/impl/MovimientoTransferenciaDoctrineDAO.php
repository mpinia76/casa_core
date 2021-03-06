<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\IMovimientoTransferenciaDAO;

use Casa\Core\model\MovimientoTransferencia;

use Casa\Core\model\ConceptoMovimiento;

use Casa\Core\dao\IConceptoMovimientoDAO;

use Casa\Core\criteria\ConceptoMovimientoCriteria;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;

use Casa\Core\model\Cuenta;
use Doctrine\ORM\Query\Expr\Andx;

/**
 * dao para MovimientoTransferencia
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class MovimientoTransferenciaDoctrineDAO extends CrudDAO implements IMovimientoTransferenciaDAO{

	protected function getClazz(){
		return get_class( new MovimientoTransferencia() );
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('mt', 'g'))
	   				->from( $this->getClazz(), "mt")
					->leftJoin('mt.cuenta', 'c')
					->leftJoin('mt.transferencia', 'g');

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(mt.oid)')
	   				->from( $this->getClazz(), "mt")
					->leftJoin('mt.cuenta', 'c')
					->leftJoin('mt.transferencia', 't');

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

//		$oid = $criteria->getOidNotEqual();
//		if( !empty($oid) ){
//			$queryBuilder->andWhere( "mt.oid <> $oid");
//		}

		//TODO filtrar fecha.

		$transferencia = $criteria->getTransferencia();
		if( !empty($transferencia) && $transferencia!=null){
			$transferenciaOid = $transferencia->getOid();
			if(!empty($transferenciaOid))
				$queryBuilder->andWhere( "t.oid= $transferenciaOid" );
		}

		$cuenta = $criteria->getCuenta();
		if( !empty($cuenta) && $cuenta!=null){
			$cuentaOid = $cuenta->getOid();
			if(!empty($cuentaOid))
				$queryBuilder->andWhere( "c.oid= $cuentaOid" );
		}

	}

	protected function getFieldName($name){

		$hash = array();

		if( array_key_exists($name, $hash) )
			return $hash[$name];
		else{
			return "mt.$name";
		}

	}


	public function getTotales(Cuenta $cuenta=null, \Datetime $fecha = null){

		try {

			$movimientoClass = get_class( new MovimientoTransferencia() );



			$emConfig = $this->getEntityManager()->getConfiguration();
			$emConfig->addCustomDatetimeFunction('YEAR', 'DoctrineExtensions\Query\Mysql\Year');
    		$emConfig->addCustomDatetimeFunction('MONTH', 'DoctrineExtensions\Query\Mysql\Month');
    		$emConfig->addCustomDatetimeFunction('DAY', 'DoctrineExtensions\Query\Mysql\Day');

			$queryBuilder = $this->getEntityManager()->createQueryBuilder();

			$queryBuilder->select('SUM(mc.debe) as debe, SUM(mc.haber) as haber')
	   				->from( $movimientoClass, "mc")
					->leftJoin('mc.cuenta', 'c');

			if( $cuenta != null )
				$queryBuilder->andWhere( "c.oid=" .  $cuenta->getOid() );

			if($fecha != null ){
				$queryBuilder->andWhere( "MONTH(mc.fechaHora) = " . $fecha->format("m") );
				$queryBuilder->andWhere( "YEAR(mc.fechaHora) = " . $fecha->format("Y") );
				$queryBuilder->andWhere( "DAY(mc.fechaHora) = " . $fecha->format("d") );
			}


			$q = $queryBuilder->getQuery();

			$r = $q->getScalarResult();

			return $r;

		} catch (\Doctrine\ORM\Query\QueryException $e) {

			throw new DAOException( $e->getMessage() );

		} catch (\Exception $e) {

			throw new DAOException( $e->getMessage() );

		}
	}
}
