<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Skill_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Task_model');
        $this->load->model('Center_model');
        $this->load->model('Skillrecord_model');


        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library('form_validation');

        if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE) {
            echo "ERROR XSS Filter";
        }

    }

    public function index()
    {
        $tUsrEmail = get_cookie('TaskEmail');





        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');
        $dFilter = '';
        
        $aUsrInfo           = $this->Center_model->GetUsrInfo();
        $aDepartment        = $this->Skillrecord_model->GetDepartment($dFilter);
        $tUsrDepCode        = $aUsrInfo['raItems'][0]['FTDepCode']; //รหัสแผนกของผู้ใช้
        $aDataGroupSkill    = $this->Skillrecord_model->FSxMSKRGetDataGroupSkill($tUsrDepCode);
        $tDashboardURL      = $this->Center_model->GetDashboardURL();
        $aParm = array(
            "tUsrEmail" => $tUsrEmail,

            "UsrInfo"  => $aUsrInfo,
            "DepartmentList"  => $aDepartment,

            "GroupSkillList" => $aDataGroupSkill,

            'tDashboardURL' => $tDashboardURL
            ,
            'tTitle' => $this->lang->line('tTitle')
        );
        
        $this->load->view('skillrecord/wSkillrecord', $aParm);



    }



    public function FSxCSKRGetGroupSkillList()
    {
        $tUsrEmail = get_cookie('TaskEmail');
        $tDevCode = $this->input->post('tDevSearch'); 
        $tLikeSearch = $this->input->post('tLikeSearch');
        $nPage = $this->input->post('nPage');

        $aFilter = array(
            "tDevCode" => $tDevCode,
            "LikeSearch" => $tLikeSearch,
            "nPage" => $nPage
        );

        $aGroupList = $this->Skillrecord_model->FSxMSKRGetGroupSkillList($aFilter);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'group' => $aGroupList]));



    }

    public function FSxCSKRGetSkillList()
    {


        $tUsrEmail = get_cookie('TaskEmail');
        $tDevCode = $this->input->post('tDevSearch');
        $tLikeSearch = $this->input->post('tLikeSearch');
        $nPage = $this->input->post('nPage');

        $aFilter = array(
            "tDevCode" => $tDevCode,
            "LikeSearch" => $tLikeSearch,
            "nPage" => $nPage
        );
        // print_r($aFilter);
        $aSkillList = $this->Skillrecord_model->FSxMSKRGetSkillList($aFilter);

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => 'success',
                'skill' => $aSkillList
            ]));




    }

    public function FSxCSKRGetSkillDev()
    {
        $tEmail = get_cookie('TaskEmail');

        $tDepCode = $this->input->post('tDepSearch');
        $tGrpCode = $this->input->post('tGrpSearch');
        $tLevelCode = $this->input->post('tLevelSearch');
        $tLikeSearch = $this->input->post('tLikeSearch');
        $nPage = $this->input->post('nPage');

        $aFilter = array(
            "tDepCode" => $tDepCode,
            "tGrpCode" => $tGrpCode,
            "tLevelCode" => $tLevelCode,
            "LikeSearch" => $tLikeSearch,
            "nPage" => $nPage
        );
        // print "<pre>";
        // print_r ($aFilter);
        // print "</pre>";


        $aSkillDev = $this->Skillrecord_model->FSxMSKRGetSkillDev($aFilter, $tEmail);
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => 'success', 'skilldev' => $aSkillDev]));


    }

    public function FSxCSKRDeleteGroupSkill()
    {

        $ptGroupSkillID = $this->input->post('ptGroupSkillID');


        $GetGrpBySKill = $this->Skillrecord_model->FSxMSKRGetGrpBySkill($ptGroupSkillID);



        if ($GetGrpBySKill[0]['RowSkill'] == 0) {

            echo $aGroupSkillStart = $this->Skillrecord_model->FSxMSKRDeleteGroupSkill($ptGroupSkillID);
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'ลบสำเร็จ']));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'ไม่สามารถลบได้ เพราะมีข้อมูลใช้งานอยู่']));
        }




    }

    public function FSxCSKRDeleteSkill()
    {

        $ptSkillID = $this->input->post('ptSkillID');

        $GetSkillBySkilldev = $this->Skillrecord_model->FSxMSKRGetSkillBySkillDev($ptSkillID);

        if ($GetSkillBySkilldev[0]['RowSkill'] == 0) {
            echo $aSkillStart = $this->Skillrecord_model->FSxMSKRDeleteSkill($ptSkillID);
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'success', 'message' => 'ลบสำเร็จ']));
        } else {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => 'error', 'message' => 'ไม่สามารถลบได้ เพราะมีข้อมูลใช้งานอยู่']));
        }




    }



    public function FSxCSKRNewGroupSkill()
    {
        $tUsrEmail = get_cookie('TaskEmail');

        


        $dFilter = '';


            $this->load->helper('language');
            $this->lang->load('main_lang', 'english');

            //ดึงข้อมูลแผนก
        $aDepartment        = $this->Skillrecord_model->GetDepartment($dFilter);
        $aUsrInfo           = $this->Center_model->GetUsrInfo();
        $tUsrDepCode        = $aUsrInfo['raItems'][0]['FTDepCode']; //รหัสแผนกของผู้ใช้
        $tUsrDepName        = $aUsrInfo['raItems'][0]['FTDepName']; //ชื่อแผนกของผู้ใช้
            $tDashboardURL = $this->Center_model->GetDashboardURL();
            $aParm = array(
                "tUsrEmail" => $tUsrEmail
                ,
                "DepartmentList"    => $aDepartment,

                    "UsrDepCode"        => $tUsrDepCode,
                    "UsrDevName"        => $tUsrDepName,
                'tDashboardURL' => $tDashboardURL
                ,
                'tTitle' => $this->lang->line('tTitle')
            );
            $this->load->view('skillrecord/wCreateGroupSkill', $aParm);
        
    }

    public function FSxCSKRNewMySkill()
    {
        $aDataMySkill = $this->Skillrecord_model->FSxMSKRGetDataSkill();
        $aParm = array(
            "SkillList" => $aDataMySkill,

        );

        $this->load->view('skillrecord/wCreateMySkill', $aParm);
    }
    public function FSxCSKRNewSkill()
    {
        $tUsrEmail = get_cookie('TaskEmail');

            $dFilter = '';

            $this->load->helper('language');
            $this->lang->load('main_lang', 'english');

             //ดึงข้อมูลแผนก
        $aDepartment        = $this->Skillrecord_model->GetDepartment($dFilter);
        $aUsrInfo           = $this->Center_model->GetUsrInfo();
        $tUsrDepCode        = $aUsrInfo['raItems'][0]['FTDepCode']; //รหัสแผนกของผู้ใช้
        $tUsrDepName        = $aUsrInfo['raItems'][0]['FTDepName']; //ชื่อแผนกของผู้ใช้
        $tDashboardURL      = $this->Center_model->GetDashboardURL();
        $aDataGroupSkill    = $this->Skillrecord_model->FSxMSKRGetDataGroupSkill($tUsrDepCode);
        $aDataRole          = $this->Skillrecord_model->FSxMSKRGetDataRole($tUsrDepCode);
        $aParm = array(
            "tUsrEmail"         => $tUsrEmail,
            "DepartmentList"    => $aDepartment,
            "UsrDepCode"        => $tUsrDepCode,
            "UsrDevName"        => $tUsrDepName,
            "GroupSkillList"    => $aDataGroupSkill,
            "RoleList"          => $aDataRole,
            'tDashboardURL'     => $tDashboardURL
            ,
            'tTitle' => $this->lang->line('tTitle')
        );


        $this->load->view('skillrecord/wCreateNewSkill', $aParm);
        
    }
    public function FSxCSKRGroupSkill()
    {

        $tUsrEmail = get_cookie('TaskEmail');



        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');

        //ดึงข้อมูลแผนก
        $aFilterDepartment = array();
        $aDepartment = $this->Skillrecord_model->GetDepartment($aFilterDepartment);

        $aUsrInfo      = $this->Center_model->GetUsrInfo();
        $tDashboardURL = $this->Center_model->GetDashboardURL();
        $aParm = array(

            "DepartmentList"    => $aDepartment,
            "tUsrEmail" => $tUsrEmail
            ,
            "UsrInfo"  => $aUsrInfo,
            'tDashboardURL' => $tDashboardURL
            ,
            'tTitle' => $this->lang->line('tTitle')
        );

        $this->load->view('skillrecord/wGroupSkillList', $aParm);



    }


    public function FSxCSKRSkill()
    {

        $tUsrEmail = get_cookie('TaskEmail');

        
            $this->load->helper('language');
            $this->lang->load('main_lang', 'english');
            $aUsrInfo      = $this->Center_model->GetUsrInfo();
            $tDashboardURL = $this->Center_model->GetDashboardURL();
            $aParm = array(
                "tUsrEmail" => $tUsrEmail
                ,
                "UsrInfo"  => $aUsrInfo,

                'tDashboardURL' => $tDashboardURL
                ,
                'tTitle' => $this->lang->line('tTitle')
            );

            $this->load->view('skillrecord/wSkillList', $aParm);

        

    }

    // public function FSxCSKRAddGroupSkill(){
    //     $tGroupSkillName = $this->input->post('tGroupskillname');
    //     $this->Skillrecord_model->FSxMSKRDeleteGroupSkill();
    // }
    public function FSxCSKRAddGroupSkill()
    {
        $this->load->model('Skillrecord_model');

        $aDataInsert = array(
            "oetGroupskillname" => $this->input->post('oetGroupskillname'),
            "oetDepCode" => $this->input->post('oetDepCode'),
        );


        $tGrpInsert = $this->Skillrecord_model->FSxMSKRInsertGroupSkill($aDataInsert);
        echo $tGrpInsert;
    }

    public function FSxCSKRAddSkill()
    {
        $this->load->model('Skillrecord_model');

        $aDataInsert = array(
            "oetSkillName"      => $this->input->post('oetSkillName'),
            "ocmGroupSkillName" => $this->input->post('ocmGroupSkillName'),
            "ocmRoleSkill"      => $this->input->post('ocmRoleSkill'),
            "oetDepCode"        => $this->input->post('oetDepCode'),
        );


        $tSkrInsert = $this->Skillrecord_model->FSxMSKRInsertSkill($aDataInsert);
        echo $tSkrInsert;
    }
    public function FSxCSKRAddMySkill()
    {
        $this->load->model('Skillrecord_model');

        $aDataInsert = array(
            "ocmSkillName" => $this->input->post('ocmSkillName'),
            "ocmLevelSkill" => $this->input->post('ocmLevelSkill'),
        );


        $tSkrMyInsert = $this->Skillrecord_model->FSxMSKRInsertMySkill($aDataInsert);
        echo $tSkrMyInsert;
    }


    public function FSxCSKREditGroupSkill()
    {
        $tUsrEmail = get_cookie('TaskEmail');

        $dFilter = '';

        $tGroupSkillID = $this->input->post('ptGroupSkillID');
//ดึงข้อมูลแผนก
$aDepartment        = $this->Skillrecord_model->GetDepartment($dFilter);
$aUsrInfo           = $this->Center_model->GetUsrInfo();
$tUsrDepCode        = $aUsrInfo['raItems'][0]['FTDepCode']; //รหัสแผนกของผู้ใช้
$tUsrDepName        = $aUsrInfo['raItems'][0]['FTDepName']; //ชื่อแผนกของผู้ใช้

        $aGrpSkillStart = $this->Skillrecord_model->FSxMSKREditGroupSkill($tGroupSkillID);
        $tDashboardURL = $this->Center_model->GetDashboardURL();
        $nPage = $this->input->post('nPage');
        $aDataEdit = array(
            "tUsrEmail" => $tUsrEmail
                ,
                "DepartmentList"    => $aDepartment,

                    "UsrDepCode"        => $tUsrDepCode,
                    "UsrDevName"        => $tUsrDepName,
            "tUsrEmail" => $tUsrEmail,
            'aGrpSkillStart' => $aGrpSkillStart,
            'tDashboardURL' => $tDashboardURL,
            "nPage" => $nPage
            ,
            'tTitle' => $this->lang->line('tTitle')
        );
        $this->load->view('skillrecord/wEditGroupSkill', $aDataEdit);

    }

    public function FSxCSKREditSkill()
    {
        $aUsrInfo           = $this->Center_model->GetUsrInfo();
        $tUsrDepName        = $aUsrInfo['raItems'][0]['FTDepName']; //รหัสแผนกของผู้ใช้
        $tUsrDepCode        = $aUsrInfo['raItems'][0]['FTDepCode']; //รหัสแผนกของผู้ใช้
        $aDataGroupSkill    = $this->Skillrecord_model->FSxMSKRGetDataGroupSkill($tUsrDepCode);
        $aDataRole          = $this->Skillrecord_model->FSxMSKRGetDataRole($tUsrDepCode);

        $tSkillID           = $this->input->post('ptSkillID');

        $aSkillStart        = $this->Skillrecord_model->FSxMSKREditSkill($tSkillID);
        $nPage              = $this->input->post('nPage');
        $aDataEdit = array(
            'aSkillStart'       => $aSkillStart,
            "GroupSkillList"    => $aDataGroupSkill,
            "RoleList"          => $aDataRole,
            "UsrDepCode"        => $tUsrDepCode,
            "UsrDevName"        => $tUsrDepName,
            "nPage"             => $nPage
        );

        $this->load->view('skillrecord/wEditNewSkill', $aDataEdit);

    }

    public function FSxCSKREditMySkill()
    {
        $tEmail = get_cookie('TaskEmail');

        $aDataSkill = $this->Skillrecord_model->FSxMSKRGetDataSkill();

        $tMySkillID = $this->input->post('ptMySkillID');

        $tSkillName = $this->input->post('ptSkillName');

        $tLevelSkill = $this->input->post('ptLevelSkill');

        
        $nPage = $this->input->post('nPage');

        $aMySkillStart = $this->Skillrecord_model->FSxMSKREditMySkill($tMySkillID, $tEmail);

        $aDataEdit = array(
            'aMySkillStart' => $aMySkillStart,
            'aDataSkill' => $aDataSkill,
            'tSkillName' => $tSkillName,
            'tLevelSkill' => $tLevelSkill,
            'tMySkillID' => $tMySkillID,
            "nPage" => $nPage


        );
        // print ("<pre>");
        // print_r($aDataEdit);
        // print ("</pre>");
        // print_r($aDataEdit);
        $this->load->view('skillrecord/wEditMySkill', $aDataEdit);

    }

    public function FSxCSKRUpdateGroupskill()
    {
        $this->load->model('Skillrecord_model');

        $aDataUpdate = array(
            "oetGroupskillcode" => $this->input->post('oetGroupskillcode'),
            "oetGroupskillname" => $this->input->post('oetGroupskillname'),
            
        );


        $tGrpUpdate = $this->Skillrecord_model->FSxMSKRUpdateGroupSkill($aDataUpdate);
        echo $tGrpUpdate;

    }

    public function FSxCSKRUpdateSkill()
    {
        $this->load->model('Skillrecord_model');

        $aDataUpdate = array(
            "oetSkillcode"              => $this->input->post('oetSkillcode'),
            "oetSkillname"              => $this->input->post('oetSkillname'),
            "ocmGroupSkillName"         => $this->input->post('ocmGroupSkillName'),
            "ocmRoleSkill"              => $this->input->post('ocmRoleSkill'),
            "oetSkillStatus"            => $this->input->post('oetSkillStatus'),
            "oetDepCode"                => $this->input->post('oetDepCode'),

        );

        $tSkrUpdate = $this->Skillrecord_model->FSxMSKRUpdateSkill($aDataUpdate);
        echo $tSkrUpdate;

    }

    public function FSxCSKRUpdateMySkill()
    {

        $aDataUpdate = array(
            "oetSkillcode" => $this->input->post('oetSkillcode'),
            "oetSkillname" => $this->input->post('oetSkillname'),
            "ocmLevelSkill" => $this->input->post('ocmLevelSkill'),

        );
        $this->load->model('Skillrecord_model');

        $getExistMySkill = $this->Skillrecord_model->FSxMSKRGetCountMySkillByEmail($aDataUpdate["oetSkillcode"]);

        if ($getExistMySkill[0]["RowSkill"] > 0) {

            $tMySkrUpdate = $this->Skillrecord_model->FSxMSKRUpdateMySkill($aDataUpdate);
            echo $tMySkrUpdate;

        } else if ($getExistMySkill[0]["RowSkill"] == 0) {

            $aDataInsert = array(
                "oetSkillName" => $aDataUpdate["oetSkillcode"],
                "ocmLevelSkill" => $aDataUpdate["ocmLevelSkill"]
            );

            $tMySkrInsert = $this->Skillrecord_model->FSxMSKRInsertMySkill($aDataInsert);
            echo $tMySkrInsert;

        }

    }

    public function FSxCSKRRefreshAddMySkill()
    {
        $ptMyEmail = $this->input->post('ptMyEmail');

        echo $refAddMySkill = $this->Skillrecord_model->FSxMSKRRefreshAddMySkill($ptMyEmail);

    }

    public function FSxCSKRGetDataSkillGroup()
    {

        $tDepCode        = $this->input->post('tDepCode');
        $aDataGroupSkill    = $this->Skillrecord_model->FSxMSKRGetDataGroupSkill($tDepCode);

        echo json_encode($aDataGroupSkill);

    }





}
?>