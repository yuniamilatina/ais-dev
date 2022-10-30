<?php

class room_c extends CI_Controller {

    private $layout = '/template/head';
    private $back_to_manage = 'room/room_reservation_c/index/';

    public function __construct() {
        parent::__construct();
        $this->load->model('room/room_m');
    }

    function index() {
        
    }

    public function create($msg = null, $id_room = null) {
        // $a = $this->db->query("SELECT     DISTINCT(TT_DELIVERY_ITEM.CHR_DEL_NO)
        //               FROM         TT_DELIVERY_ITEM INNER JOIN
        //               TT_DELIVERY ON TT_DELIVERY_ITEM.CHR_DEL_NO = TT_DELIVERY.CHR_DEL_NO")->result();

        // $i = 1;
        // foreach ($a as $value) {
        //     $b = $this->db->query("SELECT  TT_GOODS_MOVEMENT_L.CHR_PART_NO , TT_GOODS_MOVEMENT_L.INT_TOTAL_QTY
        //                 FROM TT_GOODS_MOVEMENT_H
        //                 INNER JOIN
        //                 TT_GOODS_MOVEMENT_L
        //                 ON TT_GOODS_MOVEMENT_H.INT_NUMBER = TT_GOODS_MOVEMENT_L.INT_NUMBER
        //                 WHERE    (CHR_TYPE_TRANS = 'FGDL') AND (CHR_REMARKS = '$value->CHR_DEL_NO')")->result();

        //     IF (COUNT($b) > 0) {
        //         echo $value->CHR_DEL_NO . " || " . $b[0]->INT_TOTAL_QTY . "<br>";
        //     }

        //     foreach ($b as $value_b) {
        //         $this->db->query("update TT_DELIVERY_ITEM set INT_SCAN_QTY = (INT_SCAN_QTY + $value_b->INT_TOTAL_QTY) where CHR_DEL_NO = '$value->CHR_DEL_NO' and CHR_PART_NO = '$value_b->CHR_PART_NO'");
        //     }
        //     $i++;
        // }

        // EXIT();






        $this->role_module_m->authorization('132');

        $data['content'] = 'room/room_v';
        $data['title'] = "Manage Room";

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(132);
        $data['news'] = $this->news_m->get_news();
        $data['pure'] = true;

        if (empty($msg)) {
            $msg = "";
        }

        if ($this->input->post("btn-Submit") == 1) {
            $kode_room = $this->input->post("kode_room");
            $desc = $this->input->post("description");
            $kode_room = "RM-" . trim($kode_room);
            //cek data ruangan
            $cek_ruangan = $this->room_m->get_data_room($kode_room);

            if (count($cek_ruangan) > 0) {
                $data_update = array(
                    'CHR_DESC' => $desc
                );
                $this->room_m->update($data_update, $kode_room);
                //$this->db->query("UPDATE GAF.TM_ROOM SET CHR_DESC='$desc' WHERE  CHR_KODE_ROOM='$kode_room';");
                $msg = "update";
            } else {
                $data_insert = array(
                    'CHR_KODE_ROOM' => $kode_room,
                    'CHR_DESC' => $desc
                );
                $this->room_m->save($data_insert);
                //$this->db->query("INSERT INTO GAF.TM_ROOM (CHR_KODE_ROOM, CHR_DESC) VALUES ('$kode_room', '$desc');");
                $msg = "register";
            }
        }

        if ($id_room <> null) {
            $edit_room = $this->room_m->get_data_room($id_room);
            if (count($edit_room) > 0) {
                $id_room = $edit_room[0]->CHR_KODE_ROOM;
                $desc_room = $edit_room[0]->CHR_DESC;
                $id_room = str_replace("RM-", "", $id_room);
            } else {
                $id_room = "";
                $desc_room = "";
            }
        } else {
            $id_room = "";
            $desc_room = "";
        }

        //select table room
        $room = $this->room_m->get_all_room();
        $data['new_year'] = date('Y');
        $data['new_month'] = date('m');
        $data['room'] = $room;
        $data['msg'] = $msg;
        $data['id_room'] = $id_room;
        $data['desc_room'] = $desc_room;

        $this->load->view($this->layout, $data);
    }

    public function delete_room($id) {

        //cek data ruangan
        //$cek_ruangan = $this->room_m->get_data_room($id);
        //$room_desc = $cek_ruangan[0]->CHR_DESC;

        $this->room_m->delete($id);

        //echo "<script>alert('Anda Berhasil Menghapus Room $room_desc')</script>";
        redirect("room/room_c/create/delete", "refresh");
    }

}
