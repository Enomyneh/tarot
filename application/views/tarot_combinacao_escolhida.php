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
<h2>Descrição</h2>
<div>
	<p>Ação combinatória do Taro já interpretada com um leque de sugestões para interpretação desses três arcanos. Um alinhamento com muitas possibilidades entre essas cartas e o que elas podem representar. Essas variações estarão liberadas para a visualização, com a máxima abrangência para os dez setores da vida, tais como: Amoroso, Espiritual, Familiar, Terapêutico, Profissional, Financeiro, Sexualidade, Estudos e Meio social (Amigos), como indicado a seguir.</p>

	<p><b>Influência, Ativo e Passivo</b><br/>
	Esta analise interpretativa dá um esquema de analise com: Influencia ativo e passivo, com os significados coordenados a cada setor da vida pensando em suas posições de três cartas como: a influencia (o arcano maior), o ativo ( arcano menor) e passivo, outro arcano menor.</p>

	<p><b>Metodologia</b><br/>
	Esta combinação ficará disponível para todas as casas do jogo da cruz celta, podendo ser acessada a cada necessidade de se completar o jogo.</p>

	<p><b>Atualização</b><br/>
	Todas as combinações passarão por novas atualizações deixando cada combinação mais robusta, com mais informações, detalhes e maior precisão. Isso significa que comprar uma combinação agora você não pagará a atualização do conteúdo, porque as novas compras poderão sofrer alterações no preço conforme indicado nos termos de uso deste projeto.</p>
</div>
<h2 class="tMargin20">Valor</h2>
<div>
    <span class="valor">R$ <?=moeda($custo)?></span>
    <? $params = "?ama=".$arcanoMaior->cod_carta."&ame1=".$arcanoMenor1->cod_carta."&ame2=".$arcanoMenor2->cod_carta ?>
    <a class="greenButton lMargin20" href="<?=site_url()?>/compra/confirmar<?=$params?>">Comprar</a>
</div>