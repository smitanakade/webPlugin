<?php 
function import_add_admin_menu()
{
$capability = (current_user_can('author'))? 'author' : 'manage_options';
   add_menu_page( 'Import Example' , 'Import' , $capability ,'impo-data' , 'Import_display_menu' );
   /*add_submenu_page('pro-search', 'Manage Product', 'Statrum' , $capability,  'add-cat' , 'AddCategory');
   add_submenu_page('pro-search', 'Manage Product', 'Sub Category' , $capability,  'add-sub' , 'AddSubCategory');
   */
}
add_action( 'admin_menu', 'import_add_admin_menu' );

function Import_display_menu(){?>
	 <form method="post" action="?page=impo-data" id="importForm" enctype="multipart/form-data">
     <table width="100%">
  <tr>
    <td>Select File To Upload In to DB</td>
    <td><input type="file" name="file" value="Browse"></td>
  </tr>
  <tr>
    <td> <input type="Submit" value="Submit" name="BrowseFile" id="BrowseFile"></td>
  </tr>
</table>

     </form>
     
<?php
	if(isset($_POST['BrowseFile'])){
		global $wpdb;
	    $csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
    	if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
			 if(is_uploaded_file($_FILES['file']['tmp_name'])){
						
						//open uploaded csv file with read only mode
						$csvFile = fopen($_FILES['file']['tmp_name'], 'r');
						
						//skip first line
						fgetcsv($csvFile);

						$i=0;
						       //parse data from csv file line by line
				while(($value = fgetcsv($csvFile)) !== FALSE){
						if($value[0]!=""){
	$prevQuery = "SELECT * FROM aa_2r53c_productdetails WHERE productCode = '".$value[0]."'";
						echo $prevQuery;
					$prevResult = $wpdb->get_results($prevQuery);
				if(sizeof($prevResult) > 0){
					
						//update member data
						$wpdb->query("UPDATE aa_2r53c_productdetails SET groupCode = '".$value[1]."', subCategory = '".$value[2]."', APN = '".$value[3]."', productTitle = '".$value[4]."',productDescription = '".$value[5]."',specification = '".$value[6]."',whereToBuy = '".$value[7]."',userPdf = '".$value[8]."',brand = '".$value[9]."',status = '".$value[10]."',updatedby= '".$value[11]."',updatedOn=now(),approved='".$value[13]."',replicate='N' WHERE ProductCode = '".$value[0]."'");
					}else{
					
						//insert member data into database
						$wpdb->query("INSERT INTO aa_2r53c_productdetails (productCode, groupCode, subCategory, APN, productTitle,productDescription,specification,whereToBuy,userPdf,brand,status,updatedby,updatedOn,approved,replicate)  VALUES ('".$value[0]."','".$value[1]."','".$value[2]."','".$value[3]."','".$value[4]."','".$value[5]."','".$value[6]."','".$value[7]."','".$value[8]."','".$value[9]."','".$value[10]."','".$value[11]."',now(),'Y','N')");
						
					}	
					}
				}
					/*while (!feof($csvFile)){
					$value =(fgetcsv($csvFile,0,";"));
					
					if($i>0){

						$prevQuery = "SELECT * FROM product WHERE ProductCode = '".$value[0]."'";
						echo $prevQuery;
					$prevResult = $wpdb->query($prevQuery);
				if($prevResult->num_rows > 0){
						//update member data
					//	$wpdb->query("UPDATE product SET Description = '".$value[1]."', SubCatId = ".$value[2].", MainCatId = '".$value[3]."', fineline = '".$value[4]."' WHERE ProductCode = '".$value[0]."'");
					}else{
						//insert member data into database
				//		$wpdb->query("INSERT INTO members (ProductCode, Description, SubCatId, MainCatId, fineline) VALUES ('".$value[0]."','".$value[1]."',".$value[2].",'".$value[3]."','".$value[3]."','".$value[4]."')");
					}	

						}
						
					//check whether member already exists in database with same email
					
					
					
					$i++;
				}*/
			
				   //close opened csv file
            fclose($csvFile);
			echo "File Uploaded Sucessfully";
			 }
			 else{
				 echo"Error";
				 }
		}else{
			echo "Invalid File";
			}
	}

 }

?>