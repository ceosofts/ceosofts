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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>ใบเสร็จจ่ายเงิน</b></h3>
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
						<td class="text-right fit"><b>หมายเลขใบเสร็จจ่ายเงิน :</b></td>
						<td>{record_pay_rec_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>อ้างอิงใบสั่งจ่าย :</b></td>
						<td>{payRecPrRefPayId}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ทำเอกสารรับใบเสร็จจ่ายเงิน :</b></td>
						<td>{record_pay_rec_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้จำหน่าย :</b></td>
						<td>{record_pay_rec_sup}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
						<td>{record_pay_rec_project_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ราคารวม :</b></td>
						<td>{record_pay_rec_price}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>จ่ายโดย :</b></td>
						<td>{record_pay_rec_pay_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_pay_rec_remark}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สแกนเอกสาร :</b></td>
						<td>{preview_pay_rec_scan}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ได้รับเอกสาร :</b></td>
						<td>{record_pay_rec_pay_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td>{record_pay_rec_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
						<td>{record_pay_rec_edit_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
						<td>{record_pay_rec_edit_date}</td>
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