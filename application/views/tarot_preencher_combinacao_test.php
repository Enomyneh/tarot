<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Tarot</title>
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/css/style.css" />
</head>
<body>
<div id="container" class="box-padrao">
    <form action="<?=site_url()?>/tarot/doPreencherCombinacao" method="POST">
        <textarea id="test" name="combinacao-texto"><?=@$combinacao->texto_combinacao?></textarea>
        <input type="hidden" name="combinacao-cod" value="<?=@$combinacao->cod_combinacao?>"/>
    </form>
</div>

<!-- inclue os scripts -->
<script src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>

<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.colors.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.styles.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.syntax.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/xhtml.js" type="text/javascript"></script>
<script language="Javascript" src="<?=base_url()?>assets/js/plugins/htmlbox/htmlbox.min.js" type="text/javascript"></script>

<script>

// define o base_url
var BASE_URL = '<?=base_url();?>';

$(document).ready(function(){
    
   // inicia o html_box do textarea
   initHtmlBox();
   
});

function initHtmlBox(){
    $("#test").css("height","400px").css("width","600px").htmlbox({
        skin    : "blue",
        idir    : BASE_URL+"/assets/js/plugins/htmlbox/images/",
        icons   : "silk",
        toolbars:[
            [
                // Cut, Copy, Paste
                "separator","cut","copy","paste",
                // Undo, Redo
                "separator","undo","redo",
                // Bold, Italic, Underline, Strikethrough, Sup, Sub
                "separator","bold","italic","underline","strike","sup","sub",
                // Left, Right, Center, Justify
                "separator","justify","left","center","right",
                // Ordered List, Unordered List, Indent, Outdent
                "separator","ol","ul","indent","outdent",
                // Hyperlink, Remove Hyperlink, Image
                "separator","link","unlink","image"
            ],
            [// Show code
                "separator","code",
                // Formats, Font size, Font family, Font color, Font, Background
                "separator","formats","fontsize","fontfamily",
                "separator","fontcolor","highlight",
            ],
            [
                //Strip tags
                "separator","removeformat","striptags","hr","paragraph",
                // Styles, Source code syntax buttons
                "separator","quote","styles","syntax"
            ]
        ]
    });
}

</script>
    
</body>
</html>