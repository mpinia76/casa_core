<?php
namespace Casa\Core\dao;

use Cose\exception\DAOException;

use Cose\Crud\dao\ICrudDAO;

/**
 * Interface del DAO de IInformeDiarioComision
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */
interface IInformeDiarioComisionDAO extends ICrudDAO {

	function getInformeMes( \DateTime $fecha );

	function getInformeAnualPorMes($anio);

}
