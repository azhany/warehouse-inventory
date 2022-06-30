<?php
  $page_title = 'Edit sale';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$sale = find_by_id('sales',(int)$_GET['id']);
if(!$sale){
  $session->msg("d","Missing sale id.");
  redirect('sales.php');
}
?>
<?php

  if(isset($_POST['update_sale'])){
    //$req_fields = array('title','quantity','price','total', 'date' );
    //validate_fields($req_fields);
        //if(empty($errors)){
		  /*
          $p_id      = $db->escape((int)$product['id']);
          $s_qty     = $db->escape((int)$_POST['quantity']);
          $s_total   = $db->escape($_POST['total']);
          $date      = $db->escape($_POST['date']);
          $s_date    = date("Y-m-d", strtotime($date));
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
		  $s_subtotal         = $db->escape($_POST['sub_total']);
		  $s_discount         = $db->escape($_POST['discount']);
		  $s_grandtotal       = $db->escape($_POST['grand_total']);
		  $s_customer_id      = (int)$_POST['customer'];
		  $s_shipping_address = $db->escape($_POST['shipping_address']);
		  $s_shipping_note    = $db->escape($_POST['notes']);
		  $s_payment_method   = $db->escape($_POST['payment_method']);
          $s_date             = $db->escape($_POST['date']);
				  
          $sql  = "UPDATE sales SET ";
          $sql .= "customer_id={$s_customer_id},details='{$s_details}',total_qty={$s_totalqty},subtotal='{$s_subtotal}',discount='{$s_discount}',grandtotal='{$s_grandtotal}',shipping_address='{$s_shipping_address}',notes='{$s_shipping_note}',payment_method='{$s_payment_method}',date='{$s_date}'";
          $sql .= " WHERE id ='{$sale['id']}'";
		  $result = $db->query($sql);
		  
          if( $result && $db->affected_rows() === 1){
			//update_product_qty($s_qty,$p_id);
			
			  foreach($sub_s as $subsale) {
				update_product_qty($subsale['quantity'],$subsale['product_id']);
			  }
			
			$session->msg('s',"Sale updated.");
			redirect('edit_sale.php?id='.$sale['id'], false);
		  } else {
			$session->msg('d',' Sorry failed to updated!');
			redirect('sales.php', false);
		  }

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
           redirect('edit_sale.php?id='.(int)$sale['id'],false);
        }*/
  }

?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
  <div class="col-md-6">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">

  <div class="col-md-12">
  <div class="panel">
    <div class="panel-heading clearfix">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>All Sales</span>
     </strong>
     <div class="pull-right">
       <a href="sales.php" class="btn btn-primary">Show all sales</a>
     </div>
    </div>
    <div class="panel-body">
       <table class="table table-bordered">
         <thead>
          <th> Details </th>
          <th> Shipping Address </th>
          <th> Amount </th>
          <th> Payment Method </th>
		      <th> Notes </th>
          <th> Date</th>
          <th> Action</th>
         </thead>
           <tbody  id="product_info">
              <tr>
        			  <form method="post" action="edit_sale.php?id=<?php echo (int)$sale['id']; ?>">
                  <td>
          			   <?php
          					$customer = find_by_id('customers',$sale['customer_id']);
          					$customers = find_all('customers');
          					$select = '<select class="form-control" name="customer">';
          					foreach($customers as $cus) {
          						$selected = '';
          						if($cus['id'] == $sale['customer_id'])
          							$selected = 'selected';
          						
          						$select .= '<option value="' . $cus['id'] . '" '.$selected.'>' . $cus['name'] . '</option>';
          					}
          					$select .= '</select>';
          					echo '<strong>Customer</strong> : ' . $select . '<br /><br />';
          					$details = json_decode($sale['details'],true);
          					$products = array();
          					foreach($details as $detail) {
          						$product = find_by_id('products',$detail['product_id']);
          						echo '<input type="hidden" name="product_id[]" value="' . $detail['product_id'] . '">';
          						echo '<strong>Product</strong> : <input type="text" class="form-control" readonly value="' . $product['name'] . '"><br />';
          						echo '<strong>Price</strong> : (RM) <input type="text" class="form-control" name="price[]" value="' . $detail['price'] . '"><br />';
          						echo '<strong>Quantity</strong> : <input type="text" class="form-control" name="quantity[]" value="' . $detail['quantity'] . '"><br />';
          						echo '<strong>Total</strong> : (RM) <input type="text" class="form-control" name="total[]" value="' . $detail['total'] . '"><hr>';
          					}
          			   ?>
                </td>
                <td>
                  <textarea class="form-control" name="shipping_address" rows="8"><?php echo $sale['shipping_address']; ?></textarea>
                </td>
                <td>
        					<strong>Sub Total</strong> : (RM) <input type="text" class="form-control" name="sub_total" value="<?php echo remove_junk($sale['subtotal']); ?>"><br />
        					<strong>Discount</strong> : <input type="text" class="form-control" name="discount" value="<?php echo remove_junk($sale['discount']); ?>"> (%)<br />
        					<strong>Grand Total</strong> : (RM) <input type="text" class="form-control" name="grand_total" value="<?php echo remove_junk($sale['grandtotal']); ?>">
                </td>
                <td>
                  <select class="form-control" name="payment_method">
          					<option value="cash" <?php echo ($sale['payment_method'] == 'cash') ? 'selected' : '';?>>Cash</option>
          					<option value="credit_card" <?php echo ($sale['payment_method'] == 'credit_card') ? 'selected' : '';?>>Credit Card</option>
          					<option value="bank_transfer" <?php echo ($sale['payment_method'] == 'bank_transfer') ? 'selected' : '';?>>Bank Transfer</option>
				          </select>
                </td>
				        <td>
                  <textarea class="form-control" name="notes" rows="4"><?php echo remove_junk($sale['notes']); ?></textarea>
                </td>
                <td id="s_date">
                  <input type="date" class="form-control datepicker" name="date" data-date-format="" value="<?php echo remove_junk($sale['date']); ?>">
                </td>
                <td>
                  <button type="submit" name="update_sale" class="btn btn-primary">Update sale</button>
                </td>
              </form>
              </tr>
           </tbody>
       </table>

    </div>
  </div>
  </div>

</div>

<?php include_once('layouts/footer.php'); ?>
