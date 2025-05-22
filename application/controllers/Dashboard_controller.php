<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH . '/libraries/spout-3.3.0/src/Spout/Autoloader/autoload.php';

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

class Dashboard_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Purchase_model');
        $this->load->model('Dashboard_model');

        if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE) {
            echo "ERROR XSS Filter";
        }
    }

    public function FSaCDBDataPO(){
        $aPoSelectFrom = $this->Purchase_model->FSaMPOGetSelectPoFrom();
        $aPoSelectTo = $this->Purchase_model->FSaMPOGetSelectPoTo();
        $aPoSelectDate = $this->Dashboard_model->FSaMDBGetSelectPoDate();

        $aData = [
            'tTitle' => 'Dashboard',
            'aPoSelectFrom' => $aPoSelectFrom['raItems'],
            'aPoSelectTo' => $aPoSelectTo['raItems'],
            'aPoSelectDate' => $aPoSelectDate['raItems'],
        ];
        $this->load->view('dashboard/wDBPo',$aData);
    }

    /**
     * Functionality : Get Dashboard List
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : view wPoList.php
     * Return Type : text/html
     */
    public function FSaCDBGetListDBPo()
    {
        // รับค่าที่ส่งมาจาก AJAX
        $aDBSearchCustomer = $this->input->post('aDBSearchCustomer');
        $aDBSearchTo = $this->input->post('aDBSearchTo');
        $aDBOptionStatus = $this->input->post('aDBOptionStatus');
        $dDBSearchFromDate = DateTime::createFromFormat('d/m/Y', $this->input->post('dDBSearchFromDate'))->format('Y-m-d');
        $dDBSearchToDate = DateTime::createFromFormat('d/m/Y', $this->input->post('dDBSearchToDate'))->format('Y-m-d');

        $nPage = $this->input->post('nPage') ? $this->input->post('nPage') : 1;
        $nPageTrack = $this->input->post('nPageTrack') ? $this->input->post('nPageTrack') : 1;
        
        // ส่งค่าที่ได้รับมาเพื่อใช้กรองข้อมูล
        $aFilter = [
            'aDBSearchCustomer' => $aDBSearchCustomer,
            'aDBSearchTo' => $aDBSearchTo,
            'aDBOptionStatus' => $aDBOptionStatus,
            'dDBSearchFromDate' => $dDBSearchFromDate,
            'dDBSearchToDate' => $dDBSearchToDate,
            'nPage' => $nPage,
            'nPageTrack' => $nPageTrack,
            'nRecordsPerPage' => 10, // จำนวนรายการต่อหน้า
            'nRecordsPerPageTracking' => 5 // จำนวนรายการต่อหน้า
        ];

        $this->session->set_userdata('filter_data', $aFilter);
        // dbug($aFilter);

        // ส่งค่าที่ได้รับมาเพื่อใช้กรองข้อมูลและกำหนดการแบ่งหน้า
        $aDBPoList = $this->Dashboard_model->FSaMDBGetPaginatedPoData($aFilter);
        $aDBPotrackingList = $this->Dashboard_model->FSaMDBGetPaginatedPoTrackingData($aFilter);

        // คำนวณจำนวนข้อมูลทั้งหมดเพื่อใช้ในการแบ่งหน้า
        $nTotalRecord = $aDBPoList['rnTotalRecord'];
        $nTotalPages = ceil($nTotalRecord / $aFilter['nRecordsPerPage']);

        $nTotalRecordPotracking = $aDBPotrackingList['rnTotalRecord'];
        $nTotalPagesPotracking = ceil($nTotalRecordPotracking / $aFilter['nRecordsPerPageTracking']);

        $aAllTotalPo = $this->Dashboard_model->FSaMExecStoreGetPaymentSummary($aFilter);
        $nTotalPoValue = $aAllTotalPo[0]['TotalAmount'];
        $nTotalPoPaid = $aAllTotalPo[1]['PaidAmount'];
        $nTotalPay = $this->Dashboard_model->FSnMDBGetTotalPay($aFilter);
        $nTotalPoUnPaid = $aAllTotalPo[2]['OutstandingAmount'];
        $nTotalPendingPay = $aAllTotalPo[3]['OutstandingAmount'];
        $aTotalPoStatus = $this->Dashboard_model->FSnMDBGetCountPoStatus($aFilter);
        
        // ส่งข้อมูลไปยัง View
        $aData['aDBPoList'] = $aDBPoList['raItems'];
        $aData['aDBPotrackingList'] = $aDBPotrackingList['raItems'];
        $aData['nCurrentPage'] = $nPage;
        $aData['nCurrentPageTrack'] = $nPageTrack;
        $aData['nTotalPages'] = $nTotalPages;
        $aData['nTotalRecord'] = $nTotalRecord;
        $aData['nTotalPagesPotracking'] = $nTotalPagesPotracking;
        $aData['nTotalRecordPotracking'] = $nTotalRecordPotracking;
        $aData['nTotalPoValue'] = $this->FSnCDBFormatShortNumber($nTotalPoValue);
        $aData['nTotalPoPaid'] = $this->FSnCDBFormatShortNumber($nTotalPoPaid);
        $aData['nTotalPoUnPaid'] = $this->FSnCDBFormatShortNumber($nTotalPoUnPaid);
        $aData['nTotalPendingPay'] = $this->FSnCDBFormatShortNumber($nTotalPendingPay);
        $aData['aTotalPoStatus'] = $aTotalPoStatus['raItems'];

        $this->load->view('dashboard/wDBPoList', $aData);
    }

    /**
     * Functionality : Get Dashboard List
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : view wPoList.php
     * Return Type : text/html
     */
    public function FSnCDBFormatShortNumber($pnNum){
        if ($pnNum >= 1000000000000) {
            $nFomat = round($pnNum / 1000000000000, 1) . 'T';
        } elseif ($pnNum >= 1000000000) {
            $nFomat = round($pnNum / 1000000000, 1) . 'B';
        } elseif ($pnNum >= 1000000) {
            $nFomat = round($pnNum / 1000000, 1) . 'M';
        } elseif ($pnNum >= 1000) {
            $nFomat = round($pnNum / 1000, 1) . 'K';
        } else {
            $nFomat = $pnNum;
        }

        return [
            'nFomat' => $nFomat,
            'nNum' => $pnNum
        ];
    }

    public function FSxCDBExportExcelPrjUrgent(){
        $aFilter = $this->session->userdata('filter_data');

        $aDataPrjUrgent = $this->Dashboard_model->FSaMDBGetDataProjectUrgent($aFilter);
        // dbug($aFilter);

        $writer = WriterEntityFactory::createXLSXWriter(); // สกุลไฟล์เป็น xlsx
        // $writer = WriterEntityFactory::createODSWriter(); // สกุลไฟล์เป็น ods
        // $writer = WriterEntityFactory::createCSVWriter(); // สกุลไฟล์เป็น csv

        $tFilename = 'Prj_urgent_'. date('YmdHis') . '.xlsx';
        $writer->openToBrowser($tFilename);

        // Header
        $rowFromValues = WriterEntityFactory::createRowFromArray(['ชื่อโครงการ', 'Release', 'Phase', 'สถานะ', 'ความคืบหน้า', 'กำหนดเสร็จ']);
        $writer->addRow($rowFromValues);

        $aPoStatusList = [
            3 => 'Requirement',
            1 => 'Analysys & Design',
            2 => 'Develop',
            4 => 'SIT',
            5 => 'UAT',
            6 => 'Imprement',
            7 => 'Golive',
            8 => 'Cancel',
            9 => 'Pre-Dev/Wait PO'
        ];

        $dToday = new DateTime();
        // Content
        foreach($aDataPrjUrgent['raItems'] as $nKey => $aVal){
            $dDueDate = new DateTime($aVal['FDPoEndDate']);
            $nInterval = (int)$dToday->diff($dDueDate)->format("%r%a");
            if($nInterval < 0){
                $tStatus = 'เลยกำหนดการ';
            }else{
                $tStatus = 'ใกล้ถึงกำหนดการ';
            }

            $writer->addRow(WriterEntityFactory::createRowFromArray([
                $aVal['FTPrjName'], //ชื่อโครงการ
                $aVal['FTPoRelease'], //Release
                $aPoStatusList[$aVal['FNPoStatus']], //Phase
                $tStatus, //สถานะ
                $aVal['FNPoProgress'].'%', //ความคืบหน้า
                date('d/m/Y', strtotime($aVal['FDPoEndDate'])) //กำหนดเสร็จ
            ]));
        }

        $writer->close();
        exit;
    }
}