<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Estado extends CI_Controller {
    
    public function getJSON(){
        // carrega a model
        $this->load->model("estado_model", "estado");
        
        // obtem os parametros
        $pais = $this->input->post("pais");
        $term = $this->input->post("term");
        
        try{
            // obtem os paises
            $estados = $this->estado->get(array(
                "pais" => $pais,
                "term" => $term
            ));
        }catch(Exception $e){
            // TODO
        }
        
        // declara o array de retorno
        $data = array();
        
        // percorre para formatar a saida
        foreach($estados as $estado){
            $data[] = array("id"=>$estado->cod, "value"=>$estado->estado.", ".$estado->sigla);
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