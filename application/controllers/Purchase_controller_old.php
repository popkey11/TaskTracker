<?php
defined('BASEPATH') or exit('No direct script access allowed');
class PurchaseOLD_controller extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Center_model');
        $this->load->model('Purchase_model');
        $this->load->model('Project_model');
        $this->load->library('upload');
        $this->load->helper(array('form', 'url', 'security'));
        $this->load->library('form_validation');
        if ($this->security->xss_clean($this->input->post(), TRUE) === FALSE) {
            echo "ERROR XSS Filter";
        }
        $tUsrEmail = get_cookie('TaskEmail');
        if ($tUsrEmail == "") {
            redirect('/home', 'refresh');
        }
    }
    public function FStCPODataListView($id)
    {
        $tProjectId         = $this->uri->segment('2');
        $tProjectName       = $this->Purchase_model->FSaMPOListView($tProjectId);
        $tUsrEmail          = get_cookie('TaskEmail');
        $aParm              = array("tUsrEmail" => $tUsrEmail);
        $aFilterDepartment  = array();
        $aDepartment        = $this->Purchase_model->FSaMPOGetDepartment($aFilterDepartment);
        $aUsrInfo           = $this->Center_model->GetUsrInfo();
        $tDashboardURL      = $this->Center_model->GetDashboardURL();
        $this->load->helper('language');
        $this->lang->load('main_lang', 'english');
        $aParm = array(
            "projectId" => $tProjectId,
            "ProjectName" => $tProjectName['FTPrjName'],
            "DepartmentList"    => $aDepartment,
            "UsrInfo"           => $aUsrInfo,
            'tDashboardURL'     => $tDashboardURL,
            "tTitle"            => $this->lang->line('tTitle')
        );
        $this->load->view('po/wPoList', $aParm);
    }
    /**
     * Functionality : Get Project PO
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : View and Array Data
     * Return Type : View and Array Data
     */
    public function FSxCPOGetProjectPo()
    {
        $tUsrEmail      = get_cookie('TaskEmail');
        $tDevCode       = $this->input->post('tDevSearch');
        $tLikeSearch    = $this->input->post('tLikeSearch');
        $nPage          = $this->input->post('nPage');
        $tProject       = $this->input->post('project');
        $aFilter = array(
            "tDevCode"      => $tDevCode,
            "LikeSearch"    => $tLikeSearch,
            "nPage"         => $nPage,
            "tProject"      => $tProject
        );
        $aProjectList   = $this->Purchase_model->FSaMPOGetProject($aFilter);
        $aParm          = array("ProjectList" => $aProjectList);



        $this->load->view('po/wProjectPo', $aParm);
    }
    /**
     * Functionality : Display Page 
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : View and Array Data
     * Return Type : View and Array Data
     */
    public function FStCPOPageAdd()
    {
        try {
            $this->load->helper('language');
            $this->lang->load('main_lang', 'english');
            $tDashboardURL = $this->Center_model->GetDashboardURL();
            $aParm = array(
                //104-107
                "aDepartment"    => $aDepartment,
                "tNextPrjCode"           => $tNextPrjCode,
                "tUsrDepCode"        => $tUsrDepCode,
                "tUsrDepName"        => $tUsrDepName,
                'tDashboardURL'     => $tDashboardURL,
                "tTitle"            => $this->lang->line('tTitle')
            );

            $this->load->view('po/wPoAdd', $aParm);
        } catch (Exception $e) {
            return 'catch';
        } finally {
            return 'finally';
        }
    }
    /**
     * Functionality : Event Add Data
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : Return text 
     * Return Type : boolean
     */
    public function FStCPOEventAddData()
    {
        try {
            $tProjectId     = trim($this->input->post('ohdProjectId'));
            $tPoTitle       = trim($this->input->post('oetPoTitle'));
            $tPoStatus      = trim($this->input->post('ocmPoStatus'));
            $tPoProgress    = trim($this->input->post('oetPoProgress'));
            $tPoDate        = trim($this->input->post('oetPoDate'));
            $tPoRemark      = trim($this->input->post('oetPoRemark'));
            $tPoPlanStart   = trim($this->input->post('oetPoPlanStart'));
            $tPoFinish      = trim($this->input->post('oetPoFinish'));
            $tPoUrlRefer    = trim($this->input->post('oetPoUrlRefer'));
            $tMDDev         = trim($this->input->post('oetMDDev'));
            $tMDPHP         = trim($this->input->post('oetMDPHP'));
            $tMDC           = trim($this->input->post('oetMDC'));
            $tMDAndriod     = trim($this->input->post('oetMDAndriod'));
            $tMDTester      = trim($this->input->post('oetMDTester'));
            $tMDsa          = trim($this->input->post('oetMDsa'));
            $tMDPm          = trim($this->input->post('oetMDPm'));
            $tMDInterface   = trim($this->input->post('oetMDInterface'));
            $tMDTotal       = trim($this->input->post('oetMDTotal'));
            $tPoDate        = trim($this->input->post('oetPoDate'));
            $PoNo = trim($this->input->post('oetPoNo'));
            $aDataInsert = array(
                "FTPpoTitle"        => $tPoTitle,
                "FNPpoStatus"       => $tPoStatus,
                "FTPpoProgress"     => $tPoProgress,
                "FTPpoRemark"       => $tPoRemark,
                "FDPpoPlanStart"    => $tPoPlanStart,
                "FDPpoPlanFinish"   => $tPoFinish,
                "FTPpoRefUrl"       => $tPoUrlRefer,
                "FCPpoMdPhp"        => $tMDPHP,
                "FCPpoMdDev"        => $tMDDev,
                "FCPpoMdcSharp"     => $tMDC,
                "FCPpoMdAndroid"    => $tMDAndriod,
                "FCPpoMdTester"     => $tMDTester,
                "FCPpoMdSa"         => $tMDsa,
                "FCPpoMdPm"         => $tMDPm,
                "FCPpoMdInterface"  => $tMDInterface,
                "FDPpoDocDate"      => $tPoDate,
                "FCPpoMdTotal"      => $tMDTotal,
                "FTPrjCode"         => $tProjectId,
                "FTPohDocNo" => $PoNo,
            );
            $bResInsert = $this->Purchase_model->FStMPOEventSavePo($aDataInsert);
            echo $bResInsert;
        } catch (Exception $e) {
            return 'catch';
        } finally {
            return 'finally';
        }
    }
    /**
     * Functionality : Page Edit
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : Return format
     * Return Type : json
     */
    public function FStCPOPageEdit($ptDocNo, $ptPrjCode)
    {
        try {
            $aProjectData  = $this->Purchase_model->FSaMPOGetDataEdit($ptPrjCode, $ptDocNo);
            echo json_encode($aProjectData);
        } catch (Exception $e) {
            return 'catch';
        }
    }
    /**
     * Functionality : Update Period
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : Return format
     * Return Type : json
     */
    public function FStCPOUpdatePeriod()
    {
        try {
            $tPeriodNo          = $this->input->post('ohdPeriodNo');
            $tPeriodName        = $this->input->post('oetPeriodName');
            $dPeriodDate        = $this->input->post('oetPeriodDate');
            $tPeriodStatus      = $this->input->post('oetPeriodStatus');
            $tPeriodRemark      = $this->input->post('oetPeriodRemark');

            $tPocSeqNo      = $this->input->post('PocSeqNo');
            $tPohDocNo      = $this->input->post('PohDocNo');
            $tProjectNo     = $this->input->post('ohdProjectNo');
            $tRefInv    = $this->input->post('oetRefInv');


            $aData = array(
                "tPeriodNo"     => $tPeriodNo,
                "tPeriodName"   => $tPeriodName,
                "dPeriodDate"   => $dPeriodDate,
                "tPeriodStatus" => $tPeriodStatus,
                "tPeriodRemark" => $tPeriodRemark,
                "tPocSeqNo" => $tPocSeqNo,
                "tPohDocNo" => $tPohDocNo,
                "tProjectNo" => $tProjectNo,
                "FTPocRefInv" => $tRefInv

            );
            $aProjectData       = $this->Purchase_model->FStMPOUpdatePeriod($aData);
            echo json_encode($aProjectData);
        } catch (Exception $e) {
            return 'catch';
        } finally {
            return 'finally';
        }
    }
    /**
     * Functionality : Edit Period
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : Return format
     * Return Type : json
     */
    public function FStCPOEditPeriod()
    {
        try {
            $tPrjCode = $this->input->post('pPrjCode');
            $tPohDocNo = $this->input->post('pPohDocNo');
            $tPocSeqNo = $this->input->post('pPocSeqNo');
            $aProjectData       = $this->Purchase_model->FSaMPOGetEditPeriod($tPrjCode, $tPohDocNo, $tPocSeqNo);
            echo json_encode($aProjectData);
        } catch (Exception $e) {
            return 'catch';
        } finally {
            return 'finally';
        }
    }
    /**
     * Functionality : Event Update Purchase
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : Return format
     * Return Type : json
     */
    public function FStEventCPOUpdate()
    {
        try {


            $tProjectCode   = trim($this->input->post('ohdProjectCode'));
            $tPoTitle       = trim($this->input->post('oetPoTitleEdit'));
            $tPoStatus      = trim($this->input->post('ocmPoStatusEdit'));
            $tProgress      = trim($this->input->post('oetPoProgressEdit'));
            $tRemark        = trim($this->input->post('oetPoRemarkEdit'));
            $dPlanStart     = trim($this->input->post('oetPoPlanStartEdit'));
            $dPlanFinish    = trim($this->input->post('oetPoFinishEdit'));
            $tUrlRefer      = trim($this->input->post('oetPoUrlReferEdit'));
            $tMDDev         = trim($this->input->post('oetMDDevEdit'));
            $tMDPHP         = trim($this->input->post('oetMdPHPEdit'));
            $tPoDateEdit    = trim($this->input->post('oetPoDateEdit'));


            $tMDC           = trim($this->input->post('oetMDCEdit'));
            $tMDAndriod     = trim($this->input->post('oetMDAndriodEdit'));
            $tMDTester      = trim($this->input->post('oetMDTesterEdit'));
            $tMDsa          = trim($this->input->post('oetMDsaEdit'));
            $tMDPm          = trim($this->input->post('oetMDPmEdit'));
            $tMDInterface   = trim($this->input->post('oetMDInterfaceEdit'));
            $tPoNo          = trim($this->input->post('oetPoNoEdit'));
            $tTotal         = trim($this->input->post('oetMDTotalEdit'));
            $aDataInsert = array(
                "FTPohName"  => $tPoTitle,
                "FTPrjPoStatus" => $tPoStatus,
                "FTPrjPoProgress" => $tProgress,
                "FTPrjPoRemark" => $tRemark,
                "FDPrjPoPlanStart" => $dPlanStart,
                "FDPrjPoPlanFinish" => $dPlanFinish,
                "FTPrjPoRefUrl" => $tUrlRefer,
                "FCPrjPoMdPhp" => $tMDPHP,
                "FCPrjPoMdDev" => $tMDDev,
                "FCPrjPoMdcSharp" => $tMDC,
                "FCPrjPoMdAndroid" => $tMDAndriod,
                "FCPodMdTester" => $tMDTester,
                "FCPrjPoMdSa" => $tMDsa,
                "FCPrjPoMdPm" => $tMDPm,
                "FCPrjPoMdInterface" => $tMDInterface,
                "FTPrjPoDocNo" => $tPoNo,
                "FTPrjCode" => $tProjectCode,
                "FCPodMdTotal" => $tTotal,
                "FDPohDocDate" => $tPoDateEdit

            );
            $tResInsert = $this->Purchase_model->FStMPOUpdateProjectPO($aDataInsert);
            echo $tResInsert;
        } catch (Exception $e) {
            return 'catch';
        }
    }

    /**
     * Functionality : Delete Purchase
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : true or false
     * Return Type : boolean
     */
    public function FSxCPODelete()
    {
        try {
            $tPrjCode = $this->input->post('tPrjCode');
            $tPohDocNo = $this->input->post('FTPohDocNo');
            $this->Purchase_model->FStMPODeletePo($tPohDocNo, $tPrjCode);
        } catch (Exception $e) {
            return 'catch';
        } finally {
            return 'finally';
        }
    }
    /**
     * Functionality : Delete Period
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : true or false
     * Return Type : boolean
     */
    public function FStCPOEventDeletePeriod()
    {
        try {
            $tPeriodCode = $this->input->post('FTPrjPoPeriodCode');
            $pPohDocNo = $this->input->post('pPohDocNo');
            $pPocSeqNo = $this->input->post('pPocSeqNo');

            $this->Purchase_model->FStMPODeletePeriod($tPeriodCode, $pPohDocNo, $pPocSeqNo);
        } catch (Exception $e) {
            return 'catch';
        } finally {
            return 'finally';
        }
    }

    /**
     * Functionality : Event Add Period
     * Parameters : -
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : true or false
     * Return Type : boolean
     */
    public function FStCPOEventAddPeriod()
    {
        try {
            $tPeriodName = trim($this->input->post('oetPeriodName'));
            $tPeriodDate = trim($this->input->post('oetPeriodDate'));
            $tPeriodRemark = trim($this->input->post('oetPeriodRemark'));
            $tPoNo = trim($this->input->post('PohDocNo'));
            $ohdProjectNo = trim($this->input->post('ohdProjectNo'));

            $tPeriodStatus = trim($this->input->post('oetPeriodStatus'));
            $tRefInv = trim($this->input->post('oetRefInv'));


            $aDataInsert = array(
                "FTPpoDocNo"  => $tPoNo,
                "FDPprDate" => $tPeriodDate,
                "FTPprTitle"  => $tPeriodName,
                "FTPprRemark" => $tPeriodRemark,
                "FNPprStatus" => $tPeriodStatus,
                "FTPocRefInv" => $tRefInv,
                "FTPrjCode" => $ohdProjectNo
            );
            $tResInsert = $this->Purchase_model->FStMPOEventSavePeriod($aDataInsert);
            echo $tResInsert;
        } catch (Exception $e) {
            return 'catch';
        } finally {
            return 'finally';
        }
    }
    /**
     * Functionality : Event Get Period
     * Parameters : $pId
     * Creator : 01/11/2023 Boripat
     * Last Modified : 01/11/2023 Boripat
     * Return : json format 
     * Return Type : json
     */
    public function FStCPOGetPeriod($pId, $pNProjectNo)
    {
        $aProjectData       = $this->Purchase_model->FSaMPOGetPeriodAll($pId, $pNProjectNo);
        $id = 1;
        if ($aProjectData) {
            $data = "<table class='table'>";
            foreach ($aProjectData as $result) {
                $data .= '<tr id="row' . $result['FTPrjCode'] . '"><td class="text-center">' . $id . '</td><td>' . $result['FTPocName'] . '</td><td>' .  date('d/m/Y', strtotime($result["FDPocDueDate"])) . '</td><td>' . $result['FTPocRemark'] . '</td><td class="text-end">' . number_format($result['FCPocPercentDone'], 2) .
                    '</td><td><img src="' . base_url('/assets/bin.png') . '" style="width:12px;cursor:pointer" onclick="JStPODeletePeriod(' . "'" . $result['FTPrjCode'] . "'" . "," . "'" . $result['FTPohDocNo'] . "'" . "," . "'" .  $result['FNPocSeqNo'] . "'" . ')"><td>
                <img src="' . base_url('/assets/edit.jpg') . '" style="width:20px;cursor:pointer" onclick="JStPOPeriodEdit(' . "'" . $result['FTPrjCode'] . "'" . "," . "'" . $result['FTPohDocNo'] . "'" . "," . "'" .  $result['FNPocSeqNo'] . "'" . ')"></td>
</tr>';
                $id++;
            }
            $data .= '</table>';

            echo json_encode($data);
        } else {
            $data_no = '<table><tr><td colspan="7" class="text-center">ไม่พบข้อมูล</td></tr></table>';

            echo json_encode($data_no);
        }
    }

    // public function _do_upload()
    // {
    //     $config['upload_path']          = FCPATH  . '/images/';
    //     $config['allowed_types'] = 'jpeg|jpg|png|gif|JPG|PNG|JPEG';
    //     $config['file_name'] = round(microtime(true) * 1000);
    //     $this->load->library('upload', $config);
    //     if (!$this->upload->do_upload('photo')) //upload and validate
    //     {
    //         $data['inputerror'][] = 'photo';
    //         $data['error_string'][] = 'Upload error: ' . $this->upload->display_errors('', ''); //show ajax error
    //         $data['status'] = FALSE;
    //         echo json_encode($data);
    //         exit();
    //     }
    //     return $this->upload->data('file_name');
    // }
}
