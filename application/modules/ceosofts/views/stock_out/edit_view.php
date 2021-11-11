<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>สินค้านำออก</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sto_id'>หมายเลขสินค้านำออก :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="sto_id" name="sto_id" value="{record_sto_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sto_date'>วันที่ใบสินค้านำออก :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="sto_date" name="sto_date" value="{record_sto_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sto_cus'>ชื่อลูกค้า :</label>
				<div class='col-sm-10'>
					<select id='sto_cus' name='sto_cus' value="{record_sto_cus}">
						<option value="">- เลือก ชื่อลูกค้า -</option>
						{tb_customer_sto_cus_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='sto_project_name'>ชื่อโครงการ :</label>
				<div class='col-sm-10'>
					<select id='sto_project_name' name='sto_project_name' value="{record_sto_project_name}">
						<option value="">- เลือก ชื่อโครงการ -</option>
						{tb_quotation_sto_project_name_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<div class='col-sm-offset-2 col-sm-10'>
					<button type="button" class='btn btn-primary btn-lg' data-toggle='modal' data-target='#editModal'>&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;</button>
					<button type="button" id="btnAddListDialog" class="btn btn-info btn-lg" data-toggle="modal" data-target="#addListModal" title="คลิกที่นี่เพื่อเพิ่มข้อมูลตารางรายการ">
						<i class="fa fa-arrow-circle-down"></i> เพิ่มรายการ
					</button>

				</div>
			</div>

			<input type="hidden" name="encrypt_id" value="{encrypt_id}" />
			<input type="hidden" id="detail_ref_sto_ref" value="{encrypt_id}" />


		</form>
	</div>
	<!--card-body-->
</div>
<!--card-->
<br />
<div class="card">

	<div class="card-header bg-info">
		<h3 class="card-title">ตารางรายการ <b>tb_stock_out_list</b></h3>
		</h3>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table  table-bordered table-hover">
				<thead class="thead-light">
					<tr>
						<th width="20px;">#</th>
						<th>id</th>
						<th>อ้างอิงใบส่งสินค้า</th>
						<th>หมายเลขสินค้า</th>
						<th>รายการสินค้า</th>
						<th>หน่วยสินค้า</th>
						<th>จำนวน</th>
						<th>หมายเหตุ</th>
						<th>จัดการข้อมูล</th>
					</tr>
				</thead>
				<tbody id="tbody_detail_list">
					<tr parser-repeat="[detail_list]" id="list_row_{record_number}">
						<td style="text-align:center;">[{record_number}]</td>
						<td>{detail_id}</td>
						<td>{detail_sto_ref}</td>
						<td>{detail_sto_id}</td>
						<td>{detailStoNamePrsName}</td>
						<td>{detail_sto_unit}</td>
						<td>{detail_sto_qty}</td>
						<td>{detail_sto_remark}</td>
						<td>
							<div class="btn-group pull-right">
								<button class="btn-edit-list-row my-tooltip btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไขข้อมูล" data-id="{detail_encrypt_id}" data-row-number="{record_number}" data-url-encrypt-id="{detail_url_encrypt_id}">
									<i class="fa fa-edit"></i> แก้ไข
								</button>
								<a href="javascript:void(0);" class="btn-delete-list-row my-tooltip btn btn-danger btn-sm" data-toggle="tooltip" title="ลบรายการนี้" data-id="{detail_encrypt_id}" data-row-number="{record_number}">
									<i class="fa fa-trash"></i> ลบ
								</a>
							</div>
						</td>
					</tr>
				</tbody>
			</table>

		</div>

	</div>
</div>
<br />

<!-- Modal Form Add List -->
<div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h4 class="modal-title" id="addListModalLabel">เพิ่มรายการ tb_stock_out_list</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body p-3">
				<form class="form-horizontal" id="formAddList" accept-charset="utf-8">
					{csrf_protection_field}
					<div class="form-group row d-none">
						<label class="col-sm-3 control-label text-right" for="sto_ref">อ้างอิงใบส่งสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_sto_ref" name="sto_ref" value="{detail_record_sto_ref}" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="sto_id">หมายเลขสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_sto_id" name="sto_id" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="sto_name">รายการสินค้า :</label>
						<div class="col-sm-9">
							<select id="detail_sto_name" name="sto_name" value="{detail_record_sto_name}">
								<option value="">- เลือก รายการสินค้า -</option>
								{detail_tb_product_sale_sto_name_option_list}
							</select>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="sto_unit">หน่วยสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_sto_unit" name="sto_unit" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="sto_qty">จำนวน :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_sto_qty" name="sto_qty" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="sto_remark">หมายเหตุ :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_sto_remark" name="sto_remark" value="" />
						</div>
					</div>
					<input type="hidden" id="detail_encrypt_id" name="encrypt_id" />
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fas fa-window-close"></i> Close</button>
				<button type="button" class="btn btn-primary" id="btnConfirmSaveList"><i class="fa fa-save"></i> &nbsp;บันทึกรายการ&nbsp;</button>
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
				<button type="button" class="btn btn-danger" id="btn_confirm_delete_list"><i class="fas fa-trash-alt"></i> Delete</button>
			</div>
		</div>
	</div>
</div>

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