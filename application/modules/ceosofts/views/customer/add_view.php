<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ลูกค้า</strong></h3>
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
				<label class="col-sm-2 control-label" for="cus_id">หมายเลขลูกค้า :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="cus_id" name="cus_id" value="{source_cus_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#cus_id" action-param="field=cus_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="cus_name">ชื่อบริษัทลูกค้า :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="cus_name" name="cus_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="cus_contact">ชื่อผู้ติดต่อ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="cus_contact" name="cus_contact" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="cus_address">ที่อยู่ลูกค้า :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="cus_address" name="cus_address" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="cus_tel">เบอร์โทรลูกค้า :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="cus_tel" name="cus_tel" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="cus_tax">หมายเลขผู้เสียภาษี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="cus_tax" name="cus_tax" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="cus_branch">สาขา :</label>
				<div class="col-sm-10">
					<select id="cus_branch" name="cus_branch" value="">
						<option value="">- เลือก สาขา -</option>
						{tb_branch_cus_branch_option_list}
					</select>
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