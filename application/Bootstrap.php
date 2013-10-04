<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    public function _initConfig()
    {
        $config = new Zend_Config($this->getApplication()->getOptions(), true);
        Zend_Registry::set('config', $config);
    }
	
	protected function _initDoctype() {
        Zend_Layout::startMvc();
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->Doctype('HTML5');
        $view->headTitle('Jogos de Empresa')->setSeparator(' | ');
		$view->headLink()->prependStylesheet("/JogosEmpresa/public/css/bootstrap.css");
		$view->headLink()->prependStylesheet("/JogosEmpresa/public/js/wijmo/jquery.wijmo-open.1.5.0.css");
		$view->headLink()->prependStylesheet("/JogosEmpresa/public/js/wijmo/jquery-ui-1.8.16.custom.css");
      	$view->headScript()->appendFile("/JogosEmpresa/public/js/wijmo/jquery-1.6.2.min.js");
      	$view->headScript()->appendFile("/JogosEmpresa/public/js/wijmo/jquery-ui-1.8.16.custom.min.js");
      	$view->headScript()->appendFile("/JogosEmpresa/public/js/wijmo/demo.js");
      	$view->headScript()->appendFile("/JogosEmpresa/public/js/wijmo/daterangepicker.jQuery.js");
      	$view->headScript()->appendFile("/JogosEmpresa/public/js/wijmo/fileinput.jquery.js");
      	$view->headScript()->appendFile("/JogosEmpresa/public/js/wijmo/jquery.wijmo-open.1.5.0.min.js");
    }

    protected function _initViewHelpers() {
        $this->bootstrap('view');
        $view = $this->getResource('view');
		/* 
		*	Compressor de páginas GZIP
		*/
        /*
		$ua = $_SERVER['HTTP_USER_AGENT'];
		  if ((strpos($ua, 'Mozilla/4.0 (compatible; MSIE ') !== 0 || strpos($ua, 'Opera') !== false)) {
			 $view->headMeta()->appendHttpEquiv('Accept-encoding', 'gzip,deflate');
			 ob_start('ob_gzhandler');
		  } else {
			 $version = floatval(substr($ua, 30));
			 if ($version < 6 || ($version == 6 && strpos($ua, 'SV1') === false)) {
				$view->headMeta()->appendHttpEquiv('Accept-encoding', 'gzip,deflate');
				ob_start('ob_gzhandler');
			 }
		  }
		*/
		  /*
		  *	FIM do compressor
		  */
		Zend_Dojo::enableView($view);
				$view->dojo()->enable()
						->setLocalPath('JogosEmpresa/public/js/dojo/dojo.js')
						->addStylesheetModule('dijit.themes.tundra')
						->requireModule('dijit.Dialog')
						->setDjConfigOption('usePlainJson', true)
						->disable();
        $view->addHelperPath("ZendX/JQuery/View/Helper", "ZendX_JQuery_View_Helper");
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
        $viewRenderer->initView();
	    $viewRenderer->view->addBasePath(APPLICATION_PATH . '/layouts/');
		Zend_Loader::loadFile("fpdf.php", realpath('/home/luxucom/public_html/JogosEmpresa/library/fpdf'), true);
//		Zend_Loader::loadFile("fpdf.php", realpath(APPLICATION_PATH . '/../library/fpdf'), true);
    }
	
	protected function _initNavigation() {
		$this->bootstrap ( 'layout' );
		$layout = $this->getResource ( 'layout' );
		$view = $layout->getView ();
//		$config = new Zend_Config_Ini ( APPLICATION_PATH . '/configs/navigation.ini' ); 
		$config = new Zend_Config_Ini ( '/home/luxucom/public_html/JogosEmpresa/application/configs/navigation.ini' ); 
		$navigation = new Zend_Navigation ( $config );
		$view->navigation ( $navigation );
	}
	
/*	public function _initCache()
	{
		$config = Zend_Registry::get('config')->cache;
		$frontendOptions = array(
		   'lifetime' => $config->frontend->lifetime, // tempo de vida 
		   'automatic_serialization' => $config->frontend->automatic_serialization
			);
		$backendOptions = $config->backend->options->toArray();
		// criando uma instancia do cache
		$cache = Zend_Cache::factory('Core',//frontend
								 $config->backend->adapter,  //backend
								 $frontendOptions,
								 $backendOptions);
		
		* Salva o cache no Registry para ser usado posteriormente
		
		Zend_Registry::set('cache', $cache);
		
		* cache para metadados das tabelas
		
		Zend_Db_Table_Abstract::setDefaultMetadataCache($cache);		
	}
*/
}
?>