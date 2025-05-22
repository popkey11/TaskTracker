<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Purchase_model extends CI_Model
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
     * Functionality : Get Count Po
     * Parameters : Filter
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : Number of records
     * ReturnType: number
     */
    public function FSnMPOGetPaginationPoCount($paFilter)
    {
        $this->db->select('COUNT(po.FTPoCode) AS total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');

        // ใช้การจัดกลุ่มเงื่อนไข
        if (!empty($paFilter['tPoSearch'])) {
            $this->db->group_start(); // เริ่มการจัดกลุ่มเงื่อนไข
            $this->db->like('po.FTPoCode', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoDocNo', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoRelease', $paFilter['tPoSearch']);
            $this->db->or_like('prj.FTPrjName', $paFilter['tPoSearch']);
            $this->db->or_like('pm.FTDevNickName', $paFilter['tPoSearch']);
            $this->db->or_like('sa.FTDevNickName', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoFrom', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoTo', $paFilter['tPoSearch']);
            $this->db->or_like('po.FNPoProgress', $paFilter['tPoSearch']);
            $this->db->group_end(); // จบการจัดกลุ่มเงื่อนไข
        }

        if (!empty($paFilter['nPoSearchYear'])) {
            $this->db->where('YEAR(po.FDPoDate)', $paFilter['nPoSearchYear']);
        }
        if (!empty($paFilter['nPoSearchProject'])) {
            $this->db->where('po.FTPrjCode', $paFilter['nPoSearchProject']);
        }
        if (!empty($paFilter['nPoSearchStatus'])) {
            $this->db->where_in('po.FNPoStatus', $paFilter['nPoSearchStatus']);
        }

        if (!empty($paFilter['tPoSearchFrom'])) {
            $this->db->where('po.FTPoFrom', $paFilter['tPoSearchFrom']);
        }
        if (!empty($paFilter['tPoSearchTo'])) {
            $this->db->where('po.FTPoTo', $paFilter['tPoSearchTo']);
        }

        if (!empty($paFilter['tPoSearchPm'])) {
            $this->db->where('pm.FTDevCode', $paFilter['tPoSearchPm']);
        }
        if (!empty($paFilter['tPoSearchSa'])) {
            $this->db->where('sa.FTDevCode', $paFilter['tPoSearchSa']);
        }
        if (!empty($paFilter['nPoSearchProgress'])) {
            $this->db->where('po.FNPoProgress', $paFilter['nPoSearchProgress']);
        }

        $oQuery = $this->db->get();
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get DateList Po
     * Parameters : Filter
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : Data PO
     * ReturnType: array
     */
    public function FSaMPOGetPaginatedPoData($paFilter)
    {
        $nPage = isset($paFilter['nPage']) ? $paFilter['nPage'] : 1;
        $nRecordsPerPage = isset($paFilter['nRecordsPerPage']) ? $paFilter['nRecordsPerPage'] : 50;

        // คำนวณตำแหน่งเริ่มต้นและสิ้นสุดของข้อมูลในแต่ละหน้า
        $nRowStart = ($nPage - 1) * $nRecordsPerPage;

        $this->db->select([
            'po.FTPoCode',
            'prj.FTPrjName',
            'po.FTPrjCode',
            'po.FTPoRelease',
            'po.FTPoPM',
            'pm.FTDevName AS FTPoPMName',
            'pm.FTDevNickName as FTPoPMNickName',
            'po.FTPoSA',
            'sa.FTDevName AS FTPoSAName',
            'sa.FTDevNickName as FTPoSANickName',
            'po.FTPoBD',
            'po.FTPoDocNo',
            'po.FDPoDate',
            'po.FCPoValue',
            'po.FDPoStartDate',
            'po.FDPoEndDate',
            'po.FNPoStatus',
            'po.FNPoProgress',
            'po.FTPoFrom',
            'po.FTPoTo',
        ]);
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');

        // ใช้การจัดกลุ่มเงื่อนไข
        if (!empty($paFilter['tPoSearch'])) {
            $this->db->group_start(); // เริ่มการจัดกลุ่มเงื่อนไข
            $this->db->like('po.FTPoCode', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoDocNo', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoRelease', $paFilter['tPoSearch']);
            $this->db->or_like('prj.FTPrjName', $paFilter['tPoSearch']);
            $this->db->or_like('pm.FTDevNickName', $paFilter['tPoSearch']);
            $this->db->or_like('sa.FTDevNickName', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoFrom', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoTo', $paFilter['tPoSearch']);
            $this->db->group_end(); // จบการจัดกลุ่มเงื่อนไข
        }

        if (!empty($paFilter['nPoSearchYear'])) {
            $this->db->where('YEAR(po.FDPoDate)', $paFilter['nPoSearchYear']);
        }
        if (!empty($paFilter['nPoSearchProject'])) {
            $this->db->where('po.FTPrjCode', $paFilter['nPoSearchProject']);
        }
        if (!empty($paFilter['nPoSearchStatus'])) {
            $this->db->where_in('po.FNPoStatus', $paFilter['nPoSearchStatus']);
        }

        if (!empty($paFilter['tPoSearchFrom'])) {
            $this->db->where('po.FTPoFrom', $paFilter['tPoSearchFrom']);
        }
        if (!empty($paFilter['tPoSearchTo'])) {
            $this->db->where('po.FTPoTo', $paFilter['tPoSearchTo']);
        }

        if (!empty($paFilter['tPoSearchPm'])) {
            $this->db->where('pm.FTDevCode', $paFilter['tPoSearchPm']);
        }
        if (!empty($paFilter['tPoSearchSa'])) {
            $this->db->where('sa.FTDevCode', $paFilter['tPoSearchSa']);
        }
        if (!empty($paFilter['tPoSearchBD'])) {
            $this->db->where('po.FTPoBD', $paFilter['tPoSearchBD']);
        }
        if (!empty($paFilter['nPoSearchProgress'])) {
            $this->db->where('po.FNPoProgress', $paFilter['nPoSearchProgress']);
        }

        $this->db->order_by('po.FTPoCode', 'DESC');
        $this->db->limit($nRecordsPerPage, $nRowStart);
        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array(),
            'rnTotalRecord' => $this->FSnMPOGetPaginationPoCount($paFilter)
        ];
    }

    /**
     * Functionality : Get Total PoValue
     * Parameters : Filter
     * Creator : 14/05/2025 Wuttichai
     * Last Modified :
     * Return : Total Data PoValue
     * ReturnType: number
     */
    public function FSaMPOGetTotalPoValue($paFilter)
    {

        $this->db->select('SUM(po.FCPoValue) AS total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTableProject . ' as prj', 'po.FTPrjCode = prj.FTPrjCode', 'left');
        $this->db->join($this->tTableDevTeam . ' as pm', 'pm.FTDevCode = po.FTPoPM', 'left');
        $this->db->join($this->tTableDevTeam . ' as sa', 'sa.FTDevCode = po.FTPoSA', 'left');

        // ใช้การจัดกลุ่มเงื่อนไข
        if (!empty($paFilter['tPoSearch'])) {
            $this->db->group_start(); // เริ่มการจัดกลุ่มเงื่อนไข
            $this->db->like('po.FTPoCode', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoDocNo', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoRelease', $paFilter['tPoSearch']);
            $this->db->or_like('prj.FTPrjName', $paFilter['tPoSearch']);
            $this->db->or_like('pm.FTDevNickName', $paFilter['tPoSearch']);
            $this->db->or_like('sa.FTDevNickName', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoFrom', $paFilter['tPoSearch']);
            $this->db->or_like('po.FTPoTo', $paFilter['tPoSearch']);
            $this->db->group_end(); // จบการจัดกลุ่มเงื่อนไข
        }

        if (!empty($paFilter['nPoSearchYear'])) {
            $this->db->where('YEAR(po.FDPoDate)', $paFilter['nPoSearchYear']);
        }
        if (!empty($paFilter['nPoSearchProject'])) {
            $this->db->where('po.FTPrjCode', $paFilter['nPoSearchProject']);
        }
        if (!empty($paFilter['nPoSearchStatus'])) {
            $this->db->where_in('po.FNPoStatus', $paFilter['nPoSearchStatus']);
        }

        if (!empty($paFilter['tPoSearchFrom'])) {
            $this->db->where('po.FTPoFrom', $paFilter['tPoSearchFrom']);
        }
        if (!empty($paFilter['tPoSearchTo'])) {
            $this->db->where('po.FTPoTo', $paFilter['tPoSearchTo']);
        }

        if (!empty($paFilter['tPoSearchPm'])) {
            $this->db->where('pm.FTDevCode', $paFilter['tPoSearchPm']);
        }
        if (!empty($paFilter['tPoSearchSa'])) {
            $this->db->where('sa.FTDevCode', $paFilter['tPoSearchSa']);
        }
        if (!empty($paFilter['tPoSearchBD'])) {
            $this->db->where('po.FTPoBD', $paFilter['tPoSearchBD']);
        }
        if (!empty($paFilter['nPoSearchProgress'])) {
            $this->db->where('po.FNPoProgress', $paFilter['nPoSearchProgress']);
        }

        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->row()->total
        ];
    }

    /**
     * Functionality : Get DataList All Project in Dev
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 20/11/2024 Sorawit
     * Return : Data Project  
     * ReturnType: array
     */
    public function FSaMPOGetProjectAll($ptUsrEmail)
    {
        // $oSubQuery = $this->db->select('FTDepCode')
        //     ->from('TTSDevTeam')
        //     ->where('FTDevEmail', $ptUsrEmail)
        //     ->get_compiled_select();

        // Main query to get projects
        $oQuery = $this->db->select('*')
            ->from('TTSMProject PRJ')
            ->where("FTDepCode = 00005")
            ->where('PRJ.FTPrjStaUse', '1')
            ->order_by('FTPrjCode', 'DESC')
            ->get();

        if ($oQuery->num_rows() > 0) {
            return [
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            ];
        } else {
            return [
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            ];
        }
    }

    /**
     * Functionality : Get DataList Team Dev All
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Data Team Lead
     * ReturnType: array
     */
    public function FSaMPOGetTeamDevAll()
    {
        $oQuery = $this->db->select(
            [
                'FTDevCode',
                'FTDevName',
                'FTDevNickName',
                'FTDevGrpTeam',
                'FTDepCode'
            ]
        )
            ->from($this->tTableDevTeam)
            ->where(['FTDepCode' => 5])
            ->where('FTDevGrpTeam !=', 'DELETE')
            ->order_by("(CASE 
                            WHEN FTDevGrpTeam = 'LEAD' THEN 0
                            WHEN FTDevGrpTeam = 'OUTSOURCE' THEN 2
                            ELSE 1 
                        END)", 'ASC')
            ->order_by('FTDevGrpTeam', 'ASC')
            ->get();

        if ($oQuery->num_rows() > 0) {
            return [
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            ];
        } else {
            return [
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            ];
        }
    }

    /**
     * Functionality : Insert Data Po
     * Parameters : - Param (data array for insert)
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPOInsertData($paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->insert($this->tTable, $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Error in saving data');
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error: ' . $e->getMessage(),
            ];
        }
        return $aResult;
    }


    /**
     * Functionality : Update Data List Po
     * Parameters : PoCode, Param (data array for update)
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : Status    
     * ReturnType: array
     */
    public function FSaMPOUpdateData($paFTPoCode, $paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->where('FTPoCode', $paFTPoCode);
            $this->db->update($this->tTable, $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $aResult = [
                    'rtCode' => 500,
                    'rtDesc' => 'error'
                ];
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Delete Data Po
     * Parameters : PoCode
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : Status    
     * ReturnType: array
     */
    public function FSaMPODeleteData($paPoCode)
    {
        try {
            $this->db->trans_start();
            $this->db->delete($this->tTable, ['FTPoCode' => $paPoCode]);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $aResult = [
                    'rtCode' => 500,
                    'rtDesc' => 'error'
                ];
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Generate New Po Code
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : Return New Po Code    
     * ReturnType: string
     */
    public function FStMPOLastCodeRunning()
    {
        $tCurrentYear = substr(date('Y'), 2); // ปีปัจจุบัน 2 หลัก เช่น 2024 -> 24
        $this->db->select('FTPoCode')
            ->from($this->tTable)
            ->like('FTPoCode', 'PO' . $tCurrentYear, 'after') // ค้นหา PO ที่เริ่มด้วย PO{year}
            ->order_by('FTPoCode', 'DESC')
            ->limit(1);

        $oQuery = $this->db->get();
        $oLastPoCode = $oQuery->row();
        $tYear = substr(date('Y'), 2);
        if ($oLastPoCode) {
            $nLastRunningNumber = (int) substr($oLastPoCode->FTPoCode, 4);
            $tNextPoRunning = sprintf('%04d', $nLastRunningNumber + 1); // บวก 1 ก่อน sprintf
            $tNextPoRunning = 'PO' . $tYear . $tNextPoRunning;
            return $tNextPoRunning;
        } else {
            $tNextPoRunning = sprintf('%04d', 1);
            return 'PO' . $tYear . $tNextPoRunning;
        }
    }

    /**
     * Functionality : Get Data List Po By Code
     * Parameters : PoCode
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : Return Data Po By FTPoCode    
     * ReturnType: array
     */

    public function FSaMPOGetDataByPoCode($paPoCode)
    {
        $this->db->select('*')
            ->from($this->tTable)
            ->where('FTPoCode', $paPoCode);
        $oQuery = $this->db->get();
        return $oQuery->row_array();
    }

    /**
     * Functionality : Get Year Po By FDPoDate
     * Parameters : -
     * Creator : 14/11/2024 Sorawit
     * Last Modified : 02/12/24 Sorawit
     * Return : Return Data Year    
     * ReturnType: array
     */
    public function FSaMPOGetSelectPoYear()
    {
        // เลือกปีจาก FDPoDate และทำการ Group By ปีเหล่านั้น
        $this->db->select("CONVERT(VARCHAR(4), FDPoDate) AS year", false);
        $this->db->from($this->tTable);
        $this->db->group_by("CONVERT(VARCHAR(4), FDPoDate)", false);
        $this->db->order_by("year", "DESC");

        $oQuery = $this->db->get();
        if ($oQuery->num_rows() > 0) {
            return [
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            ];
        } else {
            return [
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            ];
        }
    }

    /**
     * Functionality : Get Datalist From Po By FTPoFrom
     * Parameters : -
     * Creator :  02/12/2024 Sorawit
     * Last Modified : -
     * Return : Return Data From    
     * ReturnType: array
     */
    public function FSaMPOGetSelectPoFrom()
    {
        // เลือกปีจาก FTPoFrom และทำการ Group By
        $oQuery = $this->db->select("FTPoFrom")
            ->from($this->tTable)
            ->where("FTPoFrom IS NOT NULL")
            ->where("FTPoFrom !=", "")
            ->group_by("FTPoFrom")
            ->order_by("FTPoFrom", "ASC")
            ->get();

        if ($oQuery->num_rows() > 0) {
            return [
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            ];
        } else {
            return [
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            ];
        }
    }

    /**
     * Functionality : Get Datalist Po To By FTPoTo
     * Parameters : -
     * Creator : 02/12/2024 Sorawit
     * Last Modified : -
     * Return : Return Data Po To    
     * ReturnType: array
     */
    public function FSaMPOGetSelectPoTo()
    {
        // เลือกปีจาก FTPoTo และทำการ Group By
        $oQuery = $this->db->select("FTPoTo")
            ->from($this->tTable)
            ->where("FTPoTo IS NOT NULL")
            ->where("FTPoTo !=", "")
            ->group_by("FTPoTo")
            ->order_by("FTPoTo", "ASC")
            ->get();

        if ($oQuery->num_rows() > 0) {
            return [
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            ];
        } else {
            return [
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            ];
        }
    }

    /**
     * Functionality : Generate New Pay Code
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified :
     * Return : Return New Pay Code    
     * ReturnType: string
     */
    public function FStMPOLastCodeRunningPay()
    {
        $tCurrentYear = substr(date('Y'), 2); // ปีปัจจุบัน 2 หลัก เช่น 2024 -> 24
        $this->db->select('FTPayCode')
            ->from($this->tTablePayment)
            ->like('FTPayCode', 'PAY' . $tCurrentYear, 'after') // ค้นหา PAY ที่เริ่มด้วย PAY{year}
            ->order_by('FTPayCode', 'DESC')
            ->limit(1);

        $oQuery = $this->db->get();
        $oLastPayCode = $oQuery->row();
        $tYear = substr(date('Y'), 2);
        if ($oLastPayCode) {
            $nLastRunningNumber = (int) substr($oLastPayCode->FTPayCode, 5);
            $tNextPayRunning = sprintf('%04d', $nLastRunningNumber + 1); // บวก 1 ก่อน sprintf
            $tNextPayRunning = 'PAY' . $tYear . $tNextPayRunning;
            return $tNextPayRunning;
        } else {
            $tNextPayRunning = sprintf('%04d', 1);
            return 'PAY' . $tYear . $tNextPayRunning;
        }
    }

    /**
     * Functionality : Insert Data Pay
     * Parameters : - Param (data array for insert)
     * Creator : 09/04/2025 Wuttichai
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPOInsertPayData($paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->insert($this->tTablePayment, $paParam);
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Error in saving data');
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
            
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error: ' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Get DateList Pay
     * Parameters : PoCode
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : 
     * Return : Data Pay
     * ReturnType: array
     */
    public function FSaMPOGetPoCodeDataPay($paPoCode)
    {
        $this->db->select('*')
            ->from($this->tTablePayment)
            ->where("FTPayPoCode", $paPoCode);

        $this->db->order_by('FNPayNo', 'ASC');
        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array()
        ];
    }

    public function FSaMPOGetPayCodeDataPay($ptPayCode)
    {
        $this->db->select('*')
            ->from($this->tTablePayment)
            ->where("FTPayCode", $ptPayCode);

        $oQuery = $this->db->get()->row();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery
        ];
    }

    public function FSaMPOGetPatCodeData($ptPatCode)
    {
        $this->db->select('*')
            ->from($this->tTablePaymentTrans)
            ->where("FTPatCode", $ptPatCode);

        $oQuery = $this->db->get()->row();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery
        ];
    }

    /**
     * Functionality : Update Data List Po
     * Parameters : PoCode, Param (data array for update)
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : Status    
     * ReturnType: array
     */
    public function FSaMPOUpdatePayData($paFTPayCode, $paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->where('FTPayCode', $paFTPayCode);
            $this->db->update($this->tTablePayment, $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $aResult = [
                    'rtCode' => 500,
                    'rtDesc' => 'error'
                ];
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    public function FSaMPOGetPayCodeDataPat($ptPayCode)
    {
        $this->db->select('*')
            ->from($this->tTablePaymentTrans)
            ->where("FTPatPayCode", $ptPayCode);

        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array()
        ];
    }

    /**
     * Functionality : Generate New Pay Code
     * Parameters : -
     * Creator : 09/04/2025 Wuttichai
     * Last Modified :
     * Return : Return New Pay Code    
     * ReturnType: string
     */
    public function FStMPOLastCodeRunningPat()
    {
        $tCurrentYear = substr(date('Y'), 2); // ปีปัจจุบัน 2 หลัก เช่น 2024 -> 24
        $this->db->select('FTPatCode')
            ->from($this->tTablePaymentTrans)
            ->like('FTPatCode', 'PAT' . $tCurrentYear, 'after') // ค้นหา PAY ที่เริ่มด้วย PAY{year}
            ->order_by('FTPatCode', 'DESC')
            ->limit(1);

        $oQuery = $this->db->get();
        $oLastPatCode = $oQuery->row();
        $tYear = substr(date('Y'), 2);
        if ($oLastPatCode) {
            $nLastRunningNumber = (int) substr($oLastPatCode->FTPatCode, 5);
            $tNextPatRunning = sprintf('%04d', $nLastRunningNumber + 1); // บวก 1 ก่อน sprintf
            $tNextPatRunning = 'PAT' . $tYear . $tNextPatRunning;
            return $tNextPatRunning;
        } else {
            $tNextPatRunning = sprintf('%04d', 1);
            return 'PAT' . $tYear . $tNextPatRunning;
        }
    }

    /**
     * Functionality : Insert Data Pat
     * Parameters : - Param (data array for insert)
     * Creator : 09/04/2025 Wuttichai
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPOInsertPatData($paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->insert($this->tTablePaymentTrans, $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Error in saving data');
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error: ' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Insert Data Pat
     * Parameters : - Param (data array for insert)
     * Creator : 09/04/2025 Wuttichai
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPOInsertDocData($paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->insert('TTSTPrjPoDoc', $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Error in saving data');
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error: ' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Insert Data Pat
     * Parameters : - Param (data array for insert)
     * Creator : 09/04/2025 Wuttichai
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPOInsertUrlData($paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->insert('TTSTPrjPoUrl', $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Error in saving data');
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error: ' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Get DateList Pay
     * Parameters : PoCode
     * Creator : 09/04/2025 Wuttichai
     * Last Modified : 
     * Return : Data Pay
     * ReturnType: array
     */
    public function FSaMPOGetPoCodeDataDoc($paPoCode)
    {
        $this->db->select([
                'doc.FNPoDocID',
                'doc.FTPocode',
                'doc.FTPoDocName',
                'doc.FTPoDocDesc',
                'doc.FTPoDocType',
                'doc.FDPoDocCreateAt',
                'doc.FTPoDocCreateBy',
                'doc.FTPoDocFile',
                'pay.FTPayPoCode',
                'pay.FNPayNo',
                'pay.FTPayCode',
                'pay.FTPayName',
            ])
            ->from('TTSTPrjPoDoc as doc')
            ->join($this->tTablePayment . ' as pay', 'doc.FTPayCode = pay.FTPayCode', 'left')
            ->where("doc.FTPoCode", $paPoCode);

        $this->db->order_by('doc.FNPoDocID', 'ASC');
        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array()
        ];
    }

    /**
     * Functionality : Get DateList Url
     * Parameters : PoCode
     * Creator : 21/04/2025 Wuttichai
     * Last Modified : 
     * Return : Data Url
     * ReturnType: array
     */
    public function FSaMPOGetPoCodeDataUrl($paPoCode)
    {
        $this->db->select('*')
            ->from('TTSTPrjPoUrl')
            ->where("FTPoCode", $paPoCode);

        $this->db->order_by('FNPoUrlID', 'ASC');
        $oQuery = $this->db->get();

        return [
            'rtCode' => 200,
            'rtDesc' => 'success',
            'raItems' => $oQuery->result_array()
        ];
    }

    /**
     * Functionality : Delete Data Doc
     * Parameters : DocID
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : Status    
     * ReturnType: array
     */
    public function FSaMPODeleteDataDoc($paDocID)
    {
        try {
            $this->db->trans_start();
            $this->db->delete('TTSTPrjPoDoc', ['FNPoDocID' => $paDocID]);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $aResult = [
                    'rtCode' => 500,
                    'rtDesc' => 'error'
                ];
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Delete Data Url
     * Parameters : UrlID
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : Status    
     * ReturnType: array
     */
    public function FSaMPODeleteDataUrl($paUrlID)
    {
        try {
            $this->db->trans_start();
            $this->db->delete('TTSTPrjPoUrl', ['FNPoUrlID' => $paUrlID]);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $aResult = [
                    'rtCode' => 500,
                    'rtDesc' => 'error'
                ];
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Delete Data Url
     * Parameters : UrlID
     * Creator : 21/04/2025 Wuttichai
     * Last Modified :
     * Return : Status    
     * ReturnType: array
     */
    public function FSaMPODeleteDataPay($paPayCode)
    {
        try {
            $this->db->trans_start();
            $this->db->delete('TTSTPaymentPo', ['FTPayCode' => $paPayCode]);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $aResult = [
                    'rtCode' => 500,
                    'rtDesc' => 'error'
                ];
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Update Data Pat
     * Parameters : PatCode, Param (data array for update)
     * Creator : 17/04/2025 Wuttichai
     * Last Modified :
     * Return :     
     * ReturnType: array
     */
    public function FSaMPOUpdateDataPat($paFTPatCode, $paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->where('FTPatCode', $paFTPatCode);
            $this->db->update($this->tTablePaymentTrans, $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $aResult = [
                    'rtCode' => 500,
                    'rtDesc' => 'error'
                ];
            }
            $aResult = [
                'rtCode' => 200,
                'rtDesc' => 'success'
            ];
        } catch (Exception $e) {
            $this->db->trans_rollback();
            $aResult = [
                'rtCode' => 500,
                'rtDesc' => 'error' . $e->getMessage(),
            ];
        }
        return $aResult;
    }

    /**
     * Functionality : Update Data List Po
     * Parameters : PoCode, Param (data array for update)
     * Creator : 14/11/2024 Sorawit
     * Last Modified :
     * Return : Status    
     * ReturnType: array
     */
    public function FSaMPOLastNoRunningPay($paFTPoCode){
        $aLastPayNo = $this->db->select_max('FNPayNo')
            ->where('FTPayPoCode', $paFTPoCode)
            ->get($this->tTablePayment)->row();
        $nNextPayNo = ($aLastPayNo && $aLastPayNo->FNPayNo !== null) ? $aLastPayNo->FNPayNo + 1 : 1;

        return $nNextPayNo;
    }

    /**
     * Functionality : Get Total Pat TotalAmount
     * Parameters : PoCode
     * Creator : 06/05/2025 Wuttichai
     * Last Modified : 
     * Return : FCPatAmount
     * ReturnType: array
     */
    public function FSaMPOGetPatTotalAmount($paPoCode)
    {
        $this->db->select('SUM(pat.FCPatAmount) as total');
        $this->db->from($this->tTable . ' as po');
        $this->db->join($this->tTablePayment . ' as pay', 'po.FTPoCode = pay.FTPayPoCode', 'left');
        $this->db->join($this->tTablePaymentTrans . ' as pat', 'pay.FTPayCode = pat.FTPatPayCode', 'left');
        $this->db->where('po.FTPoCode', $paPoCode);

        $oQuery = $this->db->get();
        $nTotal = $oQuery->row()->total;

        return [
            'rtCode' => 200, // tCode
            'rtDesc' => 'success', //tDesc
            'raItems' => $nTotal??0 //aItems
        ];
    }

    /**
     * Functionality : Get Datalist From Po By FTPoBD
     * Parameters : -
     * Creator :  13/05/2025 Wuttichai
     * Last Modified : -
     * Return : Return Data From    
     * ReturnType: array
     */
    public function FSaMPOGetSelectPoBD()
    {
        $this->db->distinct();
        $this->db->select('FTPoBD');
        $this->db->from('TTSTProjectPo');
        $this->db->where('FTPoBD !=', '');
        $this->db->order_by('FTPoBD', 'ASC');
        $oQuery = $this->db->get();

        if ($oQuery->num_rows() > 0) {
            return [
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            ];
        } else {
            return [
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            ];
        }
    }

    /**
     * Functionality : Get Sum PayAmount
     * Parameters : -
     * Creator :  14/05/2025 Wuttichai
     * Last Modified : -
     * Return : Return Data From    
     * ReturnType: number
     */
    public function FSaMPOSumPayAmount($paFTPoCode)
    {
        $this->db->select('SUM(FCPayAmount) AS total');
        $this->db->from('TTSTPaymentPo');
        $this->db->where('FTPayPoCode', $paFTPoCode);
        $oQuery = $this->db->get();

        return $oQuery->row()->total??0;
    }

    /**
     * Functionality : Get Sum PoAmount
     * Parameters : -
     * Creator :  14/05/2025 Wuttichai
     * Last Modified : -
     * Return : Return Data From    
     * ReturnType: number
     */
    public function FSaMPOSumPoAmount($paFTPoCode)
    {
        $this->db->select('SUM(FCPoValue) AS total');
        $this->db->from('TTSTProjectPo');
        $this->db->where('FTPoCode', $paFTPoCode);
        $oQuery = $this->db->get();

        return $oQuery->row()->total??0;
    }

    /**
     * Functionality : Get Sum PoAmount
     * Parameters : -
     * Creator :  14/05/2025 Wuttichai
     * Last Modified : -
     * Return : Return Data From    
     * ReturnType: number
     */
    public function FSnMPOSumPatAmount($paFTPayCode)
    {
        $this->db->select('SUM(FCPatAmount) AS total');
        $this->db->from('TTSTPaymentTrans');
        $this->db->where('FTPatPayCode', $paFTPayCode);
        $oQuery = $this->db->get();

        return $oQuery->row()->total??0;
    }

    /**
     * Functionality : Get Datalist From Po By Pay
     * Parameters : -
     * Creator :  13/05/2025 Wuttichai
     * Last Modified : -
     * Return : Return Data From    
     * ReturnType: array
     */
    public function FSaMPOGetSelectPayNo($paFTPoCode)
    {
        $this->db->select([
            'FTPayCode',
            'FNPayNo',
            'FTPayName'
        ]);
        $this->db->from('TTSTPaymentPo');
        $this->db->where('FTPayPoCode =', $paFTPoCode);
        $this->db->order_by('FNPayNo', 'ASC');
        $oQuery = $this->db->get();

        if ($oQuery->num_rows() > 0) {
            return [
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            ];
        } else {
            return [
                'raItems' => [],
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            ];
        }
    }
}
