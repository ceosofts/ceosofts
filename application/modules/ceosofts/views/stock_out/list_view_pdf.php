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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>สินค้านำออก</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขสินค้านำออก</th>
			<th>วันที่ใบสินค้านำออก</th>
			<th>ชื่อลูกค้า</th>
			<th>ชื่อโครงการ</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{sto_id}</td>
			<td>{sto_date}</td>
			<td>{stoCusCusName} {stoCusCusContact} {stoCusCusAddress} {stoCusCusTel} {stoCusCusTax} {stoCusCusBranch}</td>
			<td>{stoProjectNameQuoProjectName}</td>
		</tr>
	</tbody>
</table>