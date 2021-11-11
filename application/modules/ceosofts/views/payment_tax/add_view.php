<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ใบหักภาษี</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_id">หมายเลขรับใบหักภาษี :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="pay_tax_id" name="pay_tax_id" value="{source_pay_tax_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#pay_tax_id" action-param="field=pay_tax_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_pay_ref">อ้างอิงใบสั่งจ่าย :</label>
				<div class="col-sm-10">
					<select id="pay_tax_pay_ref" name="pay_tax_pay_ref" value="">
						<option value="">- เลือก อ้างอิงใบสั่งจ่าย -</option>
						{tb_pay_pay_tax_pay_ref_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_date">วันที่ทำเอกสารรับใบหักภาษี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="pay_tax_date" name="pay_tax_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_sup">ชื่อผู้จำหน่าย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_tax_sup" name="pay_tax_sup" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_project_name">ชื่อโครงการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_tax_project_name" name="pay_tax_project_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_price">ราคารวม :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_tax_price" name="pay_tax_price" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_pay_by">จ่ายโดย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_tax_pay_by" name="pay_tax_pay_by" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_tax_remark" name="pay_tax_remark" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_scan">สแกนเอกสาร :</label>
				<div class="col-sm-10">

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="pay_tax_scan" name="pay_tax_scan" data-elem-preview="pay_tax_scan_preview" data-elem-label="pay_tax_scan_label" />
							</span><input class="form-control" id="pay_tax_scan_label" name="pay_tax_scan_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_pay_tax_scan_label}" />
						</div>
					</div>
					{preview_pay_tax_scan}
					<input type="hidden" id="pay_tax_scan_old_path" name="pay_tax_scan_old_path" value="" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_pay_date">วันที่ได้รับเอกสาร :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="pay_tax_pay_date" name="pay_tax_pay_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_tax_by">ผู้จัดทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="pay_tax_by" name="pay_tax_by" value="{source_pay_tax_by}" readonly="readonly" />
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