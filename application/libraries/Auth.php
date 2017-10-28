<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
 
class Auth {

    public function check($redirect = true){
        // obtem a sessao
        @session_start();
        
        // checa a sessao
        if(!isset($_SESSION["logged"]) || $_SESSION["logged"] != true){
            if($redirect){
                // antes de redirecionar salva a url na sessao
                $_SESSION["source_url"] = site_url() . "/" . get_instance()->uri->uri_string;

                redirect("login/signin");
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public function checkUsuarioLite($redirect = true){
        // obtem a sessao
        @session_start();
        
        // checa a sessao
        if(!isset($_SESSION["logged"]) || $_SESSION["logged"] != true){
            if($redirect){

                // obtem os parametros da url se houver 
                $getParams = get_instance()->input->get();

                $queryString = "?";

                foreach($getParams as $key => $value){
                    $queryString .= $key . "=" . $value . "&";
                }

                if(count($getParams) == 0){
                    $queryString = "";
                }

                // antes de redirecionar salva a url na sessao
                $_SESSION["source_url"] = site_url() . "/" . get_instance()->uri->uri_string . $queryString;

                redirect("login/signinUsuarioLite");
            }else{
                return false;
            }
        }else{
            return true;
        }
    }
    
    public function checkAdmin($redirect = true){
        $this->check($redirect);
        
        if($this->getData("admin") == 0 || $this->getData("admin") == "0"){
            if($redirect)
            {
                redirect("tarot/combinacoesDisponiveis");    
            }else{
                return false;
            }
            
        }else{
            return true;
        }
    }
    
    public static function getData($data)
    {
        // obtem a sessao
        @session_start();
        
        $usuario = unserialize(@$_SESSION["usuario"]);
        
        if(isset($usuario[$data])){
            return $usuario[$data];
        }else{
            return false;
        }
    }
} 
?>
