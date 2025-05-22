<?php defined('BASEPATH') or exit('No direct script access allowed');
class Project_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }

    //หาจำนวนข้อมูลเพื่อนำไปแบ่งหน้า
    public function GetPaginationProject($aFilter)
    {
        //Filter รหัสโปรเจ็ค
        if (isset($aFilter['tPrjCode'])) {
            $tPrjCode = $aFilter['tPrjCode'];
        } else {
            $tPrjCode = '';
        }
        //Filter แผนก
        if (isset($aFilter['tDevCode'])) {
            $tDevCode = $aFilter['tDevCode'];
        } else {
            $tDevCode = '';
        }
        //Filter แผนก
        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }
        $tSQL = "SELECT  PRJ.FTPrjCode,PRJ.FTPrjName,DEV.FTDepName , DEV.FTDepCode, PRJ.FBPrjPoForce
            FROM TTSMPROJECT PRJ
            LEFT JOIN  TTSDepartment DEV ON PRJ.FTDepCode = DEV.FTDepCode
            WHERE ISNULL(PRJ.FTPrjCode,'') <> '' ";

        //Filter Data 

        if ($tPrjCode != '') {
            $tSQL .= " AND PRJ.FTPrjCode = '$tPrjCode' ";
        }

        if ($tDevCode != '') {
            $tSQL .= " AND DEV.FTDepCode = '$tDevCode' ";
        }

        if ($LikeSearch != '') {
            $tSQL .= " AND ((  PRJ.FTPrjCode LIKE '%$LikeSearch%') OR (PRJ.FTPrjName LIKE '%$LikeSearch%'))  ";
        }

        // echo $tSQL ;

        $oQuery = $this->db->query($tSQL);

        return $oQuery->num_rows();
    }

    //ดึงข้อมูล Project ทั้งหมด
    public function GetProject($aFilter)
    {
        //Filter รหัสโปรเจ็ค
        if (isset($aFilter['tPrjCode'])) {
            $tPrjCode = $aFilter['tPrjCode'];
        } else {
            $tPrjCode = '';
        }

        //Filter แผนก
        if (isset($aFilter['tDevCode'])) {
            $tDevCode = $aFilter['tDevCode'];
        } else {
            $tDevCode = '';
        }

        //Filter แผนก
        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }



        //Get All Record
        $nTotalRecord = $this->GetPaginationProject($aFilter);

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
                            PRJ.FTPrjCode,PRJ.FTPrjName,DEV.FTDepName ,PRJ.FTPrjStaUse, DEV.FTDepCode, PRJ.FBPrjPoForce
            FROM TTSMPROJECT PRJ
            LEFT JOIN  TTSDepartment DEV ON PRJ.FTDepCode = DEV.FTDepCode
            WHERE ISNULL(PRJ.FTPrjCode,'') <> '' ";

        //Filter Data 

        if ($tPrjCode != '') {
            $tSQL .= " AND PRJ.FTPrjCode = '$tPrjCode' ";
        }

        if ($tDevCode != '') {
            $tSQL .= " AND DEV.FTDepCode = '$tDevCode' ";
        }

        if ($LikeSearch != '') {
            $tSQL .= " AND ((  PRJ.FTPrjCode LIKE '%$LikeSearch%') OR (PRJ.FTPrjName LIKE '%$LikeSearch%'))  ";
        }

        $tSQL .= " ) C ";

        $tSQL .= " WHERE c.RowID > $row_start AND c.RowID <= $row_end ";



        // echo $tSQL ;

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

    //Get Department List
    public function GetDepartment($dFilter)
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

    public function CheckDuplicateProject($ptPrjCode)
    {

        $tSQL = "SELECT * FROM TTSMPROJECT WHERE FTPrjCode = '$ptPrjCode' ";
        $oQuery = $this->db->query($tSQL);
        return $oQuery->num_rows();
    }

    // Get Last Project Code Running
    public function GetLastPrjCodeRunning($aFilter)
    {

        if (isset($aFilter["tDepCode"])) {
            $tDepCode = $aFilter["tDepCode"];
        } else {
            $tDepCode = '';
        }

        $tCYear = substr(date('Y'), 2); //หาปีปัจจุบัน

        $tSQL = "SELECT TOP 1 RIGHT(FTPrjCode,3) AS FTPrjCode 
                             FROM TTSMProject 
                             WHERE  LEFT(RIGHT(FTPrjCode,5),2) = '$tCYear'
                             AND FTDepCode = '$tDepCode' 
                             ORDER BY FDCreateOn DESC ";

        $oQuery = $this->db->query($tSQL);

        $Items = $oQuery->result_array();

        if (isset($Items[0]['FTPrjCode'])) {
            $IDLast = $Items[0]['FTPrjCode'] + 1;
        } else {
            $IDLast = 1;
        }

        return $IDLast;
    }

    // Save New Project
    public function SaveNewProject($aDataInsert)
    {
        $tPrjCode = trim($aDataInsert["tPrjCode"]);
        $tPrjName = trim($aDataInsert["tPrjName"]);
        $tDevCode = trim($aDataInsert["tDevCode"]);
        $nPrjStaUse = trim($aDataInsert["nPrjStaUse"]);
        $bPrjPoForce = trim($aDataInsert["bPrjPoForce"]);
        $tSQL = "INSERT INTO TTSMPROJECT(FTPrjCode,FTPrjName,FTDepCode,FTPrjStaUse,FDCreateOn, FBPrjPoForce)";
        $tSQL .= "VALUES ('$tPrjCode','$tPrjName','$tDevCode','$nPrjStaUse',GETDATE(), '$bPrjPoForce')";
        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    // Delete Project
    public function DeleteProject($ptPrjCode)
    {
        $tSQL = "DELETE FROM  TTSMProject WHERE FTPrjCode ='$ptPrjCode' ";
        $this->db->query($tSQL);
    }

    // Update Project
    public function UpdateProject($aDataUpdate)
    {
        $tPrjCode = trim($aDataUpdate["tPrjCode"]);
        $tPrjName = trim($aDataUpdate["tPrjName"]);
        $tDevCode = trim($aDataUpdate["tDevCode"]);
        $nPrjStaUse = trim($aDataUpdate["nPrjStaUse"]);
        $bPrjPoForce = trim($aDataUpdate["bPrjPoForce"]);
        $tSQL = "UPDATE TTSMProject 
                SET FTPrjName = '$tPrjName',
                    FTPrjStaUse ='$nPrjStaUse', 
                    FBPrjPoForce = '$bPrjPoForce' 
                
                WHERE  FTPrjCode = '$tPrjCode' ";

        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }
}
