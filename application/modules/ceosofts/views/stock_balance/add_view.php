<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>สถานะเช็คยอดสินค้า</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="stb_id">หมายเลขเอกสารเช็คยอดสินค้า :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="stb_id" name="stb_id" value="{source_stb_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#stb_id" action-param="field=stb_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="stb_date">วันที่เช็คยอดสินค้า :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="stb_date" name="stb_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="stb_remark">หมายเหตุ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="stb_remark" name="stb_remark" value="" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" id="add_encrypt_id" name="encrypt_id" />
					<input type="hidden" id="detail_ref_stb_pr_ref" />
					<button type="button" id="btnConfirmSave" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addModal">
						&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;
					</button>
					<a id="btnGotoEdit" class="btn btn-warning btn-lg" style="display:none" href="#" title="คลิกที่นี่เพื่อแก้ไขข้อมูลหลัก">
						<i class="fa fa-edit"></i> แก้ไขข้อมูล
					</a>
					<button type="button" id="btnAddListDialog" class="btn btn-info btn-lg" style="display:none" title="คลิกที่นี่เพื่อเพิ่มข้อมูลตารางรายการ">
						<i class="fa fa-arrow-circle-down"></i> เพิ่มรายการ
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
				<th>อ้างอิงใบ stock balance</th>
				<th>หมายเลขสินค้า</th>
				<th>ชื่อสินค้า</th>
				<th>หน่วยสินค้า</th>
				<th>จำนวน</th>
				<th>สถานะ</th>
				<th>หมายเหตุ</th>
				<th>วันที่แก้ไข</th>
				<th class="text-center" style="width:200px">จัดการข้อมูล</th>
			</tr>
		</thead>
		<tbody id="tbody_detail_list">
		</tbody>
	</table>
</div>

<!-- Modal Form Add List -->
<div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h4 class="modal-title" id="addListModalLabel">เพิ่มรายการ tb_stock_balance_list</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body p-3">
				<form class="form-horizontal" id="formAddList" accept-charset="utf-8">
					{csrf_protection_field}
					<div class="form-group row d-none">
						<label class="col-sm-3 control-label text-right" for="stb_pr_ref">อ้างอิงใบ stock balance :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_stb_pr_ref" name="stb_pr_ref" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="stb_no">หมายเลขสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_stb_no" name="stb_no" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="stb_product_name">ชื่อสินค้า :</label>
						<div class="col-sm-9">
							<select id="detail_stb_product_name" name="stb_product_name">
								<option value="">- เลือก ชื่อสินค้า -</option>
								{detail_tb_product_buy_stb_product_name_option_list}
							</select>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="stb_unit">หน่วยสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_stb_unit" name="stb_unit" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="stb_qty">จำนวน :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_stb_qty" name="stb_qty" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="stb_status">สถานะ :</label>
						<div class="col-sm-9">
							<select id="detail_stb_status" name="stb_status">
								<option value="">- เลือก สถานะ -</option>
								{detail_tb_stock_balance_status_stb_status_option_list}
							</select>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="stb_remark">หมายเหตุ :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_stb_remark" name="stb_remark" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="stb_edit_date">วันที่แก้ไข :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control  datepicker" id="detail_stb_edit_date" name="stb_edit_date" value="" />
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