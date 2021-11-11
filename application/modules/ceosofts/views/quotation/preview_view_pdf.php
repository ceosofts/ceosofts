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
			<td class="text-right fit"><b>หมายเลขใบเสนอราคา :</b></td>
			<td>{record_quo_id}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่ใบเสนอราคา :</b></td>
			<td>{record_quo_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
			<td>{quoCusCusName} {quoCusCusContact} {quoCusCusAddress} {quoCusCusTel} {quoCusCusTax} {quoCusCusBranch}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
			<td>{record_quo_project_name}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ราคาสินค้ารวมทั้งสิ้น :</b></td>
			<td>{record_quo_price}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>สถานะ :</b></td>
			<td>{quoStatusStqName}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
			<td>{record_quo_by}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
			<td>{record_quo_edit_by}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
			<td>{record_quo_edit_date}</td>
		</tr>

	</tbody>
</table>
<h3 class="card-title">ตารางรายการ <b>tb_quotation_list</b></h3>
<table class="table  table-bordered table-hover">
	<thead class="thead-light">
		<tr>
			<th width="20px;">#</th>
			<th>Id</th>
			<th>อ้างอิงใบเสนอราคา</th>
			<th>หมายเลขสินค้า</th>
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
			<td>{detail_quo_ref}</td>
			<td>{detail_quo_pro_id}</td>
			<td>{detailQuoProNamePrsName}</td>
			<td>{detail_quo_pro_price}</td>
			<td>{detail_quo_pro_unit}</td>
			<td>{detail_quo_pro_qty}</td>
			<td class="text-right">{fx_detail_total_price}</td>
			<td>{detail_quo_pro_remark}</td>
		</tr>
	</tbody>
	<tfoot class="thead-light">
		<tr>
			<th class="text-center" colspan="8">รวมทั้งสิ้น</th>
			<th class="text-right">{fx_detail_grand_total_price}</th>
			<th></th>
		</tr>
	</tfoot>
</table>

<br />