<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
</head>
<body>

<div id="container">
    <h1>Escolha a combinacao:</h1>
    <div>
        <p>
            <label>Escolha o Arcano Maior:</label>
            <select name="arcano-maior">
                <? foreach($arcanosMaiores as $arcanoMaior): ?>
                    <option value="<?=$arcanoMaior->cod_carta?>"><?=$arcanoMaior->nome_carta?></option>
                <? endforeach; ?>
            </select>
        </p>
    </div>

    <div>
        <p>
            <label>Escolha o 1o Arcano Menor:</label>
            <select name="arcano-menor-1">
                <? foreach($arcanosMenores as $arcanoMenor): ?>
                    <option value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                <? endforeach; ?>
            </select>
        </p>
    </div>

    <div>
        <p>
            <label>Escolha o 2o Arcano Menor:</label>
            <select name="arcano-menor-2">
                <? foreach($arcanosMenores as $arcanoMenor): ?>
                    <option value="<?=$arcanoMenor->cod_carta?>"><?=$arcanoMenor->nome_carta?></option>
                <? endforeach; ?>
            </select>
        </p>
    </div>
</div>
<?=base_url()?>application/views/js/jquery-1.8.2.min.js
<!-- inclue os scripts -->
<script src="<?=base_url()?>application/views/js/jquery-1.8.2.min.js"></script>

<script>

$(document).ready(function(){
   
   // adiciona os eventos
   $("#container").find("select[name=arcano-menor-1],select[name=arcano-menor-2]").change(function(){
       alert($(this).val());
   });
});

</script>
    
</body>
</html>