<td style="border-bottom:2px solid transparent;height:30px;">
	<table width="100%" CELLSPACING="0">
		<tr>
			<td style="width:31px;"> 
			</td>
			<td style="width:40px;">
				<?php echo '<b>'.$saison->getNumero().'</b> x <b>'.$saison->getChiffreTop($i).'</b>' ?>
			</td>
			<td style="<?php if($sf_user->getAttribute("admin")){ echo 'width:290px;'; }else{ echo 'width:320px;'; } ?>">
				- <i><span class="titreEp">???</span></i>
			</td>
			<td style="width:65px;">
				<span class="qualiteEp">
					<i>
						???
					</i>
				</span>
			</td>
			<td align="right" style="width:80px;">
				<span class="versionEp">
					<b>
						???
					</b>
				</span>
			</td>
			<?php if($sf_user->getAttribute("admin")){ ?>
			<td align="right" style="width:30px;">
				<a href="" onClick="$('.new').hide();$('.edit').hide();$('.visnot').show();$('.vis').show();$('#visnotEp<?php echo $i; ?>').hide();$('#newEp<?php echo $i; ?>').show();return false;">
					<img src="/images/new.png" width="25"/>
				</a>
			</td>
			<?php } ?>
		</tr>
	</table>
</td>