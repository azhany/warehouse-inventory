<?php
  $page_title = 'All sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sales = find_all_sale();
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>All Sales</span>
          </strong>
          <div class="pull-right">
            <a href="add_sale.php" class="btn btn-primary">Add sale</a>
          </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th class="text-center" style="width: 50px;">#</th>
                <th style="width: 20%;"> Details </th>
                <th style="width: 20%;"> Shipping Address</th>
                <th style="width: 20%;"> Amount </th>
				        <th class="text-center" style="width: 10%;"> Payment Method </th>
				        <th class="text-center" style="width: 20%;"> Notes </th>
                <th class="text-center" style="width: 10%;"> Date </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
             </tr>
            </thead>
           <tbody>
             <?php foreach ($sales as $sale):?>
             <tr>
               <td class="text-center"><?php echo count_id();?></td>
               <td>
      			   <?php
      					$customer = find_by_id('customers',$sale['customer_id']);
      					echo '<strong>Customer</strong> : ' . $customer['name'] . '<br /><br />';
      					$details = json_decode($sale['details'],true);
      					$products = array();
      					foreach($details as $detail) {
      						$product = find_by_id('products',$detail['product_id']);
      						echo '<strong>Product</strong> : ' . $product['name'] . '<br />';
      						echo '<strong>Price</strong> : RM' . $detail['price'] . '<br />';
      						echo '<strong>Quantity</strong> : ' . $detail['quantity'] . '<br />';
      						echo '<strong>Total</strong> : RM' . $detail['total'] . '<hr />';
      					}
      			   ?>
      			   </td>
               <td><?php echo remove_junk($sale['shipping_address']); ?></td>
               <td>
      					<strong>Sub Total</strong> : RM<?php echo remove_junk($sale['subtotal']); ?><br />
      					<strong>Discount</strong> : <?php echo remove_junk($sale['discount']); ?>%<br />
      					<strong>Grand Total</strong> : RM<?php echo remove_junk($sale['grandtotal']); ?>
      			   </td>
      			   <td class="text-center"><?php echo remove_junk($sale['payment_method']); ?></td>
      			   <td class="text-center"><?php echo remove_junk($sale['notes']); ?></td>
               <td class="text-center"><?php echo $sale['date']; ?></td>
               <td class="text-center">
                  <div class="btn-group">
                     <a href="edit_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-warning btn-xs"  title="Edit" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-edit"></span>
                     </a>
                     <a href="delete_sale.php?id=<?php echo (int)$sale['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                       <span class="glyphicon glyphicon-trash"></span>
                     </a>
                  </div>
               </td>
             </tr>
             <?php endforeach;?>
           </tbody>
         </table>
        </div>
      </div>
    </div>
  </div>
<?php include_once('layouts/footer.php'); ?>
