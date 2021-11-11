<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>ผู้จำหน่าย</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_id'>หมายเลขผู้ผลิต :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="sup_id" name="sup_id" value="{record_sup_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_name'>ชื่อบริษัทผู้ผลิต :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="sup_name" name="sup_name" value="{record_sup_name}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_contact'>ชื่อผู้ติดต่อ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="sup_contact" name="sup_contact" value="{record_sup_contact}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_address'>ที่อยู่ผู้ผลิต :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="sup_address" name="sup_address" value="{record_sup_address}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_tel'>เบอร์โทรผู้ผลิต :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="sup_tel" name="sup_tel" value="{record_sup_tel}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_tax'>หมายเลขผู้เสียภาษี :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="sup_tax" name="sup_tax" value="{record_sup_tax}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_branch'>สาขา :</label>
				<div class='col-sm-10'>
					<select id='sup_branch' name='sup_branch' value="{record_sup_branch}">
						<option value="">- เลือก สาขา -</option>
						{tb_branch_sup_branch_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_by'>เพิ่มข้อมูลโดย :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control " id="sup_by" name="sup_by" value="{record_sup_by}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sup_date'>วันที่เพิ่มข้อมูล :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control  datepicker" id="sup_date" name="sup_date" value="{record_sup_date}" readonly="readonly" />
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