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
