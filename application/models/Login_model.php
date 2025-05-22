<?php defined('BASEPATH') or exit('No direct script access allowed');
class Login_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }
    //ตรวจสอบ email และ รหัสผ่าน
    public function FindEmailAndPassword($tEmail, $tPassword)
    {
        $this->load->library('encryption');
        $tSQL = "SELECT FTDevName,FTDevAlwCreatePrj,FTDepCode,FTDevPass
             FROM TTSDevTeam WHERE FTDevEmail = '$tEmail'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $data=$oQuery->result_array();
             $decypt = $this->encryption->decrypt($data[0]['FTDevPass']);
            if ($tPassword==$decypt) {
                $aResult     = array(
                    'raItems'      => $oQuery->result_array(),
                    'rtCode'    => '200',
                    'rtDesc'       => 'success',
                );
            } else {
                $aResult = array(
                    'raItems'      => array(),
                    'rtCode'         => '800',
                    'rtDesc'         => 'data not found',
                );
            }
        } else {
            //not found
            $aResult = array(
                'raItems'      => array(),
                'rtCode'         => '800',
                'rtDesc'         => 'data not found',
            );
        }
        return $aResult;
    }

    public function savePassword($tPassword)
    {
        $tEmail = get_cookie('TaskEmail');

        $tSQL = "UPDATE TTSDevTeam set FTDevPass = '$tPassword' where FTDevEmail='$tEmail'";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery) {
            //found
            $aResult     = array(
                'rtCode'    => '200',
                'rtDesc'       => 'success',
            );
        } else {

            //not found
            $aResult = array(
                'raItems'      => array(),
                'rtCode'         => '800',
                'rtDesc'         => 'data not found',
            );
        }
        return $aResult;
    }


    //ตรวจสอบ email
    public function FindEmailByUser($tEmail)
    {

        $tSQL = "SELECT FTDevName,FTDevAlwCreatePrj,FTDepCode,FTDevPass, FTDevCode
                     FROM TTSDevTeam WHERE FTDevEmail = '$tEmail' ";

        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {
            //found
            $aResult     = array(

                'raItems'      => $oQuery->result_array(),
                'rtCode'    => '200',
                'rtDesc'       => 'success',
            );
        } else {

            //not found
            $aResult = array(
                'raItems'      => array(),
                'rtCode'         => '800',
                'rtDesc'         => 'data not found',
            );
        }
        return $aResult;
    }
    //เพิ่มข้อมูลสมาชิก
    public function InsertMember($aDataInsert)
    {

        $oetName            = trim($aDataInsert["oetName"]);
        $oetNickname        = trim($aDataInsert["oetNickname"]);
        $oetEmail           = trim($aDataInsert["oetEmail"]);
        $oetLine            = trim($aDataInsert["oetLine"]);
        $oetTeam            = trim($aDataInsert["oetTeam"]);
        $oetDepCode         = trim($aDataInsert["oetDepCode"]);
        $tRoleName          = trim($aDataInsert["osmRoleName"]);
        $tStartdate         = trim($aDataInsert["oetRegEdtShwStartDate"]);
        $tEnddate           = trim($aDataInsert["oetRegEdtShwEndDate"]);
        $tWorkPlan          = trim($aDataInsert["oetWorkPlan"]);
        $tProvince          = trim($aDataInsert["osmProvince"]);
        $tLatLong           = trim($aDataInsert["oetLatLong"]);

        $tRoleadmin          = trim($aDataInsert["ocbroleadmin"]);
        $tActive         = trim($aDataInsert["ockactive"]);




        if ($tRoleadmin != NULL || $tRoleadmin != "") {
            $tRoleadmin = $tRoleadmin;
        } else {
            $tRoleadmin = 1;
        }
        //Get ข้อมูลรหัสก่อนหน้ามาก่อน
        $tSQLSeleteID = "SELECT TOP 1 RIGHT(FTDevCode,3) AS FTDevCode FROM TTSDevTeam 
                             WHERE  FTDepCode = '$oetDepCode' 
                             ORDER BY FDCreateOn DESC ";

        $oQuery = $this->db->query($tSQLSeleteID);

        $Items = $oQuery->result_array();

        if (isset($Items[0]['FTDevCode'])) {
            $IDLast = $Items[0]['FTDevCode'] + 1;
        } else {
            $IDLast = 1;
        }

        $tCYear = substr(date('Y'), 2); //หาปีปัจจุบัน
        $prefix = $oetDepCode . '' . $tCYear;
        $tFormatCode = sprintf($prefix . '%03d', $IDLast);

        $tSQL = "INSERT INTO TTSDevTeam ( FTDevCode, FTDevName, FTDevNickName, FTDevEmail, FTDevLineUsrID , FTDevStaActive , 
                                            FTDevGrpTeam, FTDepCode,FDCreateOn, FTDevRole, FDDevDateStart, FDDevDateResign,
                                            FTDevPlanWFH, FTDevProvince, FTDevGPSLatLong,FTDevAlwCreatePrj)";
        $tSQL .= "VALUES ('$tFormatCode','$oetName','$oetNickname','$oetEmail','$oetLine','$tActive','$oetTeam','$oetDepCode',GETDATE(),
                            '$tRoleName', '$tStartdate', '$tEnddate', '$tWorkPlan', '$tProvince', '$tLatLong','$tRoleadmin')";

        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    //ข้อมูลสมาชิก
    public function GetDataMember($memberID)
    {
        $tSQL = "SELECT * FROM TTSDevTeam WHERE FTDevCode = '$memberID' ";
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

    //แก้ไขข้อมูลสมาชิก
    public function EditMember($aDataUpdate)
    {
        $idcode         = trim($aDataUpdate["idcode"]);
        $oetName        = trim($aDataUpdate["oetName"]);
        $oetNickname    = trim($aDataUpdate["oetNickname"]);
        $oetEmail       = trim($aDataUpdate["oetEmail"]);
        $oetLine        = trim($aDataUpdate["oetLine"]);
        $oetTeam        = trim($aDataUpdate["oetTeam"]);
        $oetDepCode     = trim($aDataUpdate["oetDepCode"]);
        $ockactive      = trim($aDataUpdate["ockactive"]);
        $tRoleName      = trim($aDataUpdate["osmRoleName"]);
        $tStartdate     = trim($aDataUpdate["oetRegEdtShwStartDate"]);
        $tEnddate       = trim($aDataUpdate["oetRegEdtShwEndDate"]);
        $tWorkPlan      = trim($aDataUpdate["oetWorkPlan"]);
        $tProvince      = trim($aDataUpdate["osmProvince"]);
        $tLatLong       = trim($aDataUpdate["oetLatLong"]);
        $tRoleadmin     = trim($aDataUpdate["ocbroleadmin"]);

        // if($tRoleadmin != 1 ) {
        //     $tRoleadmin = NULL;
        // }else{
        //     $tRoleadmin = $tRoleadmin;
        // }

        if ($tEnddate == '') {
            $tEnddate = NULL;
        } else {
            $tEnddate = $tEnddate;
        }

        $tSQL = "UPDATE TTSDevTeam SET 
                        FTDevName           = '$oetName', 
                        FTDevNickName       = '$oetNickname', 
                        FTDevEmail          = '$oetEmail', 
                        FTDevLineUsrID      = '$oetLine', 
                        FTDevStaActive      = '$ockactive', 
                        FTDevGrpTeam        = '$oetTeam', 
                        FTDepCode           = '$oetDepCode',
                        FTDevRole           = '$tRoleName',
                        FDDevDateStart      = '$tStartdate',
                        FDDevDateResign     = '$tEnddate',
                        FTDevPlanWFH        = '$tWorkPlan',
                        FTDevProvince       = '$tProvince',
                        FTDevGPSLatLong     = '$tLatLong',
                        FTDevAlwCreatePrj   = '$tRoleadmin' 
                    WHERE FTDevCode = '$idcode' ";

        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    //ข้อมูลแผนก
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

    // Save New Project
    public function SaveNewProject($aDataInsert)
    {

        $tPrjCode = trim($aDataInsert["tPrjCode"]);
        $tPrjName = trim($aDataInsert["tPrjName"]);
        $tDevCode = trim($aDataInsert["tDevCode"]);

        $tSQL = "INSERT INTO TTSMPROJECT(FTPrjCode,FTPrjName,FTDepCode)";
        $tSQL .= "VALUES ('$tPrjCode','$tPrjName','$tDevCode')";

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

 // Update ResetPasswordValidate
 public function ResetPasswordValidate($aDataUpdate)
 {

     
    
     $tSQL = "UPDATE TTSDevTeam SET FTDevPass = ''
                                       
                 WHERE  FTDevEmail = '$aDataUpdate' ";

     if ($this->db->query($tSQL)) {
         return 'success';
     } else {
         return 'error';
     }
 }


    // Update Project
    public function UpdateProject($aDataUpdate)
    {

        $tPrjCode = trim($aDataUpdate["tPrjCode"]);
        $tPrjName = trim($aDataUpdate["tPrjName"]);
        $tDevCode = trim($aDataUpdate["tDevCode"]);

        $tSQL = "UPDATE TTSMProject SET FTPrjName = '$tPrjName',
                                           FTDepCode = '$tDevCode' 
                    WHERE  FTPrjCode = '$tPrjCode' ";

        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    //ข้อมูลตำแหน่ง
    public function GetDataDevRole($ptDepCode)
    {
        $tDepCode = $ptDepCode;

        if ($tDepCode != '') {
            $tWhere = " AND FTDepCode = '" . $tDepCode . "'";
        } else {
            $tWhere = "";
        }
        $tSQL = "SELECT * FROM TSysDevRole WHERE 1 = 1" . $tWhere;
        // print_r($tSQL);
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

    //ข้อมูลจังหวัด
    public function GetDataProvince()
    {
        $tSQL = "SELECT * FROM TSysProvince_L WHERE FNLngID = 1";
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
    public function GetDataHolidays()
    {
        $tYear = date('Y');
        $tSQL = "SELECT FTHolidayName AS holidayName, FDHolidayStart AS holidayStart, FDHolidayEnd AS holidayEnd FROM THRSHolidays WHERE YEAR(FDHolidayStart) = '$tYear'";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'raItems' => $oQuery->result_array(),
                'rtCode' => '200',
                'rtDesc' => 'success',
            );
        } else {
            $aResult = array(
                'rnAllRow' => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );
        }
        return $aResult;
    }
}
