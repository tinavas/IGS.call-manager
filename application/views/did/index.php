		<?php 
		
			$_GET['dnis'] = isset($_GET['dnis']) ? $_GET['dnis']:'';
			$_GET['callid'] = isset($_GET['callid']) ? $_GET['callid']:''; 
			
			switch ($_GET['dnis']) {
				case '8552437989':
					$campaign = 'IGS Verif ComEd Dual ';
					break;
				case '3124651689':
					$campaign = 'IGS Verif IL TM Single ';
					break;
				case '3124651630':
					$campaign = 'IGS Verif IL TM Dual ';
					break;
				case '6304073796':
					$campaign = 'IGS Verif AGR OBTM ';
					break;
				case '8552437989':
					$campaign = 'IGS Verif ComEd Dual ';
					break;
				case '6304073797':
					$campaign = 'IGS Verif ComEd Single ';
					break;
				case '9892441696':
					$campaign = 'IGS Verif MI D2D ';
					break;
				case '6143494807':
					$campaign = 'IGS Verif OH D2D Single ';
					break;
				case '6144073627':
					$campaign = 'IGS Verif OH D2D Dual ';
					break;
				case '4122001042':
					$campaign = 'IGS Verif PA D2D Dual ';
					break;
				case '2152496056':
					$campaign = 'IGS Verif PA D2D Single ';
					break;
				case '2105268157':
					$campaign = 'Nicor ';
					break;
				default:
					$campaign = 'Unregistered DNIS number: ' . $_GET['dnis'];
					break;
			}
		?>
		
		<div class="clearFix"></div>
		<div class="contentBody w500">
			<div class="contentTitle">Incoming Call</div>
			<div class="clearFix"></div>
	        <div class="midcontentBody">
        		<div class="frm_container">
	        		<div class="frm_heading"><span>CALL ORIGIN</span></div>
	        		<div class="frm_inputs">
		        		<table>
		        			<tr>
								<td><?php echo $campaign; ?></td>
							</tr>
		        		</table>
	        		</div>
        		</div>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>DNIS NUMBER</span></div>
	        		<div class="frm_inputs">
		        		<table>
		        			<tr>
								<td><?php echo $_GET['dnis']; ?></td>
							</tr>
		        		</table>
	        		</div>
        		</div>
        		<div class="frm_container">
	        		<div class="frm_heading"><span>ACTION</span></div>
	        		<div class="frm_inputs">
		        		<table>
		        			<tr>
								<td><a href="<?php echo base_url();?>agent/quick/record/<?php echo '?did='.$_GET['dnis'].'&callid='.$_GET['callid'];?>">Make Quick Call Record</a></td>
							</tr>
		        		</table>
	        		</div>
        		</div>
	        </div>
	        <div class="clearFix"></div>
		</div>