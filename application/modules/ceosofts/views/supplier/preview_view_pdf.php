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
						<td class="text-right fit"><b>หมายเลขผู้ผลิต :</b></td>
						<td>{record_sup_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อบริษัทผู้ผลิต :</b></td>
						<td>{record_sup_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้ติดต่อ :</b></td>
						<td>{record_sup_contact}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ที่อยู่ผู้ผลิต :</b></td>
						<td>{record_sup_address}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เบอร์โทรผู้ผลิต :</b></td>
						<td>{record_sup_tel}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเลขผู้เสียภาษี :</b></td>
						<td>{record_sup_tax}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>สาขา :</b></td>
					<td>{supBranchBranchName}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>เพิ่มข้อมูลโดย :</b></td>
						<td>{record_sup_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่เพิ่มข้อมูล :</b></td>
						<td>{record_sup_date}</td>
					</tr>

				</tbody>
			</table>
