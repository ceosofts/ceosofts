<!-- [ View File name : preview_view.php ] -->

<style>
	body {
		font-family: 'TH SarabunPSK';
		font-size : 16pt;
		margin : 0px;
	}
	table{
		width : 100%;
		border-collapse: collapse;
	}
	table { page-break-inside:auto; }
	
	th {
	   background-color:lightgrey;
	   text-align : center;
	}
</style>

			<table class="table table-bordered table-hover">
				<thead class="well">
					<tr>
						<th class="text-right fit">หัวข้อ</th>
						<th>ข้อมูล</th>
					</tr>
				</thead>
				<tbody>

				<tr>
					<td class="text-right fit"><b>หมายเลขพนักงาน :</b></td>
					<td>{emsIdEmpId}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อพนักงาน :</b></td>
						<td>{record_ems_fname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>นามสกุลพนักงาน :</b></td>
						<td>{record_ems_lname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เงินเดือน :</b></td>
						<td>{record_ems_salary}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_ems_remark}</td>
					</tr>

				</tbody>
			</table>
