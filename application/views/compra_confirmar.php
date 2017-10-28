<h2>Cartas</h2>
<div class="tCenter">
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$arcanoMaior->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$arcanoMaior->nome_carta?></span>
    </span>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$arcanoMenor1->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$arcanoMenor1->nome_carta?></span>
    </span>
    <span class="img-carta">
        <img src="<?=base_url()?>assets/images/cartas/<?=$arcanoMenor2->cod_carta?>.jpg" width="150" height="262"/>
        <span><?=$arcanoMenor2->nome_carta?></span>
    </span>
</div>
<h2>Confirmar Compra</h2>
<div>
    <p>Tem certeza que deseja confirmar a compra da combinação acima?</p>
    <? $params = "?ama=".$arcanoMaior->cod_carta."&ame1=".$arcanoMenor1->cod_carta."&ame2=".$arcanoMenor2->cod_carta ?>
    <p>Sim, debitar R$ <?=moeda($custo)?> do meu saldo de R$ <?=moeda($this->auth->getData("saldo"));?></p>
    <div class="clearfix lMargin20 tMargin10">
        <a href="<?=site_url()?>/compra/doConfirmar<?=$params?>" class="newGreenButton escolher"><span>Comprar</span></a>
    </div>
    <div>
        <br/>
        <h2 class="red">Importante!</h2>
        <p><a target="_blank" href="http://www.oracvlvm.com/index.php/atualizacoes/">Você está adquirindo a versão 1.0. Saiba mais</a></p>
        <p><a target="_blank" href="http://www.oracvlvm.com/index.php/about-2/arquitetura-do-site/">Antes de fazer a aquisição leia os termos de uso</a></p>
    </div>
    <div class="tMargin30">
        <a href="javascript:void()" onclick="javascript:history.go(-1);"><< Voltar</a>
    </div>
</div>