<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>เงินเดือนพนักงาน</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='ems_id'>หมายเลขพนักงาน :</label>
				<div class='col-sm-10'>
					<select id='ems_id' name='ems_id' value="{record_ems_id}">
						<option value="">- เลือก หมายเลขพนักงาน -</option>
						{tb_employees_ems_id_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='ems_fname'>ชื่อพนักงาน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="ems_fname" name="ems_fname" value="{record_ems_fname}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='ems_lname'>นามสกุลพนักงาน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="ems_lname" name="ems_lname" value="{record_ems_lname}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='ems_salary'>เงินเดือน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="ems_salary" name="ems_salary" value="{record_ems_salary}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='ems_remark'>หมายเหตุ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="ems_remark" name="ems_remark" value="{record_ems_remark}" />
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