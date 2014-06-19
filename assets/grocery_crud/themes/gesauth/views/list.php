<?php $uniqid = uniqid();?>
<table cellpadding="0" cellspacing="0" border="0" class="display groceryCrudTable" id="<?php echo $uniqid; ?>">
	<thead>
		<tr>
			<th class='checked' style="display:none;">
				<input type="checkbox" name="all_chbx" id="all_chbx" value="" />
			</th>
			<th class='lines'><?php echo $this->l('list_lines');?></th>
			<?php foreach($columns as $column){?>
				<th><?php echo $column->display_as; ?></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<th class='actions'><?php echo $this->l('list_actions'); ?></th>
			<?php }?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($list as $num_row => $row){ ?>
		<tr id='<?php echo $row->id?>'>
			<td class='checked' style="display:none;">
				<input type="checkbox" name="chbx_<?php echo $num_row;?>" id="chbx_<?php echo $num_row;?>" value="<?php echo $row->id?>" />
			</td>
			<td name="lines" style="text-align:center;">
				<?php echo $num_row+1;?>
			</td>
			<?php foreach($columns as $column){?>
				<td name="<?php echo $column->field_name;?>"><?php echo $row->{$column->field_name}?></td>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
			<td class='actions'>
				<table>
				<tr>
				<?php if(!$unset_read){?>
					<td style="border: 1px solid transparent; padding: 3px 3px;">
					<a href="<?php echo $row->read_url?>" class="DTTT_button edit_button ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-document"></span>
						<span class="ui-button-text">&nbsp;<?php echo $this->l('list_view'); ?></span>
					</a>
					</td>
				<?php }?>

				<?php if(!$unset_edit){?>
					<td style="border: 1px solid transparent; padding: 3px 3px;">
					<a href="<?php echo $row->edit_url?>" class="DTTT_button edit_button ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-pencil"></span>
						<span class="ui-button-text">&nbsp;<?php echo $this->l('list_edit'); ?></span>
					</a>
					</td>
				<?php }?>
				<?php if(!$unset_delete){?>
					<?php
					$tab = explode('/',$row->delete_url);
					$itab = count($tab)-1;
					$id = str_replace('.','_',$tab[$itab]);
				?>
					<td style="border: 1px solid transparent; padding: 3px 3px;">
					<a id="delete_<?php echo $id?>" onclick = "javascript: return delete_row('<?php echo $row->delete_url?>', '<?php echo $num_row?>')"
						href="javascript:void(0)" class="DTTT_button delete_button ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
						<span class="ui-button-icon-primary ui-icon ui-icon-circle-minus"></span>
						<span class="ui-button-text">&nbsp;<?php echo $this->l('list_delete'); ?></span>
					</a>
					</td>
				<?php }?>
				<?php
				if(!empty($row->action_urls)){
					foreach($row->action_urls as $action_unique_id => $action_url){
						$action = $actions[$action_unique_id];
				?>
						<td style="border: 1px solid transparent; padding: 3px 3px;">
						<a href="<?php echo $action_url; ?>" class="DTTT_button <?php echo $action->css_class; ?> edit_button ui-state-default ui-corner-all ui-button-text-icon-primary" role="button">
							<span class="ui-button-icon-primary ui-icon <?php echo $action->css_class; ?> <?php echo $action_unique_id;?>"></span><span class="ui-button-text">&nbsp;<?php echo $action->label?></span>
						</a>
						</td>
				<?php }
				}
				?>
				</tr>
				</table>
			</td>
			<?php }?>
		</tr>
		<?php }?>
	</tbody>
	<tfoot>
		<tr>
				<th style="display:none;"><input style="display:none;" type="text" name="checkbox" class="search_checkbox" /></th>
				<th><input style="display:none;" type="text" name="lines" class="search_lines" /></th>
			<?php foreach($columns as $column){?>
				<th><input type="text" name="<?php echo $column->field_name; ?>" placeholder="<?php echo $this->l('list_search').' '.$column->display_as; ?>" class="search_<?php echo $column->field_name; ?>" /></th>
			<?php }?>
			<?php if(!$unset_delete || !$unset_edit || !$unset_read || !empty($actions)){?>
				<th>
					<button class="DTTT_button ui-state-default ui-corner-all floatR" role="button" data-url="<?php echo $ajax_list_url; ?>" style="height:26px;">
						<span class="ui-button-icon-primary ui-icon ui-icon-refresh"></span><span class="ui-button-text">&nbsp;</span>
					</button>
					<a href="javascript:void(0)" role="button" class="DTTT_button ui-state-default ui-corner-all ui-button-text-icon-primary floatR">
						<span class="ui-button-icon-primary ui-icon ui-icon-arrowrefresh-1-e"></span>
						<span class="ui-button-text"><?php echo $this->l('list_clear_filtering');?></span>
					</a>
				</th>
			<?php }?>
		</tr>
	</tfoot>
</table>
<script type="text/javascript">
var uniqid = '<?php echo $uniqid; ?>';
</script>