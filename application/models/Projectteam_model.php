<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Projectteam_model extends CI_Model
{
    protected $tTable = 'TTSTPrjTeam';
    protected $tTableProject = 'TTSMProject';
    protected $tTableDevTeam = 'TTSDevTeam';
    protected $tViewTable = 'V_CNPjtPlan';

    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }

    /**
     * Functionality : Get Count Project Team
     * Parameters : Filter
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : Number of records
     * ReturnType: number
     */
    public function FSnMPOGetPaginationPoCount($paFilter)
    {
        $this->db->select('COUNT(pjt.FTPrjCode) AS total');
        $this->db->from($this->tViewTable . ' as pjt');

        // ใช้การจัดกลุ่มเงื่อนไข
        if (!empty($paFilter['tSearch'])) {
            $this->db->group_start(); // เริ่มการจัดกลุ่มเงื่อนไข
            $this->db->like('pjt.FTPrjName', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTPrjRelease', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTDevName', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTDevNickName', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTDevGrpTeam', $paFilter['tSearch']);
            $this->db->group_end(); // จบการจัดกลุ่มเงื่อนไข
        }

        if (!empty($paFilter['tSearchProject'])) {
            $this->db->where('pjt.FTPrjCode', $paFilter['tSearchProject']);
        }
        if (!empty($paFilter['tSearchRelease'])) {
            $this->db->where('pjt.FTPrjRelease', $paFilter['tSearchRelease']);
        }
        if (!empty($paFilter['nSearchDev'])) {
            $this->db->where('pjt.FTDevCode', $paFilter['nSearchDev']);
        }
        if (!empty($paFilter['nSearchDevTeam'])) {
            $this->db->where('pjt.FTDevGrpTeam', $paFilter['nSearchDevTeam']);
        }

        $oQuery = $this->db->get();
        return $oQuery->row()->total;
    }

    /**
     * Functionality : Get DateList Project Team
     * Parameters : Filter (array for filter)
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : Data Project Team
     * ReturnType: array
     */
    public function FSaMPJTGetPaginatedData($paFilter)
    {
        $nPage = isset($paFilter['nPage']) ? $paFilter['nPage'] : 1;
        $nRecordsPerPage = isset($paFilter['nRecordsPerPage']) ? $paFilter['nRecordsPerPage'] : 10;

        // คำนวณตำแหน่งเริ่มต้นและสิ้นสุดของข้อมูลในแต่ละหน้า
        $nRowStart = ($nPage - 1) * $nRecordsPerPage;

        $this->db->select('*');
        $this->db->from($this->tViewTable . ' as pjt');

        // ใช้การจัดกลุ่มเงื่อนไข
        if (!empty($paFilter['tSearch'])) {
            $this->db->group_start(); // เริ่มการจัดกลุ่มเงื่อนไข
            $this->db->like('pjt.FTPrjName', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTPrjRelease', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTDevName', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTDevNickName', $paFilter['tSearch']);
            $this->db->or_like('pjt.FTDevGrpTeam', $paFilter['tSearch']);
            $this->db->group_end(); // จบการจัดกลุ่มเงื่อนไข
        }

        if (!empty($paFilter['tSearchProject'])) {
            $this->db->where('pjt.FTPrjCode', $paFilter['tSearchProject']);
        }
        if (!empty($paFilter['tSearchRelease'])) {
            $this->db->where('pjt.FTPrjRelease', $paFilter['tSearchRelease']);
        }
        if (!empty($paFilter['nSearchDev'])) {
            $this->db->where('pjt.FTDevCode', $paFilter['nSearchDev']);
        }
        if (!empty($paFilter['nSearchDevTeam'])) {
            $this->db->where('pjt.FTDevGrpTeam', $paFilter['nSearchDevTeam']);
        }

        $this->db->order_by('pjt.FTPrjCode', 'ASC');
        $this->db->order_by('pjt.FTPrjRelease', 'ASC');
        $this->db->order_by('pjt.FDPrjPlanStart', 'ASC');

        $this->db->limit($nRecordsPerPage, $nRowStart);
        $oQuery = $this->db->get();

        if ($oQuery->num_rows() > 0) {
            return [
                'rtCode' => 200,
                'rtDesc' => 'success',
                'raItems' => $oQuery->result_array(),
                'rnTotalRecord' => $this->FSnMPOGetPaginationPoCount($paFilter)
            ];
        } else {
            return [
                'rtCode' => 800,
                'rtDesc' => 'data not found',
                'raItems' => [],
                'rnTotalRecord' => 0
            ];
        }
    }

    /**
     * Functionality : Insert Data Project Team
     * Parameters : - Param (data array for insert)
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPJTInsertData($paParam)
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
     * Functionality : Update Data Project Team
     * Parameters : - Param (data array for update)
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPJTUpdateData($paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->where([
                'FTPrjCode' => $paParam['FTPrjCode'],
                'FTDevCode' => $paParam['FTDevCode'],
                'FTPrjRelease' => $paParam['FTPrjRelease']
            ]);
            $this->db->update($this->tTable, $paParam);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Error in updating data');
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
     * Functionality : Delete Data Project Team
     * Parameters : - Param (data array for Delete)
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : Status
     * ReturnType : array
     */
    public function FSaMPJTDeleteData($paParam)
    {
        try {
            $this->db->trans_start();
            $this->db->where([
                'FTPrjCode' => $paParam['tPrjCode'],
                'FTDevCode' => $paParam['tDevCode'],
                'FTPrjRelease' => $paParam['tPrjRelease']
            ]);
            $this->db->delete($this->tTable);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Error in deleting data');
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
     * Functionality : Get Data Project Team by Primary Key
     * Parameters : - Param (Primary Key)
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : Data Project Team
     * ReturnType : array
     */
    public function FSaMPJTGetDataByPrimaryKey($paParam)
    {
        $oQuery = $this->db->select('*')
            ->from($this->tTable)
            ->where([
                'FTPrjCode' => $paParam['tPrjCode'],
                'FTDevCode' => $paParam['tDevCode'],
                'FTPrjRelease' => $paParam['tPrjRelease']
            ])
            ->get();

        if ($oQuery->num_rows() > 0) {
            return $oQuery->row_array(); // คืนค่าข้อมูลแถวเดียว
        } else {
            return [];
        }
    }


    /**
     * Functionality : Check Duplicate Data Dev Plan
     * Parameters : $aData (ข้อมูลที่ต้องตรวจสอบ)
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : Status
     * ReturnType : boolean
     */
    public function FSbMPJTCheckDuplicate($aData)
    {
        $this->db->where('FTPrjCode', $aData['FTPrjCode']);
        $this->db->where('FTDevCode', $aData['FTDevCode']);
        $this->db->where('FTPrjRelease', $aData['FTPrjRelease']);
        $oQuery = $this->db->get($this->tTable);

        // คืนค่า true หากไม่มีข้อมูลซ้ำ
        return $oQuery->num_rows() === 0;
    }

    /**
     * Functionality : Get Data List Dev Team  
     * Parameters : -
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : Data Team Lead
     * ReturnType: array
     */
    public function FSaMPJTGetDevTeamAll()
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
     * Functionality : Get Data Release List 
     * Parameters : -
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : Data Release List 
     * ReturnType : array
     */
    public function FSaMPJTGetReleaseListAll()
    {
        $oQuery = $this->db->select('FTPrjRelease')
            ->from($this->tTable)
            ->group_by('FTPrjRelease')
            ->order_by('FTPrjRelease', 'ASC')
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
     * Functionality : Get Data List Dev Group Team in Project Team
     * Parameters :
     * Creator : 19/11/2024 Sorawit
     * Last Modified :
     * Return : Data Group Team 
     * ReturnType: array
     */
    public function FSaMPJTGetDevGroupTeamAll()
    {
        $oQuery = $this->db->select('FTDevGrpTeam')
            ->from($this->tViewTable)
            ->where('FTDevGrpTeam !=', 'DELETE') // เงื่อนไขที่ไม่เอา DELETE
            ->group_by('FTDevGrpTeam')
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
     * Functionality : Get Data List Project By Code 00005
     * Parameters : 
     * Creator : 18/11/2024 Sorawit
     * Last Modified :
     * Return : Data Project   
     * ReturnType: array
     */
    public function FSaMPJTGetProjectList($ptUsrEmail)
    {
        // Subquery to get FTDepCode
        $oSubQuery = $this->db->select('FTDepCode')
            ->from('TTSDevTeam')
            ->where('FTDevEmail', $ptUsrEmail)
            ->get_compiled_select();

        // Main query to get projects
        $oQuery = $this->db->select('*')
            ->from('TTSMProject PRJ')
            ->where("FTDepCode = ($oSubQuery)", null, false) // Using subquery here
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
     * Functionality : Filter Project List by Dev Code, Dev Team, Release
     * Parameters : DevCode, DevTeam, Release
     * Creator : 20/11/2024 Sorawit
     * Last Modified :
     * Return : Data Project   
     * ReturnType: array
     */
    public function FSaMPJTGetOptionProjectList($ptDevCode, $ptDevTeam, $ptRelease)
    {
        $this->db->select('FTPrjCode, FTPrjName');
        $this->db->from('V_CNPjtPlan');

        if ($ptDevCode) {
            $this->db->where('FTDevCode', $ptDevCode);
        }
        if ($ptDevTeam) {
            $this->db->where('FTDevGrpTeam', $ptDevTeam);
        }
        if ($ptRelease) {
            $this->db->where('FTPrjRelease', $ptRelease);
        }

        $this->db->group_by('FTPrjCode, FTPrjName');
        $oQuery = $this->db->get();

        return $this->FSaMPJTQueryResult($oQuery);
    }
    /**
     * Functionality : Filter Release List by Dev Code, Dev Team, Project Code
     * Parameters : DevCode, DevTeam, ProjectCode
     * Creator : 20/11/2024 Sorawit
     * Last Modified :
     * Return : Data Release      
     * ReturnType: array
     */
    public function FSaMPJTGetOptionReleaseList($ptDevCode, $ptDevTeam, $ptProjectCode)
    {
        $this->db->select('FTPrjRelease');
        $this->db->from('V_CNPjtPlan');

        if ($ptDevCode) {
            $this->db->where('FTDevCode', $ptDevCode);
        }
        if ($ptDevTeam) {
            $this->db->where('FTDevGrpTeam', $ptDevTeam);
        }
        if ($ptProjectCode) {
            $this->db->where('FTPrjCode', $ptProjectCode);
        }

        $this->db->group_by('FTPrjRelease');
        $oQuery = $this->db->get();

        return $this->FSaMPJTQueryResult($oQuery);
    }
    /**
     * Functionality : Filter Developer List by Dev Team, Project Code, Release
     * Parameters : DevTeam, ProjectCode, Release
     * Creator : 20/11/2024 Sorawit
     * Last Modified :
     * Return : Data Dev   
     * ReturnType: array
     */
    public function FSaMPJTGetOptionDeveloperList($ptDevTeam, $ptProjectCode, $ptRelease)
    {
        $this->db->select('FTDevCode, FTDevName, FTDevNickName, FTDevGrpTeam');
        $this->db->from('V_CNPjtPlan');

        if ($ptDevTeam) {
            $this->db->where('FTDevGrpTeam', $ptDevTeam);
        }
        if ($ptProjectCode) {
            $this->db->where('FTPrjCode', $ptProjectCode);
        }
        if ($ptRelease) {
            $this->db->where('FTPrjRelease', $ptRelease);
        }

        $this->db->group_by('FTDevCode, FTDevName, FTDevNickName, FTDevGrpTeam');
        $oQuery = $this->db->get();

        return $this->FSaMPJTQueryResult($oQuery);
    }
    /**
     * Functionality : Filter Team List by Dev Code, Project Code, Release
     * Parameters : DevCode, ProjectCode, Release
     * Creator : 20/11/2024 Sorawit
     * Last Modified : 03/12/2024 Sorawit
     * Return : Data Team    
     * ReturnType: array
     */
    public function FSaMPJTGetOptionTeamList($ptDevCode, $ptProjectCode, $ptRelease)
    {
        $this->db->select('FTDevGrpTeam');
        $this->db->from('V_CNPjtPlan');

        if ($ptDevCode) {
            $this->db->where('FTDevCode', $ptDevCode);
        }
        if ($ptProjectCode) {
            $this->db->where('FTPrjCode', $ptProjectCode);
        }
        if ($ptRelease) {
            $this->db->where('FTPrjRelease', $ptRelease);
        }
        $this->db->where('FTDevGrpTeam !=', 'DELETE');

        $this->db->group_by('FTDevGrpTeam');
        $oQuery = $this->db->get();

        return $this->FSaMPJTQueryResult($oQuery);
    }

    /**
     * Functionality : Result Query Result
     * Parameters : Query (Data Result)
     * Creator : 20/11/2024 Sorawit
     * Last Modified :
     * Return : array of result       
     * ReturnType: array
     * */
    private function FSaMPJTQueryResult($poQuery)
    {
        if ($poQuery->num_rows() > 0) {
            return [
                'raItems' => $poQuery->result_array(),
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
