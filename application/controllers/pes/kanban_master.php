<?php

set_time_limit(7200);
ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Kanban_master extends CI_Controller {
    /* -- define constructor -- */

    private $layout = '/template/head';

    public function __construct() {
        parent::__construct();
        $this->load->model('pes/prod_entry_m');
        $this->load->model('pes/kanban_master_m');
        $this->load->model('organization/dept_m');
        $this->load->model('basis/role_module_m');
        // $this->load->model(array('pes/display_m'));
        $this->load->model('portal/news_m');
        $this->load->model('basis/log_m');
        $this->load->model('portal/notification_m');
    }

    public function index() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $data['content'] = 'pes/kanban_master';
        $data['title'] = 'Kanban Master';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(16);
        $data['news'] = $this->news_m->get_news();

        if ($this->session->userdata('ROLE') == 15 || $this->session->userdata('ROLE') == 1 || $this->session->userdata('ROLE') == 16) {
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', '', 'CHR_WCENTER_MN');
        } else {
            $row = $this->dept_m->get_data_dept($this->session->userdata('DEPT'))->row();
            $data['dept_crop'] = substr($row->CHR_DEPT, 2, 1);
            $wcenter = $this->prod_entry_m->find('TOP(1) CHR_WCENTER_MN', 'CHR_PROD=' . $data['dept_crop'] . '', 'CHR_WCENTER_MN');
        }
        $data['first_wcenter'] = $wcenter[0]->CHR_WCENTER_MN;

        $this->load->view($this->layout, $data);
    }

