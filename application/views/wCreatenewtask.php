<!DOCTYPE html>
<html lang="en">

<head>
    <title><?= $tTitle ?></title>
    <?php include(APPPATH . 'views/wHeader.php') ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/ada.titlebar.css'); ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/po/ada.po.css'); ?>" />
    <style>
        /* ข้อความแสดงข้อผิดพลาดสำหรับ selectpicker ให้แสดงด้านล่าง */
        .bootstrap-select+.text-danger {
            margin-top: 5px;
            display: block;
        }

        .Titlebar {
            padding: 10px;
            color: #ffffff;
        }

        .xWTSKPrjRelease {
            width: 100px;
            justify-content: center;
        }
    </style>
</head>

<body>
    <img class="xCNWorkingBg" src="<?php echo base_url('/assets/WorkingBg.png'); ?>"> </img>
    <?php include(APPPATH . 'views/menu/wMenu.php') ?>
    <div class="container-fluid">
        <div class="row">
            <div class="card" style="width: 100%;">
                <div class="card-body">
                    <h5 class="card-title">เพิ่มงานใหม่</h5>
                    <form id="ofmTSKCreateTask" action="<?php echo base_url('index.php/CreateNewtask'); ?>" method="post">
                        <p class="card-text">
                        <div class="row" style="margin-bottom:10px;">
                            <div class="col-md-6 col-12">
                                <span class="text-danger">*</span> <label for="ocmPoProject">โปรเจค</label>
                                <select name="ocmproject" id="ocmproject" class="form-control form-select selectpicker w-100"
                                    placeholder="เลือกโปรเจค" data-live-search="true">
                                    <option selected="selected" value="">กรุณาเลือกโปรเจค</option>
                                    <?php foreach ($ProjectList['raItems'] as $nKey => $aValue) { ?>
                                        <option value="<?= $aValue['FTPrjCode'] ?>" data-prjpoforce="<?= $aValue['FBPrjPoForce'] ?>"><?= $aValue['FTPrjName'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-12">
                                <div class="more-info ">ขั้นตอน</div>
                                <select id="ocmPhase" class="form-control form-select selectpicker w-100"
                                    data-live-search="true" name="ocmPhase" disabled>
                                    <option selected="selected" value="">กรุณาเลือกขั้นตอน</option>
                                    <?php if ($aPhaseList['tCode'] == '200') {
                                        foreach ($aPhaseList['aItems'] as $nKey => $aValue) { ?>
                                            <option class="xWPrjCode-<?= $aValue['FTPrjCode'] ?> xWPhaseList"
                                                value="<?= $aValue['FTPshCode'] ?>"><?= $aValue['FTPshName'] ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                            <div class="col-md-12" id="odvPrjRelease">
                                <div class="more-info ">PO</div>
                                <div class="input-group">
                                    <span class="input-group-text xWTSKPrjRelease" id="ospPrjRelease">รหัส PO</span>
                                    <select name="ocmPrjRelease" id="ocmPrjRelease" class="form-control selectpicker" data-live-search="true">
                                        <option selected="selected" value="">กรุณาเลือก PO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="more-info">รายละเอียดงานที่ทำ</div>
                            <textarea rows="3" placeholder="กรุณากรอกรายละเอียด" name="otaTextDetail" class="form-control"
                                id="otaTextDetail" maxlength="255" required="true"></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="more-info">หมายเหตุ</div>
                            <!-- Text Editor -->
                            <div class="col-lg-12 nopadding">
                                <textarea id="otaTextRemark" placeholder="ระบุหมายเหตุ" name="otaTextRemark"
                                    class="form-control" style="display:none"></textarea>
                                <div id="odvSummerRemarkText"></div>
                            </div>
                            <!-- Text Editor -->
                        </div>
                        </p>
                        <div class="text-end">
                            <div style="display:block; float:left;"><a href="<?php echo base_url('index.php/Task'); ?>"
                                    style="margin-top: 10%; display: block;">
                                    << ย้อนกลับ </a>
                            </div>
                            <button type="button" class="btn btn-outline-dark"
                                onclick="resetvalueinform()">ล้างข้อมูล</button>
                            <button type="submit" id="obtCreateTask" class="btn btn-primary">บันทึกงาน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Button trigger modal -->
    <button type="button" id="obtAlterClick" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"
        style="display:none">
        Click for Open Mpdal
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

    <script type="text/javascript">
        $(document).ready(function() {
            $('#ocmPrjRelease').selectpicker('refresh');
            $('.xWSelectOptions').selectpicker();
            $('#odvSummerRemarkText').summernote({
                placeholder: 'กรอกหมายเหตุ',
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

            function resetvalueinform() {
                $("ofmTSKCreateTask").reset()
            }

            $.upload = function(file) {
                let out = new FormData();
                out.append('file', file, file.name);

                $.ajax({
                    method: 'POST',
                    url: '<?= base_url('/index.php/UploadImage') ?>',
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

            $("#ocmproject").on('change', function() {
                let tPrjCode = $(this).val();
                let bPrjPoForce = $(this).find(':selected').data('prjpoforce');

                $('#ocmPhase').val('');
                $('.xWPhaseList').show();
                $('.xWPrjCode-' + tPrjCode).show();

                if (tPrjCode != "") {
                    $('#ocmPhase').prop('disabled', false).selectpicker('refresh');
                } else {
                    $('#ocmPhase').prop('disabled', true).selectpicker('refresh');
                    $('#ocmPrjRelease')
                        .html('<option selected="selected" value="">กรุณาเลือก PO</option>')
                        .selectpicker('refresh');
                }

                $('#ocmPrjRelease').removeClass('is-invalid');
                $('#ocmPrjRelease').closest('.bootstrap-select').removeClass('is-invalid');
                $('#ocmPrjRelease-error').remove();

                $('#ospPrjRelease').text('รหัส PO');
                if (bPrjPoForce == 1) {
                    JSxTSKRelease(tPrjCode, 'กรุณาเลือก PO');
                } else if (bPrjPoForce == 0) {
                    JSxTSKRelease(tPrjCode, 'โปรเจคนี้ไม่บังคับเลือก PO');
                }
                $('#ocmPrjRelease').selectpicker('refresh');
            });

            // เมื่อเลือกโปรเจคจะแสดงเฟสของโปรเจคที่เลือก
            $("#ofmTSKCreateTask").validate({
                errorClass: 'text-danger',
                errorElement: 'span',
                rules: {
                    ocmproject: {
                        required: true
                    },
                    ocmPhase: {
                        required: true
                    },
                    otaTextDetail: {
                        required: true,
                        maxlength: 255
                    },
                    ocmPrjRelease: {
                        required: function() {
                            return $("#ocmproject option:selected").data('prjpoforce') == 1;
                        }
                    }
                },
                messages: {
                    ocmproject: {
                        required: "กรุณาเลือกโปรเจค"
                    },
                    ocmPhase: {
                        required: "กรุณาเลือกขั้นตอน"
                    },
                    otaTextDetail: {
                        required: "กรุณากรอกรายละเอียดงาน",
                        maxlength: "รายละเอียดงานต้องไม่เกิน 255 ตัวอักษร"
                    },
                    ocmPrjRelease: {
                        required: "กรุณาเลือก PO"
                    }
                },
                errorPlacement: function(error, element) {
                    error.addClass("text-danger");
                    if (element.attr('id') === 'ocmPrjRelease') {
                        element.closest('.input-group').after(error);
                    } else if (element.hasClass("selectpicker")) {
                        element.closest('.bootstrap-select').after(error);
                    } else if (element.closest('.input-group').length) {
                        element.closest('.input-group').after(error);
                    } else {
                        element.after(error);
                    }
                },
                highlight: function(element) {
                    $(element).addClass("is-invalid");
                    if ($(element).hasClass("selectpicker")) {
                        $(element).closest(".bootstrap-select").addClass("is-invalid");
                    }
                    // เพิ่มเงื่อนไขสำหรับ ocmPrjRelease
                    if ($(element).attr('id') === 'ocmPrjRelease') {
                        $(element).closest(".input-group").addClass("is-invalid");
                    }
                },
                unhighlight: function(element) {
                    $(element).removeClass("is-invalid");
                    if ($(element).hasClass("selectpicker")) {
                        $(element).closest(".bootstrap-select").removeClass("is-invalid");
                    }
                    // เพิ่มเงื่อนไขสำหรับ ocmPrjRelease
                    if ($(element).attr('id') === 'ocmPrjRelease') {
                        $(element).closest(".input-group").removeClass("is-invalid");
                    }
                },
                submitHandler: function(form) {
                    // เรียกฟังก์ชันสำหรับส่งข้อมูล
                    // $("#ofmTSKCreateTask").valid();
                    JSxTSKCheckTask();
                    return false;
                }
            });

            function JSxTSKCheckTask() {
                var tRemark = $(".note-editable").html();
                $("#otaTextRemark").val(tRemark);

                // ตรวจสอบ PrjPoForce เพื่อ validate Release
                var bPrjPoForce = $("#ocmproject option:selected").data('prjpoforce');

                if (bPrjPoForce != 1) {
                    $("#ocmPrjRelease").rules("remove", "required");
                } else {
                    $("#ocmPrjRelease").rules("add", {
                        required: true
                    });
                }
                if ($("#ofmTSKCreateTask").valid()) {
                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('/index.php/CheckCreateTask') ?>",
                        data: $("#ofmTSKCreateTask").serialize(),
                        cache: false,
                        timeout: 0,
                        beforeSend: function() {
                            $("#obtCreateTask").attr("disabled", true);
                        },
                        success: function(tResult) {
                            if (tResult > 0) {
                                $("#olbMessage").text(
                                    '!ไม่สามารถเพิ่มงานใหม่ได้เนื่องจากคุณมีงานที่ทำค้างอยู่ กรุณาจบงานก่อนหน้า ก่อนจะเพิ่มงานใหม่'
                                );
                                $("#obtAlterClick").click();
                                $("#obtCreateTask").attr("disabled", false);
                            } else {
                                $("#obtCreateTask").attr("disabled", false);
                                // CheckCreateTask
                                JSxTSKCreateTask();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                            $("#obtCreateTask").attr("disabled", false);
                        }
                    });
                }
            }


            function JSxTSKCreateTask() {
                // ส่งข้อมูลงาน
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('/index.php/CreateNewtask') ?>",
                    data: $("#ofmTSKCreateTask").serialize(),
                    cache: false,
                    timeout: 0,
                    beforeSend: function() {
                        $("#obtCreateTask").attr("disabled", true);
                    },
                    success: function(ptResponse) {
                        let aRes = JSON.parse(ptResponse);
                        if (aRes.rtCode == "200") {
                            window.location.href = "<?= base_url('/index.php/Task') ?>";
                        } else {
                            $("#olbMessage").text(aRes.rtMsg);
                            $("#obtAlterClick").click();
                            $("#obtCreateTask").attr("disabled", false);
                        }
                    }
                });
            }

            function JSxTSKRelease(ptPrjCode, ptMsgDefault = 'โปรเจคนี้ไม่บังคับเลือก PO') {
                $.ajax({
                    type: "POST",
                    url: "<?= base_url('/index.php/masTSKGetRelease') ?>",
                    data: {
                        "tPrjCode": ptPrjCode
                    },
                    cache: false,
                    timeout: 0,
                    beforeSend: function() {
                        $('#ocmPrjRelease').selectpicker('refresh');
                    },
                    success: function(paResponse) {
                        let aRes = JSON.parse(paResponse);
                        let tHtml = `<option value="">${ptMsgDefault}</option>`;
                        let bHasReleases = false;
                        if (aRes.rtCode == '200') {
                            aRes.raItems.forEach(function(aItem) {
                                tHtml += `<option value="${aItem.FTPoCode}" data-pocode="${aItem.FTPoCode}">${aItem.FTPoCode}-${aItem.FTPoRelease}</option>`;
                            });
                            bHasReleases = true;
                        } else if (aRes.rtCode == '404') {
                            tHtml = `<option value="">${aRes.rtMsg}</option>`;
                        }

                        $('#ocmPrjRelease')
                            .html(tHtml)
                            .selectpicker('refresh');

                        // Set a data attribute to indicate if releases are available
                        // $('#ocmPrjRelease').data('has-releases', bHasReleases);

                        // Reset validation state
                        $('#ocmPrjRelease').removeClass('is-invalid');
                        $('#ocmPrjRelease').closest('.bootstrap-select').removeClass('is-invalid');
                        $('#ocmPrjRelease-error').remove();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching po:', textStatus, errorThrown);
                    }
                });
            }

            $('#ocmPrjRelease').on('change', function() {
                var $selectedOption = $(this).find('option:selected');
                var tPoCode = $selectedOption.data('pocode');

                setTimeout(function() {
                    if (tPoCode && tPoCode !== '') {
                        $('#ospPrjRelease').text(tPoCode);
                    } else {
                        $('#ospPrjRelease').text('รหัส PO');
                    }
                }, 0);
            });
        });
    </script>
</body>

</html>