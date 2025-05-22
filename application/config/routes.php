<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller']                = 'Login_Controller';
$route['404_override']                      = '';
$route['translate_uri_dashes']              = FALSE;
$route['home']                              = 'Home_Controller';
$route['login']                             = 'Login_Controller';
$route['logout']                            = 'Login_Controller/logout';
$route['Task']                              = 'Task_Controller';


//register
$route['checkemil']                         = 'Login_Controller/checkemail';
$route['sendEmail']                         = 'Login_Controller/sendEmail';
$route['validateEmail/(:any)']                         = 'Login_Controller/validateEmail/$1';
$route['verifyPassword']                    = 'Login_Controller/verify_password';
$route['savePassword']                      = 'Login_Controller/savePassword';
$route['register']                          = 'Login_Controller/register';
$route['registerMember']                    = 'Login_Controller/registerMember';
$route['editmember_page/(:any)']            = 'Login_Controller/editmember/$1';
$route['editmember_event']                  = 'Login_Controller/eventeditmember';
$route['regGetDevRole']                     = 'Login_Controller/FSaCGetDevRole';

$route['PageCreateNewtask']                 = 'Task_Controller/pagecreatenewtask';
$route['CreateNewtask']                     = 'Task_Controller/createnewtask';
$route['CheckStartTask']                    = 'Task_Controller/CheckStartTask';
$route['PauseTask']                         = 'Task_Controller/PauseTask';
$route['StartTask']                         = 'Task_Controller/StartTask';
$route['FinishTask']                        = 'Task_Controller/FinishTask';
$route['DeleteTask']                        = 'Task_Controller/DeleteTask';

$route['CheckCreateTask']                   = 'Task_Controller/CheckCreateTask';

$route['CopyTask']                          = 'Task_Controller/CopyTask';

$route['InsertFilter']                      = 'Task_Controller/InsertFilter';

// เข้างาน

$route['TimeCardCheckIN']                   = 'Task_Controller/TimeCardCheckIN';

// พักเบรก
$route['TimeCardTakeBreak']                 = 'Task_Controller/TimeCardTakeBreak';

//ออกงาน
$route['TimeCardCheckOut']                  = 'Task_Controller/TimeCardCheckOut';

$route['workshop']                          = 'workshop_controller/index';

// Upload Image
$route['UploadImage']                       = 'Task_Controller/UploadImage';

// Project
$route['ProjectList']                       = 'Project_Controller/index';
$route['GetProject']                        = 'Project_Controller/GetProject';
$route['AddNewProject']                     = 'Project_Controller/AddNewProject';
$route['SaveNewProject']                    = 'Project_Controller/SaveNewProject';
$route['DeleteProject']                     = 'Project_Controller/DeleteProject';
$route['EditProject/(:any)']                = 'Project_Controller/EditProject/$1';
$route['UpdateProject']                     = 'Project_Controller/UpdateProject';

// Employee
$route['Employee']                          = 'Employee_Controller/index';
$route['GetEmployee']                       = 'Employee_Controller/GetEmployee';
$route['DeleteEmployee']                    = 'Employee_Controller/DeleteEmployee';

// Leave
$route['masLEVLeave'] = 'Leave_Controller/FCNxCLEVIndex';
$route['masLEVLeaveList'] = 'Leave_Controller/FSxCLEVLeaveDataGetLeave';
$route['masLEVLeaveManage'] = 'Leave_Controller/FSxCLEVLeaveDataLeaveManage';
$route['masLEVLeaveManageList'] = 'Leave_Controller/FSxCLEVLeaveDataGetLeaveManage';
$route['masLEVEventLeaveManagerApprove'] = 'Leave_Controller/FSxCLEVLeaveDataApproveLeave';
$route['masLEVEventLeaveManagerDeny'] = 'Leave_Controller/FSxCLEVLeaveDataDenyLeave';
$route['masLEVEventLeaveEmployeeCancle'] = 'Leave_Controller/FSxCLEVLeaveDataCancle';
$route['masLEVEventLeaveAdd'] = 'Leave_Controller/FSxCLEVLeaveDataAddLeave';
$route['masLEVEventLeaveUpdate'] = 'Leave_Controller/FSxCLEVLeaveDataUpdate';
$route['masLEVEventPostToSheet'] = 'Leave_Controller/FSxCLEVLeaveDataAddToGoogleSheet';
$route['masLEVEventGetLeaveEmployee'] = 'Leave_Controller/FSxCLEVLeaveGetLeaveM';
$route['masLEVEventGetLeaveManager'] = 'Leave_Controller/FSxCLEVLeaveGetLeaveMng';
$route['masLEVEventGetEmployeeByTeam'] = 'Leave_Controller/FSxCLEVLeaveGetDevNameByTeam';
$route['masLEVEventGetAllEmployee'] = 'Leave_Controller/FSxCLEVLeaveGetAllEmployees';
$route['masLEVEventRollback'] = 'Leave_Controller/FSxCLEVLeaveDataRollback';

