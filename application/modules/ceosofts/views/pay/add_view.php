<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ใบสั่งจ่าย</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_id">หมายเลขใบสั่งจ่าย :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="pay_id" name="pay_id" value="{source_pay_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#pay_id" action-param="field=pay_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_pr_ref">อ้างอิงใบสั่งซื้อ :</label>
				<div class="col-sm-10">
					<select id="pay_pr_ref" name="pay_pr_ref" value="">
						<option value="">- เลือก อ้างอิงใบสั่งซื้อ -</option>
						{tb_pob_pay_pr_ref_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_date">วันที่ใบสั่งจ่าย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="pay_date" name="pay_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_sup">ชื่อผู้จำหน่าย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_sup" name="pay_sup" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_project_name">ชื่อโครงการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_project_name" name="pay_project_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_price">ราคารวม :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_price" name="pay_price" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_pay_by">จ่ายโดย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_pay_by" name="pay_pay_by" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="pay_remark" name="pay_remark" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_pay_date">วันที่นัดจ่าย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="pay_pay_date" name="pay_pay_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="pay_by">ผู้จัดทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="pay_by" name="pay_by" value="{source_pay_by}" readonly="readonly" />
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