<?php defined('BASEPATH') or exit('No direct script access allowed');
class Leave_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        ini_set("memory_limit", -1);
    }
    public function FSxMLEVLeaveDataLeave()
    {
        $tSQL = "SELECT 
            HLS.*, DT.FTDevName, LST.FTLvtName, DT.FTDevGrpTeam  , Pvn.FTPvnName , DPM.FTDepName
            FROM THRTLeaveHis HLS WITH (NOLOCK)
            LEFT JOIN TTSDevTeam DT WITH (NOLOCK) ON HLS.FTLvhDevCode = DT.FTDevCode
            LEFT JOIN THRSLeaveType LST  WITH (NOLOCK) ON HLS.FTLvhType = LST.FTLvtCode
            LEFT JOIN TTSDepartment DPM  WITH (NOLOCK) ON DT.FTDepCode = DPM.FTDepCode
            LEFT JOIN TSysProvince_L Pvn  WITH (NOLOCK) ON HLS.FTLvhPvnCode = Pvn.FTPvnCode 
            AND Pvn.FNLngID = '1'
            ";

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
        
        
public function FSxMLEVLeaveDataAddLeave($aData)
{
    $tUsrEmail = get_cookie('TaskEmail');     
    $this->db->select('FTDevCode, FTDevAlwCreatePrj');
    $this->db->where('FTDevEmail', $tUsrEmail);
    $query = $this->db->get('TTSDevTeam');
    $this->load->helper('date');

    if ($query->num_rows() > 0) {
        $row = $query->row();
        $tDevCode = $row->FTDevCode;
        $tAdmin = $row->FTDevAlwCreatePrj;
    } else {
        $tDevCode = '';
        $tAdmin = ''; 
    }

  
    $tAddTypeCode = $this->input->post('ocmLSAddType');
    $dAddDateFrom = strtotime(str_replace('/', '-',$this->input->post('odpLSAddDateFromHidden')));
    $dAddDateTo = strtotime(str_replace('/', '-',$this->input->post('odpLSAddDateToHidden')));
    $tAddRemark = $this->input->post('otaLSAddRemark');  
    $tAcm   = $aData['FTLvhAttachFile'];   
    $tAddProvince = $this->input->post('ocmLSAddProvince');
    $cAddDayQty = $this->input->post('oetLSAddDayQty');   
    $nAddHR = $this->input->post('ocmAddNameHr');
    $this->db->select_max('FTLvhCode', 'tLastCode');
    $this->db->like('FTLvhCode', 'HL', 'after'); 
    $query = $this->db->get('THRTLeaveHis');
    $tLastCode = $query->row()->tLastCode;
    if ($tLastCode) {
        $tNewCode = 'HL' . str_pad((int) substr($tLastCode, 2) + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $tNewCode = 'HL0001';
    }
    $this->db->where('FTLvhDevCode', $tDevCode);
    // $this->db->where('FTLvhStaApv', 1);
    $this->db->where('FTLvhType !=', 'A');
    $this->db->where('FTLvhType != ', 0);
    $this->db->where('FTLvhStaApv', 2);
    $this->db->group_start();
    $this->db->or_where('FDLvhDateFrom <=', date('Y-m-d H:i:s', $dAddDateTo));
    $this->db->where('FDLvhDateTo >=', date('Y-m-d H:i:s', $dAddDateFrom));
    $this->db->or_group_start();
    $this->db->where('FDLvhDateFrom <=', date('Y-m-d H:i:s', $dAddDateTo));
    $this->db->where('FDLvhDateTo >=', date('Y-m-d H:i:s', $dAddDateTo));
    $this->db->group_end();
    $this->db->group_end();
    $query = $this->db->get('THRTLeaveHis');

    // echo $this->db->last_query();
    if ($query->num_rows() > 0) {
        $aResult = array(
            'rtCode' => '800',
            'rtDesc' => 'กรุณาตรวจสอบรายการของท่านอีกครั้งเนื่องจากมีการลาที่ทับซ้อนกัน',
        );
        echo json_encode($aResult);
        return;
    }
    
    $aDataToInsert = array(
        'FTLvhCode' => $tNewCode,
        'FTLvhDevCode' => $tDevCode,
        'FTLvhType' => $tAddTypeCode,
        'FDLvhDateFrom' => date('Y-m-d H:i:s', $dAddDateFrom),
        'FDLvhDateTo' => date('Y-m-d H:i:s', $dAddDateTo),
        'FTLvhRemark' => $tAddRemark,
        'FTLvhPvnCode' => $tAddProvince,
        'FTLvhAttachFile' => $tAcm, 
        'FTLvhStaApv' => 1,
        'FTLvhCreateBy' => $tDevCode,
        'FDLvhCreateOn' => date('Y-m-d H:i:s'),
        'FTLvhLastUpdBy' => $tDevCode,
        'FDLvhLastUpdOn' => date('Y-m-d H:i:s'),
        'FCLvhDayQty' => $cAddDayQty,
    );
            if ($nAddHR !== "" && $nAddHR !== null && $tAdmin == 3) {
            $aAutoInsertApproveHR = array(
            'FTLvhCode' => $tNewCode,
            'FTLvhDevCode' => $nAddHR,
            'FTLvhType' => $tAddTypeCode,
            'FDLvhDateFrom' => date('Y-m-d H:i:s', $dAddDateFrom),
            'FDLvhDateTo' => date('Y-m-d H:i:s', $dAddDateTo),
            'FTLvhRemark' => "$tAddRemark",
            'FTLvhComment' => "Human Resources Update Approval",
            'FTLvhPvnCode' => $tAddProvince,
            'FTLvhAttachFile' => $tAcm,
            'FTLvhStaApv' => 2,
            'FTLvhApvBy' => "$tDevCode",
            'FTLvhCreateBy' => $tDevCode,
            'FDLvhCreateOn' => date('Y-m-d H:i:s'),
            'FTLvhLastUpdBy' => $tDevCode,
            'FDLvhLastUpdOn' => date('Y-m-d H:i:s'),
            'FCLvhDayQty' => $cAddDayQty,
        );
        $this->db->insert('THRTLeaveHis', $aAutoInsertApproveHR);
    }
    else if ($tAdmin == 3) {
        $aAutoInsertApprove = array(
            'FTLvhCode' => $tNewCode,
            'FTLvhDevCode' => $tDevCode,
            'FTLvhType' => $tAddTypeCode,
            'FDLvhDateFrom' => date('Y-m-d H:i:s', $dAddDateFrom),
            'FDLvhDateTo' => date('Y-m-d H:i:s', $dAddDateTo),
            'FTLvhRemark' => "$tAddRemark",
            'FTLvhComment' => "AutoApprove",
            'FTLvhPvnCode' => $tAddProvince,
            'FTLvhAttachFile' => $tAcm,
            'FTLvhStaApv' => 2,
            'FTLvhApvBy' => "$tDevCode",
            'FTLvhCreateBy' => $tDevCode,
            'FDLvhCreateOn' => date('Y-m-d H:i:s'),
            'FTLvhLastUpdBy' => $tDevCode,
            'FDLvhLastUpdOn' => date('Y-m-d H:i:s'),
            'FCLvhDayQty' => $cAddDayQty,
        );
        $this->db->insert('THRTLeaveHis', $aAutoInsertApprove);
    } else {
        $this->db->insert('THRTLeaveHis', $aDataToInsert);
    }

    if ($this->db->affected_rows() > 0) {
        $aResult = array(
            'rtCode' => '200',
            'rtDesc' => 'บันทึกการลางานเรียบร้อย',
            'hasAttachment' => isset($aDataToInsert['FTLvhAttachFile']) && !empty($aDataToInsert['FTLvhAttachFile'])
        );
    } else {
        $aResult = array(
            'rtCode' => '800',
            'rtDesc' => 'เกิดข้อผิดพลาดในการบันทึกการลาโปรดติดต่อเจ้าหน้าที่',
        );
    }
    echo json_encode($aResult);
}

    public function FSxMLEVLeaveDataType()
    {
        $tSQL = "SELECT * FROM THRSLeaveType";
        $oQuery = $this->db->query($tSQL);
        if ($oQuery->num_rows() > 0) {
            $aResult = array(
            'raItems' => $oQuery->result_array(),
            'rtCode' => '200',
            'rtDesc' => 'success',
        );
    }   
    else {
            $aResult = array(
            'rnAllRow' => 0,
            'rtCode' => '800',
            'rtDesc' => 'data not found',
        );
    }
    return $aResult;
    }

    public function FSxMLEVLeaveDataProvince()
    {
        $tSQL = "SELECT FTPvnCode, FTPvnName FROM TSysProvince_L WHERE FNLngID = '1'";
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

    public function FSxMLEVLeaveDataDepartment()
    {
        $tUsrDepCode = get_cookie('UsrDepCode');  
        $tSQL = "SELECT FTDepName FROM TTSDepartment WHERE FTDepCode = '$tUsrDepCode'";
        $oQuery = $this->db->query($tSQL);


        if ($oQuery->num_rows() > 0) {
            $aResult = array(
            'raItems' => $oQuery->result_array(),
            'rtCode' => '200',
            'rtDesc' => 'success',
        );
        }   
        else {
            $aResult = array(
            'rnAllRow' => 0,
            'rtCode' => '800',
            'rtDesc' => 'data not found',
        );
        }
        return $aResult;
   
    }


    public function FSxMLEVLeaveDataLeaveTeam()

{
    $tUsrDepCode = get_cookie('UsrDepCode'); 
    $tSQL ="SELECT DISTINCT TTSDevTeam.FTDevGrpTeam 
    FROM TTSDevTeam 
    JOIN TTSDepartment DPM ON TTSDevTeam.FTDepCode = DPM.FTDepCode
    WHERE TTSDevTeam.FTDevGrpTeam IS NOT NULL AND TTSDevTeam.FTDevGrpTeam != '' 
    AND TTSDevTeam.FTDevGrpTeam != 'DELETE'
    AND (DPM.FTDepCode = '$tUsrDepCode' OR '$tUsrDepCode' = '00001')";
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

public function FSxMLEVLeaveDataLeaveName()
{
    $tUsrDepCode = get_cookie('UsrDepCode');
    $tSQL = "SELECT FTDevCode,FTDevName
    FROM TTSDevTeam
    JOIN TTSDepartment DPM ON TTSDevTeam.FTDepCode = DPM.FTDepCode 
    WHERE (DPM.FTDepCode = '$tUsrDepCode' OR '$tUsrDepCode' = '00001')
    AND TTSDevTeam.FTDevGrpTeam != 'DELETE' ";
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

    public function FSxMLEVLeaveGetDevNameByTeam() {
        $tTeam = $this->input->post('selectedTeam');
        $query = $this->db->query("SELECT DISTINCT FTDevCode,FTDevName FROM TTSDevTeam WHERE FTDevGrpTeam = ? AND FTDevGrpTeam != 'DELETE'", array($tTeam));
        $tDevName = $query->result_array();
        $options = '<option value="">ทั้งหมด</option>';
        foreach($tDevName as $tDevNames) {
            $options .= '<option value="'.$tDevNames['FTDevCode'].'">'.$tDevNames['FTDevName'].'</option>';
        }
        echo $options;
    }
    

public function FSxMLEVLeaveDataApproveLeave($FTLvhCode, $key0) 
{
    $tUsrEmail = get_cookie('TaskEmail');     
    $tSQL = "SELECT FTDevCode FROM TTSDevTeam 
    WHERE FTDevEmail = '$tUsrEmail'";
    $oQuery = $this->db->query($tSQL);
   
    if ($oQuery->num_rows() > 0) {
        $row = $oQuery->row();
        $tDevCode = $row->FTDevCode;

        $dCurrentDateTime = date('Y-m-d H:i:s');
        if (!empty($FTLvhCode)) {
            $otaComment = $this->input->post('otaComment' . $key0);
            $tSQL = "UPDATE THRTLeaveHis SET FTLvhStaApv = 2, FTLvhApvBy = '$tDevCode'
            , FDLvhLastUpdOn = '$dCurrentDateTime', FTLvhComment = '$otaComment' 
            WHERE FTLvhCode = '$FTLvhCode'";
            $this->db->query($tSQL);

            if ($this->db->affected_rows() > 0) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    } else {
        return 'error'; 
    }
    }

public function FSxMLEVLeaveDataUpdate($FTLvhCode,$ocmLSUpdateType,$odpLSUpdateDateFrom,$odpLSUpdateDateTo,
$ocmLSUpdateProvince,$otaLSUpdateRemark,$oflAttachment,$oetLSUpdateDayQty,$FTLvhStaApv)
{
    $oldFilePath = $this->Leave_model->FSxMLEVLeaveDeleteFilePath($FTLvhCode);
    if ($oflAttachment) {
        if ($oldFilePath) {
            unlink(FCPATH . $oldFilePath);
        }
        $tUpdateDateFrom = str_replace('/', '-',$odpLSUpdateDateFrom);
        $tUpdateDateTo = str_replace('/', '-',$odpLSUpdateDateTo);
        $data = array(
            'FTLvhType' => $ocmLSUpdateType,
            'FDLvhDateFrom' => date('Y-m-d', strtotime($tUpdateDateFrom)),
            'FDLvhDateTo' => date('Y-m-d', strtotime($tUpdateDateTo)),
            'FTLvhPvnCode' => $ocmLSUpdateProvince,
            'FTLvhRemark' => $otaLSUpdateRemark,
            'FTLvhAttachFile' => $oflAttachment,
            'FCLvhDayQty' => $oetLSUpdateDayQty
        );
    } else {
        $tUpdateDateFrom = str_replace('/', '-',$odpLSUpdateDateFrom);
        $tUpdateDateTo = str_replace('/', '-',$odpLSUpdateDateTo);
        $data = array(
            'FTLvhType' => $ocmLSUpdateType,
            'FDLvhDateFrom' => date('Y-m-d', strtotime($tUpdateDateFrom)),
            'FDLvhDateTo' => date('Y-m-d', strtotime($tUpdateDateTo)),
            'FTLvhPvnCode' => $ocmLSUpdateProvince,
            'FTLvhRemark' => $otaLSUpdateRemark,
            'FCLvhDayQty' => $oetLSUpdateDayQty
        );
    }

    $this->db->where('FTLvhCode', $FTLvhCode);
    $this->db->update('THRTLeaveHis', $data);
    return ($this->db->affected_rows() > 0) ? 'success' : 'error';
}

    public function FSxMLEVLeaveDeleteFilePath($FTLvhCode)
    {
        $tSQL = "SELECT FTLvhAttachFile FROM THRTLeaveHis WHERE FTLvhCode = ?";
        $query = $this->db->query($tSQL, array($FTLvhCode));
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->FTLvhAttachFile;
        } else {
            return false;
        }
    }
    public function FSxMLEVLeaveDataDenyLeave($FTLvhCode, $key0) 
    {
        $tUsrEmail = get_cookie('TaskEmail');     
        $tSQL = "SELECT FTDevCode FROM TTSDevTeam WHERE FTDevEmail = '$tUsrEmail'";
        $oQuery = $this->db->query($tSQL);
       
        if ($oQuery->num_rows() > 0) {
            $row = $oQuery->row();
            $tDevCode = $row->FTDevCode;
    
            $dCurrentDateTime = date('Y-m-d H:i:s');
            if (!empty($FTLvhCode)) {
                $otaComment = $this->input->post('otaComment' . $key0);
                $tSQL = "UPDATE THRTLeaveHis SET FTLvhStaApv = 4, FTLvhApvBy = '$tDevCode'
                , FDLvhLastUpdOn = '$dCurrentDateTime', FTLvhComment = '$otaComment' 
                WHERE FTLvhCode = '$FTLvhCode'";
                $this->db->query($tSQL);
    
                if ($this->db->affected_rows() > 0) {
                    return 'success';
                } else {
                    return 'error';
                }
            } else {
                return 'error';
            }
        } else {
            return 'error'; 
        }
        }
        public function FSxMLEVLeaveDataRollback($FTLvhCode) 
        {
            $tUsrEmail = get_cookie('TaskEmail');     
            $tSQL = "SELECT FTDevCode FROM TTSDevTeam WHERE FTDevEmail = '$tUsrEmail'";
            $oQuery = $this->db->query($tSQL);
            if ($oQuery->num_rows() > 0) {
                $row = $oQuery->row();
                $tDevCode = $row->FTDevCode;
                $dCurrentDateTime = date('Y-m-d H:i:s');
                if (!empty($FTLvhCode)) {
                    $tSQL = "UPDATE THRTLeaveHis SET FTLvhStaApv = 1, FTLvhApvBy = '$tDevCode'
                    , FDLvhLastUpdOn = '$dCurrentDateTime'
                    WHERE FTLvhCode = '$FTLvhCode'";
                    $this->db->query($tSQL);
        
                    if ($this->db->affected_rows() > 0) {
                        return 'success';
                    } else {
                        return 'error';
                    }
                } else {
                    return 'error';
                }
            } else {
                return 'error'; 
            }
            }


    public function FSxMLEVLeaveDataCancle($FTLvhCode)
        {
    $tUsrEmail = get_cookie('TaskEmail');     
    $this->db->select('FTDevCode');
    $this->db->where('FTDevEmail', $tUsrEmail);
    $query = $this->db->get('TTSDevTeam');
   
    if ($query->num_rows() > 0) {
        $row = $query->row();
        $tDevCode = $row->FTDevCode;

        $currentDateTime = date('Y-m-d H:i:s');
        if (!empty($FTLvhCode)) {          
            $tSQL = "UPDATE THRTLeaveHis SET FTLvhStaApv = 3
            , FTLvhApvBy = '$tDevCode'
            , FDLvhLastUpdOn = '$currentDateTime' 
            WHERE FTLvhCode = '$FTLvhCode'";
            $this->db->query($tSQL);
            if ($this->db->affected_rows() > 0) {
                return 'success';
            } else {
                return 'error';
            }
        } else {
            return 'error';
        }
    } else {
        return 'error'; 
    }
}

public function FSxMLEVLeaveDataGetUserInfo($ptUserEmail)
{
    $tUser = "SELECT FTDevName FROM TTSDevTeam WHERE FTDevEmail = '$ptUserEmail' ";
    $oQuery = $this->db->query($tUser);
    if ($oQuery->num_rows() > 0) {
        return $oQuery->row_array();
    } else {
        return null;
    }
}
public function FSxCLEVLeaveDataAdminAutoApprove($ptUserEmail)
{
    $tUser = "SELECT FTDevAlwCreatePrj FROM TTSDevTeam WHERE FTDevEmail = '$ptUserEmail' ";
    $oQuery = $this->db->query($tUser);
    if ($oQuery->num_rows() > 0) {
        return $oQuery->row_array();
    } else {
        return null;
    }
}
public function FSxMLEVLeaveDataCheckLeaveHistory($ptUserEmail)
{
    $tUser = "
        SELECT *
        FROM TTSDevTeam
        WHERE TTSDevTeam.FTDevEmail = '$ptUserEmail'
    ";
    $oQuery = $this->db->query($tUser);
    if ($oQuery->num_rows() > 0) {
        $userInfo = $oQuery->row_array();
        $pendingLeave = $this->db->get_where('THRTLeaveHis', array('FTLvhDevCode' => $userInfo['FTDevCode'], 'FTLvhStaApv' => 1));
        $userInfo['hasPendingLeave'] = ($pendingLeave->num_rows() > 0);
        return $userInfo;
    } else {
        return null;
    }
}

public function FSxMLEVLeaveGetPagination($ptSQL) {
    $oQuery = $this->db->query($ptSQL);
    return $oQuery->num_rows();
}


public function FSxMLEVLeaveDataGetLeave($aFilter) {
    $tUsrEmail = get_cookie('TaskEmail');     
	$this->db->select('FTDevCode');
	$this->db->where('FTDevEmail', $tUsrEmail);
	$query = $this->db->get('TTSDevTeam');


	if(isset($aFilter['nStatus'])){
		$nStatus = $aFilter['nStatus'];
	}else{
		$nStatus = '';
	}
	if(isset($aFilter['tType'])){
		$tType = $aFilter['tType'];
	}else{
		$tType = '';
	}

	if(isset($aFilter['dStartDate'])){
		$dStartDate = $aFilter['dStartDate'];
	}else{
		$dStartDate = '';
	}
	if(isset($aFilter['dEndDate'])){
		$dEndDate = $aFilter['dEndDate'];
	}else{
		$dEndDate = '';
	}

	$tSQL1 = "SELECT
    ROW_NUMBER() OVER(ORDER BY HLS.FDLvhCreateOn DESC) AS RowID,
    HLS.*, DT.FTDevName, LST.FTLvtName, DT.FTDevEmail AS DT_FTDevEmail, PVN.FTPvnName, DT.FTDevGrpTeam,
    DTA.FTDevName AS FTLvhApvByName
        FROM THRTLeaveHis HLS
        LEFT JOIN TTSDevTeam DTA ON HLS.FTLvhApvBy = DTA.FTDevCode
        LEFT JOIN TTSDevTeam DT ON HLS.FTLvhDevCode = DT.FTDevCode
        LEFT JOIN THRSLeaveType LST ON HLS.FTLvhType = LST.FTLvtCode
        LEFT JOIN TSysProvince_L PVN ON HLS.FTLvhPvnCode = PVN.FTPvnCode AND PVN.FNLngID = '1'
        WHERE ISNULL(HLS.FTLvhCode, '') <> '' 
    AND DT.FTDevEmail = '$tUsrEmail'
 
    	";
	if (!empty($nStatus)) {
		$tSQL1 .= " AND HLS.FTLvhStaApv = '$nStatus'";
	}
	if (!empty($tType)) {
		$tSQL1 .= " AND HLS.FTLvhType = '$tType'";
	}

if (!empty($dStartDate)) {
    $dStartDateTime = DateTime::createFromFormat('d/m/Y', $dStartDate);
    if ($dStartDateTime !== false) {
        $dStartDateTime = $dStartDateTime->format('Y-m-d');
        $tSQL1 .= " AND HLS.FDLvhDateFrom >= '$dStartDateTime'";
    } else {       
    }
}
if (!empty($dEndDate)) {
    $dEndDateTime = DateTime::createFromFormat('d/m/Y', $dEndDate);
    if ($dEndDateTime !== false) {
        $dEndDateTime = $dEndDateTime->format('Y-m-d');
        $tSQL1 .= " AND HLS.FDLvhDateTo <= '$dEndDateTime'";
    } else {
    }
}
	$nTotalRecord = $this->FSxMLEVLeaveGetPagination($tSQL1);
    $nRecordsPerPage = 10;
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
        $nNum_page = 1;
    } else if (($nTotalRecord % $nRecordsPerPage) == 0) {
        $nNum_page = ($nTotalRecord / $nRecordsPerPage);
    } else {
        $nNum_page = ($nTotalRecord / $nRecordsPerPage) + 1;
        $nNum_page = (int)$nNum_page;
    }

    $row_end = $nRecordsPerPage * $nPage;

    if ($row_end > $nTotalRecord) {
        $row_end = $nTotalRecord;
    }
    $tSQL2 = "SELECT * FROM ( ";
	$tSQL2 .= $tSQL1;
    $tSQL2 .= " ) C ";
    $tSQL2 .= " WHERE c.RowID > $row_start AND c.RowID <= $row_end ";
    $oQuery = $this->db->query($tSQL2);

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
    } 
    else 
    {
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

public function FSxMLEVLeaveGetManagePagination($ptSQL) {
    $oQuery = $this->db->query($ptSQL);
    return $oQuery->num_rows();
}
public function FSxMLEVLeaveDataGetLeaveManage($aFilter) {
    $tUsrEmail = get_cookie('TaskEmail');   
    $tUsrDepCode = get_cookie('UsrDepCode');  
	$this->db->select('FTDevCode');
	$this->db->where('FTDevEmail', $tUsrEmail);
	$query = $this->db->get('TTSDevTeam');
	if(isset($aFilter['nStatus'])){
		$nStatus = $aFilter['nStatus'];
	}else{
		$nStatus = '';
	}
	if(isset($aFilter['tType'])){
		$tType = $aFilter['tType'];
	}else{
		$tType = '';
	}
    if(isset($aFilter['tName'])){
		$tName = $aFilter['tName'];
	}else{
		$tName = '';
	}
    if(isset($aFilter['tTeam'])){
		$tTeam = $aFilter['tTeam'];
	}else{
		$tTeam = '';
	}
	if(isset($aFilter['dStartDate'])){
		$dStartDate = $aFilter['dStartDate'];
	}else{
		$dStartDate = '';
	}
	if(isset($aFilter['dEndDate'])){
		$dEndDate = $aFilter['dEndDate'];
	}else{
		$dEndDate = '';
	}
    $tSQL1 = "SELECT
    ROW_NUMBER() OVER(ORDER BY HLS.FDLvhCreateOn DESC) AS RowID,
    HLS.*, LST.FTLvtName, 
    DT.FTDevName AS FTDevName, 
    DT.FTDevGrpTeam AS FTDevGrpTeam,
    DTA.FTDevName AS FTLvhApvByName,
    LST.FTLvtName AS Typename,
    DT.FTDevGrpTeam AS team,
    Pvn.FTPvnName AS FTPvnName,
    DPM.FTDepName AS FTDepName
    FROM THRTLeaveHis HLS
    LEFT JOIN TTSDevTeam DTA ON HLS.FTLvhApvBy = DTA.FTDevCode
    LEFT JOIN TTSDevTeam DT ON HLS.FTLvhDevCode = DT.FTDevCode
    LEFT JOIN THRSLeaveType LST ON HLS.FTLvhType = LST.FTLvtCode
    LEFT JOIN TTSDepartment DPM ON DT.FTDepCode = DPM.FTDepCode
    LEFT JOIN TSysProvince_L Pvn ON HLS.FTLvhPvnCode = Pvn.FTPvnCode AND Pvn.FNLngID = '1'
    WHERE ISNULL(HLS.FTLvhCode, '') <> '' 
    AND ('$tUsrDepCode' = '00001' OR DT.FTDepCode = '$tUsrDepCode')
    AND DT.FTDevGrpTeam != 'DELETE'";
        if (!empty($nStatus)) {
            $tSQL1 .= " AND HLS.FTLvhStaApv = '$nStatus'";
        }
        if (!empty($tType)) {
            $tSQL1 .= " AND HLS.FTLvhType = '$tType'";
        }

        if (!empty($dStartDate)) {
            $dStartDateTime = DateTime::createFromFormat('d/m/Y', $dStartDate);
            if ($dStartDateTime !== false) {
                $dStartDateTime = $dStartDateTime->format('Y-m-d');
                $tSQL1 .= " AND HLS.FDLvhDateFrom >= '$dStartDateTime'";
            } else {       
            }
        }
        if (!empty($dEndDate)) {
            $dEndDateTime = DateTime::createFromFormat('d/m/Y', $dEndDate);
            if ($dEndDateTime !== false) {
                $dEndDateTime = $dEndDateTime->format('Y-m-d');
                $tSQL1 .= " AND HLS.FDLvhDateTo <= '$dEndDateTime'";
            } else {
            }
        }
        if (!empty($tTeam)) {
            $tSQL1 .= " AND DT.FTDevGrpTeam = '$tTeam'";
        } 
        if (!empty($tName)) {
            $tSQL1 .= " AND DT.FTDevCode = '$tName'";
        } 
   
	$nTotalRecord = $this->FSxMLEVLeaveGetManagePagination($tSQL1);
    $nRecordsPerPage = 10;
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
        $nNum_page = 1;
    } else if (($nTotalRecord % $nRecordsPerPage) == 0) {
        $nNum_page = ($nTotalRecord / $nRecordsPerPage);
    } else {
        $nNum_page = ($nTotalRecord / $nRecordsPerPage) + 1;
        $nNum_page = (int)$nNum_page;
    }

    $row_end = $nRecordsPerPage * $nPage;
    if ($row_end > $nTotalRecord) {
        $row_end = $nTotalRecord;
    }
    $tSQL2 = "SELECT * FROM ( ";
	$tSQL2 .= $tSQL1;
    $tSQL2 .= " ) C ";
    $tSQL2 .= " WHERE c.RowID > $row_start AND c.RowID <= $row_end ";
    $oQuery = $this->db->query($tSQL2);

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
    } 
    else 
    {
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


    public function FSxMLEVLeaveGetLeaveM($FTLvhCode) {
       
        $aLeaveDataM = $this->db->get_where('THRTLeaveHis', array('FTLvhCode' => $FTLvhCode))->row_array();
        $aLeaveDataM['hasAttachment'] = true;
        return json_encode($aLeaveDataM);
    }
    public function FSxMLEVLeaveGetLeaveMng($FTLvhCode) {
    
        $aLeaveDataMng = $this->db->get_where('THRTLeaveHis', array('FTLvhCode' => $FTLvhCode))->row_array();
        $aLeaveDataMng['hasAttachment'] = true;
        return json_encode($aLeaveDataMng);
    }


}