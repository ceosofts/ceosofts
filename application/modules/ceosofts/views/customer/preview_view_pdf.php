<!-- [ View File name : preview_view.php ] -->

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

<table class="table table-bordered table-hover">
	<thead class="well">
		<tr>
			<th class="text-right fit">หัวข้อ</th>
			<th>ข้อมูล</th>
		</tr>
	</thead>
	<tbody>

		<tr>
			<td class="text-right fit"><b>หมายเลขลูกค้า :</b></td>
			<td>{record_cus_id}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อบริษัทลูกค้า :</b></td>
			<td>{record_cus_name}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อผู้ติดต่อ :</b></td>
			<td>{record_cus_contact}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ที่อยู่ลูกค้า :</b></td>
			<td>{record_cus_address}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>เบอร์โทรลูกค้า :</b></td>
			<td>{record_cus_tel}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>หมายเลขผู้เสียภาษี :</b></td>
			<td>{record_cus_tax}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>สาขา :</b></td>
			<td>{cusBranchBranchName}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>แก้ไขโดย :</b></td>
			<td>{record_cus_edit_by}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
			<td>{record_cus_edit_date}</td>
		</tr>

	</tbody>
</table>