<div class="row mx-md-4 mx-sm-3 mx-0 mt-4">
    <div class="col-md-12">
        <h5 class="mx-2 text-dark">การประมาณการ</h5>
        <hr class="text-dark">
        <form id="ofmPoManday" action="<?= site_url('docPOEventEditManday') ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="ohdPoCodeMD" id="ohdPoCodeMD" value="<?= isset($aPoData) ? $aPoData['FTPoCode'] : ''; ?>">
            <div class="row">
                <div class="col-6">
                    <h5 class="mx-2 text-dark">การประมาณการทรัพยากร</h5>
                    <div class="col-12 mx-4">
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD Dev</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDDev" name="onbPoMDDev" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDDev'],2) : ''; ?>" onkeyup="JSxPOCalTotalManday()">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD Tester</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDTester" name="onbPoMDTester" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDTester'],2) : ''; ?>" onkeyup="JSxPOCalTotalManday()">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD SA</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDSA" name="onbPoMDSA" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDSA'],2) : ''; ?>" onkeyup="JSxPOCalTotalManday()">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD PM</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDPM" name="onbPoMDPM" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDPM'],2) : ''; ?>" onkeyup="JSxPOCalTotalManday()">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD Interface</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDInterface" name="onbPoMDInterface" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDInterface'],2) : ''; ?>" onkeyup="JSxPOCalTotalManday()">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <strong class="text-dark">MD Total</strong>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDTotal" name="onbPoMDTotal" class="form-control text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDTotal'],2) : ''; ?>" readonly>
                            </div>
                            <div class="col">
                                <strong class="text-dark">วัน</strong>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <h5 class="mx-2 text-dark">การประมาณการตามเทคโนโลยี</h5>
                    <div class="col-12 mx-4">
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD Web</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDWeb" name="onbPoMDWeb" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDWeb'],2) : ''; ?>">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD C#</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDCSharp" name="onbPoMDCSharp" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDCSharp'],2) : ''; ?>">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                        <div class="row mb-1">
                            <div class="col">
                                <span class="text-dark">MD Android</span>
                            </div>
                            <div class="col">
                                <input type="number" id="onbPoMDAndroid" name="onbPoMDAndroid" class="form-control form-input text-end" value="<?= isset($aPoData) ? number_format($aPoData['FCPoMDAndroid'],2) : ''; ?>">
                            </div>
                            <div class="col">
                                <span class="text-dark">วัน</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="text-dark">
            <div class="row">
                <div class="col">
                    <a href="<?= base_url('/index.php/docPOPageListView') ?>" class="xCNCursorPointer"><< ย้อนกลับ</a>
                </div>
                <div class="col-md-6 text-end" style="z-index:10000">
                    <button type="submit" class="btn btn-primary" id="obtMDSubmit">บันทึก</button>
                </div>
            </div>
        </form>
    </div>
</div>