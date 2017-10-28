<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Social extends CI_Controller {
    
    public function atividades_oraculares(){
        
        // chama a view
        $this->load->view("social_atividades_oraculares", array());
    }    
}

?>