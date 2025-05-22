<?php include(APPPATH . 'views/wHeader.php') ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
.Titlebar {
    padding: 10px;
    color: #ffffff;
}

.mb-2 {
    margin-bottom: 1rem;
    /* หรือปรับขนาดตามที่คุณต้องการ */
}
</style>

<img src="<?php echo base_url('/assets/WorkingBg.png');?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%;"></img>

<div class="container-fluid">
    <div class="row">
        <div class="col bg-dark Titlebar" style="font-size:20px">
            <?= $tTitle ?>
        </div>
        <div class="col bg-dark Titlebar text-end login-acc">
            <?php echo  get_cookie('TaskEmail');?>
            <a style="color:#ffffff !important;" href="<?=base_url('/index.php/logout')?>">[ออกจากระบบ]</a>
        </div>
    </div>
</div>
<div class="container-fluid">

    <div class="row">
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <h5 class="card-title">เพิ่มวันลา</h5>
                <form id="formcreateleave" action="<?php echo base_url('index.php/Leave_Controller/add_leave');?>"
                    method="post">
                    <div class="mb-2">
                        <label for="ocmLSType" class="form-label">ประเภทการลา</label>
                        <select class="form-control" id="ocmLSType" name="ocmLSType" required>
                            <option value="">กรุณาเลือกประเภทลา</option>
                            <?php foreach($LeaveTypeList['raItems'] as $type) { ?>
                            <option value="<?php echo $type['FNTypeID']; ?>"><?php echo $type['FTTypeName']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-md-6 odpLSDateFrom">
                                <label for="FDDateFrom" class="form-label">วันที่เริ่มต้น</label>
                                <input type="date" class="form-control" id="odpLSDateFrom" name="odpLSDateFrom" required>
                            </div>
                            <div class="col-md-6">
                                <label for="odpLSDateTo" class="form-label">วันที่สิ้นสุด</label>
                                <input type="date" class="form-control" id="odpLSDateTo" name="odpLSDateTo" required>
                            </div>
                        </div>
                    </div>


                    
            <div class="col-lg-12 nopadding mb-2">
            <label for="otaLSRemark" class="form-label">เหตุผล </label>
                <textarea id="otaLSRemark" placeholder="ระบุเหตุผล" name="otaLSRemark" class="form-control"
                    style="display:none"></textarea>

                <div id="odvLSRemarkText"></div>
                <script>
                $('#odvLSRemarkText').summernote({
                    placeholder: 'ระบุเหตุผล',
                    tabsize: 2,
                    height: 120,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear', 'fontsize']],
                        // ['color', ['color']],
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
            </div>
            <div class="col-md-3">
                <a href="<?php echo base_url('index.php/Leave') ?> " style="cursor='pointer'">
            << ย้อนกลับ</a>
                  </div>
            <div class="text-end">
                <button type="button" class="btn btn-outline-dark" onclick="resetvalueinform()">ล้างข้อมูล</button>
                <button type="submit" class="btn btn-primary" onclick="InsertFilter()" >บันทึกการลา</button>
            </div>
            </form>
        </div>
        <!-- Text Editor -->
    </div>

    </form>
</div
</div>
</div>
</div>

<script>
$('.xWSelectOptions').selectpicker();
</script>

<script type="text/javascript">
function resetvalueinform() {
    document.getElementById("formcreateleave").reset();
}


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
            $('#odvLSRemarkText').summernote('insertImage', img);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error(textStatus + " " + errorThrown);
        }
    });
};
