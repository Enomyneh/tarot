<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cidade extends CI_Controller {
    
    public function getJSON(){
        // carrega a model
        $this->load->model("cidade_model", "cidade");
        
        // obtem os parametros
        $estado = $this->input->post("estado");
        $term = $this->input->post("term");
        
        try{
            // obtem os paises
            $cidades = $this->cidade->get(array(
                "estado" => $estado,
                "term" => $term
            ));
        }catch(Exception $e){
            // TODO
        }
        
        // declara o array de retorno
        $data = array();
        
        // percorre para formatar a saida
        foreach($cidades as $cidade){
            $data[] = array("id"=>$cidade->cod, "value"=>$cidade->cidade);
        }
        
        // se nao achou nenhum retorna uma string informando
        if(count($data) == 0){
            $data[] = array("id"=>-1, "value"=> utf8_encode("Não encontrado"));
        }
        
        // retorna em json
        die(json_encode($data));
    }
}

?>