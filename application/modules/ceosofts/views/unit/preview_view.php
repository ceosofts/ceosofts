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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>หน่วยนับ</b></h3>
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
						<td class="text-right fit"><b>หมายเลขหน่วยนับ :</b></td>
						<td>{record_unit_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อหน่วยนับ :</b></td>
						<td>{record_unit_name}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>