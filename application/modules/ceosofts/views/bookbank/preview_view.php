<!-- [ View File name : preview_view.php ] -->

<style>
	.table th.fit,
	.table td.fit {
		white-space: nowrap;
		width: 2%;
	}
</style>
<div class="card">

	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>สมุดบัญชีเงินฝาก</b></h3>
	</div>

	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered table-hover">
				<thead class="well">
					<tr>
						<th class="text-right fit">หัวข้อ</th>
						<th>ข้อมูล</th>
					</tr>
				</thead>
				<tbody>

					<tr>
						<td class="text-right fit"><b>หมายเลขสมุดบัญชี :</b></td>
						<td>{record_bank_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อบัญชี :</b></td>
						<td>{record_bank_cus_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อธนาคาร :</b></td>
						<td>{record_bank_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สาขา :</b></td>
						<td>{record_bank_branch}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเลขบัญชี :</b></td>
						<td>{record_bank_number}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เพิ่มข้อมูล :</b></td>
						<td>{record_bank_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ทำรายการ :</b></td>
						<td>{record_bank_date}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
	<div class="col-sm-12 col-md-12">
		<div class="pull-right text-right">
			<a href="{page_url}/preview_print_pdf/{recode_url_encrypt_id}" target="_blank" class="btn btn-danger btn-lg" data-toggle="tooltip" title="พิมพ์ข้อมูล">
				<i class="fas fa-file-pdf"></i></span> PDF
			</a>
			<a href="{page_url}/preview_export_excel/{recode_url_encrypt_id}" class="btn btn-success btn-lg" data-toggle="tooltip" title="ส่งออกข้อมูล">
				<i class="fas fa-file-excel"></i></span> Excel
			</a>
		</div>
	</div>
	<hr />
</div>