<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>สลิปเงินเดือนพนักงาน</strong></h3>
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
				<label class="col-sm-2 control-label" for="Slip_id">หมายเลขสลิป :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="Slip_id" name="Slip_id" value="{source_Slip_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#Slip_id" action-param="field=Slip_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_id">หมายเลขพนักงาน :</label>
				<div class="col-sm-10">
					<select id="slip_ems_id" name="slip_ems_id" value="">
						<option value="">- เลือก หมายเลขพนักงาน -</option>
						{tb_employees_salary_slip_ems_id_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_fname">ชื่อพนักงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_fname" name="slip_ems_fname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_lname">นามสกุลพนักงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_lname" name="slip_ems_lname" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_salary">เงินเดือน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_salary" name="slip_ems_salary" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_ot">เงินล่วงเวลา :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_ot" name="slip_ems_ot" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_advance">หักเบิกล่วงหน้า :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_advance" name="slip_ems_advance" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_ss">หักประกันสังคม :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_ss" name="slip_ems_ss" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_absent">หักวันขาดงาน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_absent" name="slip_ems_absent" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_tax">หักภาษี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_tax" name="slip_tax" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_net">ยอดสุทธิ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_net" name="slip_net" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="slip_ems_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="slip_ems_remark" name="slip_ems_remark" value="" />
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