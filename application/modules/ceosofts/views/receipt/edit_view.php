<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>ใบเสร็จรับเงิน</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_id'>หมายเลขใบเสร็จรับเงิน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="rec_id" name="rec_id" value="{record_rec_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_inv_number_ref'>อ้างอิงหมายเลขใบวางบิล :</label>
				<div class='col-sm-10'>
					<select id='rec_inv_number_ref' name='rec_inv_number_ref' value="{record_rec_inv_number_ref}">
						<option value="">- เลือก อ้างอิงหมายเลขใบวางบิล -</option>
						{tb_invoice_rec_inv_number_ref_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_date'>วันที่ใบเสร็จรับเงิน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="rec_date" name="rec_date" value="{record_rec_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_cus'>ชื่อลูกค้า :</label>
				<div class='col-sm-10'>
					<select id='rec_cus' name='rec_cus' value="{record_rec_cus}">
						<option value="">- เลือก ชื่อลูกค้า -</option>
						{tb_customer_rec_cus_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_project_name'>ชื่อโครงการ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="rec_project_name" name="rec_project_name" value="{record_rec_project_name}" />
				</div>
			</div>

			<!-- <div class='form-group'>
					<label class='col-sm-2 control-label' for='rec_price'>ยอดตามใบวางบิล  :</label>
					<div class='col-sm-10'>

						<input type="text" class="form-control " id="rec_price" name="rec_price" value="{record_rec_price}"  />
					</div>
				</div> -->

			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_price'>ยอดตามใบวางบิล :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="rec_price" name="rec_price" value="{record_rec_price}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='total_vat'>ภาษีมูลค่าเพิ่ม 7% :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="total_vat" name="total_vat" value="{total_vat}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='grand_total'>ยอดสุทธิ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="grand_total" name="grand_total" value="{grand_total}" />
				</div>
			</div>


			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_status'>สถานะ :</label>
				<div class='col-sm-10'>
					<select id='rec_status' name='rec_status' value="{record_rec_status}">
						<option value="">- เลือก สถานะ -</option>
						{tb_receipt_status_rec_status_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_edit_by'>ชื่อผู้แก้ไข :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control " id="rec_edit_by" name="rec_edit_by" value="{source_rec_edit_by}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='rec_edit_date'>วันที่แก้ไข :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control  datepicker" id="rec_edit_date" name="rec_edit_date" value="{source_rec_edit_date}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-offset-2 col-sm-10'>
					<button type="button" class='btn btn-primary btn-lg' data-toggle='modal' data-target='#editModal'>&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;</button>

				</div>
			</div>

			<input type="hidden" name="encrypt_id" value="{encrypt_id}" />


		</form>
	</div>
	<!--card-body-->
</div>
<!--card-->

<!-- Modal -->
<div class='modal fade' id='editModal' tabindex='-1' role='dialog' aria-labelledby='editModalLabel' aria-hidden='true'>
	<div class='modal-dialog' role='document'>
		<div class='modal-content'>
			<div class='modal-header bg-warning'>
				<h4 class='modal-title' id='editModalLabel'>บันทึกข้อมูล</h4>
				<button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>&times;</span><span class='sr-only'>Close</span></button>
			</div>
			<div class='modal-body'>
				<h4>ยืนยันการเปลี่ยนแปลงแก้ไขข้อมูล ?</h4>
				<form class="form-horizontal" onsubmit="return false;">
					<div class="form-group">
						<div class="col-sm-8">
							<label class="col-sm-3 text-right badge badge-warning" for="edit_remark">ระบุเหตุผล :</label>
						</div>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="edit_remark">
						</div>
					</div>
				</form>
			</div>
			<div class='modal-footer'>
				<button type='button' class='btn btn-lg btn-default' data-dismiss='modal'><i class="fas fa-window-close"></i> ปิด</button>
				<button type='button' class='btn btn-lg btn-primary' id='btnSaveEdit'>&nbsp;<i class="fa fa-save"></i> บันทึก&nbsp;</button>
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
					<input id="import_detail_" name="import_detail_" value="{detail_record_}" type="hidden" />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
				<button type="button" class="btn btn-warning" id="btnSaveExcelDetail"><i class="fa fa-save"></i> บันทึกข้อมูล</button>
			</div>
		</div>
	</div>
</div>