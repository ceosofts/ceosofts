<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>เงินเดือนพนักงาน</strong></h3>
	</div>
	<div class="card-body">
		<div class="col-sm-12 col-md-12">
			<div class="pull-right text-right">
				<a href="{page_url}/import_excel_form" target="_blank" class="btn btn-success btn-lg" data-toggle="tooltip" title="นำเข้าข้อมูล">
					<i class="fas fa-file-excel"></i></span> นำเข้า Excel
				</a>
			</div>
		</div>

		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="ems_id">หมายเลขพนักงาน :</label>
				<div class="col-sm-10">
					<select id="ems_id" name="ems_id" value="">
						<option value="">- เลือก หมายเลขพนักงาน -</option>
						{tb_employees_ems_id_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="ems_fname">ชื่อพนักงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="ems_fname" name="ems_fname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="ems_lname">นามสกุลพนักงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="ems_lname" name="ems_lname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="ems_salary">เงินเดือน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="ems_salary" name="ems_salary" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="ems_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="ems_remark" name="ems_remark" value="" />
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