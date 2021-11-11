<!-- [ View File name : preview_view.php ] -->

<style>
	body {
		font-family: 'TH SarabunPSK';
		font-size: 16pt;
		margin: 0px;
	}

	table {
		width: 100%;
		border-collapse: collapse;
	}

	table {
		page-break-inside: auto;
	}

	th {
		background-color: lightgrey;
		text-align: center;
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
			<td class="text-right fit"><b>หมายเลขใบวางบิล :</b></td>
			<td>{record_inv_id}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>อ้างอิงหมายเลขใบเสนอราคา :</b></td>
			<td>{invQuoNumberRefQuoId}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่ใบวางบิล :</b></td>
			<td>{record_inv_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
			<td>{invCusCusName} {invCusCusContact} {invCusCusAddress} {invCusCusTel} {invCusCusTax} {invCusCusBranch}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
			<td>{record_inv_project_name}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ราคาตามใบเสนอราคา :</b></td>
			<td>{record_inv_price}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ยอดวางบิลงวดนี้ :</b></td>
			<td>{record_inv_price_this_period}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>สถานะ :</b></td>
			<td>{invStatusStiName}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่นัดจ่าย :</b></td>
			<td>{record_inv_pay_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
			<td>{record_inv_by}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่ทำเอกสาร :</b></td>
			<td>{record_inv_create_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
			<td>{record_inv_edit_by}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
			<td>{record_inv_edit_date}</td>
		</tr>

	</tbody>
</table>
<h3 class="card-title">ตารางรายการ <b>รายละเอียดใบวางบิล</b></h3>
<table class="table  table-bordered table-hover">
	<thead class="thead-light">
		<tr>
			<th width="20px;">#</th>
			<th>Id</th>
			<th>อ้างอิงใบวางบิล</th>
			<th>รายการสินค้า</th>
			<th>ราคาสินค้า</th>
			<th>หน่วยสินค้า</th>
			<th>จำนวน</th>
			<th>ราคารวม</th>
			<th>หมายเหตุ</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[detail_list]" id="row_{record_number}">
			<td style="text-align:center;">[{record_number}]</td>
			<td>{detail_id}</td>
			<td>{detail_inv_ref}</td>
			<td>{detail_inv_pro_name}</td>
			<td>{detail_inv_pro_price}</td>
			<td>{detailInvProUnitUnitName}</td>
			<td>{detail_inv_pro_qty}</td>
			<td class="text-right">{fx_detail_total_price}</td>
			<td>{detail_inv_pro_remark}</td>
		</tr>
	</tbody>
	<tfoot class="thead-light">
		<tr>
			<th class="text-center" colspan="7">รวมทั้งสิ้น</th>
			<th class="text-right">{fx_detail_grand_total_price}</th>
			<th></th>
		</tr>
	</tfoot>
</table>

<br />