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

    <div id="odvCardSkill" class="container-fluid" style="margin-top:10px">
        <div class="row" style="margin-top:15px">
            <!-- <div class="col-md-12">
                <h5>ข้อมูลโปรเจ็ค</h5>
            </div> -->
            <div class="col-md-4">
                <table widht="100%">
                    <tr>
                    <td width="20%">แผนก
                            <?php 
                            // print_r($UsrInfo);
                            $tUsrDepCode = trim($UsrInfo['raItems'][0]['FTDepCode']);
                            $tUsrDepName =  trim($UsrInfo['raItems'][0]['FTDepName']);
                            
                            ?>
                            <div class="input-group mb-3 ">
                                <input type="text" value="<?=$tUsrDepName?>" class="form-control" disabled>
                            <input type="hidden" id="oetDevSearch" name="oetDevSearch" value="<?=$tUsrDepCode?>" class="form-control">
                            <!-- <select name="oetDevSearch" id="oetDevSearch" class="form-control" onchange="ResetPage()">
                                <option value="">ทั้งหมด</option>
                                <?php //foreach($DepartmentList["raItems"] as $key1=>$val1){ ?>
                                <option value="<?=$val1["FTDepCode"]?>"><?=$val1["FTDepName"]?></option>
                                <?php //} ?>
                            </select> -->
                            </div>
                            
                        </td>
                        <td width="40%">
                            ค้นหา
                            <div class="input-group mb-3 ">
                                <input type="text" name="oetLikeSearch" id="oetLikeSearch" class="form-control"
                                    placeholder="กรอกคำค้นหา">
                                <button class="btn btn-primary" type="button" onclick="JSxSKRFilterData()">ค้นหา</button>
                            </div>
                        </td>

                    </tr>
                </table>
            </div>
            <div class="col-md-8 row">
                <div class=col-md-4>

                </div>
                <div class="col-md-8" style="text-align:right; margin-top:20px;">

                    <!-- <div class="col-md-3" style="text-align:right; margin-top:20px;"> -->
                    <button type="button" class="btn btn-primary" onclick="JSxSKRAddNewSkill()">+ เพิ่มทักษะ</button>
                </div>
            </div>
            <div class="col-lg-12" style="margin-top: 20px">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 10%">ลำดับ</th>
                            <th style="width: 20%">ทักษะ</th>
                            <th style="width: 20%">กลุ่มทักษะ</th>
                            <th style="width: 20%">แผนก</th>
                            <th style="width: 20%">บทบาท</th>
                            <th class="text-center" style="width: 4%">ลบ</th>
                            <th class="text-center" style="width: 10%">แก้ไข</th>

                        </tr>
                    <tbody id="skill">

                    </tbody>
                    </thead>
                    <tbody>
                </table>
            </div>
        </div>
        <div>
            <input type="hidden" id="oetFilterGrpPage" value="1">
        </div>

        <div id="pagination" style="display:flex">

        </div>

    </div>



</body>

</html>

