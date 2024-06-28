
<?php
    $settings = \App\Models\Utility::settings();
?>


<?php echo e(Form::open(array('url' => 'plan', 'enctype' => "multipart/form-data"))); ?>

<div class="row">
    <?php if(!empty($settings['chatgpt_key'])): ?>
    <div class="float-end">
            <a class="btn btn-primary btn-sm float-end ms-2" href="#" data-size="md" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['plan'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content with AI')); ?>"><i class="fas fa-robot"> <?php echo e(__('Generate with AI')); ?></i></a>
    </div>
    <?php endif; ?>
    <div class="col-6">
        <div class="form-group">
            <?php echo e(Form::label('name',__('Name'),['class'=>'form-label'])); ?>

            <?php echo e(Form::text('name',null,array('class'=>'form-control font-style','placeholder'=>__('Enter Plan Name'),'required'=>'required'))); ?>

        </div>
    </div>
    <div class="col-6">
        <div class="form-group ">
            <?php echo e(Form::label('price',__('Price'),['class'=>'form-label'])); ?>

            <?php echo e(Form::number('price',null,array('class'=>'form-control','placeholder'=>__('Enter Plan Price'),'step'=>'0.01'))); ?>

        </div>
    </div>
    <div class="col-6">
        <div class="form-group ">
            <?php echo e(Form::label('max_agent',__('Maximum Agent'),['class'=>'form-label'])); ?>

            <?php echo e(Form::number('max_agent',null,array('class'=>'form-control','required'=>'required'))); ?>

            <span class="small"><?php echo e(__('Note: "-1" for Unlimited')); ?></span>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <?php echo e(Form::label('duration', __('Duration'),['class'=>'form-label'])); ?>

            <?php echo Form::select('duration', $arrDuration, null,array('class' => 'form-control','required'=>'required')); ?>

        </div>
    </div>

    <div class="form-group col-md-6">
        <?php echo e(Form::label('storage_limit', __('Storage limit'), ['class' => 'form-label'])); ?>

        <div class="input-group">
            <?php echo e(Form::number('storage_limit', null, ['class' => 'form-control', 'placeholder' => __('Enter Storage Limit'),'required'=>'required'])); ?>

            <div class="input-group-append">
                <span class="input-group-text"
                    id="basic-addon2">MB</span>
            </div>
        </div>
        <span class="small"><?php echo e(__('Note: upload storage limit in MB')); ?></span>
    </div>

    <div class="col-6">
    <div class="form-group">
        <?php echo e(Form::label('description', __('Description'))); ?>

        <?php echo Form::textarea('description', null, ['class'=>'form-control','rows'=>'2']); ?>

    </div>
    </div>

    <div class="row">
            <div class="col-md-6 mt-3 plan_price_div">
                <label class="form-check-label" for="trial"></label>
                <div class="form-group">
                    <label for="trial" class="form-label"><?php echo e(__('Trial is enable(on/off)')); ?></label>
                    <div class="form-check form-switch custom-switch-v1 float-end">
                        <input type="checkbox" name="trial" class="form-check-input input-primary pointer" value="1" id="trial">
                        <label class="form-check-label" for="trial"></label>
                    </div>
                </div>
            </div>
            <div class="col-md-6 d-none plan_div plan_price_div">
                <div class="form-group">
                    <?php echo e(Form::label('trial_days', __('Trial Days'), ['class' => 'form-label'])); ?>

                    <?php echo e(Form::number('trial_days',null, ['class' => 'form-control','placeholder' => __('Enter Trial days'),'step' => '1','min'=>'1'])); ?>

                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-4">
            <div class="custom-control form-switch pt-2">
                <input type="checkbox" class="form-check-input" name="enable_custdomain" id="enable_custdomain">
                <label class="custom-control-label form-check-label"
                    for="enable_custdomain"><?php echo e(__('Enable Domain')); ?></label>
            </div>
        </div>
        <div class="col-4">
            <div class="custom-control form-switch pt-2">
                <input type="checkbox" class="form-check-input" name="enable_custsubdomain" id="enable_custsubdomain">
                <label class="custom-control-label form-check-label"
                    for="enable_custsubdomain"><?php echo e(__('Enable Sub Domain')); ?></label>
            </div>
        </div>
        <div class="col-4">
            <div class="custom-control form-switch pt-2">
                <input type="checkbox" class="form-check-input" name="enable_chatgpt" id="enable_chatgpt">
            <label class="custom-control-label form-check-label"
                for="enable_chatgpt"><?php echo e(__('Enable Chatgpt')); ?></label>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light"
            data-bs-dismiss="modal">Close</button>
            <?php echo e(Form::submit(__('Create'),array('class'=>'btn btn-primary '))); ?>

    </div>
</div>
<?php echo e(Form::close()); ?>


<script>
    $(document).on('change', '#is_free_plan', function() {
        var value =  $(this).val();
        PlanLable(value);
    });
    $(document).on('change', '#trial', function() {
        if ($(this).is(':checked')) {
            $('.plan_div').removeClass('d-none');
            $('#trial').attr("required", true);

        } else {
            $('.plan_div').addClass('d-none');
            $('#trial').removeAttr("required");
        }
    });

    $(document).on('keyup mouseup', '#number_of_user', function() {
        var user_counter = parseInt($(this).val());
        if (user_counter == 0  || user_counter < -1)
        {
            $(this).val(1)
        }

    });

    function PlanLable(value){
        if(value == 1){
            $('.plan_price_div').addClass('d-none');
        }
        if(value == 0){
            $('.plan_price_div').removeClass('d-none');
            if ($(".add_lable").find(".text-danger").length === 0) {
                $(".add_lable").append(`<span class="text-danger"> <sup>Paid</sup></span>`);
            }
        }
    }
</script>
<?php /**PATH /home/splibrjd/public_html/resources/views/plan/create.blade.php ENDPATH**/ ?>