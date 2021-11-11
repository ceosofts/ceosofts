
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
						<td valign="top" class="text-right fit"><b>หมายเลขสินค้านำออก :</b></td>
						<td valign="top">&#8203;{record_sto_id}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่ใบสินค้านำออก :</b></td>
						<td valign="top">&#8203;{record_sto_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
					<td>{stoCusCusName} {stoCusCusContact} {stoCusCusAddress} {stoCusCusTel} {stoCusCusTax} {stoCusCusBranch}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
					<td>{stoProjectNameQuoProjectName}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td valign="top">&#8203;{record_sto_by}</td>
					</tr>

				</tbody>
			</table>
<h3 class="card-title">ตารางรายการ <b>tb_stock_out_list</b></h3>
		<table border="1">
			<thead class="thead-light">
				<tr>
					<th valign="top" width="20px;">#</th>
					<th valign="top">Id</th>
					<th valign="top">อ้างอิงใบส่งสินค้า</th>
					<th valign="top">หมายเลขสินค้า</th>
					<th valign="top">รายการสินค้า</th>
					<th valign="top">หน่วยสินค้า</th>
					<th valign="top">จำนวน</th>
					<th valign="top">หมายเหตุ</th>
				</tr>
			</thead>
			<tbody>
				<tr parser-repeat="[detail_list]" id="row_{record_number}">
					<td valign="top" style="text-align:center;">[{record_number}]</td>
					<td valign="top">{detail_id}</td>
					<td valign="top">&#8203;{detail_sto_ref}</td>
					<td valign="top">&#8203;{detail_sto_id}</td>
					<td valign="top">&#8203;{detailStoNamePrsName}</td>
					<td valign="top">&#8203;{detail_sto_unit}</td>
					<td valign="top">{detail_sto_qty}</td>
					<td valign="top">&#8203;{detail_sto_remark}</td>
				</tr>
			</tbody>
		</table>

<br/>
