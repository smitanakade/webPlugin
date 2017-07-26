<?php 
ini_set('max_execution_time', 500);
function replicate(){

/* Production Server Details */
		global $wpdb;
		$servername = "182.160.155.42";
		$username = "arlec";
		$password = "JX8+&@+juAZZ";
		$conn = mysql_connect($servername,$username,$password) or die(mysql_error()); 
	 
	 /*FTP connection detail to trasfer files and images*/	 
	 $ftp_server="182.160.155.42";
	
	 $ftp_user_pass="JX8+&@+juAZZ";
	 $source="C:/xampp/apps/wordpress/htdocs/wp-content/files";


/*Replication of product detail in to prodction server Starts from here */		
		/*Below query checking is there any today updated record in aa_2r53c_productdetails*/
		$query= $wpdb->get_results("SELECT * FROM `aa_2r53c_productdetails` WHERE `updatedOn` = CURDATE() AND replicate='N'");
		$i=0;
				
		/*Replicating updated records in to production server database table aa_2r53c_productdetails */
	if($query){
		foreach($query as $data ) { 	
			$current_user = wp_get_current_user();
			$username =$current_user->user_login;	
	 
			  /*Add new row in the custom table*/
			$productCode =$data->productCode;
			$groupCode = $data->groupCode;
			$subCategory = $data->subCategory;
			$productTitle =$data->productTitle;
			$APN =$data->APN;
			$productDescription =$data->productDescription;
			$specification=$data->specification;
			$whereToBuy =$data->whereToBuy;
			$status =$data->status;
			$approved=$data->approved;
			$brand=$data->brand;
			$replicate=$data->replicate;
			$replicateOn=$data->replicateOn;
			$userPdf= $data->userPdf;

			$dest=$data->productCode.".jpg";

			$sql = "INSERT INTO aa_2r53c_productdetails(productCode,groupCode,subCategory,APN,productTitle,productDescription,specification,whereToBuy,userPdf,brand,status,updatedby,updatedOn,approved,replicateOn,replicate)
					 VALUES('".$productCode."','" .$groupCode."','" .$subCategory."','" .$APN."','".$productTitle."','".$productDescription."','".$specification."','".$whereToBuy."','".$userPdf."','".$brand."','C','".$username."',NOW(),'".$approved."',NOW(),'Y')
					 ON DUPLICATE KEY UPDATE groupCode='" .$groupCode."',subCategory='" .$subCategory."',APN='" .$APN."',productTitle='".$productTitle."',productDescription='".$productDescription."',specification='".$specification."',whereToBuy='".$whereToBuy."',userPdf='".$userPdf."',brand='".$brand."',status='C',updatedby='".$username."',updatedOn=NOW(),approved='".$approved."',replicateOn=NOW(),replicate='Y'";
			echo $productCode."<br/>";
			if($updateProductCode ==""){
 				$updateProductCode= "'".$productCode."'";
			}
			else{
				$updateProductCode .=", '".$productCode."'";		
			}
			mysql_select_db('arlec_wordpress');
			$retval = mysql_query( $sql, $conn );
			
			
			
			
			/*open FTP connection and transfer images*/
			$connection = ftp_connect($ftp_server);
			$ftp_user_name="arlec";
			$login = ftp_login($connection, $ftp_user_name, $ftp_user_pass);
			if((!$connection) || (!$login)){
				echo "<br/><br/><strong>FTP connection has failed!</strong>";
			    echo "<br/><strong>Attempted to Replicate image ".$data->productCode.".jpg and thumb_".$data->productCode.".jpg</strong>" ; 
			    die; 
			}
			else {
				//turn on passive connection
				ftp_pasv($connection, true);
				//Changing directory
				ftp_chdir($connection,"/public_html/wp-content/files");
		
				if (!$connection || !$login) { die('Connection attempt failed!'); }
				
				//Coping file from staging to production 
				$upload = ftp_put($connection, $dest, $source."/".$data->productCode.".jpg", FTP_BINARY);
				$upload_thumb = ftp_put($connection, "thumb_".$dest, $source."/thumb_".$data->productCode.".jpg", FTP_BINARY);
				if($userPdf){
					$upload_pdf = ftp_put($connection,  $data->userPdf, $source."/".$data->userPdf, FTP_BINARY);
					if (!$upload_pdf) { echo "<br/><strong> Attempted to Replicate PDF ".$data->userPdf." <strong>" ;  }
				}
				if (!$upload) { echo "<br/><br/><strong>Attempted to Replicate image ".$data->productCode.".jpg </strong>" ;  }
				if (!$upload_thumb) { echo "<br/><strong> Attempted to Replicate image thumb_".$data->productCode.".jpg </strong>" ;  }


				ftp_close($connection);
				/*Close FTP connection */	
		    }	 
			
			
		$i+=1;
		}
		if($updateProductCode){
			/*updating back in to the staging server how many products are replicated in to production*/
			$updateStaging= $wpdb->query("update `aa_2r53c_productdetails` set replicate='Y' WHERE productCode IN(".$updateProductCode.")");
		}
		if(! $retval )
		{
		  die('Could not update data: ' . mysql_error());
		}
		else{
				echo "<br/><strong>Total Product  updated in to production:  ".$i." Product code's are ".$updateProductCode."</strong><br/>";

		}
		
	}
	else{
		echo "<br/><strong>Presently no product is available to replicate</strong> ";
	}
	
/*Replication of product detail in to prodction server End here */		
		
/*Replication of Sub-Category  detail in to prodction  server End here */		
	
	//echo "Select * from aa_2r53c_subgroup WHERE `updatedOn` > DATE_SUB(NOW(), INTERVAL 1 DAY)";
		$Querysub=$wpdb->get_results("Select * from aa_2r53c_subgroup WHERE `updatedOn` > DATE_SUB(NOW(), INTERVAL 1 DAY)");
	if($Querysub){	
		$j=0;
		foreach($Querysub as $subQuery){
			
				$subReplicationQuery="INSERT INTO aa_2r53c_subgroup (subGDescription,subGCode,groupCode,classCode,publish,updatedOn,replicate,updatedBy) VALUES ('".$subQuery->subGDescription."','".$subQuery->subGCode."','".$subQuery->groupCode."','".$subQuery->classCode."','".$subQuery->publish."',NOW(),'Y','".$subQuery->updatedBy."')ON DUPLICATE KEY UPDATE
subGDescription='".$subQuery->subGDescription."',groupCode='".$subQuery->groupCode."',classCode='".$subQuery->classCode."',publish='".$subQuery->publish."',updatedOn=NOW(),replicate='Y',updatedBy='".$subQuery->updatedBy."'";	
		$dest_sub=$subQuery->groupCode."_".preg_replace('/\s+/', '', $subQuery->subGDescription).".jpg";
		mysql_select_db('arlec_wordpress');
		$retval_subCategory = mysql_query( $subReplicationQuery, $conn );

		/*open FTP connection and transfer images*/
		$connection = ftp_connect($ftp_server);
	 	$ftp_user_name="arlec";
		$login = ftp_login($connection, $ftp_user_name, $ftp_user_pass);
			if((!$connection) || (!$login)){
				echo "<br/><br/><strong>FTP connection has failed!</strong>";
			    echo "<br/><strong>Attempted to Replicate image ".$data->productCode.".jpg and thumb_".$data->productCode.".jpg </strong>" ; 
			    die; 
			}
			else {
				//turn on passive connection
				ftp_pasv($connection, true);
				//Changing directory
				ftp_chdir($connection,"/public_html/wp-content/files");
		
				if (!$connection || !$login) { die('Connection attempt failed!'); }
				
				//Coping file from staging to production 
				$upload = ftp_put($connection, $dest_sub, $source."/".$dest_sub, FTP_BINARY);

				if (!$upload) { echo "Attempted to Replicate image ".$dest_sub ;  }			
				ftp_close($connection);
			/*Close FTP Connection*/
		  }
		  $j+=1;
	}
		
	if(!$retval_subCategory )
		{
		  die('<br/><strong>Could not Subcategory update data: </strong>' . mysql_error());
		}
	else{
			echo "<br/><br/><strong>Total Subcategories updated in to production:  ".$j."</strong><br/>";

	}

	}
/*Replication of Category  detail in to prodction  server End here */		
		$QueryCategory=$wpdb->get_results("Select * from aa_2r53c_groupdetail WHERE `updatedOn` > DATE_SUB(NOW(), INTERVAL 1 DAY)");
		if($QueryCategory){
		$k=0;
		foreach($QueryCategory as $category){
			
				$categoryReplicate="INSERT INTO aa_2r53c_groupdetail (groupCode,groupDescription,classCode,countryCode,updateBy,updatedOn,replicate,publish)  VALUES ('".$category->groupCode."','".$category->groupDescription."','".$category->classCode."','AU','".$category->updatedBy."',NOW(),'Y','".$category->publish."' )ON DUPLICATE KEY UPDATE
				groupDescription='".$category->groupDescription."',classCode='".$category->classCode."',countryCode='AU',updateBy='".$category->updatedBy."',updatedOn=NOW(),replicate='Y',publish='".$category->publish."'";	
		
		mysql_select_db('arlec_wordpress');
		$retval_Category = mysql_query( $categoryReplicate, $conn );
	
		/*open FTP connection and transfer images*/
			$connection = ftp_connect($ftp_server);
			$ftp_user_name="arlec";
			$login = ftp_login($connection, $ftp_user_name, $ftp_user_pass);
			if((!$connection) || (!$login)){
				echo "<br/><br/><strong>FTP connection has failed!</strong>";
			    echo "<br/><strong>Attempted to Replicate image ".$category->groupCode.".jpg.</strong>" ; 
			    die; 
			}
			else {
				//turn on passive connection
				ftp_pasv($connection, true);
				//Changing directory
				ftp_chdir($connection,"/public_html/wp-content/files");
		
				if (!$connection || !$login) { die('Connection attempt failed!'); }
				
				//Coping file from staging to production 
				$upload = ftp_put($connection, $category->groupCode.".jpg", $source."/".$category->groupCode.".jpg", FTP_BINARY);
				if (!$upload) { echo "<br/><br/><strong>Attempted to Replicate image ".$category->groupCode.".jpg. Please try again!</strong> " ;  }		
				ftp_close($connection);
				/*Close FTP connection */
			
		  }	
			
		
		
		$k+=1;
	}
		
	if(!$retval_Category )
		{
		  die('Could not update data: ' . mysql_error());
		}
	else{
			echo "<br/><strong>Total Categories updated in to production:  ".$k."</strong><br/>";

	}	
		}
		
		mysql_close($conn);
		}
?>