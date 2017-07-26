<?php
 function add_subCategory(){
	if($_GET['action'] == 'edit'){
		$detail= Edit_subCategory($_GET['code']);
		 $sub = preg_replace('/\s+/', '', $detail[0]->SuCategory);     
	}
	if($detail[0]->publish=="P"){
		
			$option="   <option value='".$detail[0]->publish."' selected='selected'>Publish</option>
			<option value='D'>Draft</option>";
  		 }
		if($detail[0]->publish =="D"){
			$option="   <option value='".$detail[0]->publish."' selected='selected'>Draft</option>
			<option value='P'>Publish</option>";
		 }
		if(!$detail[0]->publish ){
			$option=" <option value='D'>Draft</option>
			 <option value='P'>Publish</option>";
		
		}
		$sub = $string = preg_replace('/\s+/', '', $detail[0]->subGDescription);

	 ?>
     
     <script type="application/javascript">
     function confirm_val(){
		if(confirm('Do you want to Delete this image')){
			window.location='?page=add-sub&id=<?php echo $detail[0]->groupCode."_".$sub;?>';
		}
		else{
			return false;
		}
	 }
     </script>
       <p>Sub Category:<input type="text" name="subGDescription" required value="<?php if($detail[0]->subGDescription){ echo $detail[0]->subGDescription;}?>" /></p> 
       <p>Group Code:<input type="text" name="groupCode" value="<?php if($detail[0]->groupCode){ echo $detail[0]->groupCode;}?>"  required /></p> 
       <p>Class Code:<input type="text" name="classCode" value="<?php if($detail[0]->classCode){ echo $detail[0]->classCode;}?>"  required /></p> 

 <?php		
 		
 			$network=network_home_url();
		   	$image_url = @getimagesize($network."/wp-content/files/".$detail[0]->groupCode."_".$sub.".jpg") ? $network."/wp-content/files/".$detail[0]->groupCode."_".$sub.".jpg" : " ";
			
?>
      <?php  if($image_url !=" "){?>
      Category Image:   <img src="<?php echo $image_url;?>" alt="<?php echo $detail[0]->subGDescription;?>" width="33" height="34">&nbsp; &nbsp;<input type="button" name="deleteImage" value="Delete Image" onclick="confirm_val()" />
         
	  <?php } else{ ?>
			       <p>Sub Category Image <input type="file" name="subcategory_image"  /></p>   
		 <?php } ?>
 
	 <p>Publish :<select name="publish">
    			  <?php echo $option; ?>
			     </select></p>
 <?php }
 
 
 
 function pro_manage_subCategory(){
	 
	global $query_data;
	
?>
<div class="wrap">
  <div class="icon32" id="icon-edit"><br></div>
  <h2><?php _e('Update Sub Category') ?>  </h2>

  <form method="post" action="" id="bor_form_action">
    <p>
       <input type="button" class="button-secondary" value="<?php _e('Add a new Sub Category')?>" onclick="window.location='?page=add-sub&amp;action=add'" />
    </p>
    <table class="widefat page fixed" cellpadding="0">
      <thead>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><?php _e('Sub Category')?></th>
          <th class="manage-column"><?php _e('Group Code')?></th>
   		 <th class="manage-column"><?php _e('Sub Category Image')?></th>
       
        </tr>
      </thead>
      <tfoot>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><?php _e('Sub Category')?></th>
           <th class="manage-column"><?php _e('Group Code')?></th>
   		 <th class="manage-column"><?php _e('Sub Category Image')?></th>
		
        </tr>
      </tfoot>
      <tbody>
        <?php
		 $table = pro_get_subCategory();
		
          if($table){
           $i=0;
           foreach($table as $subcategory) { 
               $i++;
        ?>
      <tr class="<?php echo (ceil($i/2) == ($i/2)) ? "" : "alternate"; ?>">
        <th class="check-column" scope="row">
          <input type="checkbox" value="<?php echo $subcategory->subGCode; ?>" name="pro_id[]" />
        </th>
          <td>
          <strong><?php echo $subcategory->subGDescription;?></strong>
          <div class="row-actions-visible">
          <span class="edit"><a href="?page=add-sub&amp;code=<?php echo $subcategory->subGCode;?>&amp;action=edit">Edit</a> </span>
          
          </div>
          </td>
         
          <td><?php echo $subcategory->groupCode;?></td>
       
           <?php 
		   $sub = $string = preg_replace('/\s+/', '', $subcategory->subGDescription);

		   $network=network_home_url();
		   	$image_url = @getimagesize($network."/wp-content/files/".$subcategory->groupCode."_".$sub.".jpg") ? $network."/wp-content/files/".$subcategory->groupCode."_".$sub.".jpg" : " ";
?>
             <td><?php 
			 
			 if($image_url){
			  ?> <img src="<?php echo $image_url;?>" alt="images (1)" width="33" height="34">
   <?php }
			 ?></td>  
             
                     
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
        
        <input type="button" class="button-secondary" value="<?php _e('Add a new Sub Category')?>" onclick="window.location='?page=add-sub&amp;edit=true'" />
    </p>

  </form>
</div>
<?php
}


 ?>