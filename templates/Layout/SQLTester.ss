<% include SideBar %>
<div class="content-container unit size3of4 lastUnit sql-tester">
    <article>
        <button id="tables-list">Tables</button>
        <h1>$Title</h1>
        <div class="content">
            $Content
        </div>
        <div class="clearfix">
            $SQLTesterInputForm
            <div class="sql-tester sql-table">
                $TestStatement
            </div>
        </div>
    </article>
    $Form
    $PageComments
</div>
<style>
    .sql-tester form {
        max-width: 100%;
        width: 100%;
    }
    .sql-table table{
        width: 100%;
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
<script>
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
</script>