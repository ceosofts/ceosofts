<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>เช็คเข้า</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_id'>หมายเลขรายการเช็ค :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequein_id" name="chequein_id" value="{record_chequein_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_make_item'>วันที่สร้างรายการ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="chequein_make_item" name="chequein_make_item" value="{record_chequein_make_item}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_receive_date'>วันที่รับเช็ค :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="chequein_receive_date" name="chequein_receive_date" value="{record_chequein_receive_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_plan_date'>วันที่สั่งจ่าย :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="chequein_plan_date" name="chequein_plan_date" value="{record_chequein_plan_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_from'>รับจาก :</label>
				<div class='col-sm-10'>
					<select id='chequein_from' name='chequein_from' value="{record_chequein_from}">
						<option value="">- เลือก รับจาก -</option>
						{tb_customer_chequein_from_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_price'>ยอดเงิน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequein_price" name="chequein_price" value="{record_chequein_price}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_bookbank'>ธนาคาร/บัญชี :</label>
				<div class='col-sm-10'>
					<select id='chequein_bookbank' name='chequein_bookbank' value="{record_chequein_bookbank}">
						<option value="">- เลือก ธนาคาร/บัญชี -</option>
						{tb_bookbank_chequein_bookbank_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_number'>หมายเลขเช็ค :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequein_number" name="chequein_number" value="{record_chequein_number}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_status'>สถานะเช็ค :</label>
				<div class='col-sm-10'>
					<select id='chequein_status' name='chequein_status' value="{record_chequein_status}">
						<option value="">- เลือก สถานะเช็ค -</option>
						{tb_cheque_status_chequein_status_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_photo'>รูปเช็ค :</label>
				<div class='col-sm-10'>

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="chequein_photo" name="chequein_photo" data-elem-preview="chequein_photo_preview" data-elem-label="chequein_photo_label" />
							</span><input class="form-control" id="chequein_photo_label" name="chequein_photo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_chequein_photo_label}" />
						</div>
					</div>
					{preview_chequein_photo}
					<input type="hidden" id="chequein_photo_old_path" name="chequein_photo_old_path" value="{record_chequein_photo}" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_remark'>หมายเหตุ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="chequein_remark" name="chequein_remark" value="{record_chequein_remark}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='chequein_user_make'>ผู้ทำรายการ :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control " id="chequein_user_make" name="chequein_user_make" value="{record_chequein_user_make}" readonly="readonly" />
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