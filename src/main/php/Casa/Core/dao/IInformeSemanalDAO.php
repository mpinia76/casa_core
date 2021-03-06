<?php
namespace Casa\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

/**
 * Interface del DAO de InformeSemanal
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
interface IInformeSemanalDAO extends ICrudDAO {

	public function getInformeAnualPorSemana($anio);

	public function getInformeAnualPorMes($anio);
}
