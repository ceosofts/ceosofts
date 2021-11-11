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

<h3 class="card-title"><i class="fa fa-list-alt"></i> ตารางแสดงรายการ ข้อมูล <b>ผู้ใช้งานโปรแกรม</b></h3>
<table border="0.1" cellpadding="2">
	<thead class="info">
		<tr bgcolor="#dddddd">
			<th width="20px;">#</th>
			<th>หมายเลขผู้ใช้</th>
			<th>ชื่อผู้ใช้งาน</th>
			<th>รหัสผ่าน</th>
			<th>รหัสยืนยันสมาชิก</th>
			<th>อีเมล</th>
			<th>คำนำหน้า</th>
			<th>ชื่อ</th>
			<th>นามสกุล</th>
			<th>เพศ</th>
			<th>วันเกิด</th>
			<th>เบอร์โทรศัพท์</th>
			<th>ไอดี Line</th>
			<th>สิทธิ์การใช้งาน</th>
			<th>แผนก/ฝ่าย</th>
			<th>การรับข่าวสาร</th>
			<th>สถานะการใช้งาน</th>
		</tr>
	</thead>
	<tbody>
		<tr parser-repeat="[data_list]" id="row_{record_number}">
			<td width="20px;">[{record_number}]</td>
			<td>{user_id}</td>
			<td>{username}</td>
			<td>{password}</td>
			<td>{referral_code}</td>
			<td>{email}</td>
			<td>{prefixPrefixName}</td>
			<td>{firstname}</td>
			<td>{lastname}</td>
			<td>{preview_sex}</td>
			<td>{birthday}</td>
			<td>{tel_number}</td>
			<td>{line_id}</td>
			<td>{levelLevelTitle}</td>
			<td>{departmentIdDpmName}</td>
			<td>{preview_unsubscribe}</td>
			<td>{voidDpmName}</td>
		</tr>
	</tbody>
</table>