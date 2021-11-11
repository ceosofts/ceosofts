<!-- [ View File name : preview_view.php ] -->

<style>
	body {
		font-family: 'TH SarabunPSK';
		font-size : 16pt;
		margin : 0px;
	}
	table{
		width : 100%;
		border-collapse: collapse;
	}
	table { page-break-inside:auto; }
	
	th {
	   background-color:lightgrey;
	   text-align : center;
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
<h3 class="card-title">ตารางรายการ <b>tb_stock_out_list</b></h3>		<table class="table  table-bordered table-hover">
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

<br/>
