<!-- [ View File name : preview_view.php ] -->
<style>
	.table th.fit,
	.table td.fit {
		white-space: nowrap;
		width: 2%;
	}
</style>

<div class="card border-primary rounded-0">
	<div class="card-header p-0">
		<div class="bg-info text-white text-center py-2">
			<i class="fa fa-5x fa-user"></i>
			<h3>แสดงข้อมูล<b>ข้อมูลสมาชิก</b></h3>
		</div>
	</div>
	<div class="card-body p-3">
		<table class="table table-bordered table-hover">
			<thead class="well">
				<tr>
					<th class="text-right fit">หัวข้อ</th>
					<th>ข้อมูล</th>
				</tr>
			</thead>
			<tbody>
				{master_data}
				<tr>
					<td class="text-right fit"><b>USER ID :</b></td>
					<td>{userid}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ภาพประจำตัว :</b></td>
					<td>{preview_photo}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อผู้ใช้งาน :</b></td>
					<td>{username}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อ - นามสกุล:</b></td>
					<td>{prefix_text} {firstname} {lastname}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>สิทธิ์การใช้งาน :</b></td>
					<td>{level_text}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>อีเมล :</b></td>
					<td>{email}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>เบอร์โทรศัพท์ :</b></td>
					<td>{tel_number}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ไอดี Line :</b></td>
					<td>{line_id}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อหน่วยงาน :</b></td>
					<td>{departmentIdDepartmentName}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>วันที่เพิ่มข้อมูล :</b></td>
					<td>{create_datetime}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ผู้เพิ่มข้อมูล :</b></td>
					<td>{createUserIdFullname} {createUserIdLastname}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>วันที่แก้ไขล่าสุด :</b></td>
					<td>{modify_datetime}</td>
				</tr>
				<tr>
					<td class="text-right fit"><b>ชื่อผู้แก้ไขข้อมูลล่าสุด :</b></td>
					<td>{modifyUserIdFullname} {modifyUserIdLastname}</td>
				</tr>
				{/master_data}
			</tbody>
		</table>
	</div>
</div>