<script>

    $(document).ready(function () {
        JSxSKRGetSkillList();
    });

    function JSxSKRFilterData() {
        document.getElementById("skill").innerHTML = "";
        $("#oetFilterGrpPage").val(1);
        JSxSKRGetSkillList();

    }

    function JSxSKRGetSkillList() {
        var tDevSearch = $("#oetDevSearch").val()
        var tLikeSearch = $("#oetLikeSearch").val()
        var nPage = $("#oetFilterGrpPage").val()
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKREventGetSkillList') ?>",
            data: {
                "tDevSearch": tDevSearch,
                "tLikeSearch": tLikeSearch,
                "nPage": nPage
            },
            cache: false,
            timeout: 0,
            success: function (oResult) {
                if (oResult.skill.rtCode == '200') {
                    // console.log(oResult.skill.rtCode);

                    if (oResult.skill.raItems) {

                        oResult.skill.raItems.forEach((val, index) => {
                            //console.log(val);
                            let tRolCode = val.FTRolCode
                            let tSkdRolName;
                            // console.log(tRolCode);

                            switch (tRolCode) {
                                case '00001':
                                    tSkdRolName = "Senior PGM";
                                    break;
                                case '00002':
                                    tSkdRolName = "SA";
                                    break;
                                case '00003':
                                    tSkdRolName = "Programmer "
                                    break;
                                case '00004':
                                    tSkdRolName = "Report"
                                    break;
                                case '00005':
                                    tSkdRolName = "Tester"
                                    break;
                                case '00006':
                                    tSkdRolName = "Mgt"
                                    break;
                                
                                case '99999':
                                    tSkdRolName = "All"
                                    break;
                                
                            }
                            let tbody = ` 
                    
                    
                    <tr>
                        <td class="text-center">${val.RowSkillID}</td>
                        <td>${val.FTSkrSkillName}</td>
                        <td>${val.FTSkgGrpName}</td>
                        <td>${val.FTDepName}</td>
                        <td>${val.FTRolName}</td>
                        <td class="text-center">
                            <img src="<?php echo base_url('/assets/bin.png'); ?>"
                                style="margin-top:7px; width:12px;cursor:pointer" onclick="JSxSKRDeleteSkill(${val.FTSkrCode})">
                        </td>
                        <td class="text-center">
                            <img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer"
                                onclick="JSxSKREditSkill(${val.FTSkrCode})">
                        </td>
                        
                        
                    </tr>`


                            $("#skill").append(tbody)

                        });
                    }
                } else {
                    let tbody = `
                    <tr>
                        <td colspan="8">ไม่พบข้อมูลทักษะ</td>
                    </tr>
                    `
                    $("#skill").append(tbody)

                }
                let total_page = oResult.skill.total_pages
                let total_record = oResult.skill.total_record
                let current_page = oResult.skill.current_page
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

    function JSxSKRDeleteSkill(ptSkillID) {
        if (confirm("ยืนยันที่จะลบทักษะนี้ออกจากระบบใช่หรือไม่") == true) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('/index.php/tpjSKREventDeleteSkill') ?>",
                data: {
                    'ptSkillID': ptSkillID
                },
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    if (tResult.status != 'error') {
                        location.reload();
                    } else {
                        alert(tResult.message)
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                }
            });

        }
    }

    function JSxSKRAddNewSkill() {
        window.location.href = 'tpjSKRPageNewSkill';
    }

    function JSxSKREditSkill(ptSkillID) {
        // window.location.href = 'EditGroupSkill';
        var nPage = $("#oetFilterGrpPage").val()
        $.ajax({
            type: "POST",
            url: "<?= base_url('/index.php/tpjSKRPageEditSkill') ?>",
            data: {
                'ptSkillID': ptSkillID
                ,
                    "nPage": nPage
            },
            cache: false,
            timeout: 0,
            success: function (tResult) {
                $('#odvCardSkill').html(tResult)
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
        document.getElementById("skill").innerHTML = "";
        $("#oetFilterGrpPage").val(nPage);
        JSxSKRGetSkillList();
    }

    if(localStorage.getItem("page") != null){
        let nPage = localStorage.getItem("page")
        $("#oetFilterGrpPage").val(nPage);
        localStorage.removeItem("page")
    }
    

    function JSxSKRPreviousPage() {
        document.getElementById("skill").innerHTML = "";
        var cPage = $("#oetFilterGrpPage").val()
        var nPage = 0;
        if (cPage > 1) {
            nPage = cPage - 1;
            $("#oetFilterGrpPage").val(nPage)

            JSxSKRGetSkillList();
        }
    }

    function JSxSKRNextPage() {

        var cPage = $("#oetFilterGrpPage").val()
        var tPage = $("#oetTotalPage").val()

        var nPage = 0;
        if (cPage < tPage) {
            nPage = parseInt(cPage) + 1;
            $("#oetFilterGrpPage").val(nPage)
            document.getElementById("skill").innerHTML = "";
            JSxSKRGetSkillList();
        }
    }

</script>
