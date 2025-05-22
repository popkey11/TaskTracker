<style>
	.xSEmpDeleted {
		color: red !important;
	}

	.custom-button {
		width: 70px;
		/* กำหนดความกว้างของปุ่ม */
		height: 28px;
		/* กำหนดความสูงของปุ่ม */
		background-color: #006666;
		color: #FFFFFF;
	}

.xSEmpActive {
    color: #000000 !important;
}
#odpLSUpdateDateFrom:disabled,
#odpLSUpdateDateTo:disabled {
    background-color: #f4f4f4;
}
#odpLSUpdateDateFrom:not([disabled]),
#odpLSUpdateDateTo:not([disabled]) {
    background-color: #ffffff;
}
</style>
<div class="col-md-12">

	<?php
	function JSdLEVCalculateTotalDays($dDateFrom, $dDateTo)
	{
		$dStart = new DateTime($dDateFrom);
		$dEnd = new DateTime($dDateTo);
		$dInterval = $dStart->diff($dEnd);
		return $dInterval->days + 1;
	}

	?>
	<table class="table table-sm">
		<thead>
		<tr>
			<th class="text-center">วันที่ทำรายการ</th>
			<th class="text-left">ชื่อ-สกุล</th>
			<th class="text-left">ทีม</th>
			<th class="text-left">ประเภทการลา</th>
			<th class="text-center">จากวันที่ลา</th>
			<th class="text-center">ถึงวันที่</th>
			<th class="text-center">รวมวัน</th>
			<th class="text-left">สถานะ</th>
			<!-- <th class="text-left">ดำเนินการโดย</th> -->
			<!-- <th class="text-center">รายละเอียด</th> -->
			<th class="text-center">ยกเลิก</th>
			<th class="text-center">แก้ไข</th>
			<th class="text-left"></th>
		</tr>
		</thead>
		<tbody>
		<?php
		if ($aLeaveList['rtCode'] == '200') {
			foreach ($aLeaveList["raItems"] as $key0 => $val0) {
				$tDevCode = $val0["FTLvhDevCode"];
				$FTLvhCode = $val0["FTLvhCode"];
				if ($FTLvhCode == 'DELETE') {
					$tDeleted = "xSLSDeleted";
				} else {
					$tDeleted = "xSLSActive";
				}
				?>
				<tr class="<?= $tDeleted ?>">
					<td class="text-center align-middle">
						<?= date('d/m/Y', strtotime($val0['FDLvhCreateOn'])) ?>
					</td>
					<td class="text-left align-middle"><?= $val0["FTDevName"] ?></td>
					<td class="text-left" style="vertical-align: middle;">
						<?= $val0["FTDevGrpTeam"] ?>
					</td>
					<td class="text-left align-middle"><?= $val0["FTLvtName"] ?></td>
					<td class="text-center align-middle">
						<?= date('d/m/Y', strtotime($val0['FDLvhDateFrom'])) ?>
					</td>
					<td class="text-center align-middle">
						<?= date('d/m/Y', strtotime($val0['FDLvhDateTo'])) ?>
					</td>
					<!-- <td class="text-left" style="vertical-align: middle;">
                    <?= JSdLEVCalculateTotalDays($val0['FDLvhDateFrom'], $val0['FDLvhDateTo']) ?> วัน
                </td> -->
					<td class="text-center align-middle"><?= $val0["FCLvhDayQty"] ?></td>
					<td class="text-left align-middle">
						<?php
						if ($val0["FTLvhStaApv"] == 1) {
							echo '<span class="badge text-warning" style="font-size: 14px;">รออนุมัติ</span>';
						} elseif ($val0["FTLvhStaApv"] == 2) {
							echo '<span class="badge text-success" style="font-size: 14px;">อนุมัติ</span>';
						} elseif ($val0["FTLvhStaApv"] == 3) {
							echo '<span class="badge text-danger" style="font-size: 14px;">ยกเลิก</span>';
						} elseif ($val0["FTLvhStaApv"] == 4) {
							echo '<span class="badge text-danger" style="font-size: 14px;">ไม่อนุมัติ</span>';
						} else {
							echo '<span class="badge text-secondary" style="font-size: 14px; ">สถานะไม่ทราบ</span>';
						}
						?>
					</td>

					<!-- <td class="text-left" style="vertical-align: middle;">
                    <?= $val0["FTLvhApvByName"] ?>

                </td> -->
					<?php if ($val0["FTLvhStaApv"] == 1) { ?>
						<!-- สามารถแก้ไขและยกเลิกได้ -->
						<td class="text-center align-middle">
							<img src="<?php echo base_url('/assets/cancle.png'); ?>"
								 style="margin-top:4px; width:18px;cursor:pointer"
								 onclick="JSxLEVCancleLeave('<?= $FTLvhCode ?>')">
						</td>
						<td class="text-center align-middle">
							<img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer"
								 onclick="JSxLEVOpenEditModal('<?= $val0['FTLvhCode'] ?>')">
						</td>
					<?php } elseif ($val0["FTLvhStaApv"] == 2) { ?>
						<!-- สามารถแก้ไขเท่านั้น -->
						<?php
						$currentDate = strtotime(date('Y-m-d'));
						$FDLvhDateFrom = strtotime($val0["FDLvhDateFrom"]);
						$FDLvhDateTo = strtotime($val0["FDLvhDateTo"]);
						?>
						<?php if ($currentDate >= $FDLvhDateFrom && $currentDate <= $FDLvhDateTo) { ?>
							<!-- ไม่สามารถแก้ไขเนื่องจากวันที่ปัจจุบันอยู่ระหว่าง FDLvhDateFrom และ FDLvhDateTo -->
							<td></td>
							<td class="text-center align-middle">
								<img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer"
									 onclick="JSxLEVOpenEditModal('<?= $val0['FTLvhCode'] ?>')">
							</td>
						<?php } elseif ($currentDate < $FDLvhDateFrom) { ?>
							<!-- สามารถยกเลิกเนื่องจากวันที่ปัจจุบันมากกว่า FDLvhDateFrom -->
							<td class="text-center align-middle">
								<img src="<?php echo base_url('/assets/cancle.png'); ?>"
									 style="margin-top:4px; width:18px;cursor:pointer"
									 onclick="JSxLEVCancleLeave('<?= $FTLvhCode ?>')">
							</td>
							<td class="text-center align-middle">
								<img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer"
									 onclick="JSxLEVOpenEditModal('<?= $val0['FTLvhCode'] ?>')">
							</td>
						<?php } else { ?>
							<!-- ไม่สามารถแก้ไขหรือยกเลิกเนื่องจากวันที่ปัจจุบันอยู่นอกเหนือ FDLvhDateFrom และ FDLvhDateTo -->
							<td></td>
							<td class="text-center">
								<img src="<?php echo base_url('/assets/edit.jpg'); ?>" style="width:30px;cursor:pointer"
									 onclick="JSxLEVOpenEditModal('<?= $val0['FTLvhCode'] ?>')">
							</td>
						<?php } ?>
					<?php } elseif ($val0["FTLvhStaApv"] == 3 || $val0["FTLvhStaApv"] == 4) { ?>
						<td></td>
						<td></td>

					<?php } ?>
					<td class="text-center" style="vertical-align: middle;">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal"
								data-bs-target="#odvShowHisModal<?= $key0 ?>" style="font-size: 0.9em;">
							<span style="font-size: 0.9em;">รายละเอียด</span>
						</button>
					</td>
				</tr>
				<?php
			}
		} else {
			?>
			<tr>
				<td colspan="8">ไม่พบข้อมูลการลา</td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>

		<?php } ?>


		</tbody>
	</table>
