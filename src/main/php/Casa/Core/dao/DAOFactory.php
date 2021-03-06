<?php
namespace Casa\Core\dao;

/**
 * Factory de DAOs
 *
 *  @author Marcos
 * @since 02-08-2018
 *
 */


use Casa\Core\dao\impl\MovimientoPagoDoctrineDAO;



use Casa\Core\dao\impl\InformeDiarioComisionDoctrineDAO;

use Casa\Core\dao\impl\InformeDiarioDebitoCreditoDoctrineDAO;

use Casa\Core\dao\impl\InformeSemanalDoctrineDAO;

use Casa\Core\dao\impl\BancoDoctrineDAO;


use Casa\Core\dao\impl\MovimientoTransferenciaDoctrineDAO;

use Casa\Core\dao\impl\TransferenciaDoctrineDAO;

use Casa\Core\dao\impl\CajaChicaDoctrineDAO;

use Casa\Core\dao\impl\MovimientoGastoDoctrineDAO;

use Casa\Core\dao\impl\CuentaDoctrineDAO;

use Casa\Core\dao\impl\MovimientoCuentaDoctrineDAO;

use Casa\Core\dao\impl\PagoDoctrineDAO;

use Casa\Core\dao\impl\GastoDoctrineDAO;

use Casa\Core\dao\impl\ConceptoMovimientoDoctrineDAO;

use Casa\Core\dao\impl\ConceptoGastoDoctrineDAO;

use Casa\Core\dao\impl\CajaDoctrineDAO;

class DAOFactory {


	/**
	 * DAO para Banco.
	 *
	 * @return IBancoDAO
	 */
	public static function getBancoDAO(){

		return new BancoDoctrineDAO();
	}
	/**
	 * DAO para CajaChica.
	 *
	 * @return ICajaChicaDAO
	 */
	public static function getCajaChicaDAO(){

		return new CajaChicaDoctrineDAO();
	}

	/**
	 * DAO para Caja.
	 *
	 * @return ICajaDAO
	 */
	public static function getCajaDAO(){

		return new CajaDoctrineDAO();
	}




	/**
	 * DAO para ConceptoGasto.
	 *
	 * @return IConceptoGastoDAO
	 */
	public static function getConceptoGastoDAO(){

		return new ConceptoGastoDoctrineDAO();
	}

	/**
	 * DAO para ConceptoMovimiento.
	 *
	 * @return IConceptoMovimientoDAO
	 */
	public static function getConceptoMovimientoDAO(){

		return new ConceptoMovimientoDoctrineDAO();
	}




	/**
	 * DAO para Cuenta.
	 *
	 * @return ICuentaDAO
	 */
	public static function getCuentaDAO(){

		return new CuentaDoctrineDAO();
	}




	/**
	 * DAO para Gasto.
	 *
	 * @return IGastoDAO
	 */
	public static function getGastoDAO(){

		return new GastoDoctrineDAO();
	}


	/**
	 * DAO para InformeSemanal.
	 *
	 * @return IInformeSemanalDAO
	 */
	public static function getInformeSemanalDAO(){

		return new InformeSemanalDoctrineDAO();
	}


	/**
	 * DAO para InformeDiarioComision.
	 *
	 * @return IInformeDiarioComisionDAO
	 */
	public static function getInformeDiarioComisionDAO(){

		return new InformeDiarioComisionDoctrineDAO();
	}


	/**
	 * DAO para InformeDiarioDebitoCredito.
	 *
	 * @return IInformeDiarioDebitoCreditoDAO
	 */
	public static function getInformeDiarioDebitoCreditoDAO(){

		return new InformeDiarioDebitoCreditoDoctrineDAO();
	}


	/**
	 * DAO para MovimientoCuenta.
	 *
	 * @return IMovimientoCuentaDAO
	 */
	public static function getMovimientoCuentaDAO(){

		return new MovimientoCuentaDoctrineDAO();
	}


	/**
	 * DAO para MovimientoGasto.
	 *
	 * @return IMovimientoGastoDAO
	 */
	public static function getMovimientoGastoDAO(){

		return new MovimientoGastoDoctrineDAO();
	}





	/**
	 * DAO para MovimientoPago.
	 *
	 * @return IMovimientoPagoDAO
	 */
	public static function getMovimientoPagoDAO(){

		return new MovimientoPagoDoctrineDAO();
	}



	/**
	 * DAO para MovimientoTransferencia.
	 *
	 * @return IMovimientoTransferenciaDAO
	 */
	public static function getMovimientoTransferenciaDAO(){

		return new MovimientoTransferenciaDoctrineDAO();
	}



	/**
	 * DAO para Pago.
	 *
	 * @return IPagoDAO
	 */
	public static function getPagoDAO(){

		return new PagoDoctrineDAO();
	}




	/**
	 * DAO para Transferencia.
	 *
	 * @return ITransferenciaDAO
	 */
	public static function getTransferenciaDAO(){

		return new TransferenciaDoctrineDAO();
	}



}
