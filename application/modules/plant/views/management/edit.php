<?php

if (validation_errors()) :
?>
<div class='alert alert-block alert-error fade in'>
    <a class='close' data-dismiss='alert'>&times;</a>
    <h4 class='alert-heading'>
        <?php echo lang('plant_errors_message'); ?>
    </h4>
    <?php echo validation_errors(); ?>
</div>
<?php
endif;

$id = isset($plant->id) ? $plant->id : '';

?>
<div class='admin-box'>
    <h3><?php echo lang('plant_area_title'); ?></h3>
    <?php echo form_open($this->uri->uri_string(), 'class="form-horizontal"'); ?>
        <fieldset>
            

            <?php 
                echo form_dropdown(array('name' => 'area_id', 'required' => 'required'), $options, set_value('area_id', isset($plant->area_id) ? $plant->area_id : ''), lang('plant_field_area_code') . lang('bf_form_label_required'));
            ?>

            <div class="control-group<?php echo form_error('plant_code') ? ' error' : ''; ?>">
                <?php echo form_label(lang('plant_field_plant_code') . lang('bf_form_label_required'), 'plant_code', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='plant_code' type='text' required='required' name='plant_code' maxlength='5' value="<?php echo set_value('plant_code', isset($plant->plant_code) ? $plant->plant_code : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('plant_code'); ?></span>
                </div>
            </div>

            <div class="control-group<?php echo form_error('plant_name') ? ' error' : ''; ?>">
                <?php echo form_label(lang('plant_field_plant_name') . lang('bf_form_label_required'), 'plant_name', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='plant_name' type='text' required='required' name='plant_name' maxlength='50' value="<?php echo set_value('plant_name', isset($plant->plant_name) ? $plant->plant_name : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('plant_name'); ?></span>
                </div>
            </div>
			
            <?php 
                // echo form_dropdown(array('name' => 'glass_meter', 'required' => 'required'), $glass, set_value('glass_meter', isset($plant->glass_meter) ? $plant->glass_meter : ''), lang('plant_field_glass_meter') . lang('bf_form_label_required'));
            ?>
            <?php 
                // echo form_dropdown(array('name' => 'gas_inputs', 'required' => 'required'), array(''=>'-','M3'=>'M3','NM3'=>'NM3'), set_value('gas_inputs', isset($plant->gas_inputs) ? $plant->gas_inputs : ''), lang('plant_field_gas_inputs') . lang('bf_form_label_required'));
            ?>
			
			<!--div class="control-group<?php echo form_error('kpi') ? ' error' : ''; ?>">
                <?php echo form_label(lang('plant_field_kpi') . lang('bf_form_label_required'), 'kpi', array('class' => 'control-label')); ?>
                <div class='controls'>
                    <input id='kpi' type='text' name='kpi' maxlength='5' value="<?php echo set_value('kpi', isset($plant->kpi) ? $plant->kpi : ''); ?>" />
                    <span class='help-inline'><?php echo form_error('kpi'); ?></span>
                </div>
            </div-->
        </fieldset>
        <fieldset class='form-actions'>
            <input type='submit' name='save' class='btn btn-primary' value="<?php echo lang('plant_action_edit'); ?>" />
            <?php echo lang('bf_or'); ?>
            <?php echo anchor(SITE_AREA . '/management/plant', lang('plant_cancel'), 'class="btn btn-warning"'); ?>
            
            <?php if ($this->auth->has_permission('Plant.Management.Delete')) : ?>
                <?php echo lang('bf_or'); ?>
                <button type='submit' name='delete' formnovalidate class='btn btn-danger' id='delete-me' onclick="return confirm('<?php e(js_escape(lang('plant_delete_confirm'))); ?>');">
                    <span class='icon-trash icon-white'></span>&nbsp;<?php echo lang('plant_delete_record'); ?>
                </button>
            <?php endif; ?>
        </fieldset>
    <?php echo form_close(); ?>
</div>