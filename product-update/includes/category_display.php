<?php
 function add_category(){
	if($_GET['action'] == 'edit'){
		$detail= Edit_category($_GET['code']);
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
	
	 ?>
     <script type="application/javascript">
     function confirm_val(){
		if(confirm('Do you want to Delete this image')){
			window.location='?page=add-cat&id=<?php echo $detail[0]->groupCode;?>';
		}
		else{
			return false;
		}
	 }
     </script>
       <p>Group Code:<input type="text" name="groupCode" required value="<?php if($detail[0]->groupCode){ echo $detail[0]->groupCode;}?>" /></p> 
       <p>Group Description:<input type="text" name="groupDescription" value="<?php if($detail[0]->groupDescription){ echo $detail[0]->groupDescription;}?>"  required /></p> 
       <p>Class Code:<input type="text" name="classCode" value="<?php if($detail[0]->classCode){ echo $detail[0]->classCode;}?>"  required /></p> 
       
     <?php $url=network_home_url();
	 $image_url = @getimagesize($url."/wp-content/files/".$detail[0]->groupCode.".jpg") ? $url."/wp-content/files/".$detail[0]->groupCode.".jpg" : "";?>
      <?php 
	 
	   if($image_url){?>
      Category Image:   <img src="<?php echo $image_url;?>" alt="<?php echo $detail[0]->groupDescription;?>" width="33" height="34"> &nbsp; &nbsp;<input type="button" name="deleteImage" value="Delete Image" onclick="confirm_val()" />
      
	  <?php } else{ ?>
       <p>Category Image <input type="file" name="category_image"  /></p>

 <?php }?>
 	 <p>Publish :<select name="publish">
    			  <?php echo $option; ?>
			     </select></p>
 
 <?php }
 function pro_manage_category(){
	 
	global $query_data;
	
?>
<div class="wrap">
  <div class="icon32" id="icon-edit"><br></div>
  <h2><?php _e('Update Stratum') ?></h2>
  <form method="post" action="?page=add-cat" id="bor_form_action">
    <p>
       <input type="button" class="button-secondary" value="<?php _e('Add a new Stratum')?>" onclick="window.location='?page=add-cat&amp;action=add'" />
    </p>
    <table class="widefat page fixed" cellpadding="0">
      <thead>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><?php _e('Stratum Code')?></th>
          <th class="manage-column"><?php _e('Stratum Description')?></th>
          <th class="manage-column"><?php _e('Stratum Code')?></th>
   		 <th class="manage-column"><?php _e('Stratum Image')?></th>
       
        </tr>
      </thead>
      <tfoot>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><?php _e('Stratum Code')?></th>
           <th class="manage-column"><?php _e('Stratum Description')?></th>
          <th class="manage-column"><?php _e('Class Code')?></th>
   		 <th class="manage-column"><?php _e('Stratum Image')?></th>
		
        </tr>
      </tfoot>
      <tbody>
        <?php
		 $table = pro_get_category();
		
          if($table){
           $i=0;
           foreach($table as $category) { 
               $i++;
        ?>
      <tr class="<?php echo (ceil($i/2) == ($i/2)) ? "" : "alternate"; ?>">
        <th class="check-column" scope="row">
          <input type="checkbox" value="<?php echo $category->groupCode; ?>" name="pro_id[]" />
        </th>
          <td>
          <strong><?php echo $category->groupCode;?></strong>
          <div class="row-actions-visible">
          <span class="edit"><a href="?page=add-cat&amp;code=<?php echo $category->groupCode?>&amp;action=edit">Edit</a> </span>
          
          </div>
          </td>
         
          <td><?php echo $category->groupDescription;?></td>
          <td><?php echo $category->classCode;?></td>
           <?php $network=network_home_url();	$image_url = @getimagesize($network."/wp-content/files/".$category->groupCode.".jpg") ?$network."/wp-content/files/".$category->groupCode.".jpg" : "";
?>
             <td><?php 
			 if($image_url){?>
							 <img src="<?php echo $image_url;?>" alt="images (1)" width="33" height="34">
				   <?php } ?></td></tr>
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
        
        <input type="button" class="button-secondary" value="<?php _e('Add a new Stratum')?>" onclick="window.location='?page=add-cat&amp;edit=true'" />
    </p>

  </form>
</div>
<?php
}


 ?>