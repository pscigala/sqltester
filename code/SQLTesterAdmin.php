<?php

//class SQLTester extends Page {
//    
//}

class SQLTesterAdmin extends LeftAndMain {

//    private static $managed_models = array('SQL Tester', 'SQL Tester'); // Can manage multiple models
    private static $url_segment = 'sql-tester'; // Linked as /admin/products/
    private static $menu_title = 'SQL Tester';
    private static $allowed_actions = array('TestStatement', 'submit', 'SQLTesterInputForm','getTablesJSON');

    public function EditForm($request = null) {
        return null;
    }

    public function EditorToolbar() {
        return 'asd';
    }

//    public function EditFormTools() {
//        return null;
//    }
//    public function ImportForm() {
//        return false;
//    }
//    public function init() {
//        parent::init();
//    }
//
//    private static $allowed_actions = array('TestStatement', 'submit', 'SQLTesterInputForm');
//
    public function init() {
        parent::init();
        Requirements::css(project() . "/templates/javascript/codemirror/addon/hint/show-hint.css");
        Requirements::css(project() . "/templates/javascript/codemirror/codemirror.css");
        Requirements::css(project() . "/templates/javascript/codemirror/theme/ambiance.css");
        Requirements::javascript(project() . "/templates/javascript/codemirror/codemirror.js");
        Requirements::javascript(project() . "/templates/javascript/codemirror/mode/sql/sql.js");
        Requirements::javascript(project() . "/templates/javascript/codemirror/addon/hint/show-hint.js");
        Requirements::javascript(project() . "/templates/javascript/codemirror/addon/hint/sql-hint.js");

        if (!Permission::check("ADMIN")) {
            Security::permissionFailure();
        }
    }

    public function SQLTesterInputForm() {
        $statement = "";
        if (isset($this->requestParams['statement'])) {
            $statement = base64_decode($this->requestParams['statement']);
        }

        $inputFld = new TextareaField('SQLStatement', '', $statement);
        $fields = new FieldList($inputFld);

        $actions = new FieldList(
                new FormAction('submit', 'submit')
        );

        $form = new Form($this, 'submit', $fields, $actions);
        return $form;
    }

    public function submit($data) {
        $backURL = $this->Link("?statement=" . base64_encode($data['SQLStatement']));
        $this->redirect($backURL);
    }

    public function TestStatement() {
        if (isset($this->requestParams['statement'])) {
            $statement = $this->requestParams['statement'];

            $result = DB::query(base64_decode($statement));
            $resultHTML = "";
            $resultHTML.='<h3>Rows: ' . $result->numRecords() . '</h3>';

            $resultHTML.=$result->table();

            return $resultHTML;
        }
    }

    public function getTablesList() {
        $tables = DB::tableList();

        $html = '<h3>Tables list</h3><ul>';
        foreach ($tables as $table) {
            $html.='<li>' . $table . '</li>';
        }
        $html.='</ul>';
        return $html;
    }

    public function getTablesJSON() {
        $tables = DB::tableList();
        $tablesStructure =array('data'=>array());
        $tabObj = array();
        $id = 0;
        foreach ($tables as $table) {
//            $tabObj['id'] = 'tab' . $id;
            $tabObj['id'] = '5';
            $tabObj['parent'] = '#';
//            $tabObj['text'] = $table;
            $tabObj['title'] = $table;
            $tabObj['position'] = $id;

            $id++;
            
            array_push($tablesStructure['data'], $tabObj);
        }
        return Convert::array2json($tablesStructure);
    }

//    
//    public function Content() {
////        return 'sad';
//        $this->renderWith('SQLTester');
//        return parent::Content();
//    }
//
//    public function Tools() {
//        return parent::Tools();
//    }
//
}

?>
