<?php defined('BASEPATH') or exit('No direct script access allowed');
class PurchaseOld_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }
    /**
     * Functionality : Get Data Spilt Pagination
     * Parameters : $pId
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : Number
     * Return Type : text
     */
    public function FSnMPaginationPurchase($aFilter)
    {
        //ชื่อตัวแปรผิด
        $tProject = $aFilter['tProject'];
        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }
        $tSQL =
            "SELECT *
            FROM TTSTPrjPo PRJ WITH (NOLOCK) WHERE FTPrjCode ='$tProject'";
        if ($LikeSearch != '') {
            $tSQL .= " OR ((  PRJ.FTPohDocNo LIKE '%$LikeSearch%') OR (PRJ.FTPohName LIKE '%$LikeSearch%'))  ";
        }
        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    /**
     * Functionality : Get Data PO
     * Parameters : $pId
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : array
     * Return Type : array
     */
    public function FSaMPOListView($pId)
    {

        $tSQL = "SELECT * from TTSMProject WITH (NOLOCK) Where FTPrjCode='$pId'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery) {
            return $oQuery->row_array();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Get Data Edit
     * Parameters : $pId
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : array
     * Return Type : array
     */
    public function FSaMPOGetEditPeriod($tPrjCode, $tPohDocNo, $tPocSeqNo)
    {
        $tSQL = "SELECT * from TTSTPrjPoCond Where FTPrjCode='$tPrjCode' AND FTPohDocNo='$tPohDocNo' AND FNPocSeqNo='$tPocSeqNo'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery) {
            return $oQuery->row_array();
        } else {
            return false;
        }
    }

    /**
     * Functionality : Get Period All
     * Parameters : $pId=PrjCode
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : Data Period
     * Return Type : Array
     */
    public function FSaMPOGetPeriodAll($pId, $pNProjectNo)
    {
        $tSQL = "SELECT * FROM TTSTPrjPoCond WITH(NOLOCK) Where FTPohDocNo='$pId' AND FTPrjCode='$pNProjectNo'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery) {
            return
                $oQuery->result_array();;
        } else {
            return 'error';
        }
    }
    /**
     * Functionality : Get Project All
     * Parameters : $aFilter
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : Data Project
     * Return Type : Array
     */
    public function FSaMPOGetProject($aFilter)
    {
        $tProject = $aFilter['tProject'];
        $nTotalRecord = $this->FSnMPaginationPurchase($aFilter);

        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }

        $nRecordsPerPage = 10;
        $total_pages = ceil($nTotalRecord / $nRecordsPerPage);

        // Determine the current page number
        if (isset($aFilter['nPage'])) {
            $nPage = $aFilter['nPage'];
        } else {
            $nPage = 1;
        }

        $prev_page = $nPage - 1;
        $next_page = $nPage + 1;

        $row_start = (($nRecordsPerPage * $nPage) - $nRecordsPerPage);
        if ($nTotalRecord <= $nRecordsPerPage) {
            $num_pages = 1;
        } else if (($nTotalRecord % $nRecordsPerPage) == 0) {
            $num_pages = ($nTotalRecord / $nRecordsPerPage);
        } else {
            $num_pages = ($nTotalRecord / $nRecordsPerPage) + 1;
            $num_pages = (int)$num_pages;
        }

        $row_end = $nRecordsPerPage * $nPage;

        if ($row_end > $nTotalRecord) {
            $row_end = $nTotalRecord;
        }
        $tSQL = "SELECT * FROM ( ";
        $tSQL .= "SELECT ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS RowID,
                            PRJ.*
            FROM TTSTPrjPo PRJ WHERE FTPrjCode ='$tProject'";

        if ($LikeSearch != '') {
            $tSQL .= " WHERE ((  PRJ.FTPohDocNo LIKE '%$LikeSearch%') OR (PRJ.FTPohName LIKE '%$LikeSearch%'))  ";
        }
        $tSQL .= " ) C ";
        $tSQL .= " WHERE c.RowID > $row_start AND c.RowID <= $row_end ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {

            $aResult     = array(
                'raItems'      => $oQuery->result_array(),
                'total_record' => $nTotalRecord,
                'total_pages' => $total_pages,
                'current_page' => $nPage,
                'prev_page' => $prev_page,
                'next_page' => $next_page,
                'rtCode'    => '200',
                'rtDesc'       => 'success',
            );
        } else {

            $aResult = array(
                'rnAllRow'         => 0,
                'total_record' => 0,
                'total_pages' => 0,
                'current_page' => 0,
                'prev_page' => 0,
                'next_page' => 0,
                'rtCode'         => '800',
                'rtDesc'         => 'data not found',
            );
        }
        return $aResult;
    }


    /**
     * Functionality : Get Department
     * Parameters : $dFilter
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : Data Department
     * Return Type : Array
     */
    public function FSaMPOGetDepartment($dFilter)
    {
        $tSQL = "SELECT * FROM TTSDepartment ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {

            $aResult     = array(
                'raItems'      => $oQuery->result_array(),
                'rtCode'    => '200',
                'rtDesc'       => 'success',
            );
        } else {

            $aResult = array(
                'rnAllRow'         => 0,
                'rtCode'         => '800',
                'rtDesc'         => 'data not found',
            );
        }
        return $aResult;
    }


    /**
     * Functionality : Check Duplicate Po
     * Parameters : $ptPrjCode=PrjCode,$tPohDocNo=PohDocNo
     * Creator : 10/11/2023 boripat
     * Last Modified : -
     * Return : return num row
     * Return Type : number
     */
    private function FStMPOCheckPODuplicate($ptPrjCode, $tPohDocNo)
    {
        try {
            $tSQL = "SELECT * FROM TTSTPrjPo WHERE FTPrjCode='$ptPrjCode' AND FTPohDocNo='$tPohDocNo'";
            return $this->db->query($tSQL)->num_rows();
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
    /**
     * Functionality : Get Period for Edit
     * Parameters : $id=PrjCode
     * Creator : 23/05/2023 Papitchaya
     * Last Modified : -
     * Return : Data List TopUp
     * Return Type : Array
     */
    public function FSaMPOGetDataEdit($pId, $ptDocNo)
    {
        try {
            $tSQL = "SELECT T1.FTPrjCode,T2.FTPohDocNo,T1.FTPohDocNo,T1.FTPohName,T1.FDPohDocDate,T1.FDPohStart,T1.FDPohFinish,
            FTPohRefUrl,T1.FTPohRemark,T1.FTPohStaDoc,T1.FCPohPercentDone,T2.FCPodMdcSharp,T2.FCPodMdPhp,T2.FCPodMdAndroid,T2.FCPodMdDev,
            T2.FCPodMdTester,T2.FCPodMdSa,T2.FCPodMdPm,T2.FCPodMdInterface,T2.FCPodMdTotal
            FROM TTSTPrjPo AS T1 WITH(NOLOCK) 
            LEFT JOIN  TTSTPrjPoMd AS T2 on T1.FTPrjCode=T2.FTPrjCode AND T1.FTPohDocNo=T2.FTPohDocNo
            WHERE T1.FTPrjCode='$pId' AND T1.FTPohDocNo='$ptDocNo'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                return $oQuery->row_array();
            } else {
                return false;
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
    /**
     * Functionality : Event Save PO 
     * Parameters : $aDataInsert
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : true or false
     * Return Type : text
     */
    public function FStMPOEventSavePo($aDataInsert)
    {
        try {
            $tTitle         = $aDataInsert["FTPpoTitle"];
            $tStatus        = $aDataInsert["FNPpoStatus"];
            $tProgress      = $aDataInsert["FTPpoProgress"];
            $tRemark        = $aDataInsert["FTPpoRemark"];
            $tPlanStart     = $aDataInsert["FDPpoPlanStart"];
            $tPlanFinish    = $aDataInsert["FDPpoPlanFinish"];
            $tRefUrl        = $aDataInsert["FTPpoRefUrl"];
            $tMdTotal       = $aDataInsert["FCPpoMdTotal"];
            $tDocDate       = $aDataInsert["FDPpoDocDate"];
            $tPrjCode       = $aDataInsert["FTPrjCode"];
            $tPohDocNo       = $aDataInsert["FTPohDocNo"];

            $tMdPhp         = $aDataInsert["FCPpoMdPhp"];
            $tMdDev         = $aDataInsert["FCPpoMdDev"];
            $tMdcSharp      = $aDataInsert["FCPpoMdcSharp"];
            $tMdAndroid     = $aDataInsert["FCPpoMdAndroid"];
            $tMdTester      = $aDataInsert["FCPpoMdTester"];
            $tMdSa          = $aDataInsert["FCPpoMdSa"];
            $tMdPm          = $aDataInsert["FCPpoMdPm"];
            $tMdInterface   = $aDataInsert["FCPpoMdInterface"];
            $tGrand   = $aDataInsert["FCPpoMdTotal"];
            $tUser = get_cookie('TaskEmail');

            $tCheckExist = $this->FStMPOCheckPODuplicate($tPrjCode, $tPohDocNo);
            if ($tCheckExist > 0) {
                return json_encode(['status' => false, 'message' => 'เลขที่ใบสั่งซื้อนี้มีอยู่แล้ว']);
            } else {
                // $this->db->trans_begin();
                $tSQL = "INSERT INTO TTSTPrjPo (FTPrjCode,FTPohDocNo,FDPohDocDate,FTPohName,FCPohGrand,FDPohStart,FDPohFinish,FTPohRefUrl,FTPohRemark,FTPohStaDoc,FCPohPercentDone,
        FTLastUpdBy,FDLastUpdOn,FTCreateBy,FDCreateOn)";
                $tSQL .= "VALUES ('$tPrjCode','$tPohDocNo',CONVERT(DATE, '$tDocDate', 103),'$tTitle','$tMdTotal',CONVERT(DATE,
         '$tPlanStart', 103),CONVERT(DATE,'$tPlanFinish', 103),'$tRefUrl','$tRemark', '$tStatus','$tProgress','$tUser',CURRENT_TIMESTAMP,'$tUser',CURRENT_TIMESTAMP)";
                $this->db->query($tSQL);

                if ($tGrand  > 0) {
                    $tSQL = "INSERT INTO TTSTPrjPoMd(FTPrjCode,FTPohDocNo,FCPodMdcSharp,FCPodMdPhp,FCPodMdAndroid,FCPodMdDev,FCPodMdTester,FCPodMdSa,
            FCPodMdPm,FCPodMdInterface,FCPodMdTotal,FDLastUpdOn,FTLastUpdBy)";
                    $tSQL .= "VALUES ('$tPrjCode','$tPohDocNo','$tMdcSharp','$tMdPhp','$tMdAndroid','$tMdDev','$tMdTester','$tMdSa','$tMdPm', '$tMdInterface','$tGrand',CURRENT_TIMESTAMP, '$tUser')";
                    $this->db->query($tSQL);
                }

                if ($this->db->affected_rows() > 0) {
                    return json_encode(['status' => true, 'message' => 'บันทึกข้อมูลสำเร็จ']);
                } else {
                    return json_encode(['status' => false, 'message' => 'ไม่สามารถบันทึกข้อมูลได้']);
                }
            }
        } catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
        }
    }
    /**
     * Functionality : Event Save Period 
     * Parameters : $aDataInsert
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : true or false
     * Return Type : text
     */
    public function FStMPOEventSavePeriod($aDataInsert)
    {

        $tDocNo         = $aDataInsert["FTPpoDocNo"];
        $tPeriodTitle   = $aDataInsert["FTPprTitle"];
        $tPeriodRemark  = $aDataInsert["FTPprRemark"];
        $tPeriodDate    = $aDataInsert["FDPprDate"];
        $tPeriodStatus  = $aDataInsert["FNPprStatus"];
        $tRefInv  = $aDataInsert["FTPocRefInv"];
        $tPrjCode  = $aDataInsert["FTPrjCode"];
        $tUser = get_cookie('TaskEmail');



        $tSQLCount = "SELECT MAX(FNPocSeqNo) as maxSeqNo FROM TTSTPrjPoCond WHERE FTPrjCode='$tPrjCode' AND FTPohDocNo='$tDocNo'";
        $nMaxId = $this->db->query($tSQLCount)->row_array();
        $nMax = $nMaxId['maxSeqNo'] + 1;

        $tSQL = "INSERT INTO TTSTPrjPoCond(FTPrjCode,FTPohDocNo,FNPocSeqNo,FTPocName,FDPocDueDate,FTPocRemark,FCPocPercentDone,FTPocRefInv,FTLastUpdBy)";
        $tSQL .= "VALUES ('$tPrjCode','$tDocNo', $nMax,'$tPeriodTitle',CONVERT(DATE,'$tPeriodDate', 103),'$tPeriodRemark','$tPeriodStatus','$tRefInv','$tUser')";
        $this->db->query($tSQL);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * Functionality : Event Delete Po
     * Parameters : $ptPrjCode
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : true or false
     * Return Type : text
     */
    public function FStMPODeletePo($ptPohDocNo, $ptPrjCode)
    {
        $tSqlDelete = "DELETE FROM  TTSTPrjPo WHERE FTPohDocNo ='$ptPohDocNo' AND FTPrjCode='$ptPrjCode' ";
        $this->db->query($tSqlDelete);
        if ($this->db->affected_rows() > 0) {

            $tSqlDeleteMd = "DELETE FROM  TTSTPrjPoMd WHERE FTPohDocNo ='$ptPohDocNo' AND FTPrjCode='$ptPrjCode' ";
            $this->db->query($tSqlDeleteMd);

            $tSqlCon = "DELETE FROM  TTSTPrjPoCond WHERE FTPohDocNo ='$ptPohDocNo' AND FTPrjCode='$ptPrjCode' ";
            $this->db->query($tSqlCon);
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * Functionality : Event Delete Po
     * Parameters : $ptPrjCode
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : true or false
     * Return Type : text
     */
    public function FStMPODeletePeriod($pPrjCode, $pPohDocNo, $pPocSeqNo)
    {
        $tSQL = "DELETE FROM  TTSTPrjPoCond WHERE FTPrjCode ='$pPrjCode' AND FTPohDocNo='$pPohDocNo' AND FNPocSeqNo='$pPocSeqNo' ";
        $this->db->query($tSQL);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    /**
     * Functionality : Event Update Period
     * Parameters : $pData
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : true or false
     * Return Type : text
     */
    public function FStMPOUpdatePeriod($pData)
    {
        $tPeriodNo     = $pData["tPeriodNo"];
        $tPeriodName   = $pData["tPeriodName"];
        $tPeriodDate   = $pData["dPeriodDate"];
        $tPeriodStatus = $pData["tPeriodStatus"];
        $tPeriodRemark = $pData['tPeriodRemark'];

        $tPocSeqNo = $pData['tPocSeqNo'];
        $tPohDocNo = $pData['tPohDocNo'];
        $tProjectNo = $pData['tProjectNo'];
        $FTPocRefInv = $pData['FTPocRefInv'];



        $tSQL = "UPDATE TTSTPrjPoCond SET FTPocName = '$tPeriodName',
        FDPocDueDate=CONVERT(DATE,'$tPeriodDate', 103),
        FCPocPercentDone='$tPeriodStatus',
        FTPocRemark='$tPeriodRemark',
         FTPocRefInv='$FTPocRefInv'

        WHERE  FTPrjCode ='$tProjectNo' AND FTPohDocNo='$tPohDocNo' AND FNPocSeqNo='$tPocSeqNo'";
        $this->db->query($tSQL);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }




    private function FStMCheckUpdatePoMd($ptPrjCode, $ptDocNo)
    {
        $tSQL = "SELECT FTPrjCode,FTPohDocNo FROM TTSTPrjPoMd WITH(NOLOCK) 
    WHERE FTPrjCode='$ptPrjCode' AND FTPohDocNo='$ptDocNo'";
        return  $this->db->query($tSQL)->num_rows();
    }



    /**
     * Functionality : Event Update Period
     * Parameters : $aDataUpdate
     * Creator : 01/11/20323 Boripat
     * Last Modified : 01/11/20323 Boripat
     * Return : true or false
     * Return Type : text
     */
    public function FStMPOUpdateProjectPO($aDataUpdate)
    {
        try {
            $tPoMdPhp       = $aDataUpdate["FCPrjPoMdPhp"];

            $tUser = get_cookie('TaskEmail');
            $tPoTitle       = $aDataUpdate["FTPohName"];
            $tPoDocNo       = $aDataUpdate["FTPrjPoDocNo"];
            $FTPrjCode      = $aDataUpdate['FTPrjCode'];

            $tMdcSharp      = $aDataUpdate["FCPrjPoMdcSharp"];

            $tPoMdDev       = $aDataUpdate["FCPrjPoMdDev"];
            $tMdTester      = $aDataUpdate["FCPodMdTester"];
            $tPoMdSa        = $aDataUpdate["FCPrjPoMdSa"];
            $tPoMdPm        = $aDataUpdate["FCPrjPoMdPm"];
            $tMdInterface   = $aDataUpdate["FCPrjPoMdInterface"];
            $tMdAndroid     = $aDataUpdate["FCPrjPoMdAndroid"];
            $tTotal = $aDataUpdate["FCPodMdTotal"];


            $tPoStatus      = $aDataUpdate["FTPrjPoStatus"];
            $tPoProgress    = trim($aDataUpdate["FTPrjPoProgress"]);
            $tPoRemark      = trim($aDataUpdate["FTPrjPoRemark"]);
            $tPoPlanStart   = trim($aDataUpdate["FDPrjPoPlanStart"]);
            $tPoPlanFinish  = trim($aDataUpdate["FDPrjPoPlanFinish"]);
            $tPoRefUrl      = trim($aDataUpdate["FTPrjPoRefUrl"]);
            $tPohDocDate      = trim($aDataUpdate["FDPohDocDate"]);

            $tSQL = "UPDATE TTSTPrjPo SET 
        FTPohName   =' $tPoTitle',
        FTPohStaDoc='$tPoStatus',
        FCPohPercentDone='$tPoProgress',
        FTPohRemark='$tPoRemark',
        FDPohStart=CONVERT(DATE,'$tPoPlanStart', 103),
        FDPohFinish=CONVERT(DATE,'$tPoPlanFinish', 103),
        FTPohRefUrl='$tPoRefUrl',
        FDPohDocDate=CONVERT(DATE,'$tPohDocDate', 103),
        FTLastUpdBy='$tUser'
        WHERE FTPohDocNo = '$tPoDocNo' AND FTPrjCode='$FTPrjCode'";
            $this->db->query($tSQL);
            $nCheckExist = $this->FStMCheckUpdatePoMd($FTPrjCode, $tPoDocNo);
            if ($nCheckExist > 0) {
                $tSQLUpdate = "UPDATE TTSTPrjPoMd 
                SET FCPodMdcSharp=CONVERT(float, '$tMdcSharp'),
                FCPodMdDev=CONVERT(float, '$tPoMdDev'),
                FCPodMdTester=CONVERT(float, '$tMdTester'),
                FCPodMdSa=CONVERT(float, '$tPoMdSa'),
                FCPodMdPm=CONVERT(float, '$tPoMdPm'),
                FCPodMdInterface=CONVERT(float, '$tMdInterface'),
                FCPodMdPhp=CONVERT(float, '$tPoMdPhp'),
                FCPodMdAndroid=CONVERT(float, '$tMdAndroid'),
                FCPodMdTotal=CONVERT(float, '$tTotal'),
                FTLastUpdBy='$tUser'
                WHERE FTPrjCode='$FTPrjCode' AND
                FTPohDocNo='$tPoDocNo'";
                $this->db->query($tSQLUpdate);
                if ($this->db->affected_rows() > 0) {
                    return json_encode(['status' => true]);
                }
            } else {
                $tSQLInsert = "INSERT INTO TTSTPrjPoMd(FTPrjCode,FTPohDocNo,FCPodMdcSharp
                ,FCPodMdDev,FCPodMdTester,FCPodMdSa,FCPodMdPm,FCPodMdInterface,FCPodMdTotal,FCPodMdPhp,FCPodMdAndroid,FTLastUpdBy,FDLastUpdOn
                ) VALUES('$FTPrjCode','$tPoDocNo', CONVERT(float, '$tMdcSharp'),CONVERT(float, '$tPoMdDev'),CONVERT(float, '$tMdTester'),
                CONVERT(float, '$tPoMdSa'),
                CONVERT(float, '$tPoMdPm'),
                CONVERT(float, '$tMdInterface'),
                CONVERT(float, '$tTotal'),
                CONVERT(float, '$tPoMdPhp'),
                CONVERT(float, '$tMdAndroid'),'$tUser',CURRENT_TIMESTAMP
                )";
                $this->db->query($tSQLInsert);
                if ($this->db->affected_rows() > 0) {
                    return json_encode(['status' => true, 'message' => 'อัพเดทสำเร็จ']);
                }
            }
        } catch (Exception $e) {
            echo 'message' . $e->getMessage();
        }
    }
}
