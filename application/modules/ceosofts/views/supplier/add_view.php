<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ผู้จำหน่าย</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_id">หมายเลขผู้ผลิต :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="sup_id" name="sup_id" value="{source_sup_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#sup_id" action-param="field=sup_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_name">ชื่อบริษัทผู้ผลิต :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="sup_name" name="sup_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_contact">ชื่อผู้ติดต่อ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="sup_contact" name="sup_contact" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_address">ที่อยู่ผู้ผลิต :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="sup_address" name="sup_address" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_tel">เบอร์โทรผู้ผลิต :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="sup_tel" name="sup_tel" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_tax">หมายเลขผู้เสียภาษี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="sup_tax" name="sup_tax" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_branch">สาขา :</label>
				<div class="col-sm-10">
					<select id="sup_branch" name="sup_branch" value="">
						<option value="">- เลือก สาขา -</option>
						{tb_branch_sup_branch_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_by">เพิ่มข้อมูลโดย :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="sup_by" name="sup_by" value="{source_sup_by}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="sup_date">วันที่เพิ่มข้อมูล :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control  datepicker" id="sup_date" name="sup_date" value="{source_sup_date}" readonly="readonly" />
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