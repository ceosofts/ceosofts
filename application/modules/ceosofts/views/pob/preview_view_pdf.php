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
			<td class="text-right fit"><b>หมายเลขใบสั่งซื้อ :</b></td>
			<td>{record_pob_id}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>อ้างอิงใบเสนอซื้อ :</b></td>
			<td>{pobPrRefId} {pobPrRefPrId}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่ใบสั่งซื้อ :</b></td>
			<td>{record_pob_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อผู้จำหน่าย :</b></td>
			<td>{pobSupSupName} {pobSupSupContact} {pobSupSupAddress} {pobSupSupTel} {pobSupSupTax} {pobSupSupBranch}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
			<td>{record_pob_project_name}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ราคารวม :</b></td>
			<td>{record_pob_price}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>จ่ายโดย :</b></td>
			<td>{pobPayByName}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่นัดจ่าย :</b></td>
			<td>{record_pob_pay_date}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>สถานะ :</b></td>
			<td>{pobStatusPobName}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
			<td>{record_pob_by}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
			<td>{record_pob_edit_by}</td>
		</tr>
		<tr>
			<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
			<td>{record_pob_edit_date}</td>
		</tr>

	</tbody>
</table>
<h3 class="card-title">ตารางรายการ <b>tb_pob_list</b></h3>
<table class="table  table-bordered table-hover">
	<thead class="thead-light">
		<tr>
			<th width="20px;">#</th>
			<th>Id</th>
			<th>อ้างอิงใบสั่งซื้อ</th>
			<th>อ้างอิง id ใบเสนอซื้อ</th>
			<th>หมายเลขสินค้า</th>
			<th>รายการสินค้า</th>
			<th>ราคาสินค้า</th>
			<th>หน่วยสินค้า</th>
			<th>จำนวน</th>
			<th>total price</th>
			<th>หมายเหตุ</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[detail_list]" id="row_{record_number}">
			<td style="text-align:center;">[{record_number}]</td>
			<td>{detail_id}</td>
			<td>{detail_pob_ref}</td>
			<td>{detailPobPrIdRefPrRef}</td>
			<td>{detail_pob_id}</td>
			<td>{detailPobNamePrbName}</td>
			<td>{detail_pob_price}</td>
			<td>{detail_pob_unit}</td>
			<td>{detail_pob_qty}</td>
			<td class="text-right">{fx_detail_ราคารวม}</td>
			<td>{detail_pob_remark}</td>
		</tr>
	</tbody>
	<tfoot class="thead-light">
		<tr>
			<th class="text-center" colspan="9">รวมทั้งสิ้น</th>
			<th class="text-right">{fx_detail_grand_ราคารวม}</th>
			<th></th>
		</tr>
	</tfoot>
</table>

<br />