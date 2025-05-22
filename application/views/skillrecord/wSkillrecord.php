<?php include(APPPATH . 'views/wHeader.php') ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/localcss/ada.titlebar.css'); ?>" />


<html>
<title>
    <?= $tTitle ?>
</title>

<body>
    <img src="<?php echo base_url('/assets/WorkingBg.png'); ?>" style="opacity: 0.2; position: absolute;
    right: 0px;
    bottom: 0px; width: 50%; z-index:-10000"></img>



	<?php include(APPPATH. 'views/menu/wMenu.php') ?>

    <div id="odvCardMySkill" class="container-fluid" style="margin-top:10px">

        <div class="row" style="margin-top:15px">
            <!-- <div class="col-md-12">
                <h5>ข้อมูลโปรเจ็ค</h5>
            </div> -->
            <div class="col-md-7">
                <table widht="100%">

                    <tr>

                        <td width="20%">แผนก
                            <?php 
                            // print_r($UsrInfo);
                            $tUsrDepCode = trim($UsrInfo['raItems'][0]['FTDepCode']);
                            $tUsrDepName =  trim($UsrInfo['raItems'][0]['FTDepName']);
                            
                            ?>
                            <div class="input-group mb-3 ">
                                <!-- <input type="text" value="<?=$tUsrDepName?>" class="form-control" disabled> -->
                            <!-- <input type="hidden" id="oetDevSearch" name="oetDevSearch" value="<?=$tUsrDepCode?>" class="form-control"> -->
                            <input type="hidden" id="oetDepSearchCode" name="oetDepSearchCode" value="<?=$tUsrDepCode?>" class="form-control">
                            <select name="ocmDepSearch" id="ocmDepSearch" class="form-control form-select" onchange="JSxSKRResetPage('1')">
                                <option value="">ทั้งหมด</option>
                                <?php foreach($DepartmentList["raItems"] as $key1=>$val1){ ?>
                                <option value="<?=$val1["FTDepCode"]?>" <?= ($val1["FTDepCode"] == $tUsrDepCode) ? 'selected' : ''; ?>><?=$val1["FTDepName"]?></option>
                                <?php } ?>
                            </select>
                            </div>
                            
                        </td>
                        <td width="20%">กลุ่มทักษะ
                            <div class="input-group mb-3 ">
                                <select name="oetGrpSearch" id="oetGrpSearch" class="form-control form-select"
                                    onchange="JSxSKRResetPage('2')">
                                    <option value="">ทั้งหมด</option>
                                    <!-- <?php foreach ($GroupSkillList["raItems"] as $key1 => $val1) { ?>
                                        <option value="<?= $val1["FTSkgCode"] ?>"><?= $val1["FTSkgGrpName"] ?></option>
                                    <?php } ?> -->
                                </select>
                            </div>

                        </td>
                        <td width="20%">ระดับ
                            <div class="input-group mb-3 ">
                                <select name="oetLevelSearch" id="oetLevelSearch" class="form-control form-select"
                                    onchange="JSxSKRResetPage('3')">
                                    <option value="">ทั้งหมด</option>
                                    <option value="0">ไม่มี</Option>
                                    <option value="2">พอใช้</Option>
                                    <option value="3">ดี</Option>
                                    <option value="4">ดีมาก</Option>
                                </select>
                            </div>

                        </td>
                        <td width="1000%">ค้นหา
                            <div class="input-group mb-3 ">
                                <input type="text" name="oetLikeSearch" id="oetLikeSearch" class="form-control"
                                    placeholder="กรอกคำค้นหา">
                                <button class="btn btn-primary" type="button" onclick="JSxSKRFilterData()">ค้นหา</button>
                            </div>
                        </td>

                    </tr>
                </table>
            </div>
            <div class="col-md-5 row">

                <div class="col-md-0" style="text-align:right; margin-top:20px;">

                    <!-- <div class="col-md-3" style="text-align:right; margin-top:20px;"> -->
                    <button type="button" class="btn btn-primary"
                        onclick="JSxSKRRefreshAddMySkill('${val.FTDevEmail}')">รีเฟรช</button>
                </div>
            </div>

        </div>



        <!-- <div id="odvSkillAdd" class="col-lg-3 col-md-12 col-sm-12">
            <div class="card" style="width: 100%;">
                <img class="card-img-top" src="<?php echo base_url('/assets/SkillDev.jpg'); ?>" alt="Card image cap">
                <div class="card-body">

                    <h5 class="card-title">ตอนนี้คุณยังไม่มีสกิล!</h5>
                    <p class="card-text">มาเพิ่มสกิลกันเลยดีกว่า โดยกดปุ่มเพิ่มสกิลใหม่เพื่อเพิ่ม สกิล ได้เลยครับ</p>
                    <a onclick="AddMySkill()""
                        class=" btn btn-primary">เพิ่มสกิลใหม่</a>

                </div>
            </div>
        </div> -->

        <div id="odvSkillTable" class="col-lg-12" style="margin-top: 20px">

            <table class="table table-sm ">
                <thead>
                    <tr>

                        <th class="text-center" style="width: 10%">ลำดับ</th>
                        <th class="" style="width: 19%">ทักษะ</th>
                        <th  style="width:8% " > &nbsp; &nbsp; &nbsp;ระดับ &nbsp;<a id="icon1"
                                class="fa fa-info-circle"></a>
                        </th>
                        <th class="" style="width: 15%">บทบาท</th>
                        <th style="width: 17%">กลุ่มทักษะ</th>
                        <th class="text-center" style="width: 10%">แก้ไข</th>
                    </tr>
                <tbody id="skillDev">

                </tbody>
                </thead>
                <tbody>
            </table>
        </div>
        <div>
            <input type="hidden" id="oetFilterGrpPage" value="1">
        </div>

        <div id="pagination" style="display:flex">

        </div>


    </div>

