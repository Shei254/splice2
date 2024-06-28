<?php
$settings = \App\Models\Utility::settings();
?>


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage SLA Policiy')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('SLA Policiy')); ?></li>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('action-button'); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="row">
    <div class="col-3">
        <?php echo $__env->make('layouts.setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-9">
        <div class="card">
            <div class="card-body table-border-style">
                <div class="well_white">
                    <div class="bold"><b>Targets</b></div>
                    <div class="hint">Set a time target for each priority.</div>
                    <hr style="margin:10px 0">
                    <div class="table-responsive m-0 custom-field-table">
                        <table class="table dataTable-table" id="pc-dt-simple" data-repeater-list="fields">
                             <thead class="thead-light">
                                <tr>
                                    <th scope="col" ><?php echo e(__('Priority')); ?></th>
                                    <th scope="col"><?php echo e(__('Response within')); ?></th>
                                    <th scope="col">
                                        <div class="form-check form-switch custom-control-inline">
                                             <?php echo e(Form::open(['route' => 'policiy.store', 'method' => 'post'])); ?>

                                            
                                            <input type="checkbox" class="form-check-input" role="switch" id="resolve"  name="resolve_status" <?php echo e($settings['resolve_status'] == 1 ? 'checked' : ""); ?>>
                                            <label for="resolve_status_cbox"><?php echo e(__('Resolve within')); ?></label>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $priority; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>  $priorities): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>

                                            <input type="text" class="form-control" id="priority_id" name="<?php echo e("priority[$priorities->name][priority]"); ?>" required=""  maxlength="255" value="<?php echo e($priorities->name); ?>" readonly>

                                            <input type="hidden" name="<?php echo e("priority[$priorities->name][priority_id]"); ?>" value="<?php echo e($priorities->id); ?>">

                                    </td>
                                    
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control  ng-not-empty ng-valid-pattern" id="response_within" name="<?php echo e("priority[$priorities->name][response_within]"); ?>" value="<?php echo e($priorities->policies->response_within ?? 0); ?>" >
                                            </div>
                                            <div class="col-sm-7" style="
                                            padding: 0px; width: 173px;">
                                                <select class="form-select" name="<?php echo e("priority[$priorities->name][response_time]"); ?>" required=""  >
                                                    <option value="Hour" <?php if($priorities->policies->response_time == "Hour"): ?> selected <?php endif; ?>
                                                    ><?php echo e(__('Hour')); ?></option>
                                                    <option value="Minute" <?php if($priorities->policies->response_time == "Minute"): ?> selected <?php endif; ?>><?php echo e(__('Minute')); ?></option>
                                                    <option value = "Day"  <?php if($priorities->policies->response_time == "Day"): ?> selected <?php endif; ?>
                                                    ><?php echo e(__('Day')); ?></option>
                                                    <option value = "Month"  <?php if($priorities->policies->response_time == "Month"): ?> selected <?php endif; ?>
                                                    ><?php echo e(__('Month')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="row resolve">
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control resolve_time" id="resolve_within" name="<?php echo e("priority[$priorities->name][resolve_within]"); ?>"  value="<?php echo e($priorities->policies->resolve_within ?? 0); ?>">
                                            </div>
                                            <div class="col-sm-7" style="
                                            padding: 0px;     width: 173px;">
                                                <select class="form-select resolve_duration <?php echo e(!empty($errors->first('resolve_time')) ? 'is-invalid' : ''); ?>" id="resolve_duration" name="<?php echo e("priority[$priorities->name][resolve_time]"); ?>" required="" >
                                                    <option value="Hour" <?php if($priorities->policies->resolve_time == "Hour"): ?> selected <?php endif; ?>><?php echo e(__('Hour')); ?></option>
                                                    <option value="Minute" <?php if($priorities->policies->resolve_time == "Minute"): ?> selected <?php endif; ?>><?php echo e(__('Minute')); ?></option>
                                                    <option value="Day" <?php if($priorities->policies->resolve_time == "Day"): ?> selected <?php endif; ?>><?php echo e(__('Day')); ?></option>
                                                    <option value="Month" <?php if($priorities->policies->resolve_time == "Month"): ?> selected <?php endif; ?>> <?php echo e(__('Month')); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                    </td>






                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <div class="text-end">
                            <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary'])); ?>

                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>



$( document ).ready(function() {
   if ($('#resolve').is(":checked")) {
            //enabled
            $('.resolve_time').attr('disabled',false);
            $('.resolve_duration').attr('disabled',false);
            preview();
        } else {
            // disabled
            $('.resolve_time').attr('disabled',true);
            $('.resolve_duration').attr('disabled',true);

        }
});


$(document).on('click', '#resolve_status', function () {
        if ($('#resolve').is(":checked")) {
            //enabled
            $('.resolve_time').attr('disabled',false);
            $('.resolve_duration').attr('disabled',false);
            preview();
        } else {
            // disabled
            $('.resolve_time').attr('disabled',true);
            $('.resolve_duration').attr('disabled',true);

        }
    });
</script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/policiy/index.blade.php ENDPATH**/ ?>