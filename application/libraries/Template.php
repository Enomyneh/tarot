<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Template {
	private $additionalStyles	= array();
	private $additionalScripts	= array();

	public function addAdditionalStyle($stylePath){
		$this->additionalStyles[] = $stylePath;
	}

	public function addAdditionalScript($scriptPath){
		$this->additionalScripts[] = $scriptPath;
	}

	public function view($view, array $data = array(), array $additionalStyles = array(), array $additionalScripts = array()){ 
		// get a codeigniter instance
		$CI = &get_instance();

		// get the specified view's text
		$viewData = $CI->load->view($view, $data, true);

		// insert the additional styles and scripts
		foreach($additionalStyles as $stylePath){
			$this->addAdditionalStyle($stylePath);
		}
		foreach($additionalScripts as $scriptPath){
			$this->addAdditionalScript($scriptPath);
		}
		
		// declare title variable
		$title = "Untitled Page";
		
		// get the title if exists
		if(isset($data["title"])){
			$title = $data["title"];
		}
		
		// banners
		$topBanner      = isset($data["topBanner"]) ? $data["topBanner"] : true;
		$bottomBanner 	= isset($data["bottomBanner"]) ? $data["bottomBanner"] : true;
		$sideBanner1	= isset($data["sideBanner1"]) ? $data["sideBanner1"] : true;
		$sideBanner2	= isset($data["sideBanner2"]) ? $data["sideBanner2"] : true;
		$menuLateral	= isset($data["menuLateral"]) ? $data["menuLateral"] : true;
		$incorporado 	= isset($data["incorporado"]) ? $data["incorporado"] : false;
		$menuHorizontal	= isset($data["menuHorizontal"]) ? $data["menuHorizontal"] : false;
		$keywords		= isset($data["keywords"]) ? $data["keywords"] : "";

		if($incorporado){
			$menuLateral = false;
		}

		// load the template
		$CI->load->view("template", array(
			"additionalStyles" => $this->additionalStyles, 
			"additionalScripts" => $this->additionalScripts, 
			"view" => $viewData,
			"title" => $title,
			"topBanner" => $topBanner,
			"bottomBanner" => $bottomBanner,
			"sideBanner1" => $sideBanner1,
			"sideBanner2" => $sideBanner2,
			"menuLateral" => $menuLateral,
			"incorporado" => $incorporado,
			"keywords" => $keywords,
			"menuHorizontal" => $menuHorizontal
		));
	} 
} 
?>
