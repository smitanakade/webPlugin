<?php
/*
Template Name: Detail
*/

get_header();

$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() ); ?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$thumbnail = get_thumbnail( $width, $height, $classtext, $titletext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $titletext, $width, $height );
				?>

				<?php endif;
				global $wpdb;
				$field=$_GET['de'];
							$pageHeading = $wpdb->get_row("SELECT p.productTitle,p.subCategory,g.groupCode,g.groupDescription,c.classDescription,c.classCode FROM `aa_2r53c_groupdetail` as g,`aa_2r53c_classdetail` as c ,aa_2r53c_productdetails p  where p.productCode='".mysql_escape_string($field)."' AND g.classCode=c.classCode AND g.groupCode =p.groupCode ");					
		if(eregi('[a-zA-Z0-9]',$pageHeading->subCategory))
		{
			$subCat= $pageHeading->subCategory;
			
			$subCode=$wpdb->get_results("SELECT subGCode FROM `aa_2r53c_subgroup` WHERE subGDescription='".mysql_escape_string($pageHeading->subCategory)."' and groupCode ='".mysql_escape_string($pageHeading->groupCode)."'");
			$subId=$subCode[0]->subGCode;
		}else{
		$subCat=0;
		$subId=0;
		}
		if($pageHeading){
			
						the_breadcrumb('Our Product',$pageHeading->classDescription,$pageHeading->groupDescription,$pageHeading->classCode,$pageHeading->groupCode,$subCat,$subId); 
							}
							if(!$pageHeading){
							$pageHeading = $wpdb->get_row("SELECT * FROM `aa_2r53c_subgroup` as s, `aa_2r53c_classdetail` as c,`aa_2r53c_productdetails` as p, `aa_2r53c_groupdetail` as g WHERE s.groupCode=g.groupCode and s.classCode = c.classCode and s.subGCode= p.groupCode and p.productCode='".mysql_escape_string($field)."'");						
							the_breadcrumb('Our Product',$pageHeading->classDescription,$pageHeading->groupDescription,$pageHeading->classCode,$pageHeading->subGDescription,'',''); 
							}
							
							  $result = $wpdb->get_results("SELECT * FROM aa_2r53c_productdetails  WHERE productCode='".$field."'");
					?>
					<div class="entry-content">
			<?php		the_content();
						if ( ! $is_page_builder_used )
							wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'Divi' ), 'after' => '</div>' ) );					
						?>
                
				<div class="et_pb_row">
               				   
                          


               <?php foreach ($result as $row){
				   
								?>
					 <h1><span style="color: #444444;"><?php echo $row->productTitle;?></span></h1>		
			<div class="et_pb_column et_pb_column_1_2">
			<?php
			$url=network_home_url(); 
			$image_url = ($url."/wp-content/files/".$row->productCode.".jpg") ? $url."/wp-content/files/".$row->productCode.".jpg" :  $url."/wp-content/files/LVX913.jpg";
			?>
			<img src="<?php echo $image_url; ?>" alt="" class="et-waypoint et_pb_image et_pb_animation_left" />
		</div> <!-- .et_pb_column --><div class="et_pb_column et_pb_column_1_2">
			<div class="et_pb_text et_pb_bg_layout_light et_pb_text_align_left">
			

<p class="product-details__description"><strong>Product Description : </strong><p align="justify"><?php echo $row->productDescription; ?></p></p>
<p><strong>Product Code</strong> :<?php echo $row->productCode ;?></p>
<p><strong>APN</strong>                    : <?php echo $row->APN ;?></p>
<p> </p>
		</div> <!-- .et_pb_text -->
		</div> <!-- .et_pb_column -->
        <?php }?>
		</div> <!-- .et_pb_row --><div class="et_pb_row">
			<div class="et_pb_column et_pb_column_4_4">
			<div class="et_pb_tabs">
			<ul class="et_pb_tabs_controls clearfix">
				<li class="et_pb_tab_active"><a href="#">Specifications</a></li><li><a href="#">Where to buy</a></li><li><a href="#">Instruction</a></li>
			</ul>
			<div class="et_pb_all_tabs">
				<div class="et_pb_tab clearfix et_pb_active_content">
			
<div class="spec-row">
<?php $specification=  explode('>>',$row->specification);?>
<ul>
<?php for($i=0;$i< count($specification);$i++){
	echo "<li>".$specification[$i]."</li>";
}?>
</ul>
</div>

		</div> <!-- .et_pb_tab --><div class="et_pb_tab clearfix">
			
<p><?php //echo $row->whereToBuy; 
$whereToBuyLink= array( );
					$whereToBuyLink["COLES"] ="http://www.coles.com.au";
					$whereToBuyLink["KMART"]  ="http://www.kmart.com.au";
					$whereToBuyLink["BIGW"]  ="http://www.bigw.com.au";
					$whereToBuyLink["DANKS"]  ="http://www.danks.com.au";
					$whereToBuyLink["SPOTLIGHT"] = "http://www.spotlight.com.au";
					$whereToBuyLink["HARRIS SCARFE"]  = "http://www.harrisscarfe.com.au";
					$whereToBuyLink["MITRE 10 AU"] = "http://www.mitre10.com.au";
					$whereToBuyLink["BUNNINGS AU"]  = "http://www.bunnings.com.au";
					$whereToBuyLink["BUNNINGS NZ"] = "http://www.bunnings.co.nz";
					$whereToBuyLink["CONTACT ARLEC"] = "/contact-arlec/";

	 if(preg_match(">>",$row->whereToBuy))
	 {
		
		 $where =  explode('>>',$row->whereToBuy);
		 
	  	for($i=0;$i< count($where);$i++){		
				echo"<li><a href='".$whereToBuyLink[$where[$i]]."' target='_blank'>".$where[$i]."</a></li>";
			
		
		}

	 }else{
		
			if($whereToBuyLink[$row->whereToBuy]){
					echo"<li><a href='".$whereToBuyLink[$row->whereToBuy]."' target='_blank'>".$row->whereToBuy."</a></li>";
			}
			else{
				echo "<a href='#' target='_blank'>".$row->whereToBuy."</a>";
			}
	 }


?></p>


		</div> <!-- .et_pb_tab -->
	<!-- .et_pb_tab --><div class="et_pb_tab clearfix">
		
<p><?php if($row->userPdf){?>
<a href="<?php echo network_home_url();?>/wp-content/files/<?php echo $row->userPdf;?>" target="_blank">Download Instruction</a></p>
<?php }else{echo "No Instruction";}
?>

		</div> <!-- .et_pb_tab -->
    		</div> <!-- .et_pb_all_tabs -->
		</div> <!-- .et_pb_tabs -->
		</div> <!-- .et_pb_column -->
		</div> <!-- .et_pb_row -->
			
				
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->

			<?php get_sidebar(); ?>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php get_footer(); ?>