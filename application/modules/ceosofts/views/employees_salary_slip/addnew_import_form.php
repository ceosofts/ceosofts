<!-- [ View File name : addnew_import_form.php ] -->
	<div class="card">
		<div class="card-header bg-info">
			<h3 class="card-title">
				<i class="fa fa-plus-square"></i> นำเข้าข้อมูล Excel
				<strong>Employees_salary_slip</strong>
			</h3>
		</div>
		<div class="card-body">
			<form class="form-horizontal" id="formImport" accept-charset="utf-8">
				{csrf_protection_field}

					<div class="form-group row">
							<label class="col-sm-2 col-form-label">ระบุแถวที่เริ่มต้นข้อมูล  :</label>
							<div class="col-sm-1">
								<input type="number" value="{start_row}" name="start_row" class="form-control" />
							</div>
					</div>
					<div class="form-group row">
							<div class="col-sm-12 upload-box">
								<div class="hold input-group">
									<span class="btn-file"> เลือกไฟล์ Excel
										<input type="file" id="FileUpload" name="FileUpload" data-elem-preview="FileUpload_preview" data-elem-label="FileUpload_label" />
									</span><input class="form-control" id="FileUpload_label" name="FileUpload_label" 
										placeholder="กรุณาเลือกไฟล์ที่ต้องการอัพโหลด"  readonly="readonly" value="" />
								</div>
							</div>
							<div style="clear:both"></div>
					</div>
				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" id="btnReadExcel"
							class="btn btn-success btn-lg">
							&nbsp;&nbsp;<i class="fas fa-file-import"></i> แสดงข้อมูล &nbsp;&nbsp;
						</button>
					</div>
				</div>
			</form>
			<form id="frmImportList">
			<table class="table table-hover table-bordered">
				<thead class="thead-light">
					<tr>
						<th width="20px;">#</th>
					</tr>
				</thead>
				<tbody id="tbody_import_list">
				</tbody>
			</table>
			</form>
				<div class="form-group row">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="button" id="btnSaveExcel"
							class="btn btn-warning btn-lg d-none">
							&nbsp;&nbsp;<i class="fas fa-file-save"></i> บันทึกข้อมูล &nbsp;&nbsp;
						</button>
					</div>
				</div>
		</div> <!--panel-body-->
	</div> <!--panel-->
