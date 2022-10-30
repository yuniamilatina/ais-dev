<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class login_c extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('login_m');
        $this->load->model('basis/user_m');
    }

    function check_session() {
        $user_session = $this->session->all_userdata();
        if ($user_session['NPK'] != '') {
            redirect(base_url('index.php/home_c'));
        } elseif (!$user_session['NPK']) {
            redirect(base_url('index.php/login_c'));
        }
    }

    function index($msg = null) {
        switch ($msg) {

            case '1':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                <strong>Sign in failed!</strong> Your account doesn\'t exist.
                </div>';
                break;
            case '2':
                $data['msg'] = '<p>
                <div class="alert alert-info text-center">
                <strong>Too bad!</strong> Your account was deleted.
                </div>';
                break;
            case '3':
                $data['msg'] = '<p>
                <div class="alert alert-warning text-center">
                You have abnormally logged off. 
                Try sign in on your last computer.
                </div>';
                break;
            case '4':
                $data['msg'] = '<p>
                <div class="alert alert-warning text-center">
                <strong>Sign in failed!</strong> Your password appear to be invalid. Please try again.
                </div>';
                break;
            case '5':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                Your password has expired and must be changed.
                </div>';
                break;
            case '6':
                $data['msg'] = '<p>
                <div class="alert alert-success text-center">
                Updating password was successful. Try to Login.
                </div>';
                break;
            case '7':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                Your account is not active.
                </div>';
                break;
            case '8':
                $data['msg'] = '<p>
                <div class="alert alert-success text-center">
                Your account is active.
                </div>';
                break;
            default:
                $data['msg'] = NULL;
                break;
        }
        $data['title'] = 'Budget Login';
        $data['content'] = 'login/login_v';
        $this->load->view('/template/login_kertas', $data);
    }

    function log() {
        $npk = trim($this->input->post('NPK'));
        $pass = trim($this->input->post('PASS'));
        if ($this->login_m->check_if_exist($npk)) {
            if ($this->login_m->check_if_not_active($npk)) {
                if ($this->login_m->check_if_deleted($npk)) {
                    if ($this->login_m->check_if_on($npk)) {
                        if ($this->login_m->check_password($npk, $pass)) {
                            if ($this->login_m->check_if_exp_password($npk)) {
                                $this->login_m->set_session($npk);
                                $ip = $this->get_ip_client();
                                $data = array(
                                    'BIT_STATUS' => 0,
                                    'CHR_CODE' => NULL,
                                    'CHR_IP' => $ip);
                                $this->login_m->update_user_login($npk, $data);
                                $this->log_m->add_log(1, NULL);
                                redirect('basis/home_c');
                            } else {
                                $this->log_m->add_log_login(13, $npk);
                                $this->index('5');
                            }
                        } else {
                            $this->log_m->add_log_login(13, $npk);
                            $this->index('4');
                        }
                    } else {
                        $this->log_m->add_log_login(13, $npk);
                        $this->index('3');
                    }
                } else {
                    $this->log_m->add_log_login(13, $npk);
                    $this->index('2');
                }
            } else {
                //change password
                redirect('basis/user_c/activing_user/' . $npk);
                $this->log_m->add_log_login(13, $npk);
                $this->index('7');
            }
        } else {
            $this->index('1');
        }
    }

    function off() {
        $user_session = $this->session->all_userdata();
        // if (!defined('NPK')) {
        //     $this->log_m->add_log(2, NULL);
        //     redirect(base_url('index.php/login_c'));
        // }
        $data = array(
            'BIT_STATUS' => 0);
        $this->login_m->update_user_login($user_session['NPK'], $data);
        // $this->log_m->add_log(2, NULL);

        $this->session->unset_userdata('NPK');
        $this->session->unset_userdata('USERNAME');
        $this->session->unset_userdata('COMPANY');
        $this->session->unset_userdata('DIVISION');
        $this->session->unset_userdata('GROUPDEPT');
        $this->session->unset_userdata('DEPT');
        $this->session->unset_userdata('SECTION');
        $this->session->unset_userdata('SUBSECTION');
        $this->session->unset_userdata('ROLE');
        $this->session->unset_userdata('CHR_EXP_DATE');
        $this->session->unset_userdata('VAL');

        $this->session->sess_destroy();
       
        redirect('login_c');
    }

    
