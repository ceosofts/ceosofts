<!--  [ View File name : edit_view.php ] -->
<div class="card">
	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-edit"></i> แก้ไขข้อมูล <strong>บริษัท / องค์กร</strong></h3>
	</div>
	<div class="card-body">
		<form class='form-horizontal' id='formEdit' accept-charset='utf-8'>
			{csrf_protection_field}
			<input type="hidden" name="submit_case" value="edit" />
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_id'>หมายเลขบริษัท :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="mycom_id" name="mycom_id" value="{record_mycom_id}" readonly="readonly" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_name'>ชื่อบริษัท :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="mycom_name" name="mycom_name" value="{record_mycom_name}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_contact'>ชื่อผู้ติดต่อ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="mycom_contact" name="mycom_contact" value="{record_mycom_contact}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_address'>ที่อยู่ :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="mycom_address" name="mycom_address" value="{record_mycom_address}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_tel'>เบอร์โทร :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="mycom_tel" name="mycom_tel" value="{record_mycom_tel}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_tax'>หมายเลขผู้เสียภาษี :</label>
				<div class='col-sm-10'>

					<input type="text" class="form-control " id="mycom_tax" name="mycom_tax" value="{record_mycom_tax}" />
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_branch'>สาขา :</label>
				<div class='col-sm-10'>
					<select id='mycom_branch' name='mycom_branch' value="{record_mycom_branch}">
						<option value="">- เลือก สาขา -</option>
						{tb_branch_mycom_branch_option_list}
					</select>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_logo'>โลโก้ :</label>
				<div class='col-sm-10'>

					<div class="upload-box">
						<div class="hold input-group">
							<span class="btn-file"> คลิกเพื่อแนบไฟล์
								<input type="file" id="mycom_logo" name="mycom_logo" data-elem-preview="mycom_logo_preview" data-elem-label="mycom_logo_label" />
							</span><input class="form-control" id="mycom_logo_label" name="mycom_logo_label" placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด" readonly="readonly" value="{record_mycom_logo_label}" />
						</div>
					</div>
					{preview_mycom_logo}
					<input type="hidden" id="mycom_logo_old_path" name="mycom_logo_old_path" value="{record_mycom_logo}" />
					<div style="clear:both"></div>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='mycom_edit_date'>วันที่แก้ไข :</label>
				<div class='col-sm-10'>
					<input type="text" class="form-control" id="mycom_edit_date" name="mycom_edit_date" value="{record_mycom_edit_date}" readonly="readonly" />
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