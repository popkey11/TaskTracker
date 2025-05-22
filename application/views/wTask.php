<?php include(APPPATH . 'views/wHeader.php') ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script>
$(document).ready(function() {
    $(".dropdown-toggle").dropdown();
    $.mask.definitions['2'] = '[012]';
    $.mask.definitions['3'] = '[0123456789]';
    $.mask.definitions['5'] = '[012345]';
    $.mask.definitions['9'] = '[0123456789]';
    $('.TimeMarker').mask('23:59');


});
</script>

<style>
.row-full {
    width: 100%;
    margin: 0px;
    padding: 0px;
}

.Titlebar {
    padding: 10px;
    color: #ffffff;
}

.login-box {
    margin-top: 200px;
    margin-left: 33%;
    margin-right: 33%;
}

.login-title {
    text-align: center;
}

.more-info {
    padding-left: 0px;
    padding-right: 0px;
    padding-top: 0px;
    padding-bottom: 10px;
    font-size: 12px;
    color: red;
}

.Content-box {
    margin-top: 20px;
    margin-left: 10px;
    margin-right: 10px;
}

.bottom-line {
    margin-right: 5px;
}

.btn-outline-secondary {
    color: #c1bbbb !important;

    border-color: #c1bbbb !important;
}

#odvMobileView td,
th {
    font-size: 1.2em !important;
}

#odvWindowsView th,
td,
button {
    font-size: 13px !important;
}

#odvWindowsView th {
    font-weight: bold !important;
}

.ui-state-default,
.ui-widget-content .ui-state-default,
.ui-widget-header .ui-state-default,
/* .ui-button,   */
.ui-button.ui-state-disabled:hover {
    background-color: #FFFFFF !important;
}

.ui-state-active {
    color: #000000 !important;
}

#odvMobileView td,
th {
    font-size: 13px !important;
    font-weight: normal;
}

.ui-widget-header {
    background-color: #FFFFFF !important;
}

.ui-datepicker .ui-datepicker-title select {
    font-size: 15px !important;
}

.ui-datepicker-trigger {
    margin-left: -23px !important;
    margin-top: -5px !important;
    cursor: pointer !important;
}

.datepicker {
    padding: 5px !important;
}


th p {
    margin-bottom: 0px !important;
}

/* {
        background-color:FFFFFF!important;
    } */

#otdRemark>img {
    width: 100% !important;
}

.active {
    color: blue !important;
}

</style>

<title><?= $tTitle ?></title>

