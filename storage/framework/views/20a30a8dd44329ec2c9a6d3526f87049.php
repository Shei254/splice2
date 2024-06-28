    <?php $__env->startSection('page-title'); ?>
        <?php echo e(__('Manage Coupons')); ?>

    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>    
        <li class="breadcrumb-item active" aria-current="page"><?php echo e(__('Coupons')); ?></li>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('action-button'); ?>
        <div>
            <div class="row">
                    <div class="col-auto=">
                        <a href="#"  class="btn btn-sm btn-primary btn-icon" title="<?php echo e(__('Create')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-ajax-popup="true" data-title="<?php echo e(__('Create New Coupon')); ?>" data-url="<?php echo e(route('coupon.create')); ?>"><i class="ti ti-plus"></i></a>
                    </div>   
            </div>
        </div>
    <?php $__env->stopSection(); ?>

    <?php $__env->startSection('content'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table id="pc-dt-simple" class="table dataTable">
                                <thead>
                                <tr>
                                    <th> <?php echo e(__('Name')); ?></th>
                                    <th> <?php echo e(__('Code')); ?></th>
                                    <th> <?php echo e(__('Discount (%)')); ?></th>
                                    <th> <?php echo e(__('Limit')); ?></th>
                                    <th> <?php echo e(__('Used')); ?></th>
                                    <th> <?php echo e(__('Action')); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $coupons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coupon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="">
                                        <td><?php echo e($coupon->name); ?></td>
                                        <td><?php echo e($coupon->code); ?></td>
                                        <td><?php echo e($coupon->discount); ?></td>
                                        <td><?php echo e($coupon->limit); ?></td>
                                        <td><?php echo e($coupon->used_coupon()); ?></td>
                                        <td>
                                            <div class="action-btn bg-warning ms-2">
                                                <a href="<?php echo e(route('coupon.show',$coupon->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center" title="<?php echo e(__('Detail')); ?>" data-bs-toggle="tooltip" data-bs-placement="top"><span class="text-white"><i class="ti ti-eye"></i></span></a>
                                            </div>
                                            
                                                
                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" title="<?php echo e(__('Edit')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-url="<?php echo e(route('coupon.edit',$coupon->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Coupon')); ?>" data-size="md"><span class="text-white"><i class="ti ti-edit"></i></span></a>
                                                </div>
                                                <div class="action-btn bg-danger ms-2">
                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['coupon.destroy', $coupon->id]]); ?>

                                                        <a href="#!" class="mx-3 btn btn-sm  align-items-center text-white show_confirm" data-bs-toggle="tooltip" title='Delete'>
                                                            <i class="ti ti-trash"></i>
                                                        </a>
                                                    <?php echo Form::close(); ?>

                                                </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/coupon/index.blade.php ENDPATH**/ ?>