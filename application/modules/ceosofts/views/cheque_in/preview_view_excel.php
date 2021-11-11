
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
						<td valign="top" class="text-right fit"><b>หมายเลขรายการเช็ค :</b></td>
						<td valign="top">&#8203;{record_chequein_id}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่สร้างรายการ :</b></td>
						<td valign="top">&#8203;{record_chequein_make_item}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่รับเช็ค :</b></td>
						<td valign="top">&#8203;{record_chequein_receive_date}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่สั่งจ่าย :</b></td>
						<td valign="top">&#8203;{record_chequein_plan_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>รับจาก :</b></td>
					<td>{chequeinFromCusName}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ยอดเงิน :</b></td>
						<td valign="top">{record_chequein_price}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ธนาคาร/บัญชี :</b></td>
					<td>{chequeinBookbankBankCusName} {chequeinBookbankBankName} {chequeinBookbankBankBranch} {chequeinBookbankBankNumber}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>หมายเลขเช็ค :</b></td>
						<td valign="top">&#8203;{record_chequein_number}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>สถานะเช็ค :</b></td>
					<td>{chequeinStatusChsName}</td>
				</tr>
height="100"					<tr height="100">
						<td valign="top" class="text-right fit"><b>รูปเช็ค :</b></td>
						<td valign="top">&#8203;{preview_chequein_photo}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>หมายเหตุ :</b></td>
						<td valign="top">&#8203;{record_chequein_remark}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ผู้ทำรายการ :</b></td>
						<td valign="top">&#8203;{record_chequein_user_make}</td>
					</tr>

				</tbody>
			</table>
