<?php

/**
 * Class Jogo_model
 *
 * @property Url_jogo_model url_jogo
 * @property Carta_Casa_Setor_Valor_model carta_casa_setor_valor
 * @property Auth auth
 */
class Jogo_model extends CI_Model {

    public $url = null;
    public $setorVida = null;
    public $combinacoes = array();
    public $custo = 0;
    public $jaComprado = false;
    public $liberadoParaConsulta = false;
    
    public function __construct(){
        
        // construtor parent
        parent::__construct();
        
        $this->load->database();
        $this->load->model("url_jogo_model", "url_jogo");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");
    }

    public function getByToken($token)
    {
        // valida o token
        if(isMd5($token) == false){
            die("erro: token invalido");
        }

        // busca a url do jogo
        $this->url = $this->url_jogo->get(array("token" => $token));

        // busca os dados do setor da vida
        $this->setorVida = $this->setor_vida->get(array('cod_setor_vida' => $this->url->cod_setor_vida));

        // busca o jogo completo a patir da string das cartas
        $jogoCompleto = Utils::getJogoByCartasString($this->url->cartas);

        $this->combinacoes = $jogoCompleto;

        // calcula o custo do jogo
        $this->preencheValorJogo();

        return $this;
    }

    public function getByTokenInSession()
    {
        // carrega a session
        $this->load->library("session");

        // obtem o jogo da session
        $token = $this->session->userdata("token_jogo");

        return $this->getByToken($token);
    }

    public function preencheValorJogo()
    {
        // assume que o jogo inteiro esta comprado
        // caso tenha alguma casa nao comprada esta flag sera alterada
        $this->jaComprado = true;

        // assume que o jogo esta liberado para consulta
        // isso quer dizer que as cartas pagas ja foram compradas
        // e o restante das cartas sao gratuitas
        $this->liberadoParaConsulta = true;

        foreach($this->combinacoes as $key => $jogo)
        {
            // busca os custos por carta e se o usuario ja comprou
            $jogo['arcanoMaior']->custo = $this->getCustoPorCarta(
                $jogo['arcanoMaior']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta,
                $this->setorVida
            );
            $jogo['arcanoMaior']->ja_comprado = $this->checkCartaJaComprada(
                $jogo['arcanoMaior']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta,
                $this->setorVida
            );
            $jogo['arcanoMenor1']->custo = $this->getCustoPorCarta(
                $jogo['arcanoMenor1']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta,
                $this->setorVida
            );
            $jogo['arcanoMenor1']->ja_comprado = $this->checkCartaJaComprada(
                $jogo['arcanoMenor1']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta,
                $this->setorVida
            );
            $jogo['arcanoMenor2']->custo = $this->getCustoPorCarta(
                $jogo['arcanoMenor2']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta,
                $this->setorVida
            );
            $jogo['arcanoMenor2']->ja_comprado = $this->checkCartaJaComprada(
                $jogo['arcanoMenor2']->cod_carta,
                $jogo['casaCarta']->cod_casa_carta,
                $this->setorVida
            );

            // calcula o custo por casa
            $jogo['casaCarta']->custo = $jogo['arcanoMaior']->custo +
                $jogo['arcanoMenor1']->custo +
                $jogo['arcanoMenor2']->custo;

            // define se a casa inteira ja esta comprada para este setor
            $jogo['casaCarta']->ja_comprada = false;

            if($jogo['arcanoMaior']->ja_comprado AND $jogo['arcanoMenor1']->ja_comprado AND $jogo['arcanoMenor2']->ja_comprado)
            {
                $jogo['casaCarta']->ja_comprada = true;
            }

            // se esta casa ainda nao esta totalmente comprada o jogo tambem nao esta
            if($jogo['casaCarta']->ja_comprada == false)
            {
                // define o jogo como nao comprado
                $this->jaComprado = false;
            }

            // soma no custo total do jogo
            $this->custo += $jogo['casaCarta']->custo;

            // checa se o jogo esta liberado para consulta
            if($jogo['arcanoMaior']->ja_comprado == false AND $jogo['arcanoMaior']->custo > 0)
            {
                $this->liberadoParaConsulta = false;
            }
            if($jogo['arcanoMenor1']->ja_comprado == false AND $jogo['arcanoMenor1']->custo > 0)
            {
                $this->liberadoParaConsulta = false;
            }
            if($jogo['arcanoMenor2']->ja_comprado == false AND $jogo['arcanoMenor2']->custo > 0)
            {
                $this->liberadoParaConsulta = false;
            }
        }
    }

    public function getCustoPorCarta($codCarta, $codCasa, $setorVida)
    {
//        if($this->auth->isLoggedIn())
//        {
//            // se o usuario ja possui essa combinacao de carta, casa e setor, entao o custo eh zero
//            $cartaUsuario = array_shift($this->carta_casa_setor_valor->get(array(
//                'cod_carta' => $codCarta,
//                'cod_casa_carta' => $codCasa,
//                'cod_setor_vida' => $setorVida->cod_setor_vida,
//                'cod_usuario' => $this->auth->getUserId()
//            )));
//
//            if(is_null($cartaUsuario) == false)
//            {
//                // usuario ja possui essa combinacao, custo zero
//                return 0;
//            }
//        }

        // busca o custo padrao de cada carta-casa-setor
        $custoPadrao = $this->carta_casa_setor_valor->getCustoPadrao();

        /** @var Carta_Casa_Setor_Valor_model $custo */
        $custo = array_shift($this->carta_casa_setor_valor->get(array(
            'cod_setor_vida' => $setorVida->cod_setor_vida,
            'cod_casa_carta' => $codCasa,
            'cod_carta' => $codCarta
        )));

        if(is_null($custo))
        {
            return $custoPadrao;
        }else{
            return $custo->valor;
        }
    }

    public function checkCartaJaComprada($codCarta, $codCasa, $setorVida)
    {
        // se o usuario ja possui essa combinacao de carta, casa e setor, entao o custo eh zero
        $cartaUsuario = array_shift($this->carta_casa_setor_valor->get(array(
            'cod_carta' => $codCarta,
            'cod_casa_carta' => $codCasa,
            'cod_setor_vida' => $setorVida->cod_setor_vida,
            'cod_usuario' => $this->auth->getUserId()
        )));

        if(is_null($cartaUsuario) == false)
        {
            // usuario ja possui essa combinacao
            return true;
        }else{

            return false;
        }
    }
}
