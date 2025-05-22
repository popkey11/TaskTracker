<?php include(APPPATH . 'views/wHeader.php') ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
    #fotgotpassword{
        cursor:pointer;
    }
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
        margin-top: 100px;
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

    .swal-button--confirm {
        background-color: #0a53be !important;
    }
</style>
<title><?= $tTitle ?></title>
<div class="container-fluid">
    <div class="row">
        <div class="col bg-dark Titlebar">
            <?= $tTitle ?>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row login-box">
        <div class="col-lg-4 col-md-1 col-sm-1"></div>
        <div class="col-lg-4 col-md-10 col-sm-10">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">กรอกอีเมลเพื่อเข้าสู่ระบบ</h5>
                    <form>
                        <p class="card-text">
                        <div class="mb-3">
                            <div class="more-info">*ใช้อีเมลบริษัท</div>
                            <input type="email" name="oetEmail" class="form-control" id="oetEmail" placeholder="name@ada-soft.com" required maxlength="150">
                        </div>
                        </p>
                        <div class="row">
                        <div id="fotgotpassword" class="col text-left">ลืมรหัสผ่าน</div>
                        <div class="col text-end">
                            <button class="btn btn-primary obtLogin" type="button">เข้าสู่ระบบ</button>
                            
                        </div>
</div>
                       
                       
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-1 col-sm-1"></div>
    </div>
 
</div>

<div class="modal" tabindex="-1" id="email_modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันอีเมล์</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ระบุอีเมล์
                <input type="text" name="oetEmailConfirm" id="oetEmailConfirm" class="form-control" placeholder="อีเมล์">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" onclick="sendEmail()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>


<div class="modal" tabindex="-1" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ยืนยันรหัสผ่านของคุณ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                รหัสผ่าน
                <input type="password" name="objpassword" id="objpassword" class="form-control" placeholder="ระบุรหัสผ่าน">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="button" class="btn btn-primary" onclick="verifyPassword()">ยืนยัน</button>
            </div>
        </div>
    </div>
</div>

<script>
$('#fotgotpassword').click(function(){
$('#email_modal').modal('show');
});

function sendEmail(){
    $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/sendEmail') ?>",
                data: {
                    "email": $('#oetEmailConfirm').val(),
                },
                cache: false,
                timeout: 0,
                success: function(nCode) {
                    alert(nCode);
                    $('#email_modal').modal('hide');
                }
            })
}

    function verifyPassword() {
        if ($('#objpassword').val() == "") {
            alert('คุณยังไม่ระบุรหัสผ่าน');
            $('#objpassword').focus();
            return false;
        
      
      
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/verifyPassword') ?>",
                data: {
                    "email": $('#oetEmail').val(),
                    "password": $('#objpassword').val()
                },
                cache: false,
                timeout: 0,
                success: function(nCode) {
                    if (nCode == 200 ) { //found
                        window.location.href = '<?= base_url('/index.php/Task') ?>';
                    } else { //not found
                        swal({
                            // title: "ไม่พบอีเมลล์ในระบบ",
                            text: 'ไม่สามารถเข้าใช้งานได้ เนื่องจากไม่พบข้อมูลรหัสผ่านในระบบ',
                            icon: 'error',
                            buttons: {
                                cancel: {
                                    text: "ลองใหม่อีกครั้ง",
                                    visible: true,
                                    closeModal: true,
                                },
                                // confirm: {
                                //     text: "ลงทะเบียน",
                                //     visible: true,
                                //     closeModal: true
                                // }
                            },
                        });
                        // .then((confirm) => {
                        //     if (confirm) {
                        //         window.location.href = '<?= base_url('/index.php/register') ?>';
                        //     }
                        // });
                    }
                }
            });
        }
    }

    $('.obtLogin').click(function(event) {
        if ($('#oetEmail').val() == '') {
            $('#oetEmail').focus();
            alert("กรุณาระบุอีเมลล์")
        } else {
            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/checkemil') ?>",
                data: {
                    "email": $('#oetEmail').val()
                },
                cache: false,
                timeout: 0,
                success: function(nCode) {
                    var data = JSON.parse(nCode);
                    if (data.rtCode == 200 && data.authorize == false) { //found
                        // ดึงค่า UsrDepCode และ StaAlwCreatPrj จาก cookie 
                        var tUsrDepCode = document.cookie.replace(/(?:(?:^|.*;\s*)UsrDepCode\s*\=\s*([^;]*).*$)|^.*$/, "$1");
                        var tStaAlwCreatPrj = document.cookie.replace(/(?:(?:^|.*;\s*)StaAlwCreatPrj\s*\=\s*([^;]*).*$)|^.*$/, "$1");
                        if (tUsrDepCode == '00002' && tStaAlwCreatPrj == '2' || tStaAlwCreatPrj == '4') {
                            window.location.href = '<?= base_url('/index.php/docDBPageView') ?>';
                        } else {
                            window.location.href = '<?= base_url('/index.php/Task') ?>';
                        }
                    } else if (data.rtCode == 200 && data.authorize == true) {
                        $('#myModal').modal('show');
                    } else { //not found
                        swal({
                            // title: "ไม่พบอีเมลล์ในระบบ",
                            text: 'ไม่สามารถเข้าใช้งานได้ เนื่องจากไม่พบข้อมูลอีเมลในระบบ',
                            icon: 'error',
                            buttons: {
                                cancel: {
                                    text: "ลองใหม่อีกครั้ง",
                                    visible: true,
                                    closeModal: true,
                                },
                                // confirm: {
                                //     text: "ลงทะเบียน",
                                //     visible: true,
                                //     closeModal: true
                                // }
                            },
                        });
                        // .then((confirm) => {
                        //     if (confirm) {
                        //         window.location.href = '<?= base_url('/index.php/register') ?>';
                        //     }
                        // });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองอีกครั้ง');
                }
            });
        }
    });
</script>