// FUNCTION DATABARU
    public function databaru() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $session = $this->session->all_userdata();
        $data['content'] = 'kanban_master/databaru_v2';
        $data['title'] = 'Kanban Master System';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(111);
        $data['news'] = $this->news_m->get_news();

        $boxtype = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_BOX_TYPE FROM TM_BOX_TYPE");
        $data['boxtype'] = $boxtype;
        if ($this->input->post('order')) {
            $partno = trim($this->input->post('idorder'));
            $partname = trim($this->input->post('pname1'));
            $stor = trim($this->input->post('stor1'));
            $backno1 = trim($this->input->post('backno1'));
            $supplierid = trim($this->input->post('supplierid1'));
            $suppliername = trim($this->input->post('sname1'));
            $qtyperbox = trim($this->input->post('qtyperbox1'));
            $boxtype1 = trim($this->input->post('boxtype1'));
            $side = trim($this->input->post('side1'));
            $keterangan = $this->input->post('keterangan');
            $cust = $this->kanban_master_m->check($partno);
            if ($cust == false) {
                $cust = '';
            } else {
                $cust = $cust[0]->CHR_CUS_PART_NO;
            }
            $partnodash = trim($this->input->post('idorder'));
            $jmlpartno = strlen($partnodash);
            //add dash part no
            if ($jmlpartno < 14) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                };
            } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno > 17) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname7 = substr($partnodash, 17, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            }

            $x = $this->kanban_master_m->checkFlagor($partno);
            if ($x == true) {
                $flag = $this->kanban_master_m->findBySql("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' and CHR_WC_VENDOR='$supplierid' ");
                $flag = $flag[0]->CHR_FLAG_DELETE;
                if ($flag == 'X') {
                    $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                } else {

                    $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '0' AND CHR_BACK_NO = '$backno1' AND CHR_SLOC_TO = '$stor' AND CHR_WC_VENDOR = '$supplierid' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype1' AND INT_QTY_PER_BOX = '$qtyperbox' ");
                    if ($cekdata) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                    }

                    // validasi partno supplier id dan tipe kanban
                    $cekall = $this->kanban_master_m->checksid($partno, $supplierid);
                    if ($cekall == true) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Part No dengan supplier id yang sama sudah ada. Silahkan pilih supplier id atau Material lain');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                    }

                    $cekqty = strlen($qtyperbox);
                    if ($cekqty == 0) {
                        echo "<script>alert('Silahkan Lengkapi Data yang Masih Kosong');";
                        echo "</script>";
                        redirect("pes/kanban_master/databaru");
                    }

                    $cekbox = strlen($boxtype1);
                    if ($cekbox == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                    }

                    $lengthb = strlen($backno1);
                    if ($lengthb == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                    }

                    // validasi backno
                    $checkbackno = $this->kanban_master_m->check_backno($backno1);
                    if ($checkbackno <> false) {
                        $bno = $checkbackno[0]->CHR_BACK_NO;
                        $cekpart = $this->kanban_master_m->checkpart($bno);
                        if ($cekpart <> false) {
                            $partnocek = $cekpart[0]->CHR_PART_NO;
                            $partnocek = trim($partnocek);
                            $partno = trim($partno);
                            if ($partnocek <> $partno) {
                                $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                                redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                            }
                        }
                    }

                    //validasi backno lama dan baru
                    $checkbackno = $this->kanban_master_m->check_backno2($partno);
                    if ($checkbackno <> false) {
                        $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                        if ($checkbackno <> $backno1) {
                            $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                        }
                    }

                    //Add part number with dash
                    $cekdash = $this->kanban_master_m->checkPartDash($partno);
                    if ($cekdash <> false) {
                        $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                        if ($cekdash = NULL or $cekdash == '') {
                            $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                            $this->kanban_master_m->updateTMParts($t_data, $partno);
                        }
                    }

                    // proses penyimpanan databaru
                    $t_data = array('CHR_PLANT' => '600',
                        'CHR_PART_NO' => $partno,
                        'CHR_BACK_NO' => strtoupper($backno1),
                        'INT_QTY_PER_BOX' => $qtyperbox,
                        'CHR_BOX_TYPE' => $boxtype1,
                        'CHR_SIDE' => $side,
                        'CHR_WC_VENDOR' => $supplierid,
                        'CHR_KANBAN_TYPE' => '0',
                        'CHR_DATE_CREATE' => date("Ymd"),
                        'CHR_DATE_CHANGE' => date("Ymd"),
                        'CHR_KETERANGAN' => strtoupper($keterangan),
                        'CHR_CUST_PART_NO' => $cust,
                        'CHR_SLOC_TO' => $stor,
                        'CHR_SLOC_FROM' => $stor,
                        'CHR_PART_NO_DASH' => $partnodash,
                    );
                    $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');

                    if (isset($status)) {

                        // cek part no di tm sto
                        $vpartno = $this->kanban_master_m->check_partno_tm_sto($partno, $supplierid);
                        $suppliername = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID='$supplierid' ");
                        $chrjenisbox = $this->kanban_master_m->findBySql("SELECT TOP 1 CHR_UNIT FROM [dbo].[TT_PO_LINE] WHERE CHR_PART_NO = '$partno' ORDER BY CHR_SYS_DATE DESC");
                        if (!empty($chrjenisbox)) {
                            $chrjenisbox = $chrjenisbox[0]->CHR_UNIT;
                            $chrjenisbox = trim($chrjenisbox);
                            if ($chrjenisbox == 'ST') {
                                $chrjenisbox = "PC";
                            }
                        } else {
                            $chrjenisbox = '';
                        }
                        if (!empty($suppliername)) {
                            $suppliername = $suppliername[0]->CHR_SUPPLIER_NAME;
                        } else {
                            $suppliername = '';
                        }

                        if ($vpartno == false) {
                            $t_data = array('CHR_ID_PART' => $partno,
                                'CHR_NAMA_PART' => $partname,
                                'CHR_BACK_NO' => strtoupper($backno1),
                                'INT_QTY_PER_BOX' => $qtyperbox,
                                'CHR_JENIS_BOX' => $chrjenisbox,
                                'CHR_KODE_VENDOR' => $supplierid,
                                'CHR_KODE_VENDOR_AKTIF' => substr($supplierid, 6, 2),
                                'CHR_NAMA_VENDOR' => $suppliername,
                                'CHR_SLOC' => 'WH00' //revisi cipto 01/06/2016
                            );
                            $this->kanban_master_m->addProduct($t_data, 'TM_STO');
                        } //submit part no di TM_STO


                        $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                    } else {

                        $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                    }
                }
            } else {
                $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '0' AND CHR_BACK_NO = '$backno1' AND CHR_SLOC_TO = '$stor' AND CHR_WC_VENDOR = '$supplierid' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype1' AND INT_QTY_PER_BOX = '$qtyperbox' ");

                if ($cekdata) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                }

                // validasi partno supplier id dan tipe kanban
                $cekall = $this->kanban_master_m->checksid($partno, $supplierid);
                if ($cekall == true) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Part No dengan supplier id yang sama sudah ada. Silahkan pilih supplier id atau Material lain');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                }

                $cekqty = strlen($qtyperbox);
                if ($cekqty == 0) {
                    echo "<script>alert('Silahkan Lengkapi Data yang Masih Kosong');";
                    echo "</script>";
                    redirect("pes/kanban_master/databaru");
                }

                $cekbox = strlen($boxtype1);
                if ($cekbox == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                }

                $lengthb = strlen($backno1);
                if ($lengthb == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                }

                // validasi backno
                $checkbackno = $this->kanban_master_m->check_backno($backno1);
                if ($checkbackno <> false) {
                    $bno = $checkbackno[0]->CHR_BACK_NO;
                    $cekpart = $this->kanban_master_m->checkpart($bno);
                    if ($cekpart <> false) {
                        $partnocek = $cekpart[0]->CHR_PART_NO;
                        $partnocek = trim($partnocek);
                        $partno = trim($partno);
                        if ($partnocek <> $partno) {
                            $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                        }
                    }
                }

                //validasi backno lama dan baru
                $checkbackno = $this->kanban_master_m->check_backno2($partno);
                if ($checkbackno <> false) {
                    $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                    if ($checkbackno <> $backno1) {
                        $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                    }
                }

                //Add part number with dash
                $cekdash = $this->kanban_master_m->checkPartDash($partno);
                if ($cekdash <> false) {
                    $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                    if ($cekdash = NULL or $cekdash == '') {
                        $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                        $this->kanban_master_m->updateTMParts($t_data, $partno);
                    }
                }

                // proses save data di TM_KANBAN
                $t_data = array('CHR_PLANT' => '600',
                    'CHR_PART_NO' => $partno,
                    'CHR_BACK_NO' => strtoupper($backno1),
                    'INT_QTY_PER_BOX' => $qtyperbox,
                    'CHR_BOX_TYPE' => $boxtype1,
                    'CHR_SIDE' => $side,
                    'CHR_WC_VENDOR' => $supplierid,
                    'CHR_KANBAN_TYPE' => '0',
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_KETERANGAN' => strtoupper($keterangan),
                    'CHR_CUST_PART_NO' => $cust,
                    'CHR_SLOC_TO' => $stor,
                    'CHR_SLOC_FROM' => $stor,
                    'CHR_PART_NO_DASH' => $partnodash,
                );

                $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');

                if (isset($status)) {

                    // cek part no di tm sto
                    $vpartno = $this->kanban_master_m->check_partno_tm_sto($partno, $supplierid);
                    $suppliername = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID='$supplierid' ");
                    $chrjenisbox = $this->kanban_master_m->findBySql("SELECT TOP 1 CHR_UNIT FROM [dbo].[TT_PO_LINE] WHERE CHR_PART_NO = '$partno' ORDER BY CHR_SYS_DATE DESC");
                    if (!empty($chrjenisbox)) {
                        $chrjenisbox = $chrjenisbox[0]->CHR_UNIT;
                        $chrjenisbox = trim($chrjenisbox);
                        if ($chrjenisbox == 'ST') {
                            $chrjenisbox = "PC";
                        }
                    } else {
                        $chrjenisbox = '';
                    }
                    if (!empty($suppliername)) {
                        $suppliername = $suppliername[0]->CHR_SUPPLIER_NAME;
                    } else {
                        $suppliername = '';
                    }
                    if ($vpartno == false) {
                        $t_data = array('CHR_ID_PART' => $partno,
                            'CHR_NAMA_PART' => $partname,
                            'CHR_BACK_NO' => strtoupper($backno1),
                            'INT_QTY_PER_BOX' => $qtyperbox,
                            'CHR_JENIS_BOX' => $chrjenisbox,
                            'CHR_KODE_VENDOR' => $supplierid,
                            'CHR_KODE_VENDOR_AKTIF' => substr($supplierid, 6, 2),
                            'CHR_NAMA_VENDOR' => $suppliername,
                            'CHR_SLOC' => 'WH00' //revisi cipto 01/06/2016
                        );
                        $this->kanban_master_m->addProduct($t_data, 'TM_STO');
                    } //submit part no di TM_STO


                    $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                } else {

                    $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru');
                }
            }
        } elseif ($this->input->post('proses')) {
            $partno = trim($this->input->post('idproses'));
            $partname = trim($this->input->post('pnameproses'));
            $backno = trim($this->input->post('backno'));
            $prodver = trim($this->input->post('prodver'));
            $qtyperpack = trim($this->input->post('qtyperpack'));
            $boxtype = trim($this->input->post('boxtype'));
            $side = trim($this->input->post('side'));
            $selfpro = trim($this->input->post('selfpro'));
            $storself = trim($this->input->post('storself'));
            $nextpro = trim($this->input->post('nextpro'));
            $stornext = trim($this->input->post('stornext'));
            $keterangan = $this->input->post('keterangan');
            $cust = $this->kanban_master_m->check($partno);
            if ($cust == false) {
                $cust = '';
            } else {
                $cust = $cust[0]->CHR_CUS_PART_NO;
            }

            $partnodash = trim($this->input->post('idproses'));
            $jmlpartno = strlen($partnodash);
            //add dash part no
            if ($jmlpartno < 14) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                };
            } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno > 17) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname7 = substr($partnodash, 17, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            }

            $x = $this->kanban_master_m->checkFlagpr($partno);
            if ($x == true) {
                $flag = $this->kanban_master_m->findBySql("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
                $flag = $flag[0]->CHR_FLAG_DELETE;
                if ($flag == 'X') {
                    $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                } else {
                    $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_SLOC_FROM, CHR_WORK_CENTER, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1' AND CHR_SLOC_FROM = '$storself' AND CHR_WORK_CENTER = '$nextpro' AND CHR_BACK_NO = '$backno' AND CHR_SLOC_TO = '$stornext' AND CHR_WC_VENDOR = '$prodver' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype' AND INT_QTY_PER_BOX = '$qtyperpack' ");
                    if ($cekdata) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    }

                    $cekall = $this->kanban_master_m->checkpv1($partno, $prodver);
                    if ($cekall == true) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Part No dengan production version yang sama sudah ada. Silahkan pilih Production Version atau Material lain');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    }

                    $cekqty = strlen($qtyperpack);
                    if ($cekqty == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    }

                    $cekbox = strlen($boxtype);
                    if ($cekbox == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    }

                    $lengthb = strlen($backno);
                    if ($lengthb == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    }

                    // validasi backno
                    $checkbackno = $this->kanban_master_m->check_backno($backno);
                    if ($checkbackno <> false) {
                        $bno = $checkbackno[0]->CHR_BACK_NO;
                        $cekpart = $this->kanban_master_m->checkpart($bno);
                        if ($cekpart <> false) {
                            $partnocek = $cekpart[0]->CHR_PART_NO;
                            $partnocek = trim($partnocek);
                            if ($partnocek <> $partno) {
                                $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                                redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                            }
                        }
                    }

                    //validasi backno lama dan baru
                    $backnolama = $this->kanban_master_m->check_backno2($partno);
                    if ($backnolama <> false) {
                        $checkbackno = trim($backnolama[0]->CHR_BACK_NO);
                        if ($checkbackno <> $backno) {
                            $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                        }
                    }

                    //Add part number with dash
                    $cekdash = $this->kanban_master_m->checkPartDash($partno);
                    if ($cekdash != false) {
                        $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                        if ($cekdash = NULL) {
                            $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                            $this->kanban_master_m->updateTMParts($t_data, $partno);
                        } elseif ($cekdash == '') {
                            $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                            $this->kanban_master_m->updateTMParts($t_data, $partno);
                        }
                    }

                    // proses save ke TM_Kanban
                    $t_data = array('CHR_PLANT' => '600',
                        'CHR_PART_NO' => $partno,
                        'CHR_BACK_NO' => strtoupper($backno),
                        'INT_QTY_PER_BOX' => $qtyperpack,
                        'CHR_BOX_TYPE' => $boxtype,
                        'CHR_SIDE' => $side,
                        'CHR_SLOC_FROM' => $storself,
                        'CHR_WORK_CENTER' => $nextpro,
                        'CHR_SLOC_TO' => $stornext,
                        'CHR_WC_VENDOR' => $prodver,
                        'CHR_KANBAN_TYPE' => '1',
                        'CHR_DATE_CREATE' => date("Ymd"),
                        'CHR_DATE_CHANGE' => date("Ymd"),
                        'CHR_KETERANGAN' => strtoupper($keterangan),
                        'CHR_RAKNO' => 'IH',
                        'CHR_CREATE_USER' => $session['NPK'],
                        'CHR_CREATE_DATE' => date("Ymd"),
                        'CHR_CREATE_TIME' => date("His"),
                        'CHR_CUST_PART_NO' => $cust,
                        'CHR_PART_NO_DASH' => $partnodash,
                    );
                    $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');
                    if (isset($status)) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    } else {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    }
                }
                // else
            } else {
                $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_SLOC_FROM, CHR_WORK_CENTER, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1' AND CHR_SLOC_FROM = '$storself' AND CHR_WORK_CENTER = '$nextpro' AND CHR_BACK_NO = '$backno' AND CHR_SLOC_TO = '$stornext' AND CHR_WC_VENDOR = '$prodver' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype' AND INT_QTY_PER_BOX = '$qtyperpack' ");
                if ($cekdata) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                }

                $cekall = $this->kanban_master_m->checkpv1($partno, $prodver);
                if ($cekall == true) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Part No dengan production version yang sama sudah ada. Silahkan pilih Production Version atau Material lain');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                }

                $cekqty = strlen($qtyperpack);
                if ($cekqty == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                }

                $cekbox = strlen($boxtype);
                if ($cekbox == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                }

                $lengthb = strlen($backno);
                if ($lengthb == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                }

                // validasi backno
                $checkbackno = $this->kanban_master_m->check_backno($backno);
                if ($checkbackno <> false) {
                    $bno = $checkbackno[0]->CHR_BACK_NO;
                    $cekpart = $this->kanban_master_m->checkpart($bno);
                    if ($cekpart <> false) {
                        $partnocek = $cekpart[0]->CHR_PART_NO;
                        $partnocek = trim($partnocek);
                        if ($partnocek <> $partno) {
                            $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                        }
                    }
                }
                //validasi backno lama dan baru
                $backnolama = $this->kanban_master_m->check_backno2($partno);
                if ($backnolama <> false) {
                    $checkbackno = trim($backnolama[0]->CHR_BACK_NO);
                    if ($checkbackno <> $backno) {
                        $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                    }
                }

                //Add part number with dash
                $cekdash = $this->kanban_master_m->checkPartDash($partno);
                if ($cekdash != false) {
                    $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                    if ($cekdash = NULL) {
                        $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                        $this->kanban_master_m->updateTMParts($t_data, $partno);
                    } elseif ($cekdash == '') {
                        $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                        $this->kanban_master_m->updateTMParts($t_data, $partno);
                    }
                }

                // save to TM_Kanban for kanban proses
                $t_data = array('CHR_PLANT' => '600',
                    'CHR_PART_NO' => $partno,
                    'CHR_BACK_NO' => strtoupper($backno),
                    'INT_QTY_PER_BOX' => $qtyperpack,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_SIDE' => $side,
                    'CHR_SLOC_FROM' => $storself,
                    'CHR_WORK_CENTER' => $nextpro,
                    'CHR_SLOC_TO' => $stornext,
                    'CHR_WC_VENDOR' => $prodver,
                    'CHR_KANBAN_TYPE' => '1',
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_KETERANGAN' => strtoupper($keterangan),
                    'CHR_RAKNO' => 'IH',
                    'CHR_CREATE_USER' => $session['NPK'],
                    'CHR_CREATE_DATE' => date("Ymd"),
                    'CHR_CREATE_TIME' => date("His"),
                    'CHR_CUST_PART_NO' => $cust,
                    'CHR_PART_NO_DASH' => $partnodash,
                );
                $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');
                if (isset($status)) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                } else {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#proses_v');
                }
            }
        } elseif ($this->input->post('supplyparts')) {
            $partno = trim($this->input->post('idsupply'));
            $partname = $this->input->post('pname3');
            $stor = trim($this->input->post('stor3'));
            $backno2 = trim($this->input->post('backno3'));
            $supplierid3 = trim($this->input->post('supplierid3'));
            $qtyperbox3 = trim($this->input->post('qtyperbox3'));
            $boxtype3 = trim($this->input->post('boxtype3'));
            $side3 = trim($this->input->post('side3'));
            $keterangan = $this->input->post('keterangan');
            $cust = $this->kanban_master_m->check($partno);
            if ($cust == false) {
                $cust = '';
            } else {
                $cust = $cust[0]->CHR_CUS_PART_NO;
            }

            $partnodash = trim($this->input->post('idsupply'));
            $jmlpartno = strlen($partnodash);
            //add dash part no
            if ($jmlpartno < 14) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                };
            } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno > 17) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname7 = substr($partnodash, 17, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            }

            $x = $this->kanban_master_m->checkFlagsp($partno);
            if ($x == true) {
                $flag = $this->kanban_master_m->findBySql("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
                $flag = $flag[0]->CHR_FLAG_DELETE;
                if ($flag == 'X') {
                    $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                } else {
                    $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '4' AND CHR_BACK_NO = '$backno2' AND CHR_SLOC_TO = '$stor' AND CHR_WC_VENDOR = '$supplierid3' AND CHR_SIDE = '$side3' AND CHR_BOX_TYPE = '$boxtype3' AND INT_QTY_PER_BOX = '$qtyperbox3' ");
                    if ($cekdata) {
                        $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                    }

                    // validasi partno supplier id dan tipe kanban
                    $cekall = $this->kanban_master_m->checksid1($partno, $supplierid3);
                    if ($cekall == true) {
                        $this->session->set_flashdata('message', 'Part No dengan supplier id yang sama sudah ada. Silahkan pilih supplier id atau Material lain');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                    }

                    $cekqty = strlen($qtyperbox3);
                    if ($cekqty == 0) {
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                    }

                    $cekbox = strlen($boxtype3);
                    if ($cekbox == 0) {
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                    }

                    $lengthb = strlen($backno2);
                    if ($lengthb == 0) {
                        $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                    }

                    // validasi backno
                    $checkbackno = $this->kanban_master_m->check_backno($backno2);
                    if ($checkbackno <> false) {
                        $bno = $checkbackno[0]->CHR_BACK_NO;
                        $cekpart = $this->kanban_master_m->checkpart($bno);
                        if ($cekpart <> false) {
                            $partnocek = $cekpart[0]->CHR_PART_NO;
                            $partnocek = trim($partnocek);
                            $partno = trim($partno);
                            if ($partnocek <> $partno) {
                                $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                                redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                            }
                        }
                    }

                    //validasi backno lama dan baru
                    $checkbackno = $this->kanban_master_m->check_backno2($partno);
                    if ($checkbackno <> false) {
                        $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                        if ($checkbackno <> $backno2) {
                            $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                        }
                    }

                    //Add part number with dash
                    $cekdash = $this->kanban_master_m->checkPartDash($partno);
                    if ($cekdash <> false) {
                        $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                        if ($cekdash = NULL or $cekdash == '') {
                            $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                            $this->kanban_master_m->updateTMParts($t_data, $partno);
                        }
                    }

                    // save to TM_kanban for kanban supplyparts
                    $t_data = array('CHR_PLANT' => '600',
                        'CHR_PART_NO' => $partno,
                        'CHR_BACK_NO' => strtoupper($backno2),
                        'INT_QTY_PER_BOX' => $qtyperbox3,
                        'CHR_BOX_TYPE' => $boxtype3,
                        'CHR_SIDE' => $side3,
                        'CHR_WC_VENDOR' => trim($supplierid3),
                        'CHR_SLOC_TO' => trim($supplierid3),
                        'CHR_KANBAN_TYPE' => '4',
                        'CHR_DATE_CREATE' => date("Ymd"),
                        'CHR_DATE_CHANGE' => date("Ymd"),
                        'CHR_KETERANGAN' => strtoupper($keterangan),
                        'CHR_CUST_PART_NO' => $cust,
                        'CHR_SLOC_FROM' => $stor,
                        'CHR_PART_NO_DASH' => $partnodash,
                    );
                    $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');
                }
            } else {
                $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '4' AND CHR_BACK_NO = '$backno2' AND CHR_SLOC_TO = '$stor' AND CHR_WC_VENDOR = '$supplierid3' AND CHR_SIDE = '$side3' AND CHR_BOX_TYPE = '$boxtype3' AND INT_QTY_PER_BOX = '$qtyperbox3' ");
                if ($cekdata) {
                    $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                }
                // validasi partno supplier id dan tipe kanban
                $cekall = $this->kanban_master_m->checksid1($partno, $supplierid3);
                if ($cekall == true) {
                    $this->session->set_flashdata('message', 'Part No dengan supplier id yang sama sudah ada. Silahkan pilih supplier id atau Material lain');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                }

                $cekqty = strlen($qtyperbox3);
                if ($cekqty == 0) {
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                }

                $cekbox = strlen($boxtype3);
                if ($cekbox == 0) {
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                }

                $lengthb = strlen($backno2);
                if ($lengthb == 0) {
                    $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                }

                // validasi backno
                $checkbackno = $this->kanban_master_m->check_backno($backno2);
                if ($checkbackno <> false) {
                    $bno = $checkbackno[0]->CHR_BACK_NO;
                    $cekpart = $this->kanban_master_m->checkpart($bno);
                    if ($cekpart <> false) {
                        $partnocek = $cekpart[0]->CHR_PART_NO;
                        $partnocek = trim($partnocek);
                        $partno = trim($partno);
                        if ($partnocek <> $partno) {
                            $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                        }
                    }
                }
                //validasi backno lama dan baru
                $checkbackno = $this->kanban_master_m->check_backno2($partno);
                if ($checkbackno <> false) {
                    $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                    if ($checkbackno <> $backno2) {
                        $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
                    }
                }

                //Add part number with dash
                $cekdash = $this->kanban_master_m->checkPartDash($partno);
                if ($cekdash <> false) {
                    $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                    if ($cekdash = NULL or $cekdash == '') {
                        $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                        $this->kanban_master_m->updateTMParts($t_data, $partno);
                    }
                }

                //save to TM_Kanban for kanban supplyparts
                $t_data = array('CHR_PLANT' => '600',
                    'CHR_PART_NO' => $partno,
                    'CHR_BACK_NO' => strtoupper($backno2),
                    'INT_QTY_PER_BOX' => $qtyperbox3,
                    'CHR_BOX_TYPE' => $boxtype3,
                    'CHR_SIDE' => $side3,
                    'CHR_WC_VENDOR' => trim($supplierid3),
                    'CHR_KANBAN_TYPE' => '4',
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_KETERANGAN' => strtoupper($keterangan),
                    'CHR_CUST_PART_NO' => $cust,
                    'CHR_SLOC_FROM' => $stor,
                    'CHR_SLOC_TO' => trim($supplierid3),
                    'CHR_PART_NO_DASH' => $partnodash,
                );
                $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');
            }

            if ($status == true) {

                // cek part no di tm sto
                $vpartno = $this->kanban_master_m->check_partno_tm_sto($partno, $supplierid3);
                $suppliername = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID='$supplierid3' ");
                $chrjenisbox = $this->kanban_master_m->findBySql("SELECT TOP 1 CHR_UNIT FROM [dbo].[TT_PO_LINE] WHERE CHR_PART_NO = '$partno' ORDER BY CHR_SYS_DATE DESC");
                if (!empty($chrjenisbox)) {
                    $chrjenisbox = $chrjenisbox[0]->CHR_UNIT;
                    $chrjenisbox = trim($chrjenisbox);
                    if ($chrjenisbox == 'ST') {
                        $chrjenisbox = "PC";
                    }
                } else {
                    $chrjenisbox = '';
                }
                if (!empty($suppliername)) {
                    $suppliername = $suppliername[0]->CHR_SUPPLIER_NAME;
                } else {
                    $suppliername = '';
                }
                if ($vpartno == false) {
                    $t_data = array('CHR_ID_PART' => $partno,
                        'CHR_NAMA_PART' => $partname,
                        'CHR_BACK_NO' => strtoupper($backno2),
                        'INT_QTY_PER_BOX' => $qtyperbox3,
                        'CHR_JENIS_BOX' => $chrjenisbox,
                        'CHR_KODE_VENDOR' => $supplierid3,
                        'CHR_KODE_VENDOR_AKTIF' => substr($supplierid3, 6, 2),
                        'CHR_NAMA_VENDOR' => $suppliername,
                        'CHR_SLOC' => 'WH00' //revisi cipto 01/06/2016
                    );
                    $this->kanban_master_m->addProduct($t_data, 'TM_STO');
                } //submit part no di TM_STO

                $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
            } else {
                $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/databaru#supplyparts_v');
            }
        } //end input kanban supplyparts
        elseif ($this->input->post('pickup')) {
            $partno = trim($this->input->post('idpickup'));
            $backno4 = trim($this->input->post('backno4'));
            $prodver = trim($this->input->post('prodver4'));
            $qtyperpack = trim($this->input->post('qtyperpack4'));
            $boxtype = trim($this->input->post('boxtype4'));
            $side = trim($this->input->post('side4'));
            $selfpro = trim($this->input->post('selfpro4'));
            $storself = trim($this->input->post('storself4'));
            $nextpro = trim($this->input->post('nextpro4'));
            $stornext = trim($this->input->post('stornext4'));
            $keterangan = $this->input->post('keterangan');
            $cust = $this->kanban_master_m->check($partno);
            if ($cust == false) {
                $this->session->set_flashdata('message', 'Customer Part Number belum tersedia, mohon dilengkapi');
                redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
            } else {
                $cust = $cust[0]->CHR_CUS_PART_NO;
            }

            $partnodash = trim($this->input->post('idpickup'));
            $jmlpartno = strlen($partnodash);
            //add dash part no
            if ($jmlpartno < 14) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                };
            } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno > 17) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname7 = substr($partnodash, 17, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            }

            $x = $this->kanban_master_m->checkFlagpu($partno);
            if ($x == true) {
                $flag = $this->kanban_master_m->findBySql("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
                $flag = $flag[0]->CHR_FLAG_DELETE;
                if ($flag == 'X') {
                    $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                } else {
                    $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_SLOC_FROM, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5' AND CHR_SLOC_FROM = '$storself' AND CHR_BACK_NO = '$backno4' AND CHR_SLOC_TO = '$stornext' AND CHR_WC_VENDOR = '$prodver' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype' AND INT_QTY_PER_BOX = '$qtyperpack' ");

                    if ($cekdata) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    }

                    $cekall = $this->kanban_master_m->checkpv($partno, $prodver);
                    if ($cekall <> false) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Part No dengan production version yang sama sudah ada. Silahkan pilih Production Version atau Material lain');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    }

                    $cekqty = strlen($qtyperpack);
                    if ($cekqty == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    }

                    $cekbox = strlen($boxtype);
                    if ($cekbox == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    }

                    $lengthb = strlen($backno4);
                    if ($lengthb == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    }
                    // validasi backno
                    $checkbackno = $this->kanban_master_m->check_backno($backno4);
                    if ($checkbackno <> false) {
                        $bno = $checkbackno[0]->CHR_BACK_NO;
                        $cekpart = $this->kanban_master_m->checkpart($bno);
                        if ($cekpart <> false) {
                            $partnocek = $cekpart[0]->CHR_PART_NO;
                            $partnocek = trim($partnocek);
                            if ($partnocek <> $partno) {
                                $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                                redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                            }
                        }
                    }

                    //validasi backno lama dan baru
                    $checkbackno = $this->kanban_master_m->check_backno2($partno);
                    if ($checkbackno <> false) {
                        $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                        if ($checkbackno <> $backno4) {
                            $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                        }
                    }

                    //Add part number with dash
                    $cekdash = $this->kanban_master_m->checkPartDash($partno);
                    if ($cekdash <> false) {
                        $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                        if ($cekdash = NULL or $cekdash == '') {
                            $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                            $this->kanban_master_m->updateTMParts($t_data, $partno);
                        }
                    }

                    //save to tm kanban for pickup kanban
                    $t_data = array('CHR_PLANT' => '600',
                        'CHR_PART_NO' => $partno,
                        'CHR_BACK_NO' => strtoupper($backno4),
                        'INT_QTY_PER_BOX' => $qtyperpack,
                        'CHR_BOX_TYPE' => $boxtype,
                        'CHR_SIDE' => $side,
                        'CHR_SLOC_FROM' => $storself,
                        'CHR_WORK_CENTER' => $nextpro,
                        'CHR_SLOC_TO' => $stornext,
                        'CHR_WC_VENDOR' => $prodver,
                        'CHR_KANBAN_TYPE' => '5',
                        'CHR_DATE_CREATE' => date("Ymd"),
                        'CHR_DATE_CHANGE' => date("Ymd"),
                        'CHR_KETERANGAN' => strtoupper($keterangan),
                        'CHR_CUST_PART_NO' => $cust,
                        'CHR_PART_NO_DASH' => $partnodash,
                    );
                    $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');

                    if (isset($status)) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    } else {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    }
                }
            } else {
                $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_SLOC_FROM, CHR_WC_VENDOR, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5' AND CHR_SLOC_FROM = '$storself' AND CHR_BACK_NO = '$backno4' AND CHR_SLOC_TO = '$stornext' AND CHR_WC_VENDOR = '$prodver' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype' AND INT_QTY_PER_BOX = '$qtyperpack' ");

                if ($cekdata) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                }

                $cekall = $this->kanban_master_m->checkpv($partno, $prodver);
                if ($cekall <> false) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Part No dengan production version yang sama sudah ada. Silahkan pilih Production Version atau Material lain');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                }

                $cekqty = strlen($qtyperpack);
                if ($cekqty == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                }

                $cekbox = strlen($boxtype);
                if ($cekbox == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                }

                $lengthb = strlen($backno4);
                if ($lengthb == 0) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                }

                // validasi backno
                $checkbackno = $this->kanban_master_m->check_backno($backno4);
                if ($checkbackno <> false) {
                    $bno = $checkbackno[0]->CHR_BACK_NO;
                    $cekpart = $this->kanban_master_m->checkpart($bno);
                    if ($cekpart <> false) {
                        $partnocek = $cekpart[0]->CHR_PART_NO;
                        $partnocek = trim($partnocek);
                        $partno = trim($partno);
                        if ($partnocek <> $partno) {
                            $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                        }
                    }
                }

                //validasi backno lama dan baru
                $checkbackno = $this->kanban_master_m->check_backno2($partno);
                if ($checkbackno <> false) {
                    $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                    if ($checkbackno <> $backno4) {
                        $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                    }
                }

                //Add part number with dash
                $cekdash = $this->kanban_master_m->checkPartDash($partno);
                if ($cekdash <> false) {
                    $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                    if ($cekdash = NULL or $cekdash == '') {
                        $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                        $this->kanban_master_m->updateTMParts($t_data, $partno);
                    }
                }

                $t_data = array('CHR_PLANT' => '600',
                    'CHR_PART_NO' => $partno,
                    'CHR_BACK_NO' => strtoupper($backno4),
                    'INT_QTY_PER_BOX' => $qtyperpack,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_SIDE' => $side,
                    'CHR_SLOC_FROM' => $storself,
                    'CHR_WORK_CENTER' => $nextpro,
                    'CHR_SLOC_TO' => $stornext,
                    'CHR_WC_VENDOR' => $prodver,
                    'CHR_KANBAN_TYPE' => '5',
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_KETERANGAN' => strtoupper($keterangan),
                    'CHR_CUST_PART_NO' => $cust,
                    'CHR_PART_NO_DASH' => $partnodash,
                );
                $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');

                if (isset($status)) {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                } else {
                    echo 'not empty';
                    $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
                }
            }
            // else
        } //end pickup kanban submit
        elseif ($this->input->post('pickupp')) {
            $partno = trim($this->input->post('idpickupp'));
            $backno4 = trim($this->input->post('backno4p'));
            $qtyperpack = trim($this->input->post('qtyperpack4p'));
            $boxtype = trim($this->input->post('boxtype4p'));
            $side = trim($this->input->post('side4p'));
            $storself = trim($this->input->post('storself4p'));
            $stornext = trim($this->input->post('stornext4p'));
            $keterangan = $this->input->post('keterangan');
            $cust = $this->kanban_master_m->check($partno);
            if ($cust == false) {
                $this->session->set_flashdata('message', 'Customer Part Number belum tersedia, mohon dilengkapi');
                redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickup_v');
            } else {
                $cust = $cust[0]->CHR_CUS_PART_NO;
            }

            $partnodash = trim($this->input->post('idpickupp'));
            $jmlpartno = strlen($partnodash);
            //add dash part no
            if ($jmlpartno < 14) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                };
            } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            } elseif ($jmlpartno > 17) {
                $partname1 = substr($partnodash, 0, 6);
                $partname2 = substr($partnodash, 6, 5);
                $partname3 = substr($partnodash, 11, 2);
                $partname4 = substr($partnodash, 13, 2);
                $partname6 = substr($partnodash, 15, 2);
                $partname7 = substr($partnodash, 17, 2);
                $partname5 = "-";
                $partnodash = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                $partnodash = trim($partnodash);
                $length2 = strlen($partnodash);
                if (substr($partnodash, 0, 1) == "-") {//delete - pertama
                    $partnodash = substr($partnodash, 1);
                    $length2 = strlen($partnodash);
                }
                if (substr($partnodash, -1) == "-") {//delete minus terakhir
                    $partnodash = rtrim($partnodash, "-");
                }
            }

            $x = $this->kanban_master_m->checkFlagpup($partno);
            if ($x == true) {
                $flag = $this->kanban_master_m->findBySql("SELECT CHR_FLAG_DELETE FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
                $flag = $flag[0]->CHR_FLAG_DELETE;
                if ($flag == 'X') {
                    $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                } else {
                    $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_SLOC_FROM, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '6' AND CHR_SLOC_FROM = '$storself' AND CHR_BACK_NO = '$backno4' AND CHR_SLOC_TO = '$stornext' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype' AND INT_QTY_PER_BOX = '$qtyperpack' ");
                    if ($cekdata) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                    }

                    $cekall = $this->kanban_master_m->checkpvp($partno, $storself, $stornext);
                    if ($cekall == true) {
                        $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                    }

                    $cekqty = strlen($qtyperpack);
                    $cekbox = strlen($boxtype);
                    $lengthb = strlen($backno4);
                    $cekp = strlen($partno);


                    if ($cekqty == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                    }


                    if ($cekbox == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                    }


                    if ($lengthb == 0) {
                        echo 'not empty';
                        $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                    }

                    // validasi backno
                    $checkbackno = $this->kanban_master_m->check_backno($backno4);
                    if ($checkbackno <> false) {
                        $bno = $checkbackno[0]->CHR_BACK_NO;
                        $cekpart = $this->kanban_master_m->checkpart($bno);
                        if ($cekpart <> false) {
                            $partnocek = $cekpart[0]->CHR_PART_NO;
                            $partnocek = trim($partnocek);
                            $partno = trim($partno);
                            if ($partnocek <> $partno) {
                                $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                                redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                            }
                        }
                    }

                    //validasi backno lama dan baru
                    $checkbackno = $this->kanban_master_m->check_backno2($partno);
                    if ($checkbackno <> false) {
                        $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                        if ($checkbackno <> $backno4) {
                            $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                        }
                    }

                    //Add part number with dash
                    $cekdash = $this->kanban_master_m->checkPartDash($partno);
                    if ($cekdash <> false) {
                        $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                        if ($cekdash == NULL or $cekdash == '') {
                            $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                            $this->kanban_master_m->updateTMParts($t_data, $partno);
                        }
                    }

                    $t_data = array('CHR_PLANT' => '600',
                        'CHR_PART_NO' => $partno,
                        'CHR_BACK_NO' => strtoupper($backno4),
                        'INT_QTY_PER_BOX' => $qtyperpack,
                        'CHR_BOX_TYPE' => $boxtype,
                        'CHR_SIDE' => $side,
                        'CHR_WC_VENDOR' => '',
                        'CHR_SLOC_FROM' => $storself,
                        'CHR_SLOC_TO' => $stornext,
                        'CHR_KANBAN_TYPE' => '6',
                        'CHR_DATE_CREATE' => date("Ymd"),
                        'CHR_DATE_CHANGE' => date("Ymd"),
                        'CHR_KETERANGAN' => strtoupper($keterangan),
                        'CHR_CUST_PART_NO' => $cust,
                        'CHR_PART_NO_DASH' => $partnodash,
                    );
                    $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');
                }
            } else {
                $cekdata = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO, CHR_KANBAN_TYPE, CHR_BACK_NO, CHR_SLOC_TO, CHR_SLOC_FROM, CHR_SIDE, CHR_BOX_TYPE, INT_QTY_PER_BOX  FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '6' AND CHR_SLOC_FROM = '$storself' AND CHR_BACK_NO = '$backno4' AND CHR_SLOC_TO = '$stornext' AND CHR_SIDE = '$side' AND CHR_BOX_TYPE = '$boxtype' AND INT_QTY_PER_BOX = '$qtyperpack' ");
                if ($cekdata) {
                    $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                }

                $cekall = $this->kanban_master_m->checkpvp($partno, $storself, $stornext);
                if ($cekall == true) {
                    $this->session->set_flashdata('message', 'Kanban dengan data yang sama sudah ada');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                }

                $cekqty = strlen($qtyperpack);
                if ($cekqty == 0) {
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Data yang Masih Kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                }

                $cekbox = strlen($boxtype);
                if ($cekbox == 0) {
                    $this->session->set_flashdata('message', 'Silahkan Lengkapi Box Type');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                }

                $lengthb = strlen($backno4);
                if ($lengthb == 0) {
                    $this->session->set_flashdata('message', 'Back No. tidak boleh kosong');
                    redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                }

                // validasi backno
                $checkbackno = $this->kanban_master_m->check_backno($backno4);
                if ($checkbackno <> false) {
                    $bno = $checkbackno[0]->CHR_BACK_NO;
                    $cekpart = $this->kanban_master_m->checkpart($bno);
                    if ($cekpart <> false) {
                        $partnocek = $cekpart[0]->CHR_PART_NO;
                        $partnocek = trim($partnocek);
                        $partno = trim($partno);
                        if ($partnocek <> $partno) {
                            $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain');
                            redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                        }
                    }
                }
                //validasi backno lama dan baru
                $checkbackno = $this->kanban_master_m->check_backno2($partno);
                if ($checkbackno <> false) {
                    $checkbackno = trim($checkbackno[0]->CHR_BACK_NO);
                    if ($checkbackno <> $backno4) {
                        $this->session->set_flashdata('message', 'Back No. untuk Part No. ' . $partno . ' adalah ' . $checkbackno . ' ');
                        redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
                    }
                }

                //Add part number with dash
                $cekdash = $this->kanban_master_m->checkPartDash($partno);
                if ($cekdash <> false) {
                    $cekdash = $cekdash[0]->CHR_PART_NO_DASH;
                    if ($cekdash == NULL or $cekdash == '') {
                        $t_data = array('CHR_PART_NO_DASH' => $partnodash,);
                        $this->kanban_master_m->updateTMParts($t_data, $partno);
                    }
                }

                $t_data = array('CHR_PLANT' => '600',
                    'CHR_PART_NO' => $partno,
                    'CHR_BACK_NO' => strtoupper($backno4),
                    'INT_QTY_PER_BOX' => $qtyperpack,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_SIDE' => $side,
                    'CHR_WC_VENDOR' => '',
                    'CHR_SLOC_FROM' => $storself,
                    'CHR_SLOC_TO' => $stornext,
                    'CHR_KANBAN_TYPE' => '6',
                    'CHR_DATE_CREATE' => date("Ymd"),
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_KETERANGAN' => strtoupper($keterangan),
                    'CHR_CUST_PART_NO' => $cust,
                    'CHR_PART_NO_DASH' => $partnodash,
                );
                $status = $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN');
            }
            // else
            if ($status == true) {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Kanban berhasil disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
            } else {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Kanban gagal disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/databaru#pickupp_v');
            }
        } // end pickup passthrough submit


        $this->load->view($this->layout, $data);
    }

