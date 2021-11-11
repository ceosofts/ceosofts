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
		<h3 class="card-title"><i class="fa fa-clipboard"></i> รายละเอียด <b>ผู้ใช้งานโปรแกรม</b></h3>
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
						<td class="text-right fit"><b>หมายเลขผู้ใช้ :</b></td>
						<td>{record_user_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อผู้ใช้งาน :</b></td>
						<td>{record_username}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>รหัสผ่าน :</b></td>
						<td>{record_password}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>รหัสยืนยันสมาชิก :</b></td>
						<td>{record_referral_code}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>อีเมล :</b></td>
						<td>{record_email}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>คำนำหน้า :</b></td>
						<td>{prefixPrefixName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ชื่อ :</b></td>
						<td>{record_firstname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>นามสกุล :</b></td>
						<td>{record_lastname}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ภาพประจำตัว :</b></td>
						<td>{preview_photo}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เพศ :</b></td>
						<td>{preview_sex}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>เบอร์โทรศัพท์ :</b></td>
						<td>{record_tel_number}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>ไอดี Line :</b></td>
						<td>{record_line_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สิทธิ์การใช้งาน :</b></td>
						<td>{levelLevelTitle}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>แผนก/ฝ่าย :</b></td>
						<td>{departmentIdDpmName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>การรับข่าวสาร :</b></td>
						<td>{preview_unsubscribe}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>สถานะการใช้งาน :</b></td>
						<td>{voidDpmName}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>create_datetime :</b></td>
						<td>{record_create_datetime}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>create_user_id :</b></td>
						<td>{record_create_user_id}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>modify_datetime :</b></td>
						<td>{record_modify_datetime}</td>
					</tr>
					<tr>
						<td class="text-right fit"><b>modify_user_id :</b></td>
						<td>{record_modify_user_id}</td>
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