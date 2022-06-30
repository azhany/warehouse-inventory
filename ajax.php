<?php
  require_once('includes/load.php');
  if (!$session->isUserLoggedIn(true)) { redirect('index.php', false);}
?>

<?php
 // Auto suggetion
    $html = '';
   if(isset($_POST['product_name']) && strlen($_POST['product_name']))
   {
     $products = find_product_by_title($_POST['product_name']);
     if($products){
        foreach ($products as $product):
           $html .= "<li class=\"list-group-item\">";
           $html .= $product['name'];
           $html .= "</li>";
         endforeach;
      } else {
        $html .= '<li onClick=\"fill(\''.addslashes().'\')\" class=\"list-group-item\">';
        $html .= 'Not found';
        $html .= "</li>";
      }

      echo json_encode($html);
   }
 ?>
 <?php
 // find all product
  if(isset($_POST['p_name']) && strlen($_POST['p_name']))
  {
    $product_title = remove_junk($db->escape($_POST['p_name']));
    if($results = find_all_product_info_by_title($product_title)){
        foreach ($results as $result) {

          $html .= "<tr id=\"{$result['id']}\">";
          $html .= "<td id=\"s_name\"><input type=\"text\" class=\"form-control\" name=\"product\" value=\"{$result['name']}\" readonly=\"readonly\"></td>";
          $html .= "<input type=\"hidden\" name=\"product_id[]\" value=\"{$result['id']}\">";
          $html .= "<td class=\"s_qty\">";
          $html .= "<input type=\"text\" class=\"form-control\" name=\"quantity[]\" value=\"1\">";
          $html  .= "</td>";
		  $html  .= "<td class=\"s_price\">";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"price[]\" value=\"{$result['sale_price']}\" readonly=\"readonly\">";
          $html  .= "</td>";
          $html  .= "<td class=\"s_total\">";
          $html  .= "<input type=\"text\" class=\"form-control\" name=\"total[]\" value=\"{$result['sale_price']}\">";
          $html  .= "</td>";
          $html  .= "<td>";
          $html  .= "<button class=\"btn btn-danger\" onclick=\"remove({$result['id']});return false;\"><i class=\"glyphicon glyphicon-trash\"></i></button>";
          $html  .= "</td>";
		  /*
          $html  .= "<td>";
          $html  .= "";
          $html  .= "</td>";
		  */
          $html  .= "</tr>";

        }
    } else {
        //$html ='<tr><td>product name not resgister in database</td></tr>';
    }

    echo json_encode($html);
  }
 ?>
 
 <?php
   if(isset($_POST['customer_id']))
   {
		$customers = find_by_id('customers',$_POST['customer_id']);

		echo json_encode($customers);
   }
 ?>
