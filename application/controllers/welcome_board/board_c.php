<?php

class Board_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('guest/guest_m');
    }

    public function index() {
        $content = 'board/display_v';
        $data['title'] = "Room Display";

        $data['data_guest'] = $this->guest_m->get_top5_guest();
        // $data['data_guest1'] = $this->guest_m->get_top_guest_1();
        // $data['data_guest2'] = $this->guest_m->get_top_guest_2();
        // $data['data_guest3'] = $this->guest_m->get_top_guest_3();

        $this->load->view($content, $data);
    }

    public function getGuest() {
        $data = $this->guest_m->getGuest();
        echo json_encode($data);
    }

    public function updateAjax() {

        $cek = $this->db->query("select * from TT_CONTROL_WB")->row();
        $stat = $cek->CHR_STAT;

        echo json_encode(array("stat" => "$stat"));
    }

    public function parkir1() {
        $content = 'board/parkir1';

        $this->load->view($content);
    }

    public function parkir2() {
        $content = 'board/parkir2';

        $this->load->view($content);
    }

    public function lobby() {
        $content = 'board/lobby';

        $this->load->view($content);
    }

    public function masjid() {
        $content = 'board/masjid';

        $this->load->view($content);
    }

    public function lapangan() {
        $content = 'board/lapangan';

        $this->load->view($content);
    }

    public function koperasi() {
        $content = 'board/koperasi';

        $this->load->view($content);
    }

    public function plant_tour() {
        $content = 'board/plant-tour';

        $this->load->view($content);
    }

}

?>
