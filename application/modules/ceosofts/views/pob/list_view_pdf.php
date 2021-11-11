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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ใบสั่งซื้อ</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขใบสั่งซื้อ</th>
			<th>อ้างอิงใบเสนอซื้อ</th>
			<th>วันที่ใบสั่งซื้อ</th>
			<th>ชื่อผู้จำหน่าย</th>
			<th>ชื่อโครงการ</th>
			<th>ราคารวม</th>
			<th>จ่ายโดย</th>
			<th>วันที่นัดจ่าย</th>
			<th>สถานะ</th>
			<th>ผู้จัดทำเอกสาร</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{pob_id}</td>
			<td>{pobPrRefId} {pobPrRefPrId}</td>
			<td>{pob_date}</td>
			<td>{pobSupSupName} {pobSupSupContact} {pobSupSupAddress} {pobSupSupTel} {pobSupSupTax} {pobSupSupBranch}</td>
			<td>{pob_project_name}</td>
			<td>{pob_price}</td>
			<td>{pobPayByName}</td>
			<td>{pob_pay_date}</td>
			<td>{pobStatusPobName}</td>
			<td>{pob_by}</td>
		</tr>
	</tbody>
</table>