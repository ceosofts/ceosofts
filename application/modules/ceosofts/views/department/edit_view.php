<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>แผนก / ฝ่าย / สังกัด</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='dpm_number'>หมายเลขแผนก :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="dpm_number" name="dpm_number" value="{record_dpm_number}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='dpm_name'>แผนก :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="dpm_name" name="dpm_name" value="{record_dpm_name}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='dpm_void'>สถานะ :</label>
				<div class='col-sm-10'>

					<div class="form-check form-check-inline">
						<input type="radio" name="dpm_void" id="dpm_void0" value="0" class="form-check-input" autocomplete="off" data-record-value="{record_dpm_void}" />
						<label class="form-check-label" for="dpm_void0">ใช้ได้</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="dpm_void" id="dpm_void1" value="1" class="form-check-input" autocomplete="off" data-record-value="{record_dpm_void}" />
						<label class="form-check-label" for="dpm_void1">ยกเลิก</label>
					</div>

				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-offset-2 col-sm-10'>
					<button type="button" class='btn btn-primary btn-lg' data-toggle='modal' data-target='#editModal'>&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;</button>

				</div>
			</div>

			<input type="hidden" name="encrypt_dpm_id" value="{encrypt_dpm_id}" />


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