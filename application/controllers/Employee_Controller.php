<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Employee_Controller extends CI_Controller {

	public function __construct()
	{
			parent::__construct();
            
            $this->load->model('Center_model');
			$this->load->model('Employee_model');
            $this->load->model('Project_model');

			$this->load->helper(array('form', 'url','security'));
			$this->load->library('form_validation');

            if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE){
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

        $aParm = array("tUsrEmail"=>$tUsrEmail);

         //ดึงข้อมูลแผนก
         $aFilterDepartment = array();
         $aDepartment = $this->Project_model->GetDepartment($aFilterDepartment);

         //ดึงข้อผู้ใช้
         $aUsrInfo = $this->Center_model->GetUsrInfo();
		 $this->load->helper('language');
		 $this->lang->load('main_lang', 'english');
         $tDashboardURL = $this->Center_model->GetDashboardURL();
         $aParm = array(
                    "DepartmentList"    => $aDepartment,
                    "UsrInfo"           => $aUsrInfo,
                    'tDashboardURL'     => $tDashboardURL,
                    "tTitle"            => $this->lang->line('tTitle')
                );

         $this->load->view('wEmployee',$aParm );
    }

    public function GetEmployee()
	{

        $tUsrEmail = get_cookie('TaskEmail');

        $tDevCode = $this->input->post('tDevSearch'); 
        $tLikeSearch = $this->input->post('tLikeSearch'); 

        
        $nPage = $this->input->post('nPage'); 

        
        $aFilter = array("tDevCode" => $tDevCode,
                         "LikeSearch" => $tLikeSearch,
                         "nPage" => $nPage );

         $aEmployeeList = $this->Employee_model->GetEmployee($aFilter);

         $aPram = array("EmployeeList" => $aEmployeeList);

         $this->load->view('wEmployeeList',$aPram );
    }

    public function DeleteEmployee(){

        $tEmpCode = $this->input->post('tEmpCode'); 
        $aKeyDelete = array("tEmpCode"=>$tEmpCode);
        $aEmployeeList = $this->Employee_model->DeleteEmployee($aKeyDelete);

    }   
}

?>