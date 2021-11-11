<!-- [ View File name : preview_view.php ] -->

<style>
	body {
		font-family: 'TH SarabunPSK';
		font-size : 16pt;
		margin : 0px;
	}
	table{
		width : 100%;
		border-collapse: collapse;
	}
	table { page-break-inside:auto; }
	
	th {
	   background-color:lightgrey;
	   text-align : center;
	}
</style>

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
						<td>{record_bank_out_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ทำการ :</b></td>
						<td>{record_bank_out_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อบัญชี :</b></td>
					<td>{bankOutNameBankCusName} {bankOutNameBankName} {bankOutNameBankBranch} {bankOutNameBankNumber}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>ยอดก่อนถอน :</b></td>
						<td>{record_bank_out_balance_before}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดทำรายการ :</b></td>
						<td>{record_bank_out_price}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>คงเหลือ :</b></td>
						<td>{record_bank_out_balance_after}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_bank_out_remark}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เพิ่มข้อมูลโดย :</b></td>
						<td>{record_bank_out_edit_by}</td>
					</tr>

				</tbody>
			</table>
