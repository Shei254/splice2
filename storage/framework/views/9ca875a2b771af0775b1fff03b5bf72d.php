<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Groups')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Groups')); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $logos = \App\Models\Utility::get_file('public/');
?>
<?php $__env->startSection('action-button'); ?>

        <div class="float-end">
            <div class="col-auto=">
                <a href="#"  class="btn btn-sm btn-primary btn-icon" title="<?php echo e(__('Create')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-ajax-popup="true" data-title="<?php echo e(__('Create Group')); ?>"
                data-url="<?php echo e(route('groups.create')); ?>" data-size="lg"><i class="ti ti-plus"></i></a>
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
                                    <th scope="col">#</th>
                                    <th scope="col"><?php echo e(__('Name')); ?></th>
                                    <th scope="col"><?php echo e(__('Email')); ?></th>
                                    <th scope="col"><?php echo e(__('Operating Hours')); ?></th>
                                    <th scope="col"><?php echo e(__('Agents')); ?></th>
                                    <th scope="col" class="text-end me-3"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $groups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <tr>
                                        <th scope="row"><?php echo e(++$index); ?></th>
                                        <td><?php echo e($group->name); ?></td>
                                        <td><?php echo e($group->email); ?></td>

                                        <td><?php echo e(isset($group->operating->name) ? $group->operating->name : ''); ?></td>
                                        <td>
                                         <?php
                                         $users = $group->getUser($group->users);
                                         ?>
                                             <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                             <a href="<?php echo e(!empty($user->avatar) ? $logos . $user->avatar : $logos . 'avatar.png'); ?>"
                                                  target="_blank">
                                                  <img src="<?php echo e(!empty($user->avatar) ? $logos . $user->avatar : $logos . 'avatar.png'); ?>"
                                                  data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e($user->name); ?>"  class="img-fluid rounded-circle card-avatar" width="30"
                                                      id="blah3">
                                            </a>
                                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                         </td>
                                         <td class="text-end">

                                                <div class="action-btn bg-info ms-2">
                                                    <a href="#" class="mx-3 btn btn-sm d-inline-flex align-items-center" title="<?php echo e(__('Edit')); ?>" data-bs-toggle="tooltip" data-bs-placement="top" data-url="<?php echo e(route('groups.edit', $group->id)); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Group')); ?>" data-size="lg"><span class="text-white"><i class="ti ti-edit"></i></span></a>
                                                </div>





                                                <div class="action-btn bg-danger ms-2">
                                                    <form method="POST" action="<?php echo e(route('groups.destroy',$group->id)); ?>" id="user-form-<?php echo e($group->id); ?>">
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/groups/index.blade.php ENDPATH**/ ?>