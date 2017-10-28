<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <!--<div class="mensagem">Monografia salva com sucesso!</div>-->
    <form action="<?=site_url();?>/monografia/doSave" method="POST">
        <h1>Preencha a monografia:</h1>
        <div>
            <label>Titulo:</label>
            <input type="text" name="titulo" size="100" value="<?=@$monografia->titulo?>" />
            <br/><br/>
        </div>
        <div>
            <label>Sub-Titulo:</label>
            <input type="text" name="sub-titulo" size="100" value="<?=@$monografia->sub_titulo?>" />
            <br/><br/>
        </div>
        <div>
            <label>Detalhe Sub-Titulo:</label>
            <input type="text" name="detalhe-sub-titulo" size="100" value="<?=@$monografia->detalhe_sub_titulo?>" />
            <br/><br/>
        </div>
        <div>
            <label>Pre&ccedil;o:</label>
            <input type="text" name="preco" value="<?=number_format(@$monografia->preco_monografia,2,",",".")?>" />
            <br/><br/>
        </div>
        <div>
            <label>Carta</label>
            <select name="carta">
                <option value="">Selecione</option>
                <? foreach($cartas as $carta): ?>
                    <? $selected = ($carta->cod_carta == @$monografia->cod_carta) ? " selected='selected'" : "" ?>
                    <option<?=$selected?> value="<?=$carta->cod_carta?>"><?=$carta->nome_carta?></option>
                <? endforeach; ?>
            </select>
            <br/><br/>
        </div>
        <div>
            <label>Titulo Geral</label>
            <input type="texto" name="titulo_geral" />
            <b>(NAO PREENCHER EM CASO DE MONOGRAFIA DE CARTA)</b>
            <br/><br/>
            OU ESCOLHA UM TITULO PARA ACRESCENTAR CONTEUDO:
            <select name="cod_monografia_titulo_geral">
                <option value="">Selecione</option>
                <? foreach($titulos as $titulo): ?>
                    <? $selected = ($titulo->cod_monografia == @$monografia->cod_monografia) ? "selected='selected'" : "" ?>
                    <option <?= $selected ?> value="<?= $titulo->cod_monografia?>#<?= $titulo->titulo_geral ?>"><?= $titulo->titulo_geral ?></option>
                <? endforeach; ?>
            </select>
            <br/><br/>
        </div>
        <div>
            <label>Tipo:</label>
            <br/>
            <? $checked = (@$monografia->tipo_monografia == "GRATIS") ? "checked='checked'" : "" ?>
            <input type="radio" <?= $checked ?> name="tipo_monografia" value="GRATIS" />
            <label>Gratis</label>
            <? $checked = (@$monografia->tipo_monografia == "PAGA") ? "checked='checked'" : "" ?>
            <input type="radio" <?= $checked ?> name="tipo_monografia" value="PAGA" />
            <label>Paga</label>
            <br/><br/>
        </div>

        <div style="width: 600px;">
            <div class="clearfix fullWidth">
                <span class="left"><input class="button" type="button" onclick="javascript:history.back();" value="Voltar"/></span>
                <span class="right"><input class="button" type="submit" value="Salvar"/></span>
            </div>
            <div>
                <label>Monografia:</label>
                <? if($capa):
                    $monografiaTexto = @$monografia->capa;
                else:
                    $monografiaTexto = @$monografia->monografia;
                endif; ?>
                <textarea id="monografia" name="monografia" class="ckeditor"><?=@$monografiaTexto?></textarea>
            </div>
            <div class="clearfix fullWidth">
                <span class="left"><input class="button" type="button" onclick="javascript:history.back();" value="Voltar"/></span>
                <span class="right"><input class="button" type="submit" value="Salvar"/></span>
            </div>
        </div>
        <input type="hidden" name="cod_monografia" value="<?=@$monografia->cod_monografia?>"/>
        <input type="hidden" name="cod_detalhe" value="<?=@$monografia->cod_detalhe?>"/>
    </form>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/plugins/ckeditor/ckeditor.js"></script>
    
</body>
</html>