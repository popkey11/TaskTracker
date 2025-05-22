<!-- if (isset($aFilter['status']) && $aFilter['status'] != NULL ) {
        $tSQL .= " AND FNStatus =  "; 
        $status = $aFilter['status'];
        $params[] = $status;
    }
 
    if (isset($aFilter['type']) && $aFilter['type'] != NULL ) {
        $tSQL .= " AND LSH.FNTypeID = ? "; 
        $type = $aFilter['type'];
        $params[] = $type;
    }

    if (isset($aFilter['startDate']) && isset($aFilter['endDate']) && $aFilter['startDate'] != NULL  && $aFilter['startEnd'] != NULL)  {
        $tSQL .= " AND FDDateFrom  BETWEEN ? AND ? "; 
        $startDate = $aFilter['startDate'];
        $endDate = $aFilter['endDate'];
        $params[] = $startDate;
        $params[] = $endDate;
    } -->

$tSQL = "SELECT * FROM ( ";

$tSQL .= "SELECT
ROW_NUMBER() OVER(ORDER BY LSH.FDCreateOn DESC) AS RowID,
LSH.*, DT.FTDevName, LST.FTTypeName
FROM TLSTHistory LSH
LEFT JOIN TTSDevTeam DT ON LSH.FTDevCode = DT.FTDevCode
LEFT JOIN TLSSType LST ON LST.FNTypeID = LSH.FNTypeID
WHERE ISNULL(LSH.FTHisCode, '') <> '' ";


    //Filter แผนก
    if(isset($aFilter['status'])){
    $status = $aFilter['status'];
    }else{
    $status = '';
    }


    if(isset($aFilter['type'])){
    $type = $aFilter['type'];
    }else{
    $type = '';
    }

    if(isset($aFilter['startDate'])){
    $startDate = $aFilter['startDate'];
    }else{
    $startDate = '';
    }


    if(isset($aFilter['EndDate'])){
    $EndDate = $aFilter['EndDate'];
    }else{
    $EndDate = '';
    }

    if($FTHisCode != ''){
    $tSQL .= " AND LSH.FTHisCode = '$FTHisCode' ";
    }


    if($status != ''){
    $tSQL .= " AND (( LSH.FNStatus LIKE '%$status%')) ";
    }

    if($type != ''){
    $tSQL .= " AND (( LSH.FNTypeID LIKE '%$type%')) ";
    }

    if($startDate != ''){
    $tSQL .= " AND (( LSH.FDDateFrom LIKE '%$startDate%')) ";
    }
    if($EndDate != ''){
    $tSQL .= " AND (( LSH.FDDateTo LIKE '%$endDate%')) ";
    }



    $tSQL .= " ) C ";
    $tSQL .= " WHERE c.RowID > ? AND c.RowID <= ? ";
    print_r($tSQL); die();
    $params[] = $row_start;
    $params[] = $row_end;
    $oQuery = $this->db->query($tSQL, $params);


    
    $tSQL = " SELECT * FROM ( ";
            $tSQL.= " SELECT ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS RowID, EMP.*,DEP.FTDepName FROM TTSDevTeam
        EMP LEFT JOIN TTSDepartment DEP ON DEP.FTDepCode=EMP.FTDepCode WHERE ISNULL(EMP.FTDevCode,'') <> '' ";
        //Filter แผนก
        if(isset($aFilter['tDevCode'])){
        $tDevCode = $aFilter['tDevCode'];
        }else{
        $tDevCode = '';
        }

        //Filter Like
        if(isset($aFilter['LikeSearch'])){
        $LikeSearch = $aFilter['LikeSearch'];
        }else{
        $LikeSearch = '';
        }

        if($tDevCode != ''){
        $tSQL .= " AND DEP.FTDepCode = '$tDevCode' ";
        }

        if($LikeSearch != ''){
        $tSQL .= " AND (( EMP.FTDevCode LIKE '%$LikeSearch%')
        OR (EMP.FTDevName LIKE '%$LikeSearch%')
        OR (EMP.FTDevNickName LIKE '%$LikeSearch%')
        OR (EMP.FTDevEmail LIKE '%$LikeSearch%')
        OR (EMP.FTDevGrpTeam LIKE '%$LikeSearch%') ) ";
        }

        $tSQL.= " ) C ";

        $tSQL.= " WHERE c.RowID > $row_start AND c.RowID <= $row_end ";

            $oQuery = $this->db->query($tSQL);