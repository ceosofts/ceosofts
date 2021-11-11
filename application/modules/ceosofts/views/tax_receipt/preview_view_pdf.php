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
						<td class="text-right fit"><b>หมายเลขใบหักภาษี :</b></td>
						<td>{record_tar_rec_id}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>อ้างอิงหมายเลขใบเสร็จรับเงิน :</b></td>
					<td>{tarRecNumberRefRecId}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ใบหักภาษี :</b></td>
						<td>{record_tar_rec_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
					<td>{tarRecCusCusName} {tarRecCusCusContact} {tarRecCusCusAddress} {tarRecCusCusTel} {tarRecCusCusTax} {tarRecCusCusBranch}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
						<td>{record_tar_rec_project_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดตามใบเสร็จรับเงิน :</b></td>
						<td>{record_tar_rec_projectprice}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>หักภาษี :</b></td>
					<td>{tarLawTarLawDetail}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>เปอร์เซ็นต์ที่หัก :</b></td>
						<td>{record_tar_percent}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดหักภาษี :</b></td>
						<td>{record_tar_rec_price}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>สถานะ :</b></td>
					<td>{tarRecStatusTarName}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td>{record_tar_rec_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ทำเอกสาร :</b></td>
						<td>{record_tar_rec_crate_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
						<td>{record_tar_rec_edit_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
						<td>{record_tax_rec_edit_date}</td>
					</tr>

				</tbody>
			</table>
