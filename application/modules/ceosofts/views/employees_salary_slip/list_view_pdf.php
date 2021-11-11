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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>สลิปเงินเดือนพนักงาน</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขสลิป</th>
			<th>หมายเลขพนักงาน</th>
			<th>ชื่อพนักงาน</th>
			<th>นามสกุลพนักงาน</th>
			<th>เงินเดือน</th>
			<th>เงินล่วงเวลา</th>
			<th>หักเบิกล่วงหน้า</th>
			<th>หักประกันสังคม</th>
			<th>หักวันขาดงาน</th>
			<th>หักภาษี</th>
			<th>ยอดสุทธิ</th>
			<th>หมายเหตุ</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{Slip_id}</td>
			<td>{slipEmsIdEmsId}</td>
			<td>{slip_ems_fname}</td>
			<td>{slip_ems_lname}</td>
			<td>{slip_ems_salary}</td>
			<td>{slip_ems_ot}</td>
			<td>{slip_ems_advance}</td>
			<td>{slip_ems_ss}</td>
			<td>{slip_ems_absent}</td>
			<td>{slip_tax}</td>
			<td>{slip_net}</td>
			<td>{slip_ems_remark}</td>
		</tr>
	</tbody>
</table>