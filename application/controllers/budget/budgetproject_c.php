<?php

class budgetproject_c extends CI_Controller {

    private $back_to_manage = 'budget/capex_plan_temp_c/view_detail_capex_plan';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budgetproject_m');

    }

    function delete_budgetproject($id, $no_budget) {
        $this->budgetproject_m->delete($id, $no_budget);
        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 3);
    }

    function save_budgetproject() {
        $project = $this->input->post('INT_ID_PROJECT');
        $no_budget = $this->input->post('INT_NO_BUDGET_CPX_TEMP');
        $session = $this->session->all_userdata();

        if ($project != NULL) {
            for ($i = 0; $i < count($project); $i++) {
                $this->budgetproject_m->prepare_save($project[$i], $no_budget, $session['USERNAME']);
            }
            redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 1);
        }
        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 5);
    }

}

?>
