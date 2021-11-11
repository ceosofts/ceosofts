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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>สินค้านำออก</b></h3>
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
						<td class="text-right fit"><b>หมายเลขสินค้านำออก :</b></td>
						<td>{record_sto_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ใบสินค้านำออก :</b></td>
						<td>{record_sto_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
						<td>{stoCusCusName} {stoCusCusContact} {stoCusCusAddress} {stoCusCusTel} {stoCusCusTax} {stoCusCusBranch}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
						<td>{stoProjectNameQuoProjectName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td>{record_sto_by}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
	<br />
	<div class="card">

		<div class="card-header bg-info">
			<h3 class="card-title">ตารางรายการ <b>tb_stock_out_list</b></h3>
			</h3>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table  table-bordered table-hover">
					<thead class="thead-light">
						<tr>
							<th width="20px;">#</th>
							<th>Id</th>
							<th>อ้างอิงใบส่งสินค้า</th>
							<th>หมายเลขสินค้า</th>
							<th>รายการสินค้า</th>
							<th>หน่วยสินค้า</th>
							<th>จำนวน</th>
							<th>หมายเหตุ</th>
						</tr>
					</thead>
					<tbody>
						<tr parser-repeat="[detail_list]" id="row_{record_number}">
							<td style="text-align:center;">[{record_number}]</td>
							<td>{detail_id}</td>
							<td>{detail_sto_ref}</td>
							<td>{detail_sto_id}</td>
							<td>{detailStoNamePrsName}</td>
							<td>{detail_sto_unit}</td>
							<td>{detail_sto_qty}</td>
							<td>{detail_sto_remark}</td>
						</tr>
					</tbody>
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