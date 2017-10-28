<style type="text/css">
  #container {
    width: 670px;
    height: 60px;
    position: relative;
  }
  #wrapper > #container {
    display: table;
    position: static;
  }
  #container div {
    position: absolute;
    top: 50%;
  }
  #container div div {
    position: relative;
    top: -50%;
  }
  #container > div {
    display: table-cell;
    vertical-align: top;
    position: static;
  }
</style>
<form id="form" action="<?=site_url()?>/login/doSigninUsuarioLite" method="POST">

    <div id="wrapper">
      <div id="container">
        <div><div><img width="330" height="350" src="<?=base_url()?>/assets/images/projeto-oracvlvm.jpg"/></div></div>
        <div>
            <div style="padding-left: 25px;">
                <h2>Preencha os dados abaixo para continuar</h2>

                <span><input type="text" name="email" placeholder="E-mail"></span>

                <? if($cadastroFull): ?>
                    <span><input type="text" name="nome" placeholder="Nome"></span>

                    <span><input type="text" name="data_nascimento" placeholder="Data de Nascimento"></span>
                <? endif; ?>

                <div class="clearfix tMargin20">
                    <a class="newGreenButton submit"><span>Continuar</span></a>
                    <button type="submit" class="hidden" />
                </div>
            </div>
        </div>
      </div>
    </div>
</form>
<script type='text/javascript' src='<?=base_url()?>assets/js/plugins/jquery.maskedinput.min.js'></script>
<script>

var CADASTRO_FULL = <?= ($cadastroFull) ? "'true';" : "'false';" ?>

$(document).ready(function(){
    $("a.submit").click(function(){

        // flag de validacao
        var valid = true;
        
        // variavel de mensagens de erro
        var errorMsgs = "";
        
        // valida o nome completo
        if(RegExp("^.{3,80}$").test($("input[name=nome]").val()) == false){
            valid = false;
            errorMsgs += "Campo 'Nome' preenchido incorretamente \n";
        }
        if(CADASTRO_FULL == "true"){
            // valida o nascimento
            if(RegExp("(0[1-9]|[012][0-9]|3[01])/(0[1-9]|1[012])/[12][0-9]{3}")
                .test($("input[name=data_nascimento]").val()) == false){
                valid = false;
                errorMsgs += "Campo 'Data de Nascimento' preenchido incorretamente \n";
            }
            // valida o email
            if(RegExp("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$")
                .test($("input[name=email]").val()) == false){
                valid = false;
                errorMsgs += "Campo 'E-mail' preenchido incorretamente \n";
            }            
        }
        
        if(!valid){
            alert(errorMsgs);
            return false;
        }

        $("form").submit();
    });

    $("input[name=data_nascimento]").mask("99/99/9999");
});
</script>

