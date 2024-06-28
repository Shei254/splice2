<?php
    $setting = Utility::settings();
    $logo = Utility::get_superadmin_logo();
    $logos = \App\Models\Utility::get_file('uploads/logo/');
    $lang = app()->getLocale();
    if ($lang == 'ar' || $lang == 'he') {
        $settings['SITE_RTL'] = 'on';
    }
    $LangName = \App\Models\Languages::where('code', $lang)->first();
    if (empty($LangName)) {
        $LangName = new App\Models\Utility();
        $LangName->fullName = 'English';
    }
    // $settings = App\Models\Settings::colorset();

    $settings = App\Models\Utility::colorset();

    $color = !empty($settings['color']) ? $settings['color'] : 'theme-3';

    if(isset($settings['color_flag']) && $settings['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }
?>



<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Reset Password')); ?>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<div class="custom-login">
    <div class="login-bg-img">
        <img src="<?php echo e(isset($settings['color_flag']) && $settings['color_flag'] == 'false' ? asset('assets/images/auth/' . $themeColor . '.svg') : asset('assets/images/auth/theme-3.svg')); ?>" class="login-bg-1">

        <img src="<?php echo e(asset('assets/images/user2.svg')); ?>" class="login-bg-2">
    </div>
    <div class="bg-login bg-primary"></div>
    <div class="custom-login-inner">

        <nav class="navbar navbar-expand-md default">
            <div class="container pe-2">
                <div class="navbar-brand">
                    <a href="#">
                        <img src="<?php echo e($logos . $logo . '?timestamp=' . time()); ?>"
                            alt="<?php echo e(config('app.name', 'TicketGo Saas')); ?>" alt="logo" loading="lazy"
                            class="logo" height="41px" width="150px"/>
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarlogin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarlogin">
                    <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                        <?php echo $__env->make('landingpage::layouts.buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Agent Login')); ?></a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('search',$lang)); ?>"><?php echo e(__('Search Ticket')); ?></a>
                        </li>
                        <div class="lang-dropdown-only-desk">
                            <li class="dropdown dash-h-item drp-language">
                                <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="drp-text"> <?php echo e(ucfirst($LangName->fullName)); ?>

                                    </span>
                                </a>
                                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                                    <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('password.request', $code)); ?>" tabindex="0"
                                            class="dropdown-item dropdown-item <?php echo e($LangName->code == $code ? 'active' : ''); ?>">
                                            <span><?php echo e(ucFirst($language)); ?></span>
                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </li>
                        </div>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="custom-wrapper">
            <div class="custom-row">

                    <div class="card">

                        <div class="card-body">
                            <div>
                                <h2 class="mb-3 f-w-600"><?php echo e(__('Forgot Password')); ?></h2>
                            </div>
                            <form method="POST" action="<?php echo e(route('password.email')); ?>" id="form_data">
                                <?php echo csrf_field(); ?>
                                <?php if(session()->has('info')): ?>
                                    <div class="alert alert-success">
                                        <?php echo e(session()->get('info')); ?>

                                    </div>
                                <?php endif; ?>
                                <?php if(session()->has('status')): ?>
                                    <div class="alert alert-info">
                                        <?php echo e(session()->get('status')); ?>

                                    </div>
                                <?php elseif(session('Error')): ?>
                                <div class="text-danger">
                                    <?php echo e(session()->get('Error')); ?>

                                </div>
                            <?php endif; ?>

                                <div class="custom-login-form">
                                    <div class="">
                                        <div class="form-group mb-3">
                                            <label for="email" class="form-label d-flex"><?php echo e(__('Email')); ?></label>
                                            <input type="email"
                                                class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                                                id="email" name="email" placeholder="<?php echo e(__('Email address')); ?>"
                                                required="" value="<?php echo e(old('email')); ?>">
                                            <div class="invalid-feedback d-block">
                                                <?php echo e($errors->first('email')); ?>

                                            </div>
                                        </div>
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-block mt-2"
                                                id="login_button"><?php echo e(__('Send Password Reset Link')); ?></button>
                                        </div>
                                    </div>

                                    <p class="my-4 text-center"><?php echo e(__('Back to? ')); ?>

                                        <a href="<?php echo e(route('login',$lang)); ?>" class="my-4 text-primary"><?php echo e(__('Login')); ?></a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>

            </div>
        </main>
        <footer>
            <div class="auth-footer">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <span>&copy; <?php echo e(date('Y')); ?>

                                <?php echo e(App\Models\Utility::getValByName('footer_text') ? App\Models\Utility::getValByName('footer_text') : config('app.name', 'Storego Saas')); ?>

                               </span>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>