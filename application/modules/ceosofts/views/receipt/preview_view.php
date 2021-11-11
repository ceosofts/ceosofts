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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>ใบเสร็จรับเงิน</b></h3>
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
						<td class="text-right fit"><b>หมายเลขใบเสร็จรับเงิน :</b></td>
						<td>{record_rec_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>อ้างอิงหมายเลขใบวางบิล :</b></td>
						<td>{recInvNumberRefInvId}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ใบเสร็จรับเงิน :</b></td>
						<td>{record_rec_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อลูกค้า :</b></td>
						<td>{recCusCusName} {recCusCusContact} {recCusCusAddress} {recCusCusTel} {recCusCusTax} {recCusCusBranch}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
						<td>{record_rec_project_name}</td>
					</tr>
					<!-- <tr>
						<td class="text-right fit"><b>ยอดตามใบวางบิล :</b></td>
						<td>{record_rec_price}</td>
					</tr> -->

					<tr>
						<td class="text-right fit"><b>ยอดตามใบวางบิล :</b></td>
						<td>{record_rec_price}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ภาษีมูลค่าเพิ่ม 7% :</b></td>
						<td>{total_vat}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ยอดสุทธิ :</b></td>
						<td>{grand_total}</td>
					</tr>


					<!-- copy มาจากเว็บ -->
					<!-- <tr>
						<th colspan="7" class="text-right">ราคาสินค้ารวมทั้งสิ้น</th>
						<th class="text-right">{total_product_price}</th>
						<th></th>
					</tr>
					<tr>
						<th colspan="7" class="text-right">ภาษีมูลค่าเพิ่ม 7%</th>
						<th class="text-right">{total_vat}</th>
						<th></th>
					</tr>
					<tr>
						<th colspan="7" class="text-right">ราคาสุทธิ</th>
						<th class="text-right">{grand_total}</th>
						<th></th>
					</tr> -->


					<tr>
						<td class="text-right fit"><b>สถานะ :</b></td>
						<td>{recStatusStrName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td>{record_rec_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ทำเอกสาร :</b></td>
						<td>{record_rec_create_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้แก้ไข :</b></td>
						<td>{record_rec_edit_by}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
						<td>{record_rec_edit_date}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
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