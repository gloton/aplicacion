<?php

//tiene que ser una clase abstracta para que no pueda ser instanciada
abstract class Controller
{
	protected $_view;
	
	public function __construct() {
		//de esta forma tenemos disponible el objeto View en el controlador ppal
		$this->_view = new View (new Request);
	}	
    abstract public function index ();
    
    //crearemos un metodo que nos importe los modelos
    protected function loadModel($modelo)
    {
    	$modelo = $modelo . 'Model';
    	$rutaModelo = ROOT . 'models' . DS . $modelo . '.php';
    
    	if(is_readable($rutaModelo)){
    		require_once $rutaModelo;
    		$modelo = new $modelo;
    		return $modelo;
    	}
    	else {
    		throw new Exception('Error de modelo');
    	}
    }
    
    protected function getLibrary($libreria)
    {
    	$rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';
    
    	if(is_readable($rutaLibreria)){
    		require_once $rutaLibreria;
    	}
    	else{
    		throw new Exception('Error de libreria');
    	}
    }
    
    //este metodo va a tomar una variable enviada por el metodo post,
    //y devolvera este dato filtrado
    protected function getTexto($clave) {
    
    	if (isset($_POST[$clave]) && !empty($_POST[$clave])) {
    		$_POST[$clave] = htmlspecialchars($_POST[$clave], ENT_QUOTES);
    		return $_POST[$clave];
    	}
    
    	return '';
    
    }
    
    protected function getInt($clave)
    {
    	if(isset($_POST[$clave]) && !empty($_POST[$clave])){
    		$_POST[$clave] = filter_input(INPUT_POST, $clave, FILTER_VALIDATE_INT);
    		return $_POST[$clave];
    	}
    
    	return 0;
    }
    
    protected function redireccionar($ruta = false)
    {
    	if($ruta){
    		header('location:' . BASE_URL . $ruta);
    		exit;
    	}
    	else{
    		header('location:' . BASE_URL);
    		exit;
    	}
    }    
    
    protected function loadHelper($helper) {
    
    	$rutaHelper = ROOT . 'helpers' . DS . $helper . '.php';
    
    	if(is_readable($rutaHelper)){
    		
    		require_once $rutaHelper;
    		$helper = new $helper;
    		return $helper;
    
    	} else {
    
    		throw new Exception('Error de helper');
    	}
    }
}

?>
