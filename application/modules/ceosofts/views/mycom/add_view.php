<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>บริษัท / องค์กร</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_id">หมายเลขบริษัท :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="mycom_id" name="mycom_id" value="{source_mycom_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#mycom_id" action-param="field=mycom_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_name">ชื่อบริษัท :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="mycom_name" name="mycom_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_contact">ชื่อผู้ติดต่อ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="mycom_contact" name="mycom_contact" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_address">ที่อยู่ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="mycom_address" name="mycom_address" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_tel">เบอร์โทร :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="mycom_tel" name="mycom_tel" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_tax">หมายเลขผู้เสียภาษี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="mycom_tax" name="mycom_tax" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_branch">สาขา :</label>
				<div class="col-sm-10">
					<select id="mycom_branch" name="mycom_branch" value="">
						<option value="">- เลือก สาขา -</option>
						{tb_branch_mycom_branch_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_logo">โลโก้ :</label>
				<div class="col-sm-10">

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="mycom_logo" name="mycom_logo" data-elem-preview="mycom_logo_preview" data-elem-label="mycom_logo_label" />
							</span><input class="form-control" id="mycom_logo_label" name="mycom_logo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_mycom_logo_label}" />
						</div>
					</div>
					{preview_mycom_logo}
					<input type="hidden" id="mycom_logo_old_path" name="mycom_logo_old_path" value="" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="mycom_edit_date">วันที่เพิ่มข้อมูล :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control  datepicker" id="mycom_edit_date" name="mycom_edit_date" value="{record_mycom_edit_date}" readonly="readonly" />
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