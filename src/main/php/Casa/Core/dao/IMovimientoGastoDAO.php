<?php
namespace Casa\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

/**
 * Interface del DAO de MovimientoGasto
 *
 * @author Marcos
 * @since 02-08-2018
 *
 */
interface IMovimientoGastoDAO extends ICrudDAO {

	function getBalance(\Datetime $fechaDesde, \Datetime $fechaHasta);

	function  getTotalesAnioPorMesConcepto($anio);
}
