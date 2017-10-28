<? 

if(is_numeric($codUsuarioCombinacao) && $codUsuarioCombinacao > 0){

    $textoBotao = "Escolher Casa";
    $margem     = "38%";
    $link       = site_url()."/jogo/escolherCasaCarta?sv=".$setorVida->cod_setor_vida."&cuc=".$codUsuarioCombinacao;

}else{

    $link = site_url()."/jogo/escolherCartas?sv=".$setorVida->cod_setor_vida ."&p=". $profissional;

    if($profissional == 1){
        $textoBotao = "Montar Jogo";
        $margem     = "43%";
    }else{
        $textoBotao = "Amostra Virtual Grátis";
        $margem     = "39%";
    }
}
    

?>
<div class="tMargin20 adsense-like">
    <? $this->load->view("jogo_ver_setor_".$setorVida->cod_setor_vida, array(
        "margem"        => $margem,
        "link"          => $link,
        "textoBotao"    => $textoBotao
    )) ?>
</div>