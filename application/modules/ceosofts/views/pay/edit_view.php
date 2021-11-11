<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>ใบสั่งจ่าย</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_id'>หมายเลขใบสั่งจ่าย :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pay_id" name="pay_id" value="{record_pay_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_pr_ref'>อ้างอิงใบสั่งซื้อ :</label>
				<div class='col-sm-10'>
					<select id='pay_pr_ref' name='pay_pr_ref' value="{record_pay_pr_ref}">
						<option value="">- เลือก อ้างอิงใบสั่งซื้อ -</option>
						{tb_pob_pay_pr_ref_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_date'>วันที่ใบสั่งจ่าย :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="pay_date" name="pay_date" value="{record_pay_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_sup'>ชื่อผู้จำหน่าย :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pay_sup" name="pay_sup" value="{record_pay_sup}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_project_name'>ชื่อโครงการ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pay_project_name" name="pay_project_name" value="{record_pay_project_name}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_price'>ราคารวม :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pay_price" name="pay_price" value="{record_pay_price}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_pay_by'>จ่ายโดย :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pay_pay_by" name="pay_pay_by" value="{record_pay_pay_by}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_remark'>หมายเหตุ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pay_remark" name="pay_remark" value="{record_pay_remark}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_pay_date'>วันที่นัดจ่าย :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="pay_pay_date" name="pay_pay_date" value="{record_pay_pay_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_edit_by'>ชื่อผู้แก้ไข :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control " id="pay_edit_by" name="pay_edit_by" value="{record_pay_edit_by}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pay_edit_date'>วันที่แก้ไข :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="pay_edit_date" name="pay_edit_date" value="{record_pay_edit_date}" readonly="readonly" />
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