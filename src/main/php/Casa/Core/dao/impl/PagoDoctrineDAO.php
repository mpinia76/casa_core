<?php
namespace Casa\Core\dao\impl;

use Casa\Core\dao\IPagoDAO;

use Casa\Core\model\Pago;

use Cose\Crud\dao\impl\CrudDAO;

use Cose\criteria\ICriteria;

use Cose\exception\DAOException;
use Doctrine\ORM\QueryBuilder;
/**
 * dao para Pago
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class PagoDoctrineDAO extends CrudDAO implements IPagoDAO{

	protected function getClazz(){
		return get_class( new Pago() );
	}

	protected function getQueryBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select(array('p', 'empl', 'c', 's'))
	   				->from( $this->getClazz(), "p")
					->leftJoin('p.sucursal', 's')
					->leftJoin('p.cobrador', 'empl')
					->leftJoin('p.cliente', 'c');

		return $queryBuilder;
	}

	protected function getQueryCountBuilder(ICriteria $criteria){

		$queryBuilder = $this->getEntityManager()->createQueryBuilder();

		$queryBuilder->select('count(p.oid)')
	   				->from( $this->getClazz(), "p")
					->leftJoin('p.sucursal', 's')
					->leftJoin('p.cobrador', 'empl')
					->leftJoin('p.cliente', 'c');

		return $queryBuilder;
	}

	protected function enhanceQueryBuild(QueryBuilder $queryBuilder, ICriteria $criteria){

		$fecha = $criteria->getFecha();
		if( !empty($fecha) ){
			$queryBuilder->andWhere( "p.fechaHora = '" . $fecha->format("Y-m-d") . "'");
		}

		$fechaDesde = $criteria->getFechaDesde();
		if( !empty($fechaDesde) ){
			$queryBuilder->andWhere( "p.fechaHora >= '" . $fechaDesde->format("Y-m-d") . "'");
		}

		$fechaHasta = $criteria->getFechaHasta();
		if( !empty($fechaHasta) ){
			$queryBuilder->andWhere( "p.fechaHora <= '" . $fechaHasta->format("Y-m-d") . "'");
		}

		$vendedor = $criteria->getVendedor();
		if( !empty($vendedor) && $vendedor!=null){
			$vendedorOid = $vendedor->getOid();
			if(!empty($vendedorOid))
				$queryBuilder->andWhere( "empl.oid= $vendedorOid" );
		}

		$cliente = $criteria->getCliente();
		if( !empty($cliente) && $cliente!=null){
			$clienteOid = $cliente->getOid();
			if(!empty($clienteOid))
				$queryBuilder->andWhere( "c.oid= $clienteOid" );
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
			return "p.$name";
		}

	}
}
