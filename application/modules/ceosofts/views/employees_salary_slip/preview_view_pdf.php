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
						<td class="text-right fit"><b>หมายเลขสลิป :</b></td>
						<td>{record_Slip_id}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>หมายเลขพนักงาน :</b></td>
					<td>{slipEmsIdEmsId}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อพนักงาน :</b></td>
						<td>{record_slip_ems_fname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>นามสกุลพนักงาน :</b></td>
						<td>{record_slip_ems_lname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เงินเดือน :</b></td>
						<td>{record_slip_ems_salary}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เงินล่วงเวลา :</b></td>
						<td>{record_slip_ems_ot}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักเบิกล่วงหน้า :</b></td>
						<td>{record_slip_ems_advance}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักประกันสังคม :</b></td>
						<td>{record_slip_ems_ss}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักวันขาดงาน :</b></td>
						<td>{record_slip_ems_absent}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หักภาษี :</b></td>
						<td>{record_slip_tax}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดสุทธิ :</b></td>
						<td>{record_slip_net}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_slip_ems_remark}</td>
					</tr>

				</tbody>
			</table>