//    function forgot($msg = NULL) {
//        switch ($msg) {
//            case '1':
//                $data['msg'] = '<p>
//                <div class="alert alert-warning text-center">
//                <strong>User Id was not found!</strong> The User Id appear to be invalid. Please try again.
//                </div>';
//                break;
//            case '2':
//                $data['msg'] = '<p>
//                <div class="alert alert-danger text-center">
//                <strong>You dont have an active email on this account!</strong> Contact administrator for more information.
//                </div>';
//                break;
//            default:
//                $data['msg'] = '<p>
//                <div class="alert alert-info text-center">
//                Submit your User Id to receive a verification code via email.
//                </div>';
//                break;
//        }
//        $data['title'] = 'Forgot Password';
//        $data['content'] = 'login/forgot_v';
//        $this->load->view('/template/login_kertas', $data);
//    }

    function change($msg = NULL) {
        switch ($msg) {
            case '1':
                $data['msg'] = '<p>
                <div class="alert alert-warning text-center">
                <strong>NPK was not found!</strong> The NPK appear to be invalid. Please try again.
                </div>';
                break;
            case '2':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                The original password you entered is incorrect
                </div>';
                break;
            case '3':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                Passwords must contain capital letters, lowercase letters and numbers with at least 7 characters
                </div>';
                break;
            case '4':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                The new password is not same with password confirmation
                </div>';
                break;
            default:
                $data['msg'] = '';
                break;
        }
        $data['title'] = 'Change Password';
        $data['content'] = 'login/change_v';
        $this->load->view('/template/login_kertas', $data);
    }

    function change_expired() {

        $exist = $this->login_m->check_password($this->input->post('CHR_NPK'), trim($this->input->post('CHR_PASS')));

        if ($exist == true) {
            $pass_format = $this->password_check(trim($this->input->post('CHR_NEW_PASS')));
            if ($pass_format == true) {
                if (trim($this->input->post('CHR_NEW_PASS')) == trim($this->input->post('CHR_NEW_PASS_CONFIRM'))) {
                    $data = array(
                        'CHR_PASS' => trim(md5($this->input->post('CHR_NEW_PASS') . date("Ymd"))),
                        'CHR_REGIS_DATE' => date("Ymd"),
                        'CHR_EXP_DATE' => date('Ymd', strtotime("+3 months", strtotime(date("Ymd")))),
                        'CHR_MODI_BY' => $this->input->post('CHR_USERNAME'),
                        'CHR_MODI_DATE' => date("Ymd"),
                        'CHR_MODI_TIME' => date("His"),
                    );
                    $this->user_m->update($data, $this->input->post('CHR_NPK'));
                    $this->log_m->add_log('55', $this->input->post('CHR_NPK'));
                    redirect('login_c');
                } else {
                    redirect('login_c/change/' . $msg = 4);
                }
            } else {
                redirect('login_c/change/' . $msg = 3);
            }
        } else {
            redirect('login_c/change/' . $msg = 2);
        }
    }

    public function password_check($str) {
        if (!preg_match('/[A-Z]/', $str)) {
            return false;
        } if (!preg_match('/[a-z]/', $str)) {
            return false;
        } if (!preg_match('/[0-9]/', $str)) {
            return false;
        } else {
            return true;
        }
    }

    function send_mail() {
        $msg = null;
        $npk = trim($this->input->post('NPK'));
        $user_session = array(
            'NPK' => $npk
        );
        $this->session->set_userdata($user_session);
        if ($this->login_m->check_if_exist($npk)) {
            if ($this->login_m->check_email($npk)) {
                $code = $this->login_m->generate_code();
                $data = array(
                    'CHR_CODE' => $code
                );
                $this->login_m->insert_code($data, trim($npk));
                $msg = $this->mail($npk);
                $row = $this->login_m->load_user($npk)->row();
                $user_session = array(
                    'NPK' => $npk,
                    'USERNAME' => trim($row->CHR_USERNAME),
                    'COMPANY' => NULL,
                    'DIVISION' => NULL,
                    'GROUPDEPT' => NULL,
                    'DEPT' => NULL,
                    'SECTION' => NULL,
                    'SUBSECTION' => NULL,
                    'ROLE' => NULL,
                    'VAL' => NULL
                );
                $this->session->set_userdata($user_session);
                $this->log_m->add_log('69', $npk);

                redirect('login_c/code/');
            } else {
                //$this->forgot('2');
            }
        } else {
            //$this->forgot('1');
        }
    }

    function code($msg = NULL) {
        $user_session = $this->session->all_userdata();
        $row = $this->login_m->load_user($user_session['NPK'])->row();
        if ($msg != NULL) {
            $data['msg'] = $msg;
        } else {
            if ($row->CHR_CODE != NULL) {
                $data['msg'] = '<p>
                <div class="alert alert-success text-center">
                Verification code has been sent,  
                check on your email : ' . trim($row->CHR_EMAIL) . '.
        </div>';
            } else {
                $data['msg'] = NULL;
            }
        }
        $data['title'] = 'Verification Code';
        $data['content'] = 'login/code_v';
        $this->load->view('/template/login_kertas', $data);
    }

    function check_code() {
        $user_session = $this->session->all_userdata();
        $code = trim($this->input->post('CODE'));
        if ($this->login_m->compare_code($code)) {
            $data = array(
                'CHR_CODE' => NULL);
            $this->login_m->update_user_login($user_session['NPK'], $data);

            $this->new_pass();
        } else {
            $this->code('<p>
                <div class="alert alert-danger text-center">
                <strong>Incorect Verfication Code!</strong> Make sure to submit the correct data.
                </div>');
        }
    }

    function new_pass($msg = NULL) {
        switch ($msg) {
            case '1':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                Invalid New Password Format.
                </div>';
                break;
            case '2':
                $data['msg'] = '<p>
                <div class="alert alert-danger text-center">
                Invalid Retype Password.
                </div>';
                break;
            default:
                $data['msg'] = NULL;
                break;
        }
        $data['title'] = 'Set New Password';
        $data['content'] = 'login/pass_v';
        $this->load->view('/template/login_kertas', $data);
    }

    function check_pass() {
        $pass1 = trim($this->input->post('PASS1'));
        $pass2 = trim($this->input->post('PASS2'));
        if ($this->login_m->check_code_null()) {
            if ($this->login_m->pass_validation($pass1)) {
                if ($pass1 == $pass2) {
                    $user_session = $this->session->all_userdata();
                    $row = $this->login_m->load_user($user_session['NPK'])->row();
                    $date = date('Ymd', strtotime(date('Ymd') . " + 90 days"));
                    $newPass = md5(trim($pass1) . trim($row->CHR_REGIS_DATE));
                    $data = array(
                        'CHR_PASS' => $newPass,
                        'CHR_CODE' => NULL,
                        'CHR_EXP_DATE' => $date);
                    $this->login_m->update_user_login($user_session['NPK'], $data);
                    $this->index('6');
                } else {
                    $this->new_pass('2');
                }
            } else {
                $this->new_pass('1');
            }
        } else {
            $this->code('<p>
                <div class="alert alert-danger text-center">
                Make sure to input the verification code.
                </div>');
        }
    }

    function get_ip_client() {
        if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
            //check for ip from share internet
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            // Check for the Proxy User
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        // This will print user's real IP Address
        // does't matter if user using proxy or not.
        return $ip;
    }

    public function email_sent($to, $cc, $subject, $message) {
        $config = Array(
            'mailtype' => 'html'
        );
        $this->load->library('email', $config);

        $this->email->from("it@aisin-indonesia.co.id", "PT AISIN INDONESIA");
        $this->email->to($to);
        $this->email->cc($cc);
        $this->email->bcc('');

        $this->email->subject($subject);
        $this->email->message($message);

        $this->email->send();
    }

    function mail($id) {

        $data = $this->login_m->load_user($id)->row();

        $to = trim($data->CHR_EMAIL);
        $cc = "";
        $subject = "Budgeting Plan and Realization - Forgotten Password";
        $message = "
                    Hi " . $data->CHR_USERNAME . ",

                    This is an automated message generated by Budgeting Plan and Realization application to help you reset your account password.
           
                    Please enter the following code into the 'Verification Code' field of the 'Verification Code' form. (Enter the code exactly as written. You can use copy/paste operations to enter the code):
        
                    " . $data->CHR_CODE . "
                   
                    Input the verification code to the last page or you can click here https://elisa.aisin-indonesia.co.id/evita/index.php/login/fast_code/" . $data->CHR_CODE . "/ 
        
                  
    ";
        $this->email_sent($to, $cc, $subject, $message);
        return NULL;

//        if ($this->email_sent($to, $cc, $subject, $message)) {
//            return NULL;
//        } else {
//            echo $this->email->print_debugger();
//            echo 'fail';exit();
//        }
    }

    public function testMail()
    {
        $subject = "EVITA - Forgotten Password";

        $config = array(
            'mailtype' => 'html'
        );
        $this->load->library('email', $config);

        $this->email->from("it@aisin-indonesia.co.id", "PT AISIN INDONESIA");
        // $this->email->from("system.admin@aisin-indonesia.co.id", "PT AISIN INDONESIA");
        $this->email->to("it@aisin-indonesia.co.id");
        $this->email->cc("");
        $this->email->bcc("");
        $this->email->subject($subject);
        $this->email->message("hallo ini test");

        if ($this->email->send()) {
            echo 'Email sent.';
        } else {
            $this->email->print_debugger();
        }
    }

}
