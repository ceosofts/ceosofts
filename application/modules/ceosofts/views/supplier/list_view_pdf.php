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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ผู้จำหน่าย</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขผู้ผลิต</th>
			<th>ชื่อบริษัทผู้ผลิต</th>
			<th>ชื่อผู้ติดต่อ</th>
			<th>ที่อยู่ผู้ผลิต</th>
			<th>เบอร์โทรผู้ผลิต</th>
			<th>หมายเลขผู้เสียภาษี</th>
			<th>สาขา</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{sup_id}</td>
			<td>{sup_name}</td>
			<td>{sup_contact}</td>
			<td>{sup_address}</td>
			<td>{sup_tel}</td>
			<td>{sup_tax}</td>
			<td>{supBranchBranchName}</td>
		</tr>
	</tbody>
</table>