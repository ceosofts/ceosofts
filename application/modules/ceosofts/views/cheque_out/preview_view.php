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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>เช็คออก</b></h3>
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
						<td class="text-right fit"><b>หมายเลขรายการเช็ค :</b></td>
						<td>{record_chequeout_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่สร้างรายการ :</b></td>
						<td>{record_chequeout_make_item}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่จ่ายเช็ค :</b></td>
						<td>{record_chequeout_pay_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่สั่งจ่าย :</b></td>
						<td>{record_chequeout_plan_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>จ่ายให้ :</b></td>
						<td>{record_chequeout_to}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดเงิน :</b></td>
						<td>{record_chequeout_price}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ธนาคาร/บัญชี :</b></td>
						<td>{chequeoutBookbankBankCusName} {chequeoutBookbankBankName} {chequeoutBookbankBankBranch} {chequeoutBookbankBankNumber}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเลขเช็ค :</b></td>
						<td>{record_chequeout_number}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สถานะเช็ค :</b></td>
						<td>{chequeoutStatusChsName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>รูปเช็ค :</b></td>
						<td>{preview_chequeout_photo}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_chequeout_remark}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ผู้ทำรายการ :</b></td>
						<td>{record_chequeout_user_make}</td>
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