<?php
    $dir = asset(Storage::url('uploads/plan'));
    $admin_payment_setting = Utility::payment_settings();
?>


<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plan')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('title'); ?>
    <?php echo e(__('Plan')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Plan')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if(\Auth::user()->type == 'Super Admin'): ?>
        <?php if(count($payment_setting) > 0): ?>
            <div class="action-btn ms-2">
                <a href="#" data-url="<?php echo e(route('plan.create')); ?>" data-size="lg" data-ajax-popup="true"
                    data-bs-toggle="tooltip" data-title="<?php echo e(__('Create New Plan')); ?>" title="<?php echo e(__('Create')); ?>"
                    class="btn btn-sm btn-primary btn-icon m-1">
                    <i class="ti ti-plus"></i>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(\Auth::user()->type == 'Super Admin'): ?>
        <div class="row">
            <div class="col-12">
                <?php if(count($payment_setting) == 0): ?>
                    <div class="alert alert-warning"><i class="fe fe-info"></i>
                        <?php echo e(__('Please set payment api key & secret key for add new plan')); ?></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-xl-3 col-md-6 col-sm-6 mt-3">
                <div class="card price-card price-1 wow animate__fadeInUp" data-wow-delay="0.2s"
                    style="
                min-height: 265px;
               visibility: visible;
               animation-delay: 0.2s;
               animation-name: fadeInUp;
               ">

                    <div class="card-body <?php echo e(!empty(\Auth::user()->type != 'Super Admin') ? 'plan-box' : ''); ?>">
                        <span class="price-badge bg-primary"><?php echo e($plan->name); ?></span>
                        <?php if(\Auth::user()->type == 'Super Admin' && $plan->price > 0): ?>
                            <div class="d-flex flex-row-reverse m-0 p-0 ">
                                <div class="form-check form-switch custom-switch-v1 mb-2">
                                    <input type="checkbox" name="plan_disable"
                                        class="form-check-input input-primary plan_disable" value="1"
                                        data-id='<?php echo e($plan->id); ?>' data-company="<?php echo e($plan->id); ?>"
                                        data-name="<?php echo e(__('user')); ?>" <?php echo e($plan->plan_disable == 1 ? 'checked' : ''); ?>>
                                    <label class="form-check-label" for="plan_disable"></label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if(\Auth::user()->type == 'Admin' && \Auth::user()->plan == $plan->id): ?>
                            <div class="d-flex flex-row-reverse m-0 p-0 ">
                                <span class="d-flex align-items-center ">
                                    <i class="f-10 lh-1 fas fa-circle text-success"></i>
                                    <span class="ms-2"><?php echo e(__('Active')); ?></span>
                                </span>
                            </div>
                        <?php endif; ?>

                        <h1 class="mb-4 f-w-600 ">
                            <?php echo e(isset($admin_payment_setting['currency_symbol']) ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e(number_format($plan->price)); ?><small
                                class="text-sm"><?php echo e(\App\Models\Plan::$arrDuration[$plan->duration]); ?></small></h1>
                        <p class="mb-0 text-center">
                            <?php echo e(__('Free Trial Days : ') . __($plan->trial_days ? $plan->trial_days : 0)); ?><br />
                        </p>
                        <p class="my-4 text-center"><?php echo e($plan->description); ?></p>

                        <ul class="list-unstyled">
                            <li> <span class="theme-avtar"><i
                                        class="text-primary ti ti-circle-plus"></i></span><?php echo e($plan->max_agent < 0 ? __('Unlimited') : $plan->max_agent); ?>

                                <?php echo e(__('Agent')); ?></li>

                            <li> <span class="theme-avtar"><i
                                        class="text-primary ti ti-circle-plus"></i></span><?php echo e($plan->storage_limit); ?>

                                <?php echo e(__(' MB Storage')); ?></li>
                            <?php if($plan->enable_custdomain == 'on'): ?>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span><?php echo e(__('Custom Domain')); ?>

                                </li>
                            <?php else: ?>
                                <li class="text-danger">
                                    <span class="theme-avtar">
                                        <i class="text-danger ti ti-circle-plus"></i></span><?php echo e(__('Custom Domain')); ?>

                                </li>
                            <?php endif; ?>
                            <?php if($plan->enable_custsubdomain == 'on'): ?>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span><?php echo e(__('Sub Domain')); ?>

                                </li>
                            <?php else: ?>
                                <li class="text-danger">
                                    <span class="theme-avtar">
                                        <i class="text-danger ti ti-circle-plus"></i></span><?php echo e(__('Sub Domain')); ?>

                                </li>
                            <?php endif; ?>
                            <?php if($plan->enable_chatgpt == 'on'): ?>
                                <li>
                                    <span class="theme-avtar">
                                        <i class="text-primary ti ti-circle-plus"></i></span><?php echo e(__('Chatgpt')); ?>

                                </li>
                            <?php else: ?>
                                <li class="text-danger">
                                    <span class="theme-avtar">
                                        <i class="text-danger ti ti-circle-plus"></i></span><?php echo e(__('Chatgpt')); ?>

                                </li>
                            <?php endif; ?>
                        </ul>
                        <br>


                        <?php if($plan->id != \Auth::user()->plan && \Auth::user()->type != 'Super Admin'): ?>
                            aws Customer <?php echo e(\Auth::user()->awsCustomer); ?>

                            <?php if(\Auth::user()->awsCustomer): ?>
                                <a href="#"
                                   class="btn btn-lg btn-primary btn-icon m-1"><?php echo e(__('Billing Handled By Aws')); ?></a>
                            <?php else: ?>
                                <?php if($plan->price > 0 && \Auth::user()->trial_plan == 0 && \Auth::user()->plan != $plan->id && $plan->trial == 1): ?>
                                    <a href="<?php echo e(route('plan.trial', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                       class="btn btn-lg btn-primary btn-icon m-1"><?php echo e(__('Start Free Trial')); ?></a>
                                <?php endif; ?>
                                <?php if($plan->price > 0): ?>
                                    <a href="<?php echo e(route('plan.payment', \Illuminate\Support\Facades\Crypt::encrypt($plan->id))); ?>"
                                       id="interested_plan_2" data-bs-toggle="tooltip" data-bs-placement="top"
                                       title="<?php echo e(__('Subscribe')); ?>" class="btn btn-lg btn-primary btn-icon m-12">
                                        <i class="ti ti-shopping-cart m-1 text-white"></i><?php echo e(__('Subscribe')); ?>

                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(\Auth::user()->type != 'Super Admin' && \Auth::user()->plan != $plan->id): ?>
                            <?php if($plan->id != 1): ?>
                                <?php if(\Auth::user()->requested_plan != $plan->id): ?>
                                    <a href="<?php echo e(route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])); ?>"
                                        class="btn btn-lg btn-primary btn-icon m-1" data-title="<?php echo e(__('Send Request')); ?>"
                                        title="<?php echo e(__('Send Request')); ?>" data-bs-toggle="tooltip">
                                        <span class="btn-inner--icon"><i class="ti ti-corner-up-right"></i></span>
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('request.cancel', \Auth::user()->id)); ?>"
                                        class="btn btn-lg btn-primary btn-icon m-1" data-title="<?php echo e(__('Cancle Request')); ?>"
                                        title="<?php echo e(__('Cancle Request')); ?>" data-bs-toggle="tooltip">
                                        <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if(\Auth::user()->type == 'Super Admin'): ?>
                            <div class="row align-items-center">
                                <div class="col-3"></div>
                                <div class="col-2 me-3 mt-1">
                                    <a title="Edit Plan" href="#" class="btn btn-primary btn-icon m-1"
                                        data-url="<?php echo e(route('plan.edit', $plan->id)); ?>" data-ajax-popup="true"
                                        data-title="<?php echo e(__('Edit Plan')); ?>" data-size="lg" data-bs-toggle="tooltip"
                                        data-bs-original-title="<?php echo e(__('Edit')); ?>">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                </div>
                                <?php if($plan->price > 0): ?>
                                    <div class="col-3">
                                        <form method="POST" action="<?php echo e(route('plan.destroy', $plan->id)); ?>"
                                            id="delete-form-<?php echo e($plan->id); ?>">
                                            <?php echo csrf_field(); ?>
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-icon m-1 show_confirm"
                                                data-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if(\Auth::user()->type == 'Admin' && \Auth::user()->trial_expire_date): ?>
                            <?php if(\Auth::user()->type == 'Admin' && \Auth::user()->trial_plan == $plan->id): ?>
                                <p class="display-total-time mb-0">
                                    <?php echo e(__('Plan Trial Expired : ')); ?>

                                    <?php echo e(!empty(\Auth::user()->trial_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->trial_expire_date) : 'lifetime'); ?>

                                </p>
                            <?php endif; ?>
                        <?php else: ?>
                            <?php if(\Auth::user()->type == 'Admin' && \Auth::user()->plan == $plan->id): ?>
                                <p class="display-total-time mb-0">
                                    <?php echo e(__('Plan Expired : ')); ?>

                                    <?php echo e(!empty(\Auth::user()->plan_expire_date) ? \Auth::user()->dateFormat(\Auth::user()->plan_expire_date) : 'lifetime'); ?>

                                </p>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>

    <script>
        $(document).on("click", ".plan_disable", function() {
            var id = $(this).attr('data-id');
            var plan_disable = ($(this).is(':checked')) ? $(this).val() : 0;


            $.ajax({
                url: '<?php echo e(route('plan.unable')); ?>',
                type: 'POST',
                data: {
                    "plan_disable": plan_disable,
                    "id": id,
                    "_token": "<?php echo e(csrf_token()); ?>",
                },
                success: function(data) {
                    if (data.success) {
                        show_toastr('success', data.success);
                    } else {
                        show_toastr('error', data.error);

                    }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/shei/Desktop/splice/resources/views/plan/index.blade.php ENDPATH**/ ?>