<?php


include_once  dirname(__DIR__) . '/vendor/autoload.php';


use Casa\Core\conf\CasaConfig;
use Cose\persistence\PersistenceContext;
use Casa\Core\notificaciones\backupBBDD\BackupBBDD;

//inicializamos cuentas core.
CasaConfig::getInstance()->initialize();
CasaConfig::getInstance()->initLogger( dirname(__FILE__).  "/log4php.xml");

$persistenceContext =  PersistenceContext::getInstance();


$notificacion = new BackupBBDD();
$notificacion->send();

//cerramos la conexión a la base.
$persistenceContext->close();




?>
