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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ใบเสนอซื้อ</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขใบเสนอซื้อ</th>
			<th>วันที่ใบเสนอซื้อ</th>
			<th>ชื่อผู้จำหน่าย</th>
			<th>ชื่อโครงการ</th>
			<th>สถานะ</th>
			<th>ราคารวม</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{pr_id}</td>
			<td>{pr_date}</td>
			<td>{prSupSupName} {prSupSupContact} {prSupSupAddress} {prSupSupTax} {prSupSupBranch}</td>
			<td>{pr_project_name}</td>
			<td>{prStatusStqName}</td>
			<td>{pr_price}</td>
		</tr>
	</tbody>
</table>