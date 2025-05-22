<div class="view">
    <div class="wrapper">
        <table class="table">
            <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อใบสั่งซื้อ</th>
                    <th>เลขที่ใบสั่งซื้อ</th>
                    <th>วันที่ใบสั่งซื้อ</th>
                    <th>วันที่เริ่ม</th>
                    <th>วันที่เสร็จ</th>
                    <th>% Progress</th>
                    <th>สถานะ</th>
                    <th class="text-center">ลบ</th>
                    <th>แก้ไข</th>
                    <th>รอบชำระเงิน</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $Nno = 1;

                if ($ProjectList['rtCode'] == '200') {
                    foreach ($ProjectList["raItems"] as $key0 => $val0) {
                        $tDocNo = $val0["FTPohDocNo"];
                ?>
                        <tr>
                            <td class="text-center"><?php echo $Nno; ?></td>
                            <td><?php echo $val0["FTPohName"]; ?></td>
                            <td><?php echo $val0["FTPohDocNo"]; ?></td>
                            <td><?= date('d/m/Y', strtotime($val0["FDPohDocDate"])) ?></td>
                            <td> <?= date('d/m/Y', strtotime($val0["FDPohStart"])) ?></td>
                            <td><?= date('d/m/Y', strtotime($val0["FDPohFinish"])) ?></td>
                            <td class="text-end"><?php echo number_format($val0["FCPohPercentDone"], 2); ?></td>
                            <td>
                                <!-- switch case  -->
                                <?php
                                $tStatus = $val0["FTPohStaDoc"];
                                switch ($tStatus) {
                                    case "1":
                                        echo "Wait Quotation";
                                        break;
                                    case "2":
                                        echo "Quatation";
                                        break;
                                    case "3":
                                        echo "Wait PO";
                                        break;
                                    case "4":
                                        echo "PO";
                                        break;
                                    case "5":
                                        echo "Email Confirm PO";
                                        break;
                                    case "6":
                                        echo "Cancel";
                                        break;
                                    default:
                                        echo "PO";
                                }
                                ?>
                                <!--end switch case  -->
                            </td>
                            <td class="text-center"><img src="<?php echo base_url('/assets/bin.png'); ?>" style="width:12px;cursor:pointer" onclick="FStCPPODeletePo('<?= $tDocNo; ?>','<?= $val0['FTPrjCode']; ?>')"></td>
                            <td class="text-center"><img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer" onclick="JStPOEdit('<?= $tDocNo; ?>','<?= $val0['FTPrjCode']; ?>')">
                            </td>
                            <td class="text-center"><button class="xWManage btn btn-primary btn-sm" data="<?php echo $val0["FTPohDocNo"]; ?>" data-project=<?php echo $val0["FTPrjCode"]; ?> data-label="<?php echo $val0["FTPohName"]; ?>"><?php echo 'จัดการ'; ?></button>
                            </td>
                        </tr>
                    <?php
                        $Nno++;
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="20" class="text-center">ไม่พบข้อมูลโปรเจ็ค</td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>
    </div>
</div>


<a href="#" onclick="history.back()" style="cursor='pointer'">
    << ย้อนกลับ </a>


        <div class="col-md-6 ">
            พบข้อมูล <?php echo $ProjectList["total_record"]; ?> รายการ
            แสดงหน้า <?php echo $ProjectList["current_page"]; ?>/ <label><?php echo $ProjectList["total_pages"]; ?></label>
            <input type="hidden" id="oetTotalPage" value="<?php echo $ProjectList['total_pages']; ?>">
        </div>
        <div class="col-md-6 ">
            <nav>
                <ul class="pagination justify-content-end">
                    <?php if ($ProjectList["current_page"] == 0 or $ProjectList["current_page"] == 1) { ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php } else { ?>
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="PreviousPage()" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php } ?>
                    <?php
                    $cPage = $ProjectList["current_page"];
                    $tPage = $ProjectList["total_pages"];

                    if ($tPage > 2 and $cPage == $tPage) {

                        $ldPage = $tPage;
                        $fdPage =  $tPage - 3;
                    } else {
                        $fdPage =  $cPage - 2;
                        $ldPage = $cPage  + 2;
                    }


                    for ($n = 1; $n <= $ProjectList["total_pages"]; $n++) {
                    ?>
                        <?php if ($n >= $fdPage and $n <= $ldPage) { ?>
                            <?php if ($ProjectList["current_page"] == $n) { ?>
                                <!-- <li class="page-item active" aria-current="page">
                <a class="page-link" href="#" onclick="SelectPage('<?= $n ?>')"><?= $n ?></a>
            </li> -->
                            <? } else { ?>
                                <!-- <li class="page-item" aria-current="page">
                <a class="page-link" href="#" onclick="SelectPage('<?= $n ?>')"><?= $n ?></a>
            </li> -->
                            <?php } ?>
                            <li class="page-item" aria-current="page">
                                <a class="page-link" href="#" onclick="SelectPage('<?= $n ?>')"><?= $n ?></a>
                            </li>
                        <?php } ?>
                    <?php  } ?>
                    <li class="page-item">
                        <a class="page-link" href="#" onclick="NextPage()" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>



        <div class="modal" tabindex="-1" id="add_peroid">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">รอบชำระเงิน</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-5 pl-0">
                                <div style="float: left;">รอบจ่ายเงิน :</div>
                                <div id="olaLabel" style="float: left;"></div>
                            </div>

                        </div>
                        <form id="ofmAddPeriod">
                            <input type="hidden" id="ohdPocSeqNo" name="PocSeqNo">
                            <input type="hidden" id="ohdPohDocNo" name="PohDocNo">
                            <input type="hidden" id="ohdProjectNo" name="ohdProjectNo">

                            <div class="row">
                                <div class="col-4" style="padding-right: 3px;"><span class="red-text">*</span> งวดชำระ
                                    <input type="text" class="form-control" name="oetPeriodName" id="oetPeriodName" placeholder="ชื่อรอบชำระ">
                                </div>
                                <div class="col-4" style="padding-right: 3px;padding-left: 3px;">
                                    <span class="red-text">*</span> วันที่
                                    <div class="input-group">
                                        <input type="text" id="oetPeriodDate" name="oetPeriodDate" placeholder="ระบุวัน" class="form-control datepicker" placeholder="Plan Start" maxlength="255" value="">
                                        <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                    </div>


                                </div>
                                <div class="col-4 " style="padding-right: 3px;padding-left: 3px;">
                                    <span class="red-text">*</span> อ้างอิงใบเสร็จเลขที่
                                    <input type="text" class="form-control" id="oetRefInv" name="oetRefInv" placeholder="อ้างอิงใบเสร็จเลขที่">
                                </div>
                            </div>
                            <div class="row">


                                <div class="col-6" style="padding-right: 3px;">
                                    <span class="red-text">*</span> หมายเหตุ
                                    <input type="text" class="form-control" id="oetPeriodRemark" name="oetPeriodRemark" placeholder="ระบุหมายเหตุ">
                                </div>
                                <div class="col-6" style="padding-left: 3px;padding-right: 3px;">
                                    <span class="red-text">*</span> สถานะ%
                                    <input type="number" class="form-control text-end" name="oetPeriodStatus" id="oetPeriodStatus">

                                </div>
                        </form>
                        <table class="table">
                            <thead>
                                <th class="text-center">ลำดับ</th>
                                <th>งวดชำระ</th>
                                <th>วันที่</th>
                                <th>หมายเหตุ</th>
                                <th>สถานะ</th>
                                <th>ลบ</th>
                                <th>แก้ไข</th>
                            </thead>
                            <tbody id="period_data">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancel">ยกเลิก</button>
                    <!-- <button type="button" class="btn btn-warning" id="obtAddPeroid" onclick="JStPOUpdatePeriod()"
                fdprocessedid="sjixdi">อัพเดท</button> -->
                    <button type="button" class="btn btn-primary" id="obtAddPeroid" onclick="JStPOAddPeriod()">บันทึก</button>
                </div>
            </div>
        </div>
        </div>


        <div class="modal" tabindex="-1" id="edit_modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">แก้ไขใบสั่งซื้อ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12">
                            <form id="ofmUpdatePo" enctype="multipart/form-data">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">
                                            <b>ข้อมูลใบสั่งซื้อ</b>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <input type="hidden" id="ohdProjectCode" name="ohdProjectCode">
                                                    <label for="olaPoTitleEdit" class="form-label">ชื่อใบสั่งซื้อ</label>
                                                    <input type="text" id="oetPoTitleEdit" value="" name="oetPoTitleEdit" class="form-control" placeholder="title" maxlength="255">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaStatusEdit" class="form-label">สถานะใบสั่งซื้อ</label>
                                                    <select class="form-select" id="ocmPoStatusEdit" name="ocmPoStatusEdit" value="">
                                                        <option value="">ระบุสถานะ</option>
                                                        <option value="1">Wait Quotation</option>
                                                        <option value="2">Quatation</option>
                                                        <option value="3">Wait PO</option>
                                                        <option value="4">PO</option>
                                                        <option value="5">Email Confirm PO</option>
                                                        <option value="6">Cancel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">

                                                    <label for="olaPoProgressEdit" class="form-label">%Progress</label>
                                                    <input type="number" id="oetPoProgressEdit" name="oetPoProgressEdit" class="form-control text-end" placeholder="Progress" maxlength="255" value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoNoEdit" class="form-label">เลขที่ใบสั่งซื้อ</label>
                                                    <input type="text" id="oetPoNoEdit" name="oetPoNoEdit" class="form-control" placeholder="PO No" maxlength="255" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoRemarkEdit" class="form-label">หมายเหตุ</label>
                                                    <input type="text" id="oetPoRemarkEdit" name="oetPoRemarkEdit" class="form-control" placeholder="PO Remark" maxlength="255" value="">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12">
                                                    <label for="olaPoDateEdit" class="form-label">วันที่ใบสั่งซื้อ</label>
                                                    <div class="input-group">
                                                        <input type="text" id="oetPoDateEdit" name="oetPoDateEdit" class="form-control datepicker" placeholder="PO Date" maxlength="255" value="">
                                                        <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoPlanStartEdit" class="form-label">วันเริ่มแผน</label>
                                                    <div class="input-group">
                                                        <input type="text" id="oetPoPlanStartEdit" name="oetPoPlanStartEdit" class="form-control datepicker" placeholder="Plan Start" maxlength="255" value="">
                                                        <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoFinishEdit" class="form-label">วันที่เสร็จ</label>
                                                    <div class="input-group">
                                                        <input type="text" id="oetPoFinishEdit" name="oetPoFinishEdit" class="form-control datepicker" placeholder="Plan Finish" maxlength="255" value="">
                                                        <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoUrlReferEdit" class="form-label">Url อ้างอิง</label>
                                                    <input type="text" id="oetPoUrlReferEdit" name="oetPoUrlReferEdit" class="form-control" placeholder="Url Refer Plan" maxlength="255" value="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card mb-2">
                                    <div class="card-body">
                                        <div class="col-md-12" style="font-size:18px;  padding-bottom:5px"><b>Man/Day</b></div>
                                        <div class="row">
                                            <div class="col-lg-2 col-md-6 col-sm-12">

                                                <label for="olaMDDevEdit" class="form-label">MD Dev:</label>
                                                <input type="number" id="oetMDDevEdit" name="oetMDDevEdit" class="form-control text-end""
                                    placeholder=" MD Dev" maxlength="255">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">

                                                <label for="olaMDTesterEdit" class="form-label">MD Tester:</label>
                                                <input type="number" id="oetMDTesterEdit" name="oetMDTesterEdit" class="form-control text-end"" placeholder=" MD Tester" maxlength="255">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">

                                                <label for="olaMDsaEdit" class="form-label">MD Sa:</label>
                                                <input type="number" id="oetMDsaEdit" name="oetMDsaEdit" class="form-control text-end"" placeholder=" MD Sa" maxlength="255">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <label for="olaMDPmEdit" class="form-label">MD PM:</label>
                                                <input type="number" id="oetMDPmEdit" name="oetMDPmEdit" class="form-control text-end"" placeholder=" MD Pm" maxlength="255">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">

                                                <label for="olaMDInterfaceEdit" class="form-label">Man %Interface:</label>
                                                <input type="number" id="oetMDInterfaceEdit" name="oetMDInterfaceEdit" class="form-control text-end"" placeholder=" MD Interface" maxlength="255">
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <label for="olaMDTotalEdit" class="form-label">MD Total:</label>
                                                <input type="number" id="oetMDTotalEdit" name="oetMDTotalEdit" class="form-control text-end"" placeholder=" MD total" maxlength="255">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label for="olaMdPHPEdit" class="form-label">MD PHP</label>
                                                <input type="number" id="oetMdPHPEdit" name="oetMdPHPEdit" class="form-control text-end"" placeholder=" MD PHP" maxlength="255">
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">

                                                <label for="olaMDCEdit" class="form-label">MD C#:</label>
                                                <input type="number" id="oetMDCEdit" name="oetMDCEdit" class="form-control text-end""  placeholder=" MD C" maxlength="255">
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <label for="olaMDAndriodEdit" class="form-label">MD Andriod:</label>
                                                <input type="number" id="oetMDAndriodEdit" name="oetMDAndriodEdit" class="form-control text-end"" placeholder=" MD Andriod" maxlength="255">
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <label for="olaFiel"><b>แนบไฟล์</b></label>
                                                <input type="file">
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" id="obtUpdate">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal" tabindex="-1" id="add_modal">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">เพิ่มใบสั่งซื้อ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="ofmAddPo">
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="col-md-12">

                                        <div class="col-md-12" style="font-size:18px;  padding-bottom:5px">
                                            <b>ข้อมูลใบสั่งซื้อ</b>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoTitle"><span class="red-text">*</span>
                                                        ชื่อใบสั่งซื้อ</label>
                                                    <input type="hidden" id="ohdProjectId" name="ohdProjectId">
                                                    <input type="text" id="oetPoTitle" name="oetPoTitle" class="form-control" placeholder="ระบุชื่อใบสั่งซื้อ" maxlength="255">
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoStatus"><span class="red-text">*</span>
                                                        สถานะใบสั่งซื้อ</label>
                                                    <select class="form-select" id="ocmPoStatus" name="ocmPoStatus" value="">
                                                        <option value="">ระบุสถานะ</option>
                                                        <option value="1">Wait Quotation</option>
                                                        <option value="2">Quatation</option>
                                                        <option value="3">Wait PO</option>
                                                        <option value="4">PO</option>
                                                        <option value="5">Email Confirm PO</option>
                                                        <option value="6">Cancel</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoProgress"><span class="red-text">*</span>
                                                        %Progress:</label>
                                                    <input type="number" id="oetPoProgress" name="oetPoProgress" class="form-control text-end" placeholder="Progress">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoNo"><span class="red-text">*</span>
                                                        เลขที่ใบสั่งซื้อ</label>
                                                    <input type="text" id="oetPoNo" name="oetPoNo" class="form-control" placeholder="ระบุเลขที่ใบสั่งซื้อ">
                                                    <div class="text-danger" id="validatepono"></div>
                                                </div>
                                            </div>
                                            <div class=" col-lg-4 col-md-6 col-ms-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoRemark"><span class="red-text">*</span>
                                                        หมายเหตุ:</label>
                                                    <input type="text" id="oetPoRemark" name="oetPoRemark" class="form-control" placeholder="ระบุหมายเหตุ">
                                                </div>

                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoDate"><span class="red-text">*</span>
                                                        วันที่ใบสั่งซื้อ:</label>
                                                    <div class="input-group">
                                                        <input type="text" id="oetPoDate" name="oetPoDate" class="form-control datepicker" placeholder="dd/mm/yyyy">
                                                        <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-ms-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoPlanStart"><span class="red-text">*</span>
                                                        วันที่เริ่มแผน:</label>
                                                    <div class="input-group">
                                                        <input type="text" id="oetPoPlanStart" name="oetPoPlanStart" class="form-control datepicker" placeholder="dd/mm/yyyy">
                                                        <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12">
                                                    <label for="olaPoFinish"><span class="red-text">*</span>
                                                        วันที่เสร็จ:</label>
                                                    <div class="input-group">
                                                        <input type="text" id="oetPoFinish" name="oetPoFinish" class="form-control datepicker" placeholder="dd/mm/yyyy">
                                                        <span class="input-group-text"><i class="fa-regular fa-calendar-days"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="form-group col-md-12 input-data">
                                                    <label for="olaPoUrlRefer"><span class="red-text">*</span> Url
                                                        อ้างอิง:</label>
                                                    <input type="text" id="oetPoUrlRefer" name="oetPoUrlRefer" class="form-control" placeholder="Url อ้างอิง">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="col-md-12" style="font-size:18px;  padding-bottom:5px"><b>Man/Day</b></div>
                                    <div class="row">
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <label for="olaMdDev"> MD Dev :</label>

                                            <input type="number" id="oetMDDev" name="oetMDDev" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">

                                            <label for="olaMdTester">MD Tester :</label>
                                            <input type="number" id="oetMDTester" name="oetMDTester" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <label for="olaMdSa">MD Sa:</label>
                                            <input type="number" id="oetMDsa" name="oetMDsa" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <label for="olaMdPm">MD PM:</label>
                                            <input type="number" id="oetMDPm" name="oetMDPm" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <label for="olaMdInterface">MD %Interface:</label>
                                            <input type="number" id="oetMDInterface" name="oetMDInterface" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-2 col-md-3 col-sm-6">
                                            <label for="olaMdTotal">MD Total:</label>
                                            <input type="number" id="oetMDTotal" name="oetMDTotal" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4 col-md-3 col-sm-6">
                                            <label for="olaMdPhp">MD PHP</label>
                                            <input type="number" id="oetMdPHP" name="oetMDPHP" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-sm-6">
                                            <label for="olaMdC">MD C#:</label>
                                            <input type="number" id="oetMDC" name="oetMDC" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                        <div class="col-lg-4 col-md-3 col-sm-6">
                                            <label for="olaMdAndroid">MD Andriod:</label>
                                            <input type="number" id="oetMDAndriod" name="oetMDAndriod" class="form-control text-end" placeholder="0" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <label for="olaFiel"><b>แนบไฟล์</b></label>
                                            <input type="file">
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        <button type="button" class="btn btn-primary" id="obtAdd" onclick="JStPOAddData()">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {

                $(".datepicker")
                    .datepicker({
                        format: 'dd/mm/yy',
                        autoclose: true,
                        todayHighlight: true,
                        dateFormat: 'dd/mm/yy',
                        changeMonth: true,
                        changeYear: true,
                        // minDate: new Date()
                    }).datepicker("setDate", new Date());

            });

            $('#oetMDDev,#oetMDTester,#oetMDsa,#oetMDPm,#oetMDInterface').keyup(function() {
                var tMDDev = $('#oetMDDev').val();
                var tMDTester = $('#oetMDTester').val();
                var tMDsa = $('#oetMDsa').val();
                var tMDPm = $('#oetMDPm').val();
                var tMDInterface = $('#oetMDInterface').val();
                $('#oetMDTotal').val(parseFloat(tMDDev) + parseFloat(tMDTester) + parseFloat(tMDsa) + parseFloat(
                        tMDPm) +
                    parseFloat(tMDInterface));
            });

            $('#oetMDDev,#oetMDTester,#oetMDsa,#oetMDPm,#oetMDInterface').click(function() {
                var tMDDev = $('#oetMDDev').val();
                var tMDTester = $('#oetMDTester').val();
                var tMDsa = $('#oetMDsa').val();
                var tMDPm = $('#oetMDPm').val();
                var tMDInterface = $('#oetMDInterface').val();
                $('#oetMDTotal').val(parseFloat(tMDDev) + parseFloat(tMDTester) + parseFloat(tMDsa) + parseFloat(
                        tMDPm) +
                    parseFloat(tMDInterface));
            });

            $('#oetMDDevEdit,#oetMDTesterEdit,#oetMDsaEdit,#oetMDPmEdit,#oetMDInterfaceEdit').keyup(function() {
                var tMDDev = $('#oetMDDevEdit').val();
                var tMDTester = $('#oetMDTesterEdit').val();
                var tMDsa = $('#oetMDsaEdit').val();
                var tMDPm = $('#oetMDPmEdit').val();
                var tMDInterface = $('#oetMDInterfaceEdit').val();
                $('#oetMDTotalEdit').val(parseFloat(tMDDev) + parseFloat(tMDTester) + parseFloat(tMDsa) + parseFloat(
                        tMDPm) +
                    parseFloat(tMDInterface));
            });

            $('#oetMDDevEdit,#oetMDTesterEdit,#oetMDsaEdit,#oetMDPmEdit,#oetMDInterfaceEdit').click(function() {
                var tMDDev = $('#oetMDDevEdit').val();
                var tMDTester = $('#oetMDTesterEdit').val();
                var tMDsa = $('#oetMDsaEdit').val();
                var tMDPm = $('#oetMDPmEdit').val();
                var tMDInterface = $('#oetMDInterfaceEdit').val();
                $('#oetMDTotalEdit').val(parseFloat(tMDDev) + parseFloat(tMDTester) + parseFloat(tMDsa) + parseFloat(
                        tMDPm) +
                    parseFloat(tMDInterface));
            });


            function BackToProjectList() {
                window.location.href = "<?= base_url('/index.php/ProjectList') ?>";
            }


            /**
             * Functionality : Filter Po
             * Parameters : -
             * Creator : 01/11/2023 Boripat
             * Last Modified : -
             * Return : Data List Purchase Order
             * Return Type : JSON
             */


            function JSxPOFilterData() {
                JStPOGetData();
            }

            $('#oetPeriodStatus').keyup(function() {
                if ($(this).val() > 100) {
                    alert('ไม่เกิน 100');
                    $(this).val('');
                }

            })

            $('#oetPoProgress,#oetPoProgressEdit').keyup(function() {
                if ($(this).val() > 100) {
                    alert('ไม่เกิน 100');
                    $(this).val('');
                }
            })

            function JStPOAddData() {
                var oFormData = new FormData($('#ofmAddPo')[0]);
                if ($('#oetPoTitle').val() == "") {
                    alert('กรุณาระบุชื่อใบสั่งซื้อ');
                    $('#oetPoTitle').focus();
                    return false;
                }

                if ($('#ocmPoStatus').val() == "") {
                    alert('กรุณาระบุสถานะใบสั่งซื้อ');
                    $('#ocmPoStatus').focus();
                    return false;
                }

                if ($('#oetPoProgress').val() == "") {
                    alert('กรุณาระบุ %Progress');
                    $('#oetPoProgress').focus();
                    return false;

                }
                if ($('#oetPoNo').val() == "") {
                    alert('กรุณาระบุเลขที่ใบสั่งซื้อ');
                    $('#oetPoNo').focus();
                    return false;
                }
                if ($('#oetPoRemark').val() == "") {
                    alert('กรุณาระบุหมายเหตุ');
                    $('#oetPoRemark').focus();
                    return false;
                }

                if ($('#oetPoDate').val() == "") {
                    alert('กรุณาระบุวันที่ใบสั่งซื้อ');
                    $('#oetPoDate').focus();
                    return false;

                }

                if ($('#oetPoPlanStart').val() == "") {
                    alert('วันที่เริ่มแผน');
                    $('#oetPoPlanStart').focus();
                    return false;
                }

                if ($('#oetPoFinish').val() == "") {
                    alert('ระบุวันที่เสร็จ');
                    $('#oetPoFinish').focus();
                    return false;
                }


                $.ajax({
                    url: "<?= base_url('/index.php/docPOEventAdd') ?>",
                    type: "POST",
                    data: oFormData,
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(tResult) {
                        if (tResult.status == false) {
                            $('#validatepono').html(tResult.message);
                            $('#oetPoNo').focus();
                        } else {
                            alert(tResult.message);
                            JStPOGetData();
                            $('#add_modal').modal('hide');
                        }


                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });
            }



            $('.xWManage').click(function() {
                $('#ofmAddPeriod')[0].reset();
                var nPono = $(this).attr('data');
                var tLabel = $(this).attr("data-label");
                var tProject = $(this).attr("data-project");
                $('#olaLabel').html(tLabel);
                $('#ohdPohDocNo').val(nPono);
                $('#ohdProjectNo').val(tProject);
                JStPOGetPeriod(nPono, tProject);
                $('#add_peroid').modal('show');
            })


            function JStPOGetPeriod(nPono, pnProjectNo) {
                //pPono
                $.ajax({
                    type: "get",
                    url: "<?= base_url("/index.php/docPOGetPeriod/"); ?>" + nPono + '/' + pnProjectNo,
                    dataType: "json",
                    success: function(tResult) {
                        console.log(tResult);
                        $('#period_data').html(tResult);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });

            }
            $('#cancel').click(function() {
                $('#oetPeriodName').val('');
                $('#oetPeriodDate').val('');
                $('#oetPeriodRemark').val('');
                $('#oetPeriodStatus').val('');
                $('#ohdPeriodNo').val('');
                $('#obtAddPeroid').attr("onclick", "AddPeriod()");
                $('#obtAddPeroid').html('บันทึก');
                $('#obtAddPeroid').removeClass('btn-warning').addClass(
                    'btn-primary');
                $('#add_peroid').modal('hide');

            });

            function JStPOAddPeriod() {
                try {
                    var result;
                    var ohdPoNo = $('#ohdPohDocNo').val();
                    var tProject = $('#ohdProjectNo').val();
                    var formData = $("#ofmAddPeriod").serialize();
                    if ($('#oetPeriodName').val() == "") {
                        alert('ระบุงวดชำระ');
                        return false;
                    } else if ($('#oetPeriodDate').val() == "") {
                        alert('ระบุวันที่รอบชำระ');
                        return false;
                    } else if ($('#oetPeriodRemark').val() == "") {
                        alert('ระบุหมายเหตุ');
                        return false;
                    } else if ($('#oetPeriodStatus').val() == "") {
                        alert('ระบุสถานะรอบชำระ');
                        return false;
                    } else {
                        $.ajax({
                            url: "<?= base_url("/index.php/docPOEventAddPeriod/"); ?>",
                            type: 'POST',
                            data: formData,
                            success: function(result) {
                                alert('บันทึกสำเร็จ');
                                JStPOGetPeriod(ohdPoNo, tProject);
                                // $("#ofmAddPeriod")[0].reset();
                            },
                        });

                    }
                } catch (error) {
                    console.error(error);
                }
            }


            function JStPODeletePeriod(pPrjCode, pPohDocNo, pPocSeqNo) {

                try {
                    if (confirm("ยืนยันการลบใบ Period ที่เลือกใช่หรือไม่?")) {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url('/index.php/docPOEventDeletePeriod') ?>",
                            data: {
                                "FTPrjPoPeriodCode": pPrjCode,
                                "pPohDocNo": pPohDocNo,
                                "pPocSeqNo": pPocSeqNo
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                alert('ลบข้อมูลสำเร็จ');
                                var ohdPoNo = $('#ohdPohDocNo').val();
                                var ohdProjectNo = $('#ohdProjectNo').val();
                                JStPOGetPeriod(ohdPoNo, ohdProjectNo);
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                            }
                        });
                    }

                } catch (error) {
                    console.error(error);
                }
            }


            async function JStPOUpdatePeriod() {
                try {

                    if ($('#oetPeriodName').val() == "") {
                        alert('ไม่พบข้อมูลงวดชำระในการอัพเดท');
                        return false;
                    }

                    if ($('#oetPeriodDate').val() == "") {
                        alert('ไม่พบข้อมูลวันเดือนปีอัพเดท');
                        return false;
                    }
                    if ($('#oetPeriodRemark').val() == "") {
                        alert('ไม่พบข้อมูลหมายเหตุอัพเดท');
                        return false;
                    }
                    if ($('#oetPeriodDate').val() == "") {
                        alert('ไม่พบสถานะอัพเดท');
                        return false;
                    } else {
                        $.ajax({
                            type: "POST",
                            url: "<?= base_url("/index.php/docPOEventUpdatePeriod/"); ?>",
                            dataType: "json",
                            data: {
                                'ohdPeriodNo': $('#ohdPeriodNo').val(),
                                'oetPeriodName': $('#oetPeriodName').val(),
                                'oetPeriodDate': $('#oetPeriodDate').val(),
                                'oetPeriodStatus': $('#oetPeriodStatus').val(),
                                'oetPeriodRemark': $('#oetPeriodRemark').val(),
                                'oetRefInv': $('#oetRefInv').val(),
                                'PocSeqNo': $('#ohdPocSeqNo').val(),
                                'PohDocNo': $('#ohdPohDocNo').val(),
                                'ohdProjectNo': $('#ohdProjectNo').val()

                            },
                            success: function(result) {
                                alert('บันทึกสำเร็จ');

                                var ohdPoNo = $('#ohdPohDocNo').val();
                                var ohdProjectNo = $('#ohdProjectNo').val();

                                // $("#period_data").find("tr #row", ohdPoNo).css("background-color", "green");
                                JStPOGetPeriod(ohdPoNo, ohdProjectNo);
                                $('#obtAddPeroid').attr("onclick", "JStPOAddPeriod()");
                                $('#oetPeriodName').val('');
                                $('#oetPeriodDate').val('');

                                $('#oetPeriodRemark').val('');
                                $('#oetPeriodStatus').val('');
                                $('#oetRefInv').val('');



                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                            }
                        });
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            async function FStCPPODeletePo(tDocNo, tPrjCode) {
                try {
                    if (confirm("ยืนยันการลบใบ PO ที่เลือกใช่หรือไม่?")) {
                        var tResult = await $.ajax({
                            type: "POST",
                            url: "<?= base_url('/index.php/docPOEventDelete') ?>",
                            data: {
                                "tPrjCode": tPrjCode,
                                "FTPohDocNo": tDocNo
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                alert('ลบข้อมูลสำเร็จ');
                                JStPOGetData()
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                            }
                        });
                        return tResult;
                    }
                } catch (error) {
                    console.error(error);
                }
            }

            $('#obtUpdate').click(function() {
                var oFormData = $("#ofmUpdatePo").serialize();
                $.ajax({
                    type: "POST",
                    url: "<?= base_url("/index.php/docPOEventUpdate/"); ?>",
                    dataType: "json",
                    data: oFormData,
                    success: function(result) {
                        alert('บันทึกสำเร็จ');
                        $('#edit_modal').modal('hide');
                        JStPOGetData();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });
            })




            function JStPOPeriodEdit(pPrjCode, pPohDocNo, pPocSeqNo) {


                $.ajax({
                    type: "POST",
                    url: "<?= base_url("/index.php/docPOEventGetPeriodEdit/"); ?>",
                    dataType: "json",
                    data: {
                        'pPrjCode': pPrjCode,
                        'pPohDocNo': pPohDocNo,
                        'pPocSeqNo': pPocSeqNo
                    },
                    success: function(result) {
                        $('#oetPeriodName').val(result.FTPocName);


                        var FDPocDueDate = new Date(result.FDPocDueDate);
                        var formattFDPocDueDate = ("0" + FDPocDueDate.getDate()).slice(-2) + "/" +
                            ("0" + (FDPocDueDate.getMonth() + 1)).slice(-2) + "/" +
                            FDPocDueDate.getFullYear();

                        $("#oetPeriodDate").val(formattFDPocDueDate);
                        $("#oetPeriodDate").datepicker({
                            dateFormat: 'dd/mm/yy'
                        });





                        // $('#oetPeriodDate').val(result.FDPocDueDate);
                        $('#oetPeriodRemark').val(result.FTPocRemark);
                        $('#oetPeriodStatus').val(parseFloat(result.FCPocPercentDone).toFixed(2));
                        $('#oetRefInv').val(result.FTPocRefInv);
                        $('#ohdPohDocNo').val(result.FTPohDocNo);
                        $('#ohdProjectNo').val(result.FTPrjCode);
                        $('#ohdPocSeqNo').val(result.FNPocSeqNo);

                        $('#obtAddPeroid').attr("onclick", "JStPOUpdatePeriod()");
                        // $('#obtAddPeroid').html('อัพเดท');
                        // $('#obtAddPeroid').removeClass('btn-primary').addClass('btn-warning');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });
            }

            function JStPOEdit(tDocNo, tPrjCode) {



                $.ajax({
                    type: "get",
                    url: "<?= base_url("/index.php/docPOEventEdit/"); ?>" + tDocNo + '/' + tPrjCode,
                    dataType: "json",
                    success: function(tResult) {
                        $('#oetPoTitleEdit').val(tResult.FTPohName);
                        $('#oetPoProgressEdit').val(parseFloat(tResult.FCPohPercentDone).toFixed(2));
                        $('#oetPoNoEdit').val(tResult.FTPohDocNo);
                        $('#oetPoRemarkEdit').val(tResult.FTPohRemark);
                        $('#oetPoUrlReferEdit').val(tResult.FTPohRefUrl);





                        var parsedDate = new Date(tResult.FDPohDocDate);
                        var formattedDate = ("0" + parsedDate.getDate()).slice(-2) + "/" +
                            ("0" + (parsedDate.getMonth() + 1)).slice(-2) + "/" +
                            parsedDate.getFullYear();

                        $("#oetPoDateEdit").val(formattedDate);
                        $("#oetPoDateEdit").datepicker({
                            dateFormat: 'dd/mm/yy'
                        });

                        var FDPohStart = new Date(tResult.FDPohStart);
                        var formattedDateFDPohStart = ("0" + FDPohStart.getDate()).slice(-2) + "/" +
                            ("0" + (FDPohStart.getMonth() + 1)).slice(-2) + "/" +
                            FDPohStart.getFullYear();

                        $("#oetPoPlanStartEdit").val(formattedDateFDPohStart);
                        $("#oetPoPlanStartEdit").datepicker({
                            dateFormat: 'dd/mm/yy'
                        });

                        var FDPohFinish = new Date(tResult.FDPohFinish);
                        var formattedDateFDPohFinish = ("0" + FDPohFinish.getDate()).slice(-2) + "/" +
                            ("0" + (FDPohFinish.getMonth() + 1)).slice(-2) + "/" +
                            FDPohFinish.getFullYear();

                        $("#oetPoFinishEdit").val(formattedDateFDPohFinish);
                        $("#oetPoFinishEdit").datepicker({
                            dateFormat: 'dd/mm/yy'
                        });

                        // $('#oetPoPlanStartEdit').val(tResult.FDPohStart);
                        // $('#oetPoFinishEdit').val(tResult.FDPohFinish);
                        $('#ohdProjectCode').val(tResult.FTPrjCode);
                        $('#ocmPoStatusEdit').val(tResult.FTPohStaDoc)


                        if (tResult.FCPodMdcSharp == null) {
                            var MdSharp = 0;
                        } else {
                            var MdSharp = tResult.FCPodMdcSharp
                        }
                        $('#oetMDCEdit').val(parseFloat(MdSharp).toFixed(2));
                        if (tResult.FCPodMdPhp == null) {
                            var FCPodMdPhp = 0;
                        } else {
                            var FCPodMdPhp = tResult.FCPodMdPhp
                        }
                        $('#oetMdPHPEdit').val(parseFloat(FCPodMdPhp).toFixed(2));

                        if (tResult.FCPodMdAndroid == null) {
                            var FCPodMdAndroid = 0;
                        } else {
                            var FCPodMdAndroid = tResult.FCPodMdAndroid
                        }
                        $('#oetMDAndriodEdit').val(parseFloat(FCPodMdAndroid).toFixed(2));

                        if (tResult.FCPodMdDev == null) {
                            var FCPodMdDev = 0;
                        } else {
                            var FCPodMdDev = tResult.FCPodMdDev
                        }

                        $('#oetMDDevEdit').val(parseFloat(FCPodMdDev).toFixed(2));
                        if (tResult.FCPodMdSa == null) {
                            var FCPodMdSa = 0;
                        } else {
                            var FCPodMdSa = tResult.FCPodMdSa
                        }

                        $('#oetMDsaEdit').val(parseFloat(FCPodMdSa).toFixed(2));

                        if (tResult.FCPodMdPm == null) {
                            var FCPodMdPm = 0;
                        } else {
                            var FCPodMdPm = tResult.FCPodMdPm
                        }
                        $('#oetMDPmEdit').val(parseFloat(FCPodMdPm).toFixed(2));

                        if (tResult.FCPodMdTester == null) {
                            var FCPodMdTester = 0;
                        } else {
                            var FCPodMdTester = tResult.FCPodMdTester
                        }

                        $('#oetMDTesterEdit').val(parseFloat(FCPodMdTester).toFixed(2));
                        if (tResult.FCPodMdInterface == null) {
                            var FCPodMdInterface = 0;
                        } else {
                            var FCPodMdInterface = tResult.FCPodMdInterface
                        }
                        $('#oetMDInterfaceEdit').val(parseFloat(FCPodMdInterface).toFixed(2));

                        if (tResult.FCPodMdTotal == null) {
                            var FCPodMdTotal = 0;
                        } else {
                            var FCPodMdTotal = tResult.FCPodMdTotal
                        }

                        $('#oetMDTotalEdit').val(parseFloat(FCPodMdTotal).toFixed(2));



                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                    }
                });
                $('#edit_modal').modal('show');
            }

            function SelectPage(nPage) {
                $("#oetFilterProjectPage").val(nPage);
                JStPOGetData();
            }

            function PreviousPage() {

                var cPage = $("#oetFilterProjectPage").val()
                var nPage = 0;
                if (cPage > 1) {
                    nPage = cPage - 1;
                    $("#oetFilterProjectPage").val(nPage)

                    JStPOGetData();
                }
            }

            function NextPage() {

                var cPage = $("#oetFilterProjectPage").val()
                var tPage = $("#oetTotalPage").val()

                var nPage = 0;
                if (cPage < tPage) {
                    nPage = parseInt(cPage) + 1;
                    $("#oetFilterProjectPage").val(nPage)

                    JStPOGetData();
                }
            }
        </script>