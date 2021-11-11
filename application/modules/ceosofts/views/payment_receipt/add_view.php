<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ใบเสร็จจ่ายเงิน</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_id">หมายเลขใบเสร็จจ่ายเงิน :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="pay_rec_id" name="pay_rec_id" value="{source_pay_rec_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#pay_rec_id" action-param="field=pay_rec_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_pr_ref">อ้างอิงใบสั่งจ่าย :</label>
				<div class="col-sm-10">
					<select id="pay_rec_pr_ref" name="pay_rec_pr_ref" value="">
						<option value="">- เลือก อ้างอิงใบสั่งจ่าย -</option>
						{tb_pay_pay_rec_pr_ref_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_date">วันที่ทำเอกสารรับใบเสร็จจ่ายเงิน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="pay_rec_date" name="pay_rec_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_sup">ชื่อผู้จำหน่าย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_rec_sup" name="pay_rec_sup" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_project_name">ชื่อโครงการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_rec_project_name" name="pay_rec_project_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_price">ราคารวม :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_rec_price" name="pay_rec_price" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_pay_by">จ่ายโดย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_rec_pay_by" name="pay_rec_pay_by" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_rec_remark" name="pay_rec_remark" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_scan">สแกนเอกสาร :</label>
				<div class="col-sm-10">

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="pay_rec_scan" name="pay_rec_scan" data-elem-preview="pay_rec_scan_preview" data-elem-label="pay_rec_scan_label" />
							</span><input class="form-control" id="pay_rec_scan_label" name="pay_rec_scan_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_pay_rec_scan_label}" />
						</div>
					</div>
					{preview_pay_rec_scan}
					<input type="hidden" id="pay_rec_scan_old_path" name="pay_rec_scan_old_path" value="" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_pay_date">วันที่ได้รับเอกสาร :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="pay_rec_pay_date" name="pay_rec_pay_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_rec_by">ผู้จัดทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="pay_rec_by" name="pay_rec_by" value="{source_pay_rec_by}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" id="add_encrypt_id" />
					<button type="button" id="btnConfirmSave" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal">
						&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;
					</button>
				</div>
			</div>

		</form>
	</div>
	<!--panel-body-->
</div>
<!--panel-->
</div>
<!--contrainer-->

<!-- Modal Confirm Save -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-warning">
				<h4 class="modal-title" id="addModalLabel">บันทึกข้อมูล</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p class="alert alert-warning">ยืนยันการบันทึกข้อมูล ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i> ปิด</button>
				<button type="button" class="btn btn-primary" id="btnSave"><i class="fa fa-save"></i> บันทึก&nbsp;</button>
			</div>
		</div>
	</div>
</div>