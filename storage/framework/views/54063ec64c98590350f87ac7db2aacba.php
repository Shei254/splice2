<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Opearating Hours')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Opearating Hours')); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $logos = \App\Models\Utility::get_file('public/');
?>
<?php $__env->startSection('action-button'); ?>
        <div class="float-end">
            <div class="col-auto=">
                <a href="#"  class="btn btn-sm btn-primary btn-icon" title="<?php echo e(__('Create')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-ajax-popup="true" data-title="<?php echo e(__('Create Operating Hour')); ?>"
                data-url="<?php echo e(route('operating_hours.create')); ?>" data-size="xl"><i class="ti ti-plus"></i></a>
            </div>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-3">
        <?php echo $__env->make('layouts.setup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
    <div class="col-9">
       <div class="card">
           <div class="card-body table-border-style">
                <div class="table-responsive">
                         <table id="pc-dt-simple" class="table">
                            <thead class="thead-light">
                                <tr>
                                      <th>#</th>
                                      <th scope="col"><?php echo e(__('Name')); ?></th>

                                    <th scope="col" class="text-end me-3"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $opeatings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $opeating): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                 <tr>
                                        <th scope="row"><?php echo e(++$index); ?></th>
                                        <td><?php echo e($opeating->name); ?></td>
                                        <td class="text-end">

                                            <div class="action-btn bg-warning ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" title="<?php echo e(__('View')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-url="<?php echo e(route('operating_hours.show',$opeating->id)); ?>" data-ajax-popup="true" data-title="<?php echo e($opeating-> name); ?>" data-size="md"><span class="text-white"><i class="ti ti-eye"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-info ms-2">
                                                <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" title="<?php echo e(__('Edit')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-url="<?php echo e(route('operating_hours.edit',$opeating->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Operating Hour')); ?>" data-size="xl"><span class="text-white"><i class="ti ti-edit"></i></span></a>
                                            </div>

                                            <div class="action-btn bg-danger ms-2">
                                                <form method="POST" action="<?php echo e(route('operating_hours.destroy',$opeating->id)); ?>" id="">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm" data-bs-toggle="tooltip"
                                                    title="<?php echo e(__('Delete')); ?>">
                                                        <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                    </button>
                                                </form>
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


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/operating_hours/index.blade.php ENDPATH**/ ?>