//SkillRecord
$route['tpjSKRPageSkillRecord'] = 'Skill_Controller/index';
$route['tpjSKREventGetGroupSkillList'] = 'Skill_Controller/FSxCSKRGetGroupSkillList';
$route['tpjSKREventGetSkillList'] = 'Skill_Controller/FSxCSKRGetSkillList';
$route['tpjSKREventGetSkillDev'] = 'Skill_Controller/FSxCSKRGetSkillDev';

$route['tpjSKREventDeleteGroupSkill']       = 'Skill_Controller/FSxCSKRDeleteGroupSkill';
$route['tpjSKREventDeleteSkill']            = 'Skill_Controller/FSxCSKRDeleteSkill';
$route['tpjSKREventDeleteMySkill']          = 'Skill_Controller/FSxCSKRDeleteMySkill';

$route['tpjSKRPageNewGroupSkill']           = 'Skill_Controller/FSxCSKRNewGroupSkill';
$route['tpjSKRPageNewSkill']                = 'Skill_Controller/FSxCSKRNewSkill';
$route['tpjSKRPageNewMySkill']              = 'Skill_Controller/FSxCSKRNewMySkill';

$route['tpjSKRPageSkill']                   = 'Skill_Controller/FSxCSKRSkill';
$route['tpjSKRPageGroupSkill']              = 'Skill_Controller/FSxCSKRGroupSkill';

$route['tpjSKREventAddGroupskill']          = 'Skill_Controller/FSxCSKRAddGroupSkill';
$route['tpjSKREventAddSkill']               = 'Skill_Controller/FSxCSKRAddSkill';
$route['tpjSKREventAddMySkill']             = 'Skill_Controller/FSxCSKRAddMySkill';

// $route['EditProject/(:any)']             = 'Project_Controller/EditProject/$1';
$route['tpjSKRPageEditGroupSkill']          = 'Skill_Controller/FSxCSKREditGroupSkill';
$route['tpjSKRPageEditSkill']               = 'Skill_Controller/FSxCSKREditSkill';
$route['tpjSKRPageEditMySkill']             = 'Skill_Controller/FSxCSKREditMySkill';

$route['tpjSKREventUpdateGroupskill']       = 'Skill_Controller/FSxCSKRUpdateGroupskill';
$route['tpjSKREventUpdateSkill']            = 'Skill_Controller/FSxCSKRUpdateSkill';
$route['tpjSKREventUpdateMySkill']          = 'Skill_Controller/FSxCSKRUpdateMySkill';
$route['tpjSKREventRefreshAddMySkill']      = 'Skill_Controller/FSxCSKRRefreshAddMySkill';
$route['tpjSKREventGetSkillGroup']          = 'Skill_Controller/FSxCSKRGetDataSkillGroup';

$route['eventGetHoliday']                   = 'Login_Controller/FSaCGetHoliday';
//PO Route
// $route['docPOPageListView/(:any)'] = 'Purchase_controller/FStCPODataListView/$1';
// $route['docPOGetData']             = 'Purchase_controller/FSxCPOGetProjectPo';
// $route['docPOPageAdd']             = 'Purchase_controller/FStCPOPageAdd';
// $route['docPOEventAdd']            = 'Purchase_controller/FStCPOEventAddData';
// $route['docPOEventEdit/(:any)/(:any)']    = 'Purchase_controller/FStCPOPageEdit/$1/$2';
// $route['docPOEventUpdate']         = 'Purchase_controller/FStEventCPOUpdate';
// $route['docPOEventDelete']         = 'Purchase_controller/FSxCPODelete';
// $route['docPOEventAddPeriod']      = 'Purchase_controller/FStCPOEventAddPeriod';
// $route['docPOGetPeriod/(:any)/(:any)']    = 'Purchase_controller/FStCPOGetPeriod/$1/$2';
// $route['docPOEventDeletePeriod']   = 'Purchase_controller/FStCPOEventDeletePeriod';
// $route['docPOEventGetPeriodEdit']  = 'Purchase_controller/FStCPOEditPeriod';
// $route['docPOEventUpdatePeriod']   = 'Purchase_controller/FStCPOUpdatePeriod';

