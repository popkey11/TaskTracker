<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Project_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Center_model');
        $this->load->model('Project_model');

        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library('form_validation');

        if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE) {
            echo "ERROR XSS Filter";
        }


        $tUsrEmail = get_cookie('TaskEmail');
        if ($tUsrEmail == "") {
            redirect('/home', 'refresh');
        }
    }

    public function index()
    {
        $tUsrEmail = get_cookie('TaskEmail');

        $aParm = array("tUsrEmail" => $tUsrEmail);

        //ดึงข้อมูลแผนก
        $aFilterDepartment = array();
        $aDepartment = $this->Project_model->GetDepartment($aFilterDepartment);

        //ดึงข้อผู้ใช้
        $aUsrInfo      = $this->Center_model->GetUsrInfo();
        $tDashboardURL = $this->Center_model->GetDashboardURL();

        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');

        $aParm = array(
            "DepartmentList"    => $aDepartment,
            "UsrInfo"           => $aUsrInfo,
            'tDashboardURL'     => $tDashboardURL,
            "tTitle"            => $this->lang->line('tTitle')
        );

        $this->load->view('wProject', $aParm);
    }

    // Get All Project
    public function GetProject()
    {
        $tUsrEmail = get_cookie('TaskEmail');

        $tDevCode       = $this->input->post('tDevSearch');
        $tLikeSearch    = $this->input->post('tLikeSearch');
        $nPage          = $this->input->post('nPage');


        $aFilter = array(
            "tDevCode"      => $tDevCode,
            "LikeSearch"    => $tLikeSearch,
            "nPage"         => $nPage
        );

        $aProjectList   = $this->Project_model->GetProject($aFilter);
        $aParm          = array("ProjectList" => $aProjectList);

        $this->load->view('wProjectList', $aParm);
    }
    // Open Form Create Project
    public function AddNewProject()
    {
        $tUsrEmail = get_cookie('TaskEmail');

        $dFilter = '';

        //ดึงข้อมูลแผนก
        $aDepartment        = $this->Project_model->GetDepartment($dFilter);
        $aUsrInfo           = $this->Center_model->GetUsrInfo();
        $tUsrDepCode        = $aUsrInfo['raItems'][0]['FTDepCode']; //รหัสแผนกของผู้ใช้
        $tUsrDepName        = $aUsrInfo['raItems'][0]['FTDepName']; //ชื่อแผนกของผู้ใช้

        // หา Running Code
        $aFilterRunning     = array("tDepCode" => $tUsrDepCode);
        $nLastPrjRunning    = $this->Project_model->GetLastPrjCodeRunning($aFilterRunning);
        $tNextRunning       = sprintf('%03d', $nLastPrjRunning); //Running Code ตัวต่อไป

        $tCYear             = substr(date('Y'), 2); //หาปีปัจจุบัน

        $tNextPrjCode       = $tUsrDepCode . '' . $tCYear . $tNextRunning; // รหัสโปรเจ็คตัวถัดไป

        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');
        $tDashboardURL = $this->Center_model->GetDashboardURL();

        $aParm = array(
            "DepartmentList"    => $aDepartment,
            "PrjCode"           => $tNextPrjCode,
            "UsrDepCode"        => $tUsrDepCode,
            "UsrDevName"        => $tUsrDepName,
            'tDashboardURL'     => $tDashboardURL,
            "tTitle"            => $this->lang->line('tTitle')
        );

        $this->load->view('wCreateProject', $aParm);
    }

    //บันทึกข้อมูลโปรเจ็ค
    public function SaveNewProject()
    {
        $tPrjCode = !empty($this->input->post('oetPrjCode')) ? $this->input->post('oetPrjCode') : $this->input->post('ohdPrjCode');
        $tPrjName = $this->input->post('oetPrjName');
        $tDevCode = $this->input->post('oetDepCode');
        $tPrjStaUse = $this->input->post('ocmPrjStaUse');
        $nPrjStaUse = isset($tPrjStaUse) ? 1 : 2;
        $tPrjPoForce = $this->input->post('ocmPrjPoForce');
        $bPrjPoForce = isset($tPrjPoForce) ? 1 : 0;

        $nStaInsDup = $this->Project_model->CheckDuplicateProject($tPrjCode);


        $aDataInsert = array(
            "tPrjCode"  => $tPrjCode,
            "tPrjName"  => $tPrjName,
            "tDevCode"  => $tDevCode,
            "nPrjStaUse"  => $nPrjStaUse,
            'bPrjPoForce' => $bPrjPoForce
        );

        if ($nStaInsDup > 0) {
            echo 'Duplicate';
        } else {
            $tResInsert = $this->Project_model->SaveNewProject($aDataInsert);
            echo $tResInsert;
        }
    }

    // ลบข้อมูลโปรเจ็ค
    public function DeleteProject()
    {
        $tPrjCode = $this->input->post('tPrjCode');
        $this->Project_model->DeleteProject($tPrjCode);
    }


    //แสดงฟอร์มแก้ไขโปรเจ็ค
    public function EditProject($tPrjCode)
    {

        $aFilter            = array("tPrjCode" => $tPrjCode);

        $aProjectData       = $this->Project_model->GetProject($aFilter);

        $aFilterDepartment  = array();
        $aDepartment        = $this->Project_model->GetDepartment($aFilterDepartment);

        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');
        $tDashboardURL = $this->Center_model->GetDashboardURL();

        $aParm = array(
            "aProjects"         => $aProjectData,
            "DepartmentList"    => $aDepartment,
            'tDashboardURL'     => $tDashboardURL,
            "tTitle"            => $this->lang->line('tTitle')
        );
        $this->load->view('wEditProject', $aParm);
    }

    //แก้ไขข้อมูลโปรเจ็ค
    public function UpdateProject()
    {

        $tPrjCode = $this->input->post('oetPrjCode');
        $tPrjName = $this->input->post('oetPrjName');
        $tDevCode = $this->input->post('oetDepCode');
        $tPrjStaUse = $this->input->post('ocmPrjStaUse');
        $nPrjStaUse = isset($tPrjStaUse) ? 1 : 2;
        $tPrjPoForce = $this->input->post('ocbPrjPoForce');
        $bPrjPoForce = isset($tPrjPoForce) ? 1 : 0;




        $aDataUpdate = array(
            "tPrjCode"  => $tPrjCode,
            "tPrjName"  => $tPrjName,
            "tDevCode"  => $tDevCode,
            "nPrjStaUse"  => $nPrjStaUse,
            "bPrjPoForce" => $bPrjPoForce
        );
        if ($nStaInsDup > 0) {
            echo 'Duplicate';
        } else {

            $tResUpdate = $this->Project_model->UpdateProject($aDataUpdate);
            echo $tResUpdate;
        }
    }
}
