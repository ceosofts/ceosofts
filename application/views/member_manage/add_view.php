<!-- [ View File name : add_view.php ] -->
<div class="card border-primary rounded-0">
   <div class="card-header p-0">
	  <div class="bg-info text-white text-center py-2">
		<i class="fa fa-5x fa-edit"></i>
		 <h3>เพิ่มข้อมูล<b>ข้อมูลสมาชิก</b></h3>
	  </div>
   </div>

		<div class="card-body p-3">
			<form class="form-horizontal" id="formAdd" accept-charset="utf-8">  
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="username">ชื่อล็อกอิน  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="username" name="username" >						
					</div>
				</div>
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="password">รหัสผ่าน  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="password" name="password" >                            
					</div>
				</div>
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="prefix_name">คำนำหน้า  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="prefix_name" name="prefix_name" >                            
					</div>
				</div>
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="fullname">ชื่อ  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="fullname" name="fullname" >                            
					</div>
				</div>
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="lastname">นามสกุล  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="lastname" name="lastname" >
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='department_id'>หน่วยงาน  :</label>
					<div class='col-sm-10'>
					   <select id='department_id' name='department_id' value="{department_id}" >
						  <option value="">- เลือก หน่วยงาน -</option>
						  {{department_option_list}}
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
				 
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="email">อีเมล  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="email" name="email" >                            
					</div>
				</div>
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="tel_number">เบอร์โทรศัพท์  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="tel_number" name="tel_number" >                            
					</div>
				</div>
				<div class="form-group">           
					<label class="col-sm-2 control-label" for="line_id">ไอดี Line  :</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" id="line_id" name="line_id" >                            
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" id="btnConfirmSave" class="btn btn-primary btn-lg"  data-toggle="modal" data-target="#addModal" ><i class="fa fa-save"></i> บันทึก</button>
					</div>
				</div>
			</form>
		</div> <!--panel-body-->
	</div> <!--panel-->
</div> <!--contrainer-->

<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="addModalLabel">บันทึกข้อมูล</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<p class="alert alert-warning">ยืนยันการบันทึกข้อมูล ?</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" id="btnSave">&nbsp;OK&nbsp;</button>
			</div>
		</div>
	</div>
</div>