// END FUNCTION DATABARU
// FUNCTION MENU UPDATE
    public function updatemenu() {
        error_reporting(E_ALL & ~E_NOTICE);
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'kanban_master/updatemenu_v';
        $data['title'] = 'Kanban Master System';

        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(109);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('updateor')) {
            $tab = $this->input->post('updateor');
            $partno = trim($this->input->post('idorder'));
            $qtyperbox = trim($this->input->post('qpb'));
            $backno = trim($this->input->post('bn'));
            $backno = strtoupper($backno);
            $side = $this->input->post('side');
            $stor = $this->input->post('stor');
            $boxtype = $this->input->post('bt');
            $sid = trim($this->input->post('sud'));
            $ket = strtoupper($this->input->post('keterangan2'));

            $x = $this->kanban_master_m->cekFlagU($partno);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $validasibackno = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'backno' FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO <>'$partno'");
                $validasi = $validasibackno[0]->backno;

                if (isset($validasi)) {
                    $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain. Silahkan masukkan back no yang lain');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }

                // update back no di TM_KANBAN
                $t_data = array('CHR_BACK_NO' => $backno);
                $this->kanban_master_m->UpdateBackno($t_data, $partno);
                $this->kanban_master_m->UpdateBackno_All_STO($t_data, $partno);

                //update back no di TM_STO
                $chrjenisbox = $this->kanban_master_m->findBySql("SELECT TOP 1 CHR_UNIT FROM [dbo].[TT_PO_LINE] WHERE CHR_PART_NO = '$partno' ORDER BY CHR_SYS_DATE DESC");
                if (!empty($chrjenisbox)) {
                    $chrjenisbox = $chrjenisbox[0]->CHR_UNIT;
                    $chrjenisbox = trim($chrjenisbox);
                    if ($chrjenisbox == "ST") {
                        $chrjenisbox = "PC";
                    }
                } else {
                    $chrjenisbox = '';
                } //permintaan cipto 27/05/2016, revisi
                $t_data = array('CHR_BACK_NO' => $backno,
                    'INT_QTY_PER_BOX' => $qtyperbox,
                    'CHR_JENIS_BOX' => $chrjenisbox,
                );
                $this->kanban_master_m->UpdateBackno_TM_STO($t_data, $partno, $sid);

                // update data
                $t_data = array('INT_QTY_PER_BOX' => $qtyperbox,
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_SIDE' => $side,
                    'CHR_SLOC_FROM' => $stor,
                    'CHR_SLOC_TO' => $stor,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_KETERANGAN' => $ket,
                );

                $returnupdate = $this->kanban_master_m->UpdateDataOr($t_data, $partno, '0', $sid);
                if ($returnupdate) {
                    $this->session->set_flashdata('message', 'Kanban berhasil diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                } else {
                    $this->session->set_flashdata('message', 'Kanban gagal diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }
            }
        } elseif ($this->input->post('updatepr')) {
            $tab = $this->input->post('updatepr');
            $qtyperbox = $this->input->post('qpb1');
            $partno = trim($this->input->post('idproses'));
            $backno = trim($this->input->post('bn1'));
            $backno = strtoupper($backno);
            $side = $this->input->post('side1');
            $selfpro = $this->input->post('sp1');
            $ss = $this->input->post('ss1');
            $np = $this->input->post('np1');
            $sn = $this->input->post('sn1');
            $boxtype = $this->input->post('bt1');
            $sid = trim($this->input->post('pv1'));
            $ket = strtoupper($this->input->post('keterangan1'));
            $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_WC_VENDOR = '$sid' AND CHR_WORK_CENTER = '$selfpro' AND CHR_SLOC_TO = '$sn'  ");
            $nokanban = $nokanban[0]->INT_KANBAN_NO;

            $validasibackno = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'backno' FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO <>'$partno'");
            $x = $this->kanban_master_m->cekFlagU($partno);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $validasi = $validasibackno[0]->backno;
                if (isset($validasi)) {
                    $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain. Silahkan masukkan back no yang lain');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }
                // update back no
                $t_data = array('CHR_BACK_NO' => $backno);
                $this->kanban_master_m->UpdateBackno($t_data, $partno);

                // update data
                $t_data = array('INT_QTY_PER_BOX' => $qtyperbox,
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_SIDE' => $side,
                    'CHR_SLOC_FROM' => $ss,
                    'CHR_WORK_CENTER' => $np,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_KETERANGAN' => $ket,
                );

                $returnupdate = $this->kanban_master_m->UpdateDataOr($t_data, $partno, '1', $sid);
                if ($returnupdate) {
                    $this->session->set_flashdata('message', 'Kanban berhasil diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                } else {
                    $this->session->set_flashdata('message', 'Kanban gagal diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }
            }
        } elseif ($this->input->post('updatesp')) {
            $tab = $this->input->post('updatesp');
            $qtyperbox = $this->input->post('qpb2');
            $partno = trim($this->input->post('idsupply'));
            $backno = trim($this->input->post('bn2'));
            $backno = strtoupper($backno);
            $side = $this->input->post('side2');
            $stor = $this->input->post('stor2');
            $boxtype = $this->input->post('bt2');
            $sid = trim($this->input->post('sud2'));
            $ket = strtoupper($this->input->post('keterangan4'));
            $kanbantype = '4';
            $validasibackno = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'backno' FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO <> '$partno'");

            $x = $this->kanban_master_m->cekFlagU($partno);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $validasi = $validasibackno[0]->backno;
                if (isset($validasi)) {
                    $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain. Silahkan masukkan back no yang lain');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }

                // update back no di TM_KANBAN
                $t_data = array('CHR_BACK_NO' => $backno);
                $this->kanban_master_m->UpdateBackno($t_data, $partno);

                //update back no di TM_STO
                $chrjenisbox = $this->kanban_master_m->findBySql("SELECT TOP 1 CHR_UNIT FROM [dbo].[TT_PO_LINE] WHERE CHR_PART_NO = '$partno' ORDER BY CHR_SYS_DATE DESC");
                if (!empty($chrjenisbox)) {
                    $chrjenisbox = $chrjenisbox[0]->CHR_UNIT;
                    $chrjenisbox = trim($chrjenisbox);
                    if ($chrjenisbox == "ST") {
                        $chrjenisbox = "PC";
                    }
                } else {
                    $chrjenisbox = '';
                } //permintaan cipto 27/05/2016, revisi
                $t_data = array('CHR_BACK_NO' => $backno,
                    'INT_QTY_PER_BOX' => $qtyperbox,
                    'CHR_JENIS_BOX' => $chrjenisbox,
                );
                $this->kanban_master_m->UpdateBackno_TM_STO($t_data, $partno, $sid);

                // update data
                $t_data = array('INT_QTY_PER_BOX' => $qtyperbox,
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_SIDE' => $side,
                    'CHR_SLOC_FROM' => $stor,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_KETERANGAN' => $ket,
                );

                $returnupdate = $this->kanban_master_m->UpdateDataOr($t_data, $partno, '4', $sid);
                if ($returnupdate) {
                    $this->session->set_flashdata('message', 'Kanban berhasil diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                } else {
                    $this->session->set_flashdata('message', 'Kanban gagal diupdate');
                    redirect(base_url() . 'index.php/pes/kanban_master/updatemenu');
                }
            }
        } elseif ($this->input->post('updatepu')) {
            $tab = $this->input->post('updatepu');
            $qtyperbox = trim($this->input->post('qpb3'));
            $partno = trim($this->input->post('idpickup'));
            $backno = trim($this->input->post('bn3'));
            $backno = strtoupper($backno);
            $side = trim($this->input->post('side3'));
            $ss = trim($this->input->post('ss3'));
            $selfpro = trim($this->input->post('sp3'));
            $sn = trim($this->input->post('sn3'));
            $np = trim($this->input->post('np3'));
            $boxtype = trim($this->input->post('bt3'));
            $sid = trim($this->input->post('pv3'));
            $ket = strtoupper($this->input->post('keterangan3'));
            
            $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_WC_VENDOR = '$sid' AND CHR_WORK_CENTER = '$selfpro' AND CHR_SLOC_TO = '$sn'  ");
            $nokanban = $nokanban[0]->INT_KANBAN_NO;
            $validasibackno = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'backno' FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO <> '$partno'");

            $x = $this->kanban_master_m->cekFlagU($partno);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $validasi = $validasibackno[0]->backno;
                if (isset($validasi)) {
                    $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain. Silahkan masukkan back no yang lain');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }
                // update back no
                $t_data = array('CHR_BACK_NO' => $backno);
                $this->kanban_master_m->UpdateBackno($t_data, $partno);
                //update Quantity
                $t_data = array('INT_QTY_PER_BOX' => $qtyperbox,);
                $this->kanban_master_m->UpdateDataPass($t_data, $partno, $sn);
                // update data
                $t_data = array('INT_QTY_PER_BOX' => $qtyperbox,
                    'CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_SIDE' => $side,
                    'CHR_SLOC_FROM' => $ss,
                    'CHR_WORK_CENTER' => $np,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_KETERANGAN' => $ket,
                    'CHR_WC_VENDOR' => $sid,
                );

                $returnupdate = $this->kanban_master_m->UpdateDataOr($t_data, $partno, '5', $sid);
                if ($returnupdate) {
                    $this->session->set_flashdata('message', 'Kanban berhasil diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                } else {
                    $this->session->set_flashdata('message', 'Kanban gagal diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }
            }
        } elseif ($this->input->post('updatepup')) {
            $tab = $this->input->post('updatepup');
            $qtyperbox = trim($this->input->post('qpb3p'));
            $partno = trim($this->input->post('idpickupp'));
            $backno = trim($this->input->post('bn3p'));
            $backno = strtoupper($backno);
            $side = trim($this->input->post('side3p'));
            $sp = trim($this->input->post('ss3p'));
            $boxtype = trim($this->input->post('bt3p'));
            $np = trim($this->input->post('sn3p'));
            $ket = strtoupper($this->input->post('keterangan3p'));
            $validasibackno = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO 'backno' FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO <> '$partno'");

            $x = $this->kanban_master_m->cekFlagU($partno);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $validasi = $validasibackno[0]->backno;
                if (isset($validasi)) {
                    $this->session->set_flashdata('message', 'Back No. sudah digunakan untuk material lain. Silahkan masukkan back no yang lain');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }
                // update back no
                $t_data = array('CHR_BACK_NO' => $backno);
                $this->kanban_master_m->UpdateBackno($t_data, $partno);
                //update Quantity
                $t_data = array('INT_QTY_PER_BOX' => $qtyperbox,);
                $this->kanban_master_m->UpdateDataPass($t_data, $partno, $np);
                // update data
                $t_data = array('CHR_DATE_CHANGE' => date("Ymd"),
                    'CHR_SIDE' => $side,
                    'CHR_SLOC_FROM' => $sp,
                    'CHR_BOX_TYPE' => $boxtype,
                    'CHR_SLOC_TO' => $np,
                    'CHR_KETERANGAN' => $ket,
                );

                $returnupdate = $this->kanban_master_m->UpdateDataPass2($t_data, $partno, $np, $sp, '6');
                if ($returnupdate) {
                    $this->session->set_flashdata('message', 'Kanban berhasil diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                } else {
                    $this->session->set_flashdata('message', 'Kanban gagal diupdate');
                    redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
                }
            }
        } elseif ($this->input->post('activecontrolor')) {
            $sid = trim($this->input->post('sud'));
            $tab = $this->input->post('activecontrolor');
            $idorder = trim($this->input->post('idorder'));
            $x = $this->kanban_master_m->cekFlagUS($idorder,$sid);
            $t_data = array('CHR_FLAG_DELETE' => 'X',
                'CHR_DATE_DEL' => date("Ymd"));
            if($x == true)
            {
                $t_data = array('CHR_FLAG_DELETE' => NULL,
                'CHR_DATE_DEL' => date("Ymd"));
            }
            $returndelete = $this->kanban_master_m->UpdateFlagSts($t_data, $idorder, $sid);
            //$this->db->query("DELETE FROM TM_STO WHERE  CHR_ID_PART='$iddelete' AND CHR_BACK_NO='$backno' and CHR_KODE_VENDOR='$sid';");
            if ($x == true) {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Tidak Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            }
        } elseif ($this->input->post('activecontrolpr')) {
            $pv = trim($this->input->post('pv1'));
            $tab = $this->input->post('activecontrolpr');
            $idproses = trim($this->input->post('idproses'));
            $x = $this->kanban_master_m->cekFlagUS($idproses,$pv);
            $t_data = array('CHR_FLAG_DELETE' => 'X',
                'CHR_DATE_DEL' => date("Ymd"));
            if($x == true)
            {
                $t_data = array('CHR_FLAG_DELETE' => NULL,
                'CHR_DATE_DEL' => date("Ymd"));
            }
            $returndelete = $this->kanban_master_m->UpdateFlagSts($t_data, $idproses, $pv); //$idorder
            //$this->db->query("DELETE FROM TM_STO WHERE  CHR_ID_PART='$iddelete' AND CHR_BACK_NO='$backno' and CHR_KODE_VENDOR='$sid';");
            if ($x == true) {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Tidak Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } 
        }  elseif ($this->input->post('activecontrolsp')) {
            $sid = trim($this->input->post('sud2'));
            $tab = $this->input->post('activecontrolsp');
            $idsupply = trim($this->input->post('idsupply'));
            $x = $this->kanban_master_m->cekFlagUS($idsupply,$sid);
            $t_data = array('CHR_FLAG_DELETE' => 'X',
                'CHR_DATE_DEL' => date("Ymd"));
            if($x == true)
            {
                $t_data = array('CHR_FLAG_DELETE' => NULL,
                'CHR_DATE_DEL' => date("Ymd"));
            }
            $returndelete = $this->kanban_master_m->UpdateFlagSts($t_data, $idsupply, $sid);
            //$this->db->query("DELETE FROM TM_STO WHERE  CHR_ID_PART='$iddelete' AND CHR_BACK_NO='$backno' and CHR_KODE_VENDOR='$sid';");
            if ($x == true) {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Tidak Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } 
        } elseif ($this->input->post('activecontrolpu')) {
            $pv = trim($this->input->post('pv3'));
            $tab = $this->input->post('activecontrolpu');
            $idpickup = trim($this->input->post('idpickup'));
            $x = $this->kanban_master_m->cekFlagUS($idpickup,$pv);
            $t_data = array('CHR_FLAG_DELETE' => 'X',
                'CHR_DATE_DEL' => date("Ymd"));
            if($x == true)
            {
                $t_data = array('CHR_FLAG_DELETE' => NULL,
                'CHR_DATE_DEL' => date("Ymd"));
            }
            $returndelete = $this->kanban_master_m->UpdateFlagSts($t_data, $idpickup, $pv);
            //$this->db->query("DELETE FROM TM_STO WHERE  CHR_ID_PART='$iddelete' AND CHR_BACK_NO='$backno' and CHR_KODE_VENDOR='$sid';");
            if ($x == true) {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Tidak Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } 
        }  elseif ($this->input->post('activecontrolpup')) {
            $slt = trim($this->input->post('sn3p'));
            $tab = $this->input->post('activecontrolpup');
            $idpickupp = trim($this->input->post('idpickupp'));
            $x = $this->kanban_master_m->cekFlagUSP($idpickupp,$slt);
            $t_data = array('CHR_FLAG_DELETE' => 'X',
                'CHR_DATE_DEL' => date("Ymd"));
            if($x == true)
            {
                $t_data = array('CHR_FLAG_DELETE' => NULL,
                'CHR_DATE_DEL' => date("Ymd"));
            }
            $returndelete = $this->kanban_master_m->UpdateFlagStsUp($t_data, $idpickupp, $slt);
            //$this->db->query("DELETE FROM TM_STO WHERE  CHR_ID_PART='$iddelete' AND CHR_BACK_NO='$backno' and CHR_KODE_VENDOR='$sid';");
            if ($x == true) {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Status Kanban Menjadi Tidak Aktif');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } 
        }  elseif ($this->input->post('deleteor')) {
            $sid = trim($this->input->post('sud'));
            $tab = $this->input->post('deleteor');
            $iddelete = trim($this->input->post('idorder'));
            $backno = trim($this->input->post('bn'));
            $backno = strtoupper($backno);
            //$t_data = array('CHR_FLAG_DELETE' => 'X',
                //'CHR_DATE_DEL' => date("Ymd"));
            $returndelete = $this->kanban_master_m->DeleteDataKanban($iddelete,$sid);
            //$returndelete = $this->kanban_master_m->UpdateFlag($t_data, $iddelete);
            $this->db->query("DELETE FROM TM_STO WHERE  CHR_ID_PART='$iddelete' AND CHR_BACK_NO='$backno' and CHR_KODE_VENDOR='$sid';");
            if ($returndelete) {
                $this->session->set_flashdata('message', 'Kanban berhasil dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Kanban gagal dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            }
        } elseif ($this->input->post('deletepr')) {
            $pv = trim($this->input->post('pv1'));
            $tab = $this->input->post('deletepr');
            $iddelete = trim($this->input->post('idproses'));
            //$t_data = array('CHR_FLAG_DELETE' => 'X',
                //'CHR_DATE_DEL' => date("Ymd"));
            $returndelete = $this->kanban_master_m->DeleteDataKanban($iddelete,$pv);
            if ($returndelete) {
                $this->session->set_flashdata('message', 'Kanban berhasil dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Kanban gagal dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            }
        } elseif ($this->input->post('deletesp')) {
            $sid = trim($this->input->post('sud2'));
            $tab = $this->input->post('deletesp');
            $iddelete = trim($this->input->post('idsupply'));
            /*$t_data = array('CHR_FLAG_DELETE' => 'X',
                'CHR_DATE_DEL' => date("Ymd")
            );*/
            $returndelete = $this->kanban_master_m->DeleteDataKanban($iddelete,$sid);
            if ($returndelete) {
                $this->session->set_flashdata('message', 'Kanban berhasil dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Kanban gagal dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            }
        } elseif ($this->input->post('deletepu')) {
             $pv = trim($this->input->post('pv3'));
            $tab = $this->input->post('deletepu');
            $iddelete = trim($this->input->post('idpickup'));
            //$t_data = array('CHR_FLAG_DELETE' => 'X',
            //    'CHR_DATE_DEL' => date("Ymd"));
            $returndelete = $this->kanban_master_m->DeleteDataKanban($iddelete, $pv);
            if ($returndelete) {
                $this->session->set_flashdata('message', 'Kanban berhasil dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Kanban gagal dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            }
        } elseif ($this->input->post('deletepup')) {
            $slt = trim($this->input->post('sn3p'));
            $tab = $this->input->post('deletepup');
            $iddelete = trim($this->input->post('idpickupp'));
            /*$t_data = array('CHR_FLAG_DELETE' => 'X',
                'CHR_DATE_DEL' => date("Ymd"));*/
            $returndelete = $this->kanban_master_m->DeleteDataKanbanUp($iddelete,$slt);
            if ($returndelete) {
                $this->session->set_flashdata('message', 'Kanban berhasil dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            } else {
                $this->session->set_flashdata('message', 'Kanban gagal dihapus');
                redirect(base_url() . "index.php/pes/kanban_master/updatemenu$tab");
            }
        }
        $this->load->view($this->layout, $data);
    }

// END MENU UPDATE
// FUNCTION PRINT
    public function print_kanban() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $data['content'] = 'kanban_master/print_kanban_v';
        $data['title'] = 'Kanban Master System';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(112);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('printor')) {
            $d['idorder'] = trim($_POST['idorder']);
            $partno_old = trim($this->input->post('idorder'));
            $backno = trim($this->input->post('back_no'));
            $stor = trim($this->input->post('stor'));
            $partname = trim($this->input->post('pname'));
            $sname = trim($this->input->post('sname'));
            $keterangan = $_POST['keterangan2'];
            $sid = trim($_POST['sid']);
            $side = trim($_POST['side']);
            $printqty = $this->input->post('printqtyor');
            $qtyperbox = $this->input->post('qtyperbox');
            $boxtype = $this->input->post('boxtype');
            $type = '0';
            if ($side == "NONE") {
                $side = "";
            }

            $x = $this->kanban_master_m->cekFlagU($partno_old);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/print_kanban');
            } else {
                $jmlpartno = strlen($partno_old);
                $partno = $partno_old;
                //add dash part no
                if ($jmlpartno < 14) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    };
                } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno > 17) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname7 = substr($partno, 17, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                }
                $nokanban = $this->kanban_master_m->check_nokanban($type, $partno_old, $sid);
                if (!false) {
                    $kanban_no = $nokanban[0]->nokanban;
                }
                if (!isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno'  FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO ='$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '10000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                            $t_data = array('INT_LAST_SERIAL' => $serial2[$i],
                            );
                            $this->kanban_master_m->UpdateLastSerial($t_data, $kanban_no);
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO='$kanban_no' ");
                        foreach ($q as $key => $value) {
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['nextpro'] = $sid;
                            $data['befpro'] = $sname;
                            $data['boxtype'] = strtoupper($boxtype);
                            $data['selflocation'] = $value->CHR_SLOC_FROM;
                            $data['nextlocation'] = $value->CHR_SLOC_TO;
                            $data['qtyperbox'] = $qtyperbox;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['specialorder'] = "";
                        $data['supplyid'] = $sname;
                        $data['partno'] = $partno;
                        $data['serialno'][$i] = $serial2[$i];
                    }
                } elseif (isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno'  FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO ='$kanban_no' AND INT_NUM_SERIAL LIKE '2%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '20000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );

                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO = '$kanban_no'");
                        foreach ($q as $key => $value) {
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['nextpro'] = $sid;
                            $data['befpro'] = $sname;
                            $data['boxtype'] = strtoupper($boxtype);
                            $data['selflocation'] = $value->CHR_SLOC_FROM;
                            $data['nextlocation'] = $value->CHR_SLOC_TO;
                            $data['qtyperbox'] = $qtyperbox;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $value->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['specialorder'] = "-SPECIAL ORDER";
                        $data['supplyid'] = $sname;
                        $data['partno'] = $partno;
                        $data['serialno'][$i] = $serial2[$i];
                    }
                }
                if(isset($_POST["checkboxC"])){
                    $data['buildout'] = '- BUILD OUT';
                }else{
                    $data['buildout'] = false;
                }
            }$iserialno++;
            $this->load->view('kanban_master/print_pdf_or', $data);
        } //end print order
        elseif ($this->input->post('printpr')) {
            $a['idproses'] = trim($_POST['idproses']);
            $partno_old = trim($this->input->post('idproses'));
            $backno = trim($this->input->post('back_no1'));
            $selfpro = trim($this->input->post('selfpro1'));
            $nextpro = trim($this->input->post('nextpro1'));
            $partname = trim($this->input->post('pname1'));
            $keterangan = $_POST['keterangan1'];
            $prodver1 = trim($_POST['prodver1']);
            $printqty = $this->input->post('printqty');
            $qtyperbox1 = $this->input->post('qtyperbox1');
            $type = '1';
            $slocfrom = trim($this->input->post('storself1'));
            $boxtype = $this->input->post('boxtype1');
            if ($slocfrom == "0") {
                $slocfrom = "";
            }
            $slocto = trim($this->input->post('stornext1'));
            $side = trim($_POST['side1']);
            if ($side == "NONE") {
                $side = "";
            }

            $x = $this->kanban_master_m->cekFlagU($partno_old);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/print_kanban#proses_v", "refresh");
            } else {
                $jmlpartno = strlen($partno_old);
                $partno = $partno_old;
                //add dash part no
                if ($jmlpartno < 14) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    };
                } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno > 17) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname7 = substr($partno, 17, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                }
                $nokanban = $this->kanban_master_m->check_nokanban($type, $partno_old, $prodver1);
                if (!false) {
                    $kanban_no = $nokanban[0]->nokanban;
                }
                if (isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno'  FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO ='$kanban_no' AND INT_NUM_SERIAL LIKE '2%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '20000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox1,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                        }

                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO ='$kanban_no'");
                        $data['selfprocess'] = $selfpro;
                        foreach ($q as $key => $value) {
                            $data['partno'] = $value->CHR_PART_NO;
                            $cust = trim($value->CHR_CUST_PART_NO);
                            if ($cust == "NULL") {
                                $cust = '';
                            }
                            $data['cust'] = $cust;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['selflocation'] = $slocfrom;
                            $data['nextprocess'] = $nextpro;
                            $data['nextlocation'] = $slocto;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox1;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $n = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO = '$partno_old' and CHR_PV ='prodver'");

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {
                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['specialorder'] = "-SPECIAL ORDER";
                            $data['partno'] = $partno;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['serialno'][$i] = $serial2[$i];
                    }
                } elseif (!isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno'  FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO ='$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '10000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox1,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                            $t_data = array('INT_LAST_SERIAL' => $serial2[$i],
                            );
                            $this->kanban_master_m->UpdateLastSerial($t_data, $kanban_no);
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO ='$kanban_no'");

                        $data['selfprocess'] = $selfpro;
                        foreach ($q as $key => $value) {
                            $data['partno'] = $value->CHR_PART_NO;
                            $cust = trim($value->CHR_CUST_PART_NO);
                            if ($cust == "NULL") {
                                $cust = '';
                            }
                            $data['cust'] = $cust;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['selflocation'] = $slocfrom;
                            $data['nextprocess'] = $nextpro;
                            $data['nextlocation'] = $slocto;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox1;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['partno'] = $partno;
                        $data['specialorder'] = "";
                        $data['serialno'][$i] = $serial2[$i];
                    }
                }
                if(isset($_POST["checkboxC"])){
                    $data['buildout'] = '- BUILD OUT';
                }else{
                    $data['buildout'] = false;
                }
            }$iserialno++;
            $this->load->view('kanban_master/print_pdf_pr', $data);
        } //end print proses
        elseif ($this->input->post('printsp')) {
            $c['idsupply'] = trim($_POST['idsupply']);
            $partno_old = trim($this->input->post('idsupply'));
            $backno = trim($this->input->post('backno3'));
            $stor = trim($this->input->post('stor3'));
            $sname = trim($this->input->post('sname3'));
            $sid3 = trim($_POST['sid3']);
            $qtyperbox4 = $this->input->post('qtyperbox4');
            $printqty = $this->input->post('printqty4');
            $partname = $this->input->post('pname3');
            $keterangan = $_POST['keterangan4'];
            $side = trim($_POST['side4']);
            $boxtype = $this->input->post('boxtype4');
            $type = '4';
            if ($side == "NONE") {
                $side = "";
            }
            $x = $this->kanban_master_m->cekFlagU($partno_old);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/print_kanban#supplyparts_v", "refresh");
            } else {
                $jmlpartno = strlen($partno_old);
                $partno = $partno_old;
                //add dash part no
                if ($jmlpartno < 14) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    };
                } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno > 17) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname7 = substr($partno, 17, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                }
                $nokanban = $this->kanban_master_m->check_nokanban($type, $partno_old, $sid3);
                if (!false) {
                    $kanban_no = $nokanban[0]->nokanban;
                }
                if (isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno'  FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO ='$kanban_no' AND INT_NUM_SERIAL LIKE '2%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '20000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox4,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                        }

                        $q = $this->kanban_master_m->findBySql("SELECT * FROM TM_KANBAN WHERE INT_KANBAN_NO = '$kanban_no'");

                        foreach ($q as $key => $value) {
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['nextpro'] = $sid3;
                            $data['befpro'] = $sname;
                            $data['selflocation'] = $value->CHR_SLOC_FROM;
                            $data['nextlocation'] = $value->CHR_SLOC_TO;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox4;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['specialorder'] = "-SPECIAL ORDER";
                        $data['partno'] = $partno;
                        $data['serialno'][$i] = $serial2[$i];
                    }
                } elseif (!isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("select TOP 1  TM_KANBAN_SERIAL.INT_NUM_SERIAL 'serialno' FROM [dbo].[TM_KANBAN_SERIAL] LEFT JOIN [dbo].[TM_KANBAN] ON TM_KANBAN_SERIAL.INT_KANBAN_NO  =  TM_KANBAN.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '4' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%'  ORDER  BY  TM_KANBAN_SERIAL.INT_NUM_SERIAL  DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '10000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox4,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                            $t_data = array('INT_LAST_SERIAL' => $serial2[$i],
                            );
                            $this->kanban_master_m->UpdateLastSerial($t_data, $kanban_no);
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO='$kanban_no' ");
                        foreach ($q as $key => $value) {
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['nextpro'] = $sid3;
                            $data['befpro'] = $sname;
                            $data['selflocation'] = $value->CHR_SLOC_FROM;
                            $data['nextlocation'] = $value->CHR_SLOC_TO;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox4;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['specialorder'] = "";
                        $data['partno'] = $partno;
                        $data['serialno'][$i] = $serial2[$i];
                    }
                }
            }$iserialno++;
            $this->load->view('kanban_master/print_pdf_sp', $data);
        } //end print supplyparts kanban
        elseif ($this->input->post('printpu')) {
            $b['idpickup'] = trim($_POST['idpickup']);
            $partno_old = trim($this->input->post('idpickup'));
            $backno = trim($this->input->post('back_no3'));
            $selfpro = trim($this->input->post('selfpro3'));
            $nextpro = trim($this->input->post('nextpro3'));
            $partname = trim($this->input->post('pnamepu'));
            $keterangan = $_POST['keterangan3'];
            $sid = trim($_POST['prodver3']);
            $side = trim($_POST['side3']);
            $printqty = $this->input->post('printqty3');
            $qtyperbox1 = $this->input->post('qtyperbox3');
            $type = '5';
            $slocfrom = trim($this->input->post('storself3'));
            $boxtype = $this->input->post('boxtype3');
            if ($slocfrom == "0") {
                $slocfrom = "";
            }
            $slocto = trim($this->input->post('stornext3'));
            if ($side == "NONE") {
                $side = "";
            }
            $x = $this->kanban_master_m->cekFlagU($partno_old);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/print_kanban#pickup_v", "refresh");
            } else {
                $jmlpartno = strlen($partno_old);
                $partno = $partno_old;
                //add dash part no
                if ($jmlpartno < 14) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    };
                } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno > 17) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname7 = substr($partno, 17, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                }
                $nokanban = $this->kanban_master_m->check_nokanban($type, $partno_old, $sid);
                if (!false) {
                    $kanban_no = $nokanban[0]->nokanban;
                }
                if (isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno' FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '2%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '20000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox1,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO ='$kanban_no' ");

                        foreach ($q as $key => $value) {
                            $data['partno'] = $value->CHR_PART_NO;
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['selfprocess'] = $selfpro;
                            $data['selflocation'] = $slocfrom;
                            $data['nextprocess'] = $nextpro;
                            $data['nextlocation'] = $slocto;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox1;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['partno'] = $partno;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['specialorder'] = "-SPECIAL ORDER";
                        $data['serialno'][$i] = $serial2[$i];
                    }
                } elseif (!isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno' FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '10000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox1,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                            $t_data = array('INT_LAST_SERIAL' => $serial2[$i],
                            );
                            $this->kanban_master_m->UpdateLastSerial($t_data, $kanban_no);
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO='$kanban_no'");

                        foreach ($q as $key => $value) {
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['selfprocess'] = $selfpro;
                            $data['selflocation'] = $slocfrom;
                            $data['nextprocess'] = $nextpro;
                            $data['nextlocation'] = $slocto;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox1;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['partno'] = $partno;
                            $data['nokanban'] = $nokanban;
                            $data['printqty'] = $printqty;
                            $data['partname'] = $partname;
                        }
                        $data['specialorder'] = "";
                        $data['serialno'][$i] = $serial2[$i];
                    }
                }
                if(isset($_POST["checkboxC"])){
                    $data['buildout'] = '- BUILD OUT';
                }else{
                    $data['buildout'] = false;
                }
            } $iserialno++;
            $this->load->view('kanban_master/print_pdf_pu', $data);
        } //end print pickup
        elseif ($this->input->post('printpup')) {
            $b['idpickupp'] = trim($_POST['idpickupp']);
            $partno_old = trim($this->input->post('idpickupp'));
            $backno = trim($this->input->post('back_no3p'));
            $keterangan = $_POST['keterangan3p'];
            $slocfrom = trim($_POST['storself3p']);
            if ($slocfrom == "0") {
                $slocfrom = "";
            } else {
                $slocfrom = $slocfrom;
            }
            $slocto = trim($_POST['stornext3p']);
            $side = trim($_POST['side3p']);
            if ($side == "NONE") {
                $side = "";
            }
            $printqty = trim($this->input->post('printqty3p'));
            $boxtype = trim($this->input->post('boxtype3p'));
            $partname = $this->input->post('pnamepup');
            $qtyperbox1 = trim($this->input->post('qtyperbox3p'));
            $type = '6';

            $x = $this->kanban_master_m->cekFlagU($partno_old);
            if ($x == true) {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . "index.php/pes/kanban_master/print_kanban#pickupp_v", "refresh");
            } else {
                $jmlpartno = strlen($partno_old);
                $partno = $partno_old;
                //add dash part no
                if ($jmlpartno < 14) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    };
                } elseif ($jmlpartno < 16 AND $jmlpartno > 13) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno < 18 AND $jmlpartno > 15) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                } elseif ($jmlpartno > 17) {
                    $partname1 = substr($partno, 0, 6);
                    $partname2 = substr($partno, 6, 5);
                    $partname3 = substr($partno, 11, 2);
                    $partname4 = substr($partno, 13, 2);
                    $partname6 = substr($partno, 15, 2);
                    $partname7 = substr($partno, 17, 2);
                    $partname5 = "-";
                    $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3 . $partname5 . $partname4 . $partname5 . $partname6 . $partname5 . $partname7;
                    $partno = trim($partno);
                    $length2 = strlen($partno);
                    if (substr($partno, 0, 1) == "-") {//delete - pertama
                        $partno = substr($partno, 1);
                        $length2 = strlen($partno);
                    }
                    if (substr($partno, -1) == "-") {//delete minus terakhir
                        $partno = rtrim($partno, "-");
                    }
                }
                $nokanban = $this->kanban_master_m->check_nokanbanpass($type, $partno_old, $slocto);
                if (!false) {
                    $kanban_no = $nokanban[0]->nokanban;
                }
                if (isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno' FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '2%' ORDER BY INT_NUM_SERIAL  DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '20000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox1,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO='$kanban_no'");

                        foreach ($q as $key => $value) {
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['selflocation'] = $slocfrom;
                            $data['nextlocation'] = $slocto;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox1;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;

                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {
                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;

                            $data['nokanban'] = $nokanban;
                            $data['partname'] = $partname;
                        }
                        $data['specialorder'] = "-SPECIAL ORDER";
                        $data['serialno'][$i] = $serial2[$i];
                        $data['partno'] = $partno;
                        $data['printqty'] = $printqty;
                    }
                } elseif (!isset($_POST["checkboxB"])) {
                    $serialno = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'serialno'  FROM [dbo].[TM_KANBAN_SERIAL] WHERE INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ORDER BY INT_NUM_SERIAL DESC");
                    if (!$serialno) {
                        $serialno[0]->serialno = '10000'; //untuk pertama select ke tm_kanban_serial ( default 10000 ) untuk special order default ganti ke 20000
                    }
                    $iserialno = $serialno[0]->serialno;
                    $iprintqty = (int) $printqty;
                    for ($i = 0; $i < $iprintqty; $i++) {
                        $no = 1 + $i;
                        $serial = $iserialno + $no;
                        $serial2[$i] = $serial;
                        $t_data = array('INT_NUM_SERIAL' => $serial2[$i],
                            'CHR_date_print' => date("Ymd"),
                            'CHR_DATE_CREATE' => date("Ymd"),
                            'CHR_DATE_CHANGE' => date("Ymd"),
                            'INT_QTY_PER_BOX' => $qtyperbox1,
                            'CHR_COD_PLANT' => '600',
                            'INT_KANBAN_NO' => $kanban_no
                        );
                        if (!isset($_POST["checkboxA"])) {
                            $this->kanban_master_m->addProduct($t_data, 'TM_KANBAN_SERIAL');
                            $this->kanban_master_m->Updateket("UPDATE [dbo].[TM_KANBAN] SET CHR_KETERANGAN = '$keterangan' where INT_KANBAN_NO = '$kanban_no'");
                            $t_data = array('INT_LAST_SERIAL' => $serial2[$i],
                            );
                            $this->kanban_master_m->UpdateLastSerial($t_data, $kanban_no);
                        }
                        $q = $this->kanban_master_m->findBySql("SELECT * FROM [dbo].[TM_KANBAN] WHERE INT_KANBAN_NO='$kanban_no'");

                        foreach ($q as $key => $value) {
                            $data['cust'] = $value->CHR_CUST_PART_NO;
                            $data['backno'] = strtoupper($backno);
                            $data['side'] = $side;
                            $data['kanbantype'] = $type;
                            $data['selflocation'] = $slocfrom;
                            $data['nextlocation'] = $slocto;
                            $data['boxtype'] = $boxtype;
                            $data['qtyperbox'] = $qtyperbox1;
                            $data['keterangan'] = strtoupper($keterangan);
                            $intVal = $kanban_no;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'] = $nokanban;
                        }
                        $data['specialorder'] = "";
                        $data['serialno'][$i] = $serial2[$i];
                        $data['partno'] = $partno;
                        $data['printqty'] = $printqty;
                        $data['partname'] = $partname;
                    }
                }
            } $iserialno++;
            $this->load->view('kanban_master/print_pdf_pup', $data);
        } //end pickup passthrough kanban

        $this->load->view($this->layout, $data);
    }

