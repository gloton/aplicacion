<?php
class View
{
	private $_controlador;
	private $_js;
	
	public function __construct(Request $peticion) {
		$this->_controlador = $peticion->getControlador();
	}
	
	public function renderizar ($vista, $item = false) {

		$menu = array(
				array(
						'id' => 'dashboard',
						'titulo' => 'Dashboard',
						'enlace' => BASE_URL . 'dashboard'
						
			
				),
				array(
						'id' => 'grafico1',
						'titulo' => 'Graf1',
						'enlace' => BASE_URL . 'grafico1'
				),
		);
		
		$js = array();
		
		if(count($this->_js)) {
			$js = $this->_js;
		}
				
		$_layoutParams = array(
				'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
				'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
				'ruta_js' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
				'menu' => $menu
		);
		
		//crearemos una carpeta por cada controlador ej;	controllers/indexController.php views/index	
		$rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.phtml';
		if(is_readable($rutaView)) {
			//para incluir el header
			include_once ROOT . 'views'. DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'header.php';
			//es el contenido de la vista ej;views/index/index.phtml (depende del controlador)
			include_once $rutaView;
			//para incluir el footer
			include_once ROOT . 'views'. DS . 'layout' . DS . DEFAULT_LAYOUT . DS . 'footer.php';
		} else {
            throw new Exception('Error de vista');
        }
	}
	
	//con array $js, vamos a enviar los array que queramos incluir en esa vista
	public function setJs(array $js)
	{
		if (is_array($js)) {
			for ($i = 0; $i < count($js); $i++) {
				echo BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i].'.js';
			}
		} else {
			throw new Exception('Error de js');
		}
	}	
}
?>