<?php
namespace Casa\Core\service;


use Cose\Crud\service\ICrudService;

/**
 * interfaz para el servicio de InformeSemanal
 *
 * @author Bernardo
 * @since 24-04-2015
 *
 */
interface IInformeSemanalService extends ICrudService {

	public function getInformeAnualPorMes($anio);

	public function getInformeAnualPorSemana($anio);
}
