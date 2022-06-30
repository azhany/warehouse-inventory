<?php
  $page_title = 'All Product';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(3);
  $customers = find_all_customers();
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
       <?php echo display_msg($msg); ?>
     </div>
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading clearfix">
         <div class="pull-right">
           <a href="add_customer.php" class="btn btn-primary">Add New Customer</a>
         </div>
        </div>
        <div class="panel-body">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="text-center" style="width: 10px;">#</th>
                <th> Customer Name </th>
				        <th> Customer Code </th>
                <th class="text-center" style="width: 10%;"> Phone </th>
                <th class="text-center" style="width: 50%;"> Address </th>
                <th class="text-center" style="width: 10%;"> Email </th>
                <th class="text-center" style="width: 10%;"> Customer Added </th>
                <th class="text-center" style="width: 100px;"> Actions </th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($customers as $customer):?>
              <tr>
                <td class="text-center"><?php echo count_id();?></td>
                <td> <?php echo remove_junk($customer['name']); ?></td>
				        <td> <?php echo remove_junk($customer['code']); ?></td>
                <td class="text-center"> <?php echo remove_junk($customer['phone']); ?></td>
                <td class="text-center"> <?php echo remove_junk($customer['address']); ?></td>
                <td class="text-center"> <?php echo remove_junk($customer['email']); ?></td>
                <td class="text-center"> <?php echo read_date($customer['date']); ?></td>
                <td class="text-center">
                  <div class="btn-group">
                    <a href="edit_customer.php?id=<?php echo (int)$customer['id'];?>" class="btn btn-info btn-xs"  title="Edit" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-edit"></span>
                    </a>
                    <a href="delete_customer.php?id=<?php echo (int)$customer['id'];?>" class="btn btn-danger btn-xs"  title="Delete" data-toggle="tooltip">
                      <span class="glyphicon glyphicon-trash"></span>
                    </a>
                  </div>
                </td>
              </tr>
             <?php endforeach; ?>
            </tbody>
          </tabel>
        </div>
      </div>
    </div>
  </div>
  <?php include_once('layouts/footer.php'); ?>
