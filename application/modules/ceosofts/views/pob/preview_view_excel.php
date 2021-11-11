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
			<td valign="top" class="text-right fit"><b>หมายเลขใบสั่งซื้อ :</b></td>
			<td valign="top">&#8203;{record_pob_id}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>อ้างอิงใบเสนอซื้อ :</b></td>
			<td>{pobPrRefId} {pobPrRefPrId}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่ใบสั่งซื้อ :</b></td>
			<td valign="top">&#8203;{record_pob_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อผู้จำหน่าย :</b></td>
			<td>{pobSupSupName} {pobSupSupContact} {pobSupSupAddress} {pobSupSupTel} {pobSupSupTax} {pobSupSupBranch}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ชื่อโครงการ :</b></td>
			<td valign="top">&#8203;{record_pob_project_name}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ราคารวม :</b></td>
			<td valign="top">{record_pob_price}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>จ่ายโดย :</b></td>
			<td>{pobPayByName}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่นัดจ่าย :</b></td>
			<td valign="top">&#8203;{record_pob_pay_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>สถานะ :</b></td>
			<td>{pobStatusPobName}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
			<td valign="top">&#8203;{record_pob_by}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
			<td valign="top">&#8203;{record_pob_edit_by}</td>
		</tr>
		<tr>
			<td valign="top" class="text-right fit"><b>วันที่แก้ไข :</b></td>
			<td valign="top">&#8203;{record_pob_edit_date}</td>
		</tr>

	</tbody>
</table>
<h3 class="card-title">ตารางรายการ <b>tb_pob_list</b></h3>
<table border="1">
	<thead class="thead-light">
		<tr>
			<th valign="top" width="20px;">#</th>
			<th valign="top">Id</th>
			<th valign="top">อ้างอิงใบสั่งซื้อ</th>
			<th valign="top">อ้างอิง id ใบเสนอซื้อ</th>
			<th valign="top">หมายเลขสินค้า</th>
			<th valign="top">รายการสินค้า</th>
			<th valign="top">ราคาสินค้า</th>
			<th valign="top">หน่วยสินค้า</th>
			<th valign="top">จำนวน</th>
			<th valign="top">total price</th>
			<th valign="top">หมายเหตุ</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[detail_list]" id="row_{record_number}">
			<td valign="top" style="text-align:center;">[{record_number}]</td>
			<td valign="top">{detail_id}</td>
			<td valign="top">&#8203;{detail_pob_ref}</td>
			<td valign="top">&#8203;{detailPobPrIdRefPrRef}</td>
			<td valign="top">&#8203;{detail_pob_id}</td>
			<td valign="top">&#8203;{detailPobNamePrbName}</td>
			<td valign="top">{detail_pob_price}</td>
			<td valign="top">&#8203;{detail_pob_unit}</td>
			<td valign="top">{detail_pob_qty}</td>
			<td valign="top" class="text-right">{fx_detail_ราคารวม}</td>
			<td valign="top">&#8203;{detail_pob_remark}</td>
		</tr>
	</tbody>
	<tfoot class="thead-light">
		<tr>
			<th valign="top" class="text-center" colspan="9">รวมทั้งสิ้น</th>
			<th valign="top" class="text-right">{fx_detail_grand_ราคารวม}</th>
			<th></th>
		</tr>
	</tfoot>
</table>

<br />