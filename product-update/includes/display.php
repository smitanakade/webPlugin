<?php 

function pro_product_meta_box(){
	global $edit_product;
	$groupNcat =get_groupNcatg();
	$get_group = get_group();
//	print_r($get_group);
?>
<p align="justify"><font  style="color:#0000FF;"><strong>Please note</strong>: Kindly write  <strong>specification, whereToBuy </strong>each point using >> delimiter<br />
		<strong>Example  :</strong>
        <ul><li><strong style="font-size:18px">.</strong>Receives all 3D TV broadcast signals</li>
        <li><strong style="font-size:18px">.</strong>Recommended for use in PRIME metro signal areas</li>
        <li><strong style="font-size:18px">.</strong>Receives full high definition TV broadcasts for a perfect picture</li>
        </ul>

<strong>Correct way to write here :</strong> Receives all 3D TV broadcast signals.>>Recommended for use in PRIME metro signal areas. >> Receives full high definition TV broadcasts for a perfect picture
	
</font></p>
    <p>Product Code:<input type="text" name="productCode" required="required"  value="<?php if(isset($edit_product)) echo $edit_product->productCode;?>" /></p> 
    <p>Select combination of Sub category - Group code
  <?php
  $dbVal=""; 
  if($edit_product->subCategory && $edit_product->groupCode ){
  	$dbVal= $edit_product->subCategory.">>".$edit_product->groupCode;
  }
  if(!$edit_product->subCategory && $edit_product->groupCode )
  {
	  	$dbVal=" >>".$edit_product->groupCode;  
  }
  echo $dbVal;
  	?>
    <select name="subCategory" >
    <option value="" >Select Statrum & Sub Category</option>
    <?php 

	for($j=0; $j< count($groupNcat); $j++){
		$val="";
			if($groupNcat[$j]->subGDescription && $groupNcat[$j]->groupCode){		
				$val= strtoupper($groupNcat[$j]->subGDescription).">>".strtoupper($groupNcat[$j]->groupCode);
			}
			
			$selected="";
			if($dbVal == $val){
				$selected = 'selected="selected"';
			}
		?>
    		<option   value="<?php echo $val;?>" <?php echo $selected;?>><?php echo $val;?></option>
 <?php }
 for($j=0; $j< count($get_group); $j++){
		$val="";
			if($groupNcat[$j]->subGDescription && $get_group[$j]->groupCode){		
				$valgroup= " >>".strtoupper($get_group[$j]->groupCode);
			}
			
			$selected="";
			if($dbVal == $valgroup){
				$selected = 'selected="selected"';
			}
		?>
    		<option   value="<?php echo $valgroup;?>" <?php echo $selected;?>><?php echo $valgroup;?></option>
 <?php }?>
 
    </select>  <script type="application/javascript">
     function confirm_val(para){
		if(confirm('Do you want to Delete !')){
			if(!para){
			window.location='?page=pro-search&id=<?php echo $edit_product->productCode;?>';
			}
			if(para =="thumb_"){
			window.location='?page=pro-search&id='+para+'<?php echo $edit_product->productCode;?>';
			}
			if(para =="pdf"){
			window.location='?page=pro-search&type=y&id=<?php echo $edit_product->productCode;?>';
			}
			
		}
		else{
			return false;
		}
	 }
     </script>
    <p>APN: <input type="text" name="APN" value="<?php if(isset($edit_product)) echo $edit_product->APN;?>" /></p>
    <p>productTitle: <input type="text" size="30" name="productTitle" required="required"   value="<?php if(isset($edit_product)) echo $edit_product->productTitle;?>" /></p>   
	<?php 
	$url=network_home_url();
	$image_url = @getimagesize($url."/wp-content/files/".$edit_product->productCode.".jpg") ? $url."/wp-content/files/".$edit_product->productCode.".jpg" : NULL;
	$thumbLine = @getimagesize($url."/wp-content/files/thumb_".$edit_product->productCode.".jpg") ? $url."/wp-content/files/thumb_".$edit_product->productCode.".jpg" : NULL;
if($image_url){?>
	<p>Product Image: <img src="<?php echo $image_url;?>" alt="images (1)" width="73" height="74">    &nbsp; &nbsp;<input type="button" name="deleteImage" value="Delete Image" onclick="confirm_val('')" /></p>

    <?php }
	if($image_url == NULL){?>
    <div class="mainbox">Select Product Image
 <input size="50" class="text"  type="file" name="example-jpg-file" onchange="readURL(this);" /><font style="color:#00F">Image Name Should be same as product code, size should be 2000*2000,Plain background and JPEG formate</font>
 </div>
<?php }
	if($thumbLine){?>
    <p>Product Thumb Line: <img src="<?php echo $image_url;?>" alt="images (1)" width="73" height="74">
    &nbsp; &nbsp;<input type="button" name="deleteImage" value="Delete Image" onclick="confirm_val('thumb_')" /></p>
   <?php }
   if($thumbLine == NULL){?>
   		<div class="mainbox">Select Product Thumb line Image
 <input size="50" class="text"  type="file" name="thumbline" onchange="readURL(this);" /><font style="color:#00F">Image Name Should be same as <strong>thumb_product code</strong>, Plain background and JPEG formate</font>
 </div>
<?php  }  ?>
    <p>productDescription: <textarea  required="required"  name="productDescription" rows="10" cols="20"  value="<?php if(isset($edit_product)) echo $edit_product->productDescription;?>"><?php if(isset($edit_product)) echo $edit_product->productDescription;?></textarea></p>
    <p>specification: <textarea required="required"   name="specification" rows="10" cols="20"  value="<?php if(isset($edit_product)) echo $edit_product->specification;?>" ><?php if(isset($edit_product)) echo $edit_product->specification;?></textarea>
    <font style="color:#00F"> Kindly check above example</font>
    </p>
        <p>Brand: <input type="text" name="brand"  required="required"  value="<?php if(isset($edit_product)) echo $edit_product->brand;?>" /></p>
        
        <?php print_r($edit_product->userPdf);?>
<p>User PDF:  <div class="mainbox"><?php if($edit_product->userPdf){ echo "<strong>Present Specification: ".$edit_product->userPdf."</strong>";?><input type="hidden" name="pdf" value="<?php echo $edit_product->userPdf;?>" /><input type="button" name="deleteImage" value="Delete PDF" onclick="confirm_val('pdf')" /> <?php } ?>Select User PDF <input size="50" class="text"  type="file" name="userPdf" /></div></p>
    <p>whereToBuy: <input type="text" name="whereToBuy"  required="required"  value="<?php if(isset($edit_product)) echo $edit_product->whereToBuy;?>" /></p>
   <?php if($edit_product->approved =="Y"){

			$option="   <option value='$edit_product->approved' selected='selected'>Publish</option>
			 <option value='N'>Draft</option>";
  		 }
		if($edit_product->approved =="N"){
			$option="   <option value='$edit_product->approved' selected='selected'>Draft</option>
			 <option value='Y'>Publish</option>";
			
  		 }
		if($edit_product->approved ==""){

			$option=" <option value='N'>Draft</option>
			 <option value='Y'>Publish</option>";
	
		}
      
   ?>
    <p>approved: <select  name="approved" >
   <?php echo $option; ?>
    </select><!-- <input type="text" name="approved" required="required"   value="<?php // if(isset($edit_product)) echo $edit_product->approved;?>" /><font style="color:#00F">Write "Y" or "N" If you want to show this in to the website</font> --></p> 

<?php 

}

