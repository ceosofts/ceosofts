<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ใบเสร็จรับเงิน</strong></h3>
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
				<label class="col-sm-2 control-label" for="rec_id">หมายเลขใบเสร็จรับเงิน :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="rec_id" name="rec_id" value="{source_rec_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#rec_id" action-param="field=rec_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_inv_number_ref">อ้างอิงหมายเลขใบวางบิล :</label>
				<div class="col-sm-10">
					<select id="rec_inv_number_ref" name="rec_inv_number_ref" value="">
						<option value="">- เลือก อ้างอิงหมายเลขใบวางบิล -</option>
						{tb_invoice_rec_inv_number_ref_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_date">วันที่ใบเสร็จรับเงิน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="rec_date" name="rec_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_cus">ชื่อลูกค้า :</label>
				<div class="col-sm-10">
					<select id="rec_cus" name="rec_cus" value="">
						<option value="">- เลือก ชื่อลูกค้า -</option>
						{tb_customer_rec_cus_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_project_name">ชื่อโครงการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="rec_project_name" name="rec_project_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_price">ยอดตามใบวางบิล :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="rec_price" name="rec_price" value="" />
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_status">สถานะ :</label>
				<div class="col-sm-10">
					<select id="rec_status" name="rec_status" value="">
						<option value="">- เลือก สถานะ -</option>
						{tb_receipt_status_rec_status_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_by">ผู้จัดทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="rec_by" name="rec_by" value="{source_rec_by}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="rec_create_date">วันที่ทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control  datepicker" id="rec_create_date" name="rec_create_date" value="{source_rec_create_date}" readonly="readonly" />
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