// END FUNCTION PRINT
// FUNCTION REPRINT
    public function reprint() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');
        $data['content'] = 'kanban_master/reprint_v';
        $data['title'] = 'Kanban Master System';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(113);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('reprintor')) {
            $a['idorder'] = trim($_POST['idorder']);
            $partno = $a;
            $sid = trim($_POST['sid']);
            $partname = $this->input->post('pname');
            $printqty = 1;
            $cek = $this->input->post('optradio');

            $type = '0';
            $x = $this->kanban_master_m->cekFlag($partno['idorder']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint');
            }

            if ($cek == 'B') {
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idorder]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='0' ");
                $kanban_no = $nokanban[0]->nokanban;
                // $qtyperbox= $this->input->post('qtyperbox');
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $custom = $this->input->post('custom');
                $n = strlen($custom);

                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);
                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '0' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idorder]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $side = trim($q[0]->CHR_SIDE);
                            if ($side == "NONE") {
                                $side = '';
                            }
                            $data['side'][$z][$i] = $side;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '0' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idorder]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");

                        for ($i = 0; $i < $printqty; $i++) {

                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $side = trim($q[0]->CHR_SIDE);
                            if ($side == "NONE") {
                                $side = '';
                            }
                            $data['side'][$z][$i] = $side;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $from = $this->input->post('fromor');
                $to = $this->input->post('toor');
                //$qtyperbox= $this->input->post('qtyperbox');
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idorder]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='0' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '0' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idorder]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    //$qtyperbox= $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX FROM TM_KANBAN_SERIAL WHERE INT_NUM_SERIAL BETW");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $side = trim($q[0]->CHR_SIDE);
                        if ($side == "NONE") {
                            $side = '';
                        }
                        $data['side'][$z][$i] = $side;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                        $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                        $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                        $data['qtyperbox'][$z][$i] = $q[$z]->Qty;
                        $data['suppname'] = $supname1;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_or', $data);
        } //end reprint order
        elseif ($this->input->post('reprintpr')) {
            $a['idproses'] = trim($_POST['idproses']);
            $partno = $a;
            $prodver = trim($_POST['prodver1']);
            $range = 1;
            $partname = $this->input->post('pname1');
            $printqty = 1;
            $cek = $this->input->post('optradio');
            $from = $this->input->post('frompr');
            $to = $this->input->post('topr');
            $qtyperbox = $this->input->post('qtyperbox1');
            $selfpro = $this->input->post('selfpro1');
            $nextpro = $this->input->post('nextpro1');
            $slocfrom = trim($this->input->post('storself1'));
            $type = '1';
            $x = $this->kanban_master_m->cekFlag($partno['idproses']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#proses_v');
            }
            if ($slocfrom == "0") {
                $slocfrom = "";
            }
            if ($cek == 'B') {
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idproses]' AND CHR_WC_VENDOR = '$prodver' AND CHR_KANBAN_TYPE='1' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = $this->input->post('custom1');
                $n = strlen($custom);
                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);

                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '1' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idproses]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($slocfrom);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom1');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '1' AND TM_KANBAN.CHR_PART_NO = '$partno[idproses]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($slocfrom);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idproses]' AND CHR_WC_VENDOR = '$prodver' AND CHR_KANBAN_TYPE='1' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '1' AND TM_KANBAN.CHR_PART_NO = '$partno[idproses]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");

                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = strtoupper($slocfrom);
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $selfpro;
                        $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                        $data['boxtype'][$z][$i] = strtoupper($q[0]->CHR_BOX_TYPE);
                        $data['qtyperbox'][$z][$i] = $q[$z]->Qty;
                        $data['suppname'] = $supname1;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                    }
                }
            }

            $data['range'] = $range;
            $data['printqty'] = $printqty;
            $this->load->view('kanban_master/reprint_pdf_pr', $data);
        }//end reprint proses
        elseif ($this->input->post('reprintsp')) {
            $a['idsupply'] = trim($_POST['idsupply']);
            $partno = $a;
            $sid = trim($_POST['sid3']);
            $partname = $this->input->post('pname3');
            $printqty = 1;
            $cek = $this->input->post('optradio');
            $type = '4';
            $x = $this->kanban_master_m->cekFlag($partno['idsupply']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#supplyparts_v');
            }
            if ($cek == 'B') {
                $qtyperbox = $this->input->post('qtyperbox4');
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idsupply]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='4' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = trim($this->input->post('custom2'));
                $n = strlen($custom);
                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);
                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '4' AND TM_KANBAN.CHR_PART_NO = '$partno[idsupply]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom2');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '4' AND TM_KANBAN.CHR_PART_NO = '$partno[idsupply]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_FROM);
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                            $data['nextlocation'][$z][$i] = strtoupper($q[0]->CHR_SLOC_TO);
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $from = $this->input->post('fromsp');
                $to = $this->input->post('tosp');
                $qtyperbox = $this->input->post('qtyperbox4');
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($sid);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idsupply]' AND CHR_WC_VENDOR = '$sid' AND CHR_KANBAN_TYPE='4' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '4' AND TM_KANBAN.CHR_PART_NO = '$partno[idsupply]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $q[0]->CHR_WC_VENDOR;
                        $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                        $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                        $data['qtyperbox'][$z][$i] = $q[$z]->Qty;
                        $data['suppname'] = $supname1;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_sp', $data);
        } //end reprint supplyparts
        elseif ($this->input->post('reprintpu')) {
            $a['idpickup'] = trim($_POST['idpickup']);
            $partno = $a;
            $prodver = trim($_POST['prodver3']);
            $range = 1;
            $partname = $this->input->post('pnamepu');
            $printqty = 1;
            $cek = $this->input->post('optradio');
            $from = trim($this->input->post('frompu'));
            $to = trim($this->input->post('topu'));
            $qtyperbox = $this->input->post('qtyperbox3');
            $selfpro = $this->input->post('selfpro3');
            $nextpro = $this->input->post('nextpro3');
            $slocfrom = trim($this->input->post('storself3'));
            $type = '5';
            $x = $this->kanban_master_m->cekFlag($partno['idpickup']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#pickup_v');
            }
            if ($slocfrom == "0") {
                $slocfrom = "";
            }

            if ($cek == 'B') {
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickup]' AND CHR_WC_VENDOR = '$prodver' and CHR_KANBAN_TYPE='5' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = trim($this->input->post('custom4'));
                $n = strlen($custom);

                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);

                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '5' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idpickup]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $slocfrom;
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = trim($this->input->post('custom4'));

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '5' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idpickup]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");
                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $cust = $q[0]->CHR_CUST_PART_NO;
                            if ($cust == NULL) {
                                $cust = '';
                            }
                            $data['cust'][$z][$i] = $cust;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $slocfrom;
                            $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                            $data['selfprocess'][$z][$i] = $selfpro;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $data['suppname'] = $supname1;
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $range = ((int) $to - (int) $from) + 1;
                $supname = $this->kanban_master_m->checkSuppname($prodver);
                if ($supname == false) {
                    $supname1 = '';
                } else {
                    $supname1 = $supname[0]->CHR_SUPPLIER_NAME;
                }
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickup]' AND CHR_WC_VENDOR = '$prodver' AND CHR_KANBAN_TYPE='5' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '5' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idpickup]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = $slocfrom;
                        $data['nextprocess'][$z][$i] = $q[0]->CHR_WORK_CENTER;
                        $data['selfprocess'][$z][$i] = $selfpro;
                        $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                        $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                        $data['qtyperbox'][$z][$i] = $q[$z]->Qty;
                        $data['suppname'] = $supname1;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_pu', $data);
        } //end reprint pickup
        elseif ($this->input->post('reprintpup')) {
            $a['idpickupp'] = trim($_POST['idpickupp']);
            $partno = $a;
            $range = 1;
            $partname = $this->input->post('pnamepup');
            $printqty = 1;
            $ss = $this->input->post('storself3p');
            $sn = $this->input->post('stornext3p');
            $qtyperbox = $this->input->post('qtyperbox3p');
            $cek = $this->input->post('optradio');
            $from = $this->input->post('frompup');
            $to = $this->input->post('topup');
            $type = '6';
            $x = $this->kanban_master_m->cekFlagpass($partno['idpickupp']);
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                $this->session->set_flashdata('message', 'Data Telah Dihapus.');
                redirect(base_url() . 'index.php/pes/kanban_master/reprint#pickupp_v');
            }

            if ($cek == 'B') {
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickupp]' AND CHR_SLOC_TO = '$sn' AND CHR_KANBAN_TYPE='6' ");
                $kanban_no = $nokanban[0]->nokanban;
                $custom = $this->input->post('custom4p');
                $n = strlen($custom);

                if ($n > 5) {
                    $custom = trim($custom);
                    $custom = explode(',', $custom);
                    $range = count($custom);

                    for ($z = 0; $z < $range; $z++) {
                        $custom1 = $custom[$z];
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '6' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idpickupp]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom1' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom1;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                } else if ($n == 5) {
                    $range = 1;
                    $custom = $this->input->post('custom4p');

                    for ($z = 0; $z < $range; $z++) {
                        $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '6' AND TM_KANBAN.CHR_PART_NO = '$partno[idpickupp]' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL = '$custom' ");

                        for ($i = 0; $i < $printqty; $i++) {
                            $data['partno'] = $q[0]->CHR_PART_NO;
                            $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                            $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                            $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                            $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                            $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                            $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                            $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                            $data['qtyperbox'][$z][$i] = $q[0]->Qty;
                            $data['serialno'][$z][$i] = $custom;
                            $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                            $intVal = $q[0]->INT_KANBAN_NO;
                            $strVal = (string) $intVal;
                            $x = strlen($strVal);
                            $b = 5;
                            $y = $b - $x;
                            $no2 = 0;
                            for ($u = 0; $u < $y; $u++) {

                                $no1 = 0;
                                $no2 = $no2 . $no1;
                            }
                            $nokanban = $no2 . $strVal;
                            $data['nokanban'][$z][$i] = $nokanban;
                            $data['partname'] = $partname;
                        }
                    }
                }
            } elseif ($cek == 'A') {
                $range = ((int) $to - (int) $from) + 1;
                $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'nokanban' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno[idpickupp]' AND CHR_SLOC_FROM = '$ss' AND CHR_KANBAN_TYPE='6' ");
                $kanban_no = $nokanban[0]->nokanban;
                $serial = $this->kanban_master_m->findBySql("SELECT INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$kanban_no' AND INT_NUM_SERIAL LIKE '1%' ");
                $serialno = (int) $from - 1;

                for ($z = 0; $z < $range; $z++) {
                    $q = $this->kanban_master_m->findBySql("SELECT TM_KANBAN.CHR_KANBAN_TYPE, TM_KANBAN.INT_KANBAN_NO, TM_KANBAN.CHR_PART_NO, TM_KANBAN.CHR_BACK_NO, 
                            TM_KANBAN.CHR_WC_VENDOR, TM_KANBAN.CHR_WORK_CENTER, TM_KANBAN.CHR_SLOC_FROM, TM_KANBAN.CHR_SLOC_TO, TM_KANBAN.CHR_BOX_TYPE, TM_KANBAN.CHR_CUST_PART_NO, TM_KANBAN.INT_LAST_SERIAL, TM_KANBAN.CHR_SIDE, TM_KANBAN.CHR_FLAG_DELETE, TM_KANBAN.CHR_DATE_DEL, 
                         TM_KANBAN.CHR_DATE_CREATE, TM_KANBAN.CHR_DATE_CHANGE, TM_KANBAN.CHR_KETERANGAN, TM_KANBAN.CHR_PART_NO_DASH, 
                         TM_KANBAN_SERIAL.INT_QTY_PER_BOX AS Qty, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] 
                         ON TM_KANBAN.INT_KANBAN_NO  =  TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE TM_KANBAN_SERIAL.INT_KANBAN_NO = '$kanban_no' AND TM_KANBAN.CHR_KANBAN_TYPE = '6' 
                         AND TM_KANBAN.CHR_PART_NO = '$partno[idpickupp]' AND (TM_KANBAN_SERIAL.INT_NUM_SERIAL BETWEEN '$from' AND '$to') ");
                    for ($i = 0; $i < $printqty; $i++) {
                        $data['partno'] = $q[0]->CHR_PART_NO;
                        $data['cust'][$z][$i] = $q[0]->CHR_CUST_PART_NO;
                        $data['backno'][$z][$i] = strtoupper($q[0]->CHR_BACK_NO);
                        $data['side'][$z][$i] = $q[0]->CHR_SIDE;
                        $data['kanbantype'][$z][$i] = $q[0]->CHR_KANBAN_TYPE;
                        $data['selflocation'][$z][$i] = $q[0]->CHR_SLOC_FROM;
                        $data['nextlocation'][$z][$i] = $q[0]->CHR_SLOC_TO;
                        $data['boxtype'][$z][$i] = $q[0]->CHR_BOX_TYPE;
                        $data['qtyperbox'][$z][$i] = $q[$z]->Qty;
                        $data['serialno'][$z][$i] = $q[$z]->INT_NUM_SERIAL;
                        $data['keterangan'][$z][$i] = strtoupper($q[0]->CHR_KETERANGAN);
                        $intVal = $q[0]->INT_KANBAN_NO;
                        $strVal = (string) $intVal;
                        $x = strlen($strVal);
                        $b = 5;
                        $y = $b - $x;
                        $no2 = 0;
                        for ($u = 0; $u < $y; $u++) {

                            $no1 = 0;
                            $no2 = $no2 . $no1;
                        }
                        $nokanban = $no2 . $strVal;
                        $data['nokanban'][$z][$i] = $nokanban;
                        $data['partname'] = $partname;
                    }
                }
            }
            $data['printqty'] = $printqty;
            $data['range'] = $range;
            $this->load->view('kanban_master/reprint_pdf_pup', $data);
        } //end reprint pickup pasthrough

        $this->load->view($this->layout, $data);
    }

