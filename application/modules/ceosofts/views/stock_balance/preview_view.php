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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>สถานะเช็คยอดสินค้า</b></h3>
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
						<td class="text-right fit"><b>หมายเลขเอกสารเช็คยอดสินค้า :</b></td>
						<td>{record_stb_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่เช็คยอดสินค้า :</b></td>
						<td>{record_stb_date}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเหตุ :</b></td>
						<td>{record_stb_remark}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
	<br />
	<div class="card">

		<div class="card-header bg-info">
			<h3 class="card-title">ตารางรายการ <b>tb_stock_balance_list</b></h3>
			</h3>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table  table-bordered table-hover">
					<thead class="thead-light">
						<tr>
							<th width="20px;">#</th>
							<th>Id</th>
							<th>อ้างอิงใบ stock balance</th>
							<th>หมายเลขสินค้า</th>
							<th>ชื่อสินค้า</th>
							<th>หน่วยสินค้า</th>
							<th>จำนวน</th>
							<th>สถานะ</th>
							<th>หมายเหตุ</th>
							<th>วันที่แก้ไข</th>
						</tr>
					</thead>
					<tbody>
						<tr parser-repeat="[detail_list]" id="row_{record_number}">
							<td style="text-align:center;">[{record_number}]</td>
							<td>{detail_id}</td>
							<td>{detail_stb_pr_ref}</td>
							<td>{detail_stb_no}</td>
							<td>{detailStbProductNamePrbName}</td>
							<td>{detail_stb_unit}</td>
							<td>{detail_stb_qty}</td>
							<td>{detailStbStatusStoStastusName}</td>
							<td>{detail_stb_remark}</td>
							<td>{detail_stb_edit_date}</td>
						</tr>
					</tbody>
				</table>
			</div>


		</div>
		<br />
	</div>