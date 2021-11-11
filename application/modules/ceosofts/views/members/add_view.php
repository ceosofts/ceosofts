<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ผู้ใช้งานโปรแกรม</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="user_id">หมายเลขผู้ใช้ :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="user_id" name="user_id" value="{source_user_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#user_id" action-param="field=user_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="username">ชื่อผู้ใช้งาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="username" name="username" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="password">รหัสผ่าน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="password" name="password" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="referral_code">รหัสยืนยันสมาชิก :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="referral_code" name="referral_code" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="email">อีเมล :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="email" name="email" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="prefix">คำนำหน้า :</label>
				<div class="col-sm-10">
					<select id="prefix" name="prefix" value="">
						<option value="">- เลือก คำนำหน้า -</option>
						{tb_members_prefix_prefix_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="firstname">ชื่อ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="firstname" name="firstname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="lastname">นามสกุล :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="lastname" name="lastname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="photo">ภาพประจำตัว :</label>
				<div class="col-sm-10">

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="photo" name="photo" data-elem-preview="photo_preview" data-elem-label="photo_label" />
							</span><input class="form-control" id="photo_label" name="photo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_photo_label}" />
						</div>
					</div>
					{preview_photo}
					<input type="hidden" id="photo_old_path" name="photo_old_path" value="" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sex">เพศ :</label>
				<div class="col-sm-10">

					<div class="form-check form-check-inline">
						<input type="radio" name="sex" id="sex1" value="1" class="form-check-input" autocomplete="off" />
						<label class="form-check-label" for="sex1">ชาย</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="sex" id="sex2" value="2" class="form-check-input" autocomplete="off" />
						<label class="form-check-label" for="sex2">หญิง</label>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tel_number">เบอร์โทรศัพท์ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="tel_number" name="tel_number" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="line_id">ไอดี Line :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="line_id" name="line_id" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="level">สิทธิ์การใช้งาน :</label>
				<div class="col-sm-10">
					<select id="level" name="level" value="">
						<option value="">- เลือก สิทธิ์การใช้งาน -</option>
						{tb_members_level_level_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="department_id">แผนก/ฝ่าย :</label>
				<div class="col-sm-10">
					<select id="department_id" name="department_id" value="">
						<option value="">- เลือก แผนก/ฝ่าย -</option>
						{tb_department_department_id_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="unsubscribe">การรับข่าวสาร :</label>
				<div class="col-sm-10">

					<div class="form-check form-check-inline">
						<input type="radio" name="unsubscribe" id="unsubscribe1" value="1" class="form-check-input" autocomplete="off" />
						<label class="form-check-label" for="unsubscribe1">รับข่าวสาร</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="unsubscribe" id="unsubscribe2" value="2" class="form-check-input" autocomplete="off" />
						<label class="form-check-label" for="unsubscribe2">ไม่รับข่าวสาร</label>
					</div>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="void">สถานะการใช้งาน :</label>
				<div class="col-sm-10">
					<select id="void" name="void" value="">
						<option value="">- เลือก สถานะการใช้งาน -</option>
						{tb_status_void_option_list}
					</select>
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