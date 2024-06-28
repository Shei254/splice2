<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Referral Program')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('dashboard')); ?>"><?php echo e(__('Dashboard')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Referral Program')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/summernote/summernote-bs4.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('css/summernote/summernote-bs4.js')); ?>"></script>
    <script>
        $('.tab-link').on('click', function() {
            var tabId = $(this).data('tab');
            $('.tab-content').addClass('d-none');
            $('#' + tabId).removeClass('d-none');

            $('.tab-link').removeClass('active');
            $(this).addClass('active');
        });
    </script>
       <script>
        $('.cp_link').on('click', function () {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
        });
    </script>
<?php $__env->stopPush(); ?>

<?php
    $settings = Utility::payment_settings();
    $currency = isset($settings['currency_symbol']) ? $settings['currency_symbol'] : '$';
?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <a href="#" class="list-group-item list-group-item-action border-0 tab-link active"
                                data-tab="guideline"><?php echo e(__('GuideLine')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 tab-link"
                                data-tab="referral-transaction"><?php echo e(__('Referral Transaction')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                            <a href="#" class="list-group-item list-group-item-action border-0 tab-link"
                                data-tab="payout"><?php echo e(__('Payout')); ?>

                                <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9">

                    <!--Site Settings-->
                    <div id="guideline" class="card tab-content">
                        <div class="card-header">
                            <h5><?php echo e(__('GuideLine')); ?></h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6 col-sm-6 col-md-6 ">
                                    <div class = "border border-2 p-3">
                                        <h4><?php echo e(__('Refer '  .  \Auth::user()->name . ' and earn ') . $currency . (isset($setting) ? $setting->minimum_threshold_amount : '') . __(' per paid signup!')); ?></h4>

                                        <?php echo isset($setting) ? $setting->guideline : ''; ?>

                                    </div>
                                </div>
                                <div class="col-lg-6 col-sm-6 col-md-6 mt-5">
                                    <h4 class="text-center"><?php echo e(__('Share Your Link')); ?></h4>
                                    <div class="d-flex justify-content-between">


                                        <a href="#" class="btn btn-sm btn-light-primary w-100 cp_link" data-link="<?php echo e(route('register', ['ref_id' => \Auth::user()->referral_code])); ?>" data-toggle="tooltip" data-original-title="<?php echo e(__('Click to copy invoice link')); ?>" title="" data-bs-toggle="tooltip" data-bs-placement="top">
                                            <?php echo e(route('register', ['ref' => \Auth::user()->referral_code])); ?>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-copy ms-1">
                                            <rect x="9" y="9" width="13" height="13" rx="2"
                                                ry="2"></rect>
                                            <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
                                        </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="referral-transaction" class="card tab-content d-none">
                        <div class="card-header">
                            <h5><?php echo e(__('Referral Transaction')); ?></h5>
                        </div>
                        <div class="card-body table-border-style">
                            <div class="table-responsive">
                                <table class="table datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('Admin Name')); ?></th>
                                            <th><?php echo e(__('Plan Name')); ?></th>
                                            <th><?php echo e(__('Plan Price')); ?></th>
                                            <th><?php echo e(__('Commission (%)')); ?></th>
                                            <th><?php echo e(__('Commission Amount')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($setting)): ?>
                                        <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td> <?php echo e(++$key); ?> </td>
                                                <td><?php echo e(!empty($transaction->getUser) ? $transaction->getUser->name : '-'); ?>

                                                </td>
                                                <td><?php echo e(!empty($transaction->getPlan) ? $transaction->getPlan->name : '-'); ?>

                                                </td>
                                                <td><?php echo e($currency . $transaction->plan_price); ?></td>
                                                <td><?php echo e($transaction->commission); ?></td>
                                                <td><?php echo e($currency . ($transaction->plan_price * $transaction->commission) / 100); ?>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div id="payout" class="tab-content d-none">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class=""><?php echo e(__('PayOut')); ?></h5>
                                    </div>
                                    <div class="col-6 text-end">
                                        <?php if(\Auth::user()->commission_amount > $paidAmount): ?>
                                            <?php if($paymentRequest == null): ?>
                                                <a href="#"
                                                    data-url = "<?php echo e(route('request.amount.sent', [$paidAmount])); ?>"
                                                    data-ajax-popup="true" class="btn btn-primary btn-sm"
                                                    data-title="<?php echo e(__('Send Request')); ?>" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Send Request')); ?>">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-corner-up-right"></i></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('request.amount.cancel', \Auth::user()->id)); ?>"
                                                    class="btn btn-danger btn-sm" data-title="<?php echo e(__('Cancle Request')); ?>"
                                                    data-bs-toggle="tooltip" title="<?php echo e(__('Cancle Request')); ?>">
                                                    <span class="btn-inner--icon"><i class="ti ti-x"></i></span>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center justify-content-between">
                                    

                                    <div class="col-lg-6 col-md-12 dashboard-card">
                                        <div class="border border-2 p-3">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="theme-avtar bg-primary">
                                                            <i class="ti ti-report-money"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <small class="text-muted"><?php echo e(__('Total')); ?></small>
                                                            <h6 class="m-0"><?php echo e(__('Commission Amount')); ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto text-end">
                                                    <h4 class="m-0"><?php echo e($currency . \Auth::user()->commission_amount); ?>

                                                    </h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    

                                    <div class="col-lg-6 col-md-12 dashboard-card">
                                        <div class="border border-2 p-3">
                                            <div class="row align-items-center justify-content-between">
                                                <div class="col-auto mb-3 mb-sm-0">
                                                    <div class="d-flex align-items-center">
                                                        <div class="theme-avtar bg-primary">
                                                            <i class="ti ti-report-money"></i>
                                                        </div>
                                                        <div class="ms-3">
                                                            <small class="text-muted"><?php echo e(__('Paid')); ?></small>
                                                            <h6 class="m-0"><?php echo e(__('Commission Amount')); ?></h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto text-end">
                                                    <h4 class="m-0"><?php echo e($currency . $paidAmount); ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class=""><?php echo e(__('Payout History')); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-border-style">
                                <div class="table-responsive">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo e(__('Admin Name')); ?></th>
                                                <th><?php echo e(__('Requested Date')); ?></th>
                                                <th><?php echo e(__('Status')); ?></th>
                                                <th><?php echo e(__('Requested Amount')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $transactionsOrder; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e(++$key); ?></td>
                                                    <td><?php echo e(\Auth::user()->name); ?></td>
                                                    <td><?php echo e($transaction->date); ?></td>
                                                    <td>
                                                        <?php if($transaction->status == 0): ?>
                                                            <span
                                                                class="status_badge badge bg-danger p-2 px-3 rounded"><?php echo e(__(\App\Models\ReferralTransactionOrder::$status[$transaction->status])); ?></span>
                                                        <?php elseif($transaction->status == 1): ?>
                                                            <span
                                                                class="status_badge badge bg-warning p-2 px-3 rounded"><?php echo e(__(\App\Models\ReferralTransactionOrder::$status[$transaction->status])); ?></span>
                                                        <?php elseif($transaction->status == 2): ?>
                                                            <span
                                                                class="status_badge badge bg-primary p-2 px-3 rounded"><?php echo e(__(\App\Models\ReferralTransactionOrder::$status[$transaction->status])); ?></span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo e($currency . $transaction->req_amount); ?></td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script>
    var scrollSpy = new bootstrap.ScrollSpy(document.body, {
        target: '#useradd-sidenav',
        offset: 200,
    })
    $('.tab-link').on('click', function () {
    var tabId = $(this).data('tab');
    $('.tab-content').addClass('d-none');
    $('#' + tabId).removeClass('d-none');

    $('.tab-link').removeClass('active');
    $(this).addClass('active');
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/referral-program/company.blade.php ENDPATH**/ ?>