// END FUNCTION REPRINT
// FUNCTION MASS PRINT
    public function mass_print() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'kanban_master/mass_print';
        $data['title'] = 'Kanban Master System';
        $data['news'] = $this->news_m->get_news();
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(97);

        $data['idproses'] = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_KANBAN_NO FROM [dbo].[TM_KANBAN_SERIAL] LEFT JOIN [dbo].[TM_KANBAN] ON TM_KANBAN_SERIAL.INT_KANBAN_NO=TM_KANBAN.INT_KANBAN_NO  WHERE TM_KANBAN.CHR_KANBAN_TYPE = '1' ORDER BY TM_KANBAN_SERIAL.INT_KANBAN_NO ASC");
        $data['idpickup'] = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_KANBAN_NO FROM [dbo].[TM_KANBAN_SERIAL] LEFT JOIN [dbo].[TM_KANBAN] ON TM_KANBAN_SERIAL.INT_KANBAN_NO=TM_KANBAN.INT_KANBAN_NO  WHERE TM_KANBAN.CHR_KANBAN_TYPE = '5' ORDER BY TM_KANBAN_SERIAL.INT_KANBAN_NO ASC");

        $this->load->view($this->layout, $data);
    }

    public function massprintpr() {
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $jml = ((int) $to - (int) $from) + 1;
        $cek = $this->kanban_master_m->getDataprint("select TM_KANBAN.*, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE (TM_KANBAN.INT_KANBAN_NO BETWEEN '$from' AND '$to') AND TM_KANBAN.CHR_KANBAN_TYPE = '1'");
        $range = count($cek);
        if ($range > 1200) {
            $this->session->set_flashdata('message', 'Error. Maksimal print kanban');
            redirect(base_url() . 'index.php/pes/kanban_master/mass_print');
        } else {
            $alldata = $this->kanban_master_m->getDataprint("select TOP 1200 TM_KANBAN.*, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE (TM_KANBAN.INT_KANBAN_NO BETWEEN '$from' AND '$to') AND TM_KANBAN.CHR_KANBAN_TYPE = '1'");
            $jumlahkanban = count($alldata);
            $data['jml'] = $jumlahkanban;
            $x = 0;
            for ($i = 0; $i < $jumlahkanban; $i++) {
                $partno = trim($alldata[$i]->CHR_PART_NO);
                $data['backno'][$i] = $alldata[$i]->CHR_BACK_NO;
                $data['cust'][$i] = $alldata[$i]->CHR_CUST_PART_NO;
                $data['nextpro'][$i] = $alldata[$i]->CHR_WORK_CENTER;
                $data['slocfrom'][$i] = $alldata[$i]->CHR_SLOC_FROM;
                $data['slocto'][$i] = $alldata[$i]->CHR_SLOC_TO;
                $data['boxtype'][$i] = $alldata[$i]->CHR_BOX_TYPE;
                $data['qtyperbox'][$i] = $alldata[$i]->INT_QTY_PER_BOX;
                $data['serial'][$i] = $alldata[$i]->INT_NUM_SERIAL;
                $data['type'][$i] = $alldata[$i]->CHR_KANBAN_TYPE;
                $intVal = $alldata[$i]->INT_KANBAN_NO;
                $strVal = (string) $intVal;
                $x = strlen($strVal);
                $b = 5;
                $y = $b - $x;
                $no2 = 0;
                for ($u = 0; $u < $y; $u++) {
                    $no1 = 0;
                    $no2 = $no2 . $no1;
                }
                $nokanban = $no2 . $strVal;
                $data['nokanban'][$i] = $nokanban;
                $pv = $alldata[$i]->CHR_WC_VENDOR;
                $data['keterangan'][$i] = $alldata[$i]->CHR_KETERANGAN;
                $side = $alldata[$i]->CHR_SIDE;
                if ($side = "NONE") {
                    $data['side'][$i] = '';
                }
                $selfpro = $this->kanban_master_m->getSelfpro("SELECT CHR_WORK_CENTER FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO ='$partno' AND CHR_PV = '$pv' ");
                if ($selfpro) {
                    $data['selfpro'][$i] = $selfpro[0]->CHR_WORK_CENTER;
                } else {
                    $data['selfpro'][$i] = '';
                }
                $partname = $this->kanban_master_m->cekPartname($partno);
                if ($partname == false) {
                    $partname = '';
                } else {
                    $partname = $partname[0]->CHR_PART_NAME;
                }
                $data['partname'][$i] = trim($partname);
                $partname1 = substr($partno, 0, 6);
                $partname2 = substr($partno, 6, 5);
                $partname3 = substr($partno, 11, 2);
                $partname4 = substr($partno, 13, 2);
                $partname5 = "-";
                $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partno = trim($partno);
                $length2 = strlen($partno);
                if (substr($partno, 0, 1) == "-") {//delete - pertama
                    $partno = substr($partno, 1);
                    $length2 = strlen($partno);
                }
                if (substr($partno, -1) == "-") {//delete minus terakhir
                    $partno = rtrim($partno, "-");
                };
                $data['partno'][$i] = $partno;
            }
        }
        $this->load->view('kanban_master/mp_pr', $data);
    }

    public function massprintpu() {
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $jml = ((int) $to - (int) $from) + 1;
        $cek = $this->kanban_master_m->getDataprint("select INT_NUM_SERIAL FROM [dbo].[TM_KANBAN_SERIAL] WHERE (INT_KANBAN_NO BETWEEN '$from' AND '$to')");
        $range = count($cek);
        if ($range > 1200) {
            $this->session->set_flashdata('message', 'Error. Data melebihi kapasitas maksimal print');
            redirect(base_url() . 'index.php/pes/kanban_master/mass_print');
        } else {
            $alldata = $this->kanban_master_m->getDataprint("select TOP 1200 TM_KANBAN.*, TM_KANBAN_SERIAL.INT_NUM_SERIAL FROM [dbo].[TM_KANBAN] INNER JOIN [dbo].[TM_KANBAN_SERIAL] ON TM_KANBAN.INT_KANBAN_NO=TM_KANBAN_SERIAL.INT_KANBAN_NO WHERE (TM_KANBAN.INT_KANBAN_NO BETWEEN '$from' AND '$to') AND TM_KANBAN.CHR_KANBAN_TYPE = '5'");
            $jumlahkanban = count($alldata);
            $data['jml'] = $jumlahkanban;
            $x = 0;
            for ($i = 0; $i < $jumlahkanban; $i++) {
                $partno = trim($alldata[$i]->CHR_PART_NO);
                $data['backno'][$i] = $alldata[$i]->CHR_BACK_NO;
                $data['cust'][$i] = $alldata[$i]->CHR_CUST_PART_NO;
                $data['slocfrom'][$i] = $alldata[$i]->CHR_SLOC_FROM;
                $data['slocto'][$i] = $alldata[$i]->CHR_SLOC_TO;
                $data['boxtype'][$i] = $alldata[$i]->CHR_BOX_TYPE;
                $data['qtyperbox'][$i] = $alldata[$i]->INT_QTY_PER_BOX;
                $data['serial'][$i] = $alldata[$i]->INT_NUM_SERIAL;
                $data['type'][$i] = $alldata[$i]->CHR_KANBAN_TYPE;
                $data['side'][$i] = $alldata[$i]->CHR_SIDE;
                $intVal = $alldata[$i]->INT_KANBAN_NO;
                $strVal = (string) $intVal;
                $x = strlen($strVal);
                $b = 5;
                $y = $b - $x;
                $no2 = 0;
                for ($u = 0; $u < $y; $u++) {
                    $no1 = 0;
                    $no2 = $no2 . $no1;
                }
                $nokanban = $no2 . $strVal;
                $data['nokanban'][$i] = $nokanban;
                $pv = $alldata[$i]->CHR_WC_VENDOR;
                $ket = $alldata[$i]->CHR_KETERANGAN;
                if ($ket == NULL) {
                    $ket = "";
                }
                $data['keterangan'][$i] = $ket;
                // if ($side = "NONE") {
                //     $side="";
                // }
                $selfpro = $this->kanban_master_m->cekSelfpro($partno);
                if ($selfpro == false) {
                    $selfpro = '';
                } else {
                    $selfpro = $selfpro[0]->CHR_WORK_CENTER;
                }
                $data['selfpro'][$i] = $selfpro;
                $partname = $this->kanban_master_m->cekPartname1($partno);

                if ($partname == false) {
                    $partname = '';
                } else {
                    $partname = $partname[0]->CHR_PART_NAME;
                }
                $data['partname'][$i] = trim($partname);
                $partname1 = substr($partno, 0, 6);
                $partname2 = substr($partno, 6, 5);
                $partname3 = substr($partno, 11, 2);
                $partname5 = "-";
                $partno = $partname1 . $partname5 . $partname2 . $partname5 . $partname3;
                $partno = trim($partno);
                $length2 = strlen($partno);
                if (substr($partno, 0, 1) == "-") {//delete - pertama
                    $partno = substr($partno, 1);
                    $length2 = strlen($partno);
                }if (substr($partno, -1) == "-") {//delete minus terakhir
                    $partno = rtrim($partno, "-");
                };
                $data['partno'][$i] = $partno;
            }
        };
        $this->load->view('kanban_master/mp_pu', $data);
    }

