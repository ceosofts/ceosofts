<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>เช็คออก</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_id">หมายเลขรายการเช็ค :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="chequeout_id" name="chequeout_id" value="{source_chequeout_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#chequeout_id" action-param="field=chequeout_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_make_item">วันที่สร้างรายการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="chequeout_make_item" name="chequeout_make_item" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_pay_date">วันที่จ่ายเช็ค :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="chequeout_pay_date" name="chequeout_pay_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_plan_date">วันที่สั่งจ่าย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="chequeout_plan_date" name="chequeout_plan_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_to">จ่ายให้ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="chequeout_to" name="chequeout_to" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_price">ยอดเงิน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="chequeout_price" name="chequeout_price" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_bookbank">ธนาคาร/บัญชี :</label>
				<div class="col-sm-10">
					<select id="chequeout_bookbank" name="chequeout_bookbank" value="">
						<option value="">- เลือก ธนาคาร/บัญชี -</option>
						{tb_bookbank_chequeout_bookbank_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_number">หมายเลขเช็ค :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="chequeout_number" name="chequeout_number" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_status">สถานะเช็ค :</label>
				<div class="col-sm-10">
					<select id="chequeout_status" name="chequeout_status" value="">
						<option value="">- เลือก สถานะเช็ค -</option>
						{tb_cheque_status_chequeout_status_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_photo">รูปเช็ค :</label>
				<div class="col-sm-10">

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="chequeout_photo" name="chequeout_photo" data-elem-preview="chequeout_photo_preview" data-elem-label="chequeout_photo_label" />
							</span><input class="form-control" id="chequeout_photo_label" name="chequeout_photo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_chequeout_photo_label}" />
						</div>
					</div>
					{preview_chequeout_photo}
					<input type="hidden" id="chequeout_photo_old_path" name="chequeout_photo_old_path" value="" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="chequeout_remark" name="chequeout_remark" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="chequeout_user_make">ผู้ทำรายการ :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="chequeout_user_make" name="chequeout_user_make" value="{source_chequeout_user_make}" readonly="readonly" />
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