<?php defined('BASEPATH') or exit('No direct script access allowed');
class Skillrecord_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }

    public function FSxMSKRGetPaginationGrpSkill($aFilter)
    {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY GRP.FTSkgCode DESC) AS RowSkillID,
        GRP.FTSkgCode,GRP.FTSkgGrpName,GRP.FTDepCode,DEP.FTDepName FROM TCNMSkillGroup GRP WITH(NOLOCK)
        INNER JOIN TTSDepartment DEP WITH(NOLOCK) ON DEP.FTDepCode=GRP.FTDepCode
        WHERE ISNULL(GRP.FTDepCode,'') <> ''";

        //Filter แผนก
        if(isset($aFilter['tDevCode'])){
            $tDevCode = $aFilter['tDevCode'];
        }else{
            $tDevCode = '';
        }

        //Filter Like
        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }

        if($tDevCode != ''){
            $tSQL .= " AND DEP.FTDepCode = '$tDevCode' ";
        }

        if ($LikeSearch != '') {
            $tSQL .= " AND ((  GRP.FTSkgCode LIKE '%$LikeSearch%') 
                        OR (GRP.FTSkgGrpName LIKE '%$LikeSearch%'))  ";
        }

        $oQuery = $this->db->query($tSQL);

        return $oQuery->num_rows();

    }

    public function FSxMSKRGetGroupSkillList($aFilter)
    {
        $nTotalRecord = $this->FSxMSKRGetPaginationGrpSkill($aFilter);

        $nRecordsPerPage = 20;
        $total_pages = ceil($nTotalRecord / $nRecordsPerPage);
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
            $num_pages = (int) $num_pages;
        }

        $row_end = $nRecordsPerPage * $nPage;

        if ($row_end > $nTotalRecord) {
            $row_end = $nTotalRecord;
        }
        $tSQL = "SELECT * FROM ( ";
        $tSQL .= "SELECT ROW_NUMBER() OVER(ORDER BY GRP.FTSkgCode DESC) AS RowSkillID,