</body>

</html>

<script type="text/javascript">
    $(document).ready(function () {
        JSxSKRGetSkillDev();
        JSxSKRGetSkillGroup();
    });
    function JSxSKRFilterData() {
        document.getElementById("skillDev").innerHTML = "";
        $("#oetFilterGrpPage").val(1);
        JSxSKRGetSkillDev();

    }

    function JSxSKRGetSkillDev() {
        var tDepSearch = $("#ocmDepSearch").val()
        var tGrpSearch = $("#oetGrpSearch").val()
        var tLevelSearch = $("#oetLevelSearch").val()
        var tLikeSearch = $("#oetLikeSearch").val()
        var nPage = $("#oetFilterGrpPage").val()

        // console.log('oetGrpSearch'+ tGrpSearch);

        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventGetSkillDev') ?>",
            data: {
                "tDepSearch": tDepSearch,
                "tGrpSearch": tGrpSearch,
                "tLevelSearch": tLevelSearch,
                "tLikeSearch": tLikeSearch,
                "nPage": nPage

            },
            cache: false,
            timeout: 0,
            success: function (oResult) {
                // console.log(oResult)
                // if (oResult.skilldev.rtCode == '800') {
                //     $('#odvSkillTable').hide()
                // } else {
                //     $('#odvSkillAdd').hide()
                // }

                if (oResult.skilldev.rtCode == '200') {
                    // console.log(oResult.skilldev.rtCode);

                    if (oResult.skilldev.raItems) {
                        oResult.skilldev.raItems.forEach((val, index) => {
                            // console.log(val);
                            let nLevelName = val.FNSkdSkillLev;
                            let tSkrLevelName;
                            //console.log(nSkrRole);
                            switch (nLevelName) {

                                case 2:
                                    tSkrLevelName = "พอใช้";
                                    break;
                                case 3:
                                    tSkrLevelName = "ดี";
                                    break;
                                case 4:
                                    tSkrLevelName = "ดีมาก"
                                    break;
                                default:
                                    tSkrLevelName = "ไม่มี";
                            }

                            let tRolCode = val.FTRolCode
                            let tSkdRolName;
                            // console.log(tRolCode);
                            
                            if(tRolCode == '99999' || tRolCode == null) {
                                tSkdRolName = "All";
                            }else{
                                tSkdRolName = val.FTRolName;
                            }
                            // switch (tRolCode) {
                            //     case '00001':
                            //         tSkdRolName = "Senior PGM";
                            //         break;
                            //     case '00002':
                            //         tSkdRolName = "SA";
                            //         break;
                            //     case '00003':
                            //         tSkdRolName = "Programmer "
                            //         break;
                            //     case '00004':
                            //         tSkdRolName = "Report"
                            //         break;
                            //     case '00005':
                            //         tSkdRolName = "Tester"
                            //         break;
                            //     case '00006':
                            //         tSkdRolName = "Mgt"
                            //         break;
                            //     default:
                            //         tSkdRolName = "All";

                            // }
                            let tbody = ` <tr>
                       
                        <td class="text-center">${val.RowSkill}</td>
                        <td>${val.FTSkrSkillName}</td>
                        <td >
                            <input type="hidden" class="form-control" id="oetSkillcode" name="oetSkillcode" required
                                value="${val.FTSkrCode}">
                            <input type="hidden" class="form-control" id="oetSkillname" name="oetSkillname" required maxlength="50" disabled
                                value=" ${val.FTSkrSkillName}">
                            <select name="ocmLevelSkill" id="ocmLevelSkill${index}"   style="width: 55%" class=" form-control form-select" onchange="JSxSKRUpdateMySkill(${val.FTSkrCode},'${val.FTDevEmail}', '${val.FTSkrSkillName}', '${index}')">
                                <option value="0" ${nLevelName == "" ? 'selected' : ''}>ไม่มี</option>
                                <option value="2" ${nLevelName == 2 ? 'selected' : ''}>พอใช้</option>
                                <option value="3" ${nLevelName == 3 ? 'selected' : ''}>ดี</option>
                                <option value="4" ${nLevelName == 4 ? 'selected' : ''}>ดีมาก</option>
                            </select></td>
                        <td>${tSkdRolName}</td>
                        <td>${val.FTSkgGrpName}</td>
                    
                        
                        <td class="text-center">
                            <img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer"
                                onclick="JSxSKREditMySkill(${val.FTSkrCode},'${val.FTDevEmail}', '${val.FTSkrSkillName}', '${nLevelName}')">
                        
                                
                        </td>
                        
                    </tr>`
                            $("#skillDev").append(tbody)
                        });
                    }
                } else {
                    let tbody = `
                    <tr>
                        <td colspan="8"  class="text-center">ไม่พบข้อมูลทักษะ</td>
                    </tr>
                    `
                    $("#skillDev").append(tbody)

                }
                let total_page = oResult.skilldev.total_pages
                let total_record = oResult.skilldev.total_record
                let current_page = oResult.skilldev.current_page
                document.getElementById("pagination").innerHTML = "";

                let pagination = JSxSKRPagination(total_page, total_record, current_page)


                $("#pagination").append(pagination)

                //$("#odvGroupSkilltList").html(tResult)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
            }
        });

    }

    function JSxSKRRefreshAddMySkill(ptMyEmail) {
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventRefreshAddMySkill') ?>",
            data: {
                'ptMyEmail': ptMyEmail
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });

    }

    // function JSxSKRDeleteMySkill(ptMySkillID, ptMyEmail) {

    //     if (confirm("ยืนยันที่จะลบงานนี้ออกจากระบบใช่หรือไม่") == true) {
    //         $.ajax({
    //             type: "POST",
    //             url: "<?= base_url('/index.php/tpjSKREventDeleteMySkill') ?>",
    //             data: {
    //                 'ptMySkillID': ptMySkillID,

    //                 'ptMyEmail': ptMyEmail
    //             },
    //             cache: false,
    //             timeout: 0,
    //             success: function (tResult) {
    //                 location.reload();
    //             },
    //             error: function (jqXHR, textStatus, errorThrown) {
    //                 alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
    //             }
    //         });

    //     }
    // }

    function JSxSKREditMySkill(ptMySkillID, ptEmail, ptSkillName, ptLevelSkill) {
        // window.location.href = 'EditGroupSkill';
        var nPage = $("#oetFilterGrpPage").val()
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKRPageEditMySkill') ?>",
            data: {
                'ptMySkillID': ptMySkillID,
                'ptEmail': ptEmail,
                'ptSkillName': ptSkillName,
                'ptLevelSkill': ptLevelSkill,
                "nPage": nPage
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $('#odvCardMySkill').html(tResult)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });

    }

    function JSxSKRPagination(total_page, total_record, current_page) {

        let showList = `
            <div class="col-md-6 ">
                พบข้อมูล ${total_record} รายการ
                แสดงหน้า ${current_page} / <label> ${total_page} </label>
                <input type="hidden" id="oetTotalPage" value="${total_page}">
            </div>
        `

        let pagination = `
            <div class="col-md-6 ">
                <nav>
                    <ul class="pagination justify-content-end">
        `

        if (current_page == 0 || current_page == 1) {
            pagination += `
    <li class="page-item disabled">
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `
        } else {
            pagination += `
    <li class="page-item">
            <a class="page-link" href="#" onclick="JSxSKRPreviousPage()" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
    `
        }

        let ldPage = 0
        let fdPage = 0

        if (total_page > 2 && current_page == total_page) {
            ldPage = total_page
            fdPage = total_page - 3
        } else {
            fdPage = current_page - 2
            ldPage = current_page + 2
        }

        for (let n = 1; n <= total_page; n++) {
            if (n >= fdPage && n <= ldPage) {
                if (current_page == n) {
                    pagination += `
            <li class="page-item active" aria-current="page">
                <a class="page-link" href="#" onclick="JSxSKRSelectPage(${n})" > ${n} </a>
            </li>
            `
                } else {
                    pagination += `
            <li class="page-item" aria-current="page">
                <a class="page-link" href="#" onclick="JSxSKRSelectPage(${n})" > ${n} </a>
            </li>
            `
                }
            }
        }

        pagination += `
            <li class="page-item">
                <a class="page-link" onclick="JSxSKRNextPage()" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
`
        return showList + pagination

    }

    function JSxSKRSelectPage(nPage) {
        document.getElementById("skillDev").innerHTML = "";
        $("#oetFilterGrpPage").val(nPage);
        JSxSKRGetSkillDev();
    }

    if(localStorage.getItem("page") != null){
        let nPage = localStorage.getItem("page")
        $("#oetFilterGrpPage").val(nPage);
        localStorage.removeItem("page")
    }

    function JSxSKRPreviousPage() {
        document.getElementById("skillDev").innerHTML = "";
        var cPage = $("#oetFilterGrpPage").val()
        var nPage = 0;
        if (cPage > 1) {
            nPage = cPage - 1;
            $("#oetFilterGrpPage").val(nPage)

            JSxSKRGetSkillDev();
        }
    }

    function JSxSKRNextPage() {

        var cPage = $("#oetFilterGrpPage").val()
        var tPage = $("#oetTotalPage").val()

        var nPage = 0;
        if (cPage < tPage) {
            nPage = parseInt(cPage) + 1;
            $("#oetFilterGrpPage").val(nPage)
            document.getElementById("skillDev").innerHTML = "";
            JSxSKRGetSkillDev();
        }
    }

    function JSxSKRResetPage(ptData) {
        tDepCode = $('#ocmDepSearch').val();
        $('#oetDepSearchCode').val(tDepCode);
        document.getElementById("skillDev").innerHTML = "";
        $("#oetFilterGrpPage").val(1);
        // console.log(ptData);
        if(ptData == '1') {
            JSxSKRGetSkillGroup();
        }
        JSxSKRGetSkillDev();
    }


    function JSxSKRUpdateMySkill(ptMySkillID, ptEmail, ptSkillName, ptIndex) {
        // console.log(ptMySkillID, ptEmail, ptSkillName, $('#ocmLevelSkill'+ ptIndex).val())

        let ptLevelSkill = $('#ocmLevelSkill' + ptIndex).val()

        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventUpdateMySkill') ?>", // เปลี่ยนเป็น URL ที่จะทำการอัพเดทข้อมูลลงฐานข้อมูล
            data: {
                "oetSkillcode": ptMySkillID,
                "oetSkillname": ptSkillName,
                "ocmLevelSkill": ptLevelSkill,
            },
            cache: false,
            timeout: 0,
            success: function (response) {
                // window.location.href = '<?= base_url('/index.php/Skillrecord') ?>';
                // สำเร็จ: คุณสามารถดำเนินการตามที่คุณต้องการเมื่ออัพเดทเสร็จแล้ว
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาดในการอัพเดทข้อมูล');
            }
        });
    }


    document.addEventListener("DOMContentLoaded", function () {
        // หา Element ของไอคอน
        const icon1 = document.getElementById("icon1");

        // กำหนด Tooltip ด้วยคำสั่ง new bootstrap.Tooltip()
        new bootstrap.Tooltip(icon1, {
            placement: "bottom", // กำหนดตำแหน่งของ Tooltip
            title: `
                <p>
                    <b>4: ดีมาก</b> 
                    มีทักษะความรู้ ความชำนาญในเรื่องนั้นๆเกิน 71%ขึ้นไป เช่น สอนหรือสามารถแนะนำผู้อื่นๆได้ทุกอย่างในเรื่องนั้น,เคยนำเสนอแบบเป็นทางการกับลูกค้า หรือเคยสอนทีมเกิน 10 คน (หัวหน้างานยืนยันได้)
                </p>
                <hr>
                <p>
                    <b>3: ดี</b> 
                    มีทักษะความรู้ ความชำนาญในเรื่องนั้นๆเกิน 51%-70% เช่นใช้งานได้ในเกณฑ์ดี,มีคำแนะนำง่ายๆให้ผู้อื่นได้ เป็นต้น
                </p>
                <hr>
                <p>
                    <b>2: พอใช้</b> 
                    มีทักษะความรู้ ความชำนาญในเรื่องนั้นๆเกิน 21%-50% เช่นใช้งานได้,ค้นคว้าเพิ่มเติมได้เอง,มีพื้นฐานมาแล้ว เป็นต้น
                </p>
                <hr>
                <p>
                    <b>0: ไม่มี</b> 
                    ไม่มีทักษะความรู้ ความชำนาญในเรื่องนั้นเลยหรือต่ำกว่า 20% เช่นไม่เคยใช้งาน,ได้ยินมาบ้าง,เคยอ่านมาบ้างแต่ไม่เคยใช้ เป็นต้น
                </p>
      
    `, // ข้อความที่จะแสดงใน Tooltip
            html: true // เนื่องจากเราใช้ HTML ใน title
        });
    });


    function JSxSKRGetSkillGroup() {

        tDepCode = $('#oetDepSearchCode').val();
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventGetSkillGroup') ?>",
            data: {
                'tDepCode': tDepCode
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                // console.log(tResult);
                var aResult = JSON.parse(tResult)
                // console.log(aResult);
                $('#oetGrpSearch').empty();
                if(aResult['rtCode'] == '200') {
                    $('#oetGrpSearch').append(new Option("ทั้งหมด", ""))
                    aResult['raItems'].forEach(function(obj) {
                        // console.log(obj['FTSkgCode']);
                        $('#oetGrpSearch').append(new Option(obj['FTSkgGrpName'], obj['FTSkgCode']))
                    })
                }else{
                    $('#oetGrpSearch').append(new Option("ทั้งหมด", ""))
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
            }
        });

    }

</script>
