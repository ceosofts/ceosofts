<ul class="sidebar navbar-nav">
    <li class="nav-item active">
        <a class="nav-link" href="{site_url}/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    {admin_left_menu}
    {other_permission_menu}

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-gift"></i>
            <span>ฝ่ายขาย</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{site_url}/ceosofts/product_sale">รายการสินค้า</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/customer">รายการลูกค้า</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/quotation">ใบเสนอราคา</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/invoice">ใบแจ้งหนี้/ใบวางบิล</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการใบส่งงาน***</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/stock_out">ใบส่งของ</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/receipt">ใบเสร็จรับเงิน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/tax_receipt">ใบหักภาษี ณ ที่จ่าย</a>
            <a class=" dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการลูกค้านัดจ่าย***</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการลูกค้าค้างชำระ***</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการรอวางบิล***</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการยอดขาย***</a>
            <a class=" dropdown-item" href="{site_url}/ceosofts/tax_receipt_percent">ตั้งค่า หักภาษี</a>
            <a class=" dropdown-item" href="{site_url}/ceosofts/pay_status">ตั้งค่า การชำระเงิน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/unit">ตั้งค่า หน่วยนับสินค้า</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>ฝ่ายจัดซื้อ</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{site_url}/ceosofts/product_buy">รายการสินค้า</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/supplier">รายการผู้จัดจำหน่าย</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/prs">รายการใบเสนอซื้อ</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/pob">รายการใบสั่งซื้อ</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/pay">รายการใบสั่งจ่าย</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/payment_receipt">รายการใบเสร็จจ่ายเงิน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/payment_tax">รายการใบหักภาษี ณ ที่จ่าย</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/stock_in">รายการใบรับสินค้า</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการนัดจ่าย***</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการรอจ่าย***</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการยอดซื้อ***</a>
            <a class=" dropdown-item" href="{site_url}/ceosofts/pay_status">ตั้งค่า การชำระเงิน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/unit">ตั้งค่า หน่วยนับสินค้า</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-landmark"></i>
            <span>ฝ่ายคลังสินค้า</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{site_url}/ceosofts/stock_in">รายการใบรับสินค้า</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/stock_out">รายการใบส่งสินค้า</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/stock_balance">รายการสินค้าคงเหลือ</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/stock_use">รายการเบิกวัสดุอุปกรณ์</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-wallet"></i>
            <span>ฝ่ายการเงิน</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{site_url}/ceosofts/bank_in">รายการ ฝากเงิน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/bank_out">รายการ ถอนเงิน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/bookbank">รายการบัญชีธนาคาร</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/cheque_in">รายการนัดรับเช็ค</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/cheque_out">รายการนัดจ่ายเช็ค</a>
            <a class=" dropdown-item" href="{site_url}/ceosofts/cheque_status">ตั้งค่า สถานะเช็ค</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-users"></i>
            <span>ฝ่ายบุคคล</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{site_url}/ceosofts/employees">รายการชื่อพนักงาน</a>
            <a class="dropdown-item" href="{site_url}/example_pages/sb-admin-bs4/##">รายการลงเวลาทำงาน***</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/dayoff">รายการวันหยุด</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/employees_salary">รายการเงินเดือนพนักงาน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/employees_salary_slip">รายการสลิปเงินเดือน</a>
        </div>
    </li>

    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-cog"></i>
            <span>การตั้งค่าระบบ</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{site_url}/ceosofts/mycom">ตั้งค่า ข้อมูลบริษัท</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/branch">ตั้งค่า สาขาบริษัท</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/unit">ตั้งค่า หน่วยนับสินค้า</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/status_stock_use">ตั้งค่า สถานะการเบิก</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/status_stock_qty">ตั้งค่า สถานะการนับจำนวนr</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/members_prefix">ตั้งค่า คำนำหน้าชื่อ</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/position">ตั้งค่า ตำแหน่งพนักงาน</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/department">ตั้งค่า แผนก/ฝ่าย</a>
            <a class=" dropdown-item" href="{site_url}/ceosofts/tax_receipt_percent">ตั้งค่า หักภาษี</a>
            <a class=" dropdown-item" href="{site_url}/ceosofts/pay_status">ตั้งค่า การชำระเงิน</a>
            <a class=" dropdown-item" href="{site_url}/ceosofts/cheque_status">ตั้งค่า สถานะเช็ค</a>
            <a class="dropdown-item" href="{site_url}/member/management">ตั้งค่า User</a>
            <a class="dropdown-item" href="{site_url}/ceosofts/members_level">ตั้งค่า ระดับ User</a>
            <!-- <a class="dropdown-item" href="{site_url}/member/management">ตั้งค่า User</a> -->
        </div>
    </li>


    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-user-cog"></i>
            <span>User Setting</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
            <a class="dropdown-item" href="{site_url}/member/login">Login</a>
            <a class="dropdown-item" href="{site_url}/member/logout">Logout</a>
            <a class="dropdown-item" href="{site_url}/member/profile">ข้อมูลส่วนตัว</a>
            <!-- <a class="dropdown-item" href="{site_url}/member/regis">Register</a> -->
            <a class="dropdown-item" href="{site_url}/member/forgot_password/question">Forgot Password</a>
            <a class="dropdown-item" href="{site_url}/member/forgot_password">Reset Password by Email</a>
        </div>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{site_url}/member/login">
            <i class="fas fa-fw fa-sign-in-alt"></i>
            <span>Login</span>
        </a>
    </li>

    <li class="nav-item active">
        <a class="nav-link" href="{site_url}/member/logout">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span>
        </a>
    </li>




</ul>