<!-- Navbar Search -->
<!-- <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
    <div class="input-group">
        <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
        <div class="input-group-append">
            <button class="btn btn-primary" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form> -->

<!-- Navbar -->
<ul class="navbar-nav ml-auto ml-md-0">
	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" href="<?php echo site_url('') ?>" title="Home Page" role="button" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-bell fa-home"></i>
			<!-- <span class="badge badge-danger">9+</span> -->
		</a>
		<!-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Something else here</a>
		</div> -->
	</li>

	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" href="#" title="แจ้งเตือน" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-bell fa-fw"></i>
			<!-- <span class="badge badge-danger">9+</span> -->
		</a>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="alertsDropdown">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Something else here</a>
		</div>
	</li>

	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" href="#" title="จดหมาย" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-envelope fa-fw"></i>
			<!-- <span class="badge badge-danger">7</span> -->
		</a>
		<div class="dropdown-menu dropdown-menu-right" aria-labelledby="messagesDropdown">
			<a class="dropdown-item" href="#">Action</a>
			<a class="dropdown-item" href="#">Another action</a>
			<div class="dropdown-divider"></div>
			<a class="dropdown-item" href="#">Something else here</a>
		</div>
	</li>

	<li class="nav-item dropdown no-arrow">
		<a class="nav-link {login_inactive_class}" title="ล็อกอินเข้าใช้งาน" href="{site_url}/member/login">
			<i class="fas fa-user-circle fa-fw"></i>
		</a>

		<a class="nav-link dropdown-toggle {login_active_class}" href="{site_url}/member/profile" title="ข้อมูลสมาชิก" role="button" aria-haspopup="true" aria-expanded="false">
			<i class="fas fa-user"></i>
		</a>
	</li>

	<li class="nav-item dropdown no-arrow mx-1">
		<a class="nav-link dropdown-toggle" aria-haspopup="true" aria-expanded="false">
			สวัสดี <b> {user_username} </b> > {user_firstname} {user_lastname}
		</a>
	</li>

</ul>