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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ใบเสร็จรับเงิน</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขใบเสร็จรับเงิน</th>
			<th>อ้างอิงหมายเลขใบวางบิล</th>
			<th>วันที่ใบเสร็จรับเงิน</th>
			<th>ชื่อลูกค้า</th>
			<th>ชื่อโครงการ</th>
			<th>ยอดตามใบวางบิล</th>
			<th>สถานะ</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{rec_id}</td>
			<td>{recInvNumberRefInvId}</td>
			<td>{rec_date}</td>
			<td>{recCusCusName} {recCusCusContact} {recCusCusAddress} {recCusCusTel} {recCusCusTax} {recCusCusBranch}</td>
			<td>{rec_project_name}</td>
			<td>{rec_price}</td>
			<td>{recStatusStrName}</td>
		</tr>
	</tbody>
</table>