/*This function display search option*/
function pro_search_box(){

	global $search_data ;
	$search_data = $_POST;
		?>

<div class="wrap">
  <div class="icon32" id="icon-edit"><br></div>
     
      <form method="post" action="?page=pro-search" id="bor_form_action">
       <p>
       <input type="button" class="button-secondary" value="<?php _e('Add a new Product')?>" onclick="window.location='?page=pro-search&amp;action=add'" />
    </p>
<table class="widefat page fixed" cellpadding="0">
      <thead>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><?php _e('Product Code')?></th>
          <th class="manage-column"><?php _e('Group Code')?></th>
          <th class="manage-column"><?php _e('Sub Category')?></th>
          <th class="manage-column"><?php _e('Exclusive')?></th>
             <th class="manage-column"><?php _e('Search')?></th>
        
        </tr>
      </thead>
      <tbody>
      <tr><td> <input type="checkbox"/></td>
      <td><input type="text" name="productCode" id="productCode" value="<?php  if(isset($search_data['productCode'])) echo $search_data['productCode'];?>"/>   </td>
      <td><input type="text" name="groupCode" id="groupCode" value="<?php  if(isset($search_data['groupCode'])) echo $search_data['groupCode'];?>" /> </td>
      <td><input type="text" name="subCategory" id="subCategory" value="<?php  if(isset($search_data['subCategory'])) echo $search_data['subCategory'];?>" /> </td>
       <td><input type="text" name="whereToBuy" id="whereToBuy" value="<?php  if(isset($search_data['whereToBuy'])) echo $search_data['whereToBuy'];?>" /> </td>
   
	  <td><input type="Submit" name="Search" value="<?php _e('Search')?>"  class="button-secondary" /></td>
      </tr>
      </tbody>
      </table>
      </form>
      </div>
	
	<?php
 }


