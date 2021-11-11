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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>เงินฝากเข้า</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขรายการ</th>
			<th>วันที่ทำการ</th>
			<th>ชื่อบัญชี</th>
			<th>ยอดก่อนฝาก</th>
			<th>ยอดทำรายการ</th>
			<th>คงเหลือ</th>
			<th>หมายเหตุ</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{bank_in_id}</td>
			<td>{bank_in_date}</td>
			<td>{bankInNameBankCusName} {bankInNameBankName} {bankInNameBankBranch} {bankInNameBankNumber}</td>
			<td>{bank_in_balance_before}</td>
			<td>{bank_in_price}</td>
			<td>{bank_in_balance_after}</td>
			<td>{bank_in_remark}</td>
		</tr>
	</tbody>
</table>