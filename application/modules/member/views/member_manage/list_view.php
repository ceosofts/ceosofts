<!-- [ View File name : list_view.php ] -->
<div class="card border-primary rounded-0">
	<div class="card-header p-0">
		<div class="bg-info text-white text-center py-2">
			<i class="fa fa-5x fa-users-cog"></i>
			<h3>จัดการข้อมูล<b>ข้อมูลสมาชิก</b></h3>
		</div>
	</div>
	<div class="card-body p-3">
		<div class="row">
			<div class="col-sm-12 col-md-12 mb-3">
				<div class="pull-right text-right">
					<a href="{page_url}/add" class="btn btn-success btn-lg" data-toggle="tooltip" title="เพิ่มข้อมูลใหม่">
						<i class="fa fa-plus-square"></i></span> เพิ่มผู้ใช้ใหม่
					</a>
				</div>
			</div>
			<div class="col-sm-12 col-md-9">
				<form class="form-inline well well-sm" name="formSearch" method="post" action="{page_url}/search">
					{csrf_protection}
					<a href="{page_url}" class="btn btn-info">ทั้งหมด</a>
					<div class="form-group">
						<select class="form-control" name="search_field" class="span2">
							<option value="">- ค้นหา -</option>
							<option value="userid">userid</option>
							<option value="firstname">ชื่อ</option>
							<option value="lastname">นามสกุล</option>
						</select>
					</div>
					<div class="form-group">
						<input type="text" class="form-control col" id="txtSearch" name="txtSearch" value="{txt_search}">
					</div>
					<input type="hidden" value="{order_by}" name="order_by" />
					<button type="submit" name="submit" class="btn btn-info">
						<span class="glyphicon glyphicon-search"></span> ค้นหา
					</button>
				</form>
			</div>
			<div class="col-sm-12 col-md-3">
				<div class="pull-right text-right">
					<div class="form-group">
						<select class="form-control" id="set_order_by" class="span2" value="{order_by}">
							<option value="">- จัดเรียงตาม -</option>
							<option value="userid|asc">userid น้อย - มาก</option>
							<option value="userid|desc">userid มาก - น้อย</option>
							<option value="prefix|asc">คำนำหน้า ก - ฮ</option>
							<option value="prefix|desc">คำนำหน้า ฮ - ก</option>
							<option value="firstname|asc">ชื่อ ก - ฮ</option>
							<option value="firstname|desc">ชื่อ ฮ - ก</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row dataTables_wrapper">
		<div class="col-sm-12 col-md-5">
			<div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
				แสดงรายการที่ <span class="badge badge-default">{start_row}</span> ถึง <b>{end_row}</b> จากทั้งหมด <span class="badge badge-info"> {search_row}</span> รายการ
			</div>
		</div>
		<div class="col-sm-12 col-md-7">
			<div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
				{pagination_link}
			</div>
		</div>
	</div>

	<table class="table table-striped table-hover">
		<thead class="info">
			<tr>
				<th width="20px;">#</th>
				<th>ID</th>
				<th>รูปประจำตัว</th>
				<th>ชื่อผู้ใช้งาน</th>
				<th>ชื่อ นามสกุล</th>
				<th>สิทธิ์การใช้งาน</th>
				<th>ชื่อหน่วยงาน</th>
				<th class="text-center" style="width:200px">จัดการข้อมูล</th>
			</tr>
		</thead>
		<tbody>
			{recData}
			<tr id="row_{record_number}">
				<td style="text-align:center;">[{record_number}]</td>
				<td>{userid}</td>
				<td><img src="{base_url}{show_photo}" width="50" /></td>
				<td>{username}</td>
				<td>{prefix_text} {firstname} {lastname}</td>
				<td>{level_text}</td>
				<td>{departmentIdDepartmentName}</td>
				<td>
					<div class="btn-group pull-right">
						<a href="{page_url}/preview/{url_encrypt_id}" class="my-tooltip btn btn-info btn-sm" data-toggle="tooltip" title="แสดงข้อมูลรายละเอียด">
							<i class="fa fa-search"></i> รายละเอียด
						</a>
						<a href="{page_url}/edit/{url_encrypt_id}" class="my-tooltip btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไขข้อมูล">
							<i class="fa fa-edit"></i> แก้ไข
						</a>
					</div>
				</td>
			</tr>
			{/recData}
		</tbody>
	</table>

	<div class="row dataTables_wrapper">
		<div class="col-sm-12 col-md-5">
			<div class="dataTables_info" id="dataTable_info" role="status" aria-live="polite">
				แสดงรายการที่ <b>{start_row}</b> ถึง <b>{end_row}</b> จากทั้งหมด <span class="badge badge-info"> {search_row}</span> รายการ
			</div>
		</div>
		<div class="col-sm-12 col-md-7">
			<div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
				{pagination_link}
			</div>
		</div>
	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="confirmDelModal" tabindex="-1" role="dialog" aria-labelledby="confirmDelModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="confirmDelModalLabel">ยืนยันการลบข้อมูล</h4>
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			</div>
			<div class="modal-body">
				<h4 class="text-center">*** ท่านต้องการลบข้อมูลแถวที่ <span id="xrow"></span> ??? ***</h4>
				<div id="div_del_detail"></div>
				<form id="formDelete">
					<div class="form-group">
						<div class="col-sm-8">
							<label class="col-sm-3 text-right badge badge-warning" for="edit_remark">ระบุเหตุผล :</label>
						</div>
						<div class="col-sm-12">
							<input type="text" class="form-control" name="delete_remark">
						</div>
					</div>
					<input type="hidden" name="encrypt_userid" />

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-danger" id="btn_confirm_delete">Delete</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalPreview" tabindex="-1" role="dialog" aria-labelledby="modalPreviewLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title" id="modalPreviewLabel">แสดงข้อมูล</h4>
			</div>
			<div class="modal-body">
				<div id="divPreview"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	var param_search_field = '{search_field}';
	var param_current_page = '{current_page_offset}';
</script>