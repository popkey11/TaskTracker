<?php  defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Employee_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            ini_set("memory_limit",-1);
        }
        
        public function index(){
            return 'Employee';
        }

        //หาจำนวนข้อมูลเพื่อนำไปแบ่งหน้า
        public function GetPaginationEmployee($aFilter){


            $tSQL = "SELECT EMP.*,DEP.FTDepName 
            FROM TTSDevTeam EMP
            LEFT JOIN TTSDepartment DEP ON DEP.FTDepCode = EMP.FTDepCode 
            WHERE ISNULL(EMP.FTDevCode,'') <> '' ";

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
                $tSQL .= " AND ((  EMP.FTDevCode LIKE '%$LikeSearch%') 
                                    OR (EMP.FTDevName LIKE '%$LikeSearch%')
                                    OR (EMP.FTDevNickName LIKE '%$LikeSearch%')
                                    OR (EMP.FTDevEmail LIKE '%$LikeSearch%')
                                    OR (EMP.FTDevGrpTeam LIKE '%$LikeSearch%') )  ";
            }

            $oQuery = $this->db->query($tSQL);

            return $oQuery->num_rows();

        }
        
        // ดึงข้อมูลพนักงานทั้งหมดในระบบ
        public function GetEmployee($aFilter){

            //Get All Record
            $nTotalRecord = $this->GetPaginationEmployee($aFilter);

            $nRecordsPerPage = 10;
            $total_pages = ceil($nTotalRecord / $nRecordsPerPage);

            // Determine the current page number
            if(isset($aFilter['nPage'])){
                $nPage = $aFilter['nPage'];
            }else{
                $nPage = 1;
            }

            $prev_page = $nPage - 1;
            $next_page = $nPage + 1;

            $row_start = (($nRecordsPerPage * $nPage)-$nRecordsPerPage);
            if($nTotalRecord<=$nRecordsPerPage)
            {
                $num_pages = 1 ;
            }
            else if(($nTotalRecord % $nRecordsPerPage)==0)
            {
                $num_pages =($nTotalRecord/$nRecordsPerPage) ;
            }
            else
            {
                $num_pages =($nTotalRecord/$nRecordsPerPage)+1;
                $num_pages = (int)$num_pages;
            }

            $row_end = $nRecordsPerPage * $nPage;

            if($row_end > $nTotalRecord)
            {
                $row_end = $nTotalRecord;
            }

            $tSQL = "SELECT * FROM ( ";
            $tSQL.= "SELECT 
                        ROW_NUMBER() OVER(ORDER BY FDCreateOn DESC) AS RowID,
                        EMP.*,DEP.FTDepName 
                    FROM TTSDevTeam EMP
                    LEFT JOIN TTSDepartment DEP ON DEP.FTDepCode = EMP.FTDepCode 
                    WHERE ISNULL(EMP.FTDevCode,'') <> '' ";    
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
                $tSQL .= " AND ((  EMP.FTDevCode LIKE '%$LikeSearch%') 
                                   OR (EMP.FTDevName LIKE '%$LikeSearch%')
                                   OR (EMP.FTDevNickName LIKE '%$LikeSearch%')
                                   OR (EMP.FTDevEmail LIKE '%$LikeSearch%')
                                   OR (EMP.FTDevGrpTeam LIKE '%$LikeSearch%') )  ";
            }

            $tSQL.= " ) C ";

            $tSQL.= " WHERE c.RowID > $row_start AND c.RowID <= $row_end ";

            $oQuery = $this->db->query($tSQL);

            if($oQuery->num_rows() > 0){

                $aResult 	= array(
                    'raItems'  	=> $oQuery->result_array(),
                    'total_record' => $nTotalRecord,
                    'total_pages' => $total_pages,
                    'current_page' => $nPage,
                    'prev_page' => $prev_page,
                    'next_page' => $next_page,
                    'rtCode'    => '200',
                    'rtDesc'   	=> 'success',
                );

                }else{

                $aResult = array(
                    'rnAllRow' 		=> 0,
                    'total_record' => 0,
                    'total_pages' => 0,
                    'current_page' => 0,
                    'prev_page' => 0,
                    'next_page' => 0,
                    'rtCode' 		=> '800',
                    'rtDesc' 		=> 'data not found',
                );

            }
            return $aResult;
        }

        public function DeleteEmployee($aKeyDelete){

            $tDevCode = $aKeyDelete["tEmpCode"];
            echo "M.".$aKeyDelete["tEmpCode"];
            $tSQL = "UPDATE TTSDevTeam SET FTDevGrpTeam = 'DELETE',FTDevStaActive='2' WHERE FTDevCode = '$tDevCode' ";
            echo $tSQL;
            $oQuery = $this->db->query($tSQL);
            if($oQuery){
               return 'success';
            }else{
                return 'error';
            }
        }
}

?>