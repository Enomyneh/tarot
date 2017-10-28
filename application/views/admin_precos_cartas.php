<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>

<div class="container">
    <div class="mensagem">Combina&ccedil;&atilde;o salva como dispon&iacute;vel!</div>

    <table width="99%" class="table" cellpadding="3" cellspacing="0">
        <thead>
            <tr>
                <th>Carta</th>
                <th>Casa</th>
                <th>Setor</th>
                <th>Valor</th>
                <th>Alterar</th>
            </tr>
        </thead>
        <tbody>
            <?
                /** @var Carta_Casa_Setor_Valor_model $cartaCasaSetorValor */
                foreach($cartasCasasSetoresValores as $key => $cartaCasaSetorValor):
            ?>
                <tr class="<?= ($key % 2 == 0) ? 'odd' : 'even' ?>">
                    <td><?= $cartaCasaSetorValor->carta->nome ?></td>
                    <td><?= $cartaCasaSetorValor->casa->nome ?></td>
                    <td><?= $cartaCasaSetorValor->setor->nome ?></td>
                    <td>R$ <?= moeda($cartaCasaSetorValor->valor) ?></td>
                    <td>
                        <a href="<?= site_url()?>/admin/precoCartaEditar/<?= $cartaCasaSetorValor->cod ?>">Alterar</a>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>

    <br/><br/>
    <a href="<?= site_url() ?>/admin">VOLTAR</a>
</div>
    
</body>
</html>