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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>บริษัท / องค์กร</b></h3>
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
						<td class="text-right fit"><b>หมายเลขบริษัท :</b></td>
						<td>{record_mycom_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อบริษัท :</b></td>
						<td>{record_mycom_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้ติดต่อ :</b></td>
						<td>{record_mycom_contact}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ที่อยู่ :</b></td>
						<td>{record_mycom_address}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เบอร์โทร :</b></td>
						<td>{record_mycom_tel}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>หมายเลขผู้เสียภาษี :</b></td>
						<td>{record_mycom_tax}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สาขา :</b></td>
						<td>{mycomBranchBranchName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>โลโก้ :</b></td>
						<td>{preview_mycom_logo}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่แก้ไข :</b></td>
						<td>{record_mycom_edit_date}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>