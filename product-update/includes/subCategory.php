<?php 
function AddSubCategory(){
	/*if($_POST['add_category_menu'] =='Add Category'){
		insert_query_addCategory();
	}*/
	
	if($_GET['action'] == 'edit' || $_GET['action'] == 'add' ) {
		add_SubCategory_menu();
	}
	if(!isset($_GET['action'])){
		pro_manage_subCategory();
	}
	if($_POST['udate_Subcategory']){
		udate_Subcategory();
	}
		if($_GET['id']){
		delete();	
	}
	//add_category_menu();
}

function delete(){
	if($_GET['id']){
	$path="../wp-content/files/".$_GET['id'].".jpg";
		unlink($path);
	}
}


function add_SubCategory_menu(){
			add_meta_box( 'add-meta',__('Add Sub-Category'), 'add_subCategory', 'add', 'normal', 'core');?>
		 <form method="post" enctype="multipart/form-data" action="" id="addsubcategory" name="addsubcategory" onsubmit="return validateForm(this)" >
              <h2><?php  if( $_GET['action'] != 'edit' ) {
                              $tf_title = __('Add Sub-Category');
			              }if($_GET['action'] == 'edit' ) {
            			       $tf_title = __('Edit Sub-Category');
			              }
            			  echo $tf_title;?>  </h2>
              <div id="poststuff" class="metabox-holder">
                <?php do_meta_boxes('add', 'normal','low'); ?>
              </div>
        
          <input type="submit" value="<?php echo $tf_title;?>" name="udate_Subcategory" id="udate_Subcategory" class="button-secondary">
        </form>
<?php }



function pro_get_subCategory(){
	global $wpdb;
	$subCategory=$wpdb->get_results("Select * from aa_2r53c_subgroup");	
	return $subCategory;
}

function Edit_subCategory($code){
	global $wpdb;

	$subcategory_result=$wpdb->get_results("Select * from aa_2r53c_subgroup where subGCode='".$code."'");	
//	print_r($subcategory_result);
	return $subcategory_result;
	
}
function udate_Subcategory(){

	global $wpdb;
	$current_user = wp_get_current_user();
	$username =$current_user->user_login;
	if($_FILES['subcategory_image'] !=""){
				//Checking uploaded image name should be same as product code
				$image=$_POST['groupCode']."_".preg_replace('/\s+/', '', $_POST['subGDescription']);
				$imageName=explode('.jpg',$_FILES['subcategory_image']['name']);
				if($image == $imageName[0]){
					$file = wp_upload_bits( $_FILES['subcategory_image']['name'], null, @file_get_contents( $_FILES['subcategory_image']['tmp_name'] ) );	
				}
				else{ echo "<br/>Image Name should be same as group Code underscore subcategory name i.e AUDI_Leads.jpg and in JPGE formate and size 2000*2000 or 460149.";
					}
	}
	if($_GET['action'] == 'edit' ) {
		echo "UPDATE aa_2r53c_subgroup set subGDescription='".mysql_escape_string($_POST['subGDescription'])."', groupCode='".mysql_escape_string($_POST['groupCode'])."',classCode='".mysql_escape_string($_POST['classCode'])."',updatedBy='".$username."' , publish='".mysql_escape_string($_POST['publish'])."', updatedOn =NOW(),replicate='N' Where subGCode='".mysql_escape_string($_GET['code'])."' ";
		$wpdb->query("UPDATE aa_2r53c_subgroup set subGDescription='".mysql_escape_string($_POST['subGDescription'])."', groupCode='".mysql_escape_string($_POST['groupCode'])."',classCode='".mysql_escape_string($_POST['classCode'])."', updatedBy='".$username."' , publish='".mysql_escape_string($_POST['publish'])."', updatedOn =NOW(),replicate='N' Where subGCode='".mysql_escape_string($_GET['code'])."' ");
		echo "<br><br><strong>Startum Updated !</strong>";
		exit;}
	if($_GET['action'] == 'add'){
		
		/*Get Last subid from table*/
		$lastid= $wpdb->get_results("SELECT Max(subGCode) as code FROM `aa_2r53c_subgroup` GROUP BY subGCode DESC LIMIT 1");
		
		$subid= $lastid[0]->code+1;

		echo"INSERT INTO aa_2r53c_subgroup (subGDescription,subGCode,groupCode,classCode,publish,updatedOn,replicate,updatedBy) VALUES ('".mysql_escape_string($_POST['subGDescription'])."','".mysql_escape_string($subid)."','".mysql_escape_string($_POST['groupCode'])."','".mysql_escape_string($_POST['classCode'])."','".mysql_escape_string($_POST['publish'])."',NOW(),'N','".$username."')";
		$wpdb->query("INSERT INTO aa_2r53c_subgroup (subGDescription,subGCode,groupCode,classCode,publish,updatedOn,replicate,updatedBy) VALUES ('".mysql_escape_string($_POST['subGDescription'])."','".mysql_escape_string($subid)."','".mysql_escape_string($_POST['groupCode'])."','".mysql_escape_string($_POST['classCode'])."','".mysql_escape_string($_POST['publish'])."',NOW(),'N','".$username."')");
		echo "<br/><strong>CategoryNow Created </strong>";
		exit;
	}
}

?>