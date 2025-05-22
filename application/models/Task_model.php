<?php defined('BASEPATH') or exit('No direct script access allowed');
class Task_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }

    public function GetTask($ptEmail, $dFilter)
    {
        $tSQL = "
                            WITH difference_in_seconds AS (
                                SELECT
                                FTTskID,
                                DATEDIFF(SECOND, FDTskStart, FDTskStop) AS seconds
                                FROM TTSTTaskHis
                            ),
                            differences AS (
                                SELECT
                                FTTskID,
                                seconds,
                                seconds % 60 AS seconds_part,
                                seconds % 3600 AS minutes_part,
                                seconds % (3600 * 24) AS hours_part
                                FROM difference_in_seconds
                            )
                            SELECT TOP 30 T.*,E.EfDAY,E.EfHours,E.EfMinutes FROM (
                            SELECT  T.FTTskID
                                    ,T.FTTskName,
                                    T.FTTskRemark,
                                    T.FTTskRemarkEnd
                                    ,T.FTTskStatus
                                    ,P.FTPrjName
                                    ,T.FTPrjCode
                                    ,T.FTPoCode
                                    ,PO.FTPoRelease
                                    ,convert(varchar, T.FDTskStart , 103) AS FTTskDateStart
                                    ,LEFT(convert(varchar, T.FDTskStart , 24),5) AS FTTskTimeStart
                                    ,Format(cast(FDTskStart as datetime),'dd-MMM-yyyy HH:mm:ss','th') AS FDTskStart
                                    ,Format(cast(FDTskFinish as datetime),'dd-MMM-yyyy HH:mm:ss','th') AS FDTskFinish
                                    ,(SELECT COUNT(FTPoCode) FROM TTSTProjectPo WHERE FTPrjCode = T.FTPrjCode) AS FNCountPo
                            FROM TTSTTask T
                            INNER JOIN TTSMProject P ON T.FTPrjCode = P.FTPrjCode
                            LEFT JOIN TTSTProjectPo PO ON PO.FTPoCode = T.FTPoCode
                            WHERE FTUsrEmail = '$ptEmail' 
                            AND   CONVERT(varchar(10),FDTskStart,121) = '$dFilter' ) T
                            LEFT JOIN (
                                    SELECT A.FTTskID
                                            ,SUM(A.EfDAY) AS EfDAY 
                                            ,SUM(A.EfHours) AS EfHours 
                                            ,SUM(A.EfMinutes) AS EfMinutes 
                                    FROM (
                                    SELECT
                                    FTTskID,
                                        CAST(CONCAT(FLOOR(seconds / 3600 / 24), '') AS float) AS EfDAY,
                                        CAST(CONCAT(FLOOR(hours_part / 3600), '' ) AS float) AS EfHours,
                                        CAST(CONCAT(FLOOR(minutes_part / 60), '') AS float) AS EfMinutes
                                    FROM differences   )  A GROUP BY A.FTTskID 
                            ) E ON T.FTTskID = E.FTTskID  ORDER BY T.FDTskStart DESC  ";

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
    // Summary เวลาทำงานรวมของวันปัจจุบัน
    public function SummaryTimeByDate($ptEmail, $dFilter)
    {
        $tSQL = "WITH difference_in_seconds AS (
                SELECT
                FTTskID,
                DATEDIFF(SECOND, FDTskStart, FDTskStop) AS seconds
                FROM TTSTTaskHis
                ),
                differences AS (
                SELECT
                FTTskID,
                seconds,
                seconds % 60 AS seconds_part,
                seconds % 3600 AS minutes_part,
                seconds % (3600 * 24) AS hours_part
                FROM difference_in_seconds
                )
                SELECT SUM(E.EfDAY) AS EfDAY,SUM(E.EfHours) AS EfHours , SUM(E.EfMinutes) AS EfMinutes FROM (
                SELECT T.FTTskID,T.FTTskName,T.FTTskRemark,T.FTTskStatus,P.FTPrjName
                            ,CONVERT(VARCHAR(17),T.FDTskStart,13) AS FDTskStart
                            ,CONVERT(VARCHAR(17),T.FDTskFinish,13) AS FDTskFinish
                            FROM TTSTTask T
                            INNER JOIN TTSMProject P ON T.FTPrjCode = P.FTPrjCode
                            WHERE FTUsrEmail = '$ptEmail'
                            AND    CONVERT(VARCHAR(10) , FDTskStart,121) = '$dFilter'
                            AND    FTTskStatus = '3'
                            ) T
                LEFT JOIN (
                    SELECT A.FTTskID
                            ,SUM(A.EfDAY) AS EfDAY 
                            ,SUM(A.EfHours) AS EfHours 
                            ,SUM(A.EfMinutes) AS EfMinutes 
                    FROM (
                    SELECT
                    FTTskID,
                        CAST(CONCAT(FLOOR(seconds / 3600 / 24), '') AS float) AS EfDAY,
                        CAST(CONCAT(FLOOR(hours_part / 3600), '' ) AS float) AS EfHours,
                        CAST(CONCAT(FLOOR(minutes_part / 60), '') AS float) AS EfMinutes
                    FROM differences   )  A GROUP BY A.FTTskID 
                ) E ON T.FTTskID = E.FTTskID ";

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


    //รายชื่อโปรเจคทั้งหมด
    public function GetProject()
    {

        $tUsrEmail = get_cookie('TaskEmail');

        $tSQL = " SELECT * FROM TTSMProject PRJ
                    WHERE FTDepCode = (
                    SELECT FTDepCode from TTSDevTeam WHERE FTDevEmail = '$tUsrEmail'
                    ) AND PRJ.FTPrjStaUse='1'
                    ORDER BY FTPrjCode DESC ";
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

    //เพิ่มข้อมูลงาน
    public function Createnewtask($email, $projectid, $detail, $remark, $ptPhaseCode, $ptPoCode)
    {
        $tSQL = " INSERT INTO TTSTTask (FTUsrEmail,FTPrjCode,FTPshCode,FTTskName,FTTskRemark, FTPoCode) VALUES ";
        $tSQL .= " ('" . $email . "','" . $projectid . "','" . $ptPhaseCode . "','" . $this->db->escape_str($detail) . "','" . $this->db->escape_str($remark) . "','" . $ptPoCode . "')";
        $this->db->query($tSQL);

        $aTaskWStart = $this->GetTaskWaitStart($email);

        $taskID = $aTaskWStart['raItems'][0]['FTTskID'];

        $this->StartTask($email, $taskID);

        $this->SetCurrentDateFilter();

        if ($taskID) {
            $aResult = array(
                'rtCode'    => '200',
                'rtDesc'    => 'Task created successfully',
            );
        } else {
            $aResult = array(
                'rtCode'    => '800',
                'rtDesc'    => 'Error in creating task',
            );
        }
        return $aResult;
    }

    public function CheckCreateTask($ptUsrEmail)
    {

        $tSQLDelete = " DELETE FROM TTSTTask 
            WHERE FTUsrEmail = '$ptUsrEmail' 
            AND (FTPrjCode IS NULL OR FTPrjCode = '')";
        $this->db->query($tSQLDelete);

        $tSQL = "  SELECT count(FTTskID) AS nCountTskStart from TTSTTask 
                       WHERE FTTskStatus IN (1,2)
                       AND FTUsrEmail = '$ptUsrEmail' ";


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

    public function CheckStartTask($ptUsrEmail)
    {

        $tSQL = "  SELECT count(FTTskID) AS nCountTskStart from TTSTTask 
                       WHERE FTTskStatus IN (1)
                       AND FTUsrEmail = '$ptUsrEmail' ";


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

    public function GetTaskWaitStart($ptUsrEmail)
    {

        $tSQL = "  SELECT FTTskID  
                       FROM TTSTTask 
                       WHERE ISNULL(FTTskStatus,'') = '' 
                       AND FTUsrEmail = '$ptUsrEmail' ";


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

    public function PauseTask($ptUsrEmail, $ptTaskID)
    {

        $SQLP = "UPDATE TTSTTask SET FTTskStatus = 2 
                        WHERE FTUsrEmail = '$ptUsrEmail'  
                        AND FTTskID = '$ptTaskID' ";

        $oQuery = $this->db->query($SQLP);



        $SQLU = "UPDATE TTSTTaskHis 
                        SET FDTskStop = FORMAT(GETDATE(),'yyyy-MM-dd HH:mm') 
                        WHERE FTTskID = '$ptTaskID'  ";
        $oQuery = $this->db->query($SQLU);
    }

    public function StartTask($ptUsrEmail, $ptTaskID)
    {

        $SQLP = "UPDATE TTSTTask SET FTTskStatus = 1 
                     WHERE FTUsrEmail = '$ptUsrEmail'  
                     AND FTTskID = '$ptTaskID' ";

        $oQuery = $this->db->query($SQLP);

        $SQLStartT = "UPDATE TTSTTask SET FDTskStart = FORMAT(GETDATE(),'yyyy-MM-dd HH:mm')
                     WHERE FTUsrEmail = '$ptUsrEmail'  
                     AND FTTskID = '$ptTaskID' 
                     AND ISNULL(FDTskStart,'') = '' ";

        $oQuery = $this->db->query($SQLStartT);



        $SQLI = "INSERT INTO TTSTTaskHis (FTTskID,FDTskStart) VALUES ('$ptTaskID',FORMAT(GETDATE(),'yyyy-MM-dd HH:mm')) ";
        $oQuery = $this->db->query($SQLI);
    }

    public function FinishTask($ptUsrEmail, $ptTaskID, $ptTaskRmk, $dTskStart, $dTskFinish)
    {

        // if($ptTaskRmk ==''){
        //     $Remark_data = ' FTTskRemark ';
        // }else{

        //        $SQLR = "SELECT ISNULL(FTTskRemark,'') AS FTTskRemark  FROM TTSTTask
        //                 WHERE FTUsrEmail = '$ptUsrEmail'  
        //                 AND FTTskID = '$ptTaskID' ";

        //        $oQuery = $this->db->query($SQLR);
        //        $aRmkRes = $oQuery->result_array();

        //        if($aRmkRes[0]['FTTskRemark'] == ''){
        //           $Remark_data = " ' $ptTaskRmk ' ";
        //        }else{
        //           $Remark_data = " FTTskRemark + ' $ptTaskRmk' ";
        //        }
        // }

        //echo $ptUsrEmail.'>'.$ptTaskID.'>'.$ptTaskRmk.'>'.$dTskStart.'>'.$dTskFinish;

        $SQLP = "UPDATE TTSTTask SET FTTskStatus = 3 , 
                 FDTskStart = '$dTskStart',
                 FDTskFinish = '$dTskFinish',
                 FTTskRemarkEnd ='" . $this->db->escape_str($ptTaskRmk) . "'
                 WHERE FTUsrEmail = '$ptUsrEmail'  
                 AND FTTskID = '$ptTaskID' ";

        // echo $SQLP;

        $oQuery = $this->db->query($SQLP);



        $SQLU = "UPDATE TTSTTaskHis 
                        SET FDTskStart = '$dTskStart',
                        FDTskStop = '$dTskFinish'
                        WHERE FTTskID = '$ptTaskID'
                        AND ISNULL(FDTskStop,'') = '' ";
        $oQuery = $this->db->query($SQLU);
    }

    public function DeleteTask($ptUsrEmail, $ptTaskID)
    {

        $SQLDT = "DELETE FROM TTSTTask
                 WHERE FTUsrEmail = '$ptUsrEmail'  
                 AND FTTskID = '$ptTaskID' ";

        $oQuery = $this->db->query($SQLDT);

        $SQLDH = "DELETE FROM TTSTTaskHis
                 WHERE FTTskID = '$ptTaskID' ";

        $oQuery = $this->db->query($SQLDH);
    }

    public function CopyTask($ptUsrEmail, $ptTaskID)
    {

        $aCheckCreateTask = $this->CheckCreateTask($ptUsrEmail);

        if ($aCheckCreateTask['raItems'][0]['nCountTskStart'] > 0) {

            return 'error';
        } else {

            $tSQL = " INSERT INTO TTSTTask (FTUsrEmail,FTPrjCode,FTTskName,FTTskRemark,FTTskStatus,FTPoCode,FBPrjPoForce) ";
            $tSQL .= " SELECT FTUsrEmail,FTPrjCode,FTTskName,FTTskRemark , 1 ,FTPoCode,FBPrjPoForce";
            $tSQL .= " FROM TTSTTask WHERE FTTskID = '$ptTaskID' AND  FTUsrEmail = '$ptUsrEmail' ";

            $oQuery = $this->db->query($tSQL);

            $tSQLH = " INSERT INTO TTSTTaskHis (FTTskID,FDTskStart) ";
            $tSQLH .= " SELECT FTTskID, FORMAT(GETDATE(),'yyyy-MM-dd HH:mm') ";
            $tSQLH .= " FROM TTSTTask WHERE FTUsrEmail = '$ptUsrEmail'  AND ISNULL(FDTskStart,'') = ''   ";

            $oQuery = $this->db->query($tSQLH);


            $SQLStartT = "UPDATE TTSTTask SET FDTskStart = FORMAT(GETDATE(),'yyyy-MM-dd HH:mm')
            WHERE FTUsrEmail = '$ptUsrEmail'  
            AND ISNULL(FDTskStart,'') = '' ";

            $oQuery = $this->db->query($SQLStartT);

            $this->SetCurrentDateFilter();

            return 'success';
        }
    }

    public function InsertFilter($tUsrEmail, $dFilter)
    {

        $tSQL = "SELECT * FROM TTSTFilter WHERE FTUsrEmail = '$tUsrEmail'";
        $oQuery = $this->db->query($tSQL);
        $aCheckFilter = $oQuery->result_array();

        if ($aCheckFilter[0]['FTUsrEmail'] == '') {

            $tSQL_Insert = "INSERT INTO TTSTFilter (FTUsrEmail,FDFltDate,FDFltLastFilter) 
          VALUES ('$tUsrEmail','$dFilter',GETDATE()) ";
            $oQuery = $this->db->query($tSQL_Insert);
        } else {

            $tSQL_Update = " UPDATE TTSTFilter SET FDFltDate = '$dFilter' , FDFltLastFilter =  GETDATE()
                             WHERE FTUsrEmail = '$tUsrEmail'";
            $oQuery = $this->db->query($tSQL_Update);
        }
    }

    public function GetFilter($tUsrEmail)
    {

        $tSQL = "SELECT * FROM TTSTFilter WHERE FTUsrEmail = '$tUsrEmail'";
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

    public function SetCurrentDateFilter()
    {

        $dFilter = date('Y-m-d');
        $tUsrEmail = get_cookie('TaskEmail');
        $this->InsertFilter($tUsrEmail, $dFilter);
    }

    public function GetTimeCrad($tUsrEmail)
    {

        $dCurrentDate = date('Y-m-d');

        $tSQL = "SELECT LEFT(convert(varchar, FDTadChkIn, 24),5) AS FDTadChkIn,
                        LEFT(convert(varchar, FDTadBreakOut, 24),5) AS FDTadBreakOut,
                        LEFT(convert(varchar, FDTadChkOut, 24),5) AS FDTadChkOut
                 FROM TTATTimeCard 
                 WHERE FTUsrEmail = '$tUsrEmail'
                 AND   CONVERT(varchar(10),FDTadChkIn,121) = '$dCurrentDate' ";

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

    //ตรวจสอบการเข้างาน
    public function TimeCardCheckForgetCheckOut()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $tSQL = "SELECT * FROM TTATTimeCard 
                 WHERE FTUsrEmail = '$tUsrEmail' 
                 AND ISNULL(FDTadChkOut,'')='' ";
        $oQuery = $this->db->query($tSQL);
        $nRows = $oQuery->num_rows();
        if ($nRows > 0) {
            $this->TimeCardCheckOUTAll();
        }
        return $nRows;
    }


    public function TimeCardCheckOUTAll()
    {

        $tUsrEmail = get_cookie('TaskEmail');
        $tSQL = "UPDATE  TTATTimeCard SET FDTadChkOut = CONVERT(VARCHAR(10) , FDTadChkIn , 121)+' 23:59:59'
                 WHERE   FTUsrEmail = '$tUsrEmail' 
                 AND     ISNULL(FDTadChkOut,'')='' ";
        $oQuery = $this->db->query($tSQL);
    }

    // บันทึกการเข้างาน
    public function TimeCardCheckIN()
    {

        $tUsrEmail = get_cookie('TaskEmail');

        $tSQL = "INSERT INTO TTATTimeCard (FTUsrEmail,FDTadChkIn) VALUES ('$tUsrEmail',GETDATE())";
        $oQuery = $this->db->query($tSQL);

        $this->CheckInSendLine(1);
    }

    // บันทึกพักเบรก
    public function TimeCardTakeBreak()
    {

        $tUsrEmail = get_cookie('TaskEmail');

        $tSQL = "UPDATE TTATTimeCard SET FDTadBreakOut = GETDATE()
                 WHERE FTUsrEmail = '$tUsrEmail' 
                 AND   CONVERT(VARCHAR(10) , FDTadChkIn , 121) = CONVERT(VARCHAR(10) , GETDATE() , 121)";
        $oQuery = $this->db->query($tSQL);
    }

    // บันทึกออกงาน
    public function TimeCardCheckOut()
    {

        $tUsrEmail = get_cookie('TaskEmail');

        $tSQL = "UPDATE TTATTimeCard SET FDTadChkOut = GETDATE()
                 WHERE FTUsrEmail = '$tUsrEmail' 
                 AND CONVERT(VARCHAR(10) , FDTadChkIn , 121) = CONVERT(VARCHAR(10) , GETDATE() , 121) ";

        $oQuery = $this->db->query($tSQL);

        $this->CheckInSendLine(2);
    }

    function CheckInSendLine($ptActionType)
    {

        $tUsrEmail = get_cookie('TaskEmail');

        // $tSQL = "SELECT FTDevName FROM TTSDevTeam WHERE FTDevEmail = '$tUsrEmail' ";
        $tSQL   = "SELECT TEAM.FTDevName , DEP.FTDepLineToken
                    FROM TTSDevTeam         TEAM    WITH (NOLOCK) 
                    LEFT JOIN TTSDepartment DEP     WITH (NOLOCK) ON TEAM.FTDepCode = DEP.FTDepCode
                    WHERE TEAM.FTDevEmail = '$tUsrEmail' ";
        $oQuery = $this->db->query($tSQL);
        $aRes   = $oQuery->result_array();

        $tDevName   = $aRes[0]['FTDevName'];
        $tLineToken = $aRes[0]['FTDepLineToken'];

        $tSQLT  = "SELECT  LEFT(convert(varchar, FDTadChkIn, 24),8) AS FDTadChkIn
                         ,LEFT(convert(varchar, FDTadChkOut, 24),8) AS FDTadChkOut
                  FROM    TTATTimeCard 
                  WHERE   FTUsrEmail = '$tUsrEmail' 
                  AND     CONVERT(VARCHAR(10) , FDTadChkIn , 121) = CONVERT(VARCHAR(10) , GETDATE() , 121) ";
        $oQueryT = $this->db->query($tSQLT);

        if ($oQueryT->num_rows() > 0) {
            $aResT      = $oQueryT->result_array();
            $tClockIn   =  $aResT[0]['FDTadChkIn'];
            $tClockOut  = $aResT[0]['FDTadChkOut'];
        } else {
            $tClockIn   =  date('H:i:s');
            $tClockOut  = '';
        }

        if ($ptActionType == '1') {
            // $tUrl = 'https://script.google.com/macros/s/AKfycbxQl9iQRigVKlqDafsxCAbgdEIdmZWnShEMJKQL1RzsodkDMk7BnUreyUQrSfPnnoZB/exec?action=AddClockInOut';
            $tUrl       = 'https://script.google.com/macros/s/AKfycbzygGoG5shQVAl0LjI23b0MRgaP4AbulIQy7tKxliIMakRzHM-oLQpII82xB_pqjMTJ/exec?action=IN';
            $tClockIn   = date('H:i:s');
            $tClockOut  = '';
        } else {
            // $tUrl = 'https://script.google.com/macros/s/AKfycbwYQ7cYY4LTCh5SfPKy_5HxXnzaNMNB3AURwprXkxrc-e0JSIXMbHKriTAqrN1MAnT03g/exec?action=AddTimecard';
            $tUrl       = 'https://script.google.com/macros/s/AKfycbzygGoG5shQVAl0LjI23b0MRgaP4AbulIQy7tKxliIMakRzHM-oLQpII82xB_pqjMTJ/exec?action=OUT';
            $tClockIn   = $tClockIn;
            $tClockOut  = date('H:i:s');
        }

        $curl = curl_init();

        $fields = array(
            'WorkDate'  => date('d/m/Y'),
            'DevName'   => $tDevName,
            'ClockIn'   => $tClockIn,
            'ClockOut'  => $tClockOut,
            'Remark'    => '',
            'Approve'   => '',
            'LineToken' => $tLineToken
        );

        // print_r($fields); exit;
        $fields_string = json_encode($fields);

        // print_r($fields_string);

        // $fields_string = http_build_query($fields);

        curl_setopt($curl, CURLOPT_URL, $tUrl);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
            )
        );

        $data = curl_exec($curl);

        // print_r($data);

        curl_close($curl);
    }

    // Get Phase
    // Create By : Napat(Jame) 10/04/2023
    public function FSaMGetPhase()
    {

        $tUsrEmail = get_cookie('TaskEmail');
        $tSQL = "   SELECT [FTPshCode],[FTPrjCode],[FTPshName],[FTRPshDesc],[FTDepCode]
                    FROM TTSMPhase WITH(NOLOCK) 
                    WHERE FTDepCode = (SELECT FTDepCode from TTSDevTeam WHERE FTDevEmail = '$tUsrEmail') ";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
                'aItems'      => $oQuery->result_array(),
                'tCode'    => '200',
                'tDesc'       => 'success',
            );
        } else {
            $aResult = array(
                'tCode'    => '800',
                'tDesc'    => 'data not found',
            );
        }
        return $aResult;
    }

    public function FSaMTSKGetReleaseByPrjCode($ptPrjCode)
    {
        try {
            $tSQL = "SELECT FTPoCode, FTPrjCode, FTPoRelease 
                FROM [TaskTracker].[dbo].[TTSTProjectPo] WITH(NOLOCK)
                WHERE FTPrjCode = '$ptPrjCode'
                GROUP By FTPoCode,FTPrjCode,  FTPoRelease
            ";
            // dbug($tSQL);
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $aResult = array(
                    'raItems'   => $oQuery->result_array(),
                    'rtCode'    => '200',
                    'rtDesc'    => 'Success',
                );
            } else {
                $aResult = array(
                    'rtCode'    => '800',
                    'rtDesc'    => 'data not found',
                );
            }
            return $aResult;
        } catch (Exception $e) {
            return array('tCode' => '500', 'tDesc' => 'Server Error : ' . $e->getMessage());
        }
    }

	public function FSaMTSKUpdatePOByTaskID($ptTaskID,$ptPoCode)
	{
		try {
			$this->db->set('FTPoCode', $ptPoCode);
			$this->db->where('FTTskID', $ptTaskID);
			$this->db->update('TTSTTask');

			// dbug($tSQL);
			if ($this->db->affected_rows() > 0) {
				$aResult = array(
					'rtCode'    => '200',
					'rtDesc'    => 'Success',
				);
			} else {
				$aResult = array(
					'rtCode'    => '800',
					'rtDesc'    => 'cannot update data',
				);
			}
			return $aResult;
		} catch (Exception $e) {
			return array('tCode' => '500', 'tDesc' => 'Server Error : ' . $e->getMessage());
		}
	}
}
