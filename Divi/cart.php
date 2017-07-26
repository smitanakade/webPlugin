<?php 
if(isset($_POST['submit'])){
	foreach ($_POST['quantity'] as $key => $val){
		if($val==0){
			unset($_SESSION['cart'][$key]);
		}
		else{
			$_SESSION['cart'][$key]['quantity']= $val;
		}
	}
}
?>
<h1>View Cart</h1>
<form method="post" action="?page=cart">
<table>
	<tr>
    <th>Part Code</th>
    <th>Trade Price</th>
    <th> Quantity</th>
    <th>Items Price</th>
    </tr>
    <?php 
	if($_SESSION['cart']){
    $sql="SELECT * FROM aa_2r53c_spareparts WHERE partnumber IN (";
						foreach($_SESSION['cart'] as $id =>$value){
							$sql.="'".$id."',";
						}
							$sql=substr($sql,0, -1).")";
							$session= $wpdb->get_results($sql);
							if($session){
								$totalPrice=0;
								foreach ($session as $row){
									$subtotal = $_SESSION['cart'][$row->partnumber]['quantity']*$row->tradeprice ;
									$totalPrice+=$subtotal;
									echo "<tr><td>".$row->partnumber."</td>";
									echo "<td> $".$row->tradeprice."</td>";
									echo"<td><input type='text' name='quantity[".$row->partnumber."]' size='5' value='".$_SESSION['cart'][$row->partnumber]['quantity']."'></td>"	;
									echo "<td> $".$_SESSION['cart'][$row->partnumber]['quantity']*$row->tradeprice."</td>";
								}
								 ?>
                                 <tr><td><strong>Total Price: $<?php echo $totalPrice;?></strong></td></tr>
                                 </table><br>
<button type="submit" name="submit">Update Cart</button>
							<?php } }
	else{
		echo "Cart is empty!";
	}
							
							?>
</table>
