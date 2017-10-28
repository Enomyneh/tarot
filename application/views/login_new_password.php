<div class="form">
    <form id="form" action="<?=site_url()?>/login/doNewPassword" method="POST">
        <span>E-mail: <?=$usuario->email?></span>
        <span>
            <input type="password" name="senha" placeholder="Senha">
            <span>No m&iacute;nimo 6 caracteres</span>
        </span>
        <span>
            <input type="password" name="senha_confirmar" placeholder="Confirmar senha">
        </span>
        <span class="tMargin20">
            <input class="greenButton" type="submit" value="Enviar" />
        </span>
        <input type="hidden" name="token" value="<?=$usuario->md5_ativacao?>" />
    </form>
</div>
<script>
$("document").ready(function(){
    
    // define o evento de submit do form
    $("input[type=submit]").click(function(evt){
        evt.preventDefault();
        
        // flag de validacao
        var valid = true;
        var errorMsgs = "";
        
        // valida a senha
        if(RegExp("^.{6,20}$").test($("input[name=senha]").val()) == false 
        || RegExp("^.{6,20}$").test($("input[name=senha_confirmar]").val()) == false
        || $("input[name=senha]").val() != $("input[name=senha_confirmar]").val() ){
             valid = false;
             errorMsgs += "Campo 'Senha' ou 'Confirmar senha' preenchido incorretamente \n";
        }
        
        if(!valid){
            alert(errorMsgs);
            return false;
        }
        
        // submita
        $("#form").submit();
    });
});
</script>