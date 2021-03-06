<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('moeda')){
    function moeda($float){
        return number_format($float, 2, ",", ".");
    }
}

if ( ! function_exists('encodar_html')){
    function encodar_html($string){
        
        $string = str_replace("\r\n", "<br/>", $string);
        
        return $string;
    }
}

function isMd5($md5){
    return !empty($md5) && preg_match('/^[a-f0-9]{32}$/', $md5);
}

function getSaldo(){
    
    $ci = &get_instance();
    
    $cod = $ci->auth->getData("cod");
    
    $ci->load->model("login_model", "login");
    
    return $ci->login->getSaldo(array("cod_usuario" => $cod));
}

function montarUrlAmigavel($setorVida, $jogoCompleto){

    // muda o nome do setor da vida amoroso
    if(strtolower($setorVida->nome_setor_vida) == "amoroso"){
        $setorVida->nome_setor_vida = "amor";
    }

    // monta a url amigavel
    $urlAmigavel = "vida/".ajustaStringParaUrl($setorVida->nome_setor_vida)."/tarot/psychic/arcano/";
    $urlAmigavel2 = "vida/".ajustaStringParaUrl($setorVida->nome_setor_vida)."/tarot/psychic/arcano/";

    // monta uma string soh com o codigo das cartas
    $cartas = "";

    // percorre para armazenar as cartas e montar a url amigavel
    foreach($jogoCompleto as $key => $jogo){
        $cartas .= $jogo["arcanoMaior"]->cod_carta."#".$jogo["arcanoMenor1"]->cod_carta."#".$jogo["arcanoMenor2"]->cod_carta."|";

        // coloca as cartas somente ate a 3a casa
        if($key < 3){

            $urlAmigavel  .=  ajustaStringParaUrl($jogo["arcanoMaior"]->nome_carta) .  "/"
                            . ajustaStringParaUrl($jogo["arcanoMenor1"]->nome_carta) . "/"
                            . ajustaStringParaUrl($jogo["arcanoMenor2"]->nome_carta) . "/";
        }
    }

    // gera o token
    $token = md5($setorVida->cod_setor_vida.$cartas);

    // armazena o token na url
    //$urlAmigavel2 .= "token/".$token;
    $urlAmigavel .= "token/".$token;

    // monta o objeto de retorno
    $result = new stdClass();

    $result->token = $token;
    $result->cartas = $cartas;
    $result->url = $urlAmigavel;

    return $result;
}

function ajustaStringParaUrl($string){

    return preg_replace("[^a-zA-Z0-9_]", "", strtolower(strtr(utf8_decode(trim($string)), utf8_decode("áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ "), "aaaaeeiooouucAAAAEEIOOOUUC_")));
}

// funcao para rotacionar a string
function str_rot($s, $n = 13) {
    static $letters = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz';
    $n = (int)$n % 26;
    if (!$n) return $s;
    if ($n < 0) $n += 26;
    if ($n == 13) return str_rot13($s);
    $rep = substr($letters, $n * 2) . substr($letters, 0, $n * 2);
    return strtr($s, $letters, $rep);
}

function getJogoByCartasString($cartasStr){
    // obtem a instancia
    $ci = &get_instance();

    // carrega as models
    $ci->load->model("carta_model", "carta");
    $ci->load->model("casa_carta_model", "casa_carta");
    // transforma em um array das casas
    $casasCarta = explode("|", $cartasStr);
    // desativa a ultima
    unset($casasCarta[count($casasCarta)-1]);
    // busca todas as cartas
    $cartas = $ci->carta->get();
    // monta array com o jogo completo
    $jogoCompleto = array();
    // percorre o jogo para montar as cartas  e buscar as combinacoes
    foreach ($casasCarta as $key => $casa) {
        // salva os dados da casa da carta
        $jogoCompleto[$key]["casaCarta"] = $ci->casa_carta->get(array("cod_casa_carta" => ($key+1)));
        // separa as cartas
        list($arcMaior,$arcMenor1,$arcMenor2) = explode("#", $casa);
        foreach($cartas as $carta){
            // procura o arcano maior
            if($carta->cod_carta == $arcMaior){
                $jogoCompleto[$key]["arcanoMaior"] = $carta;
            }
            if($carta->cod_carta == $arcMenor1){
                $jogoCompleto[$key]["arcanoMenor1"] = $carta;
            }
            if($carta->cod_carta == $arcMenor2){
                $jogoCompleto[$key]["arcanoMenor2"] = $carta;
            }
        }
    }
    // retorna o jogo completo
    return $jogoCompleto;
}

function _helper_pedido_status_amigavel($status)
{
    $statusAmigavel = array(
        STATUS_PAGO => 'Pago',
        STATUS_AGUARDANDO_PAGAMENTO => 'Aguardando Pagamento',
        STATUS_AGUARDANDO_PAGSEGURO => 'Aguardando Retorno Pagseguro'
    );

    if(isset($statusAmigavel[$status]) == false)
    {
        return 'ERROR_STATUS';
    }else{

        return $statusAmigavel[$status];
    }
}

function _print($var)
{
    echo("<pre>");print_r($var);die;
}

function _dump($var)
{
    var_dump($var);die;
}
