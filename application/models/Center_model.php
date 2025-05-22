<?php  defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );
class Center_model extends CI_Model {

        public function __construct()
        {
            parent::__construct();
            ini_set("memory_limit",-1);
        }

        //ดึงข้อมูลแผนกของผู้ใช้
        public function GetUsrInfo(){

            $tEmail = get_cookie('TaskEmail');
            
            $tSQL = "SELECT EMP.*,DEP.FTDepName 
                     FROM TTSDevTeam EMP
                     LEFT JOIN TTSDepartment DEP
                     ON EMP.FTDepCode = DEP.FTDepCode
                     WHERE  FTDevEmail = '$tEmail' ";

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

		public function GetDashboardURL()
		{
			$tUsrDepCode = get_cookie('UsrDepCode');

			$tSQL = "SELECT FTDepUrlReport FROM TTSDepartment WHERE FTDepCode = '$tUsrDepCode' ";
			try {
				$oQuery = $this->db->query($tSQL);
				if($oQuery->num_rows() > 0)
				{
					return $oQuery->row()->FTDepUrlReport;
				} else {
					return null;
				}
			} catch (Exception $oException) {
				return null;
			}
		}
}
