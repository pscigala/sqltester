<div id="reportadmin-cms-content" class="cms-content center cms-tabset $BaseCSSClasses" data-layout-type="border" data-pjax-fragment="Content">

    <div class="cms-content-header north">
        <div class="cms-content-header-info">
            <% include CMSBreadcrumbs %>
        </div>
    </div>

    <div class="cms-content-fields center ui-widget-content ui-tabs ui-tabs-panel" data-layout-type="border">

        $SQLTesterInputForm
        <button id="tables-list">Tables</button>
        <div class="sql-tester sql-table">
            $TestStatement
        </div>
    </div>

</div>

<style>
    .sql-tester form {
        max-width: 100%;
        width: 100%;
    }
    .sql-table table{
        width: 100%;
    }
    .sql-table table th,
    .sql-table table td{
        border: 1px solid #A0A0A0;
        padding: 3px;
    }

    .sql-table{
        clear: both;
    }
    #tables-list{
        float: right;
    }
    .CodeMirror{
        width: 100%;
        max-width: 100%;
        height: 150px;
    }
    .CodeMirror-hints{
        z-index: 100;
    }
    .CodeMirror pre {
        background: none;
        border: initial;
        font-size: 18px;
        font-family: Courier, monospace; 
        margin: initial; 
        padding:0px 0px 0px 10px;
        clear: initial; 
    }
</style>
<div id="sql-tester-dialog">
    <div class="sql-tester-tables-tree"></div>
</div>
<script>
    jQuery(document).ready(function () {


        var textArea = document.getElementById('Form_submit_SQLStatement');
        var editor = CodeMirror.fromTextArea(textArea, {
            mode: 'text/x-mysql',
            theme: 'ambiance',
            indentWithTabs: true,
            lineWrapping: true,
            smartIndent: true,
            lineNumbers: true,
            tabMode: 'indent',
            styleActiveLine: true,
            matchBrackets: true,
            autofocus: true,
            extraKeys: {"Ctrl-Space": "autocomplete"}
        });
        var charWidth = editor.defaultCharWidth(), basePadding = 4;
        editor.on("renderLine", function (cm, line, elt) {
            var off = CodeMirror.countColumn(line.text, null, cm.getOption("tabSize")) * charWidth;
            elt.style.textIndent = "-" + off + "px";
            elt.style.paddingLeft = (basePadding + off) + "px";
        });
        editor.refresh();
        jQuery('#tables-list').click(function () {
            var z;
            jQuery.ajax({
                url: '/~pscigii/silver/admin/sql-tester/getTablesJSON',
                async: false,
                dataType: 'json',
                error: function () {
                    alert('Error occured');
                },
                success: function (response) {
                    z = response;
                }});

            jQuery('#sql-tester-dialog').dialog({width: 800, resizable: true, height: 600});
            jQuery('.sql-tester-tables-tree').jstree({"plugins": [
                    "themes", "json_data", "ui"
                ],
                "json_data"
                        : {"data": z}}
            );


        });
    });
</script>