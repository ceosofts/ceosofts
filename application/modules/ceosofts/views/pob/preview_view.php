<!-- [ View File name : preview_view.php ] -->

<style>
	.table th.fit,
	.table td.fit {
		white-space: nowrap;
		width: 2%;
	}
</style>
<div class="card">

	<div class="card-header bg-primary">
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>ใบสั่งซื้อ</b></h3>
	</div>

	<div class="card-body">
		<div class="table-responsive">
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
		</div>
	</div>
	<br />
	<div class="card">

		<div class="card-header bg-info">
			<h3 class="card-title">ตารางรายการ <b>ใบสั่งซื้อ</b></h3>
			</h3>
		</div>

		<div class="card-body">
			<div class="table-responsive">
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
							<!-- โหลดข้อมูล -->
							<td style="text-align:center;">[{record_number}]</td> <!-- # -->
							<td>{detail_id}</td> <!-- id -->
							<td>{detail_pob_ref}</td> <!-- อ้างอิงใบสั่งซื้อ -->
							<td>{detailPobPrIdRefPrRef}</td> <!-- อ้างอิง id ใบเสนอซื้อ -->
							<td>{detail_pob_id}</td> <!-- หมายเลขสินค้า -->
							<td>{detailPobNamePrbName}</td> <!-- รายการสินค้า -->
							<td>{detail_pob_price}</td> <!-- ราคาสินค้า -->
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
			</div>


		</div>
		<br />
		<div class="col-sm-12 col-md-12">
			<div class="pull-right text-right">
				<a href="{page_url}/preview_print_pdf/{recode_url_encrypt_id}" target="_blank" class="btn btn-danger btn-lg" data-toggle="tooltip" title="พิมพ์ข้อมูล">
					<i class="fas fa-file-pdf"></i></span> PDF
				</a>
				<a href="{page_url}/preview_export_excel/{recode_url_encrypt_id}" class="btn btn-success btn-lg" data-toggle="tooltip" title="ส่งออกข้อมูล">
					<i class="fas fa-file-excel"></i></span> Excel
				</a>
			</div>
		</div>
		<hr />
	</div>