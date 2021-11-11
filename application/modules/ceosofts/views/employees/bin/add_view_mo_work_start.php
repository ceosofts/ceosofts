<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>พนักงาน</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_id">หมายเลขพนักงาน :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="emp_id" name="emp_id" value="{source_emp_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#emp_id" action-param="field=emp_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_title_name">คำนำหน้าชื่อ :</label>
				<div class="col-sm-10">
					<select id="emp_title_name" name="emp_title_name" value="">
						<option value="">- เลือก คำนำหน้าชื่อ -</option>
						{tb_members_prefix_emp_title_name_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_fname">ชื่อพนักงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_fname" name="emp_fname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_lname">นามสกุลพนักงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_lname" name="emp_lname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emd_id_card">เลขบัตรประชาชน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emd_id_card" name="emd_id_card" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_photo">รูปพนักงาน :</label>
				<div class="col-sm-10">

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="emp_photo" name="emp_photo" data-elem-preview="emp_photo_preview" data-elem-label="emp_photo_label" />
							</span><input class="form-control" id="emp_photo_label" name="emp_photo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_emp_photo_label}" />
						</div>
					</div>
					{preview_emp_photo}
					<input type="hidden" id="emp_photo_old_path" name="emp_photo_old_path" value="" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_sex">เพศ :</label>
				<div class="col-sm-10">

					<div class="form-check form-check-inline">
						<input type="radio" name="emp_sex" id="emp_sex1" value="1" class="form-check-input" autocomplete="off" />
						<label class="form-check-label" for="emp_sex1">ชาย</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="emp_sex" id="emp_sex2" value="2" class="form-check-input" autocomplete="off" />
						<label class="form-check-label" for="emp_sex2">หญิง</label>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_birthday">วันที่เกิด :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="emp_birthday" name="emp_birthday" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_age">อายุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_age" name="emp_age" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_position">ตำแหน่งพนักงาน :</label>
				<div class="col-sm-10">
					<select id="emp_position" name="emp_position" value="">
						<option value="">- เลือก ตำแหน่งพนักงาน -</option>
						{tb_position_emp_position_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_section">แผนกพนักงาน :</label>
				<div class="col-sm-10">
					<select id="emp_section" name="emp_section" value="">
						<option value="">- เลือก แผนกพนักงาน -</option>
						{tb_department_emp_section_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_tel">เบอร์โทรศัพท์ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_tel" name="emp_tel" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_start">วันที่เริ่มงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="emp_start" name="emp_start" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_time">อายุงาน :<span id="display_year_experience"></span></label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_time" name="emp_time" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_end">วันที่ลาออก :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="emp_end" name="emp_end" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_holiday_max">จำนวนวันลาพักร้อน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_holiday_max" name="emp_holiday_max" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_holiday_off">จำนวนวันที่ลาพักร้อนแล้ว :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_holiday_off" name="emp_holiday_off" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_dayoff_day">จำนวนวันหยุด :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_dayoff_day" name="emp_dayoff_day" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="emp_dayoff_off">จำนวนวันที่หยุดแล้ว :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="emp_dayoff_off" name="emp_dayoff_off" value="" />
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