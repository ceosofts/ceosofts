<meta http-equiv="content-type" content="application/xhtml+xml; charset=UTF-8" />

<table border="1">
	<thead class="well">
		<tr>
			<th class="text-right fit">หัวข้อ</th>
			<th>ข้อมูล</th>
		</tr>
	</thead>
	<tbody>

		<tr>
			<td valign="top" class="text-right fit"><b>หมายเลขใบเสร็จรับเงิน :</b></td>
			<td valign="top">&#8203;{record_rec_id}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>อ้างอิงหมายเลขใบวางบิล :</b></td>
			<td>{recInvNumberRefInvId}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่ใบเสร็จรับเงิน :</b></td>
			<td valign="top">&#8203;{record_rec_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
			<td>{recCusCusName} {recCusCusContact} {recCusCusAddress} {recCusCusTel} {recCusCusTax} {recCusCusBranch}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ชื่อโครงการ :</b></td>
			<td valign="top">&#8203;{record_rec_project_name}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ยอดตามใบวางบิล :</b></td>
			<td valign="top">{record_rec_price}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>สถานะ :</b></td>
			<td>{recStatusStrName}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
			<td valign="top">&#8203;{record_rec_by}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่ทำเอกสาร :</b></td>
			<td valign="top">&#8203;{record_rec_create_date}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
			<td valign="top">&#8203;{record_rec_edit_by}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่แก้ไข :</b></td>
			<td valign="top">&#8203;{record_rec_edit_date}</td>
		</tr>

	</tbody>
</table>