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
			<td valign="top" class="text-right fit"><b>หมายเลขใบเสนอราคา :</b></td>
			<td valign="top">&#8203;{record_quo_id}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่ใบเสนอราคา :</b></td>
			<td valign="top">&#8203;{record_quo_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
			<td>{quoCusCusName} {quoCusCusContact} {quoCusCusAddress} {quoCusCusTel} {quoCusCusTax} {quoCusCusBranch}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ชื่อโครงการ :</b></td>
			<td valign="top">&#8203;{record_quo_project_name}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ราคาสินค้ารวมทั้งสิ้น :</b></td>
			<td valign="top">{record_quo_price}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>สถานะ :</b></td>
			<td>{quoStatusStqName}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
			<td valign="top">&#8203;{record_quo_by}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
			<td valign="top">&#8203;{record_quo_edit_by}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่แก้ไข :</b></td>
			<td valign="top">&#8203;{record_quo_edit_date}</td>
		</tr>

	</tbody>
</table>
<h3 class="card-title">ตารางรายการ <b>tb_quotation_list</b></h3>
<table border="1">
	<thead class="thead-light">
		<tr>
			<th valign="top" width="20px;">#</th>
			<th valign="top">Id</th>
			<th valign="top">อ้างอิงใบเสนอราคา</th>
			<th valign="top">หมายเลขสินค้า</th>
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
			<td valign="top">&#8203;{detail_quo_ref}</td>
			<td valign="top">&#8203;{detail_quo_pro_id}</td>
			<td valign="top">&#8203;{detailQuoProNamePrsName}</td>
			<td valign="top">{detail_quo_pro_price}</td>
			<td valign="top">&#8203;{detail_quo_pro_unit}</td>
			<td valign="top">{detail_quo_pro_qty}</td>
			<td valign="top" class="text-right">{fx_detail_total_price}</td>
			<td valign="top">&#8203;{detail_quo_pro_remark}</td>
		</tr>
	</tbody>
	<tfoot class="thead-light">
		<tr>
			<th valign="top" class="text-center" colspan="8">รวมทั้งสิ้น</th>
			<th valign="top" class="text-right">{fx_detail_grand_total_price}</th>
			<th></th>
		</tr>
	</tfoot>
</table>

<br />