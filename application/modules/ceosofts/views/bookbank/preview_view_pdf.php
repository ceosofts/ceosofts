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
