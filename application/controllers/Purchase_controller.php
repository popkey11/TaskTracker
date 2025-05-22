<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Purchase_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Center_model');
        $this->load->model('Purchase_model');
        $this->load->model('Project_model');
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
        if ($tStaAlwCreatPrj != '3' && $tStaAlwCreatPrj != '2' && $tStaAlwCreatPrj != '4') {
            redirect('/Task', 'refresh');
        }
    }

    /**
     * Functionality : View Po
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : view wPo.php
     * Return Type : text/html
     */
    public function FStCPODataListView()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $tDashboardURL = $this->Center_model->GetDashboardURL();
        $aProjectList = $this->Purchase_model->FSaMPOGetProjectAll($tUsrEmail);
        $aPoSelectYear = $this->Purchase_model->FSaMPOGetSelectPoYear();
        $aPoSelectFrom = $this->Purchase_model->FSaMPOGetSelectPoFrom();
        $aPoSelectTo = $this->Purchase_model->FSaMPOGetSelectPoTo();
        $aPoTeamDevList = $this->Purchase_model->FSaMPOGetTeamDevAll();
        $aPoSelectBD = $this->Purchase_model->FSaMPOGetSelectPoBD();

        $aParm = [
            'tDashboardURL' => $tDashboardURL,
            'aProjectList' => $aProjectList['raItems'],
            'aPoSelectYear' => $aPoSelectYear['raItems'],
            'aPoSelectFrom' => $aPoSelectFrom['raItems'],
            'aPoSelectTo' => $aPoSelectTo['raItems'],
            'aPoTeamDevList' => $aPoTeamDevList['raItems'],
            'aPoSelectBD' => $aPoSelectBD['raItems'],
            "tTitle" => $this->lang->line('tTitle')
        ];

        $this->load->view('po/wPo', $aParm);
    }

    /**
     * Functionality : Get Po List
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : view wPoList.php
     * Return Type : text/html
     */
    public function FStCPOGetPoList()
    {
        // รับค่าที่ส่งมาจาก AJAX
        $tPoSearch = $this->input->post('tPoSearch');
        $nPoSearchYear = $this->input->post('nPoSearchYear');
        $nPoSearchProject = $this->input->post('nPoSearchProject');
        $nPoSearchStatus = $this->input->post('nPoSearchStatus');
        $tPoSearchFrom = $this->input->post('tPoSearchFrom');
        $tPoSearchTo = $this->input->post('tPoSearchTo');
        $tPoSearchPm = $this->input->post('tPoSearchPm');
        $tPoSearchSa = $this->input->post('tPoSearchSa');
        $tPoSearchBD = $this->input->post('tPoSearchBD');
        $nPoSearchProgress = $this->input->post('nPoSearchProgress');

        $nPage = $this->input->post('nPage') ? $this->input->post('nPage') : 1;

        // ส่งค่าที่ได้รับมาเพื่อใช้กรองข้อมูล
        $aFilter = [
            'tPoSearch' => $tPoSearch,
            'nPoSearchYear' => $nPoSearchYear,
            'nPoSearchProject' => $nPoSearchProject,
            'nPoSearchStatus' => $nPoSearchStatus,
            'tPoSearchFrom' => $tPoSearchFrom,
            'tPoSearchTo' => $tPoSearchTo,
            'tPoSearchPm' => $tPoSearchPm,
            'tPoSearchSa' => $tPoSearchSa,
            'tPoSearchBD' => $tPoSearchBD,
            'nPoSearchProgress' => $nPoSearchProgress,
            'nPage' => $nPage,
            'nRecordsPerPage' => 50 // จำนวนรายการต่อหน้า
        ];

        // ส่งค่าที่ได้รับมาเพื่อใช้กรองข้อมูลและกำหนดการแบ่งหน้า
        $aPoList = $this->Purchase_model->FSaMPOGetPaginatedPoData($aFilter);
        $nTotalPoValue = $this->Purchase_model->FSaMPOGetTotalPoValue($aFilter);
        
        // คำนวณจำนวนข้อมูลทั้งหมดเพื่อใช้ในการแบ่งหน้า
        $nTotalRecord = $aPoList['rnTotalRecord'];
        $nTotalPages = ceil($nTotalRecord / $aFilter['nRecordsPerPage']);

        // ส่งข้อมูลไปยัง View
        $aData['aPoList'] = $aPoList['raItems'];
        $aData['nCurrentPage'] = $nPage;
        $aData['nTotalPages'] = $nTotalPages;
        $aData['nTotalRecord'] = $nTotalRecord;
        $aData['nTotalPoValue'] = $nTotalPoValue['raItems']??0;

        // dbug($aData['nTotalPoValue']);
        $this->load->view('po/wPoList', $aData);
    }

    /**
     * Functionality : Page Add Data
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : view wPoForm.php
     * Reurn Type : text/html
     */
    public function FStCPOPageAdd()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $aProjectList = $this->Purchase_model->FSaMPOGetProjectAll($tUsrEmail);
        $aTeamLeadList = $this->Purchase_model->FSaMPOGetTeamDevAll();
        $aPoSelectFrom = $this->Purchase_model->FSaMPOGetSelectPoFrom();
        $aPoSelectTo = $this->Purchase_model->FSaMPOGetSelectPoTo();

        $aParm = [
            'tActionTitle' => 'addPo',
            'aProjectList' => $aProjectList['raItems'],
            'aTeamLeadList' => $aTeamLeadList['raItems'],
            'aPoSelectFrom' => $aPoSelectFrom['raItems'],
            'aPoSelectTo' => $aPoSelectTo['raItems'],
            "tTitle" => $this->lang->line('tTitle'),
            "tAction" => site_url('docPOEventAdd')
        ];
        
        $this->load->view('po/wPoForm', $aParm);
    }

    /**
     * Functionality : Event Add Data
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : text  
     * Reurn Type : string
     */
    public function FStCPOEventAddData()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $nLastPoRunning = $this->Purchase_model->FStMPOLastCodeRunning();

        // ดึงข้อมูลจาก POST
        $aData = $this->FSaCPOGetDataFromPost();
        $aData['FTPoCode'] = $nLastPoRunning;
        $aData['FDPoCreateOn'] = date('Y-m-d H:i:s');
        $aData['FTPoCreateBy'] = $tUsrEmail;

        // ตรวจสอบการอัปโหลดไฟล์
        $tUploadPath = FCPATH . 'assets/Images/PO/';
        $aUploadResult = $this->FSaCPOUploadFile('oflPoFile', $tUploadPath);

        if ($aUploadResult['rtCode'] == 200) {
            $aData['FTPoFile'] = $aUploadResult['rtFilePath'];
        } elseif ($aUploadResult['rtCode'] == 500) {
            http_response_code(400);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => $aUploadResult['rtDesc']
            ]);
            return;
        } else {
            $aData['FTPoFile'] = '';
        }

        // ตรวจสอบข้อมูล
        $aResult = $this->Purchase_model->FSaMPOInsertData($aData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'บันทึกข้อมูลสำเร็จ',
                'raData' => $aData
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $aResult['rtDesc']
            ]);
        }
    }

    /**
     * Functionality : Page Edit Data
     * Parameters : PoCode
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 11/04/25 Wuttichai
     * Return : view wPoForm.php  
     * Return Type : text/html
     */
    public function FStCPOPageEdit($ptPoCode)
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $aPoData = $this->Purchase_model->FSaMPOGetDataByPoCode($ptPoCode); // ดึงข้อมูลใบสั่งซื้อที่ต้องการแก้ไข
        $aProjectList = $this->Purchase_model->FSaMPOGetProjectAll($tUsrEmail);
        $aTeamLeadList = $this->Purchase_model->FSaMPOGetTeamDevAll();
        $aPoSelectFrom = $this->Purchase_model->FSaMPOGetSelectPoFrom();
        $aPoSelectTo = $this->Purchase_model->FSaMPOGetSelectPoTo();
        $aPayData = $this->Purchase_model->FSaMPOGetPoCodeDataPay($aPoData['FTPoCode']);
        $aDocData = $this->Purchase_model->FSaMPOGetPoCodeDataDoc($aPoData['FTPoCode']);
        $aUrlData = $this->Purchase_model->FSaMPOGetPoCodeDataUrl($aPoData['FTPoCode']);
        $aTotalPatAmount = $this->Purchase_model->FSaMPOGetPatTotalAmount($ptPoCode);
        $aPaySelectNo = $this->Purchase_model->FSaMPOGetSelectPayNo($ptPoCode);

        $nSumPayAmount = 0;
        foreach($aPayData['raItems'] as $nKey => $aValue){
            $nSumPayAmount += $aValue['FCPayAmount']; //ปรับเป็น Query
            $aPatData = $this->Purchase_model->FSaMPOGetPayCodeDataPat($aValue['FTPayCode']);
            if(isset($aPatData['raItems']) && count($aPatData['raItems']) > 0){
                $aPayData['raItems'][$nKey]['PatData'] = $aPatData['raItems'];
            }else{
                $aPayData['raItems'][$nKey]['PatData'] = null;
            }
        }
        
        $aParm = [
            'tActionTitle' => 'editPo',
            'aPoData' => $aPoData,
            'aPayData' => $aPayData['raItems'],
            'aDocData' => $aDocData['raItems'],
            'aUrlData' => $aUrlData['raItems'],
            'aProjectList' => $aProjectList['raItems'],
            'aTeamLeadList' => $aTeamLeadList['raItems'],
            'aPoSelectFrom' => $aPoSelectFrom['raItems'],
            'aPoSelectTo' => $aPoSelectTo['raItems'],
            "tTitle" => $this->lang->line('tTitle'),
            "tAction" => site_url('docPOEventEdit'),
            'nPaySumAmount' => $nSumPayAmount,
            'aTotalPatAmount' => $aTotalPatAmount['raItems'],
            'aPaySelectNo' => $aPaySelectNo['raItems'],
        ];
        // dbug($aPayData['raItems']);
        $this->load->view('po/wPoForm', $aParm);
    }

    /**
     * Functionality : Event Edit Data
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : text
     * Return Type : string
     */
    public function FStCPOEventEditData()
    {
        $tPoCode = $this->input->post('ohdPoCode'); // รับรหัสใบสั่งซื้อที่ต้องการแก้ไข

        $aPoData = $this->FSaCPOGetDataFromPost();
        // ดึงข้อมูล PO ปัจจุบันเพื่อตรวจสอบไฟล์เก่า
        $aCurrentPoData = $this->Purchase_model->FSaMPOGetDataByPoCode($tPoCode); // ดึงข้อมูลใบสั่งซื้อโดยใช้รหัส PoCode

        if ($this->input->post('ohdPoDeleteFile') == "1") {
            // ลบไฟล์เดิมออกจากระบบ
            if (!empty($aCurrentPoData['FTPoFile']) && file_exists(FCPATH . $aCurrentPoData['FTPoFile'])) {
                unlink(FCPATH . $aCurrentPoData['FTPoFile']); // ลบไฟล์เก่า
            }
            $aPoData['FTPoFile'] = ''; // ตั้งค่าในฐานข้อมูลให้เป็นค่าว่าง
        }

        // ตรวจสอบการอัปโหลดไฟล์ใหม่
        $tUploadPath = FCPATH . 'assets/Images/PO/';
        $aUploadResult = $this->FSaCPOUploadFile('oflPoFile', $tUploadPath);

        if ($aUploadResult['rtCode'] == 200) {
            if (!empty($aCurrentPoData['FTPoFile']) && file_exists(FCPATH . $aCurrentPoData['FTPoFile'])) {
                unlink(FCPATH . $aCurrentPoData['FTPoFile']); // ลบไฟล์เก่า
            }
            $aPoData['FTPoFile'] = $aUploadResult['rtFilePath'];
        } elseif ($aUploadResult['rtCode'] == 500) {
            http_response_code(400);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => $aUploadResult['rtDesc'],
                'rtError' => $aUploadResult['rtError'] ?? ''
            ]);
            return;
        }

        // อัพเดตข้อมูลในฐานข้อมูล
        $aResult = $this->Purchase_model->FSaMPOUpdateData($tPoCode, $aPoData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'แก้ไขข้อมูลสำเร็จ'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
                'raData' => $aResult['rtDesc']
            ]);
        }
    }

    /**
     * Functionality : Event Delete Data
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOEventDeleteData()
    {
        $tPoCode = $this->input->post('tPoCode');
        if (isset($tPoCode) && $tPoCode != '') {
            $aResult = $this->Purchase_model->FSaMPODeleteData($tPoCode);
            if ($aResult['rtCode'] == 200) {
                http_response_code(200);
                echo json_encode([
                    'rtStatus' => 'success',
                    'rtMessage' => 'ลบข้อมูลสำเร็จ'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'rtStatus' => 'error',
                    'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล',
                    'raData' => $aResult['rtDesc']
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล'
            ]);
        }
    }


    /**
     * Functionality : Upload File
     * Parameters : $sInputName => input file, $sUploadPath => path upload
     * Creator : 15/11/2024 Sorawit
     * Last Modified : 
     * Return : path file 
     * ReturnType: array
     */
    private function FSaCPOUploadFile($sInputName, $sUploadPath)
    {
        if (!empty($_FILES[$sInputName]) && $_FILES[$sInputName]['name'] != '') {

            // ตรวจสอบว่าเป็นโฟลเดอร์หรือไม่ ถ้าไม่มีก็สร้างใหม่
            if (!is_dir($sUploadPath)) {
                if (!mkdir($sUploadPath, 0755, true)) {
                    return [
                        'rtCode' => 500,
                        'rtDesc' => 'ไม่สามารถสร้างโฟลเดอร์สำหรับการอัปโหลดได้ กรุณาติดต่อผู้ดูแลระบบ'
                    ];
                }
            }

            $fileSize = $_FILES[$sInputName]['size'];
            $fileType = $_FILES[$sInputName]['type'];

            // ตรวจสอบขนาดไฟล์ก่อนอัปโหลด (ไม่เกิน 5 MB และไม่ต่ำกว่า 100 ไบต์)
            if ($fileSize > 5 * 1024 * 1024) {
                return [
                    'rtCode' => 500,
                    'rtDesc' => 'ขนาดไฟล์เกินที่กำหนด (5 MB) กรุณาเลือกไฟล์และลองใหม่อีกครั้ง'
                ];
            }

            if ($fileSize < 100) { // ขนาดขั้นต่ำ 100 ไบต์
                return [
                    'rtCode' => 500,
                    'rtDesc' => 'ขนาดไฟล์ของคุณน้อยเกินไป (100 ไบต์) กรุณาเลือกไฟล์และลองใหม่อีกครั้ง'
                ];
            }

            // กำหนดการตั้งค่าการอัปโหลด
            $aConfig['upload_path'] = $sUploadPath;
            $aConfig['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|csv|ppt|pptx';
            $aConfig['max_size'] = 5120; // ขนาดสูงสุด 5MB (5120KB)
            $aConfig['file_name'] = 'po_attachment_' . date('YmdHis') . '_' . uniqid();
            $this->upload->initialize($aConfig);

            // เริ่มการอัปโหลดไฟล์
            if (!$this->upload->do_upload($sInputName)) {
                // ดึงข้อผิดพลาดจาก Upload Library
                $error = $this->upload->display_errors('', '');

                // ตรวจสอบข้อผิดพลาดและส่งข้อความที่ชัดเจนขึ้น
                if (strpos($error, 'The filetype you are attempting to upload is not allowed') !== false) {
                    $errorMsg = 'ชนิดไฟล์ไม่ถูกต้อง กรุณาอัปโหลดไฟล์ชนิด: gif, jpg, jpeg, png, pdf, doc, docx, xls, xlsx, csv, ppt, pptx';
                } elseif (strpos($error, 'The file you are attempting to upload is larger than the permitted size') !== false) {
                    $errorMsg = 'ขนาดไฟล์เกินที่กำหนด (5 MB) กรุณาเลือกไฟล์และลองใหม่อีกครั้ง';
                } else {
                    $errorMsg = 'ไฟล์เอกสารอัปโหลดไม่สำเร็จ: กรุณาตรวจสอบไฟล์เอกสารและอัปโหลดไฟล์ใหม่อีกครั้ง';
                }

                return [
                    'rtCode' => 500,
                    'rtDesc' => $errorMsg,
                    'rtError' => $error
                ];
            } else {
                $aDataFile = $this->upload->data();
                return [
                    'rtCode' => 200,
                    'rtDesc' => 'อัปโหลดไฟล์สำเร็จ',
                    'rtFilePath' => 'assets/Images/PO/' . $aDataFile['file_name']
                    // 'rtFilePath' => 'storage/PO/' . $aDataFile['file_name']
                ];
            }
        }

        return [
            'rtCode' => 204,
            'rtDesc' => 'ไม่มีไฟล์ที่ถูกอัปโหลด'
        ];
    }

    /**
     * Functionality : Get Params from POST
     * Parameters : -
     * Creator : 15/11/2024 Sorawit
     * Last Modified : 06/05/25 Wuttichai
     * Return : params from POST
     * ReturnType: array
     */
    private function FSaCPOGetDataFromPost()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        return [
            'FTPrjCode' => $this->input->post('ocmPoProject'),
            'FTPoRelease' => $this->input->post('oetPoRelease', FALSE),
            'FTPoPM' => $this->input->post('ocmPoPM'),
            'FTPoSA' => $this->input->post('ocmPoSA'),
            'FTPoBD' => $this->input->post('oetPoBD'),
            'FTPoDocNo' => $this->input->post('oetPoDocNo', FALSE),
            'FDPoDate' => DateTime::createFromFormat('d/m/Y', $this->input->post('odpPoDate'))->format('Y-m-d'),
            'FCPoValue' => str_replace(',', '', $this->input->post('onbPoValue')),
            'FDPoStartDate' => DateTime::createFromFormat('d/m/Y', $this->input->post('odpPoStartDate'))->format('Y-m-d'),
            'FDPoEndDate' => DateTime::createFromFormat('d/m/Y', $this->input->post('odpPoEndDate'))->format('Y-m-d'),
            'FNPoStatus' => $this->input->post('ocmPoStatus'),
            'FNPoProgress' => $this->input->post('onbPoProgress'),
            'FTPoDetails' => $this->input->post('otaPoDetails', FALSE),
            'FTPoNotes' => $this->input->post('otaPoNotes', FALSE),
            'FTPoRefDoc' => $this->input->post('oetPoRefDoc', FALSE),
            'FTPoRefURL' => $this->input->post('oetPoRefURL', FALSE),
            'FCPoMDDev' => round(floatval($this->input->post('onbPoMDDev')) ?? 0, 2),
            'FCPoMDTester' => round(floatval($this->input->post('onbPoMDTester')) ?? 0, 2),
            'FCPoMDSA' => round(floatval($this->input->post('onbPoMDSA')) ?? 0, 2),
            'FCPoMDPM' => round(floatval($this->input->post('onbPoMDPM')) ?? 0, 2),
            'FCPoMDInterface' => round(floatval($this->input->post('onbPoMDInterface')) ?? 0, 2),
            'FCPoMDTotal' => round(floatval($this->input->post('onbPoMDTotal')) ?? 0, 2),
            'FCPoMDWeb' => round(floatval($this->input->post('onbPoMDWeb')) ?? 0, 2),
            'FCPoMDCSharp' => round(floatval($this->input->post('onbPoMDCSharp')) ?? 0, 2),
            'FCPoMDAndroid' => round(floatval($this->input->post('onbPoMDAndroid')) ?? 0, 2),
            'FTPoFrom' => $this->input->post('ocmPoFrom'),
            'FTPoTo' => $this->input->post('ocmPoTo'),
            'FTPoQttNo' => $this->input->post('oetPoQttNo'),
            'FDPoQttDate' => $this->input->post('odpPoQttDate') != ''
                ? DateTime::createFromFormat('d/m/Y', $this->input->post('odpPoQttDate'))->format('Y-m-d')
                : null,
            'FTPoPayStatus' => $this->input->post('ocmPoPayStatus'),
            'FTPoPayTerm' => $this->input->post('otaPoPayTerm', FALSE),
            'FDPoUpdateOn' => date('Y-m-d H:i:s'),
            'FTPoUpdateBy' => $tUsrEmail,
            'FTPoPayType' => $this->input->post('ocmPoPayType'),
            'FCPoTotalPaid' => str_replace(',', '', $this->input->post('onbPoTotalPaid') ?? 0),
            'FCPoTotalRemain' => str_replace(',', '', $this->input->post('onbPoTotalRemain') ?? 0),
            'FTPoImplementer' => $this->input->post('oetPoImplementer'),
            'FNPoActiveStatus' => $this->input->post('ocmPoActiveStatus'),
        ];
    }

    public function FSxCPOEventExportExcel()
    {
        $tPoSearch = $this->input->post('tPoSearch');
        $nPoSearchYear = $this->input->post('nPoSearchYear');
        $nPoSearchProject = $this->input->post('nPoSearchProject');
        $nPoSearchStatus = $this->input->post('nPoSearchStatus');
        $tPoSearchFrom = $this->input->post('tPoSearchFrom');
        $tPoSearchTo = $this->input->post('tPoSearchTo');
        $tPoSearchPm = $this->input->post('tPoSearchPm');
        $tPoSearchSa = $this->input->post('tPoSearchSa');
        $nPoSearchProgress = $this->input->post('nPoSearchProgress');
        $nPage = $this->input->post('nPoPage') ? $this->input->post('nPoPage') : 1;

        $aFilter = [
            'tPoSearch' => $tPoSearch,
            'nPoSearchYear' => $nPoSearchYear,
            'nPoSearchProject' => $nPoSearchProject,
            'nPoSearchStatus' => $nPoSearchStatus,
            'tPoSearchFrom' => $tPoSearchFrom,
            'tPoSearchTo' => $tPoSearchTo,
            'tPoSearchPm' => $tPoSearchPm,
            'tPoSearchSa' => $tPoSearchSa,
            'nPoSearchProgress' => $nPoSearchProgress,
            'nPage' => $nPage,
            'nRecordsPerPage' => 9999
        ];

        $aPoList = $this->Purchase_model->FSaMPOGetPaginatedPoData($aFilter);

        $oSpreadsheet = new Spreadsheet();
        $oSheet = $oSpreadsheet->getActiveSheet();
        $aPoMapStatus = [
            3 => 'Requirement',
            1 => 'Analysys & Design',
            2 => 'Develop',
            4 => 'SIT',
            5 => 'UAT',
            6 => 'Imprement',
            7 => 'Golive',
            8 => 'Cancel',
            9 => 'Pre-Dev/Wait PO',
        ];
        // Add headers
        $oSheet->setCellValue('A1', 'รหัส');
        $oSheet->setCellValue('B1', 'ชื่อโครงการ');
        $oSheet->setCellValue('C1', 'Release');
        $oSheet->setCellValue('D1', 'เลขที่เอกสาร PO');
        $oSheet->setCellValue('E1', 'วันที่ PO');
        $oSheet->setCellValue('F1', 'From');
        $oSheet->setCellValue('G1', 'To');
        $oSheet->setCellValue('H1', 'มูลค่า PO');
        $oSheet->setCellValue('I1', 'Phase');
        $oSheet->setCellValue('J1', '% ความคืบหน้า');
        $oSheet->setCellValue('K1', 'PM');
        $oSheet->setCellValue('L1', 'SA');
        $oSheet->setCellValue('M1', 'BD');

        $nRow = 2;
        $nTotalPoValue = 0;
        foreach ($aPoList['raItems'] as $aRowPo) {
            $tPmName = $aRowPo['FTPoPMName'] ?? '';
            $tPmNickName = $aRowPo['FTPoPMNickName'] ?? '';
            $tPmName = $tPmName . ($tPmNickName ? " ($tPmNickName)" : '');
            $tPmName = $tPmName ?: '-';

            $tSaName = $aRowPo['FTPoSAName'] ?? '';
            $tSaNickName = $aRowPo['FTPoSANickName'] ?? '';
            $tSaName = $tSaName . ($tSaNickName ? " ($tSaNickName)" : '');
            $tSaName = $tSaName ?: '-';
            $oSheet->setCellValue('A' . $nRow, $aRowPo['FTPoCode']);
            $oSheet->setCellValue('B' . $nRow, $aRowPo['FTPrjName']);
            $oSheet->setCellValue('C' . $nRow, $aRowPo['FTPoRelease']);
            $oSheet->setCellValue('D' . $nRow, $aRowPo['FTPoDocNo']);
            $oSheet->setCellValue('E' . $nRow, date('d/m/Y', strtotime($aRowPo['FDPoDate'])));
            $oSheet->setCellValue('F' . $nRow, $aRowPo['FTPoFrom'] ?? '-');
            $oSheet->setCellValue('G' . $nRow, $aRowPo['FTPoTo'] ?? '-');
            $oSheet->setCellValue('H' . $nRow, number_format($aRowPo['FCPoValue'], 2));
            $oSheet->setCellValue('I' . $nRow, $aPoMapStatus[$aRowPo['FNPoStatus']]);
            $oSheet->setCellValue('J' . $nRow, $aRowPo['FNPoProgress'] . '%');
            $oSheet->setCellValue('K' . $nRow, $tPmName);
            $oSheet->setCellValue('L' . $nRow, $tSaName);
            $oSheet->setCellValue('M' . $nRow, !empty($aRowPo['FTPoBD']) ? $aRowPo['FTPoBD'] : '-');

            $nTotalPoValue += $aRowPo['FCPoValue'];
            $nRow++;
        }

        // เพิ่มผลรวมที่ด้านล่าง
        $oSheet->setCellValue('G' . $nRow, 'PO รวมทั้งหมด:');
        $oSheet->setCellValue('H' . $nRow, number_format($nTotalPoValue, 2)); // ผลรวมในคอลัมน์ H

        // กำหนดรูปแบบเซลล์สำหรับผลรวม (optional)
        $oSheet->getStyle('G' . $nRow . ':H' . $nRow)->getFont()->setBold(true);
        $oSheet->getStyle('H' . $nRow)->getNumberFormat()->setFormatCode('#,##0.00');

        // Continue with output
        $oWriter = new Xlsx($oSpreadsheet);
        $tFilename = 'PO_Export_' . date('YmdHis') . '.xlsx';

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $tFilename . '"');
        header('Cache-Control: max-age=0');

        // Save file to output
        $oWriter->save('php://output');
    }


    /**
     * Functionality : Event Add Pay Data
     * Parameters : -
     * Creator : 09/04/2025 Wutticha
     * Last Modified :
     * Return : text  
     * Reurn Type : string
     */
    public function FStCPOEventAddPayData(){
        $tUsrEmail = get_cookie('TaskEmail');
        $nLastPayRunning = $this->Purchase_model->FStMPOLastCodeRunningPay();

        // ดึงข้อมูลจาก POST
        $aData = $this->FSaCPOGetDataPayFromPost();
        $aData['FTPayCode'] = $nLastPayRunning;
        $aData['FDPayCreateAt'] = date('Y-m-d H:i:s');
        $aData['FTPayCreateBy'] = $tUsrEmail;

        // ตรวจสอบข้อมูล
        $aResult = $this->Purchase_model->FSaMPOInsertPayData($aData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'บันทึกข้อมูลสำเร็จ',
                'raData' => $aData
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $aResult['rtDesc']
            ]);
        }
    }

    /**
     * Functionality : Event Edit Pay Data
     * Parameters : -
     * Creator : 09/04/2025 Wutticha
     * Last Modified :
     * Return : text  
     * Reurn Type : string
     */
    public function FStCPOEventEditPayData(){
        $tPayCode = $this->input->post('ohdPayCodeEdit'); // รับรหัสใบสั่งซื้อที่ต้องการแก้ไข

        $aPayData = $this->FSaCPOGetDataPayFromPostEdit();
        
        // อัพเดตข้อมูลในฐานข้อมูล
        $aResult = $this->Purchase_model->FSaMPOUpdatePayData($tPayCode, $aPayData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'แก้ไขข้อมูลสำเร็จ'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
                'raData' => $aResult['rtDesc']
            ]);
        }
    }

    /**
     * Functionality : Get Params Pay from POST
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : -
     * Return : params Pay from POST
     * ReturnType: array
     */
    public function FSaCPOGetDataPayFromPost(){
        $tUsrEmail = get_cookie('TaskEmail');
        return [
            'FTPayPoCode' => $this->input->post('ohdPayPoCode'),
            'FNPayNo' => $this->input->post('onbPayPoNo'),
            'FTPayDesc' => $this->input->post('otaPayPoDesc'),
            'FCPayAmount' => $this->input->post('onbPayPoAmount'),
            'FDPayDueDate' => DateTime::createFromFormat('d/m/Y', $this->input->post('oetPayPoDueDate'))->format('Y-m-d'),
            'FTPayStatus' => $this->input->post('ocmPayPoStatus'),
            'FDPayUpdateAt' => date('Y-m-d H:i:s'),
            'FTPayUpdateBy' => $tUsrEmail,
            'FTPayName' => $this->input->post('oetPayName'),
        ];
    }

    /**
     * Functionality : Get Params Pay from POST Edit
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : -
     * Return : params Pay from POST
     * ReturnType: array
     */
    public function FSaCPOGetDataPayFromPostEdit(){
        $tUsrEmail = get_cookie('TaskEmail');
        return [
            'FNPayNo' => $this->input->post('onbPayPoNoEdit'),
            'FTPayDesc' => $this->input->post('otaPayPoDescEdit'),
            'FCPayAmount' => $this->input->post('onbPayPoAmountEdit'),
            'FDPayDueDate' => DateTime::createFromFormat('d/m/Y', $this->input->post('oetPayPoDueDateEdit'))->format('Y-m-d'),
            'FTPayStatus' => $this->input->post('ocmPayPoStatusEdit'),
            'FDPayUpdateAt' => date('Y-m-d H:i:s'),
            'FTPayUpdateBy' => $tUsrEmail,
            'FTPayName' => $this->input->post('oetPayNameEdit'),
        ];
    }

    /**
     * Functionality : Get Pay List
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : 
     * Return : view wPoPaymentList.php
     * Return Type : text/html
     */
    public function FStCPOGetPayList()
    {
        $ptPoCode = $this->input->post('tPayPoCode');
        $aPayList = $this->Purchase_model->FSaMPOGetPoCodeDataPay($ptPoCode);
        $aPoList = $this->Purchase_model->FSaMPOGetDataByPoCode($ptPoCode);
        $aDocData = $this->Purchase_model->FSaMPOGetPoCodeDataDoc($ptPoCode);

        $aListDoc = [];
        foreach($aDocData['raItems'] as $nKey => $aValue){
            $aListDoc[] = $aValue['FTPayCode'];
        }

        // ส่งข้อมูลไปยัง View
        $aData['aPayList'] = $aPayList['raItems'];
        $aData['aPoList'] = $aPoList;
        $aData['aListDoc'] = $aListDoc;
        
        $this->load->view('po/wPoPaymentList', $aData);
    }

    /**
     * Functionality : Get Data Pay
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * Return Type : text/html
     */
    public function FSaCPOGetDataPay(){
        $ptPayCode = $this->input->post('tPayCode');
        $aPayData = $this->Purchase_model->FSaMPOGetPayCodeDataPay($ptPayCode);
        $aPatData = $this->Purchase_model->FSaMPOGetPayCodeDataPat($aPayData['raItems']->FTPayCode);
        $nSumPayAmount = $this->Purchase_model->FSaMPOSumPayAmount($aPayData['raItems']->FTPayPoCode);
        $nSumPoAmount = $this->Purchase_model->FSaMPOSumPoAmount($aPayData['raItems']->FTPayPoCode);
        $nPatDataCount = count($aPatData['raItems']);

        $aData['aPayData'] = $aPayData['raItems'];
        $aData['nPatDataCount'] = $nPatDataCount;
        $aData['nSumPayAmount'] = $nSumPayAmount - $aPayData['raItems']->FCPayAmount;
        $aData['nSumPoAmount'] = $nSumPoAmount;
        // dbug($aData);
        http_response_code(200);
        echo json_encode($aData);
    }

    /**
     * Functionality : Get Pat List
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : 
     * Return : view wPoPaymentList.php
     * Return Type : text/html
     */
    public function FSaCPOGetDataPat(){
        $ptPayCode = $this->input->post('tPayCode');
        $oPayData = $this->Purchase_model->FSaMPOGetPayCodeDataPay($ptPayCode);
        $aPayData = $oPayData['raItems'];
        $aPatData = $this->Purchase_model->FSaMPOGetPayCodeDataPat($aPayData->FTPayCode);

        $nPatTotalAmount = 0;
        foreach($aPatData['raItems'] as $nKey => $aValue){
            $nPatTotalAmount += $aValue['FCPatAmount'];
        }
        $btnAction = $nPatTotalAmount >= $aPayData->FCPayAmount ? 'disabled' : '';

        // สร้างปุ่มบันทึกการชำระเงิน
        $btn = '<button type="button" class="btn btn-primary" onclick="JSxPOModalAddPat('
                    . '\'' . addslashes($aPayData->FTPayCode) . '\', '
                    . $aPayData->FNPayNo . ', '
                    . '\'' . addslashes($aPayData->FTPayName) . '\', '
                    . $aPayData->FCPayAmount . ', '
                    . '\'' . $aPayData->FDPayDueDate . '\''
                    . ')" '. $btnAction .'>+เพิ่มข้อมูลการชำระ</button>';

        $aData['aPatList'] = $aPatData['raItems'];
        $aData['btn'] = $btn;
        $aData['aPayData'] = $aPayData;

        // dbug($aData);
        $this->load->view('po/wPoPatList', $aData);
    }

    public function FSaCPOGetDataPatEdit(){
        $ptPatCode = $this->input->post('tPatCode');
        $aPatData = $this->Purchase_model->FSaMPOGetPatCodeData($ptPatCode);
        $nSumPatAmount = $this->Purchase_model->FSnMPOSumPatAmount($aPatData['raItems']->FTPatPayCode);

        // สร้างปุ่มโหลดไฟล์
        $link = '<a href="' . base_url($aPatData['raItems']->FTPatFile) . '" target="_blank">
            <i class="fa fa-file"></i> ' . basename($aPatData['raItems']->FTPatFile) . '
        </a>';

        $aData['aPatData'] = $aPatData['raItems'];
        $aData['nSumPatAmount'] = $nSumPatAmount;
        $aData['link'] = $link;
        http_response_code(200);
        echo json_encode($aData);
    }

    /**
     * Functionality : Event Add Pat Data
     * Parameters : -
     * Creator : 09/04/2025 Wutticha
     * Last Modified :
     * Return : text  
     * Reurn Type : string
     */
    public function FStCPOEventAddPatData(){
        $tUsrEmail = get_cookie('TaskEmail');
        $nLastPatRunning = $this->Purchase_model->FStMPOLastCodeRunningPat();

        // ดึงข้อมูลจาก POST
        $aData = $this->FSaCPOGetDataPatFromPost();
        $aData['FTPatCode'] = $nLastPatRunning;
        $aData['FDPatCreateAt'] = date('Y-m-d H:i:s');
        $aData['FTPatCreateBy'] = $tUsrEmail;

        // ตรวจสอบการอัปโหลดไฟล์
        $tUploadPath = FCPATH . 'assets/Images/PO/';
        $aUploadResult = $this->FSaCPOUploadFile('oflPatFile', $tUploadPath);

        if ($aUploadResult['rtCode'] == 200) {
            $aData['FTPatFile'] = $aUploadResult['rtFilePath'];
        } elseif ($aUploadResult['rtCode'] == 500) {
            http_response_code(400);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => $aUploadResult['rtDesc']
            ]);
            return;
        } else {
            $aData['FTPatFile'] = '';
        }

        // ตรวจสอบข้อมูล
        $aResult = $this->Purchase_model->FSaMPOInsertPatData($aData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'บันทึกข้อมูลสำเร็จ',
                'raData' => $aData
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $aResult['rtDesc']
            ]);
        }
    }

    /**
     * Functionality : Get Params Pat from POST
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : -
     * Return : params Pat from POST
     * ReturnType: array
     */
    public function FSaCPOGetDataPatFromPost(){
        $tUsrEmail = get_cookie('TaskEmail');
        return [
            'FTPatPayCode' => $this->input->post('ohdPatPayCode'),
            'FDPatDate' => DateTime::createFromFormat('d/m/Y', $this->input->post('oetPatDate'))->format('Y-m-d'),
            'FCPatAmount' => $this->input->post('onbPatAmount'),
            'FTPatPaymethod' => $this->input->post('ocmPatPyMethod'),
            'FTPatRefNo' => $this->input->post('oetPatRefNo'),
            'FTPatDesc' => $this->input->post('otaPatDesc'),
            'FDPatUpdateAt' => date('Y-m-d H:i:s'),
            'FTPatUpdateBy' => $tUsrEmail,
        ];
    }

    public function FStCPOEventEditManday(){
        $tPoCode = $this->input->post('ohdPoCodeMD');
        $aData = [
            'FCPoMDDev' => $this->input->post('onbPoMDDev'),
            'FCPoMDTester' => $this->input->post('onbPoMDTester'),
            'FCPoMDSA' => $this->input->post('onbPoMDSA'),
            'FCPoMDPM' => $this->input->post('onbPoMDPM'),
            'FCPoMDInterface' => $this->input->post('onbPoMDInterface'),
            'FCPoMDTotal' => $this->input->post('onbPoMDTotal'),
            'FCPoMDWeb' => $this->input->post('onbPoMDWeb'),
            'FCPoMDCSharp' => $this->input->post('onbPoMDCSharp'),
            'FCPoMDAndroid' => $this->input->post('onbPoMDAndroid'),
        ];

        $aResult = $this->Purchase_model->FSaMPOUpdateData($tPoCode, $aData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'แก้ไขข้อมูลสำเร็จ'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
                'raData' => $aResult['rtDesc']
            ]);
        }
    }

    /**
     * Functionality : Event Add Data Doc
     * Parameters : -
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOEventAddDocData(){
        $tUsrEmail = get_cookie('TaskEmail');

        $aData = [
            'FTPoCode' => $this->input->post('ohdDocPoCode'),
            'FTPoDocType' => $this->input->post('ocmPoDocType'),
            'FTPoDocDesc' => $this->input->post('otaPoDocDesc'),
            'FDPoDocCreateAt' => date('Y-m-d H:i:s'),
            'FTPoDocCreateBy' => $tUsrEmail,
            'FDPoDocUpdateAt' => date('Y-m-d H:i:s'),
            'FTPoDocUpdateBy' => $tUsrEmail,
            'FTPayCode' => $this->input->post('ocmDocPayCode'),
        ];

        // ตรวจสอบการอัปโหลดไฟล์
        $tUploadPath = FCPATH . 'assets/Images/PO/';
        $aUploadResult = $this->FSaCPOUploadFileOrgName('oflPoDocFile', $tUploadPath);

        if ($aUploadResult['rtCode'] == 200) {
            $aData['FTPoDocFile'] = $aUploadResult['rtFilePath'];
            $aData['FTPoDocName'] = $aUploadResult['rtFileName'];
        } elseif ($aUploadResult['rtCode'] == 500) {
            http_response_code(400);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => $aUploadResult['rtDesc']
            ]);
            return;
        } else {
            $aData['FTPoDocFile'] = '';
            $aData['FTPoDocName'] = '';
        }

        // ตรวจสอบข้อมูล
        $aResult = $this->Purchase_model->FSaMPOInsertDocData($aData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'บันทึกข้อมูลสำเร็จ',
                'raData' => $aData
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $aResult['rtDesc']
            ]);
        }

    }

    /**
     * Functionality : Upload File Orignal Name
     * Parameters : $sInputName => input file, $sUploadPath => path upload
     * Creator : 21/04/2025 Wuttichai
     * Last Modified : 
     * Return : path file 
     * ReturnType: array
     */
    private function FSaCPOUploadFileOrgName($sInputName, $sUploadPath)
    {
        if (!empty($_FILES[$sInputName]) && $_FILES[$sInputName]['name'] != '') {

            // ตรวจสอบว่าเป็นโฟลเดอร์หรือไม่ ถ้าไม่มีก็สร้างใหม่
            if (!is_dir($sUploadPath)) {
                if (!mkdir($sUploadPath, 0755, true)) {
                    return [
                        'rtCode' => 500,
                        'rtDesc' => 'ไม่สามารถสร้างโฟลเดอร์สำหรับการอัปโหลดได้ กรุณาติดต่อผู้ดูแลระบบ'
                    ];
                }
            }

            $fileSize = $_FILES[$sInputName]['size'];
            $fileType = $_FILES[$sInputName]['type'];

            // ตรวจสอบขนาดไฟล์ก่อนอัปโหลด (ไม่เกิน 5 MB และไม่ต่ำกว่า 100 ไบต์)
            if ($fileSize > 5 * 1024 * 1024) {
                return [
                    'rtCode' => 500,
                    'rtDesc' => 'ขนาดไฟล์เกินที่กำหนด (5 MB) กรุณาเลือกไฟล์และลองใหม่อีกครั้ง'
                ];
            }

            if ($fileSize < 100) { // ขนาดขั้นต่ำ 100 ไบต์
                return [
                    'rtCode' => 500,
                    'rtDesc' => 'ขนาดไฟล์ของคุณน้อยเกินไป (100 ไบต์) กรุณาเลือกไฟล์และลองใหม่อีกครั้ง'
                ];
            }

            // ชื่อไฟล์ที่อัพโหลด
            $OriginalFileName = pathinfo($_FILES[$sInputName]['name'], PATHINFO_FILENAME);

            // กำหนดการตั้งค่าการอัปโหลด
            $aConfig['upload_path'] = $sUploadPath;
            $aConfig['allowed_types'] = 'gif|jpg|jpeg|png|pdf|doc|docx|xls|xlsx|csv|ppt|pptx';
            $aConfig['max_size'] = 5120; // ขนาดสูงสุด 5MB (5120KB)
            $aConfig['file_name'] = $OriginalFileName . '_' . date('YmdHis');
            
            $this->upload->initialize($aConfig);

            // ปรับการตรวจสอบความถูกต้องก่อนอัพโหลด **

            // เริ่มการอัปโหลดไฟล์
            if (!$this->upload->do_upload($sInputName)) {
                // ดึงข้อผิดพลาดจาก Upload Library
                $error = $this->upload->display_errors('', '');

                // ตรวจสอบข้อผิดพลาดและส่งข้อความที่ชัดเจนขึ้น
                if (strpos($error, 'The filetype you are attempting to upload is not allowed') !== false) {
                    $errorMsg = 'ชนิดไฟล์ไม่ถูกต้อง กรุณาอัปโหลดไฟล์ชนิด: gif, jpg, jpeg, png, pdf, doc, docx, xls, xlsx, csv, ppt, pptx';
                } elseif (strpos($error, 'The file you are attempting to upload is larger than the permitted size') !== false) {
                    $errorMsg = 'ขนาดไฟล์เกินที่กำหนด (5 MB) กรุณาเลือกไฟล์และลองใหม่อีกครั้ง';
                } else {
                    $errorMsg = 'ไฟล์เอกสารอัปโหลดไม่สำเร็จ: กรุณาตรวจสอบไฟล์เอกสารและอัปโหลดไฟล์ใหม่อีกครั้ง';
                }

                return [
                    'rtCode' => 500,
                    'rtDesc' => $errorMsg,
                    'rtError' => $error
                ];
            } else {
                $aDataFile = $this->upload->data();
                return [
                    'rtCode' => 200,
                    'rtDesc' => 'อัปโหลดไฟล์สำเร็จ',
                    'rtFilePath' => 'assets/Images/PO/' . $aDataFile['file_name'],
                    'rtFileName' => $aConfig['file_name']
                ];
            }
        }

        return [
            'rtCode' => 204,
            'rtDesc' => 'ไม่มีไฟล์ที่ถูกอัปโหลด'
        ];
    }

    /**
     * Functionality : Event Add Data Url
     * Parameters : -
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOEventAddUrlData(){
        $tUsrEmail = get_cookie('TaskEmail');

        $aData = [
            'FTPoCode' => $this->input->post('ohdUrlPoCode'),
            'FTPoUrlAddress' => $this->input->post('oetPoUrlAddress'),
            'FTPoUrlDesc' => $this->input->post('otaPoUrlDesc'),
            'FDPoUrlCreateAt' => date('Y-m-d H:i:s'),
            'FTPoUrlCreateBy' => $tUsrEmail,
            'FDPoUrlUpdateAt' => date('Y-m-d H:i:s'),
            'FTPoUrlUpdateBy' => $tUsrEmail,
        ];

        // ตรวจสอบข้อมูล
        $aResult = $this->Purchase_model->FSaMPOInsertUrlData($aData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'บันทึกข้อมูลสำเร็จ',
                'raData' => $aData
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการบันทึกข้อมูล: ' . $aResult['rtDesc']
            ]);
        }

    }

    /**
     * Functionality : Event Delete Data Doc
     * Parameters : -
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOEventDeleteDataDoc()
    {
        $tDocID = $this->input->post('tDocID');
        if (isset($tDocID) && $tDocID != '') {
            $aResult = $this->Purchase_model->FSaMPODeleteDataDoc($tDocID);
            if ($aResult['rtCode'] == 200) {
                http_response_code(200);
                echo json_encode([
                    'rtStatus' => 'success',
                    'rtMessage' => 'ลบข้อมูลสำเร็จ'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'rtStatus' => 'error',
                    'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล',
                    'raData' => $aResult['rtDesc']
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล'
            ]);
        }
    }

    /**
     * Functionality : Event Delete Data Url
     * Parameters : -
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOEventDeleteDataUrl()
    {
        $tUrlID = $this->input->post('tUrlID');
        if (isset($tUrlID) && $tUrlID != '') {
            $aResult = $this->Purchase_model->FSaMPODeleteDataUrl($tUrlID);
            if ($aResult['rtCode'] == 200) {
                http_response_code(200);
                echo json_encode([
                    'rtStatus' => 'success',
                    'rtMessage' => 'ลบข้อมูลสำเร็จ'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'rtStatus' => 'error',
                    'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล',
                    'raData' => $aResult['rtDesc']
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล'
            ]);
        }
    }

    /**
     * Functionality : Event Delete Data Url
     * Parameters : -
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOEventDeleteDataPay()
    {
        $tPayCode = $this->input->post('tPayCode');
        // dbug($tPayCode);
        if (isset($tPayCode) && $tPayCode != '') {
            $aResult = $this->Purchase_model->FSaMPODeleteDataPay($tPayCode);
            if ($aResult['rtCode'] == 200) {
                http_response_code(200);
                echo json_encode([
                    'rtStatus' => 'success',
                    'rtMessage' => 'ลบข้อมูลสำเร็จ'
                ]);
            } else {
                http_response_code(500);
                echo json_encode([
                    'rtStatus' => 'error',
                    'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล',
                    'raData' => $aResult['rtDesc']
                ]);
            }
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการลบข้อมูล'
            ]);
        }
    }

    /**
     * Functionality : Edit Data Pat
     * Parameters : -
     * Creator : 25/04/2025 Wuttichai
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOEventEditPatData(){
        $tUsrEmail = get_cookie('TaskEmail');
        $tPatCode = $this->input->post('ohdPatCodeEdit');

        $aPatData = [
            'FDPatDate' => DateTime::createFromFormat('d/m/Y', $this->input->post('oetPatDateEdit'))->format('Y-m-d'),
            'FCPatAmount' => $this->input->post('onbPatAmountEdit'),
            'FTPatPaymethod' => $this->input->post('ocmPatPyMethodEdit'),
            'FTPatRefNo' => $this->input->post('oetPatRefNoEdit'),
            'FTPatDesc' => $this->input->post('otaPatDescEdit'),
            'FDPatUpdateAt' => date('Y-m-d H:i:s'),
            'FTPatUpdateBy' => $tUsrEmail,
        ];
        // ดึงข้อมูล PO ปัจจุบันเพื่อตรวจสอบไฟล์เก่า
        $aCurrentPatData = $this->Purchase_model->FSaMPOGetPatCodeData($tPatCode); // ดึงข้อมูลใบสั่งซื้อโดยใช้รหัส PoCode
        $oCurrentPatData = $aCurrentPatData['raItems'];

        if ($this->input->post('ohdPoDeleteFile') == "1") {
            // ลบไฟล์เดิมออกจากระบบ
            if (!empty($oCurrentPatData->FTPatFile) && file_exists(FCPATH . $oCurrentPatData->FTPatFile)) {
                unlink(FCPATH . $oCurrentPatData->FTPatFile); // ลบไฟล์เก่า
            }
            $aPatData['FTPatFile'] = ''; // ตั้งค่าในฐานข้อมูลให้เป็นค่าว่าง
        }

        // ตรวจสอบการอัปโหลดไฟล์ใหม่
        $tUploadPath = FCPATH . 'assets/Images/PO/';
        $aUploadResult = $this->FSaCPOUploadFile('oflPatFileEdit', $tUploadPath);

        if ($aUploadResult['rtCode'] == 200) {
            if (!empty($oCurrentPatData->FTPatFile) && file_exists(FCPATH . $oCurrentPatData->FTPatFile)) {
                unlink(FCPATH . $oCurrentPatData->FTPatFile); // ลบไฟล์เก่า
            }
            $aPatData['FTPatFile'] = $aUploadResult['rtFilePath'];
        } elseif ($aUploadResult['rtCode'] == 500) {
            http_response_code(400);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => $aUploadResult['rtDesc'],
                'rtError' => $aUploadResult['rtError'] ?? ''
            ]);
            return;
        }

        // อัพเดตข้อมูลในฐานข้อมูล
        $aResult = $this->Purchase_model->FSaMPOUpdateDataPat($tPatCode, $aPatData);
        if ($aResult['rtCode'] == 200) {
            http_response_code(200);
            echo json_encode([
                'rtStatus' => 'success',
                'rtMessage' => 'แก้ไขข้อมูลสำเร็จ'
            ]);
        } else {
            http_response_code(500);
            echo json_encode([
                'rtStatus' => 'error',
                'rtMessage' => 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
                'raData' => $aResult['rtDesc']
            ]);
        }
    }

    /**
     * Functionality : Generate ID Sequential
     * Parameters : -
     * Creator : 25/04/2025 Wuttichai
     * Last Modified :
     * Return : text
     * ReturnType: string
     */
    public function FStCPOGetLastPayNo(){
        $tPoCode = $this->input->post('tPoCode');

        $aResult = $this->Purchase_model->FSaMPOLastNoRunningPay($tPoCode);
        $nSumPayAmount = $this->Purchase_model->FSaMPOSumPayAmount($tPoCode);

        $aData['aPayNo'] = $aResult;
        $aData['nSumPayAmount'] = $nSumPayAmount;
        // dbug($aData);
        http_response_code(200);
        echo json_encode($aData);
    }
}
