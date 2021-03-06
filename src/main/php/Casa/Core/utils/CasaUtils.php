<?php
namespace Casa\Core\utils;

use Casa\Core\conf\CasaConfig;

use Casa\Core\service\ServiceFactory;

use Cose\Security\model\Usergroup;
use Cose\Security\model\User;

use Cose\utils\Logger;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * Utilidades para casa.
 *
 *  @author Marcos
 * @since 02-08-2018
 */
class CasaUtils {

	const CTS_USERGROUP_ADMIN = 1;

	const CTS_CONCEPTO_MOVIMIENTO_PAGO= 1;
	const CTS_CONCEPTO_MOVIMIENTO_GASTO= 2;
	const CTS_CONCEPTO_MOVIMIENTO_ANULACION_GASTO= 3;
	const CTS_CONCEPTO_MOVIMIENTO_RETIRO_EFECTIVO= 4;
	const CTS_CONCEPTO_MOVIMIENTO_ANULACION_RETIRO_EFECTIVO= 5;
	const CTS_CONCEPTO_MOVIMIENTO_TRANSFERENCIA= 6;
	const CTS_CONCEPTO_MOVIMIENTO_ANULACION_TRANSFERENCIA= 7;
	const CTS_CONCEPTO_MOVIMIENTO_ANULACION_PAGO= 2;



	const CTS_CONCEPTO_GASTO_VARIOS = 1;

	const CTS_CUENTA_CAJA_CHICA = 1;

	const CTS_CUENTA_BAPRO_CTACTE = 1;
	const CTS_CUENTA_ARISTEGUI_1 = 2;
	const CTS_CUENTA_BAPRO_CAJAAHORRO = 3;
	const CTS_CUENTA_ARISTEGUI_2 = 4;


	const CTS_DATE_FORMAT = 'd/m/Y';
	const CTS_DATETIME_FORMAT = 'd/m/y H:i:s';
	const CTS_TIME_FORMAT = 'H:i';

	//números
	const CTS_DECIMALES = '2';
	const CTS_SEPARADOR_DECIMAL = ',';
	const CTS_SEPARADOR_MILES = '.';

	//moneda.
	const CTS_MONEDA_SIMBOLO = '$';
	const CTS_MONEDA_ISO = 'ARS';
	const CTS_MONEDA_NOMBRE = 'Pesos Argentinos';
	const CTS_MONEDA_POSICION_IZQ = 1;




	/**
	 * se formateo un monto a visualizar
	 * @param $monto
	 * @return string
	 */
	public static function formatMontoToView( $monto ){

		if( empty($monto) )
		$monto = 0;

		$res = $monto;
		//si es negativo, le quito el signo para agregarlo antes de la moneda.
		if( $monto < 0 ){
			$res = $res * (-1);
		}

		$res = number_format ( $res ,  self::CTS_DECIMALES , self::CTS_SEPARADOR_DECIMAL, self::CTS_SEPARADOR_MILES );



		if( self::CTS_MONEDA_POSICION_IZQ ){
			$res = self::CTS_MONEDA_SIMBOLO . $res;

		}else
		$res = $res. self::CTS_MONEDA_SIMBOLO ;

		//si es negativo lo mostramos rojo y le agrego el signo.
		if( $monto < 0 ){
			$res = "<span style='color:red;'>- $res</span>";
		}

		return $res;
	}


	//Formato fecha yyyy-mm-dd
	public static function differenceBetweenDates($fecha_fin, $fecha_Ini, $formato_salida = "d") {
		$valueFI = str_replace('/', '-', $fecha_Ini);
		$valueFF = str_replace('/', '-', $fecha_fin);
		$f0 = strtotime($valueFF);
		$f1 = strtotime($valueFI);
		if ($f0 < $f1) {
			$tmp = $f1;
			$f1 = $f0;
			$f0 = $tmp;
		}
		return date($formato_salida, $f0 - $f1);
	}


