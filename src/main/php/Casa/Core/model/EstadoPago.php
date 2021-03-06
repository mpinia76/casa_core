<?php

namespace Casa\Core\model;
/**
 * Estado de Pago
 *
 *  @author Marcos
 * @since 02-08-2018
 */

class EstadoPago{

    const Pendiente = 1;
    const Realizado = 2;
    const Anulado = 3;


    private static $items = array(
    								   self::Pendiente => "pago.pendiente.label",
    								   self::Realizado => "pago.realizado.label",
    								   self::Anulado => "pago.anulado.label"
    								   );


	public static function getItems(){
		return self::$items;
	}

	public static function getLabel($value){
		return self::$items[$value];
	}


}
?>
