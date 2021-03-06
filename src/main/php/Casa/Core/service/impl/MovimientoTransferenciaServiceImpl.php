<?php
namespace Casa\Core\service\impl;


use Casa\Core\model\Cuenta;

use Casa\Core\service\IMovimientoCuentaService;

use Casa\Core\model\MovimientoVenta;

use Casa\Core\service\ServiceFactory;

use Casa\Core\model\Caja;

use Casa\Core\model\Venta;

use Casa\Core\model\EstadoVenta;

use Casa\Core\service\IVentaService;

use Casa\Core\dao\DAOFactory;

use Cose\Crud\service\impl\CrudService;

use Cose\Security\service\SecurityContext;
use Cose\Security\model\User;

use Cose\exception\ServiceException;
use Cose\exception\ServiceNoResultException;
use Cose\exception\ServiceNonUniqueResultException;
use Cose\exception\DuplicatedEntityException;
use Cose\exception\DAOException;

/**
 * servicio para MovimientoTransferencia
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class MovimientoTransferenciaServiceImpl extends MovimientoCuentaServiceImpl {


	protected function getDAO(){
		return DAOFactory::getMovimientoTransferenciaDAO();
	}

	function getTotales( Cuenta $cuenta=null, \Datetime $fecha = null){

		$result = $this->getDAO()->getTotales($cuenta, $fecha);
		$totales = $result[0];
		return $totales["haber"] - $totales["debe"];

	}

}
