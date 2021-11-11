
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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>tb_tax_receipt</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>						<th>หมายเลขใบหักภาษี</th>
						<th>อ้างอิงหมายเลขใบเสร็จรับเงิน</th>
						<th>วันที่ใบหักภาษี</th>
						<th>ชื่อลูกค้า</th>
						<th>ชื่อโครงการ</th>
						<th>ยอดตามใบเสร็จรับเงิน</th>
						<th>หักภาษี</th>
						<th>เปอร์เซ็นต์ที่หัก</th>
						<th>ยอดหักภาษี</th>
						<th>สถานะ</th>
</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td  width="20px;">[{record_number}]</td>						<td>{tar_rec_id}</td>
						<td>{tarRecNumberRefRecId}</td>
						<td>{tar_rec_date}</td>
						<td>{tarRecCusCusName} {tarRecCusCusContact} {tarRecCusCusAddress} {tarRecCusCusTel} {tarRecCusCusTax} {tarRecCusCusBranch}</td>
						<td>{tar_rec_project_name}</td>
						<td>{tar_rec_projectprice}</td>
						<td>{tarLawTarLawDetail}</td>
						<td>{tar_percent}</td>
						<td>{tar_rec_price}</td>
						<td>{tarRecStatusTarName}</td>
</tr>
	</tbody>
</table>