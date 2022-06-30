<?php
  $page_title = 'Add Sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
  $customers = find_all_customers();
?>
<?php

  if(isset($_POST['add_sale'])){
    //$req_fields = array('s_id','quantity','price','total', 'date' );
    //validate_fields($req_fields);
        //if(empty($errors)){
		  /*
          $p_id               = $db->escape((int)$_POST['s_id']);
          $s_qty              = $db->escape((int)$_POST['quantity']);
          $s_total            = $db->escape($_POST['total']);
		  */
		  $pid = array();
		  $sub_s = array();
		  $total_qty = 0;
		  if(count($_POST['product_id']) > 0) {
			  for($i = 0;$i < sizeof($_POST['product_id']);$i++) {
				$pid[]      = $db->escape((int)$_POST['product_id']);
				$sub_s[]    = array(
									'product_id' => $db->escape((int)$_POST['product_id'][$i]),
									'quantity'   => $db->escape((int)$_POST['quantity'][$i]),
									'price'      => $db->escape((int)$_POST['price'][$i]),
									'total'      => $db->escape((int)$_POST['total'][$i])
								);
				
				$total_qty += (int)$_POST['quantity'][$i];
			  }
		  }
		  
		  $s_product_ids      = json_encode($pid);
		  $s_details          = json_encode($sub_s);
		  $s_totalqty         = (int)$total_qty;
		  $s_subtotal         = $db->escape($_POST['subtotal']);
		  $s_discount         = $db->escape($_POST['discount']);
		  $s_grandtotal       = $db->escape($_POST['grandtotal']);
		  $s_customer_id      = (int)$_POST['customer'];
		  $s_shipping_address = $db->escape($_POST['shipping_address']);
		  $s_shipping_note    = $db->escape($_POST['shipping_note']);
		  $s_payment_method   = $db->escape($_POST['payment_method']);
          $s_date             = $db->escape($_POST['date']);

          $sql  = "INSERT INTO sales (";
          $sql .= " customer_id,details,total_qty,subtotal,discount,grandtotal,shipping_address,notes,payment_method,date";
          $sql .= ") VALUES (";
          $sql .= "{$s_customer_id},'{$s_details}',{$s_totalqty},'{$s_subtotal}','{$s_discount}','{$s_grandtotal}','{$s_shipping_address}','{$s_shipping_note}','{$s_payment_method}','{$s_date}'";
          $sql .= ")";

			if($db->query($sql)){
			  foreach($sub_s as $subsale) {
				update_product_qty($subsale['quantity'],$subsale['product_id']);
			  }
			  
			  $session->msg('s',"Sale added. ");
			  redirect('sales.php', false);
			} else {
			  $session->msg('d',' Sorry failed to add!');
			  redirect('add_sale.php', false);
			}
			
        /*} else {
           $session->msg("d", $errors);
           redirect('add_sale.php',false);
        }*/
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
    <form method="post" action="ajax.php" autocomplete="off" id="sug-form">
        <div class="form-group">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Add</button>
            </span>
            <input type="text" id="sug_input" class="form-control" name="title"  placeholder="Search for product name or barcode">
         </div>
         <div id="result" class="list-group"></div>
        </div>
    </form>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading clearfix">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>Sale Add</span>
       </strong>
      </div>
      <div class="panel-body">
        <form method="post" action="add_sale.php" id="my_form">
        <div class="form-group pull-right">
          <div class="input-group">
            <input type="date" class="form-control datePicker" name="date" data-date data-date-format="yyyy-mm-dd" value="<?php echo date('Y-m-d'); ?>">
         </div>
        </div>
		 
         <table class="table table-bordered">
           <thead>
            <th> Product </th>
            <th> Qty </th>
			<th> Price </th>
            <th> Total </th>
			<th> Action </th>
           </thead>
           <tbody id="product_info"> </tbody>
         </table>
		 
		<hr />
		
		<div class="row">
			<div class="col-md-12">
				<div class="form-group pull-right">
				  <label>Customer</label>
				  <div id="cus-form">
					<div class="input-group">
						<select id="cus_input" class="form-control" name="customer">
							<option value="">Please choose...</option>
							<?php foreach($customers as $customer) { ?>
							<option value="<?php echo $customer['id'];?>"><?php echo $customer['name'];?></option>
							<?php } ?>
						</select>
						&emsp;
						<a class="btn btn-primary" href="add_customer.php">Add Customer</a>
					</div>
				  </div>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
				  <label>Shipping Address</label>
				  <textarea class="form-control" name="shipping_address" rows="4"></textarea>
				</div>
			</div>
			<div class="col-md-2"> </div>
			<div class="col-md-4">
				<div class="form-group pull-right">
				  <label>Sub Total</label>
				  <div class="input-group">
					<input type="text" class="form-control" name="subtotal" readonly="readonly" value="0.00">
				  </div>
				</div>
			</div>
			<div class="col-md-2"> </div>
		</div>
		
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
				  <label>Shipping Note</label>
				  <textarea class="form-control" name="shipping_note" rows="4"></textarea>
				</div>
			</div>
			<div class="col-md-2"> </div>
			<div class="col-md-4">
				<div class="form-group pull-right">
				  <label>Discount (%)</label>
				  <div class="input-group">
					<input type="text" class="form-control" name="discount" value="0">
				  </div>
				</div>
			</div>
			<div class="col-md-2"> </div>
		</div>
		
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
				  <label>Payment Method</label>
					<div class="input-group">
						<select class="form-control" name="payment_method">
							<option value="cash">Cash</option>
							<option value="credit_card">Credit Card</option>
							<option value="bank_transfer">Bank Transfer</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group pull-right">
				  <label>Grand Total</label>
				  <div class="input-group">
					<input type="text" class="form-control" name="grandtotal" readonly="readonly" value="0.00">
				  </div>
				</div>
			</div>
			<div class="col-md-2"> </div>
		</div>
		
		<div class="row">
			<div class="col-md-12">
				<div class="form-group pull-right">
				  <div class="input-group">
					<button type="submit" name="add_sale" class="btn btn-primary">Submit</button>
				 </div>
				</div>
			</div>
		</div>
       </form>
      </div>
    </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
