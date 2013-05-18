<?php
	$lien .= '?';
	if(sizeof($param)>0){
		foreach($param as $i => $p){
			$lien .= $i.'='.$p.'&';
		}
	}
?>
<table id="tableLettre" width="95%" class="centre" cellspacing="2">
	<tr>
		<?php if($lettre=='autre'){
				$lettreSel='lettreSel';
				$javascript='';
			}else{
				$lettreSel='';
				$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for($lien.'le=autre') .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
				//$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="lettre(\''. url_for('video/index?le=autre&t='.$type) .'\',\'autre\');return false;" onMouseOut="this.style.backgroundColor=\'\';"';
			}?>
		<td width="3.5%" class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
				#
		</td>
		<?php for( $i='A';$i<'Z';$i++){?>
			
			<?php if($i==$lettre){
				$lettreSel='lettreSel';
				$javascript='';
			}else{
				$lettreSel='';
				$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for($lien.'le='.$i) .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
				//$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="lettre(\''. url_for('video/index?le='.$i.'&t='.$type) .'\',\''.$i .'\');return false;" onMouseOut="this.style.backgroundColor=\'\';"';
			}?>
			<td width="3.5%" class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
					<?php echo $i ?>
			</td>
		<?php } ?>
		<?php if($lettre=='Z'){
				$lettreSel='lettreSel';
				$javascript='';
			}else{
				$lettreSel='';
				$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="location.href=\''.url_for($lien.'le=Z') .'\'" onMouseOut="this.style.backgroundColor=\'\';"';
				//$javascript='onmouseover="this.style.backgroundColor=\'#e3d5b6\';style.cursor=\'pointer\';" onClick="lettre(\''. url_for('video/index?le=Z&t='.$type) .'\',\'Z\');return false;" onMouseOut="this.style.backgroundColor=\'\';"';
			}?>
		<td width="3.5%" class="<?php echo $lettreSel; ?>" <?php echo $javascript; ?> >
				Z
		</td>
	</tr>
</table>