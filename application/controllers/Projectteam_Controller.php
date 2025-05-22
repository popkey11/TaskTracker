<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Projectteam_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Center_model');
        $this->load->model('Projectteam_model');
        $this->load->library('upload');
        // $this->load->helper(array('form', 'url', 'security'));
        // $this->load->library('form_validation');
        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');
        if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE) {
            echo "ERROR XSS Filter";
        }

        if (get_cookie('TaskEmail') == "") {
            redirect('/home', 'refresh');
        }
        $tStaAlwCreatPrj = get_cookie('StaAlwCreatPrj');
        if ($tStaAlwCreatPrj != '3' && $tStaAlwCreatPrj != '2') {
            redirect('/Task', 'refresh');
        }
    }

    /**
     * Functionality : Data List of Project Team
     * Parameters : -
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : view wProjectTeamList.php
     * Return Type : text/html
     */
    public function FStCPJTListView()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $tDashboardURL = $this->Center_model->GetDashboardURL();
        $aDevList = $this->Projectteam_model->FSaMPJTGetDevTeamAll();
        $aDevGroupTeam = $this->Projectteam_model->FSaMPJTGetDevGroupTeamAll();
        $aReleaseList = $this->Projectteam_model->FSaMPJTGetReleaseListAll();
        $aProjectList = $this->Projectteam_model->FSaMPJTGetProjectList($tUsrEmail);

        $aParm = [
            'tDashboardURL' => $tDashboardURL,
            'aProjectList' => $aProjectList['raItems'] ?? [],
            'aReleaseList' => $aReleaseList['raItems'] ?? [],
            'aDevList' => $aDevList['raItems'] ?? [],
            'aDevGroupTeamList' => $aDevGroupTeam['raItems'] ?? [],
            "tTitle" => $this->lang->line('tTitle')
        ];
        // dbug($aParm);
        $this->load->view('projectteam/wProjectteam', $aParm);
    }

    /**
     * Functionality : Get Project Team List
     * Parameters : -
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : view wPoList.php
     * Return Type : text/html
     */
    public function FStCPJTGetDataList()
    {
        // รับค่าที่ส่งมาจาก AJAX
        $tSearch = $this->input->post('tSearch');
        $tSearchProject = $this->input->post('nSearchProject');
        $tSearchRelease = $this->input->post('tSearchRelease');
        $nSearchDev  = $this->input->post('nSearchDev');
        $nSearchDevTeam = $this->input->post('nSearchDevTeam');
        $nPage = $this->input->post('nPage') ? $this->input->post('nPage') : 1;
        // ส่งค่าที่ได้รับมาเพื่อใช้กรองข้อมูล
        $aFilter = [
            'tSearch' => $tSearch,
            'tSearchProject' => $tSearchProject,
            'tSearchRelease' => $tSearchRelease,
            'nSearchDev' => $nSearchDev,
            'nSearchDevTeam' => $nSearchDevTeam,
            'nPage' => $nPage,
            'nRecordsPerPage' => 10 // จำนวนรายการต่อหน้า
        ];

        // ส่งค่าที่ได้รับมาเพื่อใช้กรองข้อมูลและกำหนดการแบ่งหน้า
        $aProjectTeamList = $this->Projectteam_model->FSaMPJTGetPaginatedData($aFilter);

        // คำนวณจำนวนข้อมูลทั้งหมดเพื่อใช้ในการแบ่งหน้า
        $nTotalRecord = $aProjectTeamList['rnTotalRecord'];
        $nTotalPages = ceil($nTotalRecord / $aFilter['nRecordsPerPage']);

        // ส่งข้อมูลไปยัง View
        $aData['aProjectTeamList'] = $aProjectTeamList['raItems'];
        $aData['nCurrentPage'] = $nPage;
        $aData['nTotalPages'] = $nTotalPages;
        $aData['nTotalRecord'] = $nTotalRecord;
        $this->load->view('projectteam/wProjectteamList', $aData);
    }

    /**
     * Functionality : Add New Project Team
     * Parameters : -
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : view wProjectteamForm.php
     * Return Type : text/html
     */
    public function FStCPJTPageAdd()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $tDashboardURL = $this->Center_model->GetDashboardURL();
        $aProjectList = $this->Projectteam_model->FSaMPJTGetProjectList($tUsrEmail);
        $aReleaseList = $this->Projectteam_model->FSaMPJTGetReleaseListAll();
        $aDevList = $this->Projectteam_model->FSaMPJTGetDevTeamAll();
        $aParm = [
            'tDashboardURL' => $tDashboardURL,
            'aProjectList' => $aProjectList['raItems'] ?? [],
            'aReleaseList' => $aReleaseList['raItems'] ?? [],
            'aDevList' => $aDevList['raItems'] ?? [],
            "tTitle" => $this->lang->line('tTitle'),
            'tAction' => base_url('index.php/masPJTEventAdd')
        ];

        $this->load->view('projectteam/wProjectteamForm', $aParm);
    }

    /**
     * Functionality : Insert New Project Team
     * Parameters : -
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : array status 
     * Return Type : string
     */
    public function FStCPJTEventAddData()
    {
        $tStartDate = $this->input->post('odpPjtStartDate');
        $tEndDate = $this->input->post('odpPjtEndDate');

        $dStartDate = !empty($tStartDate) ? DateTime::createFromFormat('d/m/Y', $tStartDate)->format('Y-m-d') : null;
        $dEndDate = !empty($tEndDate) ? DateTime::createFromFormat('d/m/Y', $tEndDate)->format('Y-m-d') : null;

        $aData = [
            'FTPrjCode' => $this->input->post('ocmPjtCode'),
            'FTPrjRelease' => $this->input->post('ocmPjtRelease'),
            'FTDevCode' => $this->input->post('ocmPjtDev'),
            'FDPrjPlanStart' => $dStartDate,
            'FDPrjActualStart' => $dStartDate,
            'FDPrjPlanFinish' => $dEndDate,
            'FDPrjActualFinish' => $dEndDate,
            'FTDepCode' => $this->input->post('ohdPjtDepCode'),
            'FTPrjStaActive' => $this->input->post('ohdPjtIsAcive'),
        ];
        if (!$this->Projectteam_model->FSbMPJTCheckDuplicate($aData)) {
            http_response_code(400);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'ข้อมูลซ้ำ'
            ]);
            exit;
        }

        $aResult = $this->Projectteam_model->FSaMPJTInsertData($aData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'บันทึกข้อมูลสำเร็จ',
                // 'raData' => $aData
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $aResult['rtDesc']
            ]);
        }
        exit;
    }

    /**
     * Functionality : Edit Project Team
     * Parameters : encoded PrjCode : Primary Key of Project Team
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : view wProjectteamForm.php
     * Return Type : text/html
     */
    public function FStCPJTPageEdit($tEncodedPrjCode)
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $tDecodedKey = base64_decode(urldecode($tEncodedPrjCode));
        list($ptPrjCode, $ptDevCode, $ptPrjRelease) = explode('|', $tDecodedKey);
        // ดึงข้อมูลจาก Model ตาม Primary Key
        $aParm = [
            'tPrjCode' => urldecode($ptPrjCode),
            'tDevCode' => urldecode($ptDevCode),
            'tPrjRelease' => urldecode($ptPrjRelease)
        ];
        $aData = $this->Projectteam_model->FSaMPJTGetDataByPrimaryKey($aParm);
        // ดึงข้อมูลที่จำเป็นสำหรับ Form แก้ไข
        $tDashboardURL = $this->Center_model->GetDashboardURL();
        $aProjectList = $this->Projectteam_model->FSaMPJTGetProjectList($tUsrEmail);
        $aReleaseList = $this->Projectteam_model->FSaMPJTGetReleaseListAll();
        $aDevList = $this->Projectteam_model->FSaMPJTGetDevTeamAll();

        $aParm = [
            'tDashboardURL' => $tDashboardURL,
            'aProjectList' => $aProjectList['raItems'] ?? [],
            'aReleaseList' => $aReleaseList['raItems'] ?? [],
            'aDevList' => $aDevList['raItems'] ?? [],
            'aData' => $aData,
            'tTitle' => $this->lang->line('tTitle'),
            'tAction' => base_url('index.php/masPJTEventEdit')
        ];

        $this->load->view('projectteam/wProjectteamForm', $aParm);
    }

    /**
     * Functionality : Edit Project Team
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : array status 
     * Return Type : string
     */
    public function FStCPJTEventEditData()
    {
        $tStartDate = $this->input->post('odpPjtStartDate');
        $tEndDate = $this->input->post('odpPjtEndDate');

        $dStartDate = !empty($tStartDate) ? DateTime::createFromFormat('d/m/Y', $tStartDate)->format('Y-m-d') : null;
        $dEndDate = !empty($tEndDate) ? DateTime::createFromFormat('d/m/Y', $tEndDate)->format('Y-m-d') : null;

        $aData = [
            'FTPrjCode' => $this->input->post('ohdPjtCode'),
            'FTPrjRelease' => $this->input->post('ohdPjtRelease'),
            'FTDevCode' => $this->input->post('ohdPjtDev'),
            'FDPrjPlanStart' => $dStartDate,
            'FDPrjActualStart' => $dStartDate,
            'FDPrjPlanFinish' => $dEndDate,
            'FDPrjActualFinish' => $dEndDate,
            'FTDepCode' => $this->input->post('ohdPjtDepCode'),
            'FTPrjStaActive' => $this->input->post('ohdPjtIsAcive'),
        ];

        $aResult = $this->Projectteam_model->FSaMPJTUpdateData($aData);
        if ($aResult) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'บันทึกข้อมูลสำเร็จ'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $aResult['rtDesc']
            ]);
        }
        exit;
    }

    /**
     * Functionality : Delete Project Team
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : array status 
     * Return Type : string
     */
    public function FStCPJTEventDeleteData()
    {
        $aData = [
            'tPrjCode' => urldecode($this->input->post('tPrjCode')),
            'tDevCode' => urldecode($this->input->post('tDevCode')),
            'tPrjRelease' => urldecode($this->input->post('tPrjRelease'))
        ];
        $aResult = $this->Projectteam_model->FSaMPJTDeleteData($aData);
        if ($aResult) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'ลบข้อมูลสำเร็จ'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล : ' . $aResult['rtDesc']
            ]);
        }
    }


    /**
     * Functionality : Filter Option for Project, Release, Developer, Team
     * Parameters : -
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : array data
     * Return Type : array
     **/
    public function FStCPJTEventFilterOption()
    {
        $tDevCode = $this->input->get('tDevCode');
        $tDevTeam = $this->input->get('tDevTeam');
        $tRelease = $this->input->get('tRelease');
        $tProjectCode = $this->input->get('tProjectCode');
        $tType = $this->input->get('tType');

        $aResult = [];

        switch ($tType) {
            case 'project':
                $aResult = $this->Projectteam_model->FSaMPJTGetOptionProjectList($tDevCode, $tDevTeam, $tRelease);
                break;
            case 'release':
                $aResult = $this->Projectteam_model->FSaMPJTGetOptionReleaseList($tDevCode, $tDevTeam, $tProjectCode);
                break;
            case 'developer':
                $aResult = $this->Projectteam_model->FSaMPJTGetOptionDeveloperList($tDevTeam, $tProjectCode, $tRelease);
                break;
            case 'team':
                $aResult = $this->Projectteam_model->FSaMPJTGetOptionTeamList($tDevCode, $tProjectCode, $tRelease);
                break;
        }

        http_response_code(200);
        echo json_encode([
            'rtStatus' => 'success',
            'rtData' => $aResult['raItems'] ?? []
        ]);
    }
}
