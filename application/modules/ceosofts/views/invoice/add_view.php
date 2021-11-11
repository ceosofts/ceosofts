<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ใบวางบิล</strong></h3>
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
				<label class="col-sm-2 control-label" for="inv_id">หมายเลขใบวางบิล :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="inv_id" name="inv_id" value="{source_inv_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#inv_id" action-param="field=inv_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_quo_number_ref">อ้างอิงหมายเลขใบเสนอราคา :</label>
				<div class="col-sm-10">
					<select id="inv_quo_number_ref" name="inv_quo_number_ref" value="">
						<option value="">- เลือก อ้างอิงหมายเลขใบเสนอราคา -</option>
						{tb_quotation_inv_quo_number_ref_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_date">วันที่ใบวางบิล :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="inv_date" name="inv_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_cus">ชื่อลูกค้า :</label>
				<div class="col-sm-10">
					<select id="inv_cus" name="inv_cus" value="">
						<option value="">- เลือก ชื่อลูกค้า -</option>
						{tb_customer_inv_cus_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_project_name">ชื่อโครงการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="inv_project_name" name="inv_project_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_price">ราคาตามใบเสนอราคา :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="inv_price" name="inv_price" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_price_this_period">ยอดวางบิลงวดนี้ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="inv_price_this_period" name="inv_price_this_period" value="{fx_detail_grand_total_price}" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_status">สถานะ :</label>
				<div class="col-sm-10">
					<select id="inv_status" name="inv_status" value="">
						<option value="">- เลือก สถานะ -</option>
						{tb_invoice_status_inv_status_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_pay_date">วันที่นัดจ่าย :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="inv_pay_date" name="inv_pay_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_by">ผู้จัดทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="inv_by" name="inv_by" value="{source_inv_by}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="inv_create_date">วันที่ทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control  datepicker" id="inv_create_date" name="inv_create_date" value="{source_inv_create_date}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" id="add_encrypt_id" name="encrypt_id" />
					<input type="hidden" id="detail_ref_inv_ref" />
					<button type="button" id="btnConfirmSave" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal">
						&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;
					</button>
					<a id="btnGotoEdit" class="btn btn-warning btn-lg" style="display:none" href="#" title="คลิกที่นี่เพื่อแก้ไขข้อมูลหลัก">
						<i class="fa fa-edit"></i> แก้ไขข้อมูล
					</a>
					<button type="button" id="btnAddListDialog" class="btn btn-info btn-lg" style="display:none" title="คลิกที่นี่เพื่อเพิ่มข้อมูลตารางรายการ">
						<i class="fa fa-arrow-circle-down"></i> เพิ่มรายการ
					</button>
					<button type="button" id="btnImportListDialog" class="btn btn-success btn-lg" style="display:none" title="คลิกที่นี่เพื่อนำเข้าข้อมูลรายการด้วย Excel">
						<i class="fas fa-file-excel"></i> นำเข้า Excel
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
<div class="table-responsive">
	<table class="table table-hover table-bordered">
		<thead class="thead-light">
			<tr>
				<th width="20px;">#</th>
				<th>id</th>
				<th>อ้างอิงใบวางบิล</th>
				<th>รายการสินค้า</th>
				<th>ราคาสินค้า</th>
				<th>หน่วยสินค้า</th>
				<th>จำนวน</th>
				<th class="text-right">ราคารวม</th>
				<th>หมายเหตุ</th>
				<th class="text-center" style="width:200px">จัดการข้อมูล</th>
			</tr>
		</thead>
		<tbody id="tbody_detail_list">
		</tbody>
		<tfoot id="tfoot_detail_list" class="thead-light">
			<tr>
				<th class="text-center" colspan="7">รวมทั้งสิ้น </th>
				<th id="fx_detail_grand_total_price" class="text-right">{fx_detail_grand_total_price}</th>
				<th></th>
				<th></th>
			</tr>
		</tfoot>
	</table>
</div>

<!-- Modal Form Add List -->
<div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h4 class="modal-title" id="addListModalLabel">เพิ่มรายการ รายละเอียดใบวางบิล</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body p-3">
				<form class="form-horizontal" id="formAddList" accept-charset="utf-8">
					{csrf_protection_field}
					<div class="form-group row d-none">
						<label class="col-sm-3 control-label text-right" for="inv_ref">อ้างอิงใบวางบิล :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_inv_ref" name="inv_ref" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="inv_pro_name">รายการสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_inv_pro_name" name="inv_pro_name" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="inv_pro_price">ราคาสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_inv_pro_price" name="inv_pro_price" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="inv_pro_unit">หน่วยสินค้า :</label>
						<div class="col-sm-9">
							<select id="detail_inv_pro_unit" name="inv_pro_unit">
								<option value="">- เลือก หน่วยสินค้า -</option>
								{detail_tb_unit_inv_pro_unit_option_list}
							</select>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="inv_pro_qty">จำนวน :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_inv_pro_qty" name="inv_pro_qty" value="" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right" for="fx_detail_total_price">ราคารวม :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fx_detail_total_price" name="fx_detail_total_price" readonly="readonly" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="inv_pro_remark">หมายเหตุ :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_inv_pro_remark" name="inv_pro_remark" value="" />
						</div>
					</div>
					<input type="hidden" id="detail_encrypt_id" name="encrypt_id" />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
				<button type="button" class="btn btn-primary" id="btnConfirmSaveList"><i class="fa fa-save"></i>&nbsp;บันทึกข้อมูล&nbsp;</button>
			</div>
		</div>
	</div>
</div>


<!-- Modal Delete -->
<div class="modal fade" id="confirmDelListModal" tabindex="-1" role="dialog" aria-labelledby="confirmDelListModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg-danger">
				<h4 class="modal-title" id="confirmDelModalListLabel">ยืนยันการลบข้อมูล</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">
				<h4 class="text-center">*** ท่านต้องการลบข้อมูลแถวที่ <span id="xrow"></span> ??? ***</h4>
				<div id="div_del_list_detail"></div>
				<form id="formDeleteList">
					<div class="form-group">
						<div class="col-sm-8">
							<label class="col-sm-3 text-right badge badge-warning" for="edit_remark">ระบุเหตุผล :</label>
						</div>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="delete_remark">
						</div>
					</div>
					<input type="hidden" id="detail_del_encrypt_id" name="encrypt_id" />

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
				<button type="button" class="btn btn-danger" id="btn_confirm_delete_list">Delete</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Import Detail -->
<div class="modal fade" id="addImportListModal" tabindex="-1" role="dialog" aria-labelledby="addImportListModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-xl">
		<div class="modal-content">
			<div class="modal-header bg-success">
				<h4 class="modal-title" id="addImportListModalLabel">นำเข้าข้อมูลรายการด้วย Excel</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">
				<style>
					.modal-lg {
						max-width: 85%;
					}
				</style>

				<form class="form-horizontal" id="formImportDetail" accept-charset="utf-8">
					{csrf_protection_field}

					<div class="form-group row">
						<label class="col-sm-2 col-form-label">ระบุแถวที่เริ่มต้น :</label>
						<div class="col-sm-1">
							<input type="text" value="{input_start_row_detail}" name="start_row_detail" class="form-control" />
						</div>
					</div>
					<div class="form-group row">
						<div class="col-sm-12 upload-box">
							<div class="hold input-group">
								<span class="btn-file"> เลือกไฟล์ Excel
									<input type="file" id="FileUploadDetail" name="FileUploadDetail" data-elem-preview="FileUploadDetail_preview" data-elem-label="FileUploadDetail_label" />
								</span><input class="form-control" id="FileUploadDetail_label" name="FileUploadDetail_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="" />
							</div>
						</div>
						<div style="clear:both"></div>
					</div>
					<div class="form-group row">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="button" id="btnReadExcelDetail" class="btn btn-success btn-lg">
								&nbsp;&nbsp;<i class="fas fa-file-import"></i> แสดงข้อมูล &nbsp;&nbsp;
							</button>
						</div>
					</div>
				</form>
				<form id="frmImportListDetail">
					<table class="table table-hover table-bordered">
						<thead class="thead-light">
							<tr>
								<th width="20px;">#</th>
							</tr>
						</thead>
						<tbody id="tbody_import_list_detail">
						</tbody>
					</table>
					<input id="import_detail_inv_ref" name="import_detail_inv_ref" value="{detail_record_inv_ref}" type="hidden" />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
				<button type="button" class="btn btn-warning" id="btnSaveExcelDetail"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
			</div>
		</div>
	</div>
</div>