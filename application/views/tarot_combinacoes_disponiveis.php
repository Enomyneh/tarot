<div>
    <table class="default">
        <thead>
            <tr>
                <th>Arcano Maior</th>
                <th>Arcano Menor 1</th>
                <th>Arcano Menor 2</th>
                <th>Opera&ccedil;&otilde;es</th>
            </tr>
        </thead>
        <tbody>
            <? foreach($combinacoesDisponiveis as $combinacaoDisponivel): ?>
                <tr>
                    <td><?=$combinacaoDisponivel->arcanoMaiorNome?></td>
                    <td><?=$combinacaoDisponivel->arcanoMenor1Nome?></td>
                    <td><?=$combinacaoDisponivel->arcanoMenor2Nome?></td>
                    <td>
                        <? if(@$combinacaoDisponivel->jaComprada): ?>
                            Comprada
                        <? else: ?>
                            <?
                                // monta a url do get que ira no link
                                $get = "?am=".$combinacaoDisponivel->arcanoMaiorCod.
                                        "&ame1=".$combinacaoDisponivel->arcanoMenor1Cod.
                                        "&ame2=".$combinacaoDisponivel->arcanoMenor2Cod;
                            ?>
                            <a href="<?=site_url()?>/tarot/combinacaoEscolhida<?=$get?>">
                                Visualizar
                            </a>
                        <? endif; ?>
                    </td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>