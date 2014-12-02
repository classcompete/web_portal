<!-- Load jQuery build -->
<script type="text/javascript" src="/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript">
    jQuery(function() {
        jQuery('textarea.tinymce').tinymce({
            // Location of TinyMCE script
            script_url : '/tinymce/tiny_mce_gzip.php',
            //mode:"specific_textareas",
            //editor_selector:"theEditor",
            width:"100%",
            theme:"advanced",
            skin:"wp_theme",
            // General options
            //plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",
            plugins:"safari,inlinepopups,spellchecker,paste,media,fullscreen,tabfocus,template,filemanager",

            // Theme options
            theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,bullist,numlist,blockquote,hr,|,justifyleft,justifycenter,justifyright,justifyfull,pastetext,pasteword,|,link,unlink,code",
            theme_advanced_buttons2 : "undo,redo,formatselect,fontselect,forecolor,|,removeformat,|,media,charmap,|,outdent,indent,|,image,insertfile",
            theme_advanced_buttons3 : "",
            theme_advanced_buttons4 : "",
            //theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
            //theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,forecolor,backcolor",
            //theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
            //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
            theme_advanced_toolbar_location : "top",
            //theme_advanced_toolbar_align : "left",
            //theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : true,

            // Example content CSS (should be your site CSS)
            //content_css : "css/example.css",
            filemanager_remember_last_path : false,
            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",

            doctype : "<!DOCTYPE html>",

            convert_urls : false,

            valid_elements : "@[id|class|style|title|lang|xml::lang],"
                + "a[rel|rev|charset|hreflang|tabindex|accesskey|type|"
                + "name|href|target|title|class],strong/b,em/i,strike,u,"
                + "#p[style],-ol[type|compact],-ul[type|compact],-li,br,img[longdesc|usemap|"
                + "src|border|alt=|title|hspace|vspace|width|height|align],-sub,-sup,"
                + "-blockquote,-table[border=0|cellspacing|cellpadding|width|frame|rules|"
                + "height|align|summary|bgcolor|background|bordercolor],-tr[rowspan|width|"
                + "height|align|valign|bgcolor|background|bordercolor],tbody,thead,tfoot,"
                + "#td[colspan|rowspan|width|height|align|valign|bgcolor|background|bordercolor"
                + "|scope],#th[colspan|rowspan|width|height|align|valign|scope],caption,-div,"
                + "-span,-code,-pre,address,-h1,-h2,-h3,-h4,-h5,-h6,hr[size|noshade],-font[face"
                + "|size|color],dd,dl,dt,cite,abbr,acronym,del[datetime|cite],ins[datetime|cite],"
                + "object[classid|width|height|codebase|*],param[name|value|_value],embed[type|width"
                + "|height|src|*],map[name],area[shape|coords|href|alt|target],bdo,"
                + "button,col[align|char|charoff|span|valign|width],colgroup[align|char|charoff|span|"
                + "valign|width],dfn,fieldset,form[action|accept|accept-charset|enctype|method],"
                + "input[accept|alt|checked|disabled|maxlength|name|readonly|size|src|type|value],"
                + "kbd,label[for],legend,noscript,optgroup[label|disabled],option[disabled|label|selected|value],"
                + "q[cite],samp,select[disabled|multiple|name|size],small,"
                + "textarea[cols|rows|disabled|name|readonly],tt,var,big",

            extended_valid_elements : "p[style|class]",
            inline_styles : true,
            verify_html : false

            // Replace values for the template plugin
            /*template_replace_values : {
                username : "Some User",
                staffid : "991234"
            }*/
        });
    });
</script>
<style type="text/css">
    .mceEditor{display: inline-block;}
    #main-content table td,#main-content table th {
        padding: 0px;
    }

    #main-content table {
        width: auto;
    }

    #menu_page_content_page_content_formatselect_menu_tbl {
        background-color: #FFF;
        color: #000;
    }

    .mceFirst {
        color: #000 !important;
    }

    #page_content_formatselect,#page_content_formatselect_text,#mce_formatPreview mce_p
    {
        color: #000;
    }

    #page_content_tbl {
        border: 1px solid #D5D5D5;
        -moz-border-radius: 4px 4px 4px 4px;
    }

    .mceButton {
        margin: 5px !important;
        border-color: #D5D5D5 !important;
    }

    .mceOpen,.mceText,.mceAction {
        border-color: #D5D5D5 !important;
    }
    .wp_themeSkin table.mceLayout
    {
        border: 1px solid #DDD;
    }
    .wp_themeSkin .mceToolbar {
        border-bottom: 1px solid #DDD;
    }
    body.mcecontentbody {
        font-family: verdana;
    }
</style>
