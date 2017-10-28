<div>
    <? if(count($monografias) == 0): ?>
        <h2>N&atilde;o h&aacute; monografias dispon&iacute;veis</h2>
    <? else: ?>
        <table class="default">
            <thead>
                <tr>
                    <th>Arcano</th>
                    <th width="15%">Opera&ccedil;&otilde;es</th>
                </tr>
            </thead>
            <tbody>
                <? $cartaAtual = null; ?>
                <? foreach($monografias as $monografia): ?>
                    <? if($cartaAtual != $monografia->cod_carta): ?>
                        <? $cartaAtual = $monografia->cod_carta ?>
                        <tr>
                            <td><?=$monografia->nome_carta?></td>
                            <td>
                                <a href="<?=site_url()?>/monografia/ver?m=<?=$monografia->cod_monografia?>">Visualizar</a>
                            </td>
                        </tr>
                    <? endif; ?>
                <? endforeach; ?>
            </tbody>
        </table>
    <? endif; ?>
</div>