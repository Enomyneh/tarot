<?php

/**
 * Class Carta_Casa_Setor_Valor_model
 *
 * @property CI_DB_active_record db
 */
class Carta_Casa_Setor_Valor_model extends CI_Model {

    public $cod;
    public $carta;
    public $setor;
    public $casa;
    public $valor;
    
    public function __construct($cod = null)
    {
        // construtor parent
        parent::__construct();
        
        // carrega a library
        $this->load->database();

        $this->load->model("casa_carta_model", "casa_carta");
        $this->load->model("setor_vida_model", "setor_vida");
        $this->load->model("carta_model", "carta");

        $this->cod = $cod;
    }
    
    public function getCustoPadrao()
    {
        $result = $this->db->select("c.tipo, c.custo")
                           ->from("custo c")
                           ->where("c.tipo", 'padrao_carta_casa_setor_valor')
                           ->get()->row();
        
        return $result->custo;
    }

    public function save(Carta_model $carta, Casa_Carta_model $casa, Setor_Vida_model $setor, $valor)
    {
        $data = array(
            'cod_carta' => $carta->cod,
            'cod_casa_carta' => $casa->cod,
            'cod_setor_vida' => $setor->cod,
            'valor' => $valor
        );

        $result = $this->db->select("c.cod_carta_casa_setor_valor")
                ->select("c.cod_carta")
                ->select("c.cod_casa_carta")
                ->select("c.cod_setor_vida")
                ->select("c.valor")
                ->from("carta_casa_setor_valor c")
                ->where("c.cod_carta", $carta->cod)
                ->where("c.cod_casa_carta", $casa->cod)
                ->where("c.cod_setor_vida", $setor->cod)
                ->get();

        if($result->num_rows() == 0)
        {
            $this->db->insert('carta_casa_setor_valor', $data);

        }else{

            $dbResult = $result->row();

            $codCartaCasaSetorValor = $dbResult->cod_carta_casa_setor_valor;

            $this->db->update('carta_casa_setor_valor', $data, array('cod_carta_casa_setor_valor' => $codCartaCasaSetorValor));
        }
    }

    public function get($options = array())
    {
        if(isset($options['codCasaCartaSetorValor']))
        {
            $this->db->where('c.cod_carta_casa_setor_valor', $options['codCasaCartaSetorValor']);
        }

        if(isset($options['cod_casa_carta']))
        {
            $this->db->where('c.cod_casa_carta', $options['cod_casa_carta']);
        }

        if(isset($options['cod_carta']))
        {
            $this->db->where('c.cod_carta', $options['cod_carta']);
        }

        if(isset($options['cod_setor_vida']))
        {
            $this->db->where('c.cod_setor_vida', $options['cod_setor_vida']);
        }

        if(isset($options['cod_usuario']))
        {
            $this->db->join('usuario_carta_casa_setor u', 'u.cod_carta = c.cod_carta 
                                                                   AND u.cod_casa_carta = c.cod_casa_carta
                                                                   AND u.cod_setor_vida = c.cod_setor_vida')
                ->where('u.cod_usuario', $options['cod_usuario']);
        }

        $result = $this->db->select("c.cod_carta_casa_setor_valor")
            ->select("c.cod_carta")
            ->select("c.cod_casa_carta")
            ->select("c.cod_setor_vida")
            ->select("c.valor")
            ->select("ca.nome_carta")
            ->select("sv.nome_setor_vida")
            ->select("cc.nome_casa_carta")
            ->from("carta_casa_setor_valor c")
            ->join("carta ca", "ca.cod_carta = c.cod_carta")
            ->join("setor_vida sv", "sv.cod_setor_vida = c.cod_setor_vida")
            ->join("casa_carta cc", "cc.cod_casa_carta = c.cod_casa_carta")
            ->order_by('ca.nome_carta, cc.nome_casa_carta, sv.nome_setor_vida')
            ->get();

        $data = array();

        foreach($result->result() as $row)
        {
            $cartaCasaSetorValor = new Carta_Casa_Setor_Valor_model($row->cod_carta_casa_setor_valor);

            $cartaCasaSetorValor->casa = new Casa_Carta_model($row->cod_casa_carta);
            $cartaCasaSetorValor->casa->nome = $row->nome_casa_carta;

            $cartaCasaSetorValor->carta = new Carta_model($row->cod_carta);
            $cartaCasaSetorValor->carta->nome = $row->nome_carta;

            $cartaCasaSetorValor->setor = new Setor_Vida_model($row->cod_setor_vida);
            $cartaCasaSetorValor->setor->nome = $row->nome_setor_vida;

            $cartaCasaSetorValor->valor = $row->valor;

            $data[] =  $cartaCasaSetorValor;
        }

        return $data;
    }
}