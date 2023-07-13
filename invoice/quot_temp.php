<?php
	if(isset($_GET['shop'])){
		$shop=$_GET['shop'];
		include('../action/class.php');
		$obj=new database();
	}
?>
<table class="table table-bordered table-condensed">
	<tr class="bg-primary">	
    	<th style="text-align:center">Sl no</th>
    	<th style="text-align:center">Particulars</th>
    	<th style="text-align:center">Quantity</th>
    	<th style="text-align:center">Price</th>
    	<th style="text-align:center">Charity</th>
    	<th style="text-align:center">Discount</th>
    	<th style="text-align:center">Customer Disc(%)</th>
    	<th style="text-align:center">Taxable Value</th>
<!--<th style="text-align:center" style="display: none;">GST</th>-->
    	<th style="text-align:center">Amount</th>
    	<th style="text-align:center">Action</th>
    </tr>
    <?php
		$select_temp=$obj->get_rows("`quot_temp`","*","`shop`='$shop'");
		$i=0;
		$amount=0;
		if(is_array($select_temp)){
			foreach($select_temp as $temp){$i++;
	?>
    <tr>
    	<td align="center"><?php echo $i;  ?></td>
    	<td align="left">
			<?php  
				$cat=$obj->get_details("`category`","`name`","`id`='".$temp['category']."'"); 
		 		$comp=$obj->get_details("`company`","`name`","`id`='".$temp['company_id']."'"); 
				echo $cat['name']."-".$comp['name']."<br>".$temp['model']; 
				if($temp['slno']!=''){echo "<br>Sl.no. : ".$temp['slno']; } 
			?>
        </td>
    	<td align="center"><?php echo $temp['quantity'];  ?></td>
    	<td align="center"><?php echo toDecimal($temp['price']);  ?></td>
    	<td align="center"><?php echo toDecimal($temp['charity']);  ?></td>
    	<td align="center"><?php echo toDecimal($temp['discount']);  ?></td>
    	<td align="center"><?php echo $temp['custdiscount'];  ?></td>
    	<td align="center"><?php echo toDecimal($temp['taxable']);  ?></td>
    	<td align="center" style="display: none;">
			<?php 
				if($temp['cgst']!=0){echo "CGST : ".$temp['cvalue']."<br>";}  
				if($temp['sgst']!=0){echo "SGST : ".$temp['svalue'];}  
				if($temp['igst']!=0){echo "IGST : ".$temp['ivalue'];}  
			?>
        </td>
    	<td align="center"><?php echo toDecimal($temp['amount']);  ?></td>
        <td align="center">
        	<!--<button type="button" class="btn btn-primary btn-xs fa fa-edit" title="Edit"></button>-->
        	<button type="button" class="btn btn-danger btn-xs fa fa-trash" title="Delete" 
            		onClick="deleteTemp('<?php echo $temp['id']; ?>')"></button>
        </td>
    </tr>
    <?php
				$amount+=$temp['amount'];
			}
		}
		$amount = twoDigits($amount);
		$total=round($amount);
		$round=$total-$amount;
		$round = twoDigits($round);
	?>
</table>
<input type="hidden" id="temp_amount" value="<?php echo $amount; ?>" />
<input type="hidden" id="temp_round" value="<?php echo $round; ?>" />
<input type="hidden" id="temp_total" value="<?php echo $total; ?>" />