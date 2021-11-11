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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ลูกค้า</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขลูกค้า</th>
			<th>ชื่อบริษัทลูกค้า</th>
			<th>ชื่อผู้ติดต่อ</th>
			<th>ที่อยู่ลูกค้า</th>
			<th>เบอร์โทรลูกค้า</th>
			<th>หมายเลขผู้เสียภาษี</th>
			<th>สาขา</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{cus_id}</td>
			<td>{cus_name}</td>
			<td>{cus_contact}</td>
			<td>{cus_address}</td>
			<td>{cus_tel}</td>
			<td>{cus_tax}</td>
			<td>{cusBranchBranchName}</td>
		</tr>
	</tbody>
</table>