GRP.FTSkgCode,GRP.FTSkgGrpName,GRP.FTDepCode,DEP.FTDepName FROM TCNMSkillGroup GRP WITH(NOLOCK)
INNER JOIN TTSDepartment DEP WITH(NOLOCK) ON DEP.FTDepCode=GRP.FTDepCode
WHERE ISNULL(GRP.FTSkgCode,'') <> ''";


        //Filter แผนก
        if(isset($aFilter['tDevCode'])){
            $tDevCode = $aFilter['tDevCode'];
        }else{
            $tDevCode = '';
        }

        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }

        if($tDevCode != ''){
            $tSQL .= " AND DEP.FTDepCode = '$tDevCode' ";
        }

        if ($LikeSearch != '') {
            $tSQL .= " AND ((  GRP.FTSkgCode LIKE '%$LikeSearch%') 
                               OR (GRP.FTSkgGrpName LIKE '%$LikeSearch%'))  ";
        }

        $tSQL .= " ) C ";
        $tSQL .= " WHERE c.RowSkillID > $row_start AND c.RowSkillID <= $row_end ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {

            $aResult = array(
                'raItems' => $oQuery->result_array(),
                'total_record' => $nTotalRecord,
                'total_pages' => $total_pages,
                'current_page' => $nPage,
                'prev_page' => $prev_page,
                'next_page' => $next_page,
                'rtCode' => '200',
                'rtDesc' => 'success',
            );

        } else {

            $aResult = array(
                'rnAllRow' => 0,
                'total_record' => 0,
                'total_pages' => 0,
                'current_page' => 0,
                'prev_page' => 0,
                'next_page' => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );

        }
        return $aResult;
    }

    public function FSxMSKRGetPaginationSkill($aFilter)
    {
        $tSQL = "SELECT ROW_NUMBER() OVER(ORDER BY SKL.FTSkrCode  DESC) AS RowSkillID,
        SKL.FTSkrCode,SKL.FTSkrSkillName,SKL.FTSkgCode,GRP.FTSkgGrpName,DEP.FTDepName,SKL.FTRolCode,ROL.FTRolName
        FROM TCNMSkillRecord SKL WITH(NOLOCK)
        INNER JOIN TCNMSkillGroup GRP WITH(NOLOCK) ON SKL.FTSkgCode=GRP.FTSkgCode
        INNER JOIN TTSDepartment DEP WITH(NOLOCK) ON DEP.FTDepCode=GRP.FTDepCode
        LEFT JOIN TSysDevRole ROL WITH(NOLOCK) ON SKL.FTRolCode=ROL.FTRolCode
        WHERE ISNULL(SKL.FTSkrCode,'') <> '' ";


        //Filter แผนก
        if(isset($aFilter['tDevCode'])){
            $tDevCode = $aFilter['tDevCode'];
        }else{
            $tDevCode = '';
        }

        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }
        if($tDevCode != ''){
            $tSQL .= " AND DEP.FTDepCode = '$tDevCode' ";
        }
        if ($LikeSearch != '') {
            $tSQL .= " AND ((  SKL.FTSkrCode LIKE '$LikeSearch') 
                       OR (SKL.FTSkrSkillName LIKE '%$LikeSearch%')
                       OR (GRP.FTSkgGrpName LIKE '%$LikeSearch%')
                       OR (ROL.FTRolName  LIKE '%$LikeSearch%'))  ";
        }


        $oQuery = $this->db->query($tSQL);

        return $oQuery->num_rows();

    }


    public function FSxMSKRGetSkillList($aFilter)
    {
        $nTotalRecord = $this->FSxMSKRGetPaginationSkill($aFilter);

        $nRecordsPerPage = 20;
        $total_pages = ceil($nTotalRecord / $nRecordsPerPage);
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
            $num_pages = (int) $num_pages;
        }

        $row_end = $nRecordsPerPage * $nPage;

        if ($row_end > $nTotalRecord) {
            $row_end = $nTotalRecord;
        }

        $tSQL = "SELECT * FROM ( ";
        $tSQL .= "SELECT ROW_NUMBER() OVER(ORDER BY SKL.FTSkrCode  DESC) AS RowSkillID,
                    SKL.FTSkrCode,SKL.FTSkrSkillName,SKL.FTSkgCode,GRP.FTSkgGrpName,DEP.FTDepName,SKL.FTRolCode,
                    CASE 
                        WHEN ISNULL(SKL.FTRolCode, '') <> '99999' THEN ROL.FTRolName
                        ELSE 'All'
                    END AS FTRolName
                FROM TCNMSkillRecord        SKL WITH(NOLOCK)
                INNER JOIN TCNMSkillGroup   GRP WITH(NOLOCK) ON SKL.FTSkgCode   =   GRP.FTSkgCode
                INNER JOIN TTSDepartment    DEP WITH(NOLOCK) ON DEP.FTDepCode   =   GRP.FTDepCode
                LEFT JOIN TSysDevRole       ROL WITH(NOLOCK) ON SKL.FTRolCode   =   ROL.FTRolCode
                WHERE ISNULL(SKL.FTSkrCode,'') <> ''";

        //Filter แผนก
        if(isset($aFilter['tDevCode'])){
            $tDevCode = $aFilter['tDevCode'];
        }else{
            $tDevCode = '';
        }
        
        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }
        if($tDevCode != ''){
            $tSQL .= " AND DEP.FTDepCode = '$tDevCode' ";
        }
        if ($LikeSearch != '') {
            $tSQL .= " AND ((  SKL.FTSkrCode LIKE '$LikeSearch') 
                               OR (SKL.FTSkrSkillName LIKE '%$LikeSearch%')
                               OR (GRP.FTSkgGrpName LIKE '%$LikeSearch%')
                               OR (ROL.FTRolName  LIKE '%$LikeSearch%'))  ";
        }

        $tSQL .= " ) C ";
        $tSQL .= " WHERE c.RowSkillID > $row_start AND c.RowSkillID <= $row_end ";
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {

            $aResult = array(
                'raItems' => $oQuery->result_array(),
                'total_record' => $nTotalRecord,
                'total_pages' => $total_pages,
                'current_page' => $nPage,
                'prev_page' => $prev_page,
                'next_page' => $next_page,
                'rtCode' => '200',
                'rtDesc' => 'success',
            );

        } else {

            $aResult = array(
                'rnAllRow' => 0,
                'total_record' => 0,
                'total_pages' => 0,
                'current_page' => 0,
                'prev_page' => 0,
                'next_page' => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found',
            );

        }
        return $aResult;
    }
    public function FSxMSKRGetPaginationSkillDev($aFilter, $ptEmail)
    {
        $tSQL = "SELECT SKD.FTSkrCode,SKR.FTSkrSkillName,SKD.FTDevEmail,GRP.FTSkgGrpName,SKD.FNSkdSkillLev,ROL.FTRolCode,ROL.FTRolName
        FROM TCNTSkillDev SKD WITH(NOLOCK)
        INNER JOIN TCNMSkillRecord SKR WITH(NOLOCK) ON SKD.FTSkrCode = SKR.FTSkrCode
        INNER JOIN TCNMSkillGroup GRP WITH(NOLOCK) ON SKR.FTSkgCode = GRP.FTSkgCode
		LEFT JOIN TSysDevRole ROL WITH(NOLOCK) ON SKR.FTRolCode = ROL.FTRolCode
        WHERE SKD.FTDevEmail = '$ptEmail'";

        if (isset($aFilter['tDepCode'])) {
            $tDepCode = $aFilter['tDepCode'];
            $tSQL .= " AND GRP.FTDepCode = '$tDepCode' ";
        } else {
            $tDepCode = '';
        }
        if (isset($aFilter['tGrpCode'])) {
            $tGrpCode = $aFilter['tGrpCode'];
        } else {
            $tGrpCode = '';
        }

        if (isset($aFilter['tLevelCode'])) {
            $tLevelCode = $aFilter['tLevelCode'];
        } else {
            $tLevelCode = '';
        }


        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }

        if ($tGrpCode != '') {
            $tSQL .= " AND GRP.FTSkgCode = '$tGrpCode' ";
        }

        if ($tLevelCode != '') {
            $tSQL .= " AND SKD.FNSkdSkillLev= '$tLevelCode' ";
        }

        if ($LikeSearch != '') {
            $tSQL .= " AND ((  SKR.FTSkrCode LIKE '$LikeSearch') 
                    OR (SKR.FTSkrSkillName LIKE '%$LikeSearch%')
                    OR (GRP.FTSkgGrpName LIKE '%$LikeSearch%')
                    OR (ROL.FTRolName  LIKE '%$LikeSearch%'))  ";
        }


        $oQuery = $this->db->query($tSQL);

        return $oQuery->num_rows();

    }
    public function FSxMSKRGetSkillDev($aFilter, $ptEmail)
    {
        $nTotalRecord = $this->FSxMSKRGetPaginationSkillDev($aFilter, $ptEmail);

        $nRecordsPerPage = 20;
        $total_pages = ceil($nTotalRecord / $nRecordsPerPage);
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
            $num_pages = (int) $num_pages;
        }

        $row_end = $nRecordsPerPage * $nPage;

        if ($row_end > $nTotalRecord) {
            $row_end = $nTotalRecord;
        }
        $tSQL = "SELECT * FROM ( ";
        $tSQL .= "SELECT ROW_NUMBER() OVER(ORDER BY GRP.FTSkgGrpName ASC, SKD.FTSkrCode DESC) AS RowSkill,
        SKD.FTSkrCode,SKR.FTSkrSkillName,SKD.FTDevEmail,GRP.FTSkgGrpName,SKD.FNSkdSkillLev,ROL.FTRolCode,ROL.FTRolName
        FROM TCNTSkillDev SKD WITH(NOLOCK)
        INNER JOIN TCNMSkillRecord SKR WITH(NOLOCK) ON SKD.FTSkrCode = SKR.FTSkrCode
        INNER JOIN TCNMSkillGroup GRP WITH(NOLOCK) ON SKR.FTSkgCode = GRP.FTSkgCode
		LEFT JOIN TSysDevRole ROL WITH(NOLOCK) ON SKR.FTRolCode = ROL.FTRolCode
        WHERE SKD.FTDevEmail = '$ptEmail'";

        if (isset($aFilter['tDepSearch'])) {
            $tDepCode = $aFilter['tDepSearch'];
            $tSQL .= " AND GRP.FTDepCode = '$tDepCode' ";
        } else {
            $tDepCode = '';
        }
        if (isset($aFilter['tGrpCode'])) {
            $tGrpCode = $aFilter['tGrpCode'];
        } else {
            $tGrpCode = '';
        }
        if (isset($aFilter['tLevelCode'])) {
            $tLevelCode = $aFilter['tLevelCode'];
        } else {
            $tLevelCode = '';
        }

        if (isset($aFilter['LikeSearch'])) {
            $LikeSearch = $aFilter['LikeSearch'];
        } else {
            $LikeSearch = '';
        }
        if ($tGrpCode != '') {
            $tSQL .= " AND GRP.FTSkgCode = '$tGrpCode' ";
        }
        if ($tLevelCode != '') {
            $tSQL .= " AND SKD.FNSkdSkillLev= '$tLevelCode' ";
        }

        if ($LikeSearch != '') {
            $tSQL .= " AND ((  SKD.FTSkrCode LIKE '$LikeSearch') 
                       OR (SKR.FTSkrSkillName LIKE '%$LikeSearch%')
                       OR (GRP.FTSkgGrpName LIKE '%$LikeSearch%')
                       OR (ROL.FTRolName  LIKE '%$LikeSearch%'))  ";
        }

        $tSQL .= " ) C ";
        $tSQL .= " WHERE c.RowSkill > $row_start AND c.RowSkill <= $row_end ";
