<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>เช็คออก</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_id'>หมายเลขรายการเช็ค :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequeout_id" name="chequeout_id" value="{record_chequeout_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_make_item'>วันที่สร้างรายการ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="chequeout_make_item" name="chequeout_make_item" value="{record_chequeout_make_item}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_pay_date'>วันที่จ่ายเช็ค :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="chequeout_pay_date" name="chequeout_pay_date" value="{record_chequeout_pay_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_plan_date'>วันที่สั่งจ่าย :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="chequeout_plan_date" name="chequeout_plan_date" value="{record_chequeout_plan_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_to'>จ่ายให้ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequeout_to" name="chequeout_to" value="{record_chequeout_to}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_price'>ยอดเงิน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequeout_price" name="chequeout_price" value="{record_chequeout_price}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_bookbank'>ธนาคาร/บัญชี :</label>
				<div class='col-sm-10'>
					<select id='chequeout_bookbank' name='chequeout_bookbank' value="{record_chequeout_bookbank}">
						<option value="">- เลือก ธนาคาร/บัญชี -</option>
						{tb_bookbank_chequeout_bookbank_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_number'>หมายเลขเช็ค :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequeout_number" name="chequeout_number" value="{record_chequeout_number}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_status'>สถานะเช็ค :</label>
				<div class='col-sm-10'>
					<select id='chequeout_status' name='chequeout_status' value="{record_chequeout_status}">
						<option value="">- เลือก สถานะเช็ค -</option>
						{tb_cheque_status_chequeout_status_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_photo'>รูปเช็ค :</label>
				<div class='col-sm-10'>

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="chequeout_photo" name="chequeout_photo" data-elem-preview="chequeout_photo_preview" data-elem-label="chequeout_photo_label" />
							</span><input class="form-control" id="chequeout_photo_label" name="chequeout_photo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_chequeout_photo_label}" />
						</div>
					</div>
					{preview_chequeout_photo}
					<input type="hidden" id="chequeout_photo_old_path" name="chequeout_photo_old_path" value="{record_chequeout_photo}" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_remark'>หมายเหตุ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequeout_remark" name="chequeout_remark" value="{record_chequeout_remark}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequeout_user_make'>ผู้ทำรายการ :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control " id="chequeout_user_make" name="chequeout_user_make" value="{record_chequeout_user_make}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-offset-2 col-sm-10'>
					<button type="button" class='btn btn-primary btn-lg' data-toggle='modal' data-target='#editModal'>&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;</button>

				</div>
			</div>

			<input type="hidden" name="encrypt_id" value="{encrypt_id}" />


		</form>
	</div>
	<!--card-body-->
</div>
<!--card-->

<!-- Modal -->
<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>
			<div class='modal-header bg-warning'>
				<h4 class='modal-title' id='editModalLabel'>บันทึกข้อมูล</h4>
				<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			</div>
			<div class='modal-body'>
				<h4>ยืนยันการเปลี่ยนแปลงแก้ไขข้อมูล ?</h4>
				<form class="form-horizontal" onsubmit="return false;">
					<div class="form-group">
						<div class="col-sm-8">
							<label class="col-sm-3 text-right badge badge-warning" for="edit_remark">ระบุเหตุผล :</label>
						</div>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="edit_remark">
						</div>
					</div>
				</form>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-lg btn-default' data-dismiss='modal'><i class="fas fa-window-close"></i> ปิด</button>
				<button type='button' class='btn btn-lg btn-primary' id='btnSaveEdit'>&nbsp;<i class="fa fa-save"></i> บันทึก&nbsp;</button>
			</div>
		</div>
	</div>
</div>