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
						<td class="text-right fit"><b>หมายเลขสินค้า :</b></td>
						<td>{record_prb_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อสินค้า :</b></td>
						<td>{record_prb_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ราคาสินค้า :</b></td>
						<td>{record_prb_price}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>หน่วยสินค้า :</b></td>
					<td>{prbUnitUnitName}</td>
				</tr>

				</tbody>
			</table>
