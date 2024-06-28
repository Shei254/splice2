<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Users')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Users')); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $logos = \App\Models\Utility::get_file('public/');
?>
<?php $__env->startSection('action-button'); ?>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-users')): ?>
        <a href="<?php echo e(route('users.create')); ?>" class="">
            <div class="btn btn-sm btn-primary btn-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                title="<?php echo e(__('Create User')); ?>">
                <i class="ti ti-plus text-white"></i>
            </div>
        </a>
    <?php endif; ?>
    <?php if(\Auth::user()->type == 'Admin'): ?>
        <a href="<?php echo e(route('userlog')); ?>" class="btn btn-sm btn-primary btn-icon" title="<?php echo e(__('User Login History')); ?>"
            data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="ti ti-user-check"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table id="pc-dt-simple" class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col"><?php echo e(__('Picture')); ?></th>
                                    <th scope="col"><?php echo e(__('Name')); ?></th>
                                    <th scope="col"><?php echo e(__('Email')); ?></th>
                                    <?php if(\Auth::user()->type == 'Admin'): ?>
                                        <th scope="col"><?php echo e(__('Category')); ?></th>
                                    <?php endif; ?>
                                    <th scope="col"><?php echo e(__('Role')); ?></th>
                                    <th scope="col" class="text-end me-3"><?php echo e(__('Action')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th scope="row"><?php echo e(++$index); ?></th>
                                        <td>
                                            <a href="<?php echo e(!empty($user->avatar) ? $logos . $user->avatar : $logos . 'avatar.png'); ?>"
                                                target="_blank">
                                                <img src="<?php echo e(!empty($user->avatar) ? $logos . $user->avatar : $logos . 'avatar.png'); ?>"
                                                    class="img-fluid rounded-circle card-avatar" width="30"
                                                    id="blah3">
                                            </a>
                                        </td>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <?php if(\Auth::user()->type == 'Admin'): ?>
                                            <td>
                                                <?php $__currentLoopData = $user->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <span class="badge badge-white p-2 px-3 rounded fix_badge"
                                                        style="background: <?php echo e($category->color); ?>"><?php echo e($category->name); ?></span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </td>
                                        <?php endif; ?>
                                        <td>
                                            <span class="badge bg-primary p-2 px-3 rounded rounded">
                                                <?php echo e($user->type); ?>

                                            </span>
                                        </td>
                                        <td class="text-end me-3">


                                            <?php if($user->is_disable == 1 || \Auth::user()->type == 'Super Admin'): ?>
                                                <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                                    <div class="action-btn bg-primary ms-2">


                                                        <a title="Admin Hub" data-size="lg" href="#"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                            data-url="<?php echo e(route('user.info', $user->id)); ?>"
                                                            data-ajax-popup="true" data-title="<?php echo e(__('Admin Info')); ?>"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Admin Hub')); ?>"><i
                                                                class="ti ti-atom"></i></a>

                                                    </div>

                                                    <div class="action-btn bg-secondary ms-2">
                                                        <a href="<?php echo e(route('login.with.company', $user->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Login As Admin')); ?>"> <span
                                                                class="text-white"><i class="ti ti-replace"></i></a>
                                                    </div>
                                                    <div class="action-btn bg-secondary ms-2">
                                                        <a href="#"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center text-white"
                                                            data-size="md"
                                                            data-url="<?php echo e(route('plan.upgrade', $user->id)); ?>"
                                                            data-ajax-popup="true" data-bs-toggle="tooltip"
                                                            data-title="<?php echo e(__('Upgrade Plan')); ?>"
                                                            title="<?php echo e(__('Upgrade Plan')); ?>">
                                                            <i class="ti ti-trophy"></i>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>



                                                <?php if($user->is_enable_login == 1): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <a href="<?php echo e(route('users.login', \Crypt::encrypt($user->id))); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Login Disable')); ?>"> <span
                                                                class="text-white"><i class="ti ti-road-sign"></i></a>
                                                    </div>
                                                <?php elseif($user->is_enable_login == 0 && $user->password == null): ?>
                                                    <div class="action-btn bg-primary ms-2">
                                                        <a href="#" data-url="<?php echo e(route('user.reset',\Crypt::encrypt($user->id))); ?>"
                                                            data-ajax-popup="true" data-size="md" class="mx-3 btn btn-sm d-inline-flex align-items-center login_enable" data-title="<?php echo e(__('New Password')); ?>" data-bs-toggle="tooltip" data-bs-original-title="<?php echo e(__('New Password')); ?>"> <span class="text-white"><i class="ti ti-road-sign"></i></a>
                                                    </div>
                                                <?php else: ?>

                                                    <div class="action-btn bg-success ms-2">
                                                        <a href="<?php echo e(route('users.login', \Crypt::encrypt($user->id))); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center login_enable"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-original-title="<?php echo e(__('Login Enable')); ?>"> <span
                                                                class="text-white"> <i class="ti ti-road-sign"></i>
                                                        </a>
                                                    </div>

                                                <?php endif; ?>
                                                <div class="action-btn bg-warning ms-2">
                                                    <a href="#"
                                                        class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                        data-size="md"
                                                        data-url="<?php echo e(route('user.reset', \Crypt::encrypt($user->id))); ?>"
                                                        data-ajax-popup="true" data-title="<?php echo e(__('Reset Password')); ?>"
                                                        data-bs-toggle="tooltip"  title="<?php echo e(__('Reset Password')); ?>" data-bs-placement="top">
                                                        <span class="text-white"> <i class="ti ti-key"></i> </span>
                                                    </a>



                                                </div>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit-users')): ?>
                                                    <div class="action-btn bg-info ms-2">
                                                        <a href="<?php echo e(route('users.edit', $user->id)); ?>"
                                                            class="mx-3 btn btn-sm d-inline-flex align-items-center"
                                                            data-bs-toggle="tooltip"  title="<?php echo e(__('Edit')); ?>"> <span
                                                                class="text-white"> <i class="ti ti-edit"></i></span></a>
                                                    </div>
                                                <?php endif; ?>
                                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-users')): ?>
                                                    <div class="action-btn bg-danger ms-2">
                                                        <form method="POST" action="<?php echo e(route('users.destroy', $user->id)); ?>"
                                                            id="delete-form-<?php echo e($user->id); ?>">
                                                            <?php echo csrf_field(); ?>
                                                            <input name="_method" type="hidden" value="DELETE">
                                                            <button type="submit"
                                                                class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm"
                                                                data-bs-toggle="tooltip" title="<?php echo e(__('Delete')); ?>">
                                                                <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <div class="text-end me-3">
                                                    <i class="ti ti-lock"></i>
                                                </div>
                                            <?php endif; ?>

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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/users/index.blade.php ENDPATH**/ ?>