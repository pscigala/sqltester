<?php

class SQLTester extends Page {
    
}

class SQLTester_Controller extends Page_Controller {

    private static $allowed_actions = array('TestStatement', 'submit', 'SQLTesterInputForm');

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

        $inputFld = new TextareaField('SQLStatement', 'SQLStatement', $statement);
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

}

?>
