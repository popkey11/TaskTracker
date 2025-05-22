<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Center_model');
        $this->load->model('Login_model');
    }

    public function index()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $tStaAlwCreatPrj = get_cookie('StaAlwCreatPrj');
        if ($tUsrEmail == "") {
            redirect('/home', 'refresh');
        }elseif($tStaAlwCreatPrj){
            redirect('/docDBPageView', 'refresh');
        } else {
            redirect('/Task', 'refresh');
        }
    }

    //ฟังก์ชั่นตรวจสอบว่า อีเมลล์มีในระบบไหม
    public function checkemail()
    {


        $this->load->library('encryption');

        // $this->load->model('Login_model');
        $email              = $this->input->post('email');
        $aCheckEmailByUser  = $this->Login_model->FindEmailByUser($email);
        $tType = $this->input->post('type');

        if (isset($tType)) {
            $decypt = $this->encryption->decrypt($aCheckEmailByUser['raItems'][0]['FTDevPass']);
            echo $decypt;
        } else {


            if ($aCheckEmailByUser["rtCode"] == '200' && $aCheckEmailByUser['raItems'][0]['FTDevPass'] != null) {
                $authorize = true;
            } else if ($aCheckEmailByUser["rtCode"] == '200' && $aCheckEmailByUser['raItems'][0]['FTDevPass'] == null) {
                $authorize = false;
                set_cookie('StaAlwCreatPrj', $aCheckEmailByUser['raItems'][0]['FTDevAlwCreatePrj'], '31556926');
                set_cookie('TaskEmail', $email, '31556926');
                set_cookie('UsrDepCode', $aCheckEmailByUser['raItems'][0]['FTDepCode'], '31556926');
                set_cookie('UsrDevCode', $aCheckEmailByUser['raItems'][0]['FTDevCode'], '31556926');
            } else {
                set_cookie('EmailForRegister', $email, '31556926');
                $authorize = false;
            }

            set_cookie('RouteMenu', 'login', '31556926');

            echo json_encode(['rtCode' => $aCheckEmailByUser['rtCode'], 'authorize' => $authorize]);
        }
    }


    public function sendEmail()
    {
        $tEmail = $this->input->post('email');
        $encypt = base64_encode($tEmail);

        $this->load->library('phpmailer_lib');
        $mail = $this->phpmailer_lib->load();
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'AdaDevSecOps@gmail.com';
        $mail->Password = 'yoic saoe zbqt rsdy';
        $mail->SMTPSecure = 'tls';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $mail->Port     = 587;
        $mail->CharSet = "UTF-8";
        $mail->setFrom('AdaDevSecOps@gmail.com', 'Reset Password');
        $mail->addAddress($tEmail);
        $mail->Subject = 'Send Email Reset PAssword';

        // Set email format to HTML
        $mail->isHTML(true);
        // Email body content
        $mailContent = "<a href='" . base_url() . "index.php/validateEmail/" . $encypt . "'>กด link นี้เพื่อล้างรหัสและเข้าระบบแบบไม่มีรหัส</a>";
        $mail->Body = $mailContent;

        // Send email
        if (!$mail->send()) {
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
    }

    public function validateEmail($email)
    {
        $tEmail = base64_decode($email);

        $tResInsert = $this->Login_model->ResetPasswordValidate($tEmail);

        $this->load->view('menu/wNar');
    }


    public function savePassword()
    {
        $tPassword = $this->input->post('password');
        $this->load->library('encryption');
        $ciphertext = $this->encryption->encrypt($tPassword);
        $savePassword  = $this->Login_model->savePassword($ciphertext);
        echo $savePassword['rtCode'];
    }
    //ฟังก์ชั่นตรวจสอบว่า verify_password
    public function verify_password()
    {
        $tEmail = $this->input->post('email');
        $tPassword = $this->input->post('password');

        $aFindEmailAndPassword  = $this->Login_model->FindEmailAndPassword($tEmail, $tPassword);

        if ($aFindEmailAndPassword["rtCode"] == '200') {
            $authorize = false;
            set_cookie('StaAlwCreatPrj', $aFindEmailAndPassword['raItems'][0]['FTDevAlwCreatePrj'], '31556926');
            set_cookie('TaskEmail',  $tEmail, '31556926');
            set_cookie('UsrDepCode', $aFindEmailAndPassword['raItems'][0]['FTDepCode'], '31556926');
        } else {
            set_cookie('EmailForRegister',  $tEmail, '31556926');
        }
        set_cookie('RouteMenu', 'login', '31556926');
        echo $aFindEmailAndPassword['rtCode'];
    }




    //หน้าสมาชิก (เพิ่มข้อมูล)
    public function register()
    {
        // $this->load->model('Login_model');

        $aFilterDepartment = array();
        $aDepartment = $this->Login_model->GetDepartment($aFilterDepartment);
        $tDepCode = '';

        //ดึงข้อผู้ใช้
        $aUsrInfo       = $this->Center_model->GetUsrInfo();
        $aDataRoleUsr   = $this->Login_model->GetDataDevRole($tDepCode);
        $aDataProvince  = $this->Login_model->GetDataProvince();

        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');

        //ส่งข้อมูลกลับไปหน้า view
        $aParm = array(
            "DepartmentList"        => $aDepartment,
            "UsrInfo"               => $aUsrInfo,
            "DevRoleList"           => $aDataRoleUsr,
            "DataProvince"          => $aDataProvince,
            "tTitle"                => $this->lang->line('tTitle'),
        );
        $this->load->view("wRegister", $aParm);
    }

    //ฟังก์ชั่นสมัครสมาชิก (เพิ่มข้อมูล)
    public function registerMember()
    {
        // $this->load->model('Login_model');

        $aDataInsert = array(
            "oetName"               => $this->input->post('oetName'),
            "oetNickname"           => $this->input->post('oetNickname'),
            "oetEmail"              => $this->input->post('oetEmail'),
            "oetLine"               => $this->input->post('oetLine'),
            "oetTeam"               => $this->input->post('oetTeam'),
            "oetDepCode"            => $this->input->post('oetDepCode'),
            "osmRoleName"           => $this->input->post('osmRoleName'),
            "oetRegEdtShwStartDate" => $this->input->post('oetRegEdtShwStartDate'),
            "oetRegEdtShwEndDate"   => $this->input->post('oetRegEdtShwEndDate'),
            "oetWorkPlan"           => $this->input->post('oetWorkPlan'),
            "osmProvince"           => $this->input->post('osmProvince'),
            "oetLatLong"            => $this->input->post('oetLatLong'),
            "ocbroleadmin"            => $this->input->post('ocbroleadmin'),
            "ockactive"            => $this->input->post('ockactive'),
        );
        
        delete_cookie("EmailForRegister");

        $tResInsert = $this->Login_model->InsertMember($aDataInsert);
        echo $tResInsert;
    }

    //-------------------------------------//

    //หน้าสมาชิก (แก้ไขข้อมูล)
    public function editmember($membercode)
    {
        // $this->load->model('Login_model');

        $aFilterDepartment = array();
        $tDepCode = '';

        $aDepartment    = $this->Login_model->GetDepartment($aFilterDepartment);
        $aDatamember    = $this->Login_model->GetDataMember($membercode);
        $aDataRoleUsr   = $this->Login_model->GetDataDevRole($aDatamember['raItems'][0]['FTDepCode']);
        $aDataProvince  = $this->Login_model->GetDataProvince();

        // print_r($aDatamember);
        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');

        //ส่งข้อมูลกลับไปหน้า view
        $aParm = array(
            "Datamember"            => $aDatamember,
            "DepartmentList"        => $aDepartment,
            "DevRoleList"           => $aDataRoleUsr,
            "DataProvince"          => $aDataProvince,
            "tTitle"                => $this->lang->line('tTitle'),
        );
        $this->load->view("wRegister_Edit", $aParm);
    }

    //ฟังก์ชั่นแก้ไขข้อมูล (แก้ไขข้อมูล)
    public function eventeditmember()
    {
        // $this->load->model('Login_model');

        $aDataEdit = array(
            "idcode"                => $this->input->post('idcode'),
            "oetName"               => $this->input->post('oetName'),
            "oetNickname"           => $this->input->post('oetNickname'),
            "oetEmail"              => $this->input->post('oetEmail'),
            "oetLine"               => $this->input->post('oetLine'),
            "oetTeam"               => $this->input->post('oetTeam'),
            "oetDepCode"            => $this->input->post('oetDepCode'),
            "ockactive"             => $this->input->post('ockactive'),
            "osmRoleName"           => $this->input->post('osmRoleName'),
            "oetRegEdtShwStartDate" => $this->input->post('oetRegEdtShwStartDate'),
            "oetRegEdtShwEndDate"   => $this->input->post('oetRegEdtShwEndDate'),
            "oetWorkPlan"           => $this->input->post('oetWorkPlan'),
            "osmProvince"           => $this->input->post('osmProvince'),
            "oetLatLong"            => $this->input->post('oetLatLong'),
            "ocbroleadmin"          => $this->input->post('ocbroleadmin'),
        );

        $tResEdit = $this->Login_model->EditMember($aDataEdit);
        echo $tResEdit;
    }

    //-------------------------------------//

    public function logout()
    {
        delete_cookie('TaskEmail');
        delete_cookie('StaAlwCreatPrj');
        delete_cookie('EmailForRegister');
        delete_cookie('UsrDepCode');
        delete_cookie('UsrDevCode');
        redirect('/home', 'refresh');
    }


    //ฟังก์ชั่นแก้ไขข้อมูล (แก้ไขข้อมูล)
    public function FSaCGetDevRole()
    {
        $tDepCode       = $this->input->post('tDepCode');
        $aDataRoleUsr   = $this->Login_model->GetDataDevRole($tDepCode);

        //ส่งข้อมูลกลับไปหน้า view
        $aParam = array(
            "DevRoleList"           => $aDataRoleUsr,
        );
        echo json_encode($aParam);
    }

    public function FSaCGetHoliday()
    {
        $aDataHoliday   = $this->Login_model->GetDataHolidays();
        return $this->output->set_content_type('application/json')->set_output(json_encode($aDataHoliday));
    }
}
