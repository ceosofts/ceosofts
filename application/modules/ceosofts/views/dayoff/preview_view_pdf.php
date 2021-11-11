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
						<td class="text-right fit"><b>หมายเลข :</b></td>
						<td>{record_dayoff_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อวันหยุด :</b></td>
						<td>{record_dayoff_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่หยุด :</b></td>
						<td>{record_dayoff_date}</td>
					</tr>

				</tbody>
			</table>
