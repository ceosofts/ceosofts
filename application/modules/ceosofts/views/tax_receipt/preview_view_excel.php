
<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />

			<table border="1">
				<thead class="well">
					<tr>
						<th class="text-right fit">หัวข้อ</th>
						<th>ข้อมูล</th>
					</tr>
				</thead>
				<tbody>

					<tr >
						<td valign="top" class="text-right fit"><b>หมายเลขใบหักภาษี :</b></td>
						<td valign="top">&#8203;{record_tar_rec_id}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>อ้างอิงหมายเลขใบเสร็จรับเงิน :</b></td>
					<td>{tarRecNumberRefRecId}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่ใบหักภาษี :</b></td>
						<td valign="top">&#8203;{record_tar_rec_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
					<td>{tarRecCusCusName} {tarRecCusCusContact} {tarRecCusCusAddress} {tarRecCusCusTel} {tarRecCusCusTax} {tarRecCusCusBranch}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ชื่อโครงการ :</b></td>
						<td valign="top">&#8203;{record_tar_rec_project_name}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ยอดตามใบเสร็จรับเงิน :</b></td>
						<td valign="top">{record_tar_rec_projectprice}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>หักภาษี :</b></td>
					<td>{tarLawTarLawDetail}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>เปอร์เซ็นต์ที่หัก :</b></td>
						<td valign="top">{record_tar_percent}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ยอดหักภาษี :</b></td>
						<td valign="top">{record_tar_rec_price}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>สถานะ :</b></td>
					<td>{tarRecStatusTarName}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td valign="top">&#8203;{record_tar_rec_by}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่ทำเอกสาร :</b></td>
						<td valign="top">&#8203;{record_tar_rec_crate_date}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
						<td valign="top">&#8203;{record_tar_rec_edit_by}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่แก้ไข :</b></td>
						<td valign="top">&#8203;{record_tax_rec_edit_date}</td>
					</tr>

				</tbody>
			</table>
