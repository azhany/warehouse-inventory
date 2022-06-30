<?php
  $page_title = 'Add Stock';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(2);
  $all_products = find_all('products');
?>
<?php
 if(isset($_POST['add_stock'])){
   $req_fields = array('product-id','product-quantity','total-cost' );
   validate_fields($req_fields);
   if(empty($errors)){
     $s_pid  = remove_junk($db->escape($_POST['product-id']));
     $s_qty   = remove_junk($db->escape($_POST['product-quantity']));
     $s_tcost  = remove_junk($db->escape($_POST['total-cost']));
     $date    = make_date();
	 
	 $stock = find_by_sql('SELECT quantity,total_cost,date FROM stocks WHERE product_id = ' . (int)$s_pid);
	 //echo '<pre>';print_r($stock);echo '</pre>';
	 //exit();
	 if(empty($stock)) {
		 $query  = "INSERT INTO stocks (";
		 $query .=" product_id,quantity,total_cost,date";
		 $query .=") VALUES (";
		 $query .=" {$s_pid}, {$s_qty}, {$s_tcost}, '{$date}'";
		 $query .=")";
		 $query .=" ON DUPLICATE KEY UPDATE product_id={$s_pid}";
		 if($db->query($query)){
		   $session->msg('s',"Stock added ");
		   redirect('product.php', false);
		 } else {
		   $session->msg('d',' Sorry failed to added!');
		   redirect('add_stock.php', false);
		 }
	 } else {
		 $query  = "UPDATE stocks";
		 $query .=" SET quantity = " . ($stock[0]['quantity']+$s_qty) . ", total_cost = " . ($stock[0]['total_cost']+$s_tcost) . ", date = '{$date}'";
		 $query .=" WHERE product_id={$s_pid}";
		 if($db->query($query)){
		   $session->msg('s',"Stock updated ");
		   redirect('product.php', false);
		 } else {
		   $session->msg('d',' Sorry failed to updated!');
		   redirect('add_stock.php', false);
		 }
	 }

   } else{
     $session->msg("d", $errors);
     redirect('add_stock.php',false);
   }

 }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
  <div class="row">
  <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add Stock</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_stock.php" class="clearfix">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <select class="form-control" name="product-id">
                      <option value="">Select Product</option>
                    <?php  foreach ($all_products as $p): ?>
                      <option value="<?php echo (int)$p['id'] ?>">
                        <?php echo $p['name'] ?></option>
                    <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>

              <div class="form-group">
               <div class="row">
                 <div class="col-md-6">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                     </span>
                     <input type="number" class="form-control" name="product-quantity" placeholder="Product Quantity">
                  </div>
                 </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <span class="input-group-addon">
                        RM
                      </span>
                      <input type="number" class="form-control" name="total-cost" placeholder="Total Cost">
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_stock" class="btn btn-danger">Add stock</button>
			  <a href="product.php" class="btn btn-default">Cancel</a>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
