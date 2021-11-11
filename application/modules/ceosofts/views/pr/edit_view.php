<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>ใบเสนอซื้อ</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pr_id'>หมายเลขใบเสนอซื้อ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pr_id" name="pr_id" value="{record_pr_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pr_date'>วันที่ใบเสนอซื้อ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="pr_date" name="pr_date" value="{record_pr_date}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pr_sup'>ชื่อผู้จำหน่าย :</label>
				<div class='col-sm-10'>
					<select id='pr_sup' name='pr_sup' value="{record_pr_sup}">
						<option value="">- เลือก ชื่อผู้จำหน่าย -</option>
						{tb_supplier_pr_sup_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pr_project_name'>ชื่อโครงการ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pr_project_name" name="pr_project_name" value="{record_pr_project_name}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pr_status'>สถานะ :</label>
				<div class='col-sm-10'>

					<div class="form-check form-check-inline">
						<input type="radio" name="pr_status" id="pr_status1" value="1" class="form-check-input" autocomplete="off" data-record-value="{record_pr_status}" />
						<label class="form-check-label" for="pr_status1">เสนอพิจารณา</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="pr_status" id="pr_status2" value="2" class="form-check-input" autocomplete="off" data-record-value="{record_pr_status}" />
						<label class="form-check-label" for="pr_status2">รอพิจารณา</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="pr_status" id="pr_status3" value="3" class="form-check-input" autocomplete="off" data-record-value="{record_pr_status}" />
						<label class="form-check-label" for="pr_status3">อนุมัติ</label>
					</div>
					<div class="form-check form-check-inline">
						<input type="radio" name="pr_status" id="pr_status4" value="4" class="form-check-input" autocomplete="off" data-record-value="{record_pr_status}" />
						<label class="form-check-label" for="pr_status4">ไม่อนุมัติ</label>
					</div>

				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pr_status_date'>วันที่แก้ไขสถานะ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control  datepicker" id="pr_status_date" name="pr_status_date" value="{record_pr_status_date}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='pr_edit_date'>วันที่แก้ไข :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="pr_edit_date" name="pr_edit_date" value="{record_pr_edit_date}" readonly="readonly" />
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
			<input type="hidden" id="detail_ref_pr_ref" value="{encrypt_id}" />


		</form>
	</div>
	<!--card-body-->
</div>
<!--card-->
<br />
<div class="card">

	<div class="card-header bg-info">
		<h3 class="card-title">ตารางรายการ <b>tb_pr_list</b></h3>
		</h3>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table  table-bordered table-hover">
				<thead class="thead-light">
					<tr>
						<th width="20px;">#</th>
						<th>id</th>
						<th>อ้างอิงใบเสนอซื้อ</th>
						<th>หมายเลขสินค้า</th>
						<th>รายการสินค้า</th>
						<th>ราคาสินค้า</th>
						<th>หน่วยสินค้า</th>
						<th>จำนวน</th>
						<th class="text-right">ราคารวม</th>
						<th>หมายเหตุ</th>
						<th>จัดการข้อมูล</th>
					</tr>
				</thead>
				<tbody id="tbody_detail_list">
					<tr parser-repeat="[detail_list]" id="list_row_{record_number}">
						<td style="text-align:center;">[{record_number}]</td>
						<td>{detail_id}</td>
						<td>{detail_pr_ref}</td>
						<td>{detail_pr_id}</td>
						<td>{detailPrNamePrName}</td>
						<td>{detail_pr_price}</td>
						<td>{detail_pr_unit}</td>
						<td>{detail_pr_qty}</td>
						<td class="text-right">{fx_detail_total_price}</td>
						<td>{detail_pr_remark}</td>
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
				<tfoot id="tfoot_detail_list" class="thead-light">
					<tr>
						<th class="text-center" colspan="8">รวมทั้งสิ้น </th>
						<th id="fx_detail_grand_total_price" class="text-right">{fx_detail_grand_total_price}</th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
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
				<h4 class="modal-title" id="addListModalLabel">เพิ่มรายการ tb_pr_list</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body p-3">
				<form class="form-horizontal" id="formAddList" accept-charset="utf-8">
					{csrf_protection_field}
					<div class="form-group row d-none">
						<label class="col-sm-3 control-label text-right" for="pr_ref">อ้างอิงใบเสนอซื้อ :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_pr_ref" name="pr_ref" value="{detail_record_pr_ref}" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="pr_id">หมายเลขสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_pr_id" name="pr_id" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="pr_name">รายการสินค้า :</label>
						<div class="col-sm-9">
							<select id="detail_pr_name" name="pr_name" value="{detail_record_pr_name}">
								<option value="">- เลือก รายการสินค้า -</option>
								{detail_tb_product_buy_pr_name_option_list}
							</select>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="pr_price">ราคาสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_pr_price" name="pr_price" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="pr_unit">หน่วยสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_pr_unit" name="pr_unit" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="pr_qty">จำนวน :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_pr_qty" name="pr_qty" value="" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right" for="fx_detail_total_price">ราคารวม :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fx_detail_total_price" name="fx_detail_total_price" readonly="readonly" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="pr_remark">หมายเหตุ :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_pr_remark" name="pr_remark" value="" />
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