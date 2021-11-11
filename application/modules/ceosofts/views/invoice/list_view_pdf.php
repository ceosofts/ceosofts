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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ใบวางบิล</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขใบวางบิล</th>
			<th>อ้างอิงหมายเลขใบเสนอราคา</th>
			<th>วันที่ใบวางบิล</th>
			<th>ชื่อลูกค้า</th>
			<th>ชื่อโครงการ</th>
			<th>ราคาตามใบเสนอราคา</th>
			<th>ยอดวางบิลงวดนี้</th>
			<th>สถานะ</th>
			<th>วันที่นัดจ่าย</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{inv_id}</td>
			<td>{invQuoNumberRefQuoId}</td>
			<td>{inv_date}</td>
			<td>{invCusCusName} {invCusCusContact} {invCusCusAddress} {invCusCusTel} {invCusCusTax} {invCusCusBranch}</td>
			<td>{inv_project_name}</td>
			<td>{inv_price}</td>
			<td>{inv_price_this_period}</td>
			<td>{invStatusStiName}</td>
			<td>{inv_pay_date}</td>
		</tr>
	</tbody>
</table>