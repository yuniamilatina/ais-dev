<?php

class dept_expense_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('budget/dept_expense_m');
        $this->load->model('basis/log_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/role_module_m');
    }

    private $layout = '/template/head';

    function index($msg = NULL) {
        $this->role_module_m->authorization('22');
        if ($msg == 1) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Creating success. </strong> The data is successfully created. </div >";
        } elseif ($msg == 2) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Updating success. </strong> The data is successfully updated. </div >";
        } elseif ($msg == 3) {
            $msg = "<div class = 'alert alert-info'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Deleting success. </strong> The data is successfully deleted. </div >";
        } elseif ($msg == 12) {
            $msg = "<div class = 'alert alert-danger'><button type = 'button' class = 'close' data-dismiss = 'alert'>×</button><strong>Executing error !</strong> Something is not right. </div >";
        }
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(22);

        $data['title'] = 'Department Expense';
        $data['msg'] = $msg;
        $data['subcontent'] = NULL;
        $data['data'] = $this->dept_m->get_dept();
        $data['content'] = 'budget/dept_expense/manage_dept_expense_v';
        $this->load->view($this->layout, $data);
    }

    function get_dept_expense_detail($id) {
        $this->role_module_m->authorization('22');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(22);
        
        $data['data_detail'] = $this->dept_m->get_data_dept($id)->row();
        $data['dept_expense'] = $this->dept_expense_m->get_dept_expense_detail($id);
        $data['dept_subexpense'] = $this->dept_expense_m->get_dept_subexpense_detail($id);
        
        $data['data'] = $this->dept_m->get_dept();
        $data['title'] = 'Dept Expense Detail';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/dept_expense/view_dept_expense_v';
        $data['content'] = 'budget/dept_expense/manage_dept_expense_v';

        $this->load->view($this->layout, $data);
    }

    function edit_dept_expense($id) {
        $this->role_module_m->authorization('22');
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(22);

        $data['data'] = $this->dept_m->get_dept();
        $data['data_detail'] = $this->dept_m->get_data_dept($id)->row();
        
        $data['dept_expense'] = $this->dept_expense_m->get_dept_expense($id);
        $data['pure_expense_sub'] = $this->dept_expense_m->get_pure_expense_sub();
        $data['pure_expense'] = $this->dept_expense_m->get_pure_expense();

        $data['dept_subexpense'] = $this->dept_expense_m->get_dept_subexpense($id);
        $data['subexpense_sub'] = $this->dept_expense_m->get_subexpense_sub();
        $data['subexpense'] = $this->dept_expense_m->get_subexpense();
//  
        $data['title'] = 'Edit Dept Expense';
        $data['msg'] = NULL;
        $data['subcontent'] = 'budget/dept_expense/edit_dept_expense_v';
        $data['content'] = 'budget/dept_expense/manage_dept_expense_v';

        $this->load->view($this->layout, $data);
    }

    function update_dept_expense() {
        $id = $this->input->post('INT_ID_DEPT');
        $expense = $this->input->post('INT_ID_BUDGET');
        $subexpense = $this->input->post('INT_ID_BUDGET2');
        $session = $this->session->all_userdata();
        if($this->dept_expense_m->if_exist($id)){
            $this->dept_expense_m->delete_dept_expense($id);
        }
        if($this->dept_expense_m->if_exist_sub($id)){
            $this->dept_expense_m->delete_dept_subexpense($id);
        }
        if ($expense != NULL) {
            for ($i = 0; $i < count($expense); $i++) {
                $this->dept_expense_m->save_dept_expense($id,$expense[$i], $session['USERNAME']);
            }
        }
        if ($subexpense != NULL) {
            for ($i = 0; $i < count($subexpense); $i++) {
                $this->dept_expense_m->save_dept_subexpense($id,$subexpense[$i], $session['USERNAME']);
            }
        }
        $this->log_m->add_log('70', $id);
        $this->index('2');
    }

}

?>
