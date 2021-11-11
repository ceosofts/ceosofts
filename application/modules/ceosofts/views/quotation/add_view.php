<!-- [ View File name : add_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-plus-square"></i> เพิ่มข้อมูล <strong>ใบเสนอราคา</strong></h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" id="formAdd" accept-charset="utf-8">
			{csrf_protection_field}
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quo_id">หมายเลขใบเสนอราคา :</label>
				<div class="col-sm-10">

					<div class="input-group"><input type="text" class="form-control " id="quo_id" name="quo_id" value="{source_quo_id}" readonly="readonly" /><a class="btn btn-sm btn-info" onclick-action="reload_runninng" action-element="#quo_id" action-param="field=quo_id"><i class="fas fa-sync"></i> Reload</a></div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quo_date">วันที่ใบเสนอราคา :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control  datepicker" id="quo_date" name="quo_date" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quo_cus">ชื่อลูกค้า :</label>
				<div class="col-sm-10">
					<select id="quo_cus" name="quo_cus" value="">
						<option value="">- เลือก ชื่อลูกค้า -</option>
						{tb_customer_quo_cus_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quo_project_name">ชื่อโครงการ :</label>
				<div class="col-sm-10">

					<input type="text" class="form-control " id="quo_project_name" name="quo_project_name" value="" />
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quo_status">สถานะ :</label>
				<div class="col-sm-10">
					<select id="quo_status" name="quo_status" value="">
						<option value="">- เลือก สถานะ -</option>
						{tb_quotation_status_quo_status_option_list}
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label" for="quo_by">ผู้จัดทำเอกสาร :</label>
				<div class="col-sm-10">
					<input type="text" class="form-control " id="quo_by" name="quo_by" value="{source_quo_by}" readonly="readonly" />
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" id="add_encrypt_id" name="encrypt_id" />
					<input type="hidden" id="detail_ref_quo_ref" />
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
				<th>อ้างอิงใบเสนอราคา</th>
				<th>หมายเลขสินค้า</th>
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
				<th colspan="8" class="text-right">ราคาสินค้ารวมทั้งสิ้น</th>
				<th id="fx_detail_grand_total_price" class="text-right">{fx_detail_grand_total_price}</th>
				<th></th>
			</tr>
		</tfoot>

		<!--  function ที่ controller ยังไม่สมบูรณ์ เนื่องจาก ผลรวมไม่แสดงทันที ยังต้องแก้อยู่
		<tfoot>
			<tr>
				<th colspan="8" class="text-right">ราคาสินค้ารวมทั้งสิ้น</th>
				<th class="text-right">{total_product_price}</th>
				<th></th>
			</tr>
			<tr>
				<th colspan="8" class="text-right">ภาษีมูลค่าเพิ่ม 7%</th>
				<th class="text-right">{total_vat}</th>
				<th></th>
			</tr>
			<tr>
				<th colspan="8" class="text-right">ราคาสุทธิ</th>
				<th class="text-right">{grand_total}</th>
				<th></th>
			</tr>
		</tfoot> -->

	</table>
</div>

<!-- Modal Form Add List -->
<div class="modal fade" id="addListModal" tabindex="-1" role="dialog" aria-labelledby="addListModalLabel" aria-hidden="true">
	<div class="modal-dialog  modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h4 class="modal-title" id="addListModalLabel">เพิ่มรายการ tb_quotation_list</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body p-3">
				<form class="form-horizontal" id="formAddList" accept-charset="utf-8">
					{csrf_protection_field}
					<div class="form-group row d-none">
						<label class="col-sm-3 control-label text-right" for="quo_ref">อ้างอิงใบเสนอราคา :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_quo_ref" name="quo_ref" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="quo_pro_id">หมายเลขสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_quo_pro_id" name="quo_pro_id" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="quo_pro_name">รายการสินค้า :</label>
						<div class="col-sm-9">
							<select id="detail_quo_pro_name" name="quo_pro_name">
								<option value="">- เลือก รายการสินค้า -</option>
								{detail_tb_product_sale_quo_pro_name_option_list}
							</select>
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="quo_pro_price">ราคาสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_quo_pro_price" name="quo_pro_price" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="quo_pro_unit">หน่วยสินค้า :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_quo_pro_unit" name="quo_pro_unit" value="" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="quo_pro_qty">จำนวน :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_quo_pro_qty" name="quo_pro_qty" value="" />
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 control-label text-right" for="fx_detail_total_price">ราคารวม :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" id="fx_detail_total_price" name="fx_detail_total_price" readonly="readonly" />
						</div>
					</div>
					<div class="form-group row ">
						<label class="col-sm-3 control-label text-right" for="quo_pro_remark">หมายเหตุ :</label>
						<div class="col-sm-9">
							<input type="text" class="form-control " id="detail_quo_pro_remark" name="quo_pro_remark" value="" />
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