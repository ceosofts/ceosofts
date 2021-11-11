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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ใบหักภาษี</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขรับใบหักภาษี</th>
			<th>อ้างอิงใบสั่งจ่าย</th>
			<th>วันที่ทำเอกสารรับใบหักภาษี</th>
			<th>ชื่อผู้จำหน่าย</th>
			<th>ชื่อโครงการ</th>
			<th>ราคารวม</th>
			<th>จ่ายโดย</th>
			<th>หมายเหตุ</th>
			<th>วันที่ได้รับเอกสาร</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{pay_tax_id}</td>
			<td>{payTaxPayRefPayId}</td>
			<td>{pay_tax_date}</td>
			<td>{pay_tax_sup}</td>
			<td>{pay_tax_project_name}</td>
			<td>{pay_tax_price}</td>
			<td>{pay_tax_pay_by}</td>
			<td>{pay_tax_remark}</td>
			<td>{pay_tax_pay_date}</td>
		</tr>
	</tbody>
</table>