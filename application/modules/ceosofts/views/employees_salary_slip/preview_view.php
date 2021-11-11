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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>สลิปเงินเดือนพนักงาน</b></h3>
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
						<td class="text-right fit"><b>หมายเลขสลิป :</b></td>
						<td>{record_Slip_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเลขพนักงาน :</b></td>
						<td>{slipEmsIdEmsId}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อพนักงาน :</b></td>
						<td>{record_slip_ems_fname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>นามสกุลพนักงาน :</b></td>
						<td>{record_slip_ems_lname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เงินเดือน :</b></td>
						<td>{record_slip_ems_salary}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เงินล่วงเวลา :</b></td>
						<td>{record_slip_ems_ot}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักเบิกล่วงหน้า :</b></td>
						<td>{record_slip_ems_advance}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักประกันสังคม :</b></td>
						<td>{record_slip_ems_ss}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักวันขาดงาน :</b></td>
						<td>{record_slip_ems_absent}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักภาษี :</b></td>
						<td>{record_slip_tax}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดสุทธิ :</b></td>
						<td>{record_slip_net}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_slip_ems_remark}</td>
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