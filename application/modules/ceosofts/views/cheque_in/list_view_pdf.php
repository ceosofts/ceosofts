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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>เช็คเข้า</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขรายการเช็ค</th>
			<th>วันที่สร้างรายการ</th>
			<th>วันที่รับเช็ค</th>
			<th>วันที่สั่งจ่าย</th>
			<th>รับจาก</th>
			<th>ยอดเงิน</th>
			<th>ธนาคาร/บัญชี</th>
			<th>หมายเลขเช็ค</th>
			<th>สถานะเช็ค</th>
			<th>รูปเช็ค</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{chequein_id}</td>
			<td>{chequein_make_item}</td>
			<td>{chequein_receive_date}</td>
			<td>{chequein_plan_date}</td>
			<td>{chequeinFromCusName}</td>
			<td>{chequein_price}</td>
			<td>{chequeinBookbankBankCusName} {chequeinBookbankBankName} {chequeinBookbankBankBranch} {chequeinBookbankBankNumber}</td>
			<td>{chequein_number}</td>
			<td>{chequeinStatusChsName}</td>
			<td>{pdf_image_chequein_photo}</td>
		</tr>
	</tbody>
</table>