//		print_r($tSQL); die();
        $oQuery = $this->db->query($tSQL);

        if ($oQuery->num_rows() > 0) {

            $aResult = array(
                'raItems' => $oQuery->result_array(),
                'total_record' => $nTotalRecord,
                'total_pages' => $total_pages,
                'current_page' => $nPage,
                'prev_page' => $prev_page,
                'next_page' => $next_page,
                'rtCode' => '200',
                'rtDesc' => 'success',

            );

        } else {

            $aResult = array(
                'rnAllRow' => 0,
                'total_record' => 0,
                'total_pages' => 0,
                'current_page' => 0,
                'prev_page' => 0,
                'next_page' => 0,
                'rtCode' => '800',
                'rtDesc' => 'data not found'

            );

        }

        return $aResult;
    }


    // public function FSxMSKRAddGroupSkill(){

    // }

    public function FSxMSKRDeleteGroupSkill($ptGroupSkillID)
    {


        $SQLDT = "DELETE FROM TCNMSkillGroup 
                 WHERE FTSkgCode = '$ptGroupSkillID' ";

        $oQuery = $this->db->query($SQLDT);

    }

    public function FSxMSKRDeleteSkill($ptSkillID)
    {


        $SQLDT = "DELETE FROM TCNMSkillRecord 
                 WHERE FTSkrCode = '$ptSkillID' ";

        $oQuery = $this->db->query($SQLDT);

    }

    public function FSxMSKRDeleteMySkill($ptMySkillID, $ptMyEmail)
    {


        $SQLDT = "DELETE FROM TCNTSkillDev 
                 WHERE FTSkrCode = '$ptMySkillID' AND FTDevEmail = '$ptMyEmail'";

        $oQuery = $this->db->query($SQLDT);

    }



    public function FSxMSKRInsertGroupSkill($aDataInsert)
    {

        $tGroupskillname = trim($aDataInsert["oetGroupskillname"]);
        $tDevCode = trim($aDataInsert["oetDepCode"]);

        $tEmailUser = get_cookie('TaskEmail');
        $tSQL = "INSERT INTO TCNMSkillGroup(FTSkgGrpname, FDCreateOn ,FTCreateBy ,FDLastUpdOn ,FTLastUpdBy,FTDepCode)";
        $tSQL .= "VALUES ('$tGroupskillname',GETDATE(),'$tEmailUser',GETDATE(),'$tEmailUser','$tDevCode')";

        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }
    public function FSxMSKRInsertSkill($aDataInsert)
    {

        $tSkillname     = trim($aDataInsert["oetSkillName"]);
        $tGrpskillname  = trim($aDataInsert["ocmGroupSkillName"]);
        $tRoleskill     = trim($aDataInsert["ocmRoleSkill"]);
        $tDepCode       = trim($aDataInsert["oetDepCode"]);

        $tEmailUser = get_cookie('TaskEmail');
        $tSQL = "INSERT INTO TCNMSkillRecord(FTSkrSkillName,FTSkgCode,FTRolCode,FNSkrStaUse,FDCreateOn ,FTCreateBy ,FDLastUpdOn ,FTLastUpdBy, FTDepCode)";
        $tSQL .= "VALUES ('$tSkillname','$tGrpskillname','$tRoleskill','1',GETDATE(),'$tEmailUser',GETDATE(),'$tEmailUser', '$tDepCode')";


        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function FSxMSKRInsertMySkill($aDataInsert)
    {

        $tMySkillname = trim($aDataInsert["oetSkillName"]);
        $tLevelskill = trim($aDataInsert["ocmLevelSkill"]);

        $tEmailUser = get_cookie('TaskEmail');
        $tSQL = "INSERT INTO TCNTSkillDev(FTSkrCode,FTDevEmail,FNSkdSkillLev,FDCreateOn ,FTCreateBy ,FDLastUpdOn ,FTLastUpdBy)";
        $tSQL .= "VALUES ('$tMySkillname','$tEmailUser','$tLevelskill',GETDATE(),'$tEmailUser',GETDATE(),'$tEmailUser')";

        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function FSxMSKRGetDataGroupSkill($ptUsrDepCode)
    {
        $tSQL = "SELECT * FROM TCNMSkillGroup WITH(NOLOCK) WHERE FTDepCode = '$ptUsrDepCode'";
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

    public function FSxMSKRGetDataSkill()
    {
        $tSQL = "SELECT * FROM TCNMSkillRecord";
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

    public function FSxMSKRGetDataMySkill()
    {
        $tSQL = "SELECT * FROM TCNTSkillDev";
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

    public function FSxMSKRGetDataRole($tUsrDepCode)
    {
        $tSQL = "SELECT * FROM TSysDevRole
        WHERE FTDepCode ='$tUsrDepCode' ";
        // print_r($tSQL);
        // die();
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

    public function FSxMSKREditGroupSkill($ptGroupSkillID)
    {
        $tSQL = "SELECT * FROM TCNMSkillGroup
        WHERE FTSkgCode = '$ptGroupSkillID' ";
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

    public function FSxMSKREditSkill($ptSkillID)
    {
        $tSQL = "SELECT * FROM TCNMSkillRecord
        WHERE FTSkrCode = '$ptSkillID' ";
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

    public function FSxMSKREditMySkill($ptMySkillID, $ptEmail)
    {
        $tSQL = "SELECT * FROM TCNTSkillDev
        WHERE FTSkrCode = '$ptMySkillID' AND FTDevEmail = '$ptEmail'";
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

    public function FSxMSKRUpdateGroupSkill($aDataUpdate)
    {
        $tGroupskillcode = trim($aDataUpdate["oetGroupskillcode"]);
        $tGroupskillname = trim($aDataUpdate["oetGroupskillname"]);

        $tEmailUser = get_cookie('TaskEmail');
        $tSQL = "UPDATE TCNMSkillGroup SET   FTSkgGrpName = '$tGroupskillname' ,
                                            FDLastUpdOn = GETDATE(),
                                            FTLastUpdBy = '$tEmailUser'

                    WHERE  FTSkgCode= '$tGroupskillcode' ";


        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function FSxMSKRUpdateSkill($aDataUpdate)
    {
        $tSkillcode         = trim($aDataUpdate["oetSkillcode"]);
        $tSkillname         = trim($aDataUpdate["oetSkillname"]);
        $tGrpskillname      = trim($aDataUpdate["ocmGroupSkillName"]);
        $tRoleskill         = trim($aDataUpdate["ocmRoleSkill"]);
        $tSkillStatus       = trim($aDataUpdate["oetSkillStatus"]);
        $tDepCode           = trim($aDataUpdate["oetDepCode"]);


        $tEmailUser = get_cookie('TaskEmail');
        $tSQL = "UPDATE TCNMSkillRecord SET   FTSkrSkillName = '$tSkillname' ,
                                            FTSkgCode = '$tGrpskillname',
                                            FTRolCode = '$tRoleskill',
                                            FNSkrStaUse = '$tSkillStatus',
                                            FDLastUpdOn = GETDATE(),
                                            FTLastUpdBy = '$tEmailUser',
                                            FTDepCode = '$tDepCode'

                    WHERE  FTSkrCode= '$tSkillcode' ";


        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function FSxMSKRUpdateMySkill($aDataUpdate)
    {
        $tSkillcode = trim($aDataUpdate["oetSkillcode"]);
        // $tSkillname = trim($aDataUpdate["oetSkillname"]);
        $tLevelSkill = trim($aDataUpdate["ocmLevelSkill"]);



        $tEmailUser = get_cookie('TaskEmail');
        $tSQL = "UPDATE TCNTSkillDev SET   
                                            FNSkdSkillLev = '$tLevelSkill',
                                            FDLastUpdOn = GETDATE(),
                                            FTLastUpdBy = '$tEmailUser'

                    WHERE  FTSkrCode= '$tSkillcode' AND  FTDevEmail = '$tEmailUser' ";

        if ($this->db->query($tSQL)) {
            return 'success';
        } else {
            return 'error';
        }
    }


    public function FSxMSKRGetCountMySkillByEmail($oetSkillcode)
    {
        $tEmailUser = get_cookie('TaskEmail');

        $tSQL = "SELECT COUNT(*) AS RowSkill FROM TCNTSkillDev WHERE FTDevEmail = '$tEmailUser' AND  FTSkrCode = '$oetSkillcode' ";

        $oResult = $this->db->query($tSQL);

        return $oResult->result_array();
    }

    public function FSxMSKRGetGrpBySkill($nSkrcode)
    {
        $tSQL = "SELECT COUNT(*) AS RowSkill 
        FROM TCNMSkillRecord SKL INNER JOIN TCNMSkillGroup GRP ON SKL.FTSkgCode = GRP.FTSkgCode
        WHERE SKL.FTSkgCode = '$nSkrcode' ";

        $oResult = $this->db->query($tSQL);

        return $oResult->result_array();
    }

    public function FSxMSKRGetSkillBySkillDev($nSkrcode)
    {
        $tSQL = "SELECT COUNT(*) AS RowSkill 
        FROM TCNTSkillDev SKD 
		INNER JOIN TCNMSkillRecord SKL ON SKD.FTSkrCode = SKL.FTSkrCode
        WHERE SKD.FTSkrCode = '$nSkrcode' ";

        $oResult = $this->db->query($tSQL);

        return $oResult->result_array();
    }


    public function FSxMSKRRefreshAddMySkill($ptMyEmail)
    {
        $ptMyEmail = get_cookie('TaskEmail');

        $tSQL = "INSERT INTO TCNTSkillDev (FTSkrCode,FTDevEmail,FNSkdSkillLev,FDCreateOn,FTCreateBy,FDLastUpdOn,FTLastUpdBy)
        SELECT S.FTSkrCode AS SCode, '$ptMyEmail' AS FTUsrEmail , 0 , GETDAte(),'System',GETDAte(),'System'
        FROM TCNMSkillRecord S
        LEFT JOIN TCNTSkillDev D  ON 
        S.FTSkrCode = D.FTSkrCode AND D.FTDevEmail = '$ptMyEmail'
        WHERE ISNULL(D.FTSkrCode,'') = ''";



        $oQuery = $this->db->query($tSQL);
    }
    public function GetDepartment($dFilter)
        {
            $tSQL = "SELECT * FROM TTSDepartment ";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){

                $aResult 	= array(
                    'raItems'  	=> $oQuery->result_array(),
                    'rtCode'    => '200',
                    'rtDesc'   	=> 'success',
                );

                }else{

                $aResult = array(
                    'rnAllRow' 		=> 0,
                    'rtCode' 		=> '800',
                    'rtDesc' 		=> 'data not found',
                );

            }
            return $aResult;

        }


}
