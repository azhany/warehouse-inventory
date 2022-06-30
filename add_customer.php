<?php
  $page_title = 'Add Customer';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(3);
  //$all_categories = find_all('categories');
?>
<?php
 if(isset($_POST['add_customer'])){
   $req_fields = array('customer-name','customer-code','customer-phone','customer-address' );
   validate_fields($req_fields);
   if(empty($errors)){
     $c_name  = remove_junk($db->escape($_POST['customer-name']));
	 $c_code   = remove_junk($db->escape($_POST['customer-code']));
     $c_phone   = remove_junk($db->escape($_POST['customer-phone']));
     $c_addr  = remove_junk($db->escape($_POST['customer-address']));
	 $c_email  = remove_junk($db->escape($_POST['customer-email']));
     $date    = make_date();
     $query  = "INSERT INTO customers (";
     $query .=" name,code,phone,address,email,date";
     $query .=") VALUES (";
     $query .=" '{$c_name}', '{$c_code}', '{$c_phone}', '{$c_addr}', '{$c_email}', '{$date}'";
     $query .=")";
     $query .=" ON DUPLICATE KEY UPDATE name='{$c_name}'";
     if($db->query($query)){
       $session->msg('s',"Customer added ");
       redirect('customer.php', false);
     } else {
       $session->msg('d',' Sorry failed to added!');
       redirect('add_customer.php', false);
     }

   } else{
     $session->msg("d", $errors);
     redirect('add_customer.php',false);
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
            <span>Add New Customer</span>
         </strong>
        </div>
        <div class="panel-body">
         <div class="col-md-12">
          <form method="post" action="add_customer.php" class="clearfix">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">
                   <i class="glyphicon glyphicon-th-large"></i>
                  </span>
                  <input type="text" class="form-control" name="customer-name" placeholder="Customer Name">
               </div>
              </div>
              <div class="form-group">
               <div class="row">
				        <div class="col-md-6">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-list"></i>
                     </span>
                     <input type="text" class="form-control" name="customer-code" placeholder="Customer Code">
                  </div>
                 </div>
                  <div class="col-md-6">
                    <div class="input-group">
                      <span class="input-group-addon">
                        +6
                      </span>
                      <input type="number" class="form-control" name="customer-phone" placeholder="Customer Phone, eg. 0123456789">
                   </div>
                  </div>
               </div>
              </div>
			       <div class="form-group">
               <div class="row">
				        <div class="col-md-6">
                   <div class="input-group">
                     <span class="input-group-addon">
                      <i class="glyphicon glyphicon-home"></i>
                     </span>
                     <textarea class="form-control" name="customer-address" placeholder="Address" rows="4"></textarea>
                  </div>
                 </div>
                  <div class="col-md-6">
                    <div class="input-group">
					           <span class="input-group-addon">
                       <i class="glyphicon glyphicon-envelope"></i>
                      </span>
                      <input type="text" class="form-control" name="customer-email" placeholder="Customer Email">
                   </div>
                  </div>
               </div>
              </div>
              <button type="submit" name="add_customer" class="btn btn-danger">Add customer</button>
			         <a href="customer.php" class="btn btn-default">Cancel</a>
          </form>
         </div>
        </div>
      </div>
    </div>
  </div>

<?php include_once('layouts/footer.php'); ?>
