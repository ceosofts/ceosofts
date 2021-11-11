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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>พนักงาน</b></h3>
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
						<td class="text-right fit"><b>หมายเลขพนักงาน :</b></td>
						<td>{record_emp_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>คำนำหน้าชื่อ :</b></td>
						<td>{empTitleNamePrefixName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อพนักงาน :</b></td>
						<td>{record_emp_fname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>นามสกุลพนักงาน :</b></td>
						<td>{record_emp_lname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เลขบัตรประชาชน :</b></td>
						<td>{record_emd_id_card}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>รูปพนักงาน :</b></td>
						<td>{preview_emp_photo}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เพศ :</b></td>
						<td>{preview_emp_sex}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่เกิด :</b></td>
						<td>{record_emp_birthday}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>อายุ :</b></td>
						<td>{record_emp_age}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ตำแหน่งพนักงาน :</b></td>
						<td>{empPositionPositionName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>แผนกพนักงาน :</b></td>
						<td>{empSectionDpmName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เบอร์โทรศัพท์ :</b></td>
						<td>{record_emp_tel}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่เริ่มงาน :</b></td>
						<td>{record_emp_start}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>อายุงาน :</b></td>
						<td>{record_emp_time}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>วันที่ลาออก :</b></td>
						<td>{record_emp_end}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>จำนวนวันลาพักร้อน :</b></td>
						<td>{record_emp_holiday_max}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>จำนวนวันที่ลาพักร้อนแล้ว :</b></td>
						<td>{record_emp_holiday_off}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>จำนวนวันหยุด :</b></td>
						<td>{record_emp_dayoff_day}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>จำนวนวันที่หยุดแล้ว :</b></td>
						<td>{record_emp_dayoff_off}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>โรงพยาบาลประกันสังคม :</b></td>
						<td>{record_emp_ss}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สวัสดิการเพิ่มเติม :</b></td>
						<td>{record_emp_welfare}</td>
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