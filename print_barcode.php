<?php
  $page_title = 'Print Barcode';
  require_once('includes/load.php');
  // Checkin What level user has permission to view this page
   page_require_level(2);
   
require './plugins/barcode-generator/BarcodeBase.php';
//require './plugins/barcode-generator/Code39.php';
require './plugins/barcode-generator/Code128.php';
$bcode = array();
//$bcode['c39']	= array('name' => 'Code39', 'obj' => new emberlabs\Barcode\Code39());
$bcode['c128']	= array('name' => 'Code128', 'obj' => new emberlabs\Barcode\Code128());
function bcode_error($m)
{
	echo "<div class='error'>{$m}</div>";
}
function bcode_success($bcode_name)
{
	echo "<div class='success'>A $bcode_name barcode was successfully created</div>";
}
function bcode_img64($b64str)
{
	echo "<img src='data:image/png;base64,$b64str' /><br />";
}
?>
<?php include_once('layouts/header.php'); ?>
  <div class="row">
     <div class="col-md-12">
		<?php
			foreach($bcode as $k => $value)
			{
				try
				{
					$bcode[$k]['obj']->setData($_GET['barcode']);
					$bcode[$k]['obj']->setDimensions(300, 150);
					$bcode[$k]['obj']->draw();
					$b64 = $bcode[$k]['obj']->base64();
					//bcode_success($bcode[$k]['name']);
					bcode_img64($b64);
				}
				catch (Exception $e)
				{
					bcode_error($e->getMessage());
				}
			}
		?>
     </div>
  </div>
<?php include_once('layouts/footer.php'); ?>