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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>ใบเสนอราคา</b></h3>
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
		</div>
	</div>
	<br />
	<div class="card">

		<div class="card-header bg-info">
			<h3 class="card-title">ตารางรายการ <b>tb_quotation_list</b></h3>
			</h3>
		</div>

		<div class="card-body">
			<div class="table-responsive">
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
					<!-- <tfoot class="thead-light"> //ของเดิม
						<tr>
							<th class="text-center" colspan="8">รวมทั้งสิ้น</th>
							<th class="text-right">{fx_detail_grand_total_price}</th> ค่าใหม่จากตอนแรกที่เรา generate
							<th></th>
						</tr>
					</tfoot> -->

					<tfoot>
						<!--copy มาจากเว็บ-->
						<tr>
							<th colspan="8" class="text-right">ราคาสินค้ารวมทั้งสิ้น</th>
							<th class="text-right">{total_product_price}</th>
							<!--แก้ค่าตัวแปรให้ตรงกัน ค่าของเก่าจาก web คือ {total_product_price}-->
							<th></th>
						</tr>
						<tr>
							<th colspan="8" class="text-right">ภาษีมูลค่าเพิ่ม 7%</th>
							<th class="text-right">{total_vat}</th>
							<th></th>
						</tr>
						<tr>
							<th colspan="8" class="text-right">ราคาสุทธิ</th>
							<th class="text-right">{grand_total}</th>
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