</div>
<div class="modal fade" id="odvEditModal" tabindex="-1" aria-labelledby="olaEditModal" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="olaEditModal">แก้ไขการลา</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="ofmFormUpdate">
					<input type="hidden" id="oetFTLvhCode">
					<input type="hidden" id="oetFTLvhStaApv">
					<div class="mb-3">
						<div class="row">
							<div class="col-md-6">
								<label for="ocmLSUpdateType" class="form-label"><span
										class="red-text">*</span>&nbsp;ประเภทการลา</label>
								<select class="form-control" id="ocmLSUpdateType" name="ocmLSUpdateType">
									<?php foreach ($aLeaveTypeList['raItems'] as $tType) { ?>
										<option value="<?= $tType['FTLvtCode']; ?>"
											<?php if ($val0['FTLvhType'] == $tType['FTLvtCode']) echo "selected"; ?>>
											<?= $tType['FTLvtName']; ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="oetLSUpdateDayQty" class="form-label"><span
										class="red-text">*</span>&nbsp;สถานะ</label>
								<div class="input-group">&nbsp;&nbsp;
									<b id="otaStaApv"></b>
								</div>
							</div>
						</div>
					</div>
					<div class="mb-2">
						<div class="row">
							<div class="col-md-6">
								<label for="odpLSUpdateDateFrom" class="form-label"><span
										class="red-text">*</span>&nbsp;วันที่เริ่มต้น</label>
								<div class="input-group">
									<input type="text" id="odpLSUpdateDateFrom" class="datepicker form-control"
										   value="<?php echo date('d/m/Y'); ?>" readonly>
									<span class="input-group-text bg-light"><i
											class="fa-regular fa-calendar-days"></i></span>
								</div>
							</div>
							<div class="col-md-6">
								<label for="odpLSUpdateDateTo" class="form-label"><span
										class="red-text">*</span>&nbsp;วันที่สิ้นสุด</label>
								<div class="input-group">
									<input type="text" id="odpLSUpdateDateTo" class="datepicker form-control"
										   value="<?php echo date('d/m/Y'); ?>" readonly>
									<span class="input-group-text bg-light"><i
											class="fa-regular fa-calendar-days"></i></span>
								</div>
							</div>
						</div>
					</div>

					<div class="mb-3">
						<div class="row">
							<div class="col-md-6">
								<label for="ocmLSUpdateProvince" class="form-label"><span
										class="red-text">*</span>&nbsp;จังหวัด</label>
								<select class="form-control" id="ocmLSUpdateProvince" name="ocmLSUpdateProvince">
									<?php foreach ($aLeavePvnList['raItems'] as $Pvn) { ?>
										<option value="<?= $Pvn['FTPvnCode']; ?>"
											<?php if ($val0['FTLvhPvnCode'] == $Pvn['FTPvnCode']) echo "selected"; ?>>
											<?= $Pvn['FTPvnName']; ?>
										</option>
									<?php } ?>
								</select>
							</div>
							<div class="col-md-3">
								<label for="oetLSUpdateDayQty" class="form-label"><span
										class="red-text">*</span>&nbsp;ระบุจำนวนวัน</label>
								<div class="input-group">
									<input type="text" class="form-control" value="<?php echo $val0['FCLvhDayQty']; ?>"
										   id="oetLSUpdateDayQty" name="oetLSUpdateDayQty">
									<span class="input-group-text">วัน</span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-lg-12 nopadding mb-2">
						<label for="otaLSUpdateRemark" class="form-label"><span
								class="red-text">*</span>&nbsp;เหตุผล</label>
						<textarea id="otaLSUpdateRemark" placeholder="ระบุเหตุผล" name="otaLSUpdateRemark"
								  class="form-control"></textarea>
					</div>
					<div class="mb-3">
						<label for="oflAttachment" class="form-label">ไฟล์แนบ</label>
						<input class="form-control" type="file" id="oflAttachment"
							   accept=".gif, .jpg, .jpeg, .png, .doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf">
					</div>

					<div id=odvAttachmentContainer></div>
				</form>

			</div>
			<div class="modal-footer">
				<td class="text-center" style="vertical-align: middle;">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
				</td>
				<td class="text-center" style="vertical-align: middle;">
					<button type="button" class="btn btn-primary" onclick="JSxLEVEditLeave()">บันทึก</button>
				</td>
			</div>
		</div>
	</div>
</div>

<?php
if (!empty($aLeaveList['raItems'])) {
    foreach ($aLeaveList['raItems'] as $key0 => $val0) {
?>
<div class="modal fade" id="odvShowHisModal<?= $key0 ?>" tabindex="-1" aria-labelledby="olaShowHisModal"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="olaShowHisModal">
                    รายละเอียดการลา
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mt-3 mb-3">
                    <div class="col-md-12 ml-auto "><b>วันที่ทำรายการ :
                        </b><span
                            id="odvCreateOn<?= $key0 ?>"><?php echo  date('d/m/Y', strtotime($val0["FDLvhCreateOn"])); ?></span>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-7 ml-auto"><b>ชื่อ-สกุล :
                        </b><span id="odvDevName<?= $key0 ?>"><?php echo $val0["FTDevName"]; ?></span></div>
                    <div class="col-md-5 ml-auto"><b>ทีม :
                        </b><span id="otaDevGrpTeam<?= $key0 ?>"><?php echo $val0["FTDevGrpTeam"]; ?></span></div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-md-7 ml-auto"><b>ประเภทการลา :
                        </b><span id="odvTypeName<?= $key0 ?>"><?php echo $val0["FTLvtName"]; ?></span></div>
                    <div class="col-md-5 ml-auto"><b>สถานะ : </b>
                        <?php 
                if ($val0["FTLvhStaApv"] == 1) {
                    echo '<span class="badge text-warning" style="font-size: 14px;">รออนุมัติ</span>';
                } elseif ($val0["FTLvhStaApv"] == 2) {
                    echo '<span class="badge text-success" style="font-size: 14px;">อนุมัติ</span>';
                } elseif ($val0["FTLvhStaApv"] == 3) {
                    echo '<span class="badge text-danger" style="font-size: 14px;">ยกเลิก</span>';
                } elseif ($val0["FTLvhStaApv"] == 4) {
                    echo '<span class="badge text-danger" style="font-size: 14px;">ไม่อนุมัติ</span>';
                } else {
                    echo '<span class="badge text-secondary" style="font-size: 14px;">สถานะไม่ทราบ</span>';
                }
                    ?>
                    </div>
                    <div class="row mt-3 mb-1">
                        <div class="col-md-7 ml-auto">
                            <div class="leave-date">
                                <b>วันที่ลา :</b>
                                <span
                                    id="odvDateFrom<?= $key0 ?>"><?php echo date('d/m/Y', strtotime($val0["FDLvhDateFrom"])); ?></span>
                                -
                                <span
                                    id="odvDateTo<?= $key0 ?>"><?php echo date('d/m/Y', strtotime($val0["FDLvhDateTo"])); ?></span>
                            </div>
                        </div>
                        <div class="col-md-5 ml-auto">
                            <b>&nbsp; &nbsp;จำนวน :</b>
                            <span id="otaAmount<?= $key0 ?>"><?php echo $val0["FCLvhDayQty"]; ?></span>&nbsp;วัน
                        </div>
                    </div>
                    <div class="row mt-3 mb-1">
                        <div class="col-md-7 ml-auto"><b>จังหวัด :
                            </b><span id="odvProvinceName<?= $key0 ?>"><?php echo $val0["FTPvnName"]; ?></span></div>
                    </div>
                    <div class="row mt-3 mb-3">
                        <div class="col-md-7 ml-auto"><b>ระบุเหตุผล :
                            </b><span id="otaRemark<?= $key0 ?>"><?php echo $val0["FTLvhRemark"]; ?></span></div>
                    </div>
                    <div class=" mt-3-col-md-7">
                        <b>ไฟล์แนบ : </b>
                        <?php
                                if ($val0["FTLvhAttachFile"] != null) {
                                $fileName = basename($val0["FTLvhAttachFile"]);
                                $fileUrl = base_url() . $val0["FTLvhAttachFile"];
                                echo '<a href="' . $fileUrl . '" target="_blank">' . $fileName . '</a>';
                        } else {
                                echo '<span style="color: red;">ยังไม่ได้แนบไฟล์</span>';
                        }
                            ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <?php if ($val0["FTLvhStaApv"] != 1) { ?>
                    <p><b>ดำเนินการโดย : </b><?php echo $val0["FTLvhApvByName"]; ?></p>
                    <?php if ($val0["FTLvhComment"] != '' && $val0["FTLvhComment"] != NULL) { ?>
                    <p><b>ความคิดเห็นหัวหน้างาน : </b><span
                            style="color: red;"><?php echo $val0["FTLvhComment"]; ?></span></p>
                    <?php } else { ?>
                    <p><b>ความคิดเห็นหัวหน้างาน :</b><span style="color: red;"> ไม่มีความคิดเห็น</span></p>
                    <?php } ?>
                    <?php } ?>
                </div>
                </hr>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php
    } 
} 
?>
<div class="col-md-6 ">
	พบข้อมูล <?php echo $aLeaveList["total_record"]; ?> รายการ
	แสดงหน้า <?php echo $aLeaveList["current_page"]; ?>/ <label><?php echo $aLeaveList["total_pages"]; ?></label>
	<input type="hidden" id="oetTotalPage" value="<?php echo $aLeaveList['total_pages']; ?>">
</div>
<div class="col-md-6 ">
	<nav>
		<ul class="pagination justify-content-end">
			<?php if ($aLeaveList["current_page"] == 0 or $aLeaveList["current_page"] == 1) { ?>
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
			$cPage = $aLeaveList["current_page"];
			$tPage = $aLeaveList["total_pages"];

			if ($tPage > 2 and $cPage == $tPage) {

				$ldPage = $tPage;
				$fdPage = $tPage - 3;
			} else {
				$fdPage = $cPage - 2;
				$ldPage = $cPage + 2;
			}

			for ($n = 1; $n <= $aLeaveList["total_pages"]; $n++) {
				if ($n >= $fdPage and $n <= $ldPage) {
					if ($aLeaveList["current_page"] == $n) { ?>
						<li class="page-item active" aria-current="page">
							<a class="page-link" href="#" onclick="SelectPage('<?= $n ?>')"><?= $n ?></a>
						</li>
					<?php } else { ?>
						<li class="page-item" aria-current="page">
							<a class="page-link" href="#" onclick="SelectPage('<?= $n ?>')"><?= $n ?></a>
						</li>
					<?php } ?>
				<?php } ?>
			<?php } ?>
			<li class="page-item">
				<a class="page-link" href="#" onclick="NextPage()" aria-label="Next">
					<span aria-hidden="true">&raquo;</span>
				</a>
			</li>
		</ul>
	</nav>
</div>

<script>
function JSdLEVCalculateTotalDays() {
    var startDateString = $('#odpLSUpdateDateFrom').val();
    var endDateString = $('#odpLSUpdateDateTo').val();
    var dStartDate = new Date(startDateString);
    var dEndDate = new Date(endDateString);
    var timeDiff = endDate - startDate;
    var totalDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    $('#totalDays').text(totalDays);
}

	function SelectPage(nPage) {
		$("#oetFilterLSPage").val(nPage);
		JSxLEVGetLeaveList();
	}

	function PreviousPage() {
		var cPage = $("#oetFilterLSPage").val()
		var nPage = 0;
		if (cPage > 1) {
			nPage = cPage - 1;
			$("#oetFilterLSPage").val(nPage)
			JSxLEVGetLeaveList();
		}
	}

	function NextPage() {
		var cPage = $("#oetFilterLSPage").val()
		var tPage = $("#oetTotalPage").val()
		var nPage = 0;
		if (cPage < tPage) {
			nPage = parseInt(cPage) + 1;
			$("#oetFilterLSPage").val(nPage)
			JSxLEVGetLeaveList();
		}
	}

	function JSxLEVGetLeaveList() {
		var nStatus = $("#ocmStatusSearch").val();
		var tType = $("#ocmTypeSearch").val();
		var dStartDate = $("#odpLeaveStartDate").val();
		var dEndDate = $("#odpLeaveEndDate").val();
		var nPage = $("#oetFilterLSPage").val();

		$.ajax({
			type: "POST",
			url: "<?= base_url('index.php/masLEVLeaveList') ?>",
			data: {
				"nStatus": nStatus,
				"tType": tType,
				"dStartDate": dStartDate,
				"dEndDate": dEndDate,
				"nPage": nPage
			},
			cache: false,
			timeout: 0,
			success: function (tResult) {
				$("#odvLeaveList").html(tResult);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
			}
		});
	}
</script>
<script>
	$(function () {
		var dateBefore = null;
		$(".datepicker").datepicker({
			dateFormat: 'dd/mm/yy',
			buttonImageOnly: true,
			dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],
			monthNamesShort: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
				'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
			],
			changeMonth: true,
			changeYear: true,
			onClose: function () {
				if ($(this).val() != "" && $(this).val() == dateBefore) {
					var arrayDate = dateBefore.split("-");
					arrayDate[2] = parseInt(arrayDate[2]) + 543;
					$(this).val(arrayDate[0] + "-" + arrayDate[1] + "-" + arrayDate[2]);
				}
			}
		});

});
function JSxLEVOpenEditModal(FTLvhCode) {
    $.ajax({
        type: 'POST',
        url: '<?= base_url('index.php/masLEVEventGetLeaveEmployee') ?>',
        data: {
            'FTLvhCode': FTLvhCode
        },
        success: function(data) {
            if (data) {
                var jsonData = JSON.parse(data);
                $('#oetFTLvhCode').val(FTLvhCode);  
                $('#oetFTLvhStaApv').val(jsonData.FTLvhStaApv); 
                $('#ocmLSUpdateType').val(jsonData.FTLvhType);
                $('#oetLSUpdateDayQty').val(jsonData.FCLvhDayQty);
                $('#odpLSUpdateDateFrom').val(moment(jsonData.FDLvhDateFrom).format('DD/MM/YYYY'));
                $('#odpLSUpdateDateTo').val(moment(jsonData.FDLvhDateTo).format('DD/MM/YYYY'));
                $('#otaLSUpdateRemark').val(jsonData.FTLvhRemark);
                $('#oetLSUpdateStatus').val(jsonData.FTLvhStaApv);
				$('#ocmLSUpdateProvince').val(jsonData.FTLvhPvnCode);
                $('#odpLSUpdateDateFrom, #odpLSUpdateDateTo').on('change', function() {
                    var dateFrom = moment($('#odpLSUpdateDateFrom').val(), 'DD/MM/YYYY');
                    var dateTo = moment($('#odpLSUpdateDateTo').val(), 'DD/MM/YYYY');
                    var diffInDays = dateTo.diff(dateFrom, 'days') + 1;
                    $('#oetLSUpdateDayQty').val(diffInDays);
                    if (diffInDays < 0.5) {
                        $('#oetLSUpdateDayQty').val(1);
                    }
                });
                if (jsonData.FTLvhStaApv == 1) {
                    clearModalValues();
                    $("#otaStaApv").text("รออนุมัติ");
                    $("#otaStaApv").addClass("text-warning");
                } 
                if (jsonData.FTLvhStaApv == 2) {
                    clearModalValues();
                    $("#otaStaApv").text("อนุมัติ");
                    $("#otaStaApv").addClass("text-success");
                    $('#ocmLSUpdateType').prop('readonly', true);
                    $('#ocmLSUpdateType').prop('disabled', true);
                    $('#odpLSUpdateDateFrom').prop('readonly', true);
                    $('#odpLSUpdateDateFrom').prop('disabled', true);
                    $('#odpLSUpdateDateTo').prop('readonly', true);
                    $('#odpLSUpdateDateTo').prop('disabled', true);
                    $('#ocmLSUpdateProvince').prop('readonly', true);
                    $('#ocmLSUpdateProvince').prop('disabled', true);
                    $('#oetLSUpdateDayQty').prop('readonly', true);
                    $('#otaLSUpdateRemark').prop('readonly', false);
                    $('#oflAttachment').prop('enable', false);
                }
                $('#odvAttachmentContainer').empty();
                if (jsonData.FTLvhAttachFile != null) {
                    var tAttachmentFileName = jsonData.FTLvhAttachFile.split('/').pop();
                    var tAttachmentLink = $('<a>', {
                        href: '<?= base_url(); ?>' + jsonData.FTLvhAttachFile,
                        text: tAttachmentFileName,
                        target: '_blank'
                    });
                    $('#odvAttachmentContainer').append(tAttachmentLink);
                } else {
                    var tNoAttachmentMessage = $('<p>', {
                        text: 'ยังไม่ได้แนบไฟล์',
                        style: 'color: red;'
                    });
                    $('#odvAttachmentContainer').append(tNoAttachmentMessage);
                }
                $('#odvEditModal').modal('show');               
            } else {
                console.error('ไม่พบข้อมูลสำหรับ เลขที่การลางาน : ' + FTLvhCode);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert('Error fetching data');
        }
    });
}
function JSxLEVEditLeave() {
    const oUpdateStartDateFrom = moment($('#odpLSUpdateDateFrom').val(), 'DD/MM/YYYY');
    const oUpdateEndDateTo = moment($('#odpLSUpdateDateTo').val(), 'DD/MM/YYYY');
    var FTLvhCode = $("#oetFTLvhCode").val();  
    var FTLvhStaApv = $("#oetFTLvhStaApv").val();
    var tLSUpdateType = $("#ocmLSUpdateType").val();
    var dLSUpdateDateFrom = $("#odpLSUpdateDateFrom").val();
    var dLSUpdateDateTo = $("#odpLSUpdateDateTo").val();
    var tLSUpdateProvince = $("#ocmLSUpdateProvince").val();
    var tLSUpdateRemark = $("#otaLSUpdateRemark").val();
    var cLSUpdateDayQty = $("#oetLSUpdateDayQty").val();
    var oflAttachment = $("#oflAttachment")[0].files[0];
    var ofmFormUpdate = new FormData();
    ofmFormUpdate.append('FTLvhCode', FTLvhCode);
    ofmFormUpdate.append('FTLvhStaApv', FTLvhStaApv);
    ofmFormUpdate.append('ocmLSUpdateType', tLSUpdateType);
    ofmFormUpdate.append('odpLSUpdateDateFrom', dLSUpdateDateFrom);
    ofmFormUpdate.append('odpLSUpdateDateTo', dLSUpdateDateTo);
    ofmFormUpdate.append('ocmLSUpdateProvince', tLSUpdateProvince);
    ofmFormUpdate.append('otaLSUpdateRemark', tLSUpdateRemark);
    ofmFormUpdate.append('oetLSUpdateDayQty', cLSUpdateDayQty);
    if (oflAttachment) {
        ofmFormUpdate.append('oflAttachment', oflAttachment);
    }
    if (oUpdateStartDateFrom.isValid() && oUpdateEndDateTo.isValid()) {
        if (oUpdateStartDateFrom.isAfter(oUpdateEndDateTo)) {
            alert('กรุณาระบุวันลาใหม่ โดยวันที่เริ่มต้นห้ามมากกว่าวันที่สิ้นสุด');
        } else if (oUpdateStartDateFrom <= oUpdateEndDateTo) {
            if (confirm("การแก้ไขการลางานที่เลือกใช่หรือไม่ ?")) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url('index.php/masLEVEventLeaveUpdate');?>",
                    data: ofmFormUpdate,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        console.log(response);
                        if (response === 'success') {
                            $("#odvAddModal").modal('hide');
                            $(".modal-backdrop").remove();
                            JSxLEVGetLeaveList();

                        } else {
                            alert('เกิดข้อผิดพลาดในการแก้ไขการลางาน โปรดลองใหม่อีกครั้ง');
                        }
                    },
                    error: function() {
                        alert('เกิดข้อผิดพลาดขณะแก้ไขการลางาน กรุณาติดต่อเจ้าหน้าที');
                    }
                });
            }
        }
    }
}
function clearModalValues() {
    $("#otaStaApv").removeClass("text-warning text-success");
    $('#ocmLSUpdateType').prop('readonly', false);
    $('#ocmLSUpdateType').prop('disabled', false);
    $('#odpLSUpdateDateFrom').prop('readonly', false);
    $('#odpLSUpdateDateFrom').prop('disabled', false);
    $('#odpLSUpdateDateTo').prop('readonly', false);
    $('#odpLSUpdateDateTo').prop('disabled', false);
    $('#ocmLSUpdateProvince').prop('readonly', false);
    $('#ocmLSUpdateProvince').prop('disabled', false);
    $('#oetLSUpdateDayQty').prop('readonly', false);
    $('#otaLSUpdateRemark').prop('readonly', false);
    $('#oflAttachment').prop('enable', true);
}
function JSxLEVShowHisLeave(FTLvhCode, key0) {
    var otaComment = $("#otaComment" + key0).val();
    var dCreateOn = $("#odvCreateOn" + key0).text();
    var tDevName = $("#odvDevName" + key0).text();
    var dDateFrom = $("#odvDateFrom" + key0).text();
    var dDateTo = $("#odvDateTo" + key0).text();
    var tPvnName = $("#odvProvinceName" + key0).text();
    var tDevGrpTeam = $("#otaDevGrpTeam" + key0).text();
    var tRemark = $("#otaRemark" + key0).text();
    var nStatus = $("#otaStaApv" + key0).text();
    var tComment = $("#otaComment" + key0).text();
    var tApproveByName = $("#otaApproveName" + key0).text();
    var nAmount = $("#otaAmount" + key0).text();
    var tTypeName = $("#odvTypeName" + key0).text();
}
</script>
