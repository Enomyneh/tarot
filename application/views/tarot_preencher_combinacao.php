<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>
<div class="container">
    <form name="frm" action="<?=site_url()?>/tarot/doPreencherCombinacao" method="POST">
        <h1>Resumo</h1>
        <div class="clearfix">
            <div class="left">
                <p class="box">
                    <label>Arcano Maior</label>
                    <span><?=$arcanoMaior->nome_carta?></span>
                    <input type="hidden" name="arcano-maior" value="<?=$arcanoMaior->cod_carta?>"/>
                </p>
            </div>
            <div class="left">
                <p class="box">
                    <label>Arcano Menor 1</label>
                    <span><?=$arcanoMenor1->nome_carta?></span>
                    <input type="hidden" name="arcano-menor-1" value="<?=$arcanoMenor1->cod_carta?>"/>
                </p>
            </div>
            <div class="left">
                <p class="box">
                    <label>Arcano Menor 2</label>
                    <span><?=$arcanoMenor2->nome_carta?></span>
                    <input type="hidden" name="arcano-menor-2" value="<?=$arcanoMenor2->cod_carta?>"/>
                </p>
            </div>
            <div class="left">
                <p class="box cor-3">
                    <label>Tipo de jogo</label>
                    <span><?=$casaCarta->nome_grupo_casa_carta?></span>
                    <input type="hidden" name="grupo-casa-carta" value="<?=$casaCarta->cod_grupo_casa_carta?>"/>
                </p>
            </div>
            <div class="left">
                <p class="box cor-1">
                    <label>Setor da Vida</label>
                    <span><?=$setorVida->nome_setor_vida?></span>
                    <input type="hidden" name="setor-vida" value="<?=$setorVida->cod_setor_vida?>"/>
                </p>
            </div>
            <div class="left">
                <p class="box cor-2">
                    <label>Casa da Carta</label>
                    <span><?=$casaCarta->nome_casa_carta?></span>
                    <input type="hidden" name="casa-carta" value="<?=$casaCarta->cod_casa_carta?>"/>
                </p>
            </div>
        </div>
        <h1>Combinação</h1>
        <div class="box-padrao">
            <div class="clearfix fullWidth">
                <span class="left"><input class="button" type="button" onclick="javascript:history.back();" value="Voltar"/></span>
                <span class="right">
                    <input class="button" type="button" name="todas-casas-button" value="Salvar em todas as CASAS"/>
                    <input class="button" type="submit" value="Salvar"/>
                </span>
            </div>

            <div class="box-casa-carta">
                <textarea id="combinacao-texto" name="combinacao-texto" class="ckeditor"><?=@$combinacao->texto_combinacao?></textarea>
                <input type="hidden" name="combinacao-cod" value="<?=@$combinacao->cod_combinacao?>"/>
            </div>

            <div class="clearfix fullWidth">
                <span class="left"><input class="button" type="button" onclick="javascript:history.back();" value="Voltar"/></span>
                <span class="right">
                    <input class="button" type="button" name="todas-casas-button" value="Salvar em todas as CASAS"/>
                    <input class="button" type="submit" value="Salvar"/>
                </span>
            </div>
        </div>
        <input type="hidden" name="todas-casas" value="false"/>
    </form>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/plugins/ckeditor/ckeditor.js"></script>

<script>
$("document").ready(function(){
    $("input[name=todas-casas-button]").click(function(){
        // seta o input
        $("input[name=todas-casas]").val("true");
        
        // dispara o form
        $("form[name=frm]").submit();
    });
});

</script>

</body>
</html>