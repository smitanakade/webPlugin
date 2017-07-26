<?php 
global $wpdb;

if(isset($_GET['action']) && $_GET['action']=="add"){
	$id=$_GET['id'];
	if(isset($_SESSION['cart'][$id])){
		$_SESSION['cart'][$id]['quantity']++;
	}else{
		$result4session = $wpdb->get_results("SELECT partnumber,tradeprice FROM aa_2r53c_spareparts WHERE partnumber='".$id."'");
		if($result4session[0]->partnumber){
			$_SESSION['cart'][$result4session[0]->partnumber]= array(	"quantity" =>1,
																		"price" => '[$result4session[0]->partnumber');
		}else{
			$message = "This partnumber is invalid";
		}
	}
}

 if(isset($message)){
				echo "<h2>$message</h2>";
			}
$result = $wpdb->get_results("SELECT * FROM aa_2r53c_spareparts");
	foreach ($result as $row){?>
            <div class="et_pb_column et_pb_column_1_3">
            <div class="et_pb_promo et_pb_bg_layout_light et_pb_text_align_center et_pb_no_bg">
            <div class="et_pb_promo_description">
			
			
			<?php echo $row->description; echo "<br>";
					$url=network_home_url();
					$image_url =@getimagesize($url."/wp-content/files/".$row->groupCode.".jpg") ? $url."/wp-content/files/".$row->groupCode.".jpg" :  $url."/wp-content/files/ACON.jpg";  ?>          
					<img class="alignnone size-full wp-image-355" src="<?php echo $image_url;?>" alt="images (1)" width="133" height="134" /></p></a><br />
					<?php echo $row->partnumber; echo " $".$row->tradeprice;?><br />
					<a href="?page=shop_product&action=add&id=<?php echo $row->partnumber;?>">Add to Cart</a><br>
            </div> </div></div>
	<?php }?>