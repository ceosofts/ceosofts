<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>สมุดบัญชีเงินฝาก</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_id">หมายเลขสมุดบัญชี :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="bank_id" name="bank_id" value="{source_bank_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#bank_id" action-param="field=bank_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_cus_name">ชื่อบัญชี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_cus_name" name="bank_cus_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_name">ชื่อธนาคาร :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_name" name="bank_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_branch">สาขา :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_branch" name="bank_branch" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_number">หมายเลขบัญชี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_number" name="bank_number" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_by">เพิ่มข้อมูล :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="bank_by" name="bank_by" value="{source_bank_by}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_date">วันที่ทำรายการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="bank_date" name="bank_date" value="" readonly="readonly" />
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