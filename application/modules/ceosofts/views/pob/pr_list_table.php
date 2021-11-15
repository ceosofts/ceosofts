<table class="table table-hover table-bordered">
  <thead class="thead-light">
    <tr>
      <th width="20px;">#</th>
      <th>id</th>
      <th>อ้างอิงใบสั่งซื้อ</th>
      <th>อ้างอิง id ใบเสนอซื้อ</th>
      <th>หมายเลขสินค้า</th>
      <th>รายการสินค้า</th>
      <th>ราคาสินค้า</th>
      <th>หน่วยสินค้า</th>
      <th>จำนวน</th>
      <th class="text-right">total price</th>
      <th>หมายเหตุ</th>
      <th class="text-center" style="width:200px">จัดการข้อมูล</th>
    </tr>
  </thead>
  <tbody id="tbody_detail_list">

    <?php
    $sum = 0;
    $i=1; foreach ($data as $key => $value) { ?>
      <?php
      $sum += $value['pr_price']*$value['pr_qty'];
       ?>
    <tr>
      <td><?php echo $i++; ?></td>
      <td><?php echo $value['id']; ?></td>
      <td><?php echo $value['prs_id']; ?></td>
      <td><?php echo $value['pr_ref']; ?></td>
      <td><?php echo $value['pr_id']; ?></td>
      <td><?php echo $value['pr_name']; ?></td>
      <td><?php echo $value['pr_price']; ?></td>
      <td><?php echo $value['pr_unit']; ?></td>
      <td><?php echo $value['pr_qty']; ?></td>
      <td><?php echo number_format($value['pr_price']*$value['pr_qty'],2); ?></td>
      <td><?php echo $value['pr_remark']; ?></td>
      <td>
        <div class="btn-group pull-right">
          <button class="btn-edit-list-row my-tooltip btn btn-warning btn-sm" data-toggle="tooltip" title="แก้ไขข้อมูล" data-id="{detail_encrypt_id}" data-row-number="{record_number}" data-url-encrypt-id="{detail_url_encrypt_id}">
            <i class="fa fa-edit"></i> แก้ไข
          </button>
          <a href="javascript:void(0);" class="btn-delete-list-row my-tooltip btn btn-danger btn-sm" data-toggle="tooltip" title="ลบรายการนี้" data-id="{detail_encrypt_id}" data-row-number="{record_number}">
            <i class="fa fa-trash"></i> ลบ
          </a>
        </div>
      </td>
    </tr>
  <?php } ?>
  </tbody>
  <tfoot id="tfoot_detail_list" class="thead-light">
    <tr>
      <th class="text-center" colspan="9">รวมทั้งสิ้น </th>
      <th id="fx_detail_grand_ราคารวม" class="text-right"><?php echo number_format($sum,2); ?></th>
      <th></th>
      <th></th>
    </tr>
  </tfoot>
</table>
