<?php

$num_columns	= 6;
$can_delete	= $this->auth->has_permission('Plant.Management.Delete');
$can_edit		= $this->auth->has_permission('Plant.Management.Edit');
$has_records	= isset($records) && is_array($records) && count($records);

if ($can_delete) {
    $num_columns++;
}
?>
<div class='admin-box'>
		<h3><?php echo lang('plant_area_title'); ?></h3>
		<div class="pull-right">
			<?php echo form_open($areaUrl , 'class="form-horizontal"'); ?>
			<input type="text" name="search_terms" class="form-control"  value="" placeholder="Search for..." />
			<input type="submit" name="submit" class="btn btn-primary" value="search" />
			<?php echo form_close(); ?>
		</div>
	<?php echo form_open($this->uri->uri_string()); ?>
		<table class='table table-striped'>
			<thead>
				<tr>
					<?php if ($can_delete && $has_records) : ?>
					<th class='column-check'><input class='check-all' type='checkbox' /></th>
					<?php endif;?>
					
					<th style="text-align:left;"><?php echo lang('plant_field_area_code'); ?></th>
					<th style="text-align:left;"><?php echo lang('plant_field_plant_code'); ?></th>
					<th style="text-align:left;"><?php echo lang('plant_field_plant_name'); ?></th>
					<!--th><?php echo lang('plant_field_glass_meter'); ?></th>
					<th><?php echo lang('plant_field_gas_inputs'); ?></th>
					<th><?php echo lang('plant_field_kpi'); ?></th-->
					<th style="text-align:left;"><?php echo lang('plant_column_deleted'); ?></th>
					<th style="text-align:left;"><?php// echo lang('plant_column_created'); ?></th>
					<th style="text-align:left;"><?php// echo lang('plant_column_modified'); ?></th>
				    <th style="text-align:left;"><?php echo e('Edit'); ?></th>
				</tr>
			</thead>
			<?php if ($has_records) : ?>
			<tfoot>
				<?php if ($can_delete) : ?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'>
						<?php echo lang('bf_with_selected'); ?>
						<input type='submit' name='delete' id='delete-me' class='btn btn-danger' value="<?php echo lang('bf_action_delete'); ?>" onclick="return confirm('<?php e(js_escape(lang('plant_delete_confirm'))); ?>')" />
					</td>
				</tr>
				<?php endif; ?>
			</tfoot>
			<?php endif; ?>
			<tbody>
				<?php
				if ($has_records) :
					foreach ($records as $record) :
						// var_dump($record);
				?>
				<tr>
					<?php if ($can_delete) : ?>
					<td class='column-check'><input type='checkbox' name='checked[]' value='<?php echo $record->id; ?>' /></td>
					<?php endif;?>
					<td style="text-align:left;"><?php e($record->area); ?></td>
					<td style="text-align:left;"><?php e($record->plant_code); ?></td>
					<td style="text-align:left;"><?php e($record->plant_name); ?></td>
					<!--td><?php e($record->size); ?></td>
					<td><?php e($record->gas_inputs); ?></td>
					<td><?php e($record->kpi); ?></td-->
					<td style="text-align:left;"><?php echo $record->deleted > 0 ? lang('plant_true') : lang('plant_false'); ?></td>
					<td style="text-align:left;"><?php// e($record->created_on); ?></td>
					<td style="text-align:left;"><?php// e($record->modified_on); ?></td>
					<?php if ($can_edit) : ?>
					<td style="text-align:left;"><?php echo anchor(SITE_AREA . '/management/plant/edit/' . $record->id, '<span class="icon-pencil"></span> '); ?></td>
				<?php endif; ?>
				</tr>
				<?php
					endforeach;
				else:
				?>
				<tr>
					<td colspan='<?php echo $num_columns; ?>'><?php echo lang('plant_records_empty'); ?></td>
				</tr>
				<?php endif; ?>
			</tbody>
		</table>
	<?php
    echo form_close();
    
    echo $this->pagination->create_links();
    ?>
</div>