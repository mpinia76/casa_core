<?php
namespace Casa\Core\service;


use Casa\Core\model\Transferencia;

use Cose\Crud\service\ICrudService;

use Cose\Security\model\User;

/**
 * interfaz para el servicio de Transferencia
 *
 * @author Bernardo
 * @since 03-06-2014
 *
 */
interface ITransferenciaService extends ICrudService {

	/**
	 * se anula la transferencia
	 * @param Transferencia $transferencia
	 * @param User $user
	 */
	public function anular(Transferencia $transferencia, User $user);

}
