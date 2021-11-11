<!--  [ View File name : edit_view.php ] -->
	<div class="card border-primary rounded-0">
	   <div class="card-header p-0">
		  <div class="bg-info text-white text-center py-2">
			<i class="fa fa-5x fa-edit"></i>
			 <h3>แก้ไขข้อมูล<b>ข้อมูลสมาชิก</b></h3>
		  </div>
	   </div>
	   <div class="card-body p-3">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>  
				{csrf_field}
				<input type="hidden" name="encrypt_userid" value="{encrypt_userid}" />
			
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='username'>ชื่อผู้ใช้งาน  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='username' name='username' value="{record_username}" readonly />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='fullname'>ชื่อ  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='fullname' name='fullname' value="{record_fullname}" readonly />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='lastname'>นามสกุล  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='lastname' name='lastname' value="{record_lastname}" readonly />
					</div>        
				</div>					
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='level'>สิทธิ์การใช้งาน  :</label>
						<div class='col-sm-10'>
						<p class="alert alert-secondary">{record_level}</p>
						</div>        
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='department_id'>หน่วยงาน  :</label>
					<div class='col-sm-10'>
						<p class="alert alert-secondary">{record_department_name}</p>
					</div>        
				</div>					
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='email'>อีเมล  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='email' name='email' value="{record_email}" >
					</div>        
					</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='tel_number'>เบอร์โทรศัพท์  :</label>
					<div class='col-sm-10'>

						<input type='text'  class='form-control' id='tel_number' name='tel_number' value="{record_tel_number}" >

					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='line_id'>ไอดี Line  :</label>
					<div class='col-sm-10'>
						<input type='text'  class='form-control' id='line_id' name='line_id' value="{record_line_id}" >
					</div>        
				</div>

				<div class='form-group'>
				   <div class='col-sm-offset-2 col-sm-10'>                           
						<button  type="button" class='btn btn-primary'  data-toggle='modal' data-target='#editModal' ><span class='glyphicon glyphicon-ok'></span> บันทึก</button>                          
					</div>
				</div>
			
        </form>     
    </div> <!--panel-body-->
 </div> <!--panel-->


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