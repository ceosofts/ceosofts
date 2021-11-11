<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>Tax_receipt</strong></h3>
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
				<label class="col-sm-2 control-label" for="tar_rec_id">หมายเลขใบหักภาษี :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="tar_rec_id" name="tar_rec_id" value="{source_tar_rec_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#tar_rec_id" action-param="field=tar_rec_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_number_ref">อ้างอิงหมายเลขใบเสร็จรับเงิน :</label>
				<div class="col-sm-10">
					<select id="tar_rec_number_ref" name="tar_rec_number_ref" value="">
						<option value="">- เลือก อ้างอิงหมายเลขใบเสร็จรับเงิน -</option>
						{tb_receipt_tar_rec_number_ref_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_date">วันที่ใบหักภาษี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="tar_rec_date" name="tar_rec_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_cus">ชื่อลูกค้า :</label>
				<div class="col-sm-10">
					<select id="tar_rec_cus" name="tar_rec_cus" value="">
						<option value="">- เลือก ชื่อลูกค้า -</option>
						{tb_customer_tar_rec_cus_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_project_name">ชื่อโครงการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="tar_rec_project_name" name="tar_rec_project_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_projectprice">ยอดตามใบเสร็จรับเงิน :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="tar_rec_projectprice" name="tar_rec_projectprice" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_law">หักภาษี :</label>
				<div class="col-sm-10">
					<select id="tar_law" name="tar_law" value="">
						<option value="">- เลือก หักภาษี -</option>
						{tb_tax_receipt_percent_tar_law_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_percent">เปอร์เซ็นต์ที่หัก :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="tar_percent" name="tar_percent" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_price">ยอดหักภาษี :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="tar_rec_price" name="tar_rec_price" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_status">สถานะ :</label>
				<div class="col-sm-10">
					<select id="tar_rec_status" name="tar_rec_status" value="">
						<option value="">- เลือก สถานะ -</option>
						{tb_tax_receipt_status_tar_rec_status_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_by">ผู้จัดทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="tar_rec_by" name="tar_rec_by" value="{source_tar_rec_by}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="tar_rec_crate_date">วันที่ทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control  datepicker" id="tar_rec_crate_date" name="tar_rec_crate_date" value="{source_tar_rec_crate_date}" readonly="readonly" />
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