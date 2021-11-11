
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
						<td valign="top" class="text-right fit"><b>หมายเลขสินค้า :</b></td>
						<td valign="top">&#8203;{record_stu_id}</td>
					</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>วันที่ใบเบิก :</b></td>
						<td valign="top">&#8203;{record_stu_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อผู้เบิก :</b></td>
					<td>{stuUserNameEmpFname} {stuUserNameEmpPosition} {stuUserNameEmpSection}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
					<td>{stuProjectNameQuoProjectName}</td>
				</tr>
					<tr >
						<td valign="top" class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td valign="top">&#8203;{record_stu_by}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>สถานะการนำไปใช้ :</b></td>
					<td>{stuStatusUseStcName}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>สถานะจำนวน :</b></td>
					<td>{stuStatusQtyStcName}</td>
				</tr>

				</tbody>
			</table>
<h3 class="card-title">ตารางรายการ <b>tb_stock_use_list</b></h3>
		<table border="1">
			<thead class="thead-light">
				<tr>
					<th valign="top" width="20px;">#</th>
					<th valign="top">Id</th>
					<th valign="top">อ้างอิงใบเบิก</th>
					<th valign="top">หมายเลขสินค้า</th>
					<th valign="top">รายการสินค้า</th>
					<th valign="top">หน่วยสินค้า</th>
					<th valign="top">จำนวน</th>
					<th valign="top">หมายเหตุ</th>
					<th valign="top">สถานะ</th>
				</tr>
			</thead>
			<tbody>
				<tr parser-repeat="[detail_list]" id="row_{record_number}">
					<td valign="top" style="text-align:center;">[{record_number}]</td>
					<td valign="top">{detail_id}</td>
					<td valign="top">&#8203;{detail_stu_ref}</td>
					<td valign="top">&#8203;{detail_stu_id}</td>
					<td valign="top">&#8203;{detail_stu_name}</td>
					<td valign="top">&#8203;{detail_stu_unit}</td>
					<td valign="top">{detail_stu_qty}</td>
					<td valign="top">&#8203;{detail_stu_remark}</td>
					<td valign="top">&#8203;{detail_stu_status}</td>
				</tr>
			</tbody>
		</table>

<br/>
