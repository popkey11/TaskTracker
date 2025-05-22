<h5 class="mx-2 text-dark"><?php echo ($tActionTitle === 'addPo') ? 'เพิ่มใบสั่งซื้อ' : 'แก้ไขใบสั่งซื้อ' ; ?></h5>
<div class="row mx-md-4 mx-sm-3 mx-0 mt-4">
    <form id="ofmPo" action="<?= $tAction ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="ohdPoCode" id="ohdPoCode" value="<?= isset($aPoData) ? $aPoData['FTPoCode'] : ''; ?>">
        <input type="hidden" id="ohdPoEvent" value="<?= isset($tActionTitle) ? $tActionTitle : ''; ?>">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card border rounded p-3">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="text-dark">ข้อมูลโครงการ</h5>
                        <div class="row mt-2 mx-1">
                            <!-- ชื่อโครงการ -->
                            <div class="mb-3">
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
                            <div class="mb-3">
                                <span class="text-danger">*</span> <label class="text-dark" for="oetPoRelease">Release</label>
                                <input type="text" name="oetPoRelease" id="oetPoRelease" class="form-control w-100" placeholder="กรอก Release"
                                    maxlength="255" value="<?= isset($aPoData) ? $aPoData['FTPoRelease'] : ''; ?>">
                            </div>
                        </div>
                        <h5 class="text-dark">ข้อมูลใบเสนอราคา</h5>
                        <div class="row mt-2 mx-1">
                            <div class="col-6">
                                <!-- เลขที่ใบสั่งซื้อ -->
                                <div class="mb-3">
                                    <label class="text-dark" for="oetPoQttNo">เลขที่ใบเสนอราคา</label>
                                    <input type="text" name="oetPoQttNo" id="oetPoQttNo" class="form-control" placeholder="กรอกเลขที่ใบเสนอราคา"
                                        maxlength="50" value="<?= isset($aPoData) ? $aPoData['FTPoQttNo'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- วันที่ใบสั่งซื้อ -->
                                <div class="mb-3">
                                    <label class="text-dark" for="odpPoQttDate">วันที่ใบเสนอราคา</label>
                                    <div class="input-group">
                                        <input type="text" id="odpPoQttDate" name="odpPoQttDate" class="form-control datepicker" placeholder="dd/mm/yyyy"
                                            value="<?= (isset($aPoData) && $aPoData['FDPoQttDate'] != '') ?  date('d/m/Y', strtotime($aPoData['FDPoQttDate']))  : ''; ?>">
                                        <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-dark">ข้อมูลใบสั่งซื้อ</h5>
                        <div class="row mt-2 mx-1">
                            <div class="col-6">
                                <!-- เลขที่ใบสั่งซื้อ -->
                                <div class="mb-3">
                                    <span class="text-danger">*</span> <label class="text-dark" for="oetPoDocNo">เลขที่ใบสั่งซื้อ</label>
                                    <input type="text" name="oetPoDocNo" id="oetPoDocNo" class="form-control" placeholder="กรอกเลขที่ใบสั่งซื้อ"
                                        maxlength="50" value="<?= isset($aPoData) ? $aPoData['FTPoDocNo'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- วันที่ใบสั่งซื้อ -->
                                <div class="mb-3">
                                    <span class="text-danger">*</span> <label class="text-dark" for="odpPoDate">วันที่ใบสั่งซื้อ</label>
                                    <div class="input-group">
                                        <input type="text" id="odpPoDate" name="odpPoDate" class="form-control datepicker" placeholder="dd/mm/yyyy" value="<?= isset($aPoData) ? date('d/m/Y', strtotime($aPoData['FDPoDate'])) : ''; ?>">
                                        <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- มูลค่าใบสั่งซื้อ -->
                                <div class="mb-3">
                                    <span class="text-danger">*</span> <label class="text-dark" for="onbPoValue">มูลค่าใบสั่งซื้อ</label>
                                    <input type="number" name="onbPoValue" id="onbPoValue" class="form-control text-end" placeholder="กรอกมูลค่าใบสั่งซื้อ"
                                        min="0" value="<?= isset($aPoData) ? $aPoData['FCPoValue'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- อ้างอิงเอกสาร -->
                                <div class="mb-3">
                                    <label class="text-dark" for="oetPoRefDoc">อ้างอิงเอกสาร</label>
                                    <input type="text" name="oetPoRefDoc" id="oetPoRefDoc" maxlength="255" class="form-control" placeholder=""
                                        value="<?= isset($aPoData) ? $aPoData['FTPoRefDoc'] : ''; ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
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
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    </span> <label class="text-dark" for="onbPoProgress">ความคืบหน้า (%)</label>
                                    <input type="number" name="onbPoProgress" id="onbPoProgress" class="form-control text-end"
                                        placeholder="0%" min="0" max="100" step="1" value="<?= isset($aPoData) ? $aPoData['FNPoProgress'] : '0'; ?>">
                                </div>
                            </div>
                        </div>
                        <h5 class="text-dark">ระยะเวลาโครงการ</h5>
                        <div class="row mt-2 mx-1">
                            <div class="col-6">
                                <!-- วันที่เริ่มแผน -->
                                <div class="mb-3">
                                    <span class="text-danger">*</span> <label class="text-dark" for="odpPoStartDate">วันที่เริ่มแผน</label>
                                    <div class="input-group">
                                        <input type="text" id="odpPoStartDate" name="odpPoStartDate" class="form-control" placeholder="dd/mm/yyyy" value="<?= isset($aPoData) ? date('d/m/Y', strtotime($aPoData['FDPoStartDate'])) : ''; ?>">
                                        <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <!-- วันที่แผนเสร็จ -->
                                <div class="mb-3">
                                    <span class="text-danger">*</span> <label class="text-dark" for="odpPoEndDate">วันที่แผนเสร็จ</label>
                                    <div class="input-group">
                                        <input type="text" id="odpPoEndDate" name="odpPoEndDate" class="form-control" placeholder="dd/mm/yyyy" value="<?= isset($aPoData) ? date('d/m/Y', strtotime($aPoData['FDPoEndDate'])) : ''; ?>">
                                        <span class="input-group-text"><i class="fa fa-calendar-o"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5 class="text-dark">ข้อมูลผู้เกี่ยวข้อง</h5>
                        <div class="row mt-2 mx-1">
                            <!-- From -->
                            <div class="col-6">
                                <div class="mb-3">
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
                            </div>

                            <!-- To -->
                            <div class="col-6">
                                <div class="mb-3">
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
                            </div>
                        </div>
                        <h5 class="text-dark">ทีมงานโครงการ</h5>
                        <div class="row mt-2 mx-1">
                            <!-- PM -->
                            <div>
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
                            <div>
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
                            <div class="mb-3">
                                <label class="text-dark" for="oetPoBD">BD</label>
                                <input type="text" name="oetPoBD" id="oetPoBD" class="form-control" maxlength="255"
                                    placeholder="กรอกชื่อ BD" value="<?= isset($aPoData) ? $aPoData['FTPoBD'] : ''; ?>">
                            </div>
                            <!-- Implementer -->
                            <div class="mb-3">
                                <label class="text-dark" for="oetPoImplementer">Implementer</label>
                                <input type="text" name="oetPoImplementer" id="oetPoImplementer" class="form-control" maxlength="255"
                                    placeholder="กรอกชื่อ Implementer" value="<?= isset($aPoData) ? $aPoData['FTPoImplementer'] : ''; ?>">
                            </div>
                            <div class="mb-3">
                                <label class="text-dark" for="ocmPoActiveStatus">สถานะการใช้งาน</label>
                                <select name="ocmPoActiveStatus" id="ocmPoActiveStatus" class="form-control form-select" data-live-search="true">
                                    <option value="1" <?= (isset($aPoData) && $aPoData['FNPoActiveStatus'] == '1') ? 'selected' : ''; ?>>Active</option>
                                    <option value="0" <?= (isset($aPoData) && $aPoData['FNPoActiveStatus'] == '0') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <!-- <h5 class="text-dark">ข้อมูลการชำระเงิน</h5>
                        <div class="row mt-2 mx-1">
                            <div class="col-6">
                                <div>
                                    <span class="text-danger">*</span> <label class="text-dark" for="ocmPoPayType">การแบ่งชำระ</label>
                                    <select name="ocmPoPayType" id="ocmPoPayType" class="form-control form-select" placeholder="เลือกสถานะ">
                                        <?php
                                        $aPoPayTypeList = ['รอชำระ', 'ยังไม่ถึงกำหนด'];
                                        foreach ($aPoPayTypeList as $aRowPoPayType) {
                                            $bSelected = isset($aPoData) && $aPoData['FTPoPayType'] == $aRowPoPayType ? 'selected' : '';
                                        ?>
                                            <option value="<?= $aRowPoPayType; ?>" <?= $bSelected; ?>><?= $aRowPoPayType; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <span class="text-danger">*</span> <label class="text-dark" for="ocmPoPayStatus">สถานะการชำระ</label>
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
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="text-dark" for="onbPoTotalPaid">ยอดชำระแล้ว (บาท)</label>
                                    <input type="number" name="onbPoTotalPaid" id="onbPoTotalPaid" class="form-control text-end" placeholder="กรอกยอดชำระแล้ว"
                                        min="0" value="<?= isset($aPoData) ? $aPoData['FCPoTotalPaid'] : '0'; ?>">
                                </div>
                            </div>
                            <div class="col-6">
                                <div>
                                    <label class="text-dark" for="onbPoTotalRemain">ยอดคงเหลือ (บาท)</label>
                                    <input type="number" name="onbPoTotalRemain" id="onbPoTotalRemain" class="form-control text-end" placeholder="กรอกยอดคงเหลือ"
                                        min="0" value="<?= isset($aPoData) ? $aPoData['FCPoTotalRemain'] : '0'; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-dark" for="otaPoPayTerm">รายละเอียดการชำระ</label>
                                <textarea name="otaPoPayTerm" id="otaPoPayTerm" class="form-control" rows="3"><?= isset($aPoData) ? $aPoData['FTPoPayTerm'] : ''; ?></textarea>
                            </div>
                        </div> -->
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