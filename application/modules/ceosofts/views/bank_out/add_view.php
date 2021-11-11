<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>เงินจ่ายออก</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_id">หมายเลขรายการ :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="bank_out_id" name="bank_out_id" value="{source_bank_out_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#bank_out_id" action-param="field=bank_out_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_date">วันที่ทำการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="bank_out_date" name="bank_out_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_name">ชื่อบัญชี :</label>
				<div class="col-sm-10">
					<select id="bank_out_name" name="bank_out_name" value="">
						<option value="">- เลือก ชื่อบัญชี -</option>
						{tb_bookbank_bank_out_name_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_balance_before">ยอดก่อนถอน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_out_balance_before" name="bank_out_balance_before" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_price">ยอดทำรายการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_out_price" name="bank_out_price" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_balance_after">คงเหลือ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_out_balance_after" name="bank_out_balance_after" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="bank_out_remark" name="bank_out_remark" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="bank_out_edit_by">เพิ่มข้อมูลโดย :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="bank_out_edit_by" name="bank_out_edit_by" value="{source_bank_out_edit_by}" readonly="readonly" />
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