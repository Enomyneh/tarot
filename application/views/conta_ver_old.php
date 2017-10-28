<h2>Meus Mapeamentos</h2>
<div>
    <table class="default">
        <thead>
            <tr>
                <th>Jogo</th>
                <th>Data</th>
                <th>Setor Vida</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($jogosCompletos as $key => $jogo): ?>
                <tr>
                    <td>Jogo <?=($key+1)?></td>
                    <td><?=mysql_to_br($jogo["data"])?></td>
                    <td><?=$jogo["setor_vida"]->nome_setor_vida?></td>
                    <td><a href="<?=site_url()?>/jogo/resultado/<?=$jogo["url"]->url?>">Clique aqui</a></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>
<h2>Minhas Combinações</h2>
<div>
    <table class="default">
        <thead>
            <tr>
                <th>Arcano Maior</th>
                <th>Arcano Menor 1</th>
                <th>Arcano Menor 2</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($combinacoes as $combinacao): ?>
                <tr>
                    <td><?=$combinacao->nome_arcano_maior?></td>
                    <td><?=$combinacao->nome_arcano_menor_1?></td>
                    <td><?=$combinacao->nome_arcano_menor_2?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>
<h2>Minhas monografias</h2>
<div>
    <table class="default">
        <thead>
            <tr>
                <th>Titulo</th>
                <th width="15%">A&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($monografias as $monografia): ?>
                <tr>
                    <td><?=$monografia->titulo_monografia?></td>
                    <td>
                        <a href="<?=site_url()?>/monografia/ver?m=<?=$monografia->cod_monografia?>">Visualizar</a>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>
<h2>Extrato</h2>
<div>
    <table class="default">
        <thead>
            <tr>
                <th>Data</th>
                <th>Descrição</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($extrato as $linha): ?>
                <tr>
                    <td><?= mysql_to_br($linha->data) ?></td>
                    <td><?= $linha->descricao ?></td>
                    <td>R$ <?= moeda($linha->valor)?></td>
                </tr>
            <? endforeach; ?>
            <tr>
                <td colspan="2">Saldo</td>
                <td>R$ <?=moeda($saldo)?></td>
            </tr>
        </tbody>
    </table>
</div>