<body>


    <img src="<?php echo base_url('/assets/WorkingBg.png');?>" style="opacity: 0.2; position: absolute;
        right: 0px;
        bottom: 0px; width: 50%; z-index:-1">

	<?php include(APPPATH. 'views/menu/wMenu.php') ?>

    <div class="container-fluid" style="border-bottom:1px solid #cccccc;font-size:13px">

        <nav class="navbar navbar-light">
            <div>
                <div>
                    <!-- <a class="navbar-brand Title-bar" style="font-size:16px">ข้อมูลการทำงาน </a> -->
                    <!-- <a href="https://lookerstudio.google.com/u/0/reporting/1a56393f-c161-4f82-8d24-f40b27377f1d/page/aCNED?s=ryJ5gzQ8mf0"
                        target="_blank">[Dashboard]</a> -->
                </div>
                <div>
                    <h6>
                        <span class="badge bg-success">
                            เวลาทำงานรวม(วันนี้)

                            <?php //print_r($SummaryTimes);
                                if($SummaryTimes["rtCode"] == '200'){

                                    if($SummaryTimes["raItems"][0]['EfMinutes'] >= 60){
                                        $nRndToHr   = floor($SummaryTimes["raItems"][0]['EfMinutes'] / 60);
                                        $nTotalHr   = $SummaryTimes["raItems"][0]['EfHours']   + $nRndToHr;
                                        $nTotalMn   = $SummaryTimes["raItems"][0]['EfMinutes']  - ($nRndToHr * 60);
                                    }else{
                                        $nTotalHr   = $SummaryTimes["raItems"][0]['EfHours'];
                                        $nTotalMn   = $SummaryTimes["raItems"][0]['EfMinutes'];
                                    }
                                    echo $SummaryTimes["raItems"][0]['EfDAY'].' วัน ';
                                    echo $nTotalHr.' ชั่วโมง ';
                                    echo $nTotalMn.' นาที ';
                                }
                            ?>
                        </span>
                    </h6>
                </div>
            </div>

            <div style="padding-left:10px;">
                <?php
                    if($aTimeCard['rtCode'] == '200'){
                        $dCheckIn   = $aTimeCard['raItems'][0]['FDTadChkIn'];
                        $dBreakOut  = $aTimeCard['raItems'][0]['FDTadBreakOut'];
                        $dChkOut    = $aTimeCard['raItems'][0]['FDTadChkOut'];
                    }else{
                        $dCheckIn   = '';
                        $dBreakOut  = '';
                        $dChkOut    = '';
                    }
                ?>

                <?php if($dCheckIn !=''){ ?>
                <button type="button" class="btn btn-dark" disabled>เข้า : <?=$dCheckIn?></button>
                <?php } else { ?>
                <!-- <button type="button" class="btn btn-outline-primary" id="obtCheckIn"
                    onclick="TimeCardCheckIN()">เข้างาน</button> -->
                <?php } ?>

                <!-- <?php if($dBreakOut !=''){ ?>
                    <button type="button" class="btn btn-dark" disabled>เบรก : <?=$dBreakOut?></button> 
                <?php } else { ?>
                    <button type="button" class="btn btn-outline-primary" onclick="TimeCardTakeBreak()">พักเบรก</button>
                <?php } ?> -->

                <?php if($dChkOut !=''){ ?>
                <button type="button" class="btn btn-dark" disabled>ออก : <?=$dChkOut?></button>
                <?php } else { ?>
                <!-- <button type="button" class="btn btn-outline-primary" onclick="TimeCardCheckOut()">ออกงาน</button> -->
                <?php } ?>
            </div>
            <div>
                <table>
                    <tr>
                        <td style="padding-right:5px;">วันที่ </td>
                        <td>
                            <?php 
                                if(isset($dFilter)){
                                    if($dFilter != '' ){
                                        $dFilterDate = $dFilter;
                                    }else{
                                        $dFilterDate = date('Y-m-d');
                                    }
                                }else{
                                    $dFilterDate = date('Y-m-d');
                                }
                            ?>
                            <input type="date" class="form-control" id="odpTaskStartDate" placeholder="dd-mm-yyyy"
                                value="<?php echo $dFilterDate; ?>">
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-dark" onclick="InsertFilter()">กรอง</button>
                        </td>
                    </tr>
                </table>
            </div>

            <?php if($TaskList["rtCode"] == '200'){ ?>
            <div class="text-end">
                <a onclick="CheckCreteTask('1')" class="btn btn-primary" style="font-size:14px">+งานใหม่</a>
            </div>
            <?php } ?>
        </nav>

    </div>

    <div class="row Content-box">

        <?php if($TaskList["rtCode"] == '800'){ ?>
        <div class="col-lg-3 col-md-12 col-sm-12">
            <div class="card" style="width: 100%;">
                <img class="card-img-top" src="<?php echo base_url('/assets/Working.png');?>" alt="Card image cap">
                <div class="card-body">
                    <?php 
                            echo 'ค้นหาข้อมูลวันที่ : '.$dFilter;

                            if($dFilter != date('Y-m-d')){
                        ?>
                    <h5 class="card-title">ไม่พบข้อมูลการทำงานในวันที่คุณค้นหา!</h5>
                    <?php 
                            } else { 
                        ?>
                    <h5 class="card-title">วันนี้คุณยังว่างงานอยู่!</h5>
                    <p class="card-text">มาเริ่มทำงานกันเลยดีกว่า โดยกดปุ่มเพิ่มงานใหม่เพื่อเพิ่ม Task งานได้เลยครับ</p>
                    <a href="<?php echo base_url('index.php/PageCreateNewtask');?>"
                        class="btn btn-primary">เพิ่มงานใหม่</a>
                    <?php 
                            } 
                        ?>
                </div>
            </div>
        </div>

        <?php } else { ?>

        <div class="col-lg-12 col-md-12 col-sm-12" id="odvMobileView" style="display:none">
            <?php  foreach($TaskList["raItems"] as $key0=>$val0){ ?>
            <div class="card" style="margin-bottom:10px">
                <div class="card-body" style="font-size: 20px;">
                    <table>
                        <tr>
                            <th>รายละเอียดงาน</th>
                            <td style="padding-left: 5px"><?php echo $val0['FTTskName']?></td>
                        </tr>
                        <tr>
                            <th>หมายเหตุ</th>
                            <td style="padding-left: 5px">
                                <?php echo $val0['FTTskRemark']?><?php echo $val0['FTTskRemarkEnd']?>
                            </td>
                        </tr>
                        <tr>
                            <th>โปรเจค</th>
                            <td style="padding-left: 5px"><?php echo $val0['FTPrjName']?></td>
                        </tr>
                        <tr>
                            <th>สถานะ</th>
                            <td style="padding-left: 5px">
                                <?php 
                                            switch ($val0['FTTskStatus']) {
                                                case '':
                                                    echo 'รอทำงานนี้';
                                                    break;
                                                case 1:
                                                    echo 'กำลังทำงานนี้อยู่';
                                                    break;
                                                case 2:
                                                    echo 'หยุดชั่วคราว';
                                                    break;
                                                case 3:
                                                    echo 'จบงานแล้ว';
                                                    break;
                                                default:
                                                echo 'ไม่ระบุ';
                                            }
                                        ?>
                            </td>
                        </tr>
                        <tr>
                            <th>วันที่เริ่มต้น</th>
                            <td style="padding-left: 5px"><?php echo $val0['FDTskStart'];?></td>
                        </tr>
                        <tr>
                            <th>วันที่เสร็จสิ้น</th>
                            <td style="padding-left: 5px"><?php echo $val0['FDTskFinish'];?></td>
                        </tr>
                        <tr>
                            <th>เวลาที่ใช้</th>
                            <td style="padding-left: 5px">
                                <?php echo $val0['EfDAY']?> วัน
                                <?php echo $val0['EfHours']?> ชม.
                                <?php echo $val0['EfMinutes']?> นาที
                            </td>
                        </tr>
                    </table>
                    <div class="text-end">
                        <?php
                                    //   เริ่มงาน
                                    if($val0['FTTskStatus'] == 1 or $val0['FTTskStatus'] == 3){
                                        $tBntStart0         = 'disabled';
                                        $tBntStartClass0    = 'btn-outline-secondary';
                                    }else{
                                        $tBntStart0         = '';
                                        $tBntStartClass0    = 'btn-outline-success';
                                    }

                                    //   หยุดชั่วคราว
                                    if($val0['FTTskStatus'] == 2 or $val0['FTTskStatus'] == 3 or $val0['FTTskStatus'] != 1){
                                        $tBntPause0         = 'disabled';
                                        $tBntPauseClass0    = 'btn-outline-secondary';
                                    }else{
                                        $tBntPause0         = '';
                                        $tBntPauseClass0    = 'btn-outline-warning';
                                    }

                                    //   จบงาน
                                    if($val0['FTTskStatus'] == 3 or $val0['FTTskStatus'] == '' ){
                                        $tBntFinish0        = 'disabled';
                                        $tBntFinisheClass0  = 'btn-outline-secondary';
                                    }else{
                                        $tBntFinish0        = '';
                                        $tBntFinisheClass0  = 'btn-outline-danger';
                                    }

                                    if($val0['FTTskStatus'] == 1 or $val0['FTTskStatus'] == 2){
                                        $tTextStartTask0    = ' ทำต่อ ';
                                    }else{
                                        $tTextStartTask0    = 'เริ่มงาน';
                                    }
                                ?>

                        <?php if($val0['FTTskStatus'] != 3) { ?>

                        <!-- <button type="button" class="btn <?php echo  $tBntStartClass0;?>" <?php echo $tBntStart0; ?>
                                        onclick="CheckStartTask('<?=$val0['FTTskID']?>')"><?=$tTextStartTask0?></button> -->

                        <!-- <button type="button" class="btn <?php echo  $tBntPauseClass0;?>" <?php echo $tBntPause0; ?>
                                        onclick="PauseTask('<?=$val0['FTTskID']?>')">หยุดชั่วคราว</button> -->

                        <button type="button" class="btn <?php echo  $tBntFinisheClass0;?>" <?php echo $tBntFinish0; ?>
                            onclick="ConfirmEndTask(<?=$val0['FTTskID']?>)">จบงาน</button>

                        <button type="button" class="btn btn-outline-danger"
                            onclick="ConfirmDeleteTask('<?=$val0['FTTskID']?>')">ลบ</button>

                        <?php } else { ?>
						<button type="button" class="btn btn-outline-danger"
								onclick="ConfirmDeleteTask('<?=$val0['FTTskID']?>')">ลบ</button>
							
                        <button type="button" class="btn btn-outline-primary"
                            onclick="CopyTask('<?=$val0['FTTskID']?>')">คัดลอก</button>

                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 table-responsive-sm" id="odvWindowsView"
            style="display:none;width:100%; table-layout: fixed;">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">ลบ</th>
                        <th scope="col">รายละเอียดงาน</th>
                        <th scope="col">หมายเหตุ</th>
                        <th scope="col">โปรเจค</th>
						<th scope="col">PO</th>
                        <th scope="col">สถานะ</th>
                        <th scope="col">วันที่เริ่ม</th>
                        <th scope="col">วันที่เสร็จสิ้น</th>
                        <th scope="col">เวลาที่ใช้</th>
                        <th scope="col" class="text-end"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php  foreach($TaskList["raItems"] as $key=>$val){ ?>
                    <tr>
                        <th style="padding-top:8px;width:3%"><img src="<?php echo base_url('/assets/bin.png');?>"
                                onclick="ConfirmDeleteTask('<?=$val['FTTskID']?>')">
                        </th>
                        <td style="width:23%;word-break: break-all;">

                            <?php  if($val['FTTskStatus']== 1){ ?>
                            <img src="<?php echo base_url('/assets/Start.png');?>">
                            <?php  } else if($val['FTTskStatus']== 2) {?>
                            <img src="<?php echo base_url('/assets/hold.png');?>">
                            <?php  } else { ?>
                            <img src="<?php echo base_url('/assets/Finish.png');?>">
                            <?php } ?>

                            <?php echo $val['FTTskName']?>

                        </td>
                        <td style="width:15%; word-break: break-all; " id="otdRemark">
                            <?php 
                                        $order_replace   = array("<p>", "</p>");
                                        echo str_replace($order_replace, "" , $val['FTTskRemark']); 
                                    ?>

                            <?php 
                                        $order_replace   = array("<p>", "</p>");
                                        echo str_replace($order_replace, "" , $val['FTTskRemarkEnd']); 
                                    ?>
                        </td>
                        <td style="width:10%"><?php echo $val['FTPrjName']?></td>
						<td style="width:15%">
							<?php if($val['FNCountPo'] > 0) : ?>
							<div class="input-group">
								<span class="po-text" style="padding:4px">
									<?php
									echo $val['FTPoRelease'];
									?>
								</span>
														<select class="po-release"
																data-prjcode="<?php echo $val['FTPrjCode']?>"
																data-pocurrent="<?php echo $val['FTPoCode']?>"
																data-taskid="<?php echo $val['FTTskID']?>"
																style="display:none;"
																data-width="100%"
																data-style="btn-light btn-sm">
														</select>
														<div class="ms-auto">
															<i class="fa fa-pencil edit-po" style="cursor:pointer; padding:8px; color:#6c757d;" title="แก้ไข PO"></i>
															<i class="fa fa-save save-po" style="cursor:pointer; padding:8px; color:#198754; display:none;" title="บันทึก"></i>
															<i class="fa fa-times cancel-po" style="cursor:pointer; padding:8px; color:#dc3545; display:none;" title="ยกเลิก"></i>
														</div>
													</div>
							<?php endif;?>
						</td>
                        <td style="width:7%">
                            <?php
                                        switch ($val['FTTskStatus']) {
                                            case '':
                                                echo 'รอทำงานนี้';
                                                break;
                                            case 1:
                                                echo 'กำลังทำงานนี้อยู่';
                                                break;
                                            case 2:
                                                echo 'หยุดชั่วคราว';
                                                break;
                                            case 3:
                                                echo 'จบงานแล้ว';
                                                break;
                                            default:
                                            echo 'ไม่ระบุ';
                                        }
                                    ?>
                        </td>
                        <td style="width:7%" id="otdDateTimeStart" data-datestart="<?php echo $val['FTTskDateStart']?>"
                            data-timestart="<?php echo $val['FTTskTimeStart']?>">
                            <?php echo $val['FDTskStart']?>
                        </td>
                        <td style="width:7%"><?php echo $val['FDTskFinish']?></td>
                        <td style="width:7%">
                            <?php echo $val['EfDAY']?> วัน <?php echo $val['EfHours']?> ชม.
                            <?php echo $val['EfMinutes']?> นาที
                        </td>
                        <td class="text-end" style="width:7%">
                            <?php 
                                        //   เริ่มงาน
                                        if($val['FTTskStatus'] == 1 or $val['FTTskStatus'] == 3){
                                            $tBntStart      = 'disabled';
                                            $tBntStartClass = 'btn-outline-secondary';
                                        }else{
                                            $tBntStart      = '';
                                            $tBntStartClass = 'btn-outline-success';
                                        }

                                        //   หยุดชั่วคราว
                                        if($val['FTTskStatus'] == 2 or $val['FTTskStatus'] == 3 or $val['FTTskStatus'] != 1){
                                            $tBntPause      = 'disabled';
                                            $tBntPauseClass = 'btn-outline-secondary';
                                        }else{
                                            $tBntPause      = '';
                                            $tBntPauseClass = 'btn-outline-warning';
                                        }

                                        //   จบงาน
                                        if($val['FTTskStatus'] == 3 or $val['FTTskStatus'] == '' ){
                                            $tBntFinish         = 'disabled';
                                            $tBntFinisheClass   = 'btn-outline-secondary';
                                        }else{
                                            $tBntFinish         = '';
                                            $tBntFinisheClass   = 'btn-outline-danger';
                                        }

                                        if($val['FTTskStatus'] == 1 or $val['FTTskStatus'] == 2){
                                            $tTextStartTask = ' ทำต่อ ';
                                        }else{
                                            $tTextStartTask = 'เริ่มงาน';
                                        }
                                    
                                    ?>

                            <?php if($val['FTTskStatus'] != 3) { ?>

                            <!-- <button type="button" class="btn <?php echo  $tBntStartClass;?>" <?php echo $tBntStart; ?>onclick="CheckStartTask('<?=$val['FTTskID']?>')"><?=$tTextStartTask?></button> -->

                            <!-- <button type="button" class="btn <?php echo  $tBntPauseClass;?>" <?php echo $tBntPause; ?>onclick="PauseTask('<?=$val['FTTskID']?>')">หยุดชั่วคราว</button> -->

                            <!-- <button type="button" class="btn <?php echo  $tBntFinisheClass;?>" data-bs-toggle="modal" data-bs-target="#exampleModal"<?php echo $tBntFinish; ?> onclick="FinishTask('<?=$val['FTTskID']?>')">จบงาน</button> -->

                            <button type="button" class="btn <?php echo  $tBntFinisheClass;?>"
                                onclick="ConfirmEndTask(<?=$val['FTTskID']?>)"> จบงาน </button>

                            <?php } else { ?>

                            <button type="button" class="btn btn-outline-primary"
                                onclick="CopyTask('<?=$val['FTTskID']?>')">คัดลอก</button>

                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
    <!-- </div> -->

    <!-- Button trigger modal -->
    <button type="button" id="omdEndTask" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
        data-backdrop="static" data-keyboard="false" style="display:none">
    </button>

    <!-- Modal -->
    <div class="modal modal-lg fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">ยืนยันการจบงาน</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="col-md-6 col-sm-12">
                                <label>วันที่-เวลา เริ่มงาน</label>
                            </div>
                            <input type="text" id="odpDateInEMode" class="datepicker" placeholder="mm/dd/yyyy" readonly>
                            <input type="text" class="TimeMarker" id="oetTimeInEMode"
                                style="padding:5px;width:100px;text-align:center" placeholder=" hh:ii ">
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <div class="col-md-6 col-sm-12">
                                <label>วันที่-เวลา เสร็จสิ้น</label>
                            </div>
                            <input type="text" id="odpDateOutEMode" class="datepicker" placeholder="mm/dd/yyyy" readonly
                                value="<?php echo date('d/m/Y');?>">
                            <input type="text" class="TimeMarker" id="oetTimeOutEMode"
                                style="padding:5px;width:100px;text-align:center" placeholder="hh:ii"
                                value="<?php echo date('H:i');?>">
                        </div>
                    </div>

                    <!-- <table class="tb-closetask" style="font-size: 16px !important;">
                        <tr>
                            <td style="font-size: 16px !important;">วันที่-เวลา เริ่มงาน<br><input type="text"
                                    id="odpDateInEMode" class="datepicker" placeholder="mm/dd/yyyy" readonly>
                                <input type="text" class="TimeMarker" id="oetTimeInEMode"
                                    style="padding:5px;width:100px;text-align:center" placeholder=" hh:ii ">
                            </td>
                            <td style="font-size: 16px !important;">วันที่-เวลา เสร็จสิ้น<br><input type="text"
                                    id="odpDateOutEMode" class="datepicker" placeholder="mm/dd/yyyy" readonly
                                    value="<?php echo date('d/m/Y');?>">
                                <input type="text" class="TimeMarker" id="oetTimeOutEMode"
                                    style="padding:5px;width:100px;text-align:center" placeholder="hh:ii"
                                    value="<?php echo date('H:i');?>">
                            </td>
                        </tr>
                    </table> -->

                    <label>หมายเหตุ</label>
                    <textarea name="oetConfirmEndTask" id="oetEndTaskRmk" rows="3" class="form-control"
                        style="display:none">
                    </textarea>

                    <div id="odvSummerRemarkText"></div>
                    <script>
                    $('#odvSummerRemarkText').summernote({
                        placeholder: 'กรอกหมายเหตุ',
                        tabsize: 2,
                        height: 120,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'underline', 'clear', 'fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']],
                            //   ['insert', ['link', 'picture', 'video']],
                            // ['view', ['fullscreen']]
                            //   ['view', ['fullscreen', 'codeview', 'help']]
                        ],
                        callbacks: {
                            onImageUpload: function(files) {
                                for (let i = 0; i < files.length; i++) {
                                    $.upload(files[i]);
                                }
                            }
                        }
                    });
                    </script>

                </div>
                <input type="hidden" id="oetTaskIDEnd" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button type="button" class="btn btn-primary" onclick="FinishTask()">ยืนยัน</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(function() {
        var dateBefore = null;
        $(".datepicker").datepicker({
            dateFormat: 'dd/mm/yy',
            showOn: 'button',
            buttonImage: '<?php echo base_url('/assets/calendar.png');?>',
            buttonImageOnly: true,
            dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
            monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ],
            changeMonth: true,
            changeYear: true,
            onClose: function() {
                if ($(this).val() != "" && $(this).val() == dateBefore) {
                    var arrayDate = dateBefore.split("-");
                    arrayDate[2] = parseInt(arrayDate[2]) + 543;
                    $(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
                }
            }
        });

    });
    </script>

    <script>
    const myModal = document.getElementById('myModal')
    const myInput = document.getElementById('myInput')

    // $('#odvSummerRemarkText').summernote({
    //     callbacks: {
    //         onImageUpload: function(files) {
    //             for(let i=0; i < files.length; i++) {
    //                 alert(111);
    //                 $.upload(files[i]);
    //             }
    //         }
    //     },
    //     height: 500,
    // });

    $.upload = function(file) {
        let out = new FormData();
        out.append('file', file, file.name);
        $.ajax({
            method: 'POST',
            url: '<?=base_url('/index.php/UploadImage')?>',
            contentType: false,
            cache: false,
            processData: false,
            data: out,
            success: function(img) {
                // alert(img)
                console.log(img);
                $('#odvSummerRemarkText').summernote('insertImage', img);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error(textStatus + " " + errorThrown);
            }
        });
    };

	$("#odpDateInEMode").on("change", function() {
		$("#odpDateOutEMode").val($(this).val());
	});

    function ConfirmEndTask(ptTaskID) {
        var tDateStart = $("#otdDateTimeStart").data("datestart");
        var tTimeStart = $("#otdDateTimeStart").data("timestart");
        // alert(tDateStart);
        $("#odpDateInEMode").val(tDateStart);
        $("#oetTimeInEMode").val(tTimeStart);

        var t = new Date();
        var TimeNow = t.toLocaleString('en-GB');
        TimeNow = TimeNow.slice(12);
        TimeNow = TimeNow.substring(0, 5);

        $("#oetTimeOutEMode").val(TimeNow)

        $("#oetTaskIDEnd").val(ptTaskID);
        $("#omdEndTask").click();
    }

    function CheckCreteTask(ptTaskID) {
        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/CheckCreateTask')?>",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult > 0) {
                    alert(
                        'ไม่สามารถเพิ่มงานใหม่ได้เนื่องจากคุณมีงานที่ทำค้างอยู่ กรุณาจบงานก่อนหน้า ก่อนจะเพิ่มงานใหม่'
                    );
                } else {
                    window.location = "<?=base_url('/index.php/PageCreateNewtask')?>";
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }

    function CheckStartTask(ptTaskID) {
        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/CheckStartTask')?>",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult > 0) {
                    alert(
                        'ไม่สามารถเริ่มงานใหม่ได้เนื่องจากคุณมีงานที่ทำค้างอยู่ กรุณาจบงานก่อนหน้า ก่อนจะเริ่มงานใหม่'
                    );
                } else {
                    StartTask(ptTaskID);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }

    function PauseTask(ptTaskID) {
        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/PauseTask')?>",
            data: {
                'ptTaskID': ptTaskID
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }

    function StartTask(ptTaskID) {
        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/StartTask')?>",
            data: {
                'ptTaskID': ptTaskID
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }

    function FinishTask() {
        const search = '/';
        const searchRegExp = new RegExp(search, 'g'); // Throws SyntaxError
        const replaceWith = '';

        const tDateStart_cp = moment($("#odpDateInEMode").val().replace(searchRegExp, replaceWith), 'DD/MM/YYYY');
        const tDateFinish_cp = moment($("#odpDateOutEMode").val().replace(searchRegExp, replaceWith), 'DD/MM/YYYY');

        const search2 = ':';  
        const searchRegExp2 = new RegExp(search2, 'g'); // Throws SyntaxError

        const tTimeStart_cp = $("#oetTimeInEMode").val().replace(searchRegExp2, replaceWith);
        const tTimeFinish_cp = $("#oetTimeOutEMode").val().replace(searchRegExp2, replaceWith);

        if (tDateFinish_cp < tDateStart_cp) {
            alert('กำหนดวันที่เสร็จสิ้นไม่ถูกต้อง วันที่เสร็จสิ้นต้องมากกว่าหรือเท่ากับวันที่เริ่มงาน');
        } else {
            if (tTimeStart_cp.substring(0, 2) >= 24 || tTimeStart_cp.substring(4, 2) > 59) {
                alert('กำหนดเวลาเริ่มงานไม่ถูกต้อง');
            } else if (tTimeFinish_cp.substring(0, 2) >= 24 || tTimeFinish_cp.substring(4, 2) > 59) {
                alert('กำหนดเวลาเสร็จงานไม่ถูกต้อง');
            }

            //  วันที่เดียวกัน แต่เวลาไม่เท่ากัน
            if (tDateStart_cp == tDateFinish_cp && tTimeStart_cp != tTimeFinish_cp) {
                if (tTimeStart_cp > tTimeFinish_cp) {
                    alert('เวลาเสร็จงานต้องมากกว่าเวลาเริ่มงาน');
                } else {
                    CommitFinishTask();
                }
            } else {
                CommitFinishTask();
            }
        }
    }

    function CommitFinishTask() {
        var tRemarkText = $(".note-editable").html();
        $("#oetEndTaskRmk").val(tRemarkText);
        var ptTaskID = $("#oetTaskIDEnd").val();
        var ptEndTaskRmk = $("#oetEndTaskRmk").val();
        // alert(ptTaskID + '' + ptEndTaskRmk)
        // วันที่เริ่มงาน
        var dDateInEMode = $("#odpDateInEMode").val();
        console.log('Start Date :' + dDateInEMode);
        // เวลาเริ่มงาน
        var tTimeInEMode = $("#oetTimeInEMode").val();
        console.log('Start Time :' + tTimeInEMode);

        // วันที่จบงาน
        var dDateOutEMode = $("#odpDateOutEMode").val();
        console.log('Finish Date :' + dDateOutEMode);
        // เวลาจบงาน
        var tTimeOutEMode = $("#oetTimeOutEMode").val();
        console.log('Finish Time :' + tTimeOutEMode);
        console.log('TaskID :' + ptTaskID);
        console.log('Task Remark :' + ptEndTaskRmk);
        // exit();
        if (tTimeInEMode == '') {
            alert('กรุณากรอกเวลาเริ่มงาน');
        } else if (tTimeOutEMode == '') {
            alert('กรุณากรอกเวลาจบงาน');
        } else {
            $.ajax({
                type: "POST",
                url: "<?=base_url('/index.php/FinishTask')?>",
                data: {
                    'ptTaskID': ptTaskID,
                    'ptEndTaskRmk': ptEndTaskRmk,
                    'dDateInEMode': dDateInEMode,
                    'tTimeInEMode': tTimeInEMode,
                    'dDateOutEMode': dDateOutEMode,
                    'tTimeOutEMode': tTimeOutEMode
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {

                    console.log(tResult);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }


            });
        }

    }

    function ConfirmDeleteTask(ptTaskID) {
        if (confirm("ยืนยันที่จะลบงานนี้ออกจากระบบใช่หรือไม่") == true) {
            $.ajax({
                type: "POST",
                url: "<?=base_url('/index.php/DeleteTask')?>",
                data: {
                    'ptTaskID': ptTaskID
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }
            });

        }
    }

    function CopyTask(ptTaskID) {
        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/CopyTask')?>",
            data: {
                'ptTaskID': ptTaskID
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult == 'error') {
                    alert('ไม่สามารถคัดลอกงานได้ กรุณาจบงานที่คุณทำค้างอยู่ ก่อนทำการคัดลอกงาน');
                } else {
                    location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }
    </script>

    <p id="result"></p>
    <script>
    $(document).ready(function() {
        myfunction();
		JSxPOFunction();
    });

	function JSxPOFunction() {
		// Edit button click
		$('.edit-po').on('click', function() {
			const btn = $(this);
			const group = btn.closest('.input-group');
			const select = group.find('select.po-release'); // Target actual select element
			const text = group.find('.po-text');
			const saveBtn = group.find('.save-po');
			const editBtn = group.find('.edit-po');
			const cancelBtn = group.find('.cancel-po');
			const prjcode = select.attr('data-prjcode'); // Use attr instead of data
			const currentPO = select.attr('data-pocurrent'); // Use attr instead of data

			// Store original value
			group.data('original-prjcode', prjcode);
			group.data('original-pocode', currentPO);
			// Destroy existing selectpicker if exists
			if (select.hasClass('selectpicker')) {
				select.selectpicker('destroy');
			}

			// Load options from server
			$.ajax({
				type: "POST",
				url: "<?=base_url('/index.php/masTSKGetRelease')?>",
				data: {
					"tPrjCode": prjcode
				},
				cache: false,
				success: function(paResponse) {
					// Clear existing options except first one
					select.find('option').remove();

					let aRes = JSON.parse(paResponse);
					if (aRes.rtCode == '200') {
						// Add new options
						aRes.raItems.forEach(function(item) {
							const option = new Option(
								item.FTPoRelease,
								item.FTPoCode,
								item.FTPoCode === currentPO, // selected state
								item.FTPoCode === currentPO  // selected state
							);
							select.append(option);
						});

						// Show dropdown and buttons
						select.selectpicker('refresh');
						select.selectpicker('show');
						text.hide();
						editBtn.hide();
						saveBtn.show();
						cancelBtn.show();
					} else if(aRes.rtCode == '404'){
						editBtn.hide();
						return;
					} else {
						console.error(aRes);
						alert('Error');
					}
				}
			});
		});

		// Cancel button click
		$('.cancel-po').on('click', function() {
			const btn = $(this);
			const group = btn.closest('.input-group');
			const editBtn = group.find('.edit-po');
			const select = group.find('.po-release');
			const text = group.find('.po-text');
			const saveBtn = group.find('.save-po');

			// Reset UI
			if (select.hasClass('selectpicker')) {
				select.selectpicker('destroy');
			}

			// Restore original values
			const originalPrjcode = group.data('original-prjcode');
			const originalPocode = group.data('original-pocode');

			select.data('prjcode', originalPrjcode);
			select.data('pocurrent', originalPocode);

			// Hide dropdown and buttons, show text
			select.selectpicker('hide');
			text.show();
			btn.hide();
			saveBtn.hide();
			editBtn.show();
		});

		// Save button click
		$('.save-po').on('click', function() {
			const btn = $(this);
			const group = btn.closest('.input-group');
			const select = group.find('select.po-release');
			const text = group.find('.po-text');
			const editBtn = group.find('.edit-po');
			const cancelBtn = group.find('.cancel-po');

			// Get values
			const taskId = select.attr('data-taskid');
			const selectedOption = select.find('option:selected');
			const poValue = selectedOption.val();
			const poText = selectedOption.text();

			// Validation
			if (!taskId || !poValue) {
				console.error('Invalid values');
				console.error('taskId',taskId);
				console.error('poValue',poValue);
				return;
			}

			// Disable buttons while saving
			btn.prop('disabled', true);
			cancelBtn.prop('disabled', true);

			$.ajax({
				type: "POST",
				url: "<?=base_url('/index.php/masTSKUpdatePO')?>",
				data: {
					'ptTaskID': taskId,
					'ptPoRelease': poValue
				},
				cache: false,
				success: function(response) {
					try {
						const result = JSON.parse(response);
						if (result.rtCode === '200') {
							// Update text display
							text.text(poText);
							select.attr('data-pocurrent', poValue);

							// Reset UI
							select.selectpicker('hide');
							text.show();
							btn.hide();
							cancelBtn.hide();
							editBtn.show();

							// Visual feedback
							text.addClass('text-success');
							setTimeout(() => text.removeClass('text-success'), 2000);
						} else {
							throw new Error('Update failed');
						}
					} catch (err) {
						alert('Failed to update PO Release');
						console.error(err);
					}
				},
				error: function(xhr, status, error) {
					alert('Error updating PO Release');
					console.error(error);
				},
				complete: function() {
					btn.prop('disabled', false);
				}
			});
		});
	}


    var a;
    var answer = document.getElementById("result");

    function myfunction() {
        if (navigator.userAgent.match(/Android/i) ||
            navigator.userAgent.match(/webOS/i) ||
            navigator.userAgent.match(/iPhone/i) ||
            navigator.userAgent.match(/iPad/i) ||
            navigator.userAgent.match(/iPod/i) ||
            navigator.userAgent.match(/BlackBerry/i) ||
            navigator.userAgent.match(/Windows Phone/i)) {

            $("#odvMobileView").show();
            $("#odvWindowsView").hide();

        } else {
            $("#odvWindowsView").show();
            $("#odvMobileView").hide();
        }
    }

    function InsertFilter() {
        var dFilter = $("#odpTaskStartDate").val();

        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/InsertFilter')?>",
            data: {
                'dFilter': dFilter
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }

        });
    }


	let aHolidays = localStorage.getItem('aHoliday');
	function JSxGetHolidays() {
		if (aHolidays === null) {
			fetch('<?=base_url('index.php/eventGetHoliday')?>')
				.then(response => response.json())
				.then(data => {
					localStorage.setItem('aHoliday', JSON.stringify(data['raItems']));
					aHolidays = localStorage.getItem('aHoliday');
				});
		}
	}
    // บันทึกการเข้างาน
    function TimeCardCheckIN() {
		JSxGetHolidays();
		const tDate = moment().format('YYYY-MM-DD');
		const isHoliday = aHolidays.includes(tDate);
		if (isHoliday || moment().day() === 0 || moment().day() === 6) {
			let tDateHoliday = '';
			if (isHoliday) {
				tDateHoliday = JSON.parse(aHolidays).find((item) => item.holidayStart === tDate);
			}

			if (moment().day() === 0) {
				tDateHoliday = {holidayName: 'วันนี้วันอาทิตย์'}
			} else if (moment().day() === 6) {
				tDateHoliday = {holidayName: 'วันนี้วันเสาร์'}
			}

			if (!confirm(`${tDateHoliday.holidayName} คุณแน่ใจไหม ?`)) {
				return false;
			}
		}
        $("#obtCheckIn").attr("disabled", true);
        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/TimeCardCheckIN')?>",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult == '2') {
                    alert('คุณไม่ได้ลงเวลาออกของวันก่อนหน้า ระบบทำการลงเวลาออกให้เรียบร้อยแล้ว');
                    alert('บันทึกเวลาเข้างานวันปัจจุบันเรียบร้อยแล้ว');
                }
                $("#obtCheckIn").attr("disabled", false);
                location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }

    //บันทึกการพักเบรก
    function TimeCardTakeBreak() {
        $.ajax({
            type: "POST",
            url: "<?=base_url('/index.php/TimeCardTakeBreak')?>",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult == 'error') {
                    alert('ไม่สามารถลงเวลาพักเบรกได้ เนื่องจากคุณยังไม่ได้เข้างาน');
                } else {
                    //alert(tResult);
                    location.reload();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });
    }


    // ลงเวลาออกงาน
    function TimeCardCheckOut() {
        if (confirm(
                "แจ้งเตือน : การออกงานก่อนเวลาอาจส่งผลให้เวลางานของคุณหายไปหรือทำงานไม่ครบตามกำหนดเวลาของบริษัท ยืนยันการลงเวลาออกงานใช่หรือไม่ "
            )) {
            $.ajax({
                type: "POST",
                url: "<?=base_url('/index.php/TimeCardCheckOut')?>",
                data: {},
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult == 'error') {
                        alert('ไม่สามารถลงเวลาพักออกงานได้ เนื่องจากคุณยังไม่ได้เข้างาน');
                    } else {
                        location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }
            });
        }
    }
    </script>

</body>
