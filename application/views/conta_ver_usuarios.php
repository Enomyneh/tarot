<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<h1>Usu&aacute;rios</h1>

<form action="<?=site_url()?>/conta/verUsuarios" method="POST">
    <div>
        <label>Filtrar: </label>
        <input type="text" size="40" name="busca" />
        <input type="submit" value="Buscar" />
        <br/><br/>
        <span>Total de Usu&aacute;rios cadastrados: <?=$totalUsuarios?></span>
    </div>
    <br/>
</form>


<div class="container" style="width: 100%">
    <!--<div class="mensagem">Monografia salva com sucesso!</div>-->
    <h1>Visualiza&ccedil;&atilde;o Geral:</h1>
    <br/>
    <table width="99%" class="table" cellpadding="3" cellspacing="0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Saldo</th>
                <th>Jogos<br/>[ultimo]</th>
                <th>Compras<br/>[ultima]</th>
                <th>Combinações<br/>[ultima]</th>
                <th>Monografias<br/>[ultima]</th>
                <th>A&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($logins as $login): ?>
                <tr>
                    <td><?=$login->nome?></td>
                    <td align="center"><?=$login->email?></td>
                    <td><?=number_format($login->saldo, 2, ",", ".")?></td>
                    <td align="center">
                        <? if($login->qtde_jogos > 0): ?>
                            <?= $login->qtde_jogos?><br/>[<?= mysql_to_br($login->ultimo_jogo, "H:i") ?>]
                        <? else: ?>
                            Nenhum
                        <? endif; ?>
                    </td>
                    <td align="center">
                        <? if($login->qtde_compras > 0): ?>
                            <?= $login->qtde_compras?><br/>[<?= mysql_to_br($login->ultima_compra, "H:i")?>]
                        <? else: ?>
                            Nenhum
                        <? endif; ?>
                    </td>
                    <td align="center">
                        <? if($login->qtde_combinacoes > 0): ?>
                            <?= $login->qtde_combinacoes?><br/>[<?= mysql_to_br($login->ultima_combinacao, "H:i")?>]
                        <? else: ?>
                            Nenhum
                        <? endif; ?>
                    </td>
                    <td align="center">
                        <? if($login->qtde_monografias > 0): ?>
                            <?= $login->qtde_monografias?><br/>[<?= mysql_to_br($login->ultima_monografia, "H:i")?>]
                        <? else: ?>
                            Nenhum
                        <? endif; ?>
                    </td>
                    <td align="center"><a href="<?=site_url()?>/conta/verUsuario?u=<?=$login->cod?>">Ver</a></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
    <br/><br/>
    <a href="<?=site_url()?>/tarot">Voltar</a>
    <br/><br/><br/><br/>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script src="<?=base_url()?>assets/js/jquery-migrate-1.1.1.min.js"></script>
    
</body>
</html>