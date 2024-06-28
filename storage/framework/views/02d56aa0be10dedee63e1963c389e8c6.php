<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Edit Profile')); ?> (<?php echo e($user->name); ?>)
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
<li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Users')); ?></a></li>
<li class="breadcrumb-item"><?php echo e(__('Edit')); ?></li>
<?php $__env->stopSection(); ?>
<?php
    $logos = \App\Models\Utility::get_file('public/');

?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="<?php echo e(route('update.profile',$user->id)); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label"><?php echo e(__('Name')); ?></label>
                            <div class="col-sm-12 col-md-12">
                                <input type="text" placeholder="<?php echo e(__('Full name of the user')); ?>" name="name" class="form-control <?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" value="<?php echo e($user->name); ?>" autofocus>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('name')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label"><?php echo e(__('Email')); ?></label>
                            <div class="col-sm-12 col-md-12">
                                <input type="email" placeholder="<?php echo e(__('Email address (should be unique)')); ?>" name="email" class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" value="<?php echo e($user->email); ?>">
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('email')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label"><?php echo e(__('Password')); ?></label>
                            <div class="col-sm-12 col-md-12">
                                <input type="password" name="password" autocomplete="new-password" placeholder="<?php echo e(__('Set an account password')); ?>" class="form-control <?php echo e($errors->has('password') ? ' is-invalid': ''); ?>">
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('password')); ?>

                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="form-label"><?php echo e(__('Confirm Password')); ?></label>
                            <div class="col-sm-12 col-md-12">
                                <input type="password" name="password_confirmation" placeholder="<?php echo e(__('Confirm account password')); ?>" autocomplete="new-password" class="form-control <?php echo e($errors->has('password_confirmation') ? ' is-invalid': ''); ?>">
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('password_confirmation')); ?>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-4">
                            <label class="form-label"><?php echo e(__('Picture')); ?></label>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="choose-file form-group">
                                        <label for="file" class="form-label">
                                            <div><?php echo e(__('Choose File Here')); ?></div>

                                            <input type="file" name="avatar" id="file" class="form-control <?php echo e($errors->has('avatar') ? ' is-invalid' : ''); ?>" onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                            <div class="invalid-feedback">
                                                <?php echo e($errors->first('avatar')); ?>

                                            </div>
                                        </label>
                                        <p class="avatar_selection"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="form-label"></label>
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group col-lg-12 col-md-12">
                                    <div class="user-main-image">
                                        <?php
                                        $logos = \App\Models\Utility::get_file('public/');
                                        ?>

                                        <a href="<?php echo e((!empty($user->avatar))? ($logos.$user->avatar): $logos."/avatar.png"); ?>" target="_blank">
                                            <img src="<?php echo e((!empty($user->avatar))? ($logos.$user->avatar): $logos."/avatar.png"); ?>" class="img-fluid rounded-circle card-avatar" width="35" id="blah3">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label"></label>
                            <div class="col-sm-12 col-md-12 text-end">
                                <button class="btn btn-primary btn-block btn-submit"><span><?php echo e(__('Update')); ?></span></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/users/profile.blade.php ENDPATH**/ ?>