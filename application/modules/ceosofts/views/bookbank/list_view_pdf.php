<style>
	body {
		font-family: 'TH SarabunPSK';
		font-size: 16pt;
		margin: 0px;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	table {
		page-break-inside: auto;
	}

	th {
		background-color: lightgrey;
		text-align: center;
	}
</style>

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>สมุดบัญชีเงินฝาก</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขสมุดบัญชี</th>
			<th>ชื่อบัญชี</th>
			<th>ชื่อธนาคาร</th>
			<th>สาขา</th>
			<th>หมายเลขบัญชี</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{bank_id}</td>
			<td>{bank_cus_name}</td>
			<td>{bank_name}</td>
			<td>{bank_branch}</td>
			<td>{bank_number}</td>
		</tr>
	</tbody>
</table>