// END FUNCTION MASS PRINT
// FUNCTION SAVE BOXTYPE BARU
    public function box_type() {

        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'kanban_master/box_type_v';
        $data['title'] = 'Master Box Type';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(71);
        $data['news'] = $this->news_m->get_news();

        if ($this->input->post('simpan')) {
            $jnsbox = strtoupper($this->input->post('jnsbox'));
            $panjang = $this->input->post('panjang');
            $lebar = $this->input->post('lebar');
            $tinggi = $this->input->post('tinggi');
            $exp = $this->input->post('exp');
            if ($jnsbox == "" or $panjang == "" or $lebar == "" or $tinggi == "") {
                $this->session->set_flashdata('message', 'Data gagal disimpan. Silahkan Lengkapi Data');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            }

            $cek = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE] WHERE CHR_BOX_TYPE = '$jnsbox'");
            if ($cek) {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Boxytpe sudah ada');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            }
            $t_data = array('CHR_BOX_TYPE' => $jnsbox,
                'CHR_LENGTH' => $panjang,
                'CHR_WIDTH' => $lebar,
                'CHR_HEIGHT' => $tinggi,
                'CHR_DESC' => $exp,
            );

            $status = $this->kanban_master_m->addProduct($t_data, 'TM_BOX_TYPE');
            if (isset($status)) {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Data berhasil disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            } else {
                echo 'not empty';
                $this->session->set_flashdata('message', 'Data gagal disimpan');
                redirect(base_url() . 'index.php/pes/kanban_master/box_type');
            }
        }



        $this->load->view($this->layout, $data);
    }

// END FUNCTION SAVE BOXTYPE BARU
// FUNCTION EDIT BOX TYPE
    public function mj_box() {
        $this->role_module_m->authorization('16');
        $this->session->userdata('user_id');

        $data['content'] = 'kanban_master/mj_box_v';
        $data['title'] = 'Master Box Type';
        $data['app'] = $this->role_module_m->get_app();
        $data['module'] = $this->role_module_m->get_module();
        $data['function'] = $this->role_module_m->get_function();
        $data['sidebar'] = $this->role_module_m->side_bar(71);
        $data['news'] = $this->news_m->get_news();

        $databox = $this->kanban_master_m->findBySql("SELECT DISTINCT * from TM_BOX_TYPE");
        $da = count($databox);
        $data['databox'] = $databox;
        $boxtype = $this->input->post('jnsbox');
        $length = $this->input->post('panjang');
        $width = $this->input->post('lebar');
        $height = $this->input->post('tinggi');
        $exp = $this->input->post('exp');
        $jml = count($boxtype);
        if ($this->input->post('simpan')) {
            for ($i = 0; $i < $jml; $i++) {
                $t_data = array('CHR_LENGTH' => $length[$i],
                    'CHR_WIDTH' => $width[$i],
                    'CHR_HEIGHT' => $height[$i],
                    'CHR_DESC' => $exp[$i]
                );
                $status = $this->kanban_master_m->UpdateBox($t_data, $boxtype[$i]);
            }
            if (isset($status)) {
                $this->session->set_flashdata('message', 'Data berhasil di-update');
                redirect(base_url() . 'index.php/pes/kanban_master/mj_box');
            } else {
                $this->session->set_flashdata('message', 'Data gagal di-update');
                redirect(base_url() . 'index.php/pes/kanban_master/mj_box');
            }
        }
        $this->load->view($this->layout, $data);
    }

