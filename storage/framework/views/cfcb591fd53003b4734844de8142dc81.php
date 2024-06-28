<?php
    $logo = Utility::get_superadmin_logo();
    $logos = \App\Models\Utility::get_file('uploads/logo/');

    $LangName = \App\Models\Languages::where('code', $lang)->first();
    if (empty($LangName)) {
        $LangName = new App\Models\Utility();
        $LangName->fullName = 'English';
    }
    $setting = App\Models\Utility::colorset();

    $color = !empty($setting['color']) ? $setting['color'] : 'theme-3';

    if(isset($setting['color_flag']) && $setting['color_flag'] == 'true')
    {
        $themeColor = 'custom-color';
    }
    else {
        $themeColor = $color;
    }
    $settings =   App\Models\Utility::settings();

    config(
        [
            'captcha.secret' => $settings['NOCAPTCHA_SECRET'],
            'captcha.sitekey' => $settings['NOCAPTCHA_SITEKEY'],
            'options' => [
                'timeout' => 30,
            ],
        ]
    );
?>



<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Register')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('custom-scripts'); ?>
    <?php if(Utility::getSettingValByName('RECAPTCHA_MODULE') == 'yes'): ?>
        <?php echo NoCaptcha::renderJs(); ?>

    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="custom-login">
    <div class="login-bg-img">
        <img src="<?php echo e(isset($setting['color_flag']) && $setting['color_flag'] == 'false' ? asset('assets/images/auth/' . $themeColor . '.svg') : asset('assets/images/auth/theme-3.svg')); ?>" class="login-bg-1">

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
                            class="logo" height="41px" width="150px" />
                    </a>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarlogin">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarlogin">
                    <ul class="navbar-nav align-items-center ms-auto mb-2 mb-lg-0">
                        <?php echo $__env->make('landingpage::layouts.buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <div class="lang-dropdown-only-desk">
                            <li class="dropdown dash-h-item drp-language">
                                <a class="dash-head-link dropdown-toggle btn" href="#" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="drp-text"> <?php echo e(ucfirst($LangName->fullName)); ?>

                                    </span>
                                </a>
                                <div class="dropdown-menu dash-h-dropdown dropdown-menu-end">
                                    <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="<?php echo e(route('register',[$ref,$code])); ?>" tabindex="0"
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
                                    <h2 class="mb-3 f-w-600"><?php echo e(__('Register')); ?></h2>
                                </div>
                                <?php echo e(Form::open(['route' => 'register', 'method' => 'post', 'id' => 'loginForm'])); ?>

                                <input type="hidden" name="ref_code" value="<?php echo e($ref); ?>">
                                <?php if(session('status')): ?>
                                    <div class="mb-4 font-medium text-lg text-green-600 text-danger">
                                        <?php echo e(__('Email SMTP settings does not configured so please contact to your site admin.')); ?>

                                    </div>
                                <?php endif; ?>

                                <div class="custom-login-form">
                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex"><?php echo e(__('Full Name')); ?></label>
                                        <?php echo e(Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Username'),'required'=>'required'])); ?>

                                    </div>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="error invalid-name text-danger" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex"><?php echo e(__('Email')); ?></label>
                                        <?php echo e(Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email address'),'required'=>'required'])); ?>

                                    </div>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="error invalid-email text-danger" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-group mb-3">
                                        <label class="form-label d-flex"><?php echo e(__('Password')); ?></label>
                                        <?php echo e(Form::password('password', ['class' => 'form-control', 'id' => 'input-password', 'placeholder' => __('Enter Password'),'required'=>'required'])); ?>

                                    </div>
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="error invalid-password text-danger" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-group">
                                        <label class="form-control-label d-flex"><?php echo e(__('Confirm password')); ?></label>
                                        <?php echo e(Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'confirm-input-password', 'placeholder' => __('Enter Confirm Password'),'required'=>'required'])); ?>


                                        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="error invalid-password_confirmation text-danger" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>

                                    <?php if(Utility::getSettingValByName('RECAPTCHA_MODULE') == 'yes'): ?>
                                    <div class="form-group mb-4">
                                        <?php echo NoCaptcha::display(); ?>

                                        <?php $__errorArgs = ['g-recaptcha-response'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="small text-danger" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="d-grid">

                                        <button class="btn btn-primary btn-block mt-2" id="login_button"><?php echo e(__('Register')); ?></button>
                                    </div>

                                </div>

                                    <p class="my-4 text-center d-flex"><?php echo e(__('Already have an account? ')); ?><a
                                            href="<?php echo e(route('login',$lang)); ?>"
                                            tabindex="0"><?php echo e(__('Login')); ?></a>
                                    </p>

                            <?php echo e(Form::close()); ?>


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

<?php $__env->startPush('scripts'); ?>
    <?php if(Utility::getSettingValByName('RECAPTCHA_MODULE') == 'yes'): ?>
    <?php echo NoCaptcha::renderJs(); ?>

    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>