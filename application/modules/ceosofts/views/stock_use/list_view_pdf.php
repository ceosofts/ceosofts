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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>เบิกวัสดุอุปกรณ์</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขสินค้า</th>
			<th>วันที่ใบเบิก</th>
			<th>ชื่อผู้เบิก</th>
			<th>ชื่อโครงการ</th>
			<th>ผู้จัดทำเอกสาร</th>
			<th>สถานะการนำไปใช้</th>
			<th>สถานะจำนวน</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{stu_id}</td>
			<td>{stu_date}</td>
			<td>{stuUserNameEmpFname} {stuUserNameEmpPosition} {stuUserNameEmpSection}</td>
			<td>{stuProjectNameQuoProjectName}</td>
			<td>{stu_by}</td>
			<td>{stuStatusUseStcName}</td>
			<td>{stuStatusQtyStcName}</td>
		</tr>
	</tbody>
</table>