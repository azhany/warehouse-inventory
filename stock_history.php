<?php
  $page_title = 'Stock History';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  
  $stock_history = find_stock_by_product_id((int)$_GET['product_id']);
?>
<?php include_once('layouts/header.php'); ?>

  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
  </div>
   <div class="row">
    <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Stock History</span>
       </strong>
	   <div class="pull-right" style="margin-top:-6px;">
           <a href="product.php" class="btn btn-primary">List All Products</a>
       </div>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
					         <th>Product</th>
                    <th>Quantity</th>
					         <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($stock_history as $sh):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($sh['name'])); ?></td>
					         <td><?php echo remove_junk(number_format($sh['quantity'],2)); ?></td>
					         <td>RM <?php echo remove_junk(number_format($sh['total_cost'],2,'.',',')); ?></td>

                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
       </div>
    </div>
    </div>
   </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
