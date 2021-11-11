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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>พนักงาน</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขพนักงาน</th>
			<th>คำนำหน้าชื่อ</th>
			<th>ชื่อพนักงาน</th>
			<th>นามสกุลพนักงาน</th>
			<th>เลขบัตรประชาชน</th>
			<th>เพศ</th>
			<th>วันที่เกิด</th>
			<th>ตำแหน่งพนักงาน</th>
			<th>แผนกพนักงาน</th>
			<th>เบอร์โทรศัพท์</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{emp_id}</td>
			<td>{empTitleNamePrefixName}</td>
			<td>{emp_fname}</td>
			<td>{emp_lname}</td>
			<td>{emd_id_card}</td>
			<td>{preview_emp_sex}</td>
			<td>{emp_birthday}</td>
			<td>{empPositionPositionName}</td>
			<td>{empSectionDpmName}</td>
			<td>{emp_tel}</td>
		</tr>
	</tbody>
</table>