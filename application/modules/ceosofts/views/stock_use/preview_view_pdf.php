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
						<td class="text-right fit"><b>หมายเลขสินค้า :</b></td>
						<td>{record_stu_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ใบเบิก :</b></td>
						<td>{record_stu_date}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อผู้เบิก :</b></td>
					<td>{stuUserNameEmpFname} {stuUserNameEmpPosition} {stuUserNameEmpSection}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อโครงการ :</b></td>
					<td>{stuProjectNameQuoProjectName}</td>
				</tr>
					<tr>
						<td class="text-right fit"><b>ผู้จัดทำเอกสาร :</b></td>
						<td>{record_stu_by}</td>
					</tr>
				<tr>
					<td class="text-right fit"><b>สถานะการนำไปใช้ :</b></td>
					<td>{stuStatusUseStcName}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>สถานะจำนวน :</b></td>
					<td>{stuStatusQtyStcName}</td>
				</tr>

				</tbody>
			</table>
<h3 class="card-title">ตารางรายการ <b>tb_stock_use_list</b></h3>		<table class="table  table-bordered table-hover">
			<thead class="thead-light">
				<tr>
					<th width="20px;">#</th>
					<th>Id</th>
					<th>อ้างอิงใบเบิก</th>
					<th>หมายเลขสินค้า</th>
					<th>รายการสินค้า</th>
					<th>หน่วยสินค้า</th>
					<th>จำนวน</th>
					<th>หมายเหตุ</th>
					<th>สถานะ</th>
				</tr>
			</thead>
			<tbody>
				<tr parser-repeat="[detail_list]" id="row_{record_number}">
					<td style="text-align:center;">[{record_number}]</td>
					<td>{detail_id}</td>
					<td>{detail_stu_ref}</td>
					<td>{detail_stu_id}</td>
					<td>{detail_stu_name}</td>
					<td>{detail_stu_unit}</td>
					<td>{detail_stu_qty}</td>
					<td>{detail_stu_remark}</td>
					<td>{detail_stu_status}</td>
				</tr>
			</tbody>
		</table>

<br/>
