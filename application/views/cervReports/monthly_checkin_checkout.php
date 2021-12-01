<div class="container bodycontainer">
<?php 
//echo round(abs(strtotime("10:50:47") - strtotime("03:42:58")) / 60,2). " minute";

$month_posted = $dataposted['monthfrom'];
//echo ''.$month_posted.'-21';
	if($TopInfo!=''){
		echo $TopInfo;
	}?>




    <div id="parent" style="margin-top: 20px;">
		<table id="fixTable" class="table table-bordered table-hover table-striped">
			<thead>
				<tr>
	
					<th rowspan="3">Vaccinator name</th>

				</tr>
				<tr>

					<th colspan="31">Dates</th>
				</tr>
				<tr>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
					<th>9</th>
					<th>10</th>
					<th>11</th>
					<th>12</th>
					<th>13</th>
					<th>14</th>
					<th>15</th>
					<th>16</th>
					<th>17</th>
					<th>18</th>
					<th>19</th>
					<th>20</th>
					<th>21</th>
					<th>22</th>
					<th>23</th>
					<th>24</th>
					<th>25</th>
					<th>26</th>
					<th>27</th>
					<th>28</th>
					<th>29</th>
					<th>30</th>
					<th>31</th>

				</tr>
			</thead>
			<tbody>
		<?php 
			foreach($PVRresult as $key => $val){ ?>
			<tr>
			<td><?php echo $val['technicianname']; ?></th>
			<td><?php if($val['checkin_date']==''.$month_posted.'-01'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-02'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-03'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-04'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-05'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-06'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-07'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-08'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-09'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-10'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-11'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-12'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-13'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-14'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-15'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-16'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-17'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-18'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-19'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-20'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title=""Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-21'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-22'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-23'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-24'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-25'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-26'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-27'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-28'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-29'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-30'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}?>			
			</td><td>
			<?php if($val['checkin_date']==''.$month_posted.'-31'){
				if((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 360){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:green;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 360) && ((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) > 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:blue;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';
				}else if(((round(abs(strtotime($val['checkout_time']) - strtotime($val['checkin_time']))/ 60,2)) < 240)){
				echo '<p class="text-center" title="CheckIn='.$val['checkin_time'].', CheckOut= '.$val['checkout_time'].'" style="color:yellow;font-weight: bold;font-size: 16px;"><i class="fa fa-check"></i></p>';					
				} ?>
			
			<?php }else{
				echo '<p class="text-center" title="Not checked-In" style="color:red;font-weight: bold;font-size: 16px;"><i class="fa fa-times"></i></p>';				
			}}?>			
			</td>
			</tr>
			</tbody>
		</table>
	</div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://pace-tech.com/dev/epimis/includes/js/tableHeadFixer.js"></script>
<script src="http://pace-tech.com/dev/epimis/includes/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#fixTable").tableHeadFixer({"left" : 1});
	});
</script>		</div>
