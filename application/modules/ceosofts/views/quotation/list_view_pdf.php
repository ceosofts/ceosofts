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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ใบเสนอราคา</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขใบเสนอราคา</th>
			<th>วันที่ใบเสนอราคา</th>
			<th>ชื่อลูกค้า</th>
			<th>ชื่อโครงการ</th>
			<th>ราคาสินค้ารวมทั้งสิ้น </th>
			<th>สถานะ</th>
			<th>ผู้จัดทำเอกสาร</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{quo_id}</td>
			<td>{quo_date}</td>
			<td>{quoCusCusName} {quoCusCusContact} {quoCusCusAddress} {quoCusCusTel} {quoCusCusTax} {quoCusCusBranch}</td>
			<td>{quo_project_name}</td>
			<td>{quo_price}</td>
			<td>{quoStatusStqName}</td>
			<td>{quo_by}</td>
		</tr>
	</tbody>
</table>