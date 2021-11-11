
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
						<td valign="top" class="text-right fit"><b>หมายเลขใบวางบิล :</b></td>
						<td valign="top">&#8203;{record_inv_id}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>อ้างอิงหมายเลขใบเสนอราคา :</b></td>
					<td>{invQuoNumberRefQuoId}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่ใบวางบิล :</b></td>
						<td valign="top">&#8203;{record_inv_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
					<td>{invCusCusName} {invCusCusContact} {invCusCusAddress} {invCusCusTel} {invCusCusTax} {invCusCusBranch}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ชื่อโครงการ :</b></td>
						<td valign="top">&#8203;{record_inv_project_name}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ราคาตามใบเสนอราคา :</b></td>
						<td valign="top">{record_inv_price}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ยอดวางบิลงวดนี้ :</b></td>
						<td valign="top">{record_inv_price_this_period}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>สถานะ :</b></td>
					<td>{invStatusStiName}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่นัดจ่าย :</b></td>
						<td valign="top">&#8203;{record_inv_pay_date}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td valign="top">&#8203;{record_inv_by}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่ทำเอกสาร :</b></td>
						<td valign="top">&#8203;{record_inv_create_date}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
						<td valign="top">&#8203;{record_inv_edit_by}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่แก้ไข :</b></td>
						<td valign="top">&#8203;{record_inv_edit_date}</td>
					</tr>

				</tbody>
			</table>
<h3 class="card-title">ตารางรายการ <b>tb_invoice_quotation_list</b></h3>
		<table border="1">
			<thead class="thead-light">
				<tr>
					<th valign="top" width="20px;">#</th>
					<th valign="top">Id</th>
					<th valign="top">อ้างอิงใบวางบิล</th>
					<th valign="top">รายการสินค้า</th>
					<th valign="top">ราคาสินค้า</th>
					<th valign="top">หน่วยสินค้า</th>
					<th valign="top">จำนวน</th>
					<th valign="top">ราคารวม</th>
					<th valign="top">หมายเหตุ</th>
				</tr>
			</thead>
			<tbody>
				<tr parser-repeat="[detail_list]" id="row_{record_number}">
					<td valign="top" style="text-align:center;">[{record_number}]</td>
					<td valign="top">{detail_id}</td>
					<td valign="top">&#8203;{detail_inv_ref}</td>
					<td valign="top">&#8203;{detail_inv_pro_name}</td>
					<td valign="top">{detail_inv_pro_price}</td>
					<td valign="top">&#8203;{detailInvProUnitUnitName}</td>
					<td valign="top">{detail_inv_pro_qty}</td>
					<td valign="top" class="text-right">{fx_detail_total_price}</td>
					<td valign="top">&#8203;{detail_inv_pro_remark}</td>
				</tr>
			</tbody>
			<tfoot class="thead-light">
				<tr>
					<th valign="top" class="text-center" colspan="7">รวมทั้งสิ้น</th>
					<th valign="top" class="text-right">{fx_detail_grand_total_price}</th>
					<th></th>
				</tr>
			</tfoot>
		</table>

<br/>
