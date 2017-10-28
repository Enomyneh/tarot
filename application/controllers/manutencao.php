<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manutencao extends CI_Controller {
    
    public function emConstrucao(){

        // chama a view
        $this->template->view("manutencao_em_construcao", array(
           "title"       => "Em contrução"
        ));
    }
}

?>