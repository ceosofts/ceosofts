<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>tb_tax_receipt</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_id'>หมายเลขใบหักภาษี :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="tar_rec_id" name="tar_rec_id" value="{record_tar_rec_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_number_ref'>อ้างอิงหมายเลขใบเสร็จรับเงิน :</label>
				<div class='col-sm-10'>
					<select id='tar_rec_number_ref' name='tar_rec_number_ref' value="{record_tar_rec_number_ref}">
						<option value="">- เลือก อ้างอิงหมายเลขใบเสร็จรับเงิน -</option>
						{tb_receipt_tar_rec_number_ref_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_date'>วันที่ใบหักภาษี :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="tar_rec_date" name="tar_rec_date" value="{record_tar_rec_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_cus'>ชื่อลูกค้า :</label>
				<div class='col-sm-10'>
					<select id='tar_rec_cus' name='tar_rec_cus' value="{record_tar_rec_cus}">
						<option value="">- เลือก ชื่อลูกค้า -</option>
						{tb_customer_tar_rec_cus_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_project_name'>ชื่อโครงการ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="tar_rec_project_name" name="tar_rec_project_name" value="{record_tar_rec_project_name}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_projectprice'>ยอดตามใบเสร็จรับเงิน :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="tar_rec_projectprice" name="tar_rec_projectprice" value="{record_tar_rec_projectprice}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_law'>หักภาษี :</label>
				<div class='col-sm-10'>
					<select id='tar_law' name='tar_law' value="{record_tar_law}">
						<option value="">- เลือก หักภาษี -</option>
						{tb_tax_receipt_percent_tar_law_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_percent'>เปอร์เซ็นต์ที่หัก :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="tar_percent" name="tar_percent" value="{record_tar_percent}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_price'>ยอดหักภาษี :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="tar_rec_price" name="tar_rec_price" value="{record_tar_rec_price}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_status'>สถานะ :</label>
				<div class='col-sm-10'>
					<select id='tar_rec_status' name='tar_rec_status' value="{record_tar_rec_status}">
						<option value="">- เลือก สถานะ -</option>
						{tb_tax_receipt_status_tar_rec_status_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tar_rec_edit_by'>ชื่อผู้แก้ไข :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control " id="tar_rec_edit_by" name="tar_rec_edit_by" value="{source_tar_rec_edit_by}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='tax_rec_edit_date'>วันที่แก้ไข :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control  datepicker" id="tax_rec_edit_date" name="tax_rec_edit_date" value="{source_tax_rec_edit_date}" readonly="readonly" />
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