/*This function will display search result*/
function pro_manage_product(){
	global $query_data;
	
?>
<div class="wrap">
  <div class="icon32" id="icon-edit"><br></div>
  <h2><?php _e('Product Update Options') ?></h2>
  <form method="post" action="?page=pro-search" id="bor_form_action">
    <p>
       <input type="button" class="button-secondary" value="<?php _e('Add a new Product')?>" onclick="window.location='?page=pro-search&amp;action=add'" />
    </p>
    <table class="widefat page fixed" cellpadding="0">
      <thead>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><a href="?page=pro-search&amp;sort=productCode"><?php _e('Product Code')?></a></th>
          <th class="manage-column"><?php _e('Stratum')?></th>
          <th class="manage-column"><?php _e('Sub Category')?></th>
          <th class="manage-column"><?php _e('Product Title')?></th>
   		 <th class="manage-column"><?php _e('Product Description')?></th>
         <th class="manage-column"><?php _e('Specification')?></th>
         <th class="manage-column"><?php _e('Exclusive')?></th>
         <th class="manage-column"><?php _e('Image')?></th>
		
        </tr>
      </thead>
      <tfoot>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><?php _e('Product Code')?></th>
          <th class="manage-column"><?php _e('Stratum')?></th>
          <th class="manage-column"><?php _e('Sub Category')?></th>
          <th class="manage-column"><?php _e('Product Title')?></th>
          <th class="manage-column"><?php _e('Product Description')?></th>
          <th class="manage-column"><?php _e('Specification')?></th>
         <th class="manage-column"><?php _e('Exclusive')?></th>
         <th class="manage-column"><?php _e('Image')?></th>
		
        </tr>
      </tfoot>
      <tbody>
        <?php
		 $table = pro_get_searchResult();
		
          if($table){
           $i=0;
           foreach($table as $product) { 
               $i++;
        ?>
      <tr class="<?php echo (ceil($i/2) == ($i/2)) ? "" : "alternate"; ?>">
        <th class="check-column" scope="row">
          <input type="checkbox" value="<?php echo $product->productCode; ?>" name="pro_id[]" />
        </th>
          <td>
          <strong><?php echo $product->productCode;?></strong>
          <div class="row-actions-visible">
          <span class="edit"><a href="?page=pro-search&amp;code=<?php echo $product->productCode?>&amp;action=edit">Edit</a> </span>
          
          </div>
          </td>
         
          <td><?php echo $product->groupCode;?></td>
          <td><?php echo $product->subCategory;?></td>
          <td><?php echo $product->productTitle;?></td>
           <td><?php echo $product->productDescription;?></td>
           <td><?php echo $product->specification;?></td>
             <td><?php echo $product->whereToBuy;?></td>  
             <?php 
			 $url=network_home_url();
			 	$image_url = @getimagesize($url."/wp-content/files/".$product->productCode.".jpg") ? network_home_url()."/wp-content/files/".$product->productCode.".jpg" : "NO Image";
?>
             <td><?php 
			 
			 if($image_url){?>
	 <img src="<?php echo $image_url;?>" alt="images (1)" width="33" height="34">
   <?php }
			 ?></td>  
             
               <td><?php echo $product->brand;?></td>
               
        </tr>
        <?php
           }
        }
        else{   
      ?>
        <tr><td colspan="4"><?php _e('There are no data.')?></td></tr>   
        <?php
      }
        ?>   
      </tbody>
    </table>
    <p>
        
        <input type="button" class="button-secondary" value="<?php _e('Add a new software')?>" onclick="window.location='?page=pro-search&amp;edit=true'" />
    </p>

  </form>
</div>
<?php
}
?>