// END FUNCTION EDIT BOX TYPE
// FUNCTION AJAX DATABARU
    function cekPartd() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$part'");

        echo json_encode($cek);
    }

    function cekPartpro() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO = '$part'");

        echo json_encode($cek);
    }

    function cekPartd2() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_VENDOR_PARTS] WHERE CHR_PART_NO = '$part'");
        echo json_encode($cek);
    }

    function getPart() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("select CHR_PART_NAME 'pname' from [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getSupplier() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_ID 'pname' from [dbo].[TM_VENDOR_PARTS] where CHR_PART_NO = '$partno'");

        $option = '';
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getBackno3() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("select CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getSupplierName() {
        $supplierid1 = trim($this->input->post('supplierid1'));
        $sup = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$supplierid1'");
        if ($sup) {
            echo $sup[0]->pname;
        } else {
            echo '';
        }
    }

    function stor() {
        $idorder = trim($this->input->post('idorder'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$idorder' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%') ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }
        echo $option;
    }

    function cekBackno1() {
        $part = trim($this->input->post('idorder', true));
        $backno = trim($this->input->post('backno1', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            // $checkbackno == 6;
            // echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getPartName() {
        $partno = trim($this->input->post('partno'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PART_NAME 'pname' from [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$partno'");

        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getIntPv() {
        $partno = trim($this->input->post('partno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PV 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getStorSelf() {
        $partno = trim($this->input->post('partno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%') AND CHR_SLOC <> 'WP01' ");
        $option .= "<option value=\"WP01\">WP01</option>";
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getBackno1() {
        $partno = trim($this->input->post('partno'));
        $partname = $this->kanban_master_m->findBySql("select CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {

            echo '';
        }
    }

    function getSelfpro() {
        $prodver = trim($this->input->post('prodver', TRUE));
        $partno = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getNextpro() {
        $prodver = trim($this->input->post('prodver', TRUE));
        $partno = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            $selfpro = $partname[0]->pname;
            $option = " ";
            $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS] WHERE CHR_WORK_CENTER <> '$selfpro' ");
            if (!empty($partname)) {
                foreach ($partname as $key => $value) {
                    $option .= "<option></option><option value=\"$value->pname\">$value->pname</option>";
                }
            }

            echo $option;
        } else {
            echo '';
        }
    }

    function getStorNext() {
        $prodver = trim($this->input->post('prodver', TRUE));
        $partno = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC_TO 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$partno' AND CHR_PV ='$prodver' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC_TO LIKE 'WH%' OR CHR_SLOC_TO LIKE 'WP%' OR CHR_SLOC_TO LIKE 'PP%') ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function cekBackno2() {
        $part = trim($this->input->post('idproses', true));
        $backno = trim($this->input->post('backno', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            // $checkbackno == 6;
            // echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getSupplier1() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SUPPLIER_ID 'pname' from [dbo].[TM_VENDOR] ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function Stor3() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%') ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getSupplierName3() {
        $supplierid3 = trim($this->input->post('supplierid3'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$supplierid3'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function cekBackno3() {
        $part = trim($this->input->post('idsupply', true));
        $backno = trim($this->input->post('backno3', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            // $checkbackno == 6;
            // echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getStorSelf1() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%') AND CHR_SLOC <> 'WP01' ");
        if (!empty($partname)) {
            $option .= "<option value=\"WP01\">WP01</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getBoxtype() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_BOX_TYPE FROM [dbo].[TM_KANBAN]");
        $option = '';

        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
        }

        echo $option;
    }

    function getBoxtypePick() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $option = '';

        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
        }

        echo $option;
    }

    function getStorNext4d1() {
        $prodver = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_PROCESS_PARTS] WHERE CHR_PART_NO = '$partno' AND CHR_PV = '$prodver' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC_TO LIKE 'WH%' OR CHR_SLOC_TO LIKE 'WP%' OR CHR_SLOC_TO LIKE 'PP%') ");
        if (!empty($partname)) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getSelfpro4() {
        $prodver4 = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver4' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function getNextpro4d() {
        $prodver = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS]");
        $option = '';
        if ($partname) {
            $option .= "<option></option>";
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function getQtypick() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $qty = $this->kanban_master_m->cekQty($partno);
        if ($qty == false) {
            echo false;
        } else {
            echo $qty[0]->INT_QTY_PER_BOX;
        }
    }

    function cekBackno4() {
        $part = trim($this->input->post('idpickup', true));
        $backno = trim($this->input->post('backno4', true));
        $cek = $this->kanban_master_m->check_backno($backno);
        if ($cek == false) {
            // $checkbackno == 6;
            // echo $cekbackno;
        } else {
            $cek1 = $cek[0]->CHR_BACK_NO;
            $jmldata = strlen($cek1);
            if ($jmldata == 6) {
                $cek2 = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM [dbo].[TM_KANBAN] WHERE CHR_BACK_NO = '$backno' AND CHR_PART_NO = '$part'");
                if ($cek2) {
                    $cek4 = $cek2[0]->CHR_BACK_NO;
                    $jml = strlen($cek4);
                    if ($jml == 6) {
                        echo $cek4;
                    }
                } else {
                    $backno2 = preg_replace('/\s+/', '', $cek2);
                    echo $backno2;
                }
            }
        }
    }

    function getStorself4d() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT CHR_SLOC FROM [dbo].[TM_PARTS_SLOC] WHERE CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%') AND CHR_SLOC <> 'WH00' ");
        $option = '';
        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"WH00\">WH00</option>";
            $option .= "<option value=\"$value->CHR_SLOC\">$value->CHR_SLOC</option>";
        }

        echo $option;
    }

    function getStorNext4d() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $stornext = $this->kanban_master_m->findBySql("SELECT CHR_SLOC FROM [dbo].[TM_PARTS_SLOC] WHERE CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND (CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%') AND CHR_SLOC <> 'WH00' ");
        $option = '';
        foreach ($stornext as $key => $value) {
            $option .= "<option value=\"$value->CHR_SLOC\">$value->CHR_SLOC</option>";
        }

        echo $option;
    }

    function getQtypass() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $qty = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'qty' FROM [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6' AND CHR_SLOC_TO='$slocto' ");
        if ($qty) {
            echo $qty[0]->qty;
        } else {
            echo '';
        }
    }

// END FUNCTION AJAX DATABARU


    public function getNextpro4() {
        $prodver = trim($this->input->post('prodver4', TRUE));
        $partno = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' FROM [dbo].[TM_PROCESS_PARTS] WHERE CHR_PV = '$prodver' AND CHR_PART_NO = '$partno'");
        if ($partname) {
            $selfpro = $partname[0]->pname;
            $option = " ";
            $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS] WHERE CHR_WORK_CENTER <> '$selfpro' ");
            if (!empty($partname)) {
                foreach ($partname as $key => $value) {
                    $option .= "<option></option><option value=\"$value->pname\">$value->pname</option>";
                }
            }

            echo $option;
        } else {
            echo '';
        }
    }

    public function getSupplierb() {
        $partno = trim($this->input->post('bno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_ID 'pname' from [dbo].[TM_VENDOR_PARTS] where CHR_BACK_NO = '$partno'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    function cekPart11() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '0'");

        echo json_encode($cek);
    }

    function cekPart12() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '1'");

        echo json_encode($cek);
    }

    function cekPart13() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '4'");

        echo json_encode($cek);
    }

    function cekPart14() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '5'");

        echo json_encode($cek);
    }

    function cekPart14p() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_PART_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$part' AND CHR_KANBAN_TYPE = '6'");

        echo json_encode($cek);
    }

    function cekBox() {
        $part = trim($this->input->post('pno', true));
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE] WHERE CHR_BOX_TYPE = '$part'");
        if ($cek) {
            $cek = trim($cek[0]->CHR_BOX_TYPE);
            echo $cek;
        } else {
            echo "tidak ada";
        }
    }

    function cekFlagor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $type = '0';
        $x = $this->kanban_master_m->cekFlag($idorder, $type, $sud);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagpr() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $type = '1';
        $x = $this->kanban_master_m->cekFlag($idproses, $type, $prodver1);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagsp() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud = trim($this->input->post('sud2', TRUE));
        $type = '4';
        $x = $this->kanban_master_m->cekFlag($idsupply, $type, $sud);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagpu() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $type = '5';
        $x = $this->kanban_master_m->cekFlag($idpickup, $type, $prodver3);
        if ($x == false) {
            echo true;
        } else {
            $x = $x[0]->CHR_FLAG_DELETE;
            if ($x == 'X') {
                echo false;
            } else {
                echo true;
            }
        }
    }

    function cekFlagpup() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $type = '6';
        $x = $this->kanban_master_m->cekFlagpass($idpickup, $type, $slocto);
        if ($x == false) {
            echo true;
        } else {
            $x = trim($x[0]->CHR_FLAG_DELETE);
            if ($x == "X") {
                echo false;
            } else {
                echo true;
            }
        }
    }

// ajax print
    public function getPart1() {
        $partno = $this->input->post('pno');
        $partno = trim($partno);
        $partname = $this->kanban_master_m->findBySql("select CHR_PART_NAME 'pname' from [dbo].[TM_PARTS] WHERE CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function back_no1() {
        $partno = $this->input->post('pno');
        $partno = trim($partno);
        $partname = $this->kanban_master_m->findBySql("select CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE='1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function back_no11() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("select CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function back_nop() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("select CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '6'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getBackno() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("select CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getLastPrintDate() {
        $partno = trim($this->input->post('pno'));
        $lastPrintDate = $this->kanban_master_m->findBySql("SELECT     TOP (1) TM_KANBAN_SERIAL.INT_KANBAN_NO, TM_KANBAN_SERIAL.CHR_DATE_PRINT, TM_KANBAN.CHR_PART_NO
            FROM         TM_KANBAN_SERIAL INNER JOIN
                                  TM_KANBAN ON TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO
            WHERE     (TM_KANBAN.CHR_PART_NO = '$partno')
            ORDER BY TM_KANBAN_SERIAL.CHR_DATE_PRINT DESC");
        if ($lastPrintDate) {
            echo date("d-m-Y", strtotime($lastPrintDate[0]->CHR_DATE_PRINT));
        } else {
            echo '';
        }
    }

    public function getIntPv1() {
        $partno = $this->input->post('pno');
        $partno = trim($partno);
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1'");
        // $partname=$partname[0]->pname;
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function getIntPv5() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        $partname = $this->kanban_master_m->findBySql("SELECT CHR_PV 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$partno' AND (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }


        echo $option;
    }

    public function getSupp() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '4'");
        $option = '';
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function getSuppu() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->getsid1($partno);
        $sid = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR from [dbo].[TM_KANBAN] where CHR_KANBAN_TYPE = '4' AND CHR_PART_NO='$partno' ");
        $option = '';
        if ($partname == false) {
            $option = '';
        } else {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->CHR_WC_VENDOR\">$value->CHR_WC_VENDOR</option>";
            }
        }
        echo $option;
    }

    public function getSupporder() {
        $partno = trim($this->input->post('pno'));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '0'");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function getSuppName() {
        $partno = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $sname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sid'");
        if ($sname) {
            echo $sname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSuppName3() {
        $sid = trim($this->input->post('sid', TRUE));
        $sname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sid'");
        if ($sname) {
            echo $sname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSuppNameu() {
        $sud2 = trim($this->input->post('sud2'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sud2'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSuppNameuor() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sud'));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SUPPLIER_NAME 'pname' FROM [dbo].[TM_VENDOR] WHERE CHR_SUPPLIER_ID ='$sud'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storSelf1r() {
        $partno = trim($this->input->post('idpickup'));
        $sud = trim($this->input->post('prodver3'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5' AND CHR_WC_VENDOR = '$sud' ");

        if (!empty($selfpro)) {
            echo $selfpro[0]->selfpro;
        } else {
            echo '';
        }
    }

    public function storSelf1() {
        $partno = trim($this->input->post('idproses'));
        $sud = trim($this->input->post('pv1'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '1' AND CHR_WC_VENDOR = '$sud' ");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%') ");

        if ($sud <> '') {
            $option .="<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->CHR_SLOC\">$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function storSelf1pk() {
        $partno = trim($this->input->post('idproses'));
        $sud = trim($this->input->post('prodver1'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '1' AND CHR_WC_VENDOR = '$sud' ");

        if ($selfpro) {
            $selfpro = $selfpro[0]->selfpro;
            if ($selfpro == "0") {
                echo '';
            } else {
                echo $selfpro;
            }
        } else {
            echo '';
        }
    }

    public function ss1() {
        $partno = trim($this->input->post('idproses'));
        $sud = trim($this->input->post('prodver1'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '1' AND CHR_WC_VENDOR = '$sud' ");
        if (!empty($selfpro)) {
            echo $selfpro = $selfpro[0]->selfpro;
        } else {
            echo '';
        }
    }

    public function storSelf1u() {
        $partno = trim($this->input->post('idpickup'));
        $sud = trim($this->input->post('pv3'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5' AND CHR_WC_VENDOR = '$sud' ");
        if (count($selfpro) == 0) {
            $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5'  ");
        }

        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%')");

        if (!empty($selfpro)) {
            $option .="<option value=\"$selfpro\">$selfpro</option>";
        }
        foreach ($partname as $key => $value) {
            $option .= "<option>$value->CHR_SLOC</option>";
        }
        echo $option;
    }

    // get storage self process kanban pickup
    public function storSelf1u1() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5'");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");

        if ($partname) {
            $option .="<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function storSelfpp() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6'");

        if (!empty($selfpro)) {
            echo $selfpro[0]->selfpro;
        } else {
            echo '';
        }
    }

    public function storSelf1u2() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '5'");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno'");

        if ($partname) {
            $option .="<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function storNextpass() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6'");
        if ($selfpro) {
            foreach ($selfpro as $key => $value) {
                $option .= "<option>$value->CHR_SLOC_TO</option>";
            }
        }

        echo $option;
    }

    public function storNextpp() {
        $partno = trim($this->input->post('idpickup'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '6'");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND (CHR_SLOC_TO LIKE 'WH%' OR CHR_SLOC_TO LIKE 'WP%' OR CHR_SLOC_TO LIKE 'PP%') ");

        if ($partname) {
            $option .="<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC_TO</option>";
            }
        }

        echo $option;
    }

    public function storSelf11() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3'");
        if ($partname) {
            $partname = $partname[0]->pname;
            if ($partname == "0") {
                echo '';
            } else {
                echo $partname;
            }
        } else {
            echo '';
        }
    }

    public function storSelf11p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3' and CHR_KANBAN_TYPE='5' ");
        if ($partname) {
            $partname = $partname[0]->pname;
            if ($partname == "0") {
                echo '';
            } else {
                echo $partname;
            }
        } else {
            echo '';
        }
    }

    public function getSelfpro1() {
        $prodver1 = $this->input->post('prodver1', TRUE);
        $prodver1 = trim($prodver1);
        $idproses = $this->input->post('idproses', TRUE);
        $idproses = trim($idproses);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idproses' and CHR_PV = '$prodver1' ");
        //   var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSelfprou() {
        $pv1 = trim($this->input->post('pv1', TRUE));
        $idproses = trim($this->input->post('idproses', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idproses' and CHR_PV = '$pv1' ");
        //   var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSelfpro3() {
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idpickup' and CHR_PV = '$prodver3' ");
        // var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getSelfprou3() {
        $pv3 = trim($this->input->post('pv3', TRUE));
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_PROCESS_PARTS] where CHR_PART_NO = '$idpickup' and CHR_PV = '$pv3' ");

// var_dump($partname);die();
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getNextpro1() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv3 = trim($this->input->post('pv1', TRUE));
        $option = "";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv3' ");
        $partname = $partname[0]->pname;
        $nextpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER from [dbo].[TM_PROCESS] ");

        if ($nextpro) {

            $option .="<option value=\"$partname\">$partname</option><option></option>";
            foreach ($nextpro as $key => $value) {
                $option .="<option value=\"$value->CHR_WORK_CENTER\">$value->CHR_WORK_CENTER</option>";
            }
        }

        echo $option;
    }

    public function getNextpro1pk() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv3 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_WC_VENDOR = '$pv3' AND CHR_KANBAN_TYPE = '1' ");
        if ($partname) {
            echo $partname = $partname[0]->CHR_WORK_CENTER;
        } else {

            echo '';
        }
    }

    public function getNextpro5pk() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->check_nextpk5($partno, $pv3);
        if ($partname == false) {
            $partname = '';
        } else {
            $partname = $partname[0]->CHR_WORK_CENTER;
            if ($partname == NULL) {
                $partname = '';
            }
        }
        echo $partname;
    }

    public function getnp1() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv3 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv3' ");

        if ($partname) {
            echo $partname = $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getNextpro5() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '5' AND CHR_WC_VENDOR = '$pv3' ");
        if (count($partname) == 0) {
            $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '5'  ");
        }
        $partname = $partname[0]->pname;
        $option = " ";
        $nextpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WORK_CENTER from [dbo].[TM_PROCESS] ");

        if ($nextpro) {
            $option .= "<option value=\"$partname\">$partname</option>";
            $option .= "<option></option>";
            foreach ($nextpro as $key => $value) {
                $option .= "<option value=\"$value->CHR_WORK_CENTER\">$value->CHR_WORK_CENTER</option>";
            }
        }

        echo $option;
    }

    public function getNextpro5r() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_WORK_CENTER 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'and CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv3' ");

        if ($partname) {
            $partname = $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext1() {
        $partno = trim($this->input->post('pno'));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC 'pname' from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNextpk() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext1u() {
        $partno = trim($this->input->post('idproses', TRUE));
        $pv = trim($this->input->post('pv1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '1' AND CHR_WC_VENDOR = '$pv' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext2u() {
        $partno = trim($this->input->post('idpickup', TRUE));
        $pv = trim($this->input->post('pv3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5' AND CHR_WC_VENDOR = '$pv' ");
        if (count($partname) == 0) {
            $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '5' ");
        }
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext11() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function storNext11p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_WC_VENDOR = '$prodver3' and CHR_KANBAN_TYPE='5'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerbox1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxu() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sud2', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_KANBAN_TYPE = '4' and CHR_WC_VENDOR='$sid' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerbox3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->getQty($idpickup, $prodver3);
        if ($partname == false) {
            echo '';
        } else {
            echo $partname[0]->INT_QTY_PER_BOX;
        }
    }

    public function qtyPerbox3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_SLOC_TO = '$slocto' AND CHR_KANBAN_TYPE = '6'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
        if (count($partname) == 0) {
            $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '5'");
        }
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerbox4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $qtybox = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO='$idsupply' and CHR_WC_VENDOR='$sid' and CHR_KANBAN_TYPE='4'");
        if ($qtybox) {
            echo $qtybox[0]->pname;
        } else {
            echo '';
        }
    }

    public function qtyPerboxor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $qtybox = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($qtybox) {
            echo $qtybox[0]->pname;
        } else {
            echo '';
        }
    }

    public function qpbu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT INT_QTY_PER_BOX 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxType1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        if (!empty($partname)) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxTypeu() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '1'");
        $partname = $partname[0]->pname;
        if ($box) {
            $option .="<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function boxTypeu1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '4'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxTypeu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
        if (count($partname) == 0) {
            $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup'  and CHR_KANBAN_TYPE = '5'");
        }
        $partname = $partname[0]->pname;
        if ($box) {
            $option .="<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function boxTypeu3pp() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $slocfrom = trim($this->input->post('slocfrom', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO ='$idpickup' and CHR_SLOC_FROM ='$slocfrom' AND CHR_SLOC_TO='$slocto' and CHR_KANBAN_TYPE ='6'");
        if (!empty($partname)) {
            $partname = $partname[0]->pname;
        } else {
            $partname = '';
        }

        if ($box) {
            $option .="<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function boxType3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$prodver3' and CHR_KANBAN_TYPE = '5'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxType3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' AND CHR_KANBAN_TYPE = '6' AND CHR_SLOC_TO='$slocto' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxType4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function boxTypeor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = $this->input->post('sid', TRUE);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function btu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        $partname = $partname[0]->pname;
        if ($box) {
            $option .="<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function btu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud = trim($this->input->post('sud2', TRUE));
        $option = '';
        $box = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE FROM [dbo].[TM_BOX_TYPE]");
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_BOX_TYPE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '4'");
        $partname = $partname[0]->pname;
        if ($box) {
            $option .="<option value=\"$partname\">$partname</option>";
            foreach ($box as $key => $value) {
                $option .= "<option value=\"$value->CHR_BOX_TYPE\">$value->CHR_BOX_TYPE</option>";
            }
        }

        echo $option;
    }

    public function side1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function keterangan1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        if (!$prodver1) {
            echo '';
        } else {
            $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
            if ($partname) {
                echo $partname[0]->pname;
            } else {
                echo '';
            }
        }
    }

    public function keterangan2() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $part = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if (!empty($part)) {
            echo $part[0]->pname;
        } else {
            echo '';
        }
    }

    public function keterangan4() {
        $idorder = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        if ($sid == '') {
            echo '';
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
            if ($part) {
                echo $part[0]->pname;
            } else {
                echo '';
            }
        }
    }

    public function keterangan3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver1 = trim($this->input->post('prodver3', TRUE));
        if ($prodver1 == '') {
            $partname = '';
        } else {
            $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '5'");
            if (count($partname) == 0) {
                $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup'  and CHR_KANBAN_TYPE = '5'");
            }
            $partname = $partname[0]->pname;
            if ($partname == NULL or $partname == '') {
                $partname = '';
            }
        }
        echo $partname;
    }

    public function keterangan3pp() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function keterangan3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_KETERANGAN 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and  CHR_KANBAN_TYPE = '6' AND CHR_SLOC_TO='$slocto' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sideu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = $this->input->post('sud', TRUE);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        $option = " ";
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .="<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .="<option>LH</option>";
                $option .="<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function sideu1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $sud = trim($this->input->post('pv1', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '1'");
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .="<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .="<option>LH</option>";
                $option .="<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function sideu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud2 = trim($this->input->post('sud2', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sud2' and CHR_KANBAN_TYPE = '4'");
        $option = '';
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .="<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .="<option>LH</option>";
                $option .="<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>RH</option><option>LH</option><option>LH/RH</option>";
        }

        echo $option;
    }

    public function side3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$prodver3' and CHR_KANBAN_TYPE = '5'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function side3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6' AND CHR_SLOC_TO='$slocto' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sidepp() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6' and CHR_SLOC_FROM='WH00' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sideu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = $this->input->post('pv3', TRUE);
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
        $option = '';
        if (count($partname) == 0) {
            $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup'  and CHR_KANBAN_TYPE = '5'");
        }
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .="<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .="<option>LH</option>";
                $option .="<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "NONE" OR $side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function sideu3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_KANBAN_TYPE = '6'");
        $option = '';
        if (!empty($partname)) {
            $side = trim($partname[0]->pname);
            $option .="<option value=\"$side\">$side</option>";

            if ($side == "LH") {
                $option .= "<option></option><option>RH</option><option>LH/RH</option>";
            } else if ($side == "RH") {
                $option .= "<option></option>";
                $option .="<option>LH</option>";
                $option .="<option>LH/RH</option>";
            } else if ($side == "LH/RH") {
                $option .= "<option></option><option>RH</option><option>LH</option>";
            } else if ($side == "") {
                $option .= "<option>LH</option><option>RH</option><option>LH/RH</option>";
            }
        } else {
            $option .= "<option></option><option>LH</option><option>RH</option><option>LH/RH</option>";
        }
        echo $option;
    }

    public function side4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_WC_VENDOR 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' AND CHR_KANBAN_TYPE = '4'");

        if ($partname) {
            $sid = $partname[0]->pname;
            $side = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
            if ($side) {
                echo $side[0]->pname;
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }

    public function spor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function sideor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function lastSerial1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        if (!$prodver1) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function fromor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idorder' and TM_KANBAN.CHR_WC_VENDOR = '$sid' AND TM_KANBAN.CHR_KANBAN_TYPE='0' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ORDER BY TM_KANBAN_SERIAL.INT_NUM_SERIAL ASC ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function from() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idproses' and TM_KANBAN.CHR_WC_VENDOR = '$prodver1' ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function fromsp() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid3 = trim($this->input->post('sid3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idsupply' and TM_KANBAN.CHR_WC_VENDOR = '$sid3' AND TM_KANBAN.CHR_KANBAN_TYPE='4' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ORDER BY TM_KANBAN_SERIAL.INT_NUM_SERIAL ASC  ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function frompu() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idpickup' and TM_KANBAN.CHR_WC_VENDOR = '$prodver3' AND TM_KANBAN.CHR_KANBAN_TYPE='5' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ORDER BY TM_KANBAN_SERIAL.INT_NUM_SERIAL ASC ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function frompup() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idpickup' and TM_KANBAN.CHR_SLOC_TO = '$slocto' and TM_KANBAN.CHR_KANBAN_TYPE='6' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ORDER BY TM_KANBAN_SERIAL.INT_NUM_SERIAL ASC ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function toor() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idorder' and TM_KANBAN.CHR_WC_VENDOR = '$sid' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%'  ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function to() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $prodver1 = trim($this->input->post('prodver1', TRUE));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] where CHR_PART_NO='$idproses' and CHR_WC_VENDOR='$prodver1' and CHR_KANBAN_TYPE='1' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$nokanban' AND INT_NUM_SERIAL LIKE '1%' ORDER BY INT_NUM_SERIAL ASC ");
        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function tosp() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid3 = trim($this->input->post('sid3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idsupply' and TM_KANBAN.CHR_WC_VENDOR = '$sid3' AND TM_KANBAN.CHR_KANBAN_TYPE='4' AND TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ORDER BY TM_KANBAN_SERIAL.INT_NUM_SERIAL ASC ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function topu() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $prodver3 = trim($this->input->post('prodver3', TRUE));
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT TM_KANBAN_SERIAL.INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] inner join [dbo].[TM_KANBAN] on TM_KANBAN_SERIAL.INT_KANBAN_NO = TM_KANBAN.INT_KANBAN_NO where TM_KANBAN.CHR_PART_NO = '$idpickup' and TM_KANBAN.CHR_WC_VENDOR = '$prodver3' AND TM_KANBAN.CHR_KANBAN_TYPE='5' and TM_KANBAN_SERIAL.INT_NUM_SERIAL LIKE '1%' ORDER BY TM_KANBAN_SERIAL.INT_NUM_SERIAL ASC ");

        if (!empty($partname)) {
            foreach ($partname as $key => $value) {
                $option .= "<option value=\"$value->pname\">$value->pname</option>";
            }
        }

        echo $option;
    }

    public function lastSerialu() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sud = trim($this->input->post('sud', TRUE));
        if (!$sud) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sud' and CHR_KANBAN_TYPE = '0'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerialu1() {
        $idproses = trim($this->input->post('idproses', TRUE));
        $pv1 = trim($this->input->post('pv1', TRUE));
        if (!$pv1) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$pv1' and CHR_KANBAN_TYPE = '1'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerialu2() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sud2 = trim($this->input->post('sud2', TRUE));
        if (!$sud2) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->cekSerialsp($idsupply, $sud2);
            if ($part == false) {
                echo '';
            } else {
                $partz = $part[0]->INT_KANBAN_NO;
                $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
                if (!$partname) {
                    $partname[0]->pname = "-";
                }
                echo $partname[0]->pname;
            }
        }
    }

    public function lastSerialu3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $pv3 = trim($this->input->post('pv3', TRUE));
        if (!$pv3) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$pv3' and CHR_KANBAN_TYPE = '5'");
            if (count($part) == 0) {
                $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup'  and CHR_KANBAN_TYPE = '5'");
            }
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerial3() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $sid = trim($this->input->post('prodver3', TRUE));
        if (!$sid) {
            echo "-";
        } else {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idpickup' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '5'");
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            //var_dump($partname);
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        }
    }

    public function lastSerial3p() {
        $idpickup = trim($this->input->post('idpickup', TRUE));
        $slocto = trim($this->input->post('slocto', TRUE));
        $part = $this->kanban_master_m->cekSerialPass($idpickup, $slocto);
        if ($part <> false) {
            $partz = $part[0]->INT_KANBAN_NO;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if (!$partname) {
                $partname[0]->pname = "-";
            }
            echo $partname[0]->pname;
        } else {
            echo "-";
        }
    }

    public function lastSerial2() {
        $idorder = trim($this->input->post('idorder', TRUE));
        $sid = trim($this->input->post('sid', TRUE));
        $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idorder' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '0'");
        if ($part) {
            $partz = $part[0]->pname;
            $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
            if ($partname) {
                echo $partname[0]->pname;
            } else {
                echo "-";
            }
        } else {
            echo '-';
        }
    }

    public function lastSerial4() {
        $idsupply = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        if ($sid != '') {
            $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$idsupply' and CHR_WC_VENDOR = '$sid' and CHR_KANBAN_TYPE = '4'");
            if ($part) {
                $partz = $part[0]->pname;
                $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 INT_NUM_SERIAL 'pname' from [dbo].[TM_KANBAN_SERIAL] where INT_KANBAN_NO = '$partz' AND INT_NUM_SERIAL LIKE '1%' order by INT_NUM_SERIAL desc");
                if ($partname) {
                    echo $partname[0]->pname;
                } else {
                    echo "-";
                }
            } else {
                echo '';
            }
        } else {
            echo '';
        }
    }

    public function PrintDate1() {
        $idproses = $this->input->post('idproses', TRUE);
        $prodver1 = $this->input->post('prodver1', TRUE);
        $part = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO 'pname' from TM_KANBAN where CHR_PART_NO = '$idproses' and CHR_WC_VENDOR = '$prodver1' and CHR_KANBAN_TYPE = '1'");
        $partz = $part[0]->pname;
        $partname = $this->kanban_master_m->findBySql("SELECT TOP 1 CHR_date_print 'pname' from TM_KANBAN_SERIAL where INT_KANBAN_NO = '$partz' order by INT_NUM_SERIAL desc");
        if (!$partname) {
            $partname[0]->pname = "-";
        }
        echo $partname[0]->pname;
    }

    public function getStor() {
        $partno = trim($this->input->post('idsupply', TRUE));
        $sid = trim($this->input->post('sid3', TRUE));
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE = '4' AND CHR_WC_VENDOR = '$sid' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    public function getStoru2() {
        $partno = trim($this->input->post('idsupply', TRUE));
        $sud = trim($this->input->post('sud2'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '4' AND CHR_WC_VENDOR = '$sud' ");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%') ");

        if ($partname) {
            $option .="<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function getStor2() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sud'));
        $option = " ";
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_FROM 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '0' AND CHR_WC_VENDOR = '$sud' ");
        $selfpro = $selfpro[0]->selfpro;
        $partname = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC from [dbo].[TM_PARTS_SLOC] where CHR_PART_NO = '$partno' AND (CHR_SLOC LIKE 'WH%' OR CHR_SLOC LIKE 'WP%' OR CHR_SLOC LIKE 'PP%') ");
        if ($sud <> '') {
            $option .="<option value=\"$selfpro\">$selfpro</option>";
            foreach ($partname as $key => $value) {
                $option .= "<option>$value->CHR_SLOC</option>";
            }
        }

        echo $option;
    }

    public function getStor2r() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sud'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO 'selfpro' FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO ='$partno' AND CHR_KANBAN_TYPE='0' AND CHR_WC_VENDOR ='$sud' ");
        if (!empty($selfpro)) {
            $selfpro = $selfpro[0]->selfpro;
        } else {
            $selfpro = "";
        }

        echo $selfpro;
    }

    public function getStorp() {
        $partno = trim($this->input->post('idorder'));
        $sud = trim($this->input->post('sid'));
        $selfpro = $this->kanban_master_m->findBySql("SELECT DISTINCT CHR_SLOC_TO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO = '$partno' AND CHR_KANBAN_TYPE= '0' AND CHR_WC_VENDOR = '$sud' ");
        if ($sud <> '') {
            echo $selfpro[0]->CHR_SLOC_TO;
        } else {
            echo '';
        }
    }

// end ajax print





    public function LastSerial() {
        $partno = $this->input->post('part_no');
        $option = " ";
        $partname = $this->kanban_master_m->findBySql("select INT_LAST_SERIAL 'pname' from [dbo].[TM_KANBAN] ORDER BY INT_LAST_SERIAL DESC");
        echo $partname[0]->pname;
    }

    public function back_no() {
        $partno = $this->input->post('pno');
        $partname = $this->kanban_master_m->findBySql("select CHR_BACK_NO 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function GetSide() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("select CHR_SIDE 'pname' from [dbo].[TM_KANBAN] where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function str3() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("select CHR_SLOC_TO 'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function qty() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("select INT_QTY_PER_BOX'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function qty2() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("select INT_QTY_PER_BOX'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function cycle() {
        $partno = $this->input->post('supplier_name');
        $partname = $this->kanban_master_m->findBySql("select CHR_CYCLE_BIN 'pname' from TM_VENDOR_CYCLE where CHR_SUPPLIER_ID = '$partno'");
        echo $partname[0]->pname;
    }

    public function box() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("select CHR_BOX_TYPE'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function box2() {
        $partno = $this->input->post('part_no');
        $partname = $this->kanban_master_m->findBySql("select CHR_BOX_TYPE'pname' from TM_KANBAN where CHR_PART_NO = '$partno'");
        echo $partname[0]->pname;
    }

    public function PrintDate() {
        $partname = date("Y-m-d");
        // echo $partname[0]->pname;
    }

    public function showcipipin() {
        // var_dump($this->layout);die();
        $data = null;
        $this->load->view('pes/production_counter2', $data);
    }

// ajax
    public function getPartNo() {
        $backno = $this->input->post('bno');
        $partname = $this->kanban_master_m->findBySql("select CHR_PART_NO 'pname' from TM_PARTS WHERE CHR_BACK_NO = '$backno' ");
        if ($partname) {
            echo $partname[0]->pname;
        } else {
            echo '';
        }
    }

    function cekBackno() {
        $part = $this->input->post('pno', true);
        $cek = $this->kanban_master_m->findBySql("SELECT CHR_BACK_NO FROM TM_PARTS WHERE CHR_PART_NO = '$part'");

        echo (!$cek);
    }

// AJAX AUTOCOMPLETE
    function search() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');
        $x = "X";
        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_PARTS WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchpartno() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_PROCESS_PARTS WHERE (CHR_FLAG_DELETE IS NULL OR CHR_FLAG_DELETE='') AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldOr() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='0' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldPr() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='1' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldSp() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='4' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

    function searchOldPu() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='5' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
//                echo json_encode($arr_result);
            }
        }
    }

    function searchOldPup() {
        $this->load->model('pes/kanban_master_m');
        $get = $this->input->get('term');

        if ($get) {
            $result = $this->db->query("SELECT DISTINCT TOP 10 CHR_PART_NO FROM TM_KANBAN WHERE CHR_KANBAN_TYPE='6' AND CHR_PART_NO LIKE '$get%'")->result();
            if (count($result) > 0) {
                foreach ($result as $res) {
                    $arr_result[] = $res->CHR_PART_NO;
                }
                echo json_encode($arr_result);
            }
        }
    }

// END AJAX AUTOCOMPLETE
// AJAX VALIDASI SERIAL PRINT CUSTOM
    function cekSerialCustom() {
        $part = trim($this->input->post('idorder', true));
        $sid = trim($this->input->post('sid', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='0' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustompr() {
        $part = trim($this->input->post('idproses', true));
        $sid = trim($this->input->post('prodver1', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='1' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustomsp() {
        $part = trim($this->input->post('idsupply', true));
        $sid = trim($this->input->post('sid3', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='4' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustompu() {
        $part = trim($this->input->post('idpickup', true));
        $sid = trim($this->input->post('prodver3', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->findBySql("SELECT INT_KANBAN_NO FROM [dbo].[TM_KANBAN] WHERE CHR_PART_NO='$part' AND CHR_WC_VENDOR='$sid' AND CHR_KANBAN_TYPE='5' ");
        $nokanban = $nokanban[0]->INT_KANBAN_NO;

        if ($custom == '') {
            $status = true;
        } else {
            $karakter = strlen($custom);
            if ($karakter == 5) {
                $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                if ($cek == false) {
                    $status = '2';
                } else {
                    $status = true;
                }
            } elseif ($karakter < 5) {
                $status = '3';
            } elseif ($karakter > 5) {
                $custom = explode(',', $custom);
                $range = count($custom);
                for ($i = 0; $i < $range; $i++) {
                    $serial = $custom[$i];
                    $karserial = strlen($serial);
                    if ($karserial <> 5) {
                        $status = '4';
                    } else {
                        $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                        if ($cek == false) {
                            $status = '5';
                        } else {
                            $status = true;
                        }
                    }
                }
            }
        }
        echo $status;
    }

    function cekSerialCustompup() {
        $part = trim($this->input->post('idpickup', true));
        $slocfrom = trim($this->input->post('slocfrom', true));
        $custom = trim($this->input->post('custom', true));
        $nokanban = $this->kanban_master_m->ceknokanban($part, $slocfrom);
        if ($nokanban == false) {
            $status = '15';
        } else {
            $nokanban = $nokanban[0]->INT_KANBAN_NO;
            if ($custom == '') {
                $status = true;
            } else {
                $karakter = strlen($custom);
                if ($karakter == 5) {
                    $cek = $this->kanban_master_m->cekSerialCustomOr($custom, $nokanban);
                    if ($cek == false) {
                        $status = '2';
                    } else {
                        $status = true;
                    }
                } elseif ($karakter < 5) {
                    $status = '3';
                } elseif ($karakter > 5) {
                    $custom = explode(',', $custom);
                    $range = count($custom);
                    for ($i = 0; $i < $range; $i++) {
                        $serial = $custom[$i];
                        $karserial = strlen($serial);
                        if ($karserial <> 5) {
                            $status = '4';
                        } else {
                            $cek = $this->kanban_master_m->cekSerialCustomOr($serial, $nokanban);
                            if ($cek == false) {
                                $status = '5';
                            } else {
                                $status = true;
                            }
                        }
                    }
                }
            }
        }
        echo $status;
    }

// END AJAX VALIDASI SERIAL PRINT CUSTOM
}

?>
