<?php
  $page_title = 'Edit product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
?>
<?php
$customer = find_by_id('customers',(int)$_GET['id']);
//$all_categories = find_all('categories');
if(!$customer){
  $session->msg("d","Missing customer id.");
  redirect('customer.php');
}
?>
<?php
 if(isset($_POST['customer'])){
    $req_fields = array('customer-name','customer-code','customer-phone','customer-address' );
    validate_fields($req_fields);

   if(empty($errors)){
       $c_name  = remove_junk($db->escape($_POST['customer-name']));
	   $c_code   = remove_junk($db->escape($_POST['customer-code']));
       $c_phone   = remove_junk($db->escape($_POST['customer-phone']));
       $c_addr  = remove_junk($db->escape($_POST['customer-address']));
	   $c_email  = remove_junk($db->escape($_POST['customer-email']));
       $query   = "UPDATE customers SET";
       $query  .=" name ='{$c_name}', code ='{$c_code}',";
       $query  .=" phone ='{$c_phone}', address ='{$c_address}',email='{$c_email}'";
       $query  .=" WHERE id ='{$customer['id']}'";
       $result = $db->query($query);
               if($result && $db->affected_rows() === 1){
                 $session->msg('s',"Customer updated ");
                 redirect('customer.php', false);
               } else {
                 $session->msg('d',' Sorry failed to updated!');
                 redirect('edit_customer.php?id='.$customer['id'], false);
               }

   } else{
       $session->msg("d", $errors);
       redirect('edit_customer.php?id='.$customer['id'], false);
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
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Customer</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-7">
           <form method="post" action="edit_customer.php?id=<?php echo (int)$customer['id'] ?>">
              <div class="form-group">
			         <label for="code">Customer Name</label>
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-name" value="<?php echo remove_junk($customer['name']);?>">
               </div>
              </div>

              <div class="form-group">
               <div class="row">
        				 <div class="col-md-6">
        				  <div class="form-group">
        				   <label for="code">Customer Code</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-list"></i>
                     </span>
                     <input type="text" class="form-control" name="customer-code" value="<?php echo remove_junk($customer['code']);?>">
                   </div>
				          </div>
                 </div>
                  <div class="col-md-6">
                   <div class="form-group">
                     <label for="selling_price">Customer Phone</label>
                     <div class="input-group">
                       <span class="input-group-addon">
                         +6
                       </span>
                       <input type="number" class="form-control" name="customer-phone" value="<?php echo remove_junk($customer['phone']);?>">
                    </div>
                   </div>
                  </div>
               </div>
              </div>
			  
			       <div class="form-group">
               <div class="row">
        				 <div class="col-md-6">
        				   <label for="code">Customer Address</label>
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-home"></i>
                     </span>
                     <textarea class="form-control" name="customer-address" rows="4"><?php echo remove_junk($customer['address']);?></textarea>
                  </div>
                 </div>
                  <div class="col-md-6">
				            <label for="code">Customer Email</label>
                    <div class="input-group">
					           <span class="input-group-addon">
                       <i class="glyphicon glyphicon-envelope"></i>
                      </span>
                      <input type="text" class="form-control" name="customer-email" value="<?php echo remove_junk($customer['email']);?>">
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="customer" class="btn btn-danger">Update</button>
			         <a href="customer.php" class="btn btn-default">Cancel</a>
          </form>
         </div>
        </div>
      </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
