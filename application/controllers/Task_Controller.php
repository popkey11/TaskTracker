<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Task_Controller extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Task_model');
		$this->load->model('Center_model');

		$this->load->helper(array('form', 'url', 'security'));
		$this->load->library('form_validation');

		if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE) {
			echo "ERROR XSS Filter";
		}
	}

	public function index()
	{
		$tUsrEmail = get_cookie('TaskEmail');

		if ($tUsrEmail == '') {

			redirect(base_url());
		} else {


			$aFilter = $this->Task_model->GetFilter($tUsrEmail);

			$dCurrentDate = date('Y-m-d');
			if ($aFilter['rtCode'] == '200') {

				if ($aFilter['raItems'][0]['FDFltLastFilter'] != $dCurrentDate) {

					$dFilter = $dCurrentDate;
				} else {
					$dFilter = $aFilter['raItems'][0]['FDFltDate'];
				}
			} else {
				$dFilter = $dCurrentDate;
			}


			$aTaskList = $this->Task_model->GetTask($tUsrEmail, $dFilter);

			$aSummaryTimes = $this->Task_model->SummaryTimeByDate($tUsrEmail, $dFilter);

			$aTimeCard = $this->Task_model->GetTimeCrad($tUsrEmail);

			$this->load->helper('language');
			$this->lang->load('main_lang', 'english');
			$tDashboardURL = $this->Center_model->GetDashboardURL();
			$aParm = array(
				"tUsrEmail" => $tUsrEmail,
				"TaskList" => $aTaskList,
				"SummaryTimes" => $aSummaryTimes,
				'dFilter' => $dFilter,
				'aTimeCard' => $aTimeCard,
				'tDashboardURL' => $tDashboardURL,
				'tTitle' => $this->lang->line('tTitle')
			);

			$this->load->view('wTask', $aParm);
		}
	}

	//หน้าจอสร้างงานใหม่
	public function pagecreatenewtask()
	{

		$tUsrEmail = get_cookie('TaskEmail');

		if ($tUsrEmail == '') {

			redirect(base_url());
		} else {

			$aProject 	= $this->Task_model->GetProject();
			$aPhase 	= $this->Task_model->FSaMGetPhase();
			$this->load->helper('language');
			$this->lang->load('main_lang', 'english');
			$aParm = array(
				"tUsrEmail" 	=> get_cookie('TaskEmail'),
				"ProjectList"	=> $aProject,
				"aPhaseList"	=> $aPhase,
				"tTitle" 		=> $this->lang->line('tTitle')
			);
			$this->load->view('wCreatenewtask', $aParm);
		}
	}

	//อีเว้นสร้างงานใหม่
	public function createnewtask()
	{
		//เพิ่มข้อมูล
		$tProjectname 	= $this->input->post('ocmproject'); //$_POST['ocmproject'];
		$tPhaseCode 	= (!empty($this->input->post('ocmPhase')) ? $this->input->post('ocmPhase') : '');
		$tPoCode 		= (!empty($this->input->post('ocmPrjRelease')) ? $this->input->post('ocmPrjRelease') : '');
		// $tTextdetail = htmlspecialchars($_POST['otaTextDetail']);
		// $tTextremark = htmlspecialchars($_POST['otaTextRemark']);

		$tTextdetail = $this->input->post('otaTextDetail'); //$_POST['otaTextDetail'];
		$tTextremark = $this->input->post('otaTextRemark', FALSE); //$_POST['otaTextRemark'];

		$aResult = $this->Task_model->Createnewtask(get_cookie('TaskEmail'), $tProjectname, $tTextdetail, $tTextremark, $tPhaseCode, $tPoCode);

		//กลับไปหน้าแรก
		if ($aResult['rtCode'] == '200') {
			echo json_encode([
				'rtCode' => 200,
				'rtMessage' => 'เพิ่มงานใหม่สำเร็จ'
			]);
		} else {
			echo json_encode([
				'rtCode' => 500,
				'rtMessage' => 'เพิ่มงานใหม่ไม่สำเร็จ กรูณาลองใหม่อีกครั้ง'
			]);
		}
		exit;
		// redirect('/Task', 'refresh');
	}

	public function CheckCreateTask()
	{

		$aTaskStart = $this->Task_model->CheckCreateTask(get_cookie('TaskEmail'));

		echo $aTaskStart['raItems'][0]['nCountTskStart'];
	}

	public function CheckStartTask()
	{

		$aTaskStart = $this->Task_model->CheckStartTask(get_cookie('TaskEmail'));

		echo $aTaskStart['raItems'][0]['nCountTskStart'];
	}

	public function PauseTask()
	{

		$ptTaskID = $this->input->post('ptTaskID');

		echo $aTaskStart = $this->Task_model->PauseTask(get_cookie('TaskEmail'), $ptTaskID);
	}

	public function StartTask()
	{

		$ptTaskID = $this->input->post('ptTaskID');

		echo $aTaskStart = $this->Task_model->StartTask(get_cookie('TaskEmail'), $ptTaskID);
	}

	public function FinishTask()
	{

		$ptTaskID = $this->input->post('ptTaskID');
		$ptEndTaskRmk = $this->input->post('ptEndTaskRmk', FALSE);
		$dDateInEMode = $this->input->post('dDateInEMode');
		$tTimeInEMode = $this->input->post('tTimeInEMode');
		$dDateOutEMode = $this->input->post('dDateOutEMode');
		$tTimeOutEMode = $this->input->post('tTimeOutEMode');

		// วันที่ - เวลา เริ่มงาน
		$aDateInEMode = explode("/", $dDateInEMode);
		$dDateInEMode = $aDateInEMode[2] . '-' . $aDateInEMode[1] . '-' . $aDateInEMode[0];
		$dTskStart = $dDateInEMode . ' ' . $tTimeInEMode;
		$dTskStart = date("Y-m-d H:i:s", strtotime($dTskStart));

		// วันที่ - เวลา จบงาน
		$aDateOutEMode = explode("/", $dDateOutEMode);
		$dDateOutEMode = $aDateOutEMode[2] . '-' . $aDateOutEMode[1] . '-' . $aDateOutEMode[0];
		$dTskFinish = $dDateOutEMode . ' ' . $tTimeOutEMode;
		$dTskFinish = date("Y-m-d H:i:s", strtotime($dTskFinish));

		// echo $dTskStart.'>'.$dTskFinish;

		echo $aTaskStart = $this->Task_model->FinishTask(get_cookie('TaskEmail'), $ptTaskID, $ptEndTaskRmk, $dTskStart, $dTskFinish);
	}

	public function DeleteTask()
	{

		$ptTaskID = $this->input->post('ptTaskID');

		echo $aTaskStart = $this->Task_model->DeleteTask(get_cookie('TaskEmail'), $ptTaskID);
	}

	public function CopyTask()
	{

		$ptTaskID = $this->input->post('ptTaskID');

		echo $aTaskStart = $this->Task_model->CopyTask(get_cookie('TaskEmail'), $ptTaskID);
	}

	public function InsertFilter()
	{

		$dFilter = $this->input->post('dFilter');

		$this->Task_model->InsertFilter(get_cookie('TaskEmail'), $dFilter);
	}

	// บันทึกการเข้างาน
	public function TimeCardCheckIN()
	{

		$nRows = $this->Task_model->TimeCardCheckForgetCheckOut();

		if ($nRows > 0) {
			echo '2';  //Forget Checkout  Checkout brfore chekin
		} else {
			echo '1'; //Normal CheckIn
		}

		$this->Task_model->TimeCardCheckIN(get_cookie('TaskEmail'));
	}

	// พักเบรก
	public function TimeCardTakeBreak()
	{

		$aCheckInSta = $this->Task_model->GetTimeCrad(get_cookie('TaskEmail'));

		if ($aCheckInSta['rtCode'] == '200') {
			$this->Task_model->TimeCardTakeBreak(get_cookie('TaskEmail'));
			echo 'success';
		} else {
			echo 'error';
		}
	}

	public function TimeCardCheckOut()
	{

		$aCheckInSta = $this->Task_model->GetTimeCrad(get_cookie('TaskEmail'));

		if ($aCheckInSta['rtCode'] == '200') {
			$this->Task_model->TimeCardCheckOut(get_cookie('TaskEmail'));
			echo 'success';
		} else {
			echo 'error';
		}
	}


	//appends all error messages
	private function handle_error($err)
	{
		$this->error .= nl2br($err . "\n");
	}

	//appends all success messages
	private function handle_success($succ)
	{
		$this->success .= nl2br($succ . "\n");
	}

	public function UploadImage()
	{
		if ($_FILES['file']['name']) {
			//set preferences
			//file upload destination
			$upload_path = './assets/Images/';
			$config['upload_path'] = $upload_path;
			//allowed file types. * means all types
			$config['allowed_types'] = 'jpg|png|gif';
			//allowed max file size. 0 means unlimited file size
			$config['max_size'] = '0';
			//max file name size
			$config['max_filename'] = '400';
			//whether file name should be encrypted or not
			$config['encrypt_name'] = TRUE;
			//store image info once uploaded
			$image_data = array();
			//check for errors
			$is_file_error = FALSE;
			//check if file was selected for upload
			if (!$_FILES) {
				$is_file_error = TRUE;
				echo 'Select an image file.';
			}
			//if file was selected then proceed to upload
			if (!$is_file_error) {
				//load the preferences
				$this->load->library('upload', $config);
				$this->upload->initialize($config);

				//check file successfully uploaded. 'image_name' is the name of the input
				if (!$this->upload->do_upload('file')) {
					//if file upload failed then catch the errors
					$error = array('error' => $this->upload->display_errors());
					echo print_r($error);
				} else {
					//store the file info
					$image_data = $this->upload->data();
					$config['image_library'] = 'gd2';
					$config['source_image'] = $image_data['full_path']; //get original image
					$config['maintain_ratio'] = TRUE;
					$config['width'] = 700;
					$config['height'] = 650;
					$config['quality'] = 100;
					$config['remove_spaces'] = TRUE;

					$this->load->library('image_lib', $config);
					if (!$this->image_lib->resize()) {
						echo 'No resize';
					}
				}
			} else {
				echo 'error';
			}
			// There were errors, we have to delete the uploaded image
			if ($is_file_error) {
				echo 'file error';
				if ($image_data) {
					$file = $upload_path . $image_data['file_name'];
					if (file_exists($file)) {
						unlink($file);
						echo 'unlink';
					}
				}
			} else {

				$data['resize_img'] = $upload_path . $image_data['file_name'];
				echo base_url('assets/Images/' . $image_data['file_name']);
			}
		} else {
			//1:no input file
			echo 'no input file';
		}
	}
	public function FSaCTSKGetRelease()
	{
		$tPrjCode = $this->input->post('tPrjCode');
		if ($tPrjCode != '' || !empty($tPrjCode) && $tPrjCode != 'null') {
			$aResult = $this->Task_model->FSaMTSKGetReleaseByPrjCode($tPrjCode);
			if ($aResult['rtCode'] == '200') {
				echo json_encode([
					'rtCode' => '200',
					'rtStatus' => 'success',
					'raItems' => $aResult['raItems'] ?? []
				]);
			} else {
				echo json_encode([
					'rtCode' => '404',
					'rtStatus' => 'fail',
					'rtMsg' => 'ไม่พบข้อมูล Release ในโปรเจคนี้',
				]);
			}
		} else {
			echo json_encode([
				'rtCode' => '400',
				'rtStatus' => 'error',
				'rtMsg' => 'ไม่มีข้อมูลโปรเจค'
			]);
		}
		exit;
	}

	public function FSaCTSKUpdatePO()
	{
		$tTaskID = $this->input->post('ptTaskID');
		$tPoCode = $this->input->post('ptPoRelease');

		if (!empty($tTaskID) && !empty($tPoCode)) {
			$aResult = $this->Task_model->FSaMTSKUpdatePOByTaskID($tTaskID, $tPoCode);
			if ($aResult['rtCode'] == '200') {
				echo json_encode([
					'rtCode' => '200',
					'rtStatus' => 'success',
				]);
			} else {
				echo json_encode([
					'rtCode' => '404',
					'rtStatus' => 'fail',
				]);
			}
		} else {
			echo json_encode([
				'rtCode' => '400',
				'rtStatus' => 'error',
			]);
		}
	}
}
