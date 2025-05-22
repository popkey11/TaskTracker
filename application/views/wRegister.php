<?php include(APPPATH . 'views/wHeader.php') ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    .Titlebar {
        padding: 10px;
        color: #ffffff;
    }

    .form-group{
        margin-bottom : 10px;
    }
    .datepicker {
    padding: 5px !important;
}

.ui-datepicker .ui-datepicker-title select {
    font-size: 15px !important;
}

.ui-datepicker-trigger {
    margin-left: -23px !important;
    margin-top: 0px !important;
    cursor: pointer !important;
    z-index: 1;
    position:absolute;
}

.datepicker {
    padding: 5px !important;
}
/*----- Icon Button Browse Date -----*/
	
.btn.xCNBtnDateTime {
    box-shadow: none !important;
    padding: 7px 10px 7px 10px !important;
    background-color: #eee !important;
    border: 1px solid #cccccc !important;
    color: #706e6e !important;
}
	
.btn.xCNBtnDateTime:hover,
.btn.xCNBtnDateTime:active,
.btn.xCNBtnDateTime.active {
    border: 0.5px solid #cccccc !important;
    background-color: #e9e6e6 !important;
}
.btn.xCNBtnDateTime>i {
    padding-top: 5px !important;
    cursor: pointer;
    float: right;
    width: 20px;
}

.btn.xCNBtnDateTime>img {
    padding-top: 4px !important;
    cursor: pointer;
    float: right;
    width: 20px;
}
	
</style>

<?php include(APPPATH. 'views/menu/wMenu.php') ?>

<div class="container">
<div
      class="row"
      style="
        margin-top: 20px;
        border: #fff 1px solid;
        box-shadow: rgba(149, 157, 165, 0.2) 2px 2px 11px 2px;
        border-radius: 2px;
        background-color: #fff;
      "
    >
      <div class="col-lg-4 d-lg-block d-none" style="padding: 0px">
        <img
          class="card-img-top img-responsive"
          src="<?php echo base_url('/assets/images/img6.jpg');?>"
          style="height: 600px; width: 100%; object-fit: cover"
        />
      </div>
      <div class="col-lg-4 d-sm-block d-lg-none" style="padding: 0px">
        <img
          class="card-img-top img-responsive"
          src="<?php echo base_url('/assets/images/img6.jpg');?>"
          style="height: 250px; width: 100%; object-fit: cover"
        />
      </div>
      <div class="col-lg-8" style="margin-top: 20px">
        <form class="fromCreateJob">
          <h4
            style="
              border-left: 4px solid rgb(250, 168, 25);
              margin-bottom: 20px;
              padding-left: 16px;
            "
          >
            ลงทะเบียน
          </h4>
          <hr />
          <div class="form-group">
            <label>* ชื่อพนักงาน</label>
            <input
              type="text"
              class="form-control"
              id="oetName"
              placeholder="กรุณาระบุชื่อพนักงาน"
              maxlength="50"
            />
          </div>

          <div class="form-group">
            <label>ชื่อเล่น</label>
            <input
              type="text"
              class="form-control"
              id="oetNickname"
              placeholder="กรุณาระบุชื่อเล่นพนักงาน"
              maxlength="20"
            />
          </div>

          <div class="form-group">
            <label>* อีเมล</label>
            <input
              type="email"
              class="form-control"
              id="oetEmail"
              name="oetEmail"
              pattern="[A-Za-z0-9._%+\-]+@ada-soft.com$"
              title="กรุณากรอกชื่อ นามสกุล ภาษาอังกฤษ" 
              placeholder="กรุณาระบุอีเมลล์"
               maxlength="50" required
            />
          </div>

          <div class="form-group">
            <label>ไลน์ไอดี (Optional)</label>
            <input
              type="text"
              class="form-control"
              id="oetLine"
              placeholder="กรุณาระบุ ไลน์ไอดี"
              maxlength="50"
            />
          </div>

          <div class="row">
              <!-- <div class="col-md-6">
                  <div class="form-group">
                      <label>ตำแหน่ง</label>
                      <select id="osmRoleName" name="osmRoleName" class="form-control form-select">
                          <option value="">เลือกตำแหน่ง</Option>
                          <?php foreach($DevRoleList["raItems"] as $key0=>$val0){ ?>
                              <option value="<?php echo $val0["FTRolName"];?>"><?php echo $val0["FTRolName"];?></option>
                          <?php } ?>
                      </select>
                  </div>
              </div> -->
              <div class="col-md-6">
                <div class="form-group">
                  <label>แผนก</label>
                  <?php
                    $tMode = get_cookie('RouteMenu');
                    if($tMode == "employee" && $UsrInfo['raItems'][0]['FTDevRole'] != '00014'){
                      // print_r($UsrInfo);
                      $tUsrDepCode = $UsrInfo['raItems'][0]['FTDepCode'];
                      $tUsrDepName = $UsrInfo['raItems'][0]['FTDepName'];
                  ?>
                    <input type="hidden" id="ohdMode" name="ohdMode" value="<?=$tMode?>">
                    <input type="text" value="<?=$tUsrDepName?>" disabled="true" class="form-control">
                    <input type="hidden" id="oetDepCode" name="oetDepCode" value="<?=$tUsrDepCode?>" disabled="true" class="form-control">
                  <?php } else { ?>
                    <select id="oetDepCode" name="oetDepCode" class="form-control form-select">
                        <option value="">เลือกแผนก</Option>
                        <?php foreach($DepartmentList["raItems"] as $key0=>$val0){ ?>
                            <?php if($val0["FTDepCode"] == $tDevCode ){?>
                                <option value="<?php echo $val0["FTDepCode"];?>" selected><?php echo $val0["FTDepName"];?></option>
                            <?php } ?>
                            <option value="<?php echo $val0["FTDepCode"];?>"><?php echo $val0["FTDepName"];?></Option>
                        <?php } ?>
                    </select>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>ตำแหน่ง</label>
                    <select id="osmRoleName" name="osmRoleName" class="form-control form-select">
                        <option value="">เลือกตำแหน่ง</Option>
                        <!-- <?php foreach($DevRoleList["raItems"] as $key0=>$val0){ ?>
                            <option value="<?php echo $val0["FTRolCode"];?>"><?php echo $val0["FTRolName"];?></option>
                        <?php } ?> -->
                    </select>
                </div>
              </div>
          </div>

          <div class="form-group">
            <label>ชื่อทีมย่อยในแผนก</label>
            <input
              type="text"
              class="form-control"
              id="oetTeam"
              placeholder="กรุณาระบุทีม"
              maxlength="20"
            />
          </div>
          <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm">วันเริ่มทำงาน</label>
                                <div class="input-group">
                                        <input type="text" class="form-control xCNDatepicker xCNStartDatePicker xCNInputMaskDate" id="oetRegEdtShwStartDate" name="oetRegEdtShwStartDate" value="" maxlength="10" placeholder="dd/mm/yyyy" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button id="obtRegEdtShwStartDate" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>assets\calendar.png">
                                            </button>
                                        </span>
                                </div>
                        </div> 
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm">วันสิ้นสุดการทำงาน</label>
                                <div class="input-group">
                                        <input type="text" class="form-control xCNDatepicker xCNEndDatePicker xCNInputMaskDate" id="oetRegEdtShwEndDate" name="oetRegEdtShwEndDate" value="" maxlength="10" placeholder="dd/mm/yyyy" autocomplete="off">
                                        <span class="input-group-btn">
                                            <button id="obtRegEdtShwEndDate" type="button" class="btn xCNBtnDateTime">
                                                <img src="<?=base_url();?>assets\calendar.png">
                                            </button>
                                        </span>
                                </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>แผนการทำงาน</label>
                    <select id="oetWorkPlan" name="oetWorkPlan" class="form-control form-select">
                        <option value="">เลือกแผนการทำงาน</Option>
                        <option value="1" >แผนที่ 1: สำหร้บคนที่ อยู่ต่างจังหวัด ในปัจจุบัน ทั้งคนเก่าคนใหม่</option>
                        <option value="2" >แผนที่ 2: สำหร้บคนที่อยู่กรุงเทพ และ  ปริมณฑล</option>
                        <option value="3" >แผนที่ 3: สำหรับคนที่ อยู่กรุงเทพ/ต่างจังหวัด เป็นช่วงๆ</option>
                        <option value="4" >แผนที่ 4: สำหรับพนักงานเริ่มงาน หลัง 1/11/2022 (เข้า office)</option>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="more-info ">จังหวัด</div>
                        <select class="form-control selectpicker" data-show-subtext="true"  data-live-search="true" id="osmProvince" name="osmProvince" required>
                            <option selected="selected" value="">กรุณาเลือกจังหวัด</option>
                                <?php foreach($DataProvince["raItems"] as $key0=>$val0){ ?>
                                    <option value="<?php echo $val0["FTPvnName"];?>" ><?php echo $val0["FTPvnName"];?></option>
                                <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ละติจูด, ลองจิจูด</label>
                            <input type="text" class="form-control" id="oetLatLong" name="oetLatLong"
                                value="" placeholder="Lat, Long" 
                                maxlength="100" />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                    <label class="form-check-label" for="ocbroleadmin">อนุญาตสิทธิ์แอดมิน</label>
                      <?php 
                         $options = [
                          '' => 'ระบุสิทธิ์',
                          '1' => 'ผู้ใช้ทั่วไป',
                          '2' => 'หัวหน้างาน',
                          '3' => 'ผู้จัดการ',
                          '4' => 'Guest',
                                  ];
                              ?>

                          <select class="form-select" id="ocbroleadmin">
                              <?php foreach ($options as $value => $label) : ?>
                                  <option value="<?= $value ?>">
                                      <?= $label ?>
                                  </option>
                              <?php endforeach; ?>
                          </select>
           
                    </div>
                    <div class="col-md-6">
                    <div class="col-md-12 mt-4">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="ockactive" checked>
                            <label class="form-check-label" for="ockactive">ใช้งาน</label>
                        </div>
                       
                    </div>
                    </div>
                </div>
          <hr />

          <?php if(get_cookie('RouteMenu') == 'employee'){ ?>
            <a href="Employee"><<ย้อนกลับ</a>
          <?php }else{ ?>
            <a href="home"><<ย้อนกลับ</a>
          <?php } ?>
          <div style="float: right; margin-bottom: 15px">
            <input
              class="btn btn-light btninform"
              type="reset"
              value="ล้างข้อมูล"
            />
            <input
                onclick="Register()"
                class="btn btn-primary btninform"
                value="ยืนยันข้อมูล"
            />
          </div>
        </form>
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
$(document).ready(function() {
    
    $('.xCNStartDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
    $('.xCNEndDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
    });
    
    $('#obtRegEdtShwStartDate').click(function() {
      $('.xCNStartDatePicker').datepicker('show');
    });
    $('#obtRegEdtShwEndDate').click(function() {
      $('.xCNEndDatePicker').datepicker('show');
    });
    
    // $('.xWSelectOptions').selectpicker();
    $('#oetDepCode').on('change', function() {
      JSxChangeOptionRole(this.value);
    });

    // console.log($('#ohdMode').val());
    // console.log($('#oetDepCode').val());
    if($('#ohdMode').val() == "employee") {
      JSxChangeOptionRole($('#oetDepCode').val());
    }
});

    $('#oetEmail').val('<?=get_cookie('EmailForRegister')?>')

    //สมัครสมาชิก
    function Register (){
        if($("#oetName").val() == ''){
            $("#oetName").focus();
        }else if($("#oetEmail").val() == ''){
            $("#oetEmail").focus();
        }else{

          var oPattern = /^[A-Za-z0-9._%+\-]+@ada-soft.com$/;
          var tEmail = $("#oetEmail").val();
          if(!tEmail.match(oPattern)){
              alert("กรุณากรอก Email ให้ถูกต้อง");
              return false;
          }else{

            if ($("#ockactive").is(":checked") == true) {
            var active = 1;
        } else {
            var active = 2;
        }


            $.ajax({
                type: "POST",
                url: "<?=base_url('/index.php/registerMember')?>",
                data: {
                    "oetName": $("#oetName").val() ,
                    "oetNickname": $("#oetNickname").val() ,
                    "oetEmail": $("#oetEmail").val() ,
                    "oetLine": $("#oetLine").val() ,
                    "oetTeam": $("#oetTeam").val() ,
                    "oetDepCode": $("#oetDepCode").val() ,
                    "osmRoleName": $("#osmRoleName").val(),
                    "oetRegEdtShwStartDate": $("#oetRegEdtShwStartDate").val(),
                    "oetRegEdtShwEndDate": $("#oetRegEdtShwEndDate").val(),
                    "oetWorkPlan": $("#oetWorkPlan").val(),
                    "osmProvince": $("#osmProvince").val(),
                    "oetLatLong": $("#oetLatLong").val(),
                    "ocbroleadmin":$('#ocbroleadmin').val(),
                    "ockactive": active,
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if(tResult == 'success'){

                        <?php if(get_cookie('RouteMenu') == 'employee'){ ?>
                          window.location.href = '<?=base_url('/index.php/Employee')?>';
                        <?php }else{ ?>
                          alert("ลงทะเบียนสำเร็จแล้ว กด OK ระบบจะพาท่านไปสู่หน้าล็อกอิน")
                          window.location.href = '<?=base_url('/index.php/home')?>';
                        <?php } ?>
                    }else{
                        alert("เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง")
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }
            });
          }
        }
    }

    function JSxChangeOptionRole(ptDepCode) {
      var tDepCode = ptDepCode;
      // console.log(tDepCode);
        $.ajax({
          type: "POST",
          url: "<?=base_url('/index.php/regGetDevRole')?>",
          data: {
              "tDepCode": tDepCode ,
          },
          cache: false,
          timeout: 0,
          success: function(tResult) {
              // console.log(tResult);
              var aResult = JSON.parse(tResult);
              // console.log(aResult);
              $("#osmRoleName option").remove();
              if(aResult['DevRoleList']['rtCode'] == '200'){
                $("#osmRoleName").append(new Option("เลือกตำแหน่ง", ""));
                aResult['DevRoleList']['raItems'].forEach(function (aItem) {
                    $("#osmRoleName").append(new Option(aItem['FTRolName'], aItem['FTRolCode']));
                });
              }else{
                $("#osmRoleName").append(new Option("เลือกตำแหน่ง", ""));
              }

          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
          }
      });
    }
</script>
