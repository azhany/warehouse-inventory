<?php
  $page_title = 'All branches';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
  
  $all_branch = find_all('branch');
?>
<?php
 if(isset($_POST['add_branch'])){
   $req_field = array('branch-name');
   validate_fields($req_field);
   $branch_name = remove_junk($db->escape($_POST['branch-name']));
   if(empty($errors)){
      $sql  = "INSERT INTO branch (name)";
      $sql .= " VALUES ('{$branch_name}')";
      if($db->query($sql)){
        $session->msg("s", "Successfully Added Branch");
        redirect('branch.php',false);
      } else {
        $session->msg("d", "Sorry Failed to insert.");
        redirect('branch.php',false);
      }
   } else {
     $session->msg("d", $errors);
     redirect('branch.php',false);
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
    <div class="col-md-5">
      <div class="panel panel-default">
        <div class="panel-heading">
          <strong>
            <span class="glyphicon glyphicon-th"></span>
            <span>Add New Branch</span>
         </strong>
        </div>
        <div class="panel-body">
          <form method="post" action="branch.php">
            <div class="form-group">
                <input type="text" class="form-control" name="branch-name" placeholder="Branch Name">
            </div>
            <button type="submit" name="add_branch" class="btn btn-primary">Add branch</button>
        </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
    <div class="panel panel-default">
      <div class="panel-heading">
        <strong>
          <span class="glyphicon glyphicon-th"></span>
          <span>All Branches</span>
       </strong>
      </div>
        <div class="panel-body">
          <table class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th class="text-center" style="width: 50px;">#</th>
                    <th>Branch</th>
                    <th class="text-center" style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
              <?php foreach ($all_branch as $b):?>
                <tr>
                    <td class="text-center"><?php echo count_id();?></td>
                    <td><?php echo remove_junk(ucfirst($b['name'])); ?></td>
                    <td class="text-center">
                      <div class="btn-group">
                        <a href="edit_branch.php?id=<?php echo (int)$b['id'];?>"  class="btn btn-xs btn-warning" data-toggle="tooltip" title="Edit">
                          <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <a href="delete_branch.php?id=<?php echo (int)$b['id'];?>"  class="btn btn-xs btn-danger" data-toggle="tooltip" title="Remove">
                          <span class="glyphicon glyphicon-trash"></span>
                        </a>
                      </div>
                    </td>

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