	public static function formatMesToView( $mes ){

		$meses = array (
			"1" => "Enero",
			"2" => "Febrero",
			"3" => "Marzo",
			"4" => "Abril",
			"5" => "Mayo",
			"6" => "Junio",
			"7" => "Julio",
			"8" => "Agosto",
			"9" => "Septiembre",
			"10" => "Octubre",
			"11" => "Noviembre",
			"12" => "Diciembre"
		);

		return $meses[$mes];
	}

	public static function formatDateToView($value, $format=self::CTS_DATE_FORMAT) {

		$res = "";
		if( !empty( $value) )
			$res = $value->format($format);
		else $res = "";

		$meses = array (
			"January" => "Enero",
			"Febraury" => "Febrero",
			"March" => "Marzo",
			"April" => "Abril",
			"May" => "Mayo",
			"June" => "Junio",
			"July" => "Julio",
			"August" => "Agosto",
			"September" => "Septiembre",
			"October" => "Octubre",
			"November" => "Noviembre",
			"December" => "Diciembre",
			"Jan" => "Ene",
			"Feb" => "Feb",
			"Mar" => "Mar",
			"Apr" => "Abr",
			"May" => "May",
			"Jun" => "Jun",
			"Jul" => "Jul",
			"Aug" => "Ago",
			"Sep" => "Sep",
			"Oct" => "Oct",
			"Nov" => "Nov",
			"Dec" => "Dic"
		);

		$dias = array(
			'Monday' => 'Lunes',
			'Tuesday' => 'Martes',
			'Wednesday' => 'Miércoles',
			'Thursday' => 'Jueves',
			'Friday' => 'Viernes',
			'Saturday' => 'Sábado',
			'Sunday' => 'Domingo',
			'Mon' => 'Lun',
			'Tue' => 'Mar',
			'Wed' => 'Mie',
			'Thu' => 'Jue',
			'Fri' => 'Vie',
			'Sat' => 'Sab',
			'Sun' => 'Dom',
		);
		foreach ($meses as $key => $value) {
			$res = str_replace($key, $value, $res);
		}
		foreach ($dias as $key => $value) {
			$res = str_replace($key, $value, $res);
		}

		return $res ;
		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value)) {
			$dt = date($format, strtotime($value));
		}else
		$dt = "";

		return $dt;
		*/
	}

	public static function formatDateToPersist($value) {

		return $value->format("Y-m-d");

		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value))
		$dt = date("Y-m-d", strtotime($value));
		else
		$dt = "";
		return $dt;*/
	}

	public static function formatDateTimeToView($value, $format="") {

		if(empty($format))
			$format = self::CTS_DATETIME_FORMAT;
		if(!empty($value))
			return $value->format( $format );
		else
			return "";
		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value)) {
			$dt = date(self:CTS_DATE_FORMAT, strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function formatDateTimeToPersist($value) {

		return $value->format("Y-m-d H:i:s");

		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value))
		$dt = date("Y-m-d H:i:s", strtotime($value));
		else
		$dt = "";

		return $dt;*/
	}


	public static function addDays($date, $dateFormat="", $days){

		$date->modify("+$days day");
		return $date;
		/*
		$newDate = strtotime ( "+$days day" , strtotime ( $date ) ) ;
		$newDate = date ( $dateFormat , $newDate );

		return $newDate;
		*/
	}

	public static function substractDays($date, $dateFormat, $days){

		$date->modify("-$days day");
		return $date;
		/*
		$newDate = strtotime ( "-$days day" , strtotime ( $date ) ) ;
		$newDate = date ( $dateFormat , $newDate );

		return $newDate;
		*/
	}

	public static function addMinutes($date, $dateFormat, $minutes){

		//$date->modify("+$minutes minutes");
		//return $date;

		$newDate = strtotime ( "+$minutes minutes" , strtotime ( $date ) ) ;
		$newDate = date ( $dateFormat , $newDate );

		return $newDate;
	}

	public static function isSameDay( $dt_date, $dt_another){

		return $dt_date->format("Ymd") == $dt_another->format("Ymd");

		/*
		$dt_dateAux = strtotime ( $dt_date ) ;
		$dt_dateAux = date ( "Ymd" , $dt_dateAux );

		$dt_anotherAux = strtotime ( $dt_another ) ;
		$dt_anotherAux = date ( "Ymd" , $dt_anotherAux );

		return $dt_dateAux == $dt_anotherAux ;*/
	}


	public static function formatTimeToView($value, $format=self::CTS_TIME_FORMAT) {

		if(!empty($value))

			return $value->format($format);

		else return "";
		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value)) {
			$dt = date(self:CTS_TIME_FORMAT, strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function getHorasItems() {

		$desde = new \DateTime();
		$desde->setTime(0,0,0);
		$duracion = 15;
		$i=0;
		while( $i<97 ){

			$items[$desde->format("H:i")] = $desde->format("H:i");

			$desde->modify("+$duracion minutes");

			$i++;

		}

		return $items;

	}

	public static function formatEdad( $edad ){

		if( !empty($edad) ){

			if( $edad > 1)
				return "$edad años";
			else
				return "$edad año";
		}return "";
	}

	public static function getEdad( $fecha ){

		$fechaNac = $fecha;

		if ($fechaNac != null ){

			$hoy = new \DateTime();

			$dia = $hoy->format("d");
			$mes = $hoy->format("m");
			$anio = $hoy->format("Y");

			//fecha de nacimiento
			$dia_nac = $fechaNac->format("d");
			$mes_nac = $fechaNac->format("m");
			$anio_nac = $fechaNac->format("Y");

			//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual

			if (($mes_nac == $mes) && ($dia_nac > $dia)) {
				$anio=($anio-1);
			}

			//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual

			if ($mes_nac > $mes) {
				$anio=($anio-1);
			}

			//ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad

			$edad=($anio-$anio_nac);

		}
		else
			$edad = "";

    	return $edad;
	}




	public static function dayOfDate(\DateTime $value) {

		return $value->format("d");

		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value)) {
			$dt = date("d", strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function monthOfDate($value) {

		return $value->format("m");

		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value)) {
			$dt = date("m", strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function yearOfDate($value) {

		return $value->format("Y");

		/*
		$value = str_replace('/', '-', $value);

		if (!empty($value)) {
			$dt = date("Y", strtotime($value));
		}else
		$dt = "";

		return $dt;*/
	}

	public static function strtotime($value) {

		$value = str_replace('/', '-', $value);

		return strtotime($value);
	}


	public static function newDateTime($value) {

		$value = str_replace('/', '-', $value);
		$time = strtotime($value);

		$dateTime = new \DateTime();
		$dateTime->setDate(date("Y", $time), date("m", $time), date("d", $time));

		return $dateTime;
	}


	public static function localize($keyMessage){

		return Locale::localize( $keyMessage );
	}


	public static function localizeEntities($enumeratedEntities){

		$items = array();

		foreach ($enumeratedEntities as $key => $keyMessage) {
			$items[$key] = self::localize($keyMessage);
		}

		return $items;
	}

	public static function formatMessage($msg, $params){

		if(!empty($params)){

			$count = count ( $params );
			$i=1;
			while ( $i <= $count ) {
				$param = $params [$i-1];

				$msg = str_replace('$'.$i, $param, $msg);

				$i ++;
			}

		}
		return $msg;


	}

	public static function isAdmin( User $user ){

		$usergroup = new Usergroup();
		$usergroup->setOid(self::CTS_USERGROUP_ADMIN);
		return $user->hasUsergroup( $usergroup );

	}

	public static function isEmpleado( User $user ){

		$usergroup = new Usergroup();
		$usergroup->setOid(self::CTS_USERGROUP_EMPLEADO);
		return $user->hasUsergroup( $usergroup );

	}

	public static function getNewDate($dia,$mes,$anio){

		$date = new \DateTime();
		$date->setDate($anio, $mes, $dia);
		return $date;
	}


	public static function getFirstDayOfWeek(\Datetime $fecha){

		$f = new \Datetime();
		$f->setTimestamp( $fecha->getTimestamp() );

		//si es lunes, no hacemos nada, sino, buscamos el lunes anterior.
		if( $f->format("N") > 1 )
			$f->modify("last monday");

    	return $f;
	}


	public static function getLastDayOfWeek(\Datetime $fecha){

		$f = new \Datetime();
		$f->setTimestamp( $fecha->getTimestamp() );
    	$f->modify("next monday");

    	//si no es lunes, restamos un día.
    	if( $fecha->format("N") > 1 )
			$f->sub(new \DateInterval('P1D'));

    	return $f;
	}

	public static function getFirstDayOfMonth(\Datetime $fecha){


		$f = self::getNewDate( 1, $fecha->format("m"), $fecha->format("Y"));
    	return $f;
	}


	public static function getLastDayOfMonth(\Datetime $fecha){

		//me paro en el primer día del mes siguiente y resto un día.

		$f = self::getFirstDayOfMonth($fecha);
		$f->modify("+1 month");
    	$f->modify("-1 day");

    	return $f;
	}

	public static function getFirstDayOfYear(\Datetime $fecha){

		$f = self::getNewDate( 1, 1, $fecha->format("Y"));
    	return $f;
	}


	public static function getLastDayOfYear(\Datetime $fecha){

		//me paro en el primer día del anio siguiente y resto un día.

		$f = self::getFirstDayOfYear($fecha);
		$f->modify("+1 year");
    	$f->modify("-1 day");

    	return $f;
	}
	public static function fechasIguales(\Datetime $fecha1, \Datetime $fecha2){
		return $fecha1->format("Ymd") == $fecha2->format("Ymd");
	}



	public static function getConceptoMovimientoGasto(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_GASTO );
	}

	public static function getUserByUsername( $username ){
		return \Cose\Security\service\ServiceFactory::getUserService()->getUserByUsername($username);
	}


	public static function getConceptoGastoVarios(){

		return ServiceFactory::getConceptoGastoService()->get( self::CTS_CONCEPTO_GASTO_VARIOS );
	}

	public static function getConceptoMovimientoAnulacionVenta(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_ANULACION_VENTA );
	}

	public static function getConceptoMovimientoAnulacionGasto(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_ANULACION_GASTO );
	}

	public static function getConceptoMovimientoPagoPremio(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_PAGO_PREMIO );
	}

	public static function getConceptoMovimientoPago(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_PAGO );
	}

	public static function getConceptoMovimientoAnulacionPagoPremio(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_ANULACION_PAGO_PREMIO );
	}

	public static function getConceptoMovimientoTransferencia(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_TRANSFERENCIA );
	}

	public static function getConceptoMovimientoAnulacionTransferencia(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_ANULACION_TRANSFERENCIA );
	}

	public static function getConceptoMovimientoRetiroEfectivo(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_RETIRO_EFECTIVO );
	}

	public static function getConceptoMovimientoAnulacionRetiroEfectivo(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_ANULACION_RETIRO_EFECTIVO );
	}

	public static function getConceptoMovimientoAnulacionPago(){

		return ServiceFactory::getConceptoMovimientoService()->get( self::CTS_CONCEPTO_MOVIMIENTO_ANULACION_PAGO );
	}

	public static function getCuentaCajaChica(){

		return ServiceFactory::getCajaChicaService()->get( self::CTS_CUENTA_CAJA_CHICA );
	}

	public static function getCuentaBAPROCtaCte(){

		return ServiceFactory::getBancoService()->get( self::CTS_CUENTA_BAPRO_CTACTE );
	}

	public static function getCuentaBAPROCajaAhorro(){

		return ServiceFactory::getBancoService()->get( self::CTS_CUENTA_BAPRO_CAJAAHORRO );
	}

	public static function getCuentaARISTEGUI1(){

		return ServiceFactory::getBancoService()->get( self::CTS_CUENTA_ARISTEGUI_1 );
	}

	public static function getCuentaARISTEGUI2(){

		return ServiceFactory::getBancoService()->get( self::CTS_CUENTA_ARISTEGUI_2 );
	}


	public static function sendMailPop($nameTo, $to, $subject, $msg, $attachs) {

		$libsHome= CasaConfig::getInstance()->getLibsPath();

        /*require_once($libsHome . "/mailer/class.phpmailer.php");
        require_once($libsHome . "/mailer/class.smtp.php");*/





        if( CasaConfig::TEST_MODE ){
        	//me los envío todos a mi en test
        	$to = CasaConfig::TEST_MAIL_TO;
        }

        //para que no de la salida del mailer.
        //ob_start();

        $mail = new PHPMailer(true);
		$mail->SMTPOptions = array(

			'ssl' => array(

				'verify_peer' => false,

				'verify_peer_name' => false,

				'allow_self_signed' => true

			)

		);

		$mail->isSMTP();
		//Enable SMTP debugging
		// 0 = off (for production use)
		// 1 = client messages
		// 2 = client and server messages
		$mail->SMTPDebug = 3;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = CasaConfig::POP_MAIL_HOST;
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = CasaConfig::POP_MAIL_PORT;
		$mail->SMTPSecure = CasaConfig::POP_MAIL_SMTP_SECURE;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = true;
		//Username to use for SMTP authentication
		$mail->Username = CasaConfig::POP_MAIL_USERNAME;
		//Password to use for SMTP authentication
		$mail->Password = CasaConfig::POP_MAIL_PASSWORD;

		//Set who the message is to be sent from
		$mail->setFrom(CasaConfig::MAIL_FROM, CasaConfig::MAIL_FROM_NAME);
		//Set an alternative reply-to address
		$mail->addReplyTo(CasaConfig::MAIL_FROM, CasaConfig::MAIL_FROM_NAME);
		//Set who the message is to be sent to
		$mail->addAddress($to, $nameTo);
		//Set the subject line
		$mail->Subject = $subject;
		$body = $msg;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($body);
		//Replace the plain text body with one created manually
		$mail->AltBody = $body;



		$mail->CharSet = 'UTF-8';



        if ($attachs) {
	        foreach ($attachs as $attach) {
	        	$mail->AddAttachment($attach);
	        }
        }



        if (!$mail->send()){
			self::log("Ocurri� un error en el env�o del mail a $nameTo <$to>") ;
            //throw new GenericException("Ocurri� un error en el env�o del mail a $nameTo <$to>");
		}

        // Clear all addresses and attachments for next loop
        $mail->ClearAddresses();
        $mail->ClearAttachments();

        //para que no de la salida del mailer.
        //ob_end_clean();
    }

    public static function sendMail($nameTo, $to, $subject, $msg, $attachs) {



        if (CasaConfig::MAIL_ENVIO_POP)
            self::sendMailPop($nameTo, $to, $subject, $msg, $attachs);
        else {

            //para que no de la salida del mailer.
            ob_start();

            $to2 = $nameTo . " <" . $to . ">";
            $headers = 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
            $headers .= "From: " . CDT_POP_MAIL_FROM;

            if (!mail($to2, $subject, $msg, $headers)){
                self::log("Ocurri� un error en el env�o del mail a $to2") ;
            	//throw new GenericException("Ocurri� un error en el env�o del mail a $to2");
            }
            //para que no de la salida del mailer.
            ob_end_clean();
        }
    }

    public static function log($msg, $clazz=__CLASS__){
    	Logger::log($msg, $clazz);
    }


    public static function getCategoriaProductoVentasOnline(){

		return ServiceFactory::getCategoriaProductoService()->get( self::CTS_CATEGORIA_PRODUCTO_ONLINE );
	}


}
