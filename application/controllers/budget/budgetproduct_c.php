<?php

class budgetproduct_c extends CI_Controller {

    private $back_to_manage = 'budget/capex_plan_temp_c/view_detail_capex_plan';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budgetproduct_m');
    }

    function delete_budgetproduct($id, $no_budget) {
        $this->budgetproduct_m->delete($id, $no_budget);
        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 3);
    }

    function save_budgetproduct() {
        $product = $this->input->post('INT_ID_PRODUCT');
        $no_budget = $this->input->post('INT_NO_BUDGET_CPX_TEMP');
        $session = $this->session->all_userdata();

        if ($product != NULL) {
            for ($i = 0; $i < count($product); $i++) {
                $this->budgetproduct_m->prepare_save($product[$i], $no_budget, $session['USERNAME']);
            }
            redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 1);
        }
        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 5);
    }

}

?>
