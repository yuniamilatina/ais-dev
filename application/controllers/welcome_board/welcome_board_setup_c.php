<?php

class welcome_board_setup_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('welcome_board/welcome_board_m');
    }

    public function index($param = null) {
        if ($param == 1) {
            $data['checkbox1'] = 'checked';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 2) {
            $data['checkbox2'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 3) {
            $data['checkbox3'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 4) {
            $data['checkbox4'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 5) {
            $data['checkbox5'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 6) {
            $data['checkbox6'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 7) {
            $data['checkbox7'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 8) {
            $data['checkbox8'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 9) {
            $data['checkbox9'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox5'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 10) {
            $data['checkbox10'] = 'checked';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        } else if ($param == 11) {
            $data['checkbox10'] = '';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox11'] = 'checked';
            $data['checkbox12'] = '';
        } else if ($param == 12) {
            $data['checkbox10'] = '';
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = 'checked';
        } else {
            $data['checkbox1'] = '';
            $data['checkbox2'] = '';
            $data['checkbox3'] = '';
            $data['checkbox4'] = '';
            $data['checkbox5'] = '';
            $data['checkbox6'] = '';
            $data['checkbox7'] = '';
            $data['checkbox8'] = '';
            $data['checkbox9'] = '';
            $data['checkbox10'] = '';
            $data['checkbox11'] = '';
            $data['checkbox12'] = '';
        }

        $this->welcome_board_m->update_stat($param);
        $this->load->view('welcome_board/setup_welcome_board_v', $data);
    }

}
