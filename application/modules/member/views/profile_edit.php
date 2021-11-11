<style>
	#formEdit {
		max-width: 1024px;
		padding: 15px;
	}

	#formEdit .form-signin-heading,
	#formEdit .checkbox {
		margin-bottom: 10px;
	}

	#formEdit .checkbox {
		font-weight: normal;
	}

	#formEdit .form-control {
		position: relative;
		height: auto;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
		padding: 10px;
		font-size: 16px;
	}

	#formEdit .form-control:focus {
		z-index: 2;
	}

	#btnOpenSaveDialog {
		padding: 20px;
	}

	.modal-title {
		color: black;
		font-weight: bold;
	}

	#ui-datepicker-div {
		z-index: 1050 !important;
	}
</style>

<h3 class='panel-title'>แก้ไขข้อมูล <strong>สมาชิก</strong></h3>

<form id='formEdit' accept-charset='utf-8'>
	{csrf_field}
	<input type="hidden" name="encrypt_userid" value="{encrypt_userid}" />

	<div class='form-group'>
		<label class='control-label' for='photo'>ภาพประจำตัว :</label>
		<div class=''>
			{preview_photo}
			<div class="upload-box">
				<div class="hold input-group">
					<span class="btn-file"> คลิกเพื่อแนบไฟล์
						<input type="file" id="photo" name="photo" data-elem-preview="photo_preview" data-elem-label="photo_label" />
					</span><input class="form-control" id="photo_label" name="photo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_photo_label}" />
				</div>
			</div>

			<input type="hidden" id="photo_old_path" name="photo_old_path" value="{record_photo}" />
			<div style="clear:both"></div>
		</div>
	</div>

	<!-- <div class='form-group'>
		<label for='prefix'>คำนำหน้า :</label>
		<div>
			<select id='prefix' name='prefix' value="{record_prefix}">
				<option value="">- เลือก คำนำหน้า -</option>
				{tb_members_prefix_prefix_option_list}
			</select>
		</div>
	</div> -->

	<div class='form-group'>
		<label class='control-label' for='prefix'>คำนำหน้า :</label>
		<div class=''>
			<p class="alert alert-secondary">{prefixprefixName}</p>
		</div>
	</div>


	<div class='form-group'>
		<label for='firstname'>ชื่อ :</label>
		<div>
			<input type='text' class='form-control' id='firstname' name='firstname' value="{firstname}" required />

		</div>
	</div>

	<div class='form-group'>
		<label for='lastname'>นามสกุล :</label>
		<div>
			<input type='text' class='form-control' id='lastname' name='lastname' value="{lastname}" required />
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label' for='tel_number'>เบอร์โทรศัพท์ :</label>
		<div>

			<input type='text' class='form-control' id='tel_number' name='tel_number' value="{record_tel_number}">

		</div>
	</div>

	<div class='form-group'>
		<label class='control-label' for='line_id'>ไอดี Line :</label>
		<div>
			<input type='text' class='form-control' id='line_id' name='line_id' value="{record_line_id}">
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label' for='email'>อีเมล :</label>
		<div>
			<input type='text' id="show_email" class='form-control' readonly value="{email}">
		</div>
	</div>

	<div class='form-group'>
		<label class='control-label' for='level'>สิทธิ์การใช้งาน :</label>
		<div class=''>
			<p class="alert alert-secondary">{levelLevelTitle}</p>
		</div>
	</div>
	<div class='form-group'>
		<label class='control-label' for='department_id'>หน่วยงาน :</label>
		<div class=''>
			<p class="alert alert-secondary">{departmentIdDpmName}</p>
		</div>
	</div>

	<div class="form-group row">
		<div class='col-sm-3'>
			<button type="button" class='form-control btn btn-info' data-toggle='modal' data-target='#modal_change_question'>ตั้งคำถามลืมรหัสผ่าน
			</button>
		</div>

		<div class='col-sm-3'>
			<button type="button" class='form-control btn btn-warning' data-toggle='modal' data-target='#modal_change_pass'>เปลี่ยนรหัสผ่าน
			</button>
		</div>

		<div class='col-sm-3'>
			<button type="button" id="btnUnsubscribe" title="{unsubscribe_label}" class='form-control btn btn-{unsubscribe_class}' data-unsubscribe="{unsubscribe}">สถานะ : {unsubscribe_label}</button>
		</div>
	</div>

	<div class='form-group'>
		<div class='col-sm-offset-2'>
			<button type="button" id="btnOpenSaveDialog" class='btn btn-lg btn-primary' data-toggle='modal' data-target='#editModal'><i class="far fa-save"></i> บันทึกข้อมูลสมาชิก </button>
		</div>
	</div>

</form>




<!-- Modal -->
<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>

			<div class='modal-header'>
				<h4 class='modal-title' id='editModalLabel'>บันทึกข้อมูล</h4>
				<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			</div>
			<div class='modal-body'>
				<h4 class="text-primary">ยืนยันการเปลี่ยนแปลงแก้ไขข้อมูล ?</h4>
				<form class="form-horizontal" onsubmit="return false;">
					<div class="form-group">
						<div class="col-sm-12">
							<label class="col-sm-3 text-right badge badge-warning" for="edit_remark">ระบุเหตุผล :</label>
						</div>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="edit_remark">
						</div>
					</div>
				</form>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				<button type='button' class='btn btn-primary' id='btnSaveEdit'>OK</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Question -->

<div class='modal fade' id='modal_change_question' tabindex='-1' role='dialog' aria-labelledby='modal_change_question_Label' aria-hidden='true'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class='modal-header'>
				<h4 class='modal-title' id='modal_change_question_Label'>ตั้งคำถามกรณีลืมรหัสผ่าน</h4>
				<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			</div>
			<div class="modal-body">
				<form role="form" id="formChangeQuestion">
					<?php echo insert_csrf_field(); ?>

					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="question" name="question" value="{forgot_question}" placeholder="ตัวอย่างเช่น ครูสอนภาษาไทยคนแรกชื่อ?" title="ตั้งคำถาม" />
							<label for="question" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div>
					</div> <!-- /.form-group -->

					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="answer" name="answer" placeholder="ระบุคำตอบ เช่น พ่อกับแม่" title="ระบุคำตอบ" />
							<label for="answer" class="input-group-addon glyphicon glyphicon-lock"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="confirm_answer" name="confirm_answer" placeholder="ระบุคำตอบ เช่น พ่อกับแม่ " title="ยืนยันคำตอบอีกครั้ง" />
							<label for="confirm_answer" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control datepicker" id="birthday" name="birthday" value="{birthday_th}" placeholder="วันเกิด เช่น 01/01/2555" title="ระบุวันเดือนปีเกิด dd/mm/yyyy" />
							<label for="birthday" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

					<input type="hidden" name="username" value="{record_username}" />
					<input type="hidden" name="encrypt_username" value="{encrypt_username}" />
				</form>

			</div> <!-- /.modal-body -->

			<div class="modal-footer">
				<button id="btn_change_question" class="form-control btn btn-primary">บันทึก</button>

				<div class="progress">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
						<span class="sr-only">progress</span>
					</div>
				</div>
			</div> <!-- /.modal-footer -->

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- Modal Password -->
<style>
	#modal_change_pass .modal-dialog {
		width: 300px;
	}

	#modal_change_pass .modal-footer {
		height: 70px;
		margin: 0;
	}

	#modal_change_pass .modal-footer .btn {
		font-weight: bold;
	}

	#modal_change_pass .modal-footer .progress {
		display: none;
		height: 32px;
		margin: 0;
	}

	#modal_change_pass .input-group-addon {
		color: #fff;
	}

	#modal_change_pass .input-group-addon.new {
		background: #3276B1;
	}

	#modal_change_pass .input-group-addon.old {
		background: #DEDCC2;
	}
</style>

<div class='modal fade' id='modal_change_pass' tabindex='-1' role='dialog' aria-labelledby='modal_change_pass_Label' aria-hidden='true'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class='modal-header'>
				<h4 class='modal-title' id='modal_change_pass_Label'>เปลี่ยนรหัสผ่าน</h4>
				<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			</div>
			<div class="modal-body">
				<form role="form" id="formChangePass">
					<?php echo insert_csrf_field(); ?>
					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" id="resetPassword1" name="resetPassword1" placeholder="รหัสผ่านใหม่" title="รหัสผ่านใหม่ที่ต้องการ" />
							<label for="resetPassword1" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div>
					</div> <!-- /.form-group -->

					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" id="resetPassword2" name="resetPassword2" placeholder="ยืนยันรหัสผ่านใหม่อีกครั้ง" title="ยืนยันรหัสผ่านใหม่อีกครั้ง" />
							<label for="resetPassword2" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" id="uPasswordOld" name="uPasswordOld" placeholder="รหัสผ่านเดิม" title="ใส่รหัสผ่านเดิมให้ถูกต้อง เพื่อยืนยันตัวตน" />
							<label for="uPasswordOld" class="input-group-addon glyphicon glyphicon-lock"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

				</form>

			</div> <!-- /.modal-body -->

			<div class="modal-footer">
				<button id="btn_change_pass" class="form-control btn btn-primary">Ok</button>

				<div class="progress">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
						<span class="sr-only">progress</span>
					</div>
				</div>
			</div> <!-- /.modal-footer -->

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<!-- Modal Email -->
<div class='modal fade' id='modal_change_email' tabindex='-1' role='dialog' aria-labelledby='modal_change_email_Label' aria-hidden='true'>
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" id="modal_change_email_Label">เปลี่ยนอีเมล</h4>
				<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			</div> <!-- /.modal-header -->

			<div class="modal-body">
				<form role="form" id="formChangeEmail">
					<?php echo insert_csrf_field(); ?>
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" id="new_email" name="new_email" placeholder="อีเมลใหม่">
							<label for="new_email" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div>
					</div> <!-- /.form-group -->

					<div class="form-group">
						<div class="input-group">
							<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="ยืนยันรหัสผ่าน">
							<label for="confirm_password" class="input-group-addon glyphicon glyphicon-lock"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->

				</form>

			</div> <!-- /.modal-body -->

			<div class="modal-footer">
				<button id="btn_change_email" class="form-control btn btn-primary">Ok</button>

				<div class="progress">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
						<span class="sr-only">progress</span>
					</div>
				</div>
			</div> <!-- /.modal-footer -->

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>