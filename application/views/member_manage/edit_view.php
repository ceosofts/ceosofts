<!--  [ View File name : edit_view.php ] -->
	<div class="card border-primary rounded-0">
	   <div class="card-header p-0">
		  <div class="bg-info text-white text-center py-2">
			<i class="fa fa-5x fa-edit"></i>
			 <h3>แก้ไขข้อมูล<b>ข้อมูลสมาชิก</b></h3>
		  </div>
	   </div>
	   <div class="card-body p-3">
			{master_data}	
			<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
				{csrf_field}
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='userid'>USER ID  :</label>
					<div class='col-sm-10'>
						<input type='text' readonly="readonly" class='form-control' id='userid' name='userid' value="{userid}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='username'>ชื่อผู้ใช้งาน  :</label>
					<div class='col-sm-10'>
						<input type='text' readonly="readonly" class='form-control' id='username' name='username' value="{username}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='password'>รหัสผ่าน  :</label>
					<div class='input-group'>
						<div class='col-sm-4 text-left'>
							<input type='text'  class='form-control' id='password' name='password' value="{password}" readonly />
						</div>
						<div class='col-sm-4'>
							<!--
								<div class="custom-control custom-checkbox">
								input type="checkbox" class="custom-control-input" name="reset_pass" id="chk_reset_pass">
								<label class="custom-control-label" for="chk_reset_pass">Reset รหัสผ่าน</label>
								</div>
							-->
							<button class="btn btn-warning"  data-toggle="modal" 
							data-target="#modal_reset_member_pass" type="button"><i class="fas fa-user-lock"></i>Reset Password</button>
						</div>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='prefix_name'>คำนำหน้า  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='prefix_name' name='prefix_name' value="{prefix}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='fullname'>ชื่อ  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='fullname' name='fullname' value="{fullname}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='lastname'>นามสกุล  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='lastname' name='lastname' value="{lastname}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='department_id'>หน่วยงาน  :</label>
					<div class='col-sm-10'>
						<select id='department_id' name='department_id' value="{department_id}" >
							<option value="">- เลือก หน่วยงาน -</option>
							{department_option_list}
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='level'>สิทธิ์การใช้งาน :</label>
					<div class='col-sm-10'>
						<select id='level' name='level' value="{level}" >
							<option value="">- เลือก ระดับ -</option>
							<option value="1">ผู้ใช้งานทั่วไป</option>
							<option value="9">ผู้ดูแลระบบ</option>
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='email'>อีเมล  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='email' name='email' value="{email}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='tel_number'>เบอร์โทรศัพท์  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='tel_number' name='tel_number' value="{tel_number}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='line_id'>ไอดี Line  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='line_id' name='line_id' value="{line_id}" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='void'>สถานะการใช้งาน  : <span class="{void_class}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></label>
					<div class='col-sm-10'>
						<select id='void' name='void' value="{void}">
							<option value="0">เปิดใช้งาน</option>
							<option value="1">ระงับการใช้งาน</option>
						</select>
					</div>
				</div>
				<div class='form-group'>
					<div class='col-sm-offset-2 col-sm-10'>                           
						<button  type="button" class='btn btn-primary'  data-toggle='modal' data-target='#editModal' ><span class='glyphicon glyphicon-ok'></span> บันทึก</button>                          
					</div>
				</div>
				<input type="hidden" name="encrypt_userid" value="{encrypt_userid}" />
			</form>
			{/master_data}
		</div>
	</div>


<!-- Modal -->
<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>
			<div class='modal-header'>
				<h4 class='modal-title' id='editModalLabel'>บันทึกข้อมูล</h4>
				<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			</div>
			<div class='modal-body'>
				<h4>ยืนยันการเปลี่ยนแปลงแก้ไขข้อมูล ?</h4>
				<form class="form-horizontal" onsubmit="return false;" >
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
				<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
				<button type='button' class='btn btn-primary' id='btnSaveEdit'>OK</button>
			</div>
		</div>
	</div>
</div>


<!-- Reset Member Password Modal-->
<div class="modal fade" id="modal_reset_member_pass" tabindex="-1" role="dialog" 
aria-labelledby="modal_reset_member_pass_Label" aria-hidden="true" style="display: none;">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="modal_reset_member_pass_Label">Reset รหัสผ่าน</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
				
			</div> <!-- /.modal-header -->
			
			<div class="modal-body">
				<form role="form" id="formResetMemberPass">
					<div class="form-group">
						<div class="input-group">
							<input class="form-control" id="password1" name="password1" placeholder="รหัสผ่านใหม่" type="password">
							<label for="password1" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div>
					</div> <!-- /.form-group -->
					
					<div class="form-group">
						<div class="input-group">
							<input class="form-control" id="password2" name="password2" placeholder="ยืนยันรหัสผ่านใหม่อีกครั้ง" type="password">
							<label for="password2" class="input-group-addon glyphicon glyphicon-lock new"></label>
						</div> <!-- /.input-group -->
					</div> <!-- /.form-group -->
					
					<div class="form-group">
						<div>
							<label class="col-sm-3 text-right badge badge-warning" for="edit_remark">ระบุเหตุผล :</label>
						</div>
						<div>
							<input type="text" class="form-control" id="reset_pass_remark">
						</div>
					</div>					
					
				</form>
				
			</div> <!-- /.modal-body -->
			
			<div class="modal-footer">
				<button id="btn_reset_pass" class="form-control btn btn-primary">Ok</button>
				
				<div class="progress">
					<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
						<span class="sr-only">progress</span>
					</div>
				</div>
			</div> <!-- /.modal-footer -->
			
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>