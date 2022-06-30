<?php
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
  page_require_level(1);
?>
<?php
  $branch = find_by_id('branch',(int)$_GET['id']);
  if(!$branch){
    $session->msg("d","Missing branch id.");
    redirect('branch.php');
  }
?>
<?php
  $delete_id = delete_by_id('branch',(int)$branch['id']);
  if($delete_id){
      $session->msg("s","Branch deleted.");
      redirect('branch.php');
  } else {
      $session->msg("d","Branch deletion failed.");
      redirect('branch.php');
  }
?>
