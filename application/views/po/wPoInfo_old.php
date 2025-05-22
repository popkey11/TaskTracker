<h5 class="mx-2 text-dark"><?php echo ($tActionTitle === 'addPo') ? 'เพิ่มใบสั่งซื้อ' : 'แก้ไขใบสั่งซื้อ' ; ?></h5>
<div class="row mx-md-4 mx-sm-3 mx-0 mt-4">
    <form id="ofmPo" action="<?= $tAction ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="ohdPoCode" id="ohdPoCode" value="<?= isset($aPoData) ? $aPoData['FTPoCode'] : ''; ?>">
        <div class="col-md-12">
            <div class="card border rounded p-3">
                <h5 class="text-dark">ข้อมูลโครงการ</h5>
                <div class="row mt-2 mx-1">
                    <!-- ชื่อโครงการ -->
                    <div class="col-12 col-md-6 mb-3">
                        <span class="text-danger">*</span> <label class="text-dark" for="ocmPoProject">ชื่อโครงการ</label>
                        <select name="ocmPoProject" id="ocmPoProject" class="form-control form-select selectpicker w-100"
                            placeholder="เลือกโครงการ" data-live-search="true">
                            <?php foreach ($aProjectList as $tTeam) { ?>
                                <option value="<?= $tTeam["FTPrjCode"]; ?>" <?= (isset($aPoData) && $aPoData['FTPrjCode'] == $tTeam["FTPrjCode"]) ? 'selected' : ''; ?>>
                                    <?= $tTeam["FTPrjName"]; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- Phase -->
                    <div class="col-12 col-md-6 mb-3">
                        <span class="text-danger">*</span> <label class="text-dark" for="oetPoRelease">Release</label>
                        <input type="text" name="oetPoRelease" id="oetPoRelease" class="form-control w-100" placeholder="กรอก Release"
                            maxlength="255" value="<?= isset($aPoData) ? $aPoData['FTPoRelease'] : ''; ?>">
                    </div>

                    <!-- From -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-dark" for="ocmPoFrom">From</label>
                        <div class="input-group">
                            <select name="ocmPoFrom" id="ocmPoFrom" class="form-control form-select selectpicker w-100" data-live-search="true"
                                placeholder="เลือก From" data-id="ocmPoFrom">
                                <?php foreach ($aPoSelectFrom as $aPoFrom) { ?>
                                    <option value="<?= $aPoFrom['FTPoFrom'] ?>"
                                        <?= isset($aPoData) && $aPoData['FTPoFrom'] === $aPoFrom['FTPoFrom'] ? 'selected' : '' ?>>
                                        <?= $aPoFrom['FTPoFrom'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <small class="text-muted">พิมพ์เพื่อค้นหา หรือพิมพ์เพื่อเพิ่มตัวเลือกใหม่</small>
                    </div>

                    <!-- To -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-dark" for="ocmPoTo">To</label>
                        <div class="input-group">
                            <select name="ocmPoTo" id="ocmPoTo" class="form-control form-select selectpicker w-100" data-live-search="true"
                                placeholder="เลือก To" data-id="ocmPoTo">
                                <?php foreach ($aPoSelectTo as $aPoTo) { ?>
                                    <option value="<?= $aPoTo['FTPoTo'] ?>"
                                        <?= isset($aPoData) && $aPoData['FTPoTo'] === $aPoTo['FTPoTo'] ? 'selected' : '' ?>>
                                        <?= $aPoTo['FTPoTo'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <small class="text-muted">พิมพ์เพื่อค้นหา หรือพิมพ์เพื่อเพิ่มตัวเลือกใหม่</small>
                    </div>

                    <!-- PM -->
                    <div class="col-12 col-md-4 mb-3">
                        <label class="text-dark" for="ocmPoPM">PM</label>
                        <select name="ocmPoPM" id="ocmPoPM" class="form-control form-select selectpicker" placeholder="เลือก PM" data-live-search="true">
                            <?php foreach ($aTeamLeadList as $aPM) { ?>
                                <option value="<?= $aPM["FTDevCode"]; ?>" <?= (isset($aPoData) && $aPoData['FTPoPM'] == $aPM["FTDevCode"]) ? 'selected' : ''; ?>>
                                    <?= $aPM["FTDevName"] . ' (' . $aPM['FTDevNickName'] . ')' ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- SA -->
                    <div class="col-12 col-md-4 mb-3">
                        <label class=" text-dark" for="ocmPoSA">SA</label>
                        <select name="ocmPoSA" id="ocmPoSA" class="form-control form-select selectpicker" placeholder="เลือก SA" data-live-search="true">
                            <?php foreach ($aTeamLeadList as $aSA) { ?>
                                <option value="<?= $aSA["FTDevCode"]; ?>" <?= (isset($aPoData) && $aPoData['FTPoSA'] == $aSA["FTDevCode"]) ? 'selected' : ''; ?>>
                                    <?= $aSA["FTDevName"] . ' (' . $aSA['FTDevNickName'] . ')' ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- BD -->
                    <div class="col-12 col-md-4 mb-3">
                        <label class="text-dark" for="oetPoBD">BD</label>
                        <input type="text" name="oetPoBD" id="oetPoBD" class="form-control" maxlength="255"
                            placeholder="กรอกชื่อ BD" value="<?= isset($aPoData) ? $aPoData['FTPoBD'] : ''; ?>">
                    </div>
                </div>
            </div>

            <!-- ข้อมูลใบสั่งซื้อ -->
            <div class="card border rounded p-3 mt-4">
                <h5 class="text-dark">ข้อมูลใบสั่งซื้อ</h5>
                <div class="row mt-2 mx-1">
                    <div class="col-12">
                        <div class="row">
                            <!-- เลขที่ใบสั่งซื้อ -->
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-dark" for="oetPoQttNo">เลขที่ใบเสนอราคา</label>
                                <input type="text" name="oetPoQttNo" id="oetPoQttNo" class="form-control" placeholder="กรอกเลขที่ใบเสนอราคา"
                                    maxlength="50" value="<?= isset($aPoData) ? $aPoData['FTPoQttNo'] : ''; ?>">
                            </div>
                            <!-- วันที่ใบสั่งซื้อ -->
                            <div class="col-12 col-md-4 mb-3">
                                <label class="text-dark" for="odpPoQttDate">วันที่ใบเสนอราคา</label>
                                <div class="input-group">
                                    <input type="text" id="odpPoQttDate" name="odpPoQttDate" class="form-control datepicker" placeholder="dd/mm/yyyy"
                                        value="<?= (isset($aPoData) && $aPoData['FDPoQttDate'] != '') ?  date('d/m/Y', strtotime($aPoData['FDPoQttDate']))  : ''; ?>">
                                    <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- เลขที่ใบสั่งซื้อ -->
                    <div class="col-12 col-md-4 mb-3">
                        <span class="text-danger">*</span> <label class="text-dark" for="oetPoDocNo">เลขที่ใบสั่งซื้อ</label>
                        <input type="text" name="oetPoDocNo" id="oetPoDocNo" class="form-control" placeholder="กรอกเลขที่ใบสั่งซื้อ"
                            maxlength="50" value="<?= isset($aPoData) ? $aPoData['FTPoDocNo'] : ''; ?>">
                    </div>
                    <!-- วันที่ใบสั่งซื้อ -->
                    <div class="col-12 col-md-4 mb-3">
                        <span class="text-danger">*</span> <label class="text-dark" for="odpPoDate">วันที่ใบสั่งซื้อ</label>
                        <div class="input-group">
                            <input type="text" id="odpPoDate" name="odpPoDate" class="form-control datepicker" placeholder="dd/mm/yyyy" value="<?= isset($aPoData) ? date('d/m/Y', strtotime($aPoData['FDPoDate'])) : ''; ?>">
                            <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                        </div>
                    </div>
                    <!-- มูลค่าใบสั่งซื้อ -->
                    <div class="col-12 col-md-4 mb-3">
                        <span class="text-danger">*</span> <label class="text-dark" for="onbPoValue">มูลค่าใบสั่งซื้อ</label>
                        <input type="number" name="onbPoValue" id="onbPoValue" class="form-control text-end" placeholder="กรอกมูลค่าใบสั่งซื้อ"
                            min="0" value="<?= isset($aPoData) ? $aPoData['FCPoValue'] : ''; ?>">
                    </div>
                    <!-- วันที่เริ่มแผน -->
                    <div class="col-12 col-md-4 mb-3">
                        <span class="text-danger">*</span> <label class="text-dark" for="odpPoStartDate">วันที่เริ่มแผน</label>
                        <div class="input-group">
                            <input type="text" id="odpPoStartDate" name="odpPoStartDate" class="form-control" placeholder="dd/mm/yyyy" value="<?= isset($aPoData) ? date('d/m/Y', strtotime($aPoData['FDPoStartDate'])) : ''; ?>">
                            <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                        </div>
                    </div>
                    <!-- วันที่แผนเสร็จ -->
                    <div class="col-12 col-md-4 mb-3">
                        <span class="text-danger">*</span> <label class="text-dark" for="odpPoEndDate">วันที่แผนเสร็จ</label>
                        <div class="input-group">
                            <input type="text" id="odpPoEndDate" name="odpPoEndDate" class="form-control" placeholder="dd/mm/yyyy" value="<?= isset($aPoData) ? date('d/m/Y', strtotime($aPoData['FDPoEndDate'])) : ''; ?>">
                            <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                        </div>
                    </div>
                    <!-- สถานะ -->
                    <div class="col-12 col-md-4 mb-3">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="text-dark" for="ocmPoStatus">สถานะ</label>
                                <select name="ocmPoStatus" id="ocmPoStatus" class="form-control form-select" placeholder="เลือกสถานะ">
                                    <?php
                                    $aPoStatusList = [
                                        3 => 'Requirement',
                                        1 => 'Analysys & Design',
                                        2 => 'Develop',
                                        4 => 'SIT',
                                        5 => 'UAT',
                                        6 => 'Imprement',
                                        7 => 'Golive',
                                        8 => 'Cancel',
                                        9 => 'Pre-Dev/Wait PO'
                                    ];
                                    foreach ($aPoStatusList as $nIndex => $aRowPoStatus) {
                                        $bSelected = isset($aPoData) && $aPoData['FNPoStatus'] == $nIndex ? 'selected' : '';
                                    ?>
                                        <option value="<?= $nIndex; ?>" <?= $bSelected; ?>><?= $aRowPoStatus; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <!-- ความคืบหน้า -->
                            <div class="col-12 col-md-6">
                                </span> <label class="text-dark" for="onbPoProgress">ความคืบหน้า (%)</label>
                                <input type="number" name="onbPoProgress" id="onbPoProgress" class="form-control text-end"
                                    placeholder="0%" min="0" max="100" step="1" value="<?= isset($aPoData) ? $aPoData['FNPoProgress'] : '0'; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- รายละเอียด -->
                    <div class="col-12 mb-3">
                        <label class="text-dark" for="otaPoDetails">รายละเอียด</label>
                        <textarea name="otaPoDetails" id="otaPoDetails" class="form-control" rows="3"><?= isset($aPoData) ? $aPoData['FTPoDetails'] : ''; ?></textarea>
                    </div>
                    <!-- หมายเหตุ -->
                    <div class="col-12 mb-3">
                        <label class="text-dark" for="otaPoNotes">หมายเหตุ</label>
                        <textarea name="otaPoNotes" id="otaPoNotes" class="form-control" rows="3"><?= isset($aPoData) ? $aPoData['FTPoNotes'] : ''; ?></textarea>
                    </div>
                    <!-- อ้างอิงเอกสาร -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-dark" for="oetPoRefDoc">อ้างอิงเอกสาร</label>
                        <input type="text" name="oetPoRefDoc" id="oetPoRefDoc" maxlength="255" class="form-control" placeholder=""
                            value="<?= isset($aPoData) ? $aPoData['FTPoRefDoc'] : ''; ?>">
                    </div>
                    <!-- URL อ้างอิง -->
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-dark" for="oetPoRefURL">URL อ้างอิง</label>
                        <input type="text" name="oetPoRefURL" id="oetPoRefURL" class="form-control" placeholder=""
                            value="<?= isset($aPoData) ? $aPoData['FTPoRefURL'] : ''; ?>">
                    </div>
                </div>
            </div>
            <div class="card border rounded p-3 mt-4">
                <h5 class="text-dark">การชำระ</h5>
                <div class="row mt-2 mx-1">
                    <div class="col-12 mb-3">
                        <label class="text-dark" for="ocmPoPayStatus">สถานะการชำระ</label>
                        <select name="ocmPoPayStatus" id="ocmPoPayStatus" class="form-control form-select" placeholder="เลือกสถานะ">
                            <?php
                            $aPoStatusList = ['ยังไม่ชำระ', 'ชำระบางส่วน', 'ชำระครบ'];
                            foreach ($aPoStatusList as $aRowPoStatus) {
                                $bSelected = isset($aPoData) && $aPoData['FTPoPayStatus'] == $aRowPoStatus ? 'selected' : '';
                            ?>
                                <option value="<?= $aRowPoStatus; ?>" <?= $bSelected; ?>><?= $aRowPoStatus; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="text-dark" for="otaPoPayTerm">รายละเอียดการชำระ</label>
                        <textarea name="otaPoPayTerm" id="otaPoPayTerm" class="form-control" rows="3"><?= isset($aPoData) ? $aPoData['FTPoPayTerm'] : ''; ?></textarea>
                    </div>
                </div>
            </div>
            <!-- Man/Day -->
            <div class="card border rounded p-3 mt-4">
                <h5 class="text-dark h6">Man/Day</h5>
                <div class="row mt-2 mx-1">
                    <!-- Dev Tester -->
                    <div class="col-12 col-md-4 mb-3">
                        <div class="row">
                            <!-- Dev -->
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-dark" for="onbPoMDDev">MD Dev</label>
                                <input type="number" name="onbPoMDDev" id="onbPoMDDev" class="form-control text-end"
                                    min="0" value="<?= isset($aPoData['FCPoMDDev']) ? $aPoData['FCPoMDDev'] : ''; ?>">
                            </div>
                            <!-- Tester -->
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-dark" for="onbPoMDTester">MD Tester</label>
                                <input type="number" name="onbPoMDTester" id="onbPoMDTester" class="form-control text-end"
                                    min="0" value="<?= isset($aPoData['FCPoMDTester']) ? $aPoData['FCPoMDTester'] : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <!-- SA PM -->
                    <div class="col-12 col-md-4 mb-3">
                        <div class="row">
                            <!-- SA -->
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-dark" for="onbPoMDSA">MD SA</label>
                                <input type="number" name="onbPoMDSA" id="onbPoMDSA" class="form-control text-end"
                                    min="0" value="<?= isset($aPoData['FCPoMDSA']) ? $aPoData['FCPoMDSA'] : ''; ?>">
                            </div>
                            <!-- PM -->
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-dark" for="onbPoMDPM">MD PM</label>
                                <input type="number" name="onbPoMDPM" id="onbPoMDPM" class="form-control text-end"
                                    min="0" value="<?= isset($aPoData['FCPoMDPM']) ? $aPoData['FCPoMDPM'] : ''; ?>">
                            </div>
                        </div>
                    </div>
                    <!-- Interface Total -->
                    <div class="col-12 col-md-4 mb-3">
                        <div class="row">
                            <!-- Interface -->
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-dark" for="onbPoMDInterface">MD Interface</label>
                                <input type="number" name="onbPoMDInterface" id="onbPoMDInterface" class="form-control text-end"
                                    min="0" value="<?= isset($aPoData['FCPoMDInterface']) ? $aPoData['FCPoMDInterface'] : ''; ?>">
                            </div>
                            <!-- Total -->
                            <div class="col-12 col-md-6 mb-3">
                                <label class="text-dark" for="onbPoMDTotal">MD Total</label>
                                <input type="number" name="onbPoMDTotal" id="onbPoMDTotal" class="form-control text-end"
                                    min="0" value="<?= isset($aPoData['FCPoMDTotal']) ? $aPoData['FCPoMDTotal'] : ''; ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Web -->
                    <div class="col-12 col-md-4 mb-3">
                        <label class="text-dark" for="onbPoMDWeb">MD Web</label>
                        <input type="number" name="onbPoMDWeb" id="onbPoMDWeb" class="form-control text-end"
                            min="0" value="<?= isset($aPoData['FCPoMDWeb']) ? $aPoData['FCPoMDWeb'] : ''; ?>">
                    </div>
                    <!-- C# -->
                    <div class="col-12 col-md-4 mb-3">
                        <label class="text-dark" for="onbPoMDCSharp">MD C#</label>
                        <input type="number" name="onbPoMDCSharp" id="onbPoMDCSharp" class="form-control text-end"
                            min="0" value="<?= isset($aPoData['FCPoMDCSharp']) ? $aPoData['FCPoMDCSharp'] : ''; ?>">
                    </div>
                    <!-- Android -->
                    <div class="col-12 col-md-4 mb-3">
                        <label class="text-dark" for="onbPoMDAndroid">MD Android</label>
                        <input type="number" name="onbPoMDAndroid" id="onbPoMDAndroid" class="form-control text-end"
                            min="0" value="<?= isset($aPoData['FCPoMDAndroid']) ? $aPoData['FCPoMDAndroid'] : ''; ?>">
                    </div>
                </div>
            </div>

            <div class="card border rounded p-3 mt-4">
                <h6 class="text-dark">แนบไฟล์</h6>
                <div class="row mt-2 mx-1">
                    <div class="col-12 col-md-6 mb-3">
                        <label class="text-dark" for="oflPoFile">แนบไฟล์</label>
                        <input type="file" name="oflPoFile" id="oflPoFile" class="form-control" onchange="JSxPOCheckFileSize()"
                            accept=".gif, .jpg, .jpeg, .png, .pdf, .doc, .docx, .xls, .xlsx, .csv, .ppt, .pptx">
                        <?php if (isset($aPoData) && !empty($aPoData['FTPoFile'])) { ?>
                            <div id="odvPoFilePreview" class="mt-1">
                                <p>
                                    ไฟล์ที่แนบอยู่:
                                    <a href="<?= base_url($aPoData['FTPoFile']); ?>" target="_blank">
                                        <i class="fa fa-file"></i> <?= basename($aPoData['FTPoFile']); ?>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger ms-2" onclick="JSxPORemoveFile()">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </p>
                            </div>
                        <?php } ?>
                        <small class="text-muted">ประเภทไฟล์ : gif,jpg,jpeg,png,pdf,doc,docx,xls,xlsx,csv,ppt,pptx</small>
                        <br>
                        <small class="text-muted">ขนาดไม่เกิน : 5MB</small>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <a href="<?= base_url('/index.php/docPOPageListView') ?>" class="xCNCursorPointer">
                        << ย้อนกลับ
                            </a>
                </div>
                <div class="col-md-6 text-end" style="z-index:10000">
                    <button type="submit" class="btn btn-primary">บันทึก</button>
                </div>
            </div>
        </div>
    </form>
</div>