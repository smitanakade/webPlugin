<?php 
/*function pro_option_link(){
	add_options_page('Update Website Product','Product Update','manage_options','pro-update','pro_plugin_option');
	add_options_page('My first wordpress plugin option','My First Plugin','manage_options','pro-update','pro_plugin_option');
}
add_action('admin_menu','pro_option_link');
*/
function pro_add_admin_menu()
{
$capability = (current_user_can('author'))? 'author' : 'manage_options';
   add_menu_page( 'Menu Example' , 'Product' , $capability ,'pro-search' , 'web_display_menu' );
   add_submenu_page('pro-search', 'Manage Product', 'Statrum' , $capability,  'add-cat' , 'AddCategory');
   add_submenu_page('pro-search', 'Manage Product', 'Sub Category' , $capability,  'add-sub' , 'AddSubCategory');
   add_submenu_page('pro-search', 'Manage Product', 'Replicate' , $capability,  'add-rip' , 'replicate');
  // add_submenu_page('pro-search', 'Manage Product', 'Page Replicate' , $capability,  'add-page' , 'Page_replicate');
   
   
}
add_action( 'admin_menu', 'pro_add_admin_menu' );


/**/

function web_display_menu() {
	
		pro_action();
		if(!$_GET['action'] ){
				add_meta_box( 'pro-meta',__('Search Product'), 'pro_search_box', 'pro', 'normal', 'core',$_POST);?>
				<div id="poststuff" class="metabox-holder">
				<?php do_meta_boxes('pro', 'normal','low'); ?>
				  </div>  
				  <?php
		}if(isset($_POST['Search']) || $_GET['sort'] ){
			global $query_data; 
				$query_data =$_POST;
				pro_manage_product();
		}
		if($_GET['id']){
		proImage_delete();	
	}
	
} 
function proImage_delete(){
	if($_GET['id'] && !$_GET['type']){
	$path="../wp-content/files/".$_GET['id'].".jpg";
		unlink($path);
	}
	if($_GET['id'] && $_GET['type']){
	$path="../wp-content/files/".$_GET['id'].".pdf";
		unlink($path);
	global $wpdb;
    $wpdb->query("UPDATE aa_2r53c_productdetails SET userPdf='' WHERE productCode='" .mysql_escape_string($_GET['id']) ."'");

		
		
	}
	
}

function pro_action(){
     global $wpdb;
    if(isset($_GET['action'])){
		global $edit_product;
		$productCode=$_GET['code'];
		if ($productCode) $edit_product = pro_get_productRow($productCode); 
			add_meta_box( 'pro-meta',__('Search Product'), 'pro_product_meta_box', 'pro', 'normal', 'core');?>
	 <div class="wrap">
      <div id="faq-wrapper">
       <form method="post" enctype="multipart/form-data" action="?page=pro-search" id="addProduct" name="addProduct" onsubmit="return validateForm(this)" >
          <h2>
          <?php if( $_GET['action'] != 'edit' ) {
			 
                $tf_title = __('Add Product');
          }if($_GET['action'] == 'edit' ) {
			    $tf_title = __('Edit Product');
          }
          echo $tf_title;
          ?>
          </h2>
          <div id="poststuff" class="metabox-holder">
            <?php do_meta_boxes('pro', 'normal','low'); ?>
          </div>
          <input type="hidden" name="HiddenproductCode" value="<?php echo $productCode?>" />
          <input type="submit" value="<?php echo $tf_title;?>" name="pro_add_product" id="pro_add_product" class="button-secondary">
        </form>
          <script>
          $(document).ready(function(){
        $('#addProduct').validate();
        });
		</script>
      </div>
    </div>
	    <?php } 
	if(isset($_GET['update'])){
		$Code = $_GET['pCode'];
       $wpdb->query("UPDATE aa_2r53c_productdetails SET status='A' WHERE productCode='" .$Code ."'");

		}
	

    if(isset($_POST['pro_add_product'])) {    
		
		$current_user = wp_get_current_user();
		$username =$current_user->user_login;	
	 
	      /**Add new row in the custom table**/
        $productCode = $_POST['productCode'];
        
		$gcode =explode('>>', $_POST['subCategory']);
		$groupCode = $gcode[1];
        $subCategory = $gcode[0];
        
		$productTitle = $_POST['productTitle'];
		$APN = $_POST['APN'];
		$productDescription =$_POST['productDescription'];
		$specification=$_POST['specification'];
		$whereToBuy =$_POST['whereToBuy'];
		$status = $_POST['status'];
		$approved=$_POST['approved'];
		$brand= $_POST['brand'];
		$HiddenproductCode = $_POST['HiddenproductCode'];
		$pdf= $_POST['pdf'];
		$url= network_home_url();
		

		if($_FILES['example-jpg-file'] !=""){
			/*Checking uploaded image name should be same as product code*/
				$imageName=explode('.jpg',$_FILES['example-jpg-file']['name']);
				if($productCode == $imageName[0] && $_FILES['example-jpg-file']['type'] == 'image/jpeg' &&  $_FILES['example-jpg-file']['size']='589730' ){
					echo "enter";
					$file = wp_upload_bits( $_FILES['example-jpg-file']['name'], null, @file_get_contents( $_FILES['example-jpg-file']['tmp_name'] ) );			
					echo"<br>";print_r($file);		
				}
				else{ echo "<br/><strong>Prdouct Image Name should be same as Product Code and in JPGE formate and size 2000*2000 or 460149.</strong>";
					}
		}
		if($_FILES['thumbline'] !=""){
			/*Checking uploaded image name should be same as product code*/
				$imageName1=explode('.jpg',$_FILES['thumbline']['name']);
				$thumbName= "thumb_".$productCode;
				if($thumbName == $imageName1[0] && $_FILES['thumbline']['type'] == 'image/jpeg'  ){
					$file = wp_upload_bits( $_FILES['thumbline']['name'], null, @file_get_contents( $_FILES['thumbline']['tmp_name'] ) );			
					echo"<br>";	
				}
				else{ echo "<br/><strong>Prdouct Thumb line Image Name should be same as thumb_Product Code and in JPGE formate.</strong>";
					}
		}
				
		if($_FILES['userPdf']){
					$userPdf = wp_upload_bits( $_FILES['userPdf']['name'], null, @file_get_contents( $_FILES['userPdf']['tmp_name'] ) );
					
					/*if($_POST['HiddenproductCode']){
						$userPdfresult=$wpdb->get_results("SELECT userPdf FROM aa_2r53c_productdetails WHERE productCode='".mysql_escape_string($_POST['HiddenproductCode'])."'");
						$nameOfuserPdf = (!$userPdfresult[0]->userPdf)? $_FILES['userPdf']['name'] : $userPdfresult[0]->userPdf.", ".$_FILES['userPdf']['name'] ;	
						echo "UPDATE aa_2r53c_productdetails set userPdf='".mysql_escape_string($nameOfuserPdf)."' WHERE productCode='".mysql_escape_string($HiddenproductCode)."'";				
						$wpdb->query("UPDATE aa_2r53c_productdetails set userPdf='".mysql_escape_string($nameOfuserPdf)."' WHERE productCode='".mysql_escape_string($HiddenproductCode)."'");
						
					}*/
					
			}
		if($_FILES['userPdf']['name']){
			$pdfUser= $_FILES['userPdf']['name'];
		}
		$pdfName= ($_FILES['userPdf']['name'])? $_FILES['userPdf']['name']:$pdf;
		
			
		
		echo "INSERT INTO aa_2r53c_productdetails(productCode,groupCode,subCategory,APN,productTitle,productDescription,specification,whereToBuy,userPdf,brand,status,updatedby,updatedOn,approved,replicateOn,replicate)
 VALUES('".$productCode."','" .$groupCode."','" .$subCategory."','" .$APN."','".$productTitle."','".$productDescription."','".$specification."','".$whereToBuy."','".$pdfName."','".$brand."','C','".$username."',CURDATE(),'".$approved."',NOW(),'N')
 ON DUPLICATE KEY UPDATE groupCode='" .$groupCode."',subCategory='" .$subCategory."',APN='" .$APN."',productTitle='".$productTitle."',productDescription='".$productDescription."',specification='".$specification."',whereToBuy='".$whereToBuy."',userPdf='".$pdfName."',brand='".$brand."',updatedby='".$username."',updatedOn=CURDATE(),approved='".$approved."',replicateOn=NOW(),replicate='N'";
   $wpdb->query("INSERT INTO aa_2r53c_productdetails(productCode,groupCode,subCategory,APN,productTitle,productDescription,specification,whereToBuy,userPdf,brand,status,updatedby,updatedOn,approved,replicateOn,replicate)
 VALUES('".$productCode."','" .$groupCode."','" .$subCategory."','" .$APN."','".$productTitle."','".$productDescription."','".$specification."','".$whereToBuy."','".$pdfName."','".$brand."','C','".$username."',CURDATE(),'".$approved."',NOW(),'N')
 ON DUPLICATE KEY UPDATE groupCode='" .$groupCode."',subCategory='" .$subCategory."',APN='" .$APN."',productTitle='".$productTitle."',productDescription='".$productDescription."',specification='".$specification."',whereToBuy='".$whereToBuy."',userPdf='".$pdfName."',brand='".$brand."',updatedby='".$username."',updatedOn=CURDATE(),approved='".$approved."',replicateOn=NOW(),replicate='N'");
	echo "<br/><strong>Product updated in to database successfully.</strong><br/>"; 
	unset($edit_product);
			
    }  
}



function pro_get_productRow($productCode) {
    global $wpdb;
    $productRowResult = $wpdb->get_results("SELECT * FROM aa_2r53c_productdetails WHERE productCode='".$productCode."'");
	if(!empty($productRowResult[0])) {
        return $productRowResult[0];
    }
    return;
}
function pro_add_product(){
    $productCode =0;
    if($_GET['code']) $productCode = $_GET['code'];

    /**Get an specific row from the table wp_bor_software**/
    global $edit_product;
    if ($productCode) $edit_product = pro_get_productRow($productCode);   

    /**create meta box**/
    add_meta_box('bor-meta', __('Product Detail'), 'pro_product_meta_box', 'pro', 'normal', 'core' );
?>

    /**Display the form to add a new row**/
    <div class="wrap">
      <div id="faq-wrapper">
        <form method="post" action="?page=pro-update" onsubmit="return Validation()" >
          <h2>
          <?php if( $productCode == 0 ) {
			 
                $tf_title = __('Add Product');
          }if($productCode != 0) {
			    $tf_title = __('Edit Product');
          }
          echo $tf_title;
          ?>
          </h2>
          <div id="poststuff" class="metabox-holder">
            <?php do_meta_boxes('pro', 'normal','low'); ?>
          </div>
          <input type="hidden" name="productCode" value="<?php echo $productCode?>" />
          <input type="submit" value="<?php echo $tf_title;?>" name="pro_add_product" id="pro_add_product" class="button-secondary">
        </form>
      </div>
    </div>
<?php
}


function pro_get_searchResult(){
	global $wpdb;
	global $query_data;
	
	$productCode=$query_data['productCode'];
			$groupCode=$query_data['groupCode'];
			$subCategory = $query_data['subCategory'];
			$whereToBuy = $query_data['whereToBuy'];
			$brand = $query_data['brand'];
	if($productCode){
		$string[0]="p.productCode like '%".$productCode."%' ";
	}
	if($groupCode){
		$string[1]="p.groupCode like '%".$groupCode."%'";
	}
	if($whereToBuy){
		$string[2]="p.whereToBuy like '%".$whereToBuy."%' ";
	}
	if($brand){
	$string[3]="p.brand LIKE '%".$brand."%'";
	}
	$data ="";
	
	
	for($i=0;$i<=4; $i++){
		if($string[$i]){
			if($data){
				$data .="OR ";
			}
			$data .= $string[$i];
			
		}
	}
	
	$productSearchResult = $wpdb->get_results( "SELECT * FROM `aa_2r53c_productdetails` as p WHERE ".$data.$sort);
	
    return $productSearchResult;
}

function get_groupNcatg(){
		global $wpdb;
	
		$groupNcat =$wpdb->get_results("SELECT subGDescription, groupCode FROM `aa_2r53c_subgroup`");
		return $groupNcat;	
}

function get_group(){
		global $wpdb;
	
		$group =$wpdb->get_results("SELECT groupCode FROM `aa_2r53c_groupdetail` WHERE `groupCode` NOT IN( SELECT DISTINCT(`groupCode`) FROM `aa_2r53c_subgroup`) ORDER BY `groupCode` ASC");
		return $group;	
}
function wptuts_scripts_basic()
{
    
    // Registering Scripts
   /*  wp_register_script('google-hosted-jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false);

     wp_register_script('jquery-validation-plugin', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js', array('google-hosted-jquery'));

    // Enqueueing Scripts to the head section
    wp_enqueue_script('google-hosted-jquery');
    wp_enqueue_script('jquery-validation-plugin');
	*/
	wp_register_script( 'custom-jquery', get_template_directory_uri() .'js/jquer.js' );
	 wp_enqueue_script('custom-jquery');
	
}
add_action( 'wp_enqueue_script', 'wptuts_scripts_basic' );?>