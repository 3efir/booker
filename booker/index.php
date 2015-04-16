<?php
set_include_path(get_include_path()
				.PATH_SEPARATOR.'controllers'
				.PATH_SEPARATOR.'controllers/pageControllers'
				.PATH_SEPARATOR.'controllers/facadesControllers'
				.PATH_SEPARATOR.'models'
				.PATH_SEPARATOR.'views');
require_once "config/config.php";
function __autoload($class){
	require_once $class.'.php';
}
$fc = FrontController::getInstance();
$fc->route();
echo $fc->getBody();
?>