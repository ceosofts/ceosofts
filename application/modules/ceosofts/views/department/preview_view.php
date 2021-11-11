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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>แผนก / ฝ่าย / สังกัด</b></h3>
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
						<td class="text-right fit"><b>หมายเลขแผนก :</b></td>
						<td>{record_dpm_number}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>แผนก :</b></td>
						<td>{record_dpm_name}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สถานะ :</b></td>
						<td>{preview_dpm_void}</td>
					</tr>

				</tbody>
			</table>
		</div>
	</div>
</div>