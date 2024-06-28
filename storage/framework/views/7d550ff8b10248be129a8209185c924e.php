<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Plan Request')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('title'); ?>
       <?php echo e(__('Plan Request')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Plan Request')); ?></li>
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
                                        <th> <?php echo e(__('User Name')); ?></th>
                                        <th> <?php echo e(__('Plan Name')); ?></th>
                                        <th> <?php echo e(__('Max Agent')); ?></th>
                                        <th> <?php echo e(__('Duration')); ?></th>
                                        <th> <?php echo e(__('Date')); ?></th>
                                        <th> <?php echo e(__('Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($plan_requests->count() > 0): ?>
                                        <?php $__currentLoopData = $plan_requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prequest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <tr>
                                                <td>
                                                    <div class="font-style font-weight-bold"><?php echo e($prequest->user->name); ?></div>
                                                </td>
                                                <td>
                                                    <div class="font-style font-weight-bold"><?php echo e($prequest->plan->name); ?></div>
                                                </td>
                                                <td>
                                                    <div class="font-weight-bold"><?php echo e($prequest->plan->max_agent < 0 ? __('Unlimited') : $prequest->plan->max_agent); ?></div>


                                                </td>
                                                <td>
                                                    <div class="font-style font-weight-bold"><?php echo e($prequest->plan->duration); ?></div>

                                                    
                                                </td>

                                                <td><?php echo e(\App\Models\Utility::getDateFormated($prequest->created_at,true)); ?></td>
                                                <td>
                                                    <div>
                                                        <a href="<?php echo e(route('response.request',[$prequest->id,1])); ?>" title="<?php echo e(__('Accept')); ?>" data-bs-toggle="tooltip" class="action-btn bg-success">
                                                            <i class="ti ti-check"></i>
                                                        </a>
                                                        <a href="<?php echo e(route('response.request',[$prequest->id,0])); ?>" title="<?php echo e(__('Delete')); ?>" data-bs-toggle="tooltip" class="action-btn bg-danger">
                                                            <i class="ti ti-x"></i>
                                                        </a>
                                                    </div>

                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <th scope="col" colspan="7"><h6 class="text-center"><?php echo e(__('No Manually Plan Request Found.')); ?></h6></th>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/plan_request/index.blade.php ENDPATH**/ ?>