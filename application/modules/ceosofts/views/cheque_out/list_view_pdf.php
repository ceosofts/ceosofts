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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>เช็คออก</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขรายการเช็ค</th>
			<th>วันที่สร้างรายการ</th>
			<th>วันที่จ่ายเช็ค</th>
			<th>วันที่สั่งจ่าย</th>
			<th>จ่ายให้</th>
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
			<td>{chequeout_id}</td>
			<td>{chequeout_make_item}</td>
			<td>{chequeout_pay_date}</td>
			<td>{chequeout_plan_date}</td>
			<td>{chequeout_to}</td>
			<td>{chequeout_price}</td>
			<td>{chequeoutBookbankBankCusName} {chequeoutBookbankBankName} {chequeoutBookbankBankBranch} {chequeoutBookbankBankNumber}</td>
			<td>{chequeout_number}</td>
			<td>{chequeoutStatusChsName}</td>
			<td>{pdf_image_chequeout_photo}</td>
		</tr>
	</tbody>
</table>