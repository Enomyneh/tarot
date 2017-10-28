<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    
        <h1>Dados do Usu&aacute;rio</h1>

        <div class="title">
            <label>Nome: </label>
            <span><?= $login->nome?></span>
        </div>

        <div class="clearfix dados-form">
            <div>
                <label>E-mail: </label>
                <span><?=$login->email?></span>
            </div>
            <div>
                <label>Nascimento: </label>
                <span><?=mysql_to_br($login->data_nascimento, " ")?></span>
            </div>
            <div>
                <label>País: </label>
                <span><?=$login->pais?></span>
            </div>
            <div>
                <label>Estado: </label>
                <? if($login->cod_estado == "" || is_null($login->cod_estado)): ?>
                    <span><?= ($login->estado_outro == "") ? "N/D" : $login->estado_outro ?></span>
                <? else: ?>
                    <?=$login->estado?>
                <? endif; ?>
            </div>
            <div>
                <label>Cidade: </label>
                <? if($login->cod_cidade == "" || is_null($login->cod_cidade)): ?>
                    <span><?= ($login->cidade_outro == "") ? "N/D" : $login->cidade_outro ?></span>
                <? else: ?>
                    <?=$login->cidade?>
                <? endif; ?>
            </div>
            <div>
                <label>Telefone: </label>
                <span><?=$login->ddi?> - <?=$login->ddd?> - <?=$login->telefone?></span>
            </div>
            <div>
                <label>Compras: </label>
                <span><?=($loginResumo->qtde_compras) ? $loginResumo->qtde_compras : "-"?></span>
            </div>
            <div>
                <label>&Uacute;ltima: </label>
                <span><?=(mysql_to_br($loginResumo->ultima_compra)) ? mysql_to_br($loginResumo->ultima_compra) : "-"?></span>
            </div>
            <div>
                <label>Combina&ccedil;&otilde;es: </label>
                <span><?=$loginResumo->qtde_combinacoes?></span>
            </div>
            <div>
                <label>Última: </label>
                <span><?=(mysql_to_br($loginResumo->ultima_combinacao)) ? mysql_to_br($loginResumo->ultima_combinacao) : "-" ?></span>
            </div>
            <div>
                <label>Jogos: </label>
                <span><?=$loginResumo->qtde_jogos?></span>
            </div>
            <div>
                <label>Último: </label>
                <span><?=(mysql_to_br($loginResumo->ultimo_jogo)) ? mysql_to_br($loginResumo->ultimo_jogo) : "-"?></span>
            </div>
            <div>
                <label>Monografias: </label>
                <span><?=$loginResumo->qtde_monografias?></span>
            </div>
            <div>
                <label>Última: </label>
                <span><?=(mysql_to_br($loginResumo->ultima_monografia)) ? mysql_to_br($loginResumo->ultima_monografia) : "-"?></span>
            </div>
        </div>

        <h1>Crédito</h1>

        <form id="frm" action="<?=site_url()?>/conta/doIncluirCredito" method="POST">
            <div class="clearfix dados-form">
                <div>
                    <label>Saldo: </label>
                    <span>R$ <?=moeda($loginResumo->saldo)?></span>
                </div>
                <div><label></label><span></span></div>
                <div>
                    <label>Incluir cr&eacute;dito: </label>
                    <span>
                        <input name="credito" type="text"/>
                        <input type="submit" class="button" value="Gravar"/>
                    </span>
                </div>
                <input type="hidden" name="cod_usuario" value="<?=$login->cod?>"/>
            </div>
        </form>
        
        <? $texto = "" ?>
        <? if(count($jogos) == $limit): ?>
            <? $texto = " - &uacute;ltimos ".$limit." mapas" ?>
        <? endif; ?>

        <h1>Mapeamentos<?=$texto?></h1>

        <table width="100%" class="table" cellpadding="3" cellspacing="0">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Setor da Vida</th>
                    <th>Data</th>
                    <th>Ver Mapa</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($jogos as $jogo): ?>
                    <tr>
                        <td>
                            <? if($jogo->titulo == "" || is_null($jogo->titulo)): ?>
                                Sem t&iacute;tulo
                            <? else: ?>
                                <?=$jogo->titulo?>
                            <? endif; ?>
                        </td>
                        <td><?=$jogo->nome_setor_vida?></td>
                        <td align="center"><?=mysql_to_br($jogo->data_cadastro)?></td>
                        <td align="center"><a href="<?=site_url()?>/jogo/resultado/token/<?=$jogo->token?>" target="_blank">VER</a></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>

        <? $texto = "" ?>
        <? if(count($combinacoes) == $limit): ?>
            <? $texto = " - &uacute;ltimas ".$limit." combina&ccedil;&otilde;es" ?>
        <? endif; ?>

        <h1>Combina&ccedil;&otilde;es<?=$texto?></h1>

        <table width="100%" class="table" cellpadding="3" cellspacing="0">
            <thead>
                <tr>
                    <th>Arcano Maior</th>
                    <th>Arcano Menor 1</th>
                    <th>Arcano Menor 2</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <? foreach($combinacoes as $combinacao): ?>
                    <tr>
                        <td><?=$combinacao->nome_arcano_maior?></td>
                        <td><?=$combinacao->nome_arcano_menor_1?></td>
                        <td><?=$combinacao->nome_arcano_menor_2?></td>
                        <td align="center"><?=mysql_to_br($combinacao->data_compra_combinacao)?></td>
                    </tr>
                <? endforeach; ?>
            </tbody>
        </table>
        
        <br/><br/>
        
        <a href="<?=site_url()?>/conta/verUsuarios">Voltar</a>

        <br/><br/>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-migrate-1.1.1.min.js"></script>
    
</body>
</html>