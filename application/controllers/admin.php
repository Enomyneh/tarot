<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Class Admin
 *
 * @property Auth auth
 * @property Carta_Casa_Setor_Valor_model carta_casa_setor_valor
 *
 */
class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // checa se eh admin
        if($this->auth->checkAdmin(NO_REDIRECT) == false)
        {
            redirect('/jogo/escolherSetorVida');
        }
    }

    public function index(){
        
        redirect('tarot/index');
        
    }
    
    public function precosCartas()
    {
        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");

        $cartasCasasSetoresValores = $this->carta_casa_setor_valor->get();

        $this->load->view('admin_precos_cartas', array(
            'cartasCasasSetoresValores' => $cartasCasasSetoresValores
        ));
    }

    public function precoCartaEditar($codCartaCasaSetorValor)
    {
        $this->load->model("carta_casa_setor_valor_model", "carta_casa_setor_valor");

        $cartaCasaSetorValor = array_shift($this->carta_casa_setor_valor->get(array(
           'codCartaCasaSetorValor' => $codCartaCasaSetorValor
        )));

        $this->load->view('admin_preco_carta_editar', array(
           'cartaCasaSetorValor' => $cartaCasaSetorValor
        ));
    }

}

?>