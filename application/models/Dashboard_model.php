<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard_model extends CI_Model
{
    protected $tTable = 'TTSTProjectPo';
    protected $tTablePayment = 'TTSTPaymentPo';
    protected $tTablePaymentTrans = 'TTSTPaymentTrans';
    protected $tTableProject = 'TTSMProject';
    protected $tTableDevTeam = 'TTSDevTeam';

    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }

    /**
     * Functionality : Get Data Po
     * Parameters : Filter
     * Creator : 25/05/2025 Wuttichai
     * Last Modified : 
     * Return : Number of records
     * ReturnType: number
     */
    public function FSaMDBGetPaginatedPoData($paFilter){
        $nPage = isset($paFilter['nPage']) ? $paFilter['nPage'] : 1;
        $nRecordsPerPage = isset($paFilter['nRecordsPerPage']) ? $paFilter['nRecordsPerPage'] : 50;

        // คำนวณตำแหน่งเริ่มต้นและสิ้นสุดของข้อมูลในแต่ละหน้า
        $nRowStart = ($nPage - 1) * $nRecordsPerPage;

        $this->db->select([
            'po.FTPoCode', //รหัสโครงการ
            'po.FTPoRelease', //release
            'po.FTPoQttNo', //เลขที่ใบเสนอราคา
            'po.FTPoDocNo', //เลขที่ใบสั่งซื้อ
            'prj.FTPrjName', //ชื่อโครงการ
            'po.FTPoFrom', //ลูกค้า
            'pay.FNPayNo', //งวดที่
            'pay.FCPayAmount', //มูลค่า
            'pay.FDPayDueDate', //กำหนดชำระ
            'po.FNPoProgress', //ความคืบหน้า
            'po.FDPoEndDate', //กำหนดสำเร็จ
            'pay.FTPayStatus', //สถานะ
        ]);
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');
        $this->db->join($this->tTablePayment . ' as pay', 'po.FTPoCode = pay.FTPayPoCode', 'right');
        // $this->db->where('DATEDIFF(DAY, GETDATE(), pay.FDPayDueDate) BETWEEN -30 AND 30', null, false);
        $this->db->where('DATEDIFF(DAY, GETDATE(), pay.FDPayDueDate) <= ', 30);
        $this->db->where('pay.FTPayStatus <>', '1');

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        $this->db->order_by('pay.FDPayDueDate', 'ASC');
        $this->db->limit($nRecordsPerPage, $nRowStart);
        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array(),
            'rnTotalRecord' => $this->FSnMDBGetPaginationPoCount($paFilter)
        ];
    }

    /**
     * Functionality : Get Data Tracking Po
     * Parameters : Filter
     * Creator : 25/05/2025 Wuttichai
     * Last Modified : 
     * Return : Number of records
     * ReturnType: number
     */
    public function FSaMDBGetPaginatedPoTrackingData($paFilter){
        $nPageTrack = isset($paFilter['nPageTrack']) ? $paFilter['nPageTrack'] : 1;
        $nRecordsPerPageTracking = isset($paFilter['nRecordsPerPageTracking']) ? $paFilter['nRecordsPerPageTracking'] : 10;

        // คำนวณตำแหน่งเริ่มต้นและสิ้นสุดของข้อมูลในแต่ละหน้า
        $nRowStart = ($nPageTrack - 1) * $nRecordsPerPageTracking;

        $this->db->select([
            'po.FTPoCode', //รหัสโครงการ
            'prj.FTPrjName', //ชื่อโครงการ
            'po.FTPoRelease', //release
            'po.FNPoStatus', //phase
            'po.FTPoFrom', //ลูกค้า
            'po.FNPoProgress', //ความคืบหน้า
            'po.FDPoEndDate', //กำหนดสำเร็จ
        ]);
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');
        // $this->db->where('DATEDIFF(DAY, GETDATE(), po.FDPoEndDate) BETWEEN -30 AND 30', null, false);
        $this->db->where('DATEDIFF(DAY, GETDATE(), po.FDPoEndDate) <= ', 30);

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }
        $this->db->where('po.FNPoStatus <>', '7');

        $this->db->order_by('po.FDPoEndDate', 'ASC');
        $this->db->limit($nRecordsPerPageTracking, $nRowStart);
        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array(),
            'rnTotalRecord' => $this->FSnMDBGetPaginationPoTrackingCount($paFilter)
        ];
    }

    /**
     * Functionality : Get Count Po
     * Parameters : Filter
     * Creator : 25/05/2025 Wuttichai
     * Last Modified : 
     * Return : Number of records
     * ReturnType: number
     */
    public function FSnMDBGetPaginationPoCount($paFilter)
    {
        $this->db->select('COUNT(po.FTPoCode) AS total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');
        $this->db->join($this->tTablePayment . ' as pay', 'po.FTPoCode = pay.FTPayPoCode', 'right');
        // $this->db->where('DATEDIFF(DAY, GETDATE(), pay.FDPayDueDate) BETWEEN -30 AND 30', null, false);
        $this->db->where('DATEDIFF(DAY, GETDATE(), pay.FDPayDueDate) <= ', 30);
        $this->db->where('pay.FTPayStatus <>', '1');

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        $oQuery = $this->db->get();
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get Count Po Tracking
     * Parameters : Filter
     * Creator : 25/05/2025 Wuttichai
     * Last Modified : 
     * Return : Number of records
     * ReturnType: number
     */
    public function FSnMDBGetPaginationPoTrackingCount($paFilter)
    {
        $this->db->select('COUNT(po.FTPoCode) AS total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');
        // $this->db->where('DATEDIFF(DAY, GETDATE(), po.FDPoEndDate) BETWEEN -30 AND 30', null, false);
        $this->db->where('DATEDIFF(DAY, GETDATE(), po.FDPoEndDate) <= ', 30);

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }
        $this->db->where('po.FNPoStatus <>', '7');

        $oQuery = $this->db->get();
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get Total Po Value
     * Parameters : Filter
     * Creator : 29/04/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: number
     */
    public function FSnMDBGetTotalProjectValue($paFilter){
        $this->db->select('SUM(po.FCPoValue) as total');
        $this->db->from($this->tTable . ' as po');

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        $oQuery = $this->db->get();
        
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get Total Po Paid
     * Parameters : Filter
     * Creator : 29/04/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: number
     */
    public function FSnMDBGetTotalPoPaid($paFilter){
        $this->db->select('SUM(pat.FCPatAmount) as total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTablePayment . ' as pay', 'po.FTPoCode = pay.FTPayPoCode', 'inner');
        $this->db->join($this->tTablePaymentTrans . ' as pat', 'pay.FTPayCode = pat.FTPatPayCode', 'left');

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        $oQuery = $this->db->get();
        
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get Total Pay
     * Parameters : Filter
     * Creator : 29/04/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: number
     */
    public function FSnMDBGetTotalPay($paFilter){
        $this->db->select('SUM(pay.FCPayAmount) as total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTablePayment . ' as pay', 'po.FTPoCode = pay.FTPayPoCode', 'right');

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        $oQuery = $this->db->get();
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get Count Po Status
     * Parameters : 
     * Creator : 29/04/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: number
     */
    public function FSnMDBGetCountPoStatus($paFilter){
        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('FTPoTo', $paFilter['aDBSearchTo']);
        }
        if (!empty($paFilter['aDBOptionStatus'])) {
            $this->db->where_in('FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        $this->db->where_in('FNPoStatus', [1, 2, 3, 4, 5, 6, 7]);
        $oQuery = $this->db->get($this->tTable);
        $aResults = $oQuery->result_array();

        $aCountValueStatus = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 6 => 0, 7 => 0];
        
        foreach ($aResults as $aRow) {
            $nStatus = (int)$aRow['FNPoStatus'];
            if (isset($aCountValueStatus[$nStatus])) {
                $aCountValueStatus[$nStatus] += $aRow['FCPoValue'];
            }
        }

        $aData = [
            'nCount3' => $aCountValueStatus[3],
            'nCount1' => $aCountValueStatus[1],
            'nCount2' => $aCountValueStatus[2],
            'nCount4' => $aCountValueStatus[4],
            'nCount5' => $aCountValueStatus[5],
            'nCount6' => $aCountValueStatus[6],
            'nCount7' => $aCountValueStatus[7],
        ];
        // dbug($aData);
        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $aData,
        ];
    }

    /**
     * Functionality : Get Total Pay Pending
     * Parameters : Filter
     * Creator : 29/04/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: number
     */
    public function FSnMDBGetTotalPayPending($paFilter){
        $this->db->select('SUM(pay.FCPayAmount) as total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTablePayment . ' as pay', 'po.FTPoCode = pay.FTPayPoCode', 'right');
        $this->db->where('CAST(pay.FDPayDueDate AS DATE) >= CAST(GETDATE() AS DATE)');
        $this->db->where('pay.FTPayStatus <>', '1');

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        // $this->db->select('SUM(OutstandingAmount) AS total');
        // $this->db->from("($tSubQuery) AS pending");

        $oQuery = $this->db->get();
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get Total Po Unpaid
     * Parameters : Filter
     * Creator : 29/04/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: number
     */
    public function FSnMDBGetTotalPoUnPaid($paFilter){
        $this->db->select('SUM(pay.FCPayAmount) as total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTablePayment . ' as pay', 'po.FTPoCode = pay.FTPayPoCode', 'inner');
        $this->db->where('CAST(pay.FDPayDueDate AS DATE) < CAST(GETDATE() AS DATE)');
        $this->db->where('pay.FTPayStatus <>', '1');

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }

        $oQuery = $this->db->get();
        
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get Date Po
     * Parameters : 
     * Creator : 08/05/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: 
     */
    public function FSaMDBGetSelectPoDate(){
        $this->db->select('MIN(FDPoStartDate) AS FDPoStartDate, MAX(FDPoEndDate) AS FDPoEndDate');
        $this->db->from($this->tTable);
        $this->db->where('FNPoProgress <', 100);

        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->row(),
        ];
    }

    /**
     * Functionality : Get Total Data 
     * Parameters : 
     * Creator : 12/05/2025 Wuttichai
     * Last Modified : 
     * Return : 
     * ReturnType: 
     */
    public function FSnMDBGetTotalAllDataPo($paFilter){
        $tWhereConditions = "";
        if (!empty($paFilter['aDBSearchCustomer']) && is_array($paFilter['aDBSearchCustomer'])) {
            $aCustomerFrom = array_map(function($v){ return "'".addslashes($v)."'"; }, $paFilter['aDBSearchCustomer']);
            $tWhereConditions .= " AND po.FTPoFrom IN (" . implode(',', $aCustomerFrom) . ")";
        }
        if (!empty($paFilter['aDBSearchTo']) && is_array($paFilter['aDBSearchTo'])) {
            $aCustomerTo = array_map(function($v){ return "'".addslashes($v)."'"; }, $paFilter['aDBSearchTo']);
            $tWhereConditions .= " AND po.FTPoTo IN (" . implode(',', $aCustomerTo) . ")";
        }
        if (!empty($paFilter['aDBOptionStatus']) && is_array($paFilter['aDBOptionStatus'])) {
            $aStatuses = array_map('intval', $paFilter['aDBOptionStatus']);
            $tWhereConditions .= " AND po.FNPoStatus IN (" . implode(',', $aStatuses) . ")";
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $tStart = addslashes($paFilter['dDBSearchFromDate']);
            $tEnd   = addslashes($paFilter['dDBSearchToDate']);
            $tWhereConditions .= " AND CAST(po.FDPoStartDate AS DATE) >= '{$tStart}' AND CAST(po.FDPoEndDate AS DATE) <= '{$tEnd}'";
        }

        $tSql = "
            WITH PaymentBase AS (
                SELECT 
                    po.FTPoCode,
                    po.FNPoStatus,
                    po.FDPoStartDate,
                    po.FDPoEndDate,
                    payment.FTPayPoCode,
                    payment.FTPayDesc,
                    payment.FCPayAmount AS TotalAmount,
                    payment.FDPayDueDate,
                    ISNULL(SUM(trans.FCPatAmount), 0) AS PaidAmount,
                    payment.FCPayAmount - ISNULL(SUM(trans.FCPatAmount), 0) AS OutstandingAmount,
                    CASE 
                        WHEN payment.FCPayAmount <= ISNULL(SUM(trans.FCPatAmount), 0) THEN 'ชำระครบแล้ว'
                        WHEN ISNULL(SUM(trans.FCPatAmount), 0) > 0 THEN 'ชำระบางส่วน'
                        ELSE 'ยังไม่มีการชำระ'
                    END AS PaymentStatus,
                    CASE 
                        WHEN payment.FCPayAmount <= ISNULL(SUM(trans.FCPatAmount), 0) THEN 'ชำระครบแล้ว'
                        WHEN payment.FDPayDueDate <= GETDATE() THEN 'เลยกำหนด'
                        ELSE 'ยังไม่ถึงกำหนด'
                    END AS DueStatus
                FROM TTSTProjectPo po
                INNER JOIN TTSTPaymentPo payment ON po.FTPoCode = payment.FTPayPoCode
                LEFT JOIN TTSTPaymentTrans trans ON payment.FTPayCode = trans.FTPatPayCode
                WHERE payment.FCPayAmount > 0
                $tWhereConditions
                GROUP BY 
                    po.FTPoCode, 
                    po.FNPoStatus, 
                    po.FDPoStartDate, 
                    po.FDPoEndDate, 
                    payment.FTPayPoCode, 
                    payment.FTPayDesc, 
                    payment.FCPayAmount, 
                    payment.FDPayDueDate
            )

            SELECT 
                '1' AS ReportType,
                'ยอดทั้งหมด' AS Description,
                COUNT(*) AS RecordCount,
                SUM(TotalAmount) AS TotalAmount,
                SUM(CASE WHEN PaymentStatus IN ('ชำระครบแล้ว', 'ชำระบางส่วน') THEN 
                    CASE WHEN PaymentStatus = 'ชำระครบแล้ว' THEN TotalAmount ELSE PaidAmount END
                    ELSE 0 END) AS PaidAmount,
                SUM(OutstandingAmount) AS OutstandingAmount
            FROM PaymentBase

            UNION ALL

            SELECT 
                '2' AS ReportType,
                'ยอดที่ชำระแล้วทั้งหมด' AS Description,
                COUNT(*) AS RecordCount,
                SUM(CASE WHEN PaymentStatus = 'ชำระครบแล้ว' THEN TotalAmount ELSE PaidAmount END) AS TotalAmount,
                SUM(CASE WHEN PaymentStatus = 'ชำระครบแล้ว' THEN TotalAmount ELSE PaidAmount END) AS PaidAmount,
                0 AS OutstandingAmount
            FROM PaymentBase
            WHERE PaymentStatus IN ('ชำระครบแล้ว', 'ชำระบางส่วน')

            UNION ALL

            SELECT 
                '3' AS ReportType,
                'ยอดค้างชำระที่เลยกำหนด+ครบกำหนด' AS Description,
                COUNT(*) AS RecordCount,
                SUM(TotalAmount) AS TotalAmount,
                SUM(PaidAmount) AS PaidAmount,
                SUM(OutstandingAmount) AS OutstandingAmount
            FROM PaymentBase
            WHERE PaymentStatus IN ('ชำระบางส่วน', 'ยังไม่มีการชำระ')
            AND DueStatus = 'เลยกำหนด'

            UNION ALL

            SELECT 
                '4' AS ReportType,
                'ยอดค้างชำระที่ยังไม่ถึงกำหนด' AS Description,
                COUNT(*) AS RecordCount,
                SUM(TotalAmount) AS TotalAmount,
                SUM(PaidAmount) AS PaidAmount,
                SUM(OutstandingAmount) AS OutstandingAmount
            FROM PaymentBase
            WHERE PaymentStatus IN ('ชำระบางส่วน', 'ยังไม่มีการชำระ')
            AND DueStatus = 'ยังไม่ถึงกำหนด'

            ORDER BY ReportType;
        ";
        $query = $this->db->query($tSql);
        // dbug($this->db->last_query());
        return $query->result_array();
    }

    public function FSaMExecStoreGetPaymentSummary($paFilter){
        if (!empty($paFilter['aDBSearchCustomer']) && is_array($paFilter['aDBSearchCustomer'])) {
            $aDBSearchCustomer = implode(',', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo']) && is_array($paFilter['aDBSearchTo'])) {
            $aDBSearchTo = implode(',', $paFilter['aDBSearchTo']);
        }
        if (!empty($paFilter['aDBOptionStatus']) && is_array($paFilter['aDBOptionStatus'])) {
            $aDBOptionStatus = implode(',', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $dDBSearchFromDate = $paFilter['dDBSearchFromDate'];
            $dDBSearchToDate = $paFilter['dDBSearchToDate'];
        }

        $tCallStore = "{CALL SP_POxGetPaymentSummary(?, ?, ?, ?, ?)}";
        $aDataStore = array(
            $dDBSearchFromDate,
            $dDBSearchToDate,
            $aDBSearchCustomer??'',
            $aDBSearchTo??'',
            $aDBOptionStatus??''
        );
        $oQuery = $this->db->query($tCallStore, $aDataStore);

        if($oQuery !== FALSE){
            $aResult = $oQuery->result_array();
            unset($oQuery);
            return $aResult;
        }else{
            unset($oQuery);
            return array(); 
        }
    }

    public function FSaMDBGetDataProjectUrgent($paFilter){
        $this->db->select([
            'po.FTPoCode', //รหัสโครงการ
            'prj.FTPrjName', //ชื่อโครงการ
            'po.FTPoRelease', //release
            'po.FNPoStatus', //phase
            'po.FTPoFrom', //ลูกค้า
            'po.FNPoProgress', //ความคืบหน้า
            'po.FDPoEndDate', //กำหนดสำเร็จ
        ]);
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');
        // $this->db->where('DATEDIFF(DAY, GETDATE(), po.FDPoEndDate) BETWEEN -30 AND 30', null, false);
        $this->db->where('DATEDIFF(DAY, GETDATE(), po.FDPoEndDate) <= ', 30);

        if (!empty($paFilter['aDBSearchCustomer'])) {
            $this->db->where_in('po.FTPoFrom', $paFilter['aDBSearchCustomer']);
        }
        if (!empty($paFilter['aDBSearchTo'])) {
            $this->db->where_in('po.FTPoTo', $paFilter['aDBSearchTo']);
        }
        if(!empty($paFilter['aDBOptionStatus'])){
            $this->db->where_in('po.FNPoStatus', $paFilter['aDBOptionStatus']);
        }
        if (!empty($paFilter['dDBSearchFromDate']) && !empty($paFilter['dDBSearchToDate'])) {
            $this->db->where('CAST(po.FDPoDate AS DATE) >=', $paFilter['dDBSearchFromDate']);
            $this->db->where('CAST(po.FDPoDate AS DATE) <=', $paFilter['dDBSearchToDate']);
        }
        $this->db->where('po.FNPoStatus <>', '7');

        $this->db->order_by('po.FDPoEndDate', 'ASC');
        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array()
        ];
    }
}