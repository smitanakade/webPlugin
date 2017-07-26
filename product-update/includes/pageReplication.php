<?php 
function Page_replicate(){
	global $wpdb;
	
	$query = $wpdb->get_results("SELECT * FROM `wp_posts` WHERE `post_title` LIKE 'Test Replication'");
	/* Production Server Details */
		global $wpdb;
		$servername = "182.160.155.42";
		$username = "arlec";
		$password = "JX8+&@+juAZZ";
		$conn = mysql_connect($servername,$username,$password) or die(mysql_error()); 
	
	
	foreach($query as $data ) {
		$ID= $data->ID;
		$post_author= $data->post_author;
		$post_date=$data->post_date;
		$post_date_gmt=$data->post_date_gmt;
		$post_content= $data->post_content;
		$post_title=$data->post_title;
		$post_excerpt=$data->post_excerpt;
		$post_status=$data->post_status;
		$comment_status=$data->comment_status;
		$ping_status=$data->ping_status;
		$post_password=$data->post_password;
		$post_name=$data->post_name;
		$to_ping=$data->to_ping;
		$pinged=$data->pinged;
		$post_modified=$data->post_modified;
		$post_modified_gmt=$data->post_modified_gmt;
		$post_content_filtered=$data->post_content_filtered;
		$post_parent=$data->post_parent;
		$guid=$data->guid;
		$menu_order=$data->menu_order;
		$post_type=$data->post_type;
		$post_mime_type=$data->post_mime_type;
		$comment_count=$data->comment_count;
		
		//echo "insert into aa_2r53c_posts(post_author,post_date,post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged,
		//post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order,post_type,post_mime_type ,comment_count)
// values('".$post_author."','".$post_date."','".$post_date_gmt."','".$post_content."','".$post_title."','".$post_excerpt."','".$post_status."','".$comment_status."','".$ping_status."','".$post_password."','".$post_name."','".$to_ping."','".$pinged."','".$post_modified."','".$post_modified_gmt."','".$post_content_filtered."','".$post_parent."','".$guid."','".$menu_order."','".$post_type."','".$post_mime_type."','".$comment_count."')";
/*$insert_query=$wpdb->query("insert into aa_2r53c_posts(post_author,post_date,post_date_gmt, post_content, post_title, post_excerpt, post_status, comment_status, ping_status, post_password, post_name, to_ping, pinged,
		post_modified, post_modified_gmt, post_content_filtered, post_parent, guid, menu_order,post_type,post_mime_type ,comment_count)
 values('".$post_author."','".$post_date."','".$post_date_gmt."','".$post_content."','".$post_title."','".$post_excerpt."','".$post_status."','".$comment_status."','".$ping_status."','".$post_password."','".$post_name."','".$to_ping."','".$pinged."','".$post_modified."','".$post_modified_gmt."','".$post_content_filtered."','".$post_parent."','".$guid."','".$menu_order."','".$post_type."','".$post_mime_type."','".$comment_count."')");
*/
	$get_meta=$wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `post_id` =".$ID."");
	echo "<br/>";
	echo "SELECT ID from aa_2r53c_posts WHERE post_title='".$post_title."' AND post_status='publish'";
	echo "<br/>";
	
	$get_postId= "SELECT ID from aa_2r53c_posts WHERE post_title='".$post_title."' AND post_status='publish'";
	
	mysql_select_db('arlec_wordpress');
	$retval = mysql_query( $get_postId, $conn );
	$result=mysql_fetch_row($retval);
	
	$post_id= $result[0];
	
	foreach($get_meta as $meta){
	$meta_key= $meta->meta_key;
	$meta_value=$meta->meta_value;
echo 	"INSERT IN TO aa_2r53c_postmeta (post_id,meta_key,meta_value) values('".$post_id."','".$meta_key."','".$meta_value."')";
//	$insert_meta=$wpdb->query("INSERT IN TO aa_2r53c_postmeta (post_id,meta_key,meta_value) values('".$post_id."','".$meta_key."','".$meta_value."')");

	}
	}
}
?>