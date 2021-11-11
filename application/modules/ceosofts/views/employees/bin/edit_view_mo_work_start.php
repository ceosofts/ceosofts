<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>พนักงาน</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_id'>หมายเลขพนักงาน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_id" name="emp_id" value="{record_emp_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_title_name'>คำนำหน้าชื่อ :</label>
				<div class='col-sm-10'>
					<select id='emp_title_name' name='emp_title_name' value="{record_emp_title_name}">
						<option value="">- เลือก คำนำหน้าชื่อ -</option>
						{tb_members_prefix_emp_title_name_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_fname'>ชื่อพนักงาน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_fname" name="emp_fname" value="{record_emp_fname}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_lname'>นามสกุลพนักงาน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_lname" name="emp_lname" value="{record_emp_lname}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emd_id_card'>เลขบัตรประชาชน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emd_id_card" name="emd_id_card" value="{record_emd_id_card}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_photo'>รูปพนักงาน :</label>
				<div class='col-sm-10'>

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="emp_photo" name="emp_photo" data-elem-preview="emp_photo_preview" data-elem-label="emp_photo_label" />
							</span><input class="form-control" id="emp_photo_label" name="emp_photo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_emp_photo_label}" />
						</div>
					</div>
					{preview_emp_photo}
					<input type="hidden" id="emp_photo_old_path" name="emp_photo_old_path" value="{record_emp_photo}" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_sex'>เพศ :</label>
				<div class='col-sm-10'>

					<div class="form-check form-check-inline">
						<input type="radio" name="emp_sex" id="emp_sex1" value="1" class="form-check-input" autocomplete="off" data-record-value="{record_emp_sex}" />
						<label class="form-check-label" for="emp_sex1">ชาย</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="emp_sex" id="emp_sex2" value="2" class="form-check-input" autocomplete="off" data-record-value="{record_emp_sex}" />
						<label class="form-check-label" for="emp_sex2">หญิง</label>
					</div>

				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_birthday'>วันที่เกิด :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="emp_birthday" name="emp_birthday" value="{record_emp_birthday}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_age'>อายุ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_age" name="emp_age" value="{record_emp_age}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_position'>ตำแหน่งพนักงาน :</label>
				<div class='col-sm-10'>
					<select id='emp_position' name='emp_position' value="{record_emp_position}">
						<option value="">- เลือก ตำแหน่งพนักงาน -</option>
						{tb_position_emp_position_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_section'>แผนกพนักงาน :</label>
				<div class='col-sm-10'>
					<select id='emp_section' name='emp_section' value="{record_emp_section}">
						<option value="">- เลือก แผนกพนักงาน -</option>
						{tb_department_emp_section_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_tel'>เบอร์โทรศัพท์ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_tel" name="emp_tel" value="{record_emp_tel}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_start'>วันที่เริ่มงาน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="emp_start" name="emp_start" value="{record_emp_start}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_time'>อายุงาน :<span id="display_year_experience"></span></label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_time" name="emp_time" value="{record_emp_time}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_end'>วันที่ลาออก :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="emp_end" name="emp_end" value="{record_emp_end}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_holiday_max'>จำนวนวันลาพักร้อน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_holiday_max" name="emp_holiday_max" value="{record_emp_holiday_max}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_holiday_off'>จำนวนวันที่ลาพักร้อนแล้ว :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_holiday_off" name="emp_holiday_off" value="{record_emp_holiday_off}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_dayoff_day'>จำนวนวันหยุด :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_dayoff_day" name="emp_dayoff_day" value="{record_emp_dayoff_day}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='emp_dayoff_off'>จำนวนวันที่หยุดแล้ว :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="emp_dayoff_off" name="emp_dayoff_off" value="{record_emp_dayoff_off}" />
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