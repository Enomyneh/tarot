<!-- <h2>Conte&uacute;do</h2> -->

<div class="monografia">
	<div class="sumario">
		<span class="n1 ativo" detalhe="capa">In&iacute;cio</span>
		<? foreach($sumario["titulos"] as $titulo): ?>
			<? $sDetalhe = (isset($titulo["cod_detalhe"])) ? "detalhe='{$titulo['cod_detalhe']}'" : "" ?>
			<span <?= $sDetalhe ?> class="n1"><?= $titulo["titulo"] ?></span>
			<? foreach($sumario["sub_titulos"] as $subtitulo): ?>
				<? if($subtitulo["titulo"] == $titulo["titulo"]): ?>
					<? $sDetalhe = (isset($subtitulo["cod_detalhe"])) ? "detalhe='{$subtitulo['cod_detalhe']}'" : "" ?>
					<span <?= $sDetalhe?> class="n2"><?= $subtitulo["sub_titulo"] ?></span>
					<? foreach($sumario["detalhes"] as $detalhe): ?>
						<? if($detalhe["sub_titulo"] == $subtitulo["sub_titulo"]): ?>
							<? $sDetalhe = (isset($detalhe["cod_detalhe"])) ? "detalhe='{$detalhe['cod_detalhe']}'" : "" ?>
							<span class="n3" <?= $sDetalhe?>><?= $detalhe["detalhe"] ?></span>
						<? endif; ?>
					<? endforeach ?>
				<? endif; ?>
			<? endforeach; ?>
		<? endforeach; ?>
	</div>
	<div detalhe="capa" class="itens"><?= $monografia[0]->capa ?></div>
	<? foreach($monografia as $detalhe): ?>
		<div class="itens" style="display: none;" detalhe="<?= $detalhe->cod_detalhe ?>"><?= $detalhe->monografia ?></div>
	<? endforeach; ?>	
</div>

<div class="tMargin10">
	<a id="btnSubmit" class="newGreenButton" onclick="javascript:history.back();"><span>Voltar</span></a>
</div>
<script type="text/javascript">

$("span[detalhe]").click(function(){

	$("div.itens").fadeOut();

	var codDetalhe = $(this).attr("detalhe");

	$("div[detalhe="+codDetalhe+"]").fadeIn();

	$(".sumario span").removeClass("ativo");

	$(this).addClass("ativo");

});

</script>