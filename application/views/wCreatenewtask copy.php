<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script> 

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>


<!-- Sellect Picker Bootstrp -->
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<style>
    .Titlebar {
        padding: 10px;
        color: #ffffff;
    }
</style>

<img src="<?php echo base_url('/assets/WorkingBg.png');?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%;"></img>
    
<div class="container-fluid">
    <div class="row">
        <div class="col bg-dark Titlebar">
            Ada Task Tracker
        </div>
    </div>
</div>

<div class="container-fluid" >
    <div class="row">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">เพิ่มงานใหม่</h5>
                <form id="formcreatetask" action="<?php echo base_url('index.php/CreateNewtask');?>" method="post">
                    <p class="card-text">
                        <div class="mb-3">
                            <div class="more-info">โปรเจค</div>
                            <select class="form-control selectpicker"  data-live-search="true" id="osmproject" name="osmproject" required>
                                <option  value="">กรุณาเลือกโปรเจค</option>
                                <option  value="">กรุณาเลือกโปรเจคx</option>
                                <?php foreach($ProjectList['raItems'] AS $nKey => $aValue){ ?>
                                    <option value="<?=$aValue['FTPrjCode']?>"><?=$aValue['FTPrjName']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="more-info">รายละเอียดงานที่ทำ</div>
                            <textarea rows="6" placeholder="กรุณากรอกรายละเอียด"  name="oetTextDetail" class="form-control" id="oetTextDetail"  maxlength="255" required="true"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="more-info">หมายเหตุ</div>
                            <textarea rows="3" placeholder="ระบุหมายเหตุ"  name="oetTextRemark" class="form-control" id="oetTextRemark"  maxlength="255"></textarea>
                        </div>
                    </p>
                    <div class="text-end">
                        <div style="display:block; float:left;"><a href="<?php echo base_url('index.php/login');?>" style="margin-top: 10%; display: block;"><< ย้อนกลับ </a></div>
                        <button type="button" class="btn btn-outline-dark" onclick="resetvalueinform()">ล้างข้อมูล</button>
                        <button type="button" id="obtCreateTask" class="btn btn-primary" onclick="CheckCreateTask()">บันทึกงาน</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
    // Call Sellect Picker
    $(document).ready(function(){
        setTimeout(function() {
            $('.selectpicker').selectpicker();
        }, 2000);
        
    });
    

    function resetvalueinform(){
        document.getElementById("formcreatetask").reset();
    }

    function CheckCreateTask (){

       

        if($("#osmproject").val()==''){
            $("#olbMessage").text('!ไม่สามารถบันทึกข้อมูลได้ กรุณาเลือกโปรเจค');
            $("#obtAlterClick").click();
        }else if($("#oetTextDetail").val()==''){

            $("#olbMessage").text('!ไม่สามารถบันทึกข้อมูลได้ กรุณากรอกรายละเอียดงาน');
            $("#obtAlterClick").click();
        }else{
                $("#obtCreateTask").attr("disabled", true);
                $.ajax({
                type: "POST",
                url: "<?=base_url('/index.php/CheckCreateTask')?>",
                data: {},
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    
                    if (tResult > 0) {
                        $("#olbMessage").text('!ไม่สามารถเพิ่มงานใหม่ได้เนื่องจากคุณมีงานที่ทำค้างอยู่ กรุณาจบงานก่อนหน้า ก่อนจะเพิ่มงานใหม่');
                        $("#obtAlterClick").click();
                    } else {

                        document.getElementById("formcreatetask").submit();

                    }

                    $("#obtCreateTask").attr("disabled", false);


                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }
                });
        }

    }
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>

<!-- Button trigger modal -->
<button type="button" id="obtAlterClick" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"  style="display:none">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">แจ้งเตือนการทำงาน</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <label id="olbMessage"></label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>