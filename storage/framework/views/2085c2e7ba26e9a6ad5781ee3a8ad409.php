<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Custom Domain Request')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
    <?php echo e(__('Custom Domain Request')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Custom Domain Request')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive overflow_hidden">
                            <table id="pc-dt-simple" class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th> <?php echo e(__('Company Name')); ?></th>
                                        <th> <?php echo e(__('Custom Domain')); ?></th>
                                        <th> <?php echo e(__('Status')); ?></th>
                                        <th> <?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $__currentLoopData = $custom_domain_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $custom_domain_request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <div class="font-style font-weight-bold">
                                                    <?php echo e($custom_domain_request->user->name); ?></div>
                                            </td>
                                            <td>
                                                <div class="font-style font-weight-bold">
                                                    <?php echo e($custom_domain_request->custom_domain); ?></div>
                                            </td>
                                            <td>
                                                <?php if($custom_domain_request->status == 0): ?>
                                                    <span
                                                        class="badge fix_badges bg-danger p-2 px-3 rounded"><?php echo e(__(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status])); ?></span>
                                                <?php elseif($custom_domain_request->status == 1): ?>
                                                    <span
                                                        class="badge fix_badges bg-primary p-2 px-3 rounded"><?php echo e(__(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status])); ?></span>
                                                <?php elseif($custom_domain_request->status == 2): ?>
                                                    <span
                                                        class="badge fix_badges bg-warning p-2 px-3 rounded"><?php echo e(__(App\Models\CustomDomainRequest::$statues[$custom_domain_request->status])); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="Action">
                                                <?php if($custom_domain_request->status == 0): ?>
                                                <div class="action-btn bg-primary ms-2">
                                                    <a href="<?php echo e(route('custom_domain_request.request',[$custom_domain_request->id,1])); ?>"
                                                        title="<?php echo e(__('Accept')); ?>" data-bs-toggle="tooltip">
                                                       <span> <i class="ti ti-check btn btn-sm text-white"></i></span>
                                                    </a>
                                                </div>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="<?php echo e(route('custom_domain_request.request',[$custom_domain_request->id,0])); ?>"
                                                        title="<?php echo e(__('Reject')); ?>" data-bs-toggle="tooltip">
                                                       <span> <i class="ti ti-x btn btn-sm text-white"></i></span>
                                                    </a>
                                                </div>
                                                <?php endif; ?>
                                                <div class="action-btn bg-danger ms-2">
                                                    <form method="POST" action="<?php echo e(route('custom_domain_request.destroy',$custom_domain_request->id)); ?>" id="user-form-<?php echo e($custom_domain_request->id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <input name="_method" type="hidden" value="DELETE">
                                                        <button type="submit" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-toggle="tooltip"
                                                        title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip">
                                                            <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/custom_domain_request/index.blade.php ENDPATH**/ ?>