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
 * servicio para MovimientoGasto
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
class MovimientoGastoServiceImpl extends MovimientoCuentaServiceImpl {


	protected function getDAO(){
		return DAOFactory::getMovimientoGastoDAO();
	}

	function getTotales( Cuenta $cuenta=null, \Datetime $fecha = null){

		$result = $this->getDAO()->getTotales($cuenta, $fecha);
		$totales = $result[0];
		return $totales["haber"] - $totales["debe"];

	}


	public function getBalance(\Datetime $fechaDesde, \Datetime $fechaHasta){

		$result = $this->getDAO()->getBalance($fechaDesde,$fechaHasta);
		$totales = $result[0];
		return $totales["haber"] - $totales["debe"];

	}

	function getTotalesMes( Cuenta $cuenta=null, \Datetime $fecha = null){

		$result = $this->getDAO()->getTotalesMes($cuenta, $fecha);
		return $result;

	}

	function getTotalesAnioPorMes( Cuenta $cuenta=null, $anio){

		$result = $this->getDAO()->getTotalesAnioPorMes($cuenta, $anio);
		return $result;

	}

	function getTotalesAnioPorMesConcepto($anio){

		$result = $this->getDAO()->getTotalesAnioPorMesConcepto($anio);

		/*
		 * viene total, mes, concepto
		 * armamos
		 *
		 *   Anio
		 *   Totales
		 *   Detalles
		 *       Concepto
		 *           Mes => total
		 */
		$gastosTotales=0;
		$concepto=null;
		$detalles = array();
		//ponemos a 0 los totales de cada mes
		foreach ($result as $row) {
			for ($mes=1;$mes<=12;$mes++){
				$detalles[$row["concepto"]][$mes] = 0;
			}
			$detalles[$row["concepto"]]["total"] = 0;
		}

		foreach ($result as $row) {

			$detalles[$row["concepto"]][$row["mes"]] = $row["total"];


		}

		//sumarizo por concepto
		foreach ($detalles as $concepto => $meses) {
			$total = 0;

			for ($mes=1;$mes<=12;$mes++){
				$total +=  $detalles[$concepto][$mes];
			}

			$detalles[$concepto]["total"] = $total;
			$gastosTotales+= $total;
		}

		$gastos = array();
		$gastos["anio"] = $anio;
		$gastos["totales"] = $gastosTotales;
		$gastos["detalles"] = $detalles;

		return $gastos;
	}

}