// PO New route
$route['docPOPageListView'] = 'Purchase_controller/FStCPODataListView';
$route['docPOGetData'] = 'Purchase_controller/FStCPOGetPoList';
$route['docPOPageAdd'] = 'Purchase_controller/FStCPOPageAdd';
$route['docPOPageEdit/(:any)'] = 'Purchase_controller/FStCPOPageEdit/$1';
$route['docPOEventAdd'] = 'Purchase_controller/FStCPOEventAddData';
$route['docPOEventEdit'] = 'Purchase_controller/FStCPOEventEditData';
$route['docPOEventDelete'] = 'Purchase_controller/FStCPOEventDeleteData/$1';
$route['docPOEventExportExcel'] = 'Purchase_controller/FSxCPOEventExportExcel';

$route['docPOEventAddPay'] = 'Purchase_controller/FStCPOEventAddPayData';
$route['docPOEventEditPay'] = 'Purchase_controller/FStCPOEventEditPayData';
$route['docPOGetDataPay'] = 'Purchase_controller/FStCPOGetPayList';
$route['docPOGetDataPayEdit'] = 'Purchase_controller/FSaCPOGetDataPay';
$route['docPOEventAddPat'] = 'Purchase_controller/FStCPOEventAddPatData';
$route['docPOEventEditManday'] = 'Purchase_controller/FStCPOEventEditManday';
$route['docPOEventAddDoc'] = 'Purchase_controller/FStCPOEventAddDocData';
$route['docPOEventAddUrl'] = 'Purchase_controller/FStCPOEventAddUrlData';
$route['docPOGetDataDocEdit'] = 'Purchase_controller/FSaCPOGetDataDoc';
$route['docPOGetDataUrlEdit'] = 'Purchase_controller/FSaCPOGetDataUrl';
$route['docPOEventDeleteDataDoc'] = 'Purchase_controller/FStCPOEventDeleteDataDoc';
$route['docPOEventDeleteDataUrl'] = 'Purchase_controller/FStCPOEventDeleteDataUrl';
$route['docPOEventDeleteDataPay'] = 'Purchase_controller/FStCPOEventDeleteDataPay';
$route['docPOGetDataPat'] = 'Purchase_controller/FSaCPOGetDataPat';
$route['docPOGetDataPatEdit'] = 'Purchase_controller/FSaCPOGetDataPatEdit';
$route['docPOEventEditPat'] = 'Purchase_controller/FStCPOEventEditPatData';
$route['docPOGetLastPayNo'] = 'Purchase_controller/FStCPOGetLastPayNo';

// Project Team route
$route['masPJTPageListView'] = 'Projectteam_controller/FStCPJTListView';
$route['masPJTGetData'] = 'Projectteam_controller/FStCPJTGetDataList';
$route['masPJTPageAdd'] = 'Projectteam_controller/FStCPJTPageAdd';
$route['masPJTPageEdit/(:any)'] = 'Projectteam_controller/FStCPJTPageEdit/$1';
$route['masPJTEventAdd'] = 'Projectteam_controller/FStCPJTEventAddData';
$route['masPJTEventEdit'] = 'Projectteam_controller/FStCPJTEventEditData';
$route['masPJTEventDelete'] = 'Projectteam_controller/FStCPJTEventDeleteData';
$route['masPJTEventFilterOption'] = 'Projectteam_controller/FStCPJTEventFilterOption';


// Task route
$route['masTSKGetRelease'] = 'Task_Controller/FSaCTSKGetRelease';
$route['masTSKUpdatePO'] = 'Task_Controller/FSaCTSKUpdatePO';

//Dashboard Monitoring route
$route['docDBPageView'] = 'Dashboard_controller/FSaCDBDataPO';
$route['docDBGetData'] = 'Dashboard_controller/FSaCDBGetListDBPo';

// WorkShop Excel
$route['docDBExportExcelPrjUrgent'] = 'Dashboard_controller/FSxCDBExportExcelPrjUrgent';
// WorkShop API
$route['workshopApi'] = 'workshop_controller/workshopAPI';
$route['workshopApiSendURL'] = 'workshop_controller/sendURL';