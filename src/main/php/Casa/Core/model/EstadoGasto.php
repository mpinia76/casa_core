<?php

namespace Casa\Core\model;
/**
 * Estado de Gasto
 *
 *  @author Marcos
 * @since 02-08-2018
 */

class EstadoGasto{

    const Impago = 1;
    const Pagado = 2;
    const Anulado = 3;

    private static $items = array(
    								   self::Pagado => "gasto.pagado.label",
    								   self::Impago=> "gasto.impago.label",
    								   self::Anulado => "gasto.anulado.label"
    								   );


	public static function getItems(){
		return self::$items;
	}

	public static function getLabel($value){
		return self::$items[$value];
	}

	public static function sePuedePagar( EstadoGasto $estado ){

		return array_key_exists($estado,
									array(
    								   self::Impago=> 1,
								) );
	}
}
?>
