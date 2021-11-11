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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>ใบเสนอซื้อ</b></h3>
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
						<td class="text-right fit"><b>หมายเลขใบเสนอซื้อ :</b></td>
						<td>{record_pr_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ใบเสนอซื้อ :</b></td>
						<td>{record_pr_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้จำหน่าย :</b></td>
						<td>{prSupSupName} {prSupSupContact} {prSupSupAddress} {prSupSupTax} {prSupSupBranch}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
						<td>{record_pr_project_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สถานะ :</b></td>
						<td>{prStatusStqName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ราคารวม :</b></td>
						<td>{record_pr_price}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td>{record_pr_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
						<td>{record_pr_edit_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
						<td>{record_pr_edit_date}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
	<br />
	<div class="card">

		<div class="card-header bg-info">
			<h3 class="card-title">ตารางรายการ <b>tb_prs_list</b></h3>
			</h3>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table  table-bordered table-hover">
					<thead class="thead-light">
						<tr>
							<th width="20px;">#</th>
							<th>Id</th>
							<th>อ้างอิงใบเสนอซื้อ</th>
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
							<td>{detail_pr_ref}</td>
							<td>{detail_pr_id}</td>
							<td>{detailPrNamePrbName}</td>
							<td>{detail_pr_price}</td>
							<td>{detail_pr_unit}</td>
							<td>{detail_pr_qty}</td>
							<td class="text-right">{fx_detail_total_price}</td>
							<td>{detail_pr_remark}</td>
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