<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="งานบัญชีครบจบที่เดียว">
	<meta name="author" content="">

	<!-- Favicon -->
	<link rel="icon" href="assets/images/ceo_logo9.ico" type="image/x-icon">
	<link rel="shortcut icon" href="assets/images/ceo_logo9.ico" type="image/x-icon">
	<link rel="apple-touch-icon" href="ceo_logo9.ico">
	<!-- social network metas -->
	<meta property="og:type" content="website" />
	<meta property="og:title" content="CEO softs งานบัญชีครบจบที่เดียว" />
	<meta property="og:url" content="https://www.ceosofts.com" />
	<meta property="image" content="ceo_logo9.ico" />
	<meta property="og:image" content="assets/images/2021-10-14.png" />
	<meta property="site_name" content="CEO Softs" />
	<meta property="description" content="program accounting online &amp; งานบัญชีครบจบที่เดียว" />

	<title>CEO Softs</title>

	<!-- Bootstrap core CSS-->
	<link href="{base_url}assets/themes/sb-admin-bs4/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom fonts for this template-->
	<link href="{base_url}assets/themes/sb-admin-bs4/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

	<!-- Page level plugin CSS-->
	<link href="{base_url}assets/themes/sb-admin-bs4/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

	<!-- Custom styles for this template-->
	<link href="{base_url}assets/themes/sb-admin-bs4/css/sb-admin.css" rel="stylesheet">

	<!-- Require -->
	<link href="{base_url}assets/bootstrap_extras/select2/select2.css" rel="stylesheet">
	<link href="{base_url}assets/css/jquery-ui.min.css" rel="stylesheet">

	{another_css}

	<style>
		div[data-notify="container"] {
			z-index: 3000 !important;
		}

		#exampleAccordion {
			overflow-y: auto;
			overflow-x: hidden;
		}

		.content-wrapper {
			overflow-x: auto;
		}

		.card .bg-primary .card-title {
			color: white;
		}

		div.alert span[data-notify="message"] p {
			margin-bottom: 0px !important;
		}

		.upload-box .btn-file {
			background-color: #22b5c0;
		}

		.upload-box .hold {
			float: left;
			width: 100%;
			position: relative;
			border: 1px solid #ccc;
			border-radius: 3px;
			padding: 4px;
		}

		.upload-box .hold span {
			font: 400 14px/36px 'Roboto', sans-serif;
			color: #666;
			text-decoration: none;
		}

		.upload-box .btn-file {
			position: relative;
			overflow: hidden;
			float: left;
			padding: 2px 10px;
			font: 900 14px/14px 'Roboto', sans-serif;
			color: #fff !important;
			margin: 0 10px 0 0;
			text-transform: uppercase;
			border-radius: 3px;
			cursor: pointer;
		}

		.upload-box .btn-file input[type=file] {
			position: absolute;
			top: 0;
			right: 0;
			min-width: 100%;
			min-height: 100%;
			font-size: 100px;
			text-align: right;
			opacity: 0;
			outline: none;
			background: #fd0707;
			cursor: inherit;
			display: block;
		}

		.div_file_preview {
			background-color: #fefcfc;
			border: 1px dashed #ccc;
		}

		.select2-container .select2-choice {
			height: 38px;
			line-height: 36px;
		}

		.select2-container .select2-choice .select2-arrow b {
			background-position: 0 5px;
		}
	</style>

	<script>
		var baseURL = '{base_url}/';
		var siteURL = '{site_url}/';
		var csrf_token_name = '{csrf_token_name}';
		var csrf_cookie_name = '{csrf_cookie_name}';
	</script>
</head>

<body id="page-top">

	<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

		<a class="navbar-brand mr-1" href="{site_url}/Dashboard">รายงาน</a>

		<button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
			<i class="fas fa-bars"></i>
		</button>

		<!-- Navbar -->
		{top_navbar}

	</nav>

	<div id="wrapper">

		<!-- Sidebar -->
		{left_sidebar}

		<div id="content-wrapper">

			<div class="container-fluid">

				<!-- Breadcrumbs-->
				{breadcrumb_list}

				<!-- Page Content -->
				{page_content}

			</div>
			<!-- /.container-fluid -->

			<!-- Sticky Footer -->
			<footer class="sticky-footer">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright CEO Softs 2021</span>
					</div>
				</div>
			</footer>

		</div>
		<!-- /.content-wrapper -->

	</div>
	<!-- /#wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">คลิกปุ่ม "Logout" เพื่อสิ้นสุดการทำงาน.</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<a class="btn btn-primary" href="{site_url}/member_login/destroy">Logout</a>
				</div>
			</div>
		</div>
	</div>


	<!-- Change Password Modal-->
	<div class="modal fade" id="modal_change_pass" tabindex="-1" role="dialog" aria-labelledby="modal_change_pass_Label" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<h4 class="modal-title" id="modal_change_pass_Label">เปลี่ยนรหัสผ่าน</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>

				</div> <!-- /.modal-header -->

				<div class="modal-body">
					<form role="form" id="formChangePass">
						<div class="form-group">
							<div class="input-group">
								<input class="form-control" id="resetPassword1" name="resetPassword1" placeholder="รหัสผ่านใหม่" type="password">
								<label for="resetPassword1" class="input-group-addon glyphicon glyphicon-lock new"></label>
							</div>
						</div> <!-- /.form-group -->

						<div class="form-group">
							<div class="input-group">
								<input class="form-control" id="resetPassword2" name="resetPassword2" placeholder="ยืนยันรหัสผ่านใหม่อีกครั้ง" type="password">
								<label for="resetPassword2" class="input-group-addon glyphicon glyphicon-lock new"></label>
							</div> <!-- /.input-group -->
						</div> <!-- /.form-group -->

						<div class="form-group">
							<div class="input-group">
								<input class="form-control" id="uPasswordOld" name="uPasswordOld" placeholder="รหัสผ่านเดิม" type="password">
								<label for="uPasswordOld" class="input-group-addon glyphicon glyphicon-lock"></label>
							</div> <!-- /.input-group -->
						</div> <!-- /.form-group -->

					</form>

				</div> <!-- /.modal-body -->

				<div class="modal-footer">
					<button id="btn_change_pass" class="form-control btn btn-primary">Ok</button>

					<div class="progress">
						<div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="1" aria-valuemin="1" aria-valuemax="100" style="width: 0%;">
							<span class="sr-only">progress</span>
						</div>
					</div>
				</div> <!-- /.modal-footer -->

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="{base_url}assets/themes/sb-admin-bs4/vendor/jquery/jquery.min.js"></script>
	<script src="{base_url}assets/themes/sb-admin-bs4/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="{base_url}assets/themes/sb-admin-bs4/vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Page level plugin JavaScript-->
	<script src="{base_url}assets/themes/sb-admin-bs4/vendor/datatables/jquery.dataTables.js"></script>
	<script src="{base_url}assets/themes/sb-admin-bs4/vendor/datatables/dataTables.bootstrap4.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="{base_url}assets/themes/sb-admin-bs4/js/sb-admin.min.js"></script>

	<!-- Require -->
	<script src="{base_url}assets/js/jquery-ui.min.js"></script>
	<script src="{base_url}assets/bootstrap_extras/bootstrap-notify.min.js"></script>
	<script src="{base_url}assets/bootstrap_extras/select2/select2.min.js"></script>
	<script src="{base_url}assets/js/jquery.cookie.min.js"></script>
	<script src="{base_url}assets/js/ci_utilities.js?ver={utilities_file_time}"></script>

	<script src="{base_url}assets/js/member_reset_pass.js"></script>
	{another_js}
</body>

</html>