<?php

class budgetcapexdetail_c extends CI_Controller {

    private $back_to_manage = 'budget/capex_plan_temp_c/view_detail_capex_plan';

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/budgetcapexdetail_m');
        $this->load->model('budget/capex_plan_temp_m');
        $this->load->model('basis/log_m');
    }

    //save capex detail
    function add_revise() {
        $this->form_validation->set_rules('DEC_PRICE_PER_UNIT', 'Price Per Unit', 'required|trim');
        $no_budget = $this->input->post('INT_NO_BUDGET_CPX_TEMP');

        if ($this->form_validation->run() == FALSE) {
            $this->create_budgetcapex();
        } else {
            $data = array(
                'INT_NO_BUDGET_CPX_TEMP' => $no_budget,
                'INT_MONTH_PLAN' => $this->input->post('INT_MONTH_PLAN'),
                'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT'),
                'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
                'INT_REVISE' => $this->input->post('INT_REVISE'),
                'INT_APPROVE1' => 0,
                'INT_APPROVE2' => 0,
                'INT_APPROVE3' => 0
            );
            $this->budgetcapexdetail_m->save($data);

            $data_update = array(
                'INT_MONTH_PLAN' => $this->input->post('INT_MONTH_PLAN'),
                'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT'),
                'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
                'INT_REVISE' => $this->input->post('INT_REVISE'),
                'INT_APPROVE1' => 0,
                'INT_APPROVE2' => 0,
                'INT_APPROVE3' => 0
            );

            $this->capex_plan_temp_m->update($data_update, $no_budget);

            redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 1);
        }
    }

    function update_revise() {
        $no_budget = $this->input->post('INT_NO_BUDGET_CPX_TEMP');
        $revise = $this->input->post('INT_REVISE');

        $data = array(
            'INT_MONTH_PLAN' => $this->input->post('INT_MONTH_PLAN'),
            'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT'),
            'INT_QUANTITY' => $this->input->post('INT_QUANTITY')
        );


        $this->budgetcapexdetail_m->update($data, $no_budget, $revise);

        $data_update = array(
            'INT_MONTH_PLAN' => $this->input->post('INT_MONTH_PLAN'),
            'DEC_PRICE_PER_UNIT' => $this->input->post('DEC_PRICE_PER_UNIT'),
            'INT_QUANTITY' => $this->input->post('INT_QUANTITY'),
            'INT_REVISE' => $this->input->post('INT_REVISE')
        );

        $this->capex_plan_temp_m->update($data_update, $no_budget);

        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 2);
    }

//    function delete_budgetcapexdetail($id) {
//        $this->budgetcapexdetail_m->delete($id);
//        redirect($this->back_to_manage . $msg = 3);
//    }

//    function approve_by_manager($no_budget, $revise) {
//        $data = array(
//            'INT_APPROVE1' => 1
//        );
//        $this->budgetcapexdetail_m->update($data, $no_budget, $revise);
//
//        $this->capex_plan_temp_m->update($data, $no_budget);
//        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 2);
//    }

//    function approve_by_gm($no_budget, $revise) {
//        $data = array(
//            'INT_APPROVE2' => 1
//        );
//        $this->budgetcapexdetail_m->update($data, $no_budget, $revise);
//
//        $this->capex_plan_temp_m->update($data, $no_budget);
//        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 2);
//    }

//    function approve_by_director($no_budget, $revise, $qty) {
//        $data_capex = array(
//            'INT_APPROVE3' => 1
//        );
//        $this->capex_plan_temp_m->update($data_capex, $no_budget);
//        $data = array(
//            'INT_APPROVE3' => 1
//        );
//        $this->budgetcapexdetail_m->last_update_capex($data, $no_budget, $revise, $qty);
//
//        redirect('budget/capex_plan_c/index/' . $msg = 2);
//    }

//    function reject_by_manager($no_budget, $revise) {
//        $data = array(
//            'INT_APPROVE1' => 2
//        );
//
//        $this->budgetcapexdetail_m->update($data, $no_budget, $revise);
//
//        $this->capex_plan_temp_m->update($data, $no_budget);
//        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 2);
//    }

//    function reject_by_gm($no_budget, $revise) {
//        $data = array(
//            'INT_APPROVE2' => 2
//        );
//
//        $this->budgetcapexdetail_m->update($data, $no_budget, $revise);
//
//        $this->capex_plan_temp_m->update($data, $no_budget);
//        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 2);
//    }

//    function reject_by_director($no_budget, $revise) {
//        $data = array(
//            'INT_APPROVE3' => 2
//        );
//
//        $this->budgetcapexdetail_m->update($data, $no_budget, $revise);
//        $this->capex_plan_temp_m->update($data, $no_budget);
//        redirect($this->back_to_manage . '/' . $no_budget . '/' . $msg = 2);
//    }

}

?>
