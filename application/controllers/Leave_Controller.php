<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Leave_Controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Task_model');
		$this->load->model('Center_model');
		$this->load->model('Leave_model');
		$this->load->helper(array('form', 'url', 'security'));
		$this->load->library('form_validation');
		$this->load->library('upload');
		if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE) {
			echo "ERROR XSS Filter";
		}
	}

	public function FCNxCLEVIndex()
	{
		$tUsrEmail = get_cookie('TaskEmail');
		$tUsrDepCode = get_cookie('UsrDepCode');
		$tUsrAdmin = get_cookie('StaAlwCreatPrj');
		$tUsrAdminCheck = ($tUsrAdmin == 3) ? true : false;

		$this->load->helper('language');
		$this->lang->load('main_lang', 'english');
		$aDataLeave = $this->Leave_model->FSxMLEVLeaveDataLeave();
		$aLeaveTypeList = $this->Leave_model->FSxMLEVLeaveDataType();
		$tDashboardURL = $this->Center_model->GetDashboardURL();
		$aLeavePvnList = $this->Leave_model->FSxMLEVLeaveDataProvince();
		$aLeaveDPMList = $this->Leave_model->FSxMLEVLeaveDataDepartment();
		$aLeaveTeamList = $this->Leave_model->FSxMLEVLeaveDataLeaveTeam();
		$aLeaveNameList = $this->Leave_model->FSxMLEVLeaveDataLeaveName();
		$aParm = array(
			"tUsrEmail" => $tUsrEmail,
			"tUsrDepCode" => $tUsrDepCode,
			"aDataLeaveList" => $aDataLeave,
			"aLeaveTypeList" => $aLeaveTypeList,
			"aLeaveDPMList" => $aLeaveDPMList,
			"aLeavePvnList" => $aLeavePvnList,
			'tDashboardURL' => $tDashboardURL,
			"tTitle" => $this->lang->line('tTitle'),
			"aLeaveNameList" => $aLeaveNameList,
			"aLeaveTeamList" => $aLeaveTeamList,
			"tUsrAdminCheck" => $tUsrAdminCheck,
		);
		$this->load->view('Leave/wLeave', $aParm);
	}

	public function FSxCLEVLeaveDataGetLeave()
{
    $aLeaveTypeList = $this->Leave_model->FSxMLEVLeaveDataType();
    $tDashboardURL = $this->Center_model->GetDashboardURL();
	$aLeaveTeamList = $this->Leave_model->FSxMLEVLeaveDataLeaveTeam();
	$aLeaveNameList = $this->Leave_model->FSxMLEVLeaveDataLeaveName();
	$aLeavePvnList = $this->Leave_model->FSxMLEVLeaveDataProvince();
	$aLeaveDPMList = $this->Leave_model->FSxMLEVLeaveDataDepartment();

    $nStatus = $this->input->post('nStatus');
    $tType = $this->input->post('tType');
    $tRemark = $this->input->post('tRemark');
    $dStartDate = $this->input->post('dStartDate');
    $dEndDate = $this->input->post('dEndDate');
    $nPage = $this->input->post('nPage');

    $aFilter = array(
        "nStatus" => $nStatus,
        "tType" => $tType,
        "tRemark" => $tRemark,
        "dStartDate" => $dStartDate,
        "dEndDate" => $dEndDate,
        "nPage" => $nPage,
    );

    $aLeaveList = $this->Leave_model->FSxMLEVLeaveDataGetLeave($aFilter);
    $aParm = array(
        "aLeaveTypeList" => $aLeaveTypeList,
        "aLeaveList" => $aLeaveList,
        "aLeavePvnList" => $aLeavePvnList,
        "aLeaveDPMList" => $aLeaveDPMList,
        "tDashboardURL" => $tDashboardURL,
		"aLeaveNameList" => $aLeaveNameList,
		"aLeaveTeamList" => $aLeaveTeamList,
    );
    $this->load->view('Leave/wLeaveList', $aParm);
}
	public function FSxCLEVLeaveDataLeaveManage() {
		$tUsrEmail = get_cookie('TaskEmail');
		$tUsrDepCode = get_cookie('UsrDepCode');
		$this->load->helper('language');
		$this->lang->load('main_lang', 'english');
		$aDataLeave = $this->Leave_model->FSxMLEVLeaveDataLeave();
		$aLeaveTeamList = $this->Leave_model->FSxMLEVLeaveDataLeaveTeam();
		$aLeaveNameList = $this->Leave_model->FSxMLEVLeaveDataLeaveName();
		$aLeaveTypeList = $this->Leave_model->FSxMLEVLeaveDataType();
		$aLeavePvnList = $this->Leave_model->FSxMLEVLeaveDataProvince();
		$tDashboardURL = $this->Center_model->GetDashboardURL();

		$aLeaveDPMList = $this->Leave_model->FSxMLEVLeaveDataDepartment();

		$aParm = array(
			"tUsrEmail" => $tUsrEmail,
			"tUsrDepCode" => $tUsrDepCode,
			"aDataLeaveList" => $aDataLeave,
			"aLeaveTypeList" => $aLeaveTypeList,
			"aLeavePvnList" => $aLeavePvnList,
			"aLeaveDPMList" => $aLeaveDPMList,
			"aLeaveNameList" => $aLeaveNameList,
			"aLeaveTeamList" => $aLeaveTeamList,
			"tDashboardURL" => $tDashboardURL,
			"tTitle" => $this->lang->line('tTitle'),
		);

		$this->load->view('Leave/wLeaveManage', $aParm);
	}

	public function FSxCLEVLeaveDataGetLeaveManage()
	{
		$tUsrEmail = get_cookie('TaskEmail');
		$tUsrDepcode = get_cookie('UsrDepCode');
		$this->load->helper('language');
		$this->lang->load('main_lang', 'english');

		$aDataLeave = $this->Leave_model->FSxMLEVLeaveDataLeave();
		$aLeaveTypeList = $this->Leave_model->FSxMLEVLeaveDataType();
		$aLeaveNameList = $this->Leave_model->FSxMLEVLeaveDataLeaveName();
		$aLeaveTeamList = $this->Leave_model->FSxMLEVLeaveDataLeaveTeam();
		$aLeavePvnList = $this->Leave_model->FSxMLEVLeaveDataProvince();
		$tDashboardURL = $this->Center_model->GetDashboardURL();
		$aLeaveDPMList = $this->Leave_model->FSxMLEVLeaveDataDepartment();
		$tTeam = $this->input->post('tTeam');
		$tName = $this->input->post('tName');
		$tDPM = $this->input->post('tDPM');
		$nStatus = $this->input->post('nStatus');
		$tApproveby = $this->input->post('tApproveby');
		$tType = $this->input->post('tType');
		$tProvince = $this->input->post('tProvince');
		$tComment = $this->input->post('tComment');
		$dStartDate = $this->input->post('dStartDate');
		$dEndDate = $this->input->post('dEndDate');
		$nPage = $this->input->post('nPage');


		$aFilter = array(
			"nStatus" => $nStatus,
			"tType" => $tType,
			"dStartDate" => $dStartDate,
			"dEndDate" => $dEndDate,
			"tTeam" => $tTeam,
			"tName" => $tName,
			"tDPM" => $tDPM,
			"tProvince" => $tProvince,
			"tComment" => $tComment,
			"tApproveby" => $tApproveby,
			"nPage" => $nPage,
		);


        $aLeaveManageList = $this->Leave_model->FSxMLEVLeaveDataGetLeaveManage($aFilter);
        $aParm = array(
            "aLeaveManageList" => $aLeaveManageList,
            "aLeaveDPMList" => $aLeaveDPMList,
            "tDashboardURL" => $tDashboardURL,
        );
        
        $this->load->view('Leave/wLeaveManageList', $aParm);
    } 
	public function FSxCLEVLeaveDataApproveLeave()
	{

		
		$FTLvhCode = $this->input->post('FTLvhCode');
		$otaComment = $this->input->post('FTLvhComment');
		$result = $this->Leave_model->FSxMLEVLeaveDataApproveLeave($FTLvhCode, $otaComment);
		return $this->output->set_output($result);
	}

	public function FSxCLEVLeaveDataAddToGoogleSheet() {
		
		$tUsrEmail = get_cookie('TaskEmail');
		$UserInfo = $this->Leave_model->FSxMLEVLeaveDataGetUserInfo($tUsrEmail);
			if ($UserInfo) {
    		$tDevname = $UserInfo['FTDevName'];    	
		} else {
		}
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

		$url = "https://script.google.com/macros/s/AKfycbzvKjykNXYgtfgARdikfpmD8ItzLXiiNYrHfXqsPKS_juJ14mGSdPYansCpdj7jz3-xag/exec?action=addLeave";
		$dataToSend = array(
            "CreateOn" => $data["CreateOn"],
            "DevName" => $data["DevName"],
            "DateFrom" => $data["DateFrom"],
            "DateTo" => $data["DateTo"],
            "Amout" => $data["Amout"],
            "Team" => $data["Team"],
            "Type" => $data["Type"],
            "Province" => $data["Province"],
            "ApproveStatus" => $data["ApproveStatus"],
            "ApproveBy" => $tDevname,
            "Remark" => $data["Remark"]
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataToSend));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
	public function FSxCLEVLeaveDataDenyLeave()
	{
		$FTLvhCode = $this->input->post('FTLvhCode');
		$otaComment = $this->input->post('FTLvhComment');
		$result = $this->Leave_model->FSxMLEVLeaveDataDenyLeave($FTLvhCode, $otaComment);
		return $this->output->set_output($result);
	}
    public function FSxCLEVLeaveDataCancle(){
        $FTLvhCode = $this->input->post('FTLvhCode'); 
        $result = $this->Leave_model->FSxMLEVLeaveDataCancle($FTLvhCode);
        return $this->output->set_output($result);
    }
	public function FSxCLEVLeaveDataRollback()
	{
		$FTLvhCode = $this->input->post('FTLvhCode');
		$result = $this->Leave_model->FSxMLEVLeaveDataRollback($FTLvhCode);
		return $this->output->set_output($result);
	} 

	public function FSxCLEVLeaveDataUpdate()
	{
		$FTLvhCode = $this->input->post('FTLvhCode');
		$FTLvhStaApv = $this->input->post('FTLvhStaApv');
		$ocmLSUpdateType = $this->input->post('ocmLSUpdateType');
		$odpLSUpdateDateFrom = $this->input->post('odpLSUpdateDateFrom');
		$odpLSUpdateDateTo = $this->input->post('odpLSUpdateDateTo');
		$otaLSUpdateRemark = $this->input->post('otaLSUpdateRemark');
		$ocmLSUpdateProvince = $this->input->post('ocmLSUpdateProvince');
		$oetLSUpdateDayQty = $this->input->post('oetLSUpdateDayQty');
		$otaLSUpdateRemark = $this->input->post('otaLSUpdateRemark');

		$oflAttachment = '';
		if (!empty($_FILES['oflAttachment']['name'])) {
			$upload_path = FCPATH . 'assets/Images/Leavefile/';
			$config['upload_path'] = $upload_path;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|ppt|pptx';
			$config['max_size'] = 2048;
			$config['file_name'] = 'leave_attachment_' . uniqid();

			$this->load->library('upload');
			$this->upload->initialize($config);
			if (!$this->upload->do_upload('oflAttachment')) {
				$error = $this->upload->display_errors();
				echo $error;
				return;
			} else {
				$data = $this->upload->data();
				$oflAttachment = 'assets/Images/Leavefile/' . $data['file_name'];
			}
		}

		$result = $this->Leave_model->FSxMLEVLeaveDataUpdate(
			$FTLvhCode,
			$ocmLSUpdateType,
			$odpLSUpdateDateFrom,
			$odpLSUpdateDateTo,
			$ocmLSUpdateProvince,
			$otaLSUpdateRemark,
			$oflAttachment,
			$oetLSUpdateDayQty,
			$FTLvhStaApv,
		);

		if ($result == 'success') {
			echo 'success';
		} else {
			echo 'error';
		}
	}

	public function FSxCLEVLeaveDataAddLeave()
{
    $tUsrEmail = get_cookie('TaskEmail');
    $this->load->helper('language');
    $this->lang->load('main_lang', 'english');
    $aLeaveTypeList = $this->Leave_model->FSxMLEVLeaveDataType();
    $aLeavePvnList = $this->Leave_model->FSxMLEVLeaveDataProvince();
    $userInfo = $this->Leave_model->FSxMLEVLeaveDataCheckLeaveHistory($tUsrEmail);
	$upload_path = FCPATH . 'assets/Images/Leavefile/';
	$oflAttachment = '';
	if (!empty($_FILES['oflAttachment']) && $_FILES['oflAttachment']['name'] != '') {		
        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|ppt|pptx';
        $config['max_size'] = 2048;
        $config['file_name'] = 'leave_attachment_' . uniqid();
        $this->load->library('upload');
        $this->upload->initialize($config); 
        if (!$this->upload->do_upload('oflAttachment')) {
			$error = $this->upload->display_errors();
			echo $error;
		} else {
			$data = $this->upload->data(); 
			$oflAttachment = 'assets/Images/Leavefile/' . $data['file_name']; 
		}
    }

    if ($userInfo != '3') {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->db->select('FTDevCode');
            $this->db->where('FTDevEmail', $tUsrEmail);
            $query = $this->db->get('TTSDevTeam');
            if ($query->num_rows() > 0) {
                $row = $query->row();
                $tDevCode = $row->FTDevCode;
            } else {
                $tDevCode = '';
            }
            $tAddTypeCode = $this->input->post('ocmLSAddType');
            $dAddDateFrom = $this->input->post('odpLSAddDateFromHidden');
            $dAddDateTo = $this->input->post('odpLSAddDateToHidden');
            $tAddRemark = $this->input->post('otaLSAddRemark');
            $tAddProvince = $this->input->post('ocmLSAddProvince');
			$cAddDayQty = $this->input->post('oetLSAddDayQty');
			$nAddHR = $this->input->post('ocmAddNameHr');
            $aData = array(
                'FTLvhType' => $tAddTypeCode,
                'FDLvhDateFrom' => $dAddDateFrom,
                'FDLvhDateTo' => $dAddDateTo,
                'FTLvhRemark' => $tAddRemark,
                'FTLvhPvnCode' => $tAddProvince,
				'FCLvhDayQty' => $cAddDayQty,
				'FTLvhAttachFile' => $oflAttachment,
				'FTLvhDevCode' => $nAddHR,
            );
            $result = $this->Leave_model->FSxMLEVLeaveDataAddLeave($aData);
            if ($result['rtCode'] == '200') {
                $hasAttachment = $result['hasAttachment'];
                $response = array(
                    'statusCode' => 200,
                    'hasAttachment' => $hasAttachment,
                    'message' => 'บันทึกการลาเรียบร้อย'
                );
            } else {
                echo $result;
				return;
            }
            echo json_encode($response);
        } else {
            $aParm = array(
                "tUsrEmail" => $tUsrEmail,
                "aLeaveTypeList" => $aLeaveTypeList,
                "aLeavePvnList" => $aLeavePvnList,
                'tTitle' => $this->lang->line('tTitle'),
            );
            $this->load->view('Leave/wLeave', $aParm);
        }		
    }
}


 
	public function FSxCLEVLeaveGetLeaveM()
	{
		$FTLvhCode = $this->input->post('FTLvhCode');
		$aLeaveDataM = $this->Leave_model->FSxMLEVLeaveGetLeaveM($FTLvhCode);
		echo $aLeaveDataM; 
	}

	public function FSxCLEVLeaveGetLeaveMng()
	{
		$FTLvhCode = $this->input->post('FTLvhCode');
		$aLeaveDataMng = $this->Leave_model->FSxMLEVLeaveGetLeaveMng($FTLvhCode);
		echo $aLeaveDataMng; 
	}
	public function FSxCLEVLeaveGetDevNameByTeam() {
		$selectedTeam = $this->input->post('selectedTeam');
		if ($selectedTeam == '') {
			$tDevName = $this->Leave_model->FSxMLEVLeaveDataLeaveName();
		} else {
			$tDevName = $this->Leave_model->FSxMLEVLeaveGetDevNameByTeam($selectedTeam);
		}
		$options = '';

		if (is_array($tDevName)) {
			foreach($tDevName as $tDevNames) {
				$options .= '<option value="'.$tDevNames['FTDevCode'].'">'.$tDevNames['FTDevName'].'</option>';
			}
		} 
		echo $options;
	}
    public function FSxCLEVLeaveGetAllEmployees() {
        $tDevName = $this->Leave_model->FSxMLEVLeaveDataLeaveName();
        $options = '<option value="">ทั้งหมด</option>';
        foreach($tDevName['raItems'] as $tDevNames) {
            $options .= '<option value="'.$tDevNames['FTDevCode'].'">'.$tDevNames['FTDevName'].'</option>';
        }
        echo $options;
    }
}

?>
