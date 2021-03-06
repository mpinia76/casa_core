<?php
namespace Casa\Core\service;


use Casa\Core\model\Gasto;

use Casa\Core\model\Cuenta;

use Cose\Crud\service\ICrudService;
use Cose\Security\model\User;

/**
 * interfaz para el servicio de Gasto
 *
 * @author Bernardo
 * @since 23-05-2014
 *
 */
interface IGastoService extends ICrudService {


	/**
	 * se realiza el pago del gasto
	 * @param $gasto
	 * @param $cuenta
	 * @param $user
	 */
	public function pagar(Gasto $gasto, Cuenta $cuenta, User $user, $fechaHora);

	/**
	 * se anula el gasto
	 * @param $gasto
	 */
	public function anular(Gasto $gasto, User $user);


	/**
	 * se obtienen los gastos por vencer
	 */
	public function getGastosPorVencer();
}
