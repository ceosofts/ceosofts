<!--  [ View File name : edit_view.php ] -->
	<div class="card">
		<div class="card-header bg-primary">
			<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>tb_bank</strong></h3>
		</div>
		<div class="card-body">
			<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
				{csrf_protection_field}
				<input type="hidden" name="submit_case" value="edit" />
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_id'>หมายเลขรายการ  :</label>
					<div class='col-sm-10'>

						<input type="text" class="form-control " id="bank_id" name="bank_id" value="{record_bank_id}" readonly="readonly" />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bankout_date'>วันที่  :</label>
					<div class='col-sm-10'>

						<input type="text" class="form-control  datepicker" id="bankout_date" name="bankout_date" value="{record_bankout_date}"  />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_cus_name'>ชื่อบัญชี  :</label>
					<div class='col-sm-10'>
					<select id='bank_cus_name'  name='bank_cus_name' value="{record_bank_cus_name}" >
						<option value="">- เลือก ชื่อบัญชี -</option>
						{tb_bookbank_bank_cus_name_option_list}
					</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_balance_before'>ยอดก่อนฝาก-ถอน  :</label>
					<div class='col-sm-10'>

						<input type="text" class="form-control " id="bank_balance_before" name="bank_balance_before" value="{record_bank_balance_before}"  />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_action'>ทำรายการ  :</label>
					<div class='col-sm-10'>

						<div class="form-check form-check-inline">
<input  type="radio"
									name="bank_action" id="bank_action1"
									value="1" class="form-check-input"
									autocomplete="off" data-record-value="{record_bank_action}" />
<label class="form-check-label" for="bank_action1">ฝาก</label>
</div>
<div class="form-check form-check-inline">
<input  type="radio"
									name="bank_action" id="bank_action2"
									value="2" class="form-check-input"
									autocomplete="off" data-record-value="{record_bank_action}" />
<label class="form-check-label" for="bank_action2">ถอน</label>
</div>

					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_price'>ยอดฝาก-ถอน  :</label>
					<div class='col-sm-10'>

						<input type="text" class="form-control " id="bank_price" name="bank_price" value="{record_bank_price}"  />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_balance_after'>คงเหลือ  :</label>
					<div class='col-sm-10'>

						<input type="text" class="form-control " id="bank_balance_after" name="bank_balance_after" value="{record_bank_balance_after}"  />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_remark'>หมายเหตุ  :</label>
					<div class='col-sm-10'>

						<input type="text" class="form-control " id="bank_remark" name="bank_remark" value="{record_bank_remark}"  />
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='bank_edit_by'>เพิ่มข้อมูลโดย  :</label>
					<div class='col-sm-10'>
						<input type="text" class="form-control " id="bank_edit_by" name="bank_edit_by" value="{source_bank_edit_by}" readonly="readonly" />
					</div>
				</div>
				<div class='form-group'>
					<div class='col-sm-offset-2 col-sm-10'>
						<button  type="button" class='btn btn-primary btn-lg'  data-toggle='modal' data-target='#editModal' >&nbsp;&nbsp;<i class="fa fa-save"></i> บันทึก &nbsp;&nbsp;</button>

						</div>
				</div>

				<input type="hidden" name="encrypt_id" value="{encrypt_id}" />


			</form>
		</div> <!--card-body-->
	</div> <!--card-->

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
				<form class="form-horizontal" onsubmit="return false;" >
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
