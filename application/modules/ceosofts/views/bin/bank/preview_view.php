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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>Bank</b></h3>
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
						<td class="text-right fit"><b>หมายเลขรายการ :</b></td>
						<td>{record_bank_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ :</b></td>
						<td>{record_bankout_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อบัญชี :</b></td>
					<td>{bankCusNameBankCusName} {bankCusNameBankName} {bankCusNameBankBranch} {bankCusNameBankNumber}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>ยอดก่อนฝาก-ถอน :</b></td>
						<td>{record_bank_balance_before}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ทำรายการ :</b></td>
						<td>{preview_bank_action}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดฝาก-ถอน :</b></td>
						<td>{record_bank_price}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>คงเหลือ :</b></td>
						<td>{record_bank_balance_after}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_bank_remark}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เพิ่มข้อมูลโดย :</b></td>
						<td>{record_bank_edit_by}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>