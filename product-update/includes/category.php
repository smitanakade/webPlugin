<?php 
function AddCategory(){
	/*if($_POST['add_category_menu'] =='Add Category'){
		insert_query_addCategory();
	}*/
	
	if($_GET['action'] == 'edit' || $_GET['action'] == 'add' ) {
		add_category_menu();
	}
	if(!isset($_GET['action'])){
		pro_manage_category();
	}
	if($_POST['udate_category']){
		udate_category();
	}
	if($_GET['id']){
		delete_image();	
	}
}

function delete_image(){
	if($_GET['id']){
	$path="../wp-content/files/".$_GET['id'].".jpg";
		unlink($path);
	}
}

function add_category_menu(){
			add_meta_box( 'add-meta',__('Add Stratum'), 'add_category', 'add', 'normal', 'core');?>
		 <form method="post" enctype="multipart/form-data" action="" id="addcategory" name="addcategory" onsubmit="return validateForm(this)" >
              <h2><?php  if( $_GET['action'] != 'edit' ) {
                              $tf_title = __('Add Stratum');
			              }if($_GET['action'] == 'edit' ) {
            			       $tf_title = __('Edit Stratum');
			              }
            			  echo $tf_title;?>  </h2>
              <div id="poststuff" class="metabox-holder">
                <?php do_meta_boxes('add', 'normal','low'); ?>
              </div>
        
          <input type="submit" value="<?php echo $tf_title;?>" name="udate_category" id="udate_category" class="button-secondary">
        </form>
<?php }

function web_display_category() {
	
		pro_action();
		if(!$_GET['action'] ){
				add_meta_box( 'pro-meta',__('Search Product'), 'pro_category_box', 'pro', 'normal', 'core',$_POST);?>
				<div id="poststuff" class="metabox-holder">
				<?php do_meta_boxes('pro', 'normal','low'); ?>
				  </div>  
				  <?php
		}if(isset($_POST['Search']) || $_GET['sort'] ){
			global $query_data; 
				$query_data =$_POST;
				pro_manage_product();
		}
	
} 

function pro_get_category(){
	global $wpdb;
	$category=$wpdb->get_results("Select * from aa_2r53c_groupdetail");	
	return $category;
}

function Edit_category($code){
	global $wpdb;
	$category_result=$wpdb->get_results("Select * from aa_2r53c_groupdetail where groupCode='".$code."'");	
	return $category_result;
	
}
function udate_category(){
	global $wpdb;
	$current_user = wp_get_current_user();
	$username =$current_user->user_login;
	if($_FILES['category_image'] !=""){
				/*Checking uploaded image name should be same as product code*/
				$imageName=explode('.jpg',$_FILES['category_image']['name']);
				if($_POST['groupCode'] == $imageName[0] && $_FILES['category_image']['type'] == 'image/jpeg' ){
					$file = wp_upload_bits( $_FILES['category_image']['name'], null, @file_get_contents( $_FILES['category_image']['tmp_name'] ) );					
				}
				else{ echo "<br/>Category Image Name should be same as Group Code and in JPGE formate and size 2000*2000 or 460149.";
					}
	}
	if($_GET['action'] == 'edit' ) {
		echo "UPDATE aa_2r53c_groupdetail set groupDescription='".mysql_escape_string($_POST['groupDescription'])."', classCode='".mysql_escape_string($_POST['classCode'])."' ,updateBy='".$username."', publish='".mysql_escape_string($_POST['publish'])."' Where groupCode='".mysql_escape_string($_POST['groupCode'])."' ";
		$wpdb->query("UPDATE aa_2r53c_groupdetail set groupDescription='".mysql_escape_string($_POST['groupDescription'])."', classCode='".mysql_escape_string($_POST['classCode'])."' ,updateBy='".$username."',updatedOn=NOW(),replicate='N', publish='".mysql_escape_string($_POST['publish'])."' Where groupCode='".mysql_escape_string($_POST['groupCode'])."'");
		echo "<br><br><strong>Startum Updated !</strong>";
		exit;}
	if($_GET['action'] == 'add'){
		echo "INSERT INTO aa_2r53c_groupdetail (groupCode,groupDescription,classCode,countryCode,updateBy,updatedOn,replicate,publish) VALUES ('".mysql_escape_string($_POST['groupCode'])."','".mysql_escape_string($_POST['groupDescription'])."','".mysql_escape_string($_POST['classCode'])."','AU','".$username."',NOW(),'N''".mysql_escape_string($_POST['publish'])."' )";
		$wpdb->query( "INSERT INTO aa_2r53c_groupdetail (groupCode,groupDescription,classCode,countryCode,updateBy,updatedOn,replicate,publish) VALUES ('".mysql_escape_string($_POST['groupCode'])."','".mysql_escape_string($_POST['groupDescription'])."','".mysql_escape_string($_POST['classCode'])."','AU','".$username."',NOW(),'N','".mysql_escape_string($_POST['publish'])."' )");
				echo "<br/><strong>CategoryNow Created </strong>";
		exit;
	}
}

?>