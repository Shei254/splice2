<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Settings ')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Settings')); ?></li>
<?php $__env->stopSection(); ?>

<?php
    $logos = \App\Models\Utility::get_file('uploads/logo/');

    $layout_setting = App\Models\Utility::getLayoutsSetting();
    if (\Auth::user()->type == 'Admin') {
        $company_logo_light = $layout_setting['company_logo_light'];

        $company_logo = $layout_setting['company_logo'];
        $company_favicon = $layout_setting['company_favicon'];
    }
    $settings = App\Models\Utility::settings();
    $cust_theme_bg = 'on';
    if (!empty($settings['cust_theme_bg'])) {
        $cust_theme_bg = $settings['cust_theme_bg'];
    }

    $cust_darklayout = 'off';
    if (!empty($layout_setting['cust_darklayout'])) {
        $cust_darklayout = $layout_setting['cust_darklayout'];
        $company_logo = $layout_setting['company_logo'];
    }

    $color = isset($settings['color']) ? $settings['color'] : 'theme-3';
    $flag = isset($settings['color_flag']) ? $settings['color_flag'] : 'false';

    $FAQ = !empty($settings['FAQ']) ? $settings['FAQ'] : 'on';
    $EmailTemplates = App\Models\EmailTemplate::getemailtemplate();

    $file_type = config('files_types');
    $setting = App\Models\Utility::superAdminsettings();

    $local_storage_validation = $setting['local_storage_validation'];
    $local_storage_validations = explode(',', $local_storage_validation);

    $s3_storage_validation = $setting['s3_storage_validation'];
    $s3_storage_validations = explode(',', $s3_storage_validation);

    $wasabi_storage_validation = $setting['wasabi_storage_validation'];
    $wasabi_storage_validations = explode(',', $wasabi_storage_validation);

    $getSetting = \App\Models\Utility::getSeoSetting();
    $lang = 'en';
    if (!empty(\App\Models\Utility::getValByName('DEFAULT_LANG'))) {
        $lang = \App\Models\Utility::getValByName('DEFAULT_LANG');
    }

    if (\Auth::user()->type == 'Super Admin') {
        $settings = Utility::settings();
    } else {
        $settings = Utility::settingsById(\Auth::user()->id);
    }
?>



<?php $__env->startPush('css-page'); ?>
    <?php if($color == 'theme-1'): ?>
        <style>
            .btn-check:checked+.btn-outline-success,
            .btn-check:active+.btn-outline-success,
            .btn-outline-success:active,
            .btn-outline-success.active,
            .btn-outline-success.dropdown-toggle.show {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
                border-color: #51459d !important;

            }

            .btn-outline-success:hover {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(81, 69, 157, 0) 3.46%, rgba(255, 58, 110, 0.6) 99.86%), #51459d !important;
                border-color: #51459d !important;
            }

            .btn.btn-outline-success {
                color: #51459d;
                border-color: #51459d !important;
            }
        </style>
    <?php endif; ?>

    <?php if($color == 'theme-2'): ?>
        <style>
            .btn-check:checked+.btn-outline-success,
            .btn-check:active+.btn-outline-success,
            .btn-outline-success:active,
            .btn-outline-success.active,
            .btn-outline-success.dropdown-toggle.show {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
                border-color: #1F3996 !important;

            }

            .btn-outline-success:hover {
                color: #ffffff;
                background: linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #4ebbd3 99.86%)#1f3996 !important;
                border-color: #1F3996 !important;
            }

            .btn.btn-outline-success {
                color: #1F3996;
                border-color: #1F3996 !important;
            }
        </style>
    <?php endif; ?>

    <?php if($color == 'theme-4'): ?>
        <style>
            .btn-check:checked+.btn-outline-success,
            .btn-check:active+.btn-outline-success,
            .btn-outline-success:active,
            .btn-outline-success.active,
            .btn-outline-success.dropdown-toggle.show {
                color: #ffffff;
                background-color: #584ed2 !important;
                border-color: #584ed2 !important;

            }

            .btn-outline-success:hover {
                color: #ffffff;
                background-color: #584ed2 !important;
                border-color: #584ed2 !important;
            }

            .btn.btn-outline-success {
                color: #584ed2;
                border-color: #584ed2 !important;
            }
        </style>
    <?php endif; ?>

    <?php if($color == 'theme-3'): ?>
        <style>
            .btn-check:checked+.btn-outline-success,
            .btn-check:active+.btn-outline-success,
            .btn-outline-success:active,
            .btn-outline-success.active,
            .btn-outline-success.dropdown-toggle.show {
                color: #ffffff;
                background-color: #6fd943 !important;
                border-color: #6fd943 !important;

            }

            .btn-outline-success:hover {
                color: #ffffff;
                background-color: #6fd943 !important;
                border-color: #6fd943 !important;
            }

            .btn.btn-outline-success {
                color: #6fd943;
                border-color: #6fd943 !important;
            }
        </style>
        <style>
            .radio-button-group .radio-button {
                position: absolute;
                width: 1px;
                height: 1px;
                opacity: 0;
            }
        </style>
    <?php endif; ?>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class="card sticky-top" style="top:30px">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            <?php if(\Auth::user()->type == 'Admin' || \Auth::user()->type == 'Super Admin'): ?>
                                <a href="#logo-settings"
                                    class="list-group-item list-group-item-action border-0 active"><?php echo e(__('Brand Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'Admin' || \Auth::user()->type == 'Super Admin'): ?>
                                <a href="#email-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Email Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'Admin'): ?>
                                <a href="#email-notification-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Email Notification Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                <a href="#pusher-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Pusher Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                                <a href="#recaptcha-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('ReCaptcha Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'Admin'): ?>
                                <a href="#ticket-fields-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Ticket Fields Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                                <a href="#company-settings" id="company-setting-tab"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Company Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>

                                <a href="#slack-settings" id="slack-setting-tab"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Slack Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>

                                <a href="#telegram-settings" id="telegram-setting-tab"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Telegram Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>

                                <a href="#domain-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Domain Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>

                                <a href="#webhook-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Webhook Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                <a href="#payment-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Payment Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                <a href="#storage-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Storage Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                            <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                <a href="#seo-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('SEO Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>


                            <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                <a href="#cookie-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Cookie Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>

                            <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                <a href="#cache-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Cache Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                                <a href="#chatgpt-settings"
                                    class="list-group-item list-group-item-action border-0"><?php echo e(__('Chat GPT Key Settings')); ?>

                                    <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="logo-settings" class="card">
                            <div class="card-header">
                                <h5><?php echo e(__('Brand Settings')); ?></h5>
                                <small class="text-muted">Edit your brand details</small>

                            </div>
                            <?php echo e(Form::open(['route' => 'settings.store', 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                            <div class="card-body">
                                <?php echo e(Form::open(['route' => 'settings.store', 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title"><?php echo e(__('Dark Logo')); ?></h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content logo-set-bg  text-center py-2">

                                                            <a href="<?php echo e($logos . 'logo-dark.png'); ?>" target="_blank">
                                                                <img id="blah2" alt="your image"
                                                                    src="<?php echo e($logos . 'logo-dark.png' . '?' . time()); ?>"
                                                                    width="150px" class="logo logo-sm">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="choose-files mt-4">
                                                            <label for="logo" class="form-label d-block">
                                                                <div class="bg-primary m-auto">
                                                                    <i
                                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                                    <input type="file" name="logo" id="logo"
                                                                        class="form-control file"
                                                                        data-filename="company_logo_update"
                                                                        onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                                                </div>
                                                            </label>
                                                            <p class="edit-logo"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title"><?php echo e(__('Light Logo')); ?></h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content  logo-set-bg text-center py-2">

                                                            <a href="<?php echo e($logos . 'logo-light.png'); ?>" target="_blank">
                                                                <img id="blah3" alt="your image"
                                                                    src="<?php echo e($logos . 'logo-light.png' . '?' . time()); ?>"
                                                                    width="150px" class="logo logo-sm img_setting"
                                                                    style="filter: drop-shadow(2px 3px 7px #011c4b);">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="choose-files mt-4">
                                                            <label for="white_logo" class="form-label d-block">
                                                                <div class=" bg-primary m-auto">
                                                                    <i
                                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                                    <input type="file" name="white_logo"
                                                                        id="white_logo" class="form-control file"
                                                                        data-filename="company_logo_update"
                                                                        onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                                                </div>
                                                            </label>
                                                            <p class="edit-white_logo"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title"><?php echo e(__('Favicon')); ?></h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content logo-set-bg text-center py-2">

                                                            <a href="<?php echo e($logos . 'favicon.png'); ?>" target="_blank">
                                                                <img id="blah" alt="your image"
                                                                    src="<?php echo e($logos . 'favicon.png' . '?' . time()); ?>"
                                                                    width="80px" class="big-logo img_setting">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="choose-files mt-4">
                                                            <label for="favicon" class="form-label d-block">
                                                                <div class=" bg-primary m-auto">
                                                                    <i
                                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                                    <input type="file" name="favicon" id="favicon"
                                                                        class="form-control file"
                                                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                                </div>
                                                            </label>
                                                            <p class="edit-favicon"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">

                                        <div class="card-body setting-card p-3 mt-3">
                                            <div class="row">
                                                <div class="col-lg-4 col-xl-4 col-md-4">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('app_name', __('App Name'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('app_name', env('APP_NAME'), ['class' => 'form-control', 'placeholder' => __('App Name')])); ?>


                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-md-4">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('footer_text', __('Footer Text'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('footer_text', env('FOOTER_TEXT'), ['class' => 'form-control', 'placeholder' => __('Footer Text')])); ?>

                                                    </div>
                                                </div>

                                                <div class="col-lg-4 col-xl-4 col-md-4">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('default_language', __('Default Language'), ['class' => 'form-label'])); ?>

                                                        <div class="changeLanguage">
                                                            <select name="default_language" id="default_language"
                                                                class="form-select">
                                                                
                                                                

                                                                <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option
                                                                        <?php if($lang == $code): ?> selected <?php endif; ?>
                                                                        value="<?php echo e($code); ?>">
                                                                        <?php echo e(Str::ucfirst($language)); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mt-2">
                                                    <?php echo e(Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'col-form-label'])); ?>

                                                    <div class="col-12 mt-2">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" data-toggle="switchbutton"
                                                                class="custom-control-input" name="SITE_RTL"
                                                                id="SITE_RTL"
                                                                <?php echo e($settings['SITE_RTL'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="form-check-labe" for="SITE_RTL"></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-3 mt-2">
                                                    <?php echo e(Form::label('display_landing_page_', __('Enable Landing Page'), ['class' => 'col-form-label'])); ?>

                                                    <div class="col-12 mt-2">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input"
                                                                name="display_landing" data-toggle="switchbutton"
                                                                id="display_landing"
                                                                <?php echo e($settings['display_landing'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="form-check-labe" for="display_landing"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mt-2">
                                                    <?php echo e(Form::label('SIGNUP', __('Enable Sign-Up Page'), ['class' => 'col-form-label'])); ?>

                                                    <div class="col-12 mt-2">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" data-toggle="switchbutton"
                                                                class="custom-control-input" name="SIGNUP"
                                                                id="SIGNUP"
                                                                <?php echo e(isset($settings['SIGNUP']) && $settings['SIGNUP'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="form-check-labe" for="SIGNUP"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3 mt-2">
                                                    <?php echo e(Form::label('verification_btn', __('Enable Email Verification'), ['class' => 'col-form-label'])); ?>

                                                    <div class="col-12 mt-2">
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" data-toggle="switchbutton"
                                                                class="custom-control-input" name="verification_btn"
                                                                id="verification_btn"
                                                                <?php echo e(isset($settings['verification_btn']) && $settings['verification_btn'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                            <label class="form-check-labe" for="verification_btn"></label>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                            <div class="row">
                                                <h4 class="small-title"><?php echo e(__('Theme Customizer')); ?></h4>

                                                <div class="setting-card setting-logo-box p-3">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-xl-4 col-md-4">
                                                            <h6 class="mt-2">
                                                                <i data-feather="credit-card"
                                                                    class="me-2"></i><?php echo e(__('Primary color settings')); ?>

                                                            </h6>

                                                            <hr class="my-2" />
                                                            <div class="color-wrp">
                                                                <div class="theme-color themes-color">
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-1' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-1"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-1"<?php echo e($color == 'theme-1' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-2' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-2"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-2"<?php echo e($color == 'theme-2' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-3' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-3"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-3"<?php echo e($color == 'theme-3' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-4' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-4"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-4"<?php echo e($color == 'theme-4' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-5' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-5"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-5"<?php echo e($color == 'theme-5' ? 'checked' : ''); ?>>
                                                                    <br>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-6' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-6"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-6"<?php echo e($color == 'theme-6' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-7' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-7"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-7"<?php echo e($color == 'theme-7' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-8' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-8"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-8"<?php echo e($color == 'theme-8' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-9' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-9"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-9"<?php echo e($color == 'theme-9' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-10' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-10"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-10"<?php echo e($color == 'theme-10' ? 'checked' : ''); ?>>
                                                                </div>
                                                                <div class="color-picker-wrp ">
                                                                    <input type="color"
                                                                        value="<?php echo e($color ? $color : ''); ?>"
                                                                        class="colorPicker <?php echo e(isset($flag) && $flag == 'true' ? 'active_color' : ''); ?>"
                                                                        name="custom_color" id="color-picker">
                                                                    <input type='hidden' name="color_flag"
                                                                        value=<?php echo e(isset($flag) && $flag == 'true' ? 'true' : 'false'); ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-xl-4 col-md-4">
                                                            <h6 class="mt-2">
                                                                <i data-feather="layout"
                                                                    class="me-2"></i><?php echo e(__('Sidebar settings')); ?>

                                                            </h6>
                                                            <hr class="my-2" />
                                                            <div class="form-check form-switch">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="cust-theme-bg" name="cust_theme_bg"
                                                                    <?php echo e(!empty($settings['cust_theme_bg']) && $settings['cust_theme_bg'] == 'on' ? 'checked' : ''); ?> />
                                                                <label class="form-check-label f-w-600 pl-1"
                                                                    for="cust-theme-bg"><?php echo e(__('Transparent layout')); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-xl-4 col-md-4">
                                                            <h6 class="mt-2">
                                                                <i data-feather="sun"
                                                                    class="me-2"></i><?php echo e(__('Layout settings')); ?>

                                                            </h6>
                                                            <hr class="my-2" />
                                                            <div class="form-check form-switch mt-2">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="cust-darklayout"
                                                                    name="cust_darklayout"<?php echo e(!empty($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? 'checked' : ''); ?> />
                                                                <label class="form-check-label f-w-600 pl-1"
                                                                    for="cust-darklayout"><?php echo e(__('Dark Layout')); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer text-end">
                                <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary'])); ?>

                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Admin'): ?>
                        <div id="logo-settings" class="card">
                            <div class="card-header">
                                <h5><?php echo e(__('Brand Settings')); ?></h5>
                                <small class="text-muted">Edit your brand details</small>

                            </div>
                            <div class="card-body">
                                <?php echo e(Form::open(['route' => 'settings.store', 'method' => 'post', 'enctype' => 'multipart/form-data'])); ?>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title"><?php echo e(__('Dark Logo')); ?></h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content logo-set-bg  text-center py-2">

                                                            <a href="<?php echo e($logos . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo_dark.png')); ?>"
                                                                target="_blank">
                                                                <img id="blah2" alt="your image"
                                                                    src="<?php echo e($logos . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo . '?' . time() : 'logo_dark.png' . '?' . time())); ?>"
                                                                    width="170px" class="">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="choose-files mt-4">
                                                            <label for="logo" class="form-label d-block">
                                                                <div class="bg-primary m-auto">
                                                                    <i
                                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                                    <input type="file" name="company_logo"
                                                                        id="company_logo" class="form-control file"
                                                                        data-filename="company_logo_update"
                                                                        onchange="document.getElementById('blah2').src = window.URL.createObjectURL(this.files[0])">
                                                                </div>
                                                            </label>
                                                            <p class="edit-logo"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title"><?php echo e(__('Light Logo')); ?></h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content  logo-set-bg text-center py-2">

                                                            <a href="<?php echo e($logos . '/' . (isset($company_logo_light) && !empty($company_logo_light) ? $company_logo_light : 'logo_light.png')); ?>"
                                                                target="_blank">
                                                                <img id="blah3" alt="your image"
                                                                    src="<?php echo e($logos . '/' . (isset($company_logo_light) && !empty($company_logo_light) ? $company_logo_light . '?' . time() : 'logo_light.png' . '?' . time())); ?>"
                                                                    width="170px" class=""
                                                                    style="filter: drop-shadow(2px 3px 7px #011c4b);">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="choose-files mt-4">
                                                            <label for="white_logo" class="form-label d-block">
                                                                <div class=" bg-primary m-auto">
                                                                    <i
                                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                                    <input type="file" name="company_logo_light"
                                                                        id="company_logo_light" class="form-control file"
                                                                        onchange="document.getElementById('blah3').src = window.URL.createObjectURL(this.files[0])">
                                                                </div>
                                                            </label>
                                                            <p class="edit-white_logo"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5 class="small-title"><?php echo e(__('Favicon')); ?></h5>
                                            </div>
                                            <div class="card-body setting-card setting-logo-box p-3">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="logo-content logo-set-bg text-center py-2">
                                                            <a href="<?php echo e($logos . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon : 'favicon.png')); ?>"
                                                                target="_blank">
                                                                <img id="blah" alt="your image"
                                                                    src="<?php echo e($logos . '/' . (isset($company_favicon) && !empty($company_favicon) ? $company_favicon . '?' . time() : 'favicon.png' . '?' . time())); ?>"
                                                                    width="170px" class="">
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="choose-files mt-4">
                                                            <label for="favicon" class="form-label d-block">
                                                                <div class=" bg-primary m-auto">
                                                                    <i
                                                                        class="ti ti-upload px-1"></i><?php echo e(__('Choose file here')); ?>

                                                                    <input type="file" name="company_favicon"
                                                                        id="company_favicon" class="form-control file"
                                                                        onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                                                </div>
                                                            </label>
                                                            <p class="edit-favicon"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        
                                        <div class="card-body setting-card p-3 mt-3">
                                            <div class="row">
                                                <div class="col-lg-4 col-xl-4 col-md-4">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('app_name', __('App Name'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('app_name', $settings['App_Name'], ['class' => 'form-control', 'placeholder' => __('App Name')])); ?>

                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-md-4">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('footer_text', __('Footer Text'), ['class' => 'form-label'])); ?>

                                                        <?php echo e(Form::text('footer_text', $settings['footer_text'], ['class' => 'form-control', 'placeholder' => __('Footer Text')])); ?>

                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-xl-4 col-md-4">
                                                    <div class="form-group">
                                                        <?php echo e(Form::label('default_language', __('Default Language'), ['class' => 'form-label'])); ?>

                                                        <div class="changeLanguage">
                                                            <select name="default_language" id="default_language"
                                                                class="form-select">
                                                                
                                                                

                                                                <?php $__currentLoopData = App\Models\Utility::languages(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code => $language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option
                                                                        <?php if($lang == $code): ?> selected <?php endif; ?>
                                                                        value="<?php echo e($code); ?>">
                                                                        <?php echo e(Str::ucfirst($language)); ?></option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12 col-xl-12 col-md-12">
                                                    <div class="row">
                                                        <div class="col-3">
                                                            <div class="col switch-width">
                                                                <div class="form-group ml-2 mr-3 ">
                                                                    <?php echo e(Form::label('SITE_RTL', __('Enable RTL'), ['class' => 'form-label'])); ?>

                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" data-toggle="switchbutton"
                                                                            data-onstyle="primary" class=""
                                                                            name="SITE_RTL" id="SITE_RTL"
                                                                            <?php echo e($settings['SITE_RTL'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                        <label class="custom-control-label"
                                                                            for="SITE_RTL"></label>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php if(\Auth::user()->type == 'Admin'): ?>
                                                            <div class="col-3 switch-width">
                                                                <div class="form-group mr-3">
                                                                    <label class="form-label"><?php echo e(__('FAQ')); ?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" data-toggle="switchbutton"
                                                                            data-onstyle="primary" class=""
                                                                            name="faq" id="faq"
                                                                            <?php echo e($settings['FAQ'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                        <label class="custom-control-label"
                                                                            for="faq"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col switch-width">
                                                                <div class="form-group mr-3">
                                                                    <label
                                                                        class="form-label"><?php echo e(__('Knowledge Base')); ?></label>
                                                                    <div class="custom-control custom-switch">
                                                                        <input type="checkbox" data-toggle="switchbutton"
                                                                            data-onstyle="primary" class=""
                                                                            name="knowledge" id="knowledge"
                                                                            <?php echo e($settings['Knowlwdge_Base'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                        <label class="custom-control-label"
                                                                            for="knowledge"></label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if(\Auth::user()->type == 'Super Admin'): ?>
                                                            <div class="col-3 ">
                                                                <div class="col switch-width">
                                                                    <div class="form-group mr-3">
                                                                        <label class="form-label text-dark "
                                                                            for="display_landing"><?php echo e(__('Enable Landing Page')); ?></label>
                                                                        <div class="form-check form-switch d-inline-block">
                                                                            <input type="checkbox" name="display_landing"
                                                                                class="form-check-input"
                                                                                id="display_landing"
                                                                                data-toggle="switchbutton"
                                                                                <?php echo e($settings['display_landing'] == 'on' ? 'checked="checked"' : ''); ?>

                                                                                data-onstyle="primary">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <h4 class="small-title"><?php echo e(__('Theme Customizer')); ?></h4>

                                                <div class="setting-card setting-logo-box p-3">
                                                    <div class="row">
                                                        <div class="col-lg-4 col-xl-4 col-md-4">
                                                            <h6 class="mt-2">
                                                                <i data-feather="credit-card"
                                                                    class="me-2"></i><?php echo e(__('Primary color settings')); ?>

                                                            </h6>

                                                            <hr class="my-2" />
                                                            <div class="color-wrp">
                                                                <div class="theme-color themes-color">
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-1' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-1"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-1"<?php echo e($color == 'theme-1' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-2' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-2"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-2"<?php echo e($color == 'theme-2' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-3' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-3"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-3"<?php echo e($color == 'theme-3' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-4' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-4"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-4"<?php echo e($color == 'theme-4' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-5' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-5"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-5"<?php echo e($color == 'theme-5' ? 'checked' : ''); ?>>
                                                                    <br>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-6' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-6"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-6"<?php echo e($color == 'theme-6' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-7' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-7"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-7"<?php echo e($color == 'theme-7' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-8' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-8"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-8"<?php echo e($color == 'theme-8' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-9' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-9"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-9"<?php echo e($color == 'theme-9' ? 'checked' : ''); ?>>
                                                                    <a href="#!"
                                                                        class="themes-color-change <?php echo e($color == 'theme-10' ? 'active_color' : ''); ?>"
                                                                        data-value="theme-10"></a>
                                                                    <input type="radio" class="theme_color d-none"
                                                                        name="color"
                                                                        value="theme-10"<?php echo e($color == 'theme-10' ? 'checked' : ''); ?>>
                                                                </div>
                                                                <div class="color-picker-wrp ">
                                                                    <input type="color"
                                                                        value="<?php echo e($color ? $color : ''); ?>"
                                                                        class="colorPicker <?php echo e(isset($flag) && $flag == 'true' ? 'active_color' : ''); ?>"
                                                                        name="custom_color" id="color-picker">
                                                                    <input type='hidden' name="color_flag"
                                                                        value=<?php echo e(isset($flag) && $flag == 'true' ? 'true' : 'false'); ?>>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-xl-4 col-md-4">
                                                            <h6 class="mt-2">
                                                                <i data-feather="layout"
                                                                    class="me-2"></i><?php echo e(__('Sidebar settings')); ?>

                                                            </h6>
                                                            <hr class="my-2" />
                                                            <div class="form-check form-switch">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="cust-theme-bg" name="cust_theme_bg"
                                                                    <?php echo e(!empty($settings['cust_theme_bg']) && $settings['cust_theme_bg'] == 'on' ? 'checked' : ''); ?> />
                                                                <label class="form-check-label f-w-600 pl-1"
                                                                    for="cust-theme-bg"><?php echo e(__('Transparent layout')); ?></label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4 col-xl-4 col-md-4">
                                                            <h6 class="mt-2">
                                                                <i data-feather="sun"
                                                                    class="me-2"></i><?php echo e(__('Layout settings')); ?>

                                                            </h6>
                                                            <hr class="my-2" />
                                                            <div class="form-check form-switch mt-2">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="cust-darklayout"
                                                                    name="cust_darklayout"<?php echo e(!empty($settings['cust_darklayout']) && $settings['cust_darklayout'] == 'on' ? 'checked' : ''); ?> />
                                                                <label class="form-check-label f-w-600 pl-1"
                                                                    for="cust-darklayout"><?php echo e(__('Dark Layout')); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="text-end">
                                    <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary'])); ?>

                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>

                        <div id="email-settings" class="card">
                            <div class="card-header">
                                <h5 class="mb-2"><?php echo e(__('Email Settings')); ?></h5>
                                <small>(<?php echo e(__('This SMTP will be used for sending your admin-level email. If this field is empty, then SuperAdmin SMTP will be used for sending emails.')); ?>)</small>

                            </div>
                            <div class="card-body">

                                <?php echo e(Form::model($settings, ['route' => ['email.settings.store'], 'method' => 'post'])); ?>


                                <?php echo csrf_field(); ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_driver', __('Mail Driver'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Driver')); ?>"
                                                name="mail_driver" type="text"
                                                value="<?php echo e(!isset($settings['mail_driver']) || is_null($settings['mail_driver']) ? '' : $settings['mail_driver']); ?>"
                                                id="mail_driver">
                                            <?php $__errorArgs = ['mail_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_host', __('Mail Host'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Host')); ?>"
                                                name="mail_host" type="text"
                                                value="<?php echo e(!isset($settings['mail_host']) || is_null($settings['mail_host']) ? '' : $settings['mail_host']); ?>"
                                                id="mail_host">
                                            <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_host" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_port', __('Mail Port'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Port')); ?>"
                                                name="mail_port" type="text"
                                                value="<?php echo e(!isset($settings['mail_port']) || is_null($settings['mail_port']) ? '' : $settings['mail_port']); ?>"
                                                id="mail_port">
                                            <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_username', __('Mail Username'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Username')); ?>"
                                                name="mail_username" type="text"
                                                value="<?php echo e(!isset($settings['mail_username']) || is_null($settings['mail_username']) ? '' : $settings['mail_username']); ?>"
                                                id="mail_username">
                                            <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_username" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_password', __('Mail Password'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Password')); ?>"
                                                name="mail_password" type="text"
                                                value="<?php echo e(!isset($settings['mail_password']) || is_null($settings['mail_password']) ? '' : $settings['mail_password']); ?>"
                                                id="mail_password">
                                            <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_password" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Encryption')); ?>"
                                                name="mail_encryption" type="text"
                                                value="<?php echo e(!isset($settings['mail_encryption']) || is_null($settings['mail_encryption']) ? '' : $settings['mail_encryption']); ?>"
                                                id="mail_encryption">
                                            <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_encryption" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail From Address')); ?>"
                                                name="mail_from_address" type="text"
                                                value="<?php echo e(!isset($settings['mail_from_address']) || is_null($settings['mail_from_address']) ? '' : $settings['mail_from_address']); ?>"
                                                id="mail_from_address">
                                            <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_from_address" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label'])); ?>

                                            <input class="form-control" placeholder="<?php echo e(__('Mail From Name')); ?>"
                                                name="mail_from_name" type="text"
                                                value="<?php echo e(!isset($settings['mail_from_name']) || is_null($settings['mail_from_name']) ? '' : $settings['mail_from_name']); ?>"
                                                id="mail_from_name">
                                            <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_from_name" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="card-footer d-flex justify-content-end">
                                    <div class="form-group me-2">
                                        <a href="#" data-url="<?php echo e(route('test.email')); ?>"
                                            data-title="<?php echo e(__('Send Test Mail')); ?>" class="btn btn-primary send_email ">
                                            <?php echo e(__('Send Test Mail')); ?>

                                        </a>
                                    </div>

                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>



                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="email-settings" class="card">
                            <div class="card-header">
                                <h5 class="mb-2"><?php echo e(__('Email Settings')); ?></h5>
                                <small>(<?php echo e(__('This SMTP will be used for system-level email sending. Additionally, if a company user does not set their SMTP, then this SMTP will be used for sending emails.
                                    ')); ?>)</small>

                            </div>

                            <div class="card-body">
                                <?php echo e(Form::open(['route' => 'email.settings.store', 'method' => 'post'])); ?>

                                <?php echo csrf_field(); ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_driver', __('Mail Driver'), ['class' => 'form-label'])); ?>

                                            

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Driver')); ?>"
                                                name="mail_driver" type="text"
                                                value="<?php echo e(!isset($settings['mail_driver']) || is_null($settings['mail_driver']) ? '' : $settings['mail_driver']); ?>"
                                                id="mail_driver">

                                            <?php $__errorArgs = ['mail_driver'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_host', __('Mail Host'), ['class' => 'form-label'])); ?>

                                            
                                            <input class="form-control" placeholder="<?php echo e(__('Mail Host')); ?>"
                                                name="mail_host" type="text"
                                                value="<?php echo e(!isset($settings['mail_host']) || is_null($settings['mail_host']) ? '' : $settings['mail_host']); ?>"
                                                id="mail_host">
                                            <?php $__errorArgs = ['mail_host'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_driver" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_port', __('Mail Port'), ['class' => 'form-label'])); ?>

                                            

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Port')); ?>"
                                                name="mail_port" type="text"
                                                value="<?php echo e(!isset($settings['mail_port']) || is_null($settings['mail_port']) ? '' : $settings['mail_port']); ?>"
                                                id="mail_port">
                                            <?php $__errorArgs = ['mail_port'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_port" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_username', __('Mail Username'), ['class' => 'form-label'])); ?>

                                            

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Username')); ?>"
                                                name="mail_username" type="text"
                                                value="<?php echo e(!isset($settings['mail_username']) || is_null($settings['mail_username']) ? '' : $settings['mail_username']); ?>"
                                                id="mail_username">
                                            <?php $__errorArgs = ['mail_username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_username" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_password', __('Mail Password'), ['class' => 'form-label'])); ?>

                                            

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Password')); ?>"
                                                name="mail_password" type="text"
                                                value="<?php echo e(!isset($settings['mail_password']) || is_null($settings['mail_password']) ? '' : $settings['mail_password']); ?>"
                                                id="mail_password">

                                            <?php $__errorArgs = ['mail_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_password" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_encryption', __('Mail Encryption'), ['class' => 'form-label'])); ?>

                                            

                                            <input class="form-control" placeholder="<?php echo e(__('Mail Encryption')); ?>"
                                                name="mail_encryption" type="text"
                                                value="<?php echo e(!isset($settings['mail_encryption']) || is_null($settings['mail_encryption']) ? '' : $settings['mail_encryption']); ?>"
                                                id="mail_encryption">
                                            <?php $__errorArgs = ['mail_encryption'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_encryption" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_from_address', __('Mail From Address'), ['class' => 'form-label'])); ?>

                                            

                                            <input class="form-control" placeholder="<?php echo e(__('Mail From Address')); ?>"
                                                name="mail_from_address" type="text"
                                                value="<?php echo e(!isset($settings['mail_from_address']) || is_null($settings['mail_from_address']) ? '' : $settings['mail_from_address']); ?>"
                                                id="mail_from_address">

                                            <?php $__errorArgs = ['mail_from_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_from_address" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?php echo e(Form::label('mail_from_name', __('Mail From Name'), ['class' => 'form-label'])); ?>

                                            
                                            <input class="form-control" placeholder="<?php echo e(__('Mail From Name')); ?>"
                                                name="mail_from_name" type="text"
                                                value="<?php echo e(!isset($settings['mail_from_name']) || is_null($settings['mail_from_name']) ? '' : $settings['mail_from_name']); ?>"
                                                id="mail_from_name">
                                            <?php $__errorArgs = ['mail_from_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-mail_from_name" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="card-footer d-flex justify-content-end">
                                    <div class="form-group me-2">
                                        <a href="#" data-url="<?php echo e(route('test.email')); ?>"
                                            data-title="<?php echo e(__('Send Test Mail')); ?>" class="btn btn-primary send_email ">
                                            <?php echo e(__('Send Test Mail')); ?>

                                        </a>
                                    </div>

                                    <div class="form-group">
                                        <input class="btn btn-primary" type="submit" value="<?php echo e(__('Save Changes')); ?>">
                                    </div>
                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Admin'): ?>
                        <div id="email-notification-settings" class="card">


                            <?php echo e(Form::model($settings, ['route' => ['status.email.language'], 'method' => 'post'])); ?>

                            <?php echo csrf_field(); ?>
                            <div class="col-md-12">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <h5><?php echo e(__('Email Notification Settings')); ?></h5>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <!-- <div class=""> -->
                                        <?php $__currentLoopData = $EmailTemplates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $EmailTemplate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-lg-4 col-md-6 col-sm-6 form-group">
                                                <div class="list-group">
                                                    <div class="list-group-item form-switch form-switch-right">
                                                        <label class="form-label"
                                                            style="margin-left:5%;"><?php echo e($EmailTemplate->name); ?></label>
                                                        <input class="form-check-input" name='<?php echo e($EmailTemplate->id); ?>'
                                                            id="email_tempalte_<?php echo e($EmailTemplate->template->id); ?>"
                                                            type="checkbox"
                                                            <?php if($EmailTemplate->template->is_active == 1): ?> checked="checked" <?php endif; ?>
                                                            type="checkbox" value="1"
                                                            data-url="<?php echo e(route('status.email.language', [$EmailTemplate->template->id])); ?>" />
                                                        <label class="form-check-label"
                                                            for="email_tempalte_<?php echo e($EmailTemplate->template->id); ?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <!-- </div> -->
                                    </div>

                                </div>
                                <div class="card-footer text-end">
                                    <div class="col-sm-12 mt-3 px-2">
                                        <div class="text-end">
                                            <input class="btn btn-print-invoice  btn-primary" type="submit"
                                                value="<?php echo e(__('Save Changes')); ?>">
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="pusher-settings" class="card">
                            <form method="POST" action="<?php echo e(route('pusher.settings.store')); ?>" accept-charset="UTF-8">
                                <?php echo csrf_field(); ?>

                                <div
                                    class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                                    <h5><?php echo e(__('Pusher Settings')); ?></h5>
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                                class="" name="enable_chat" id="enable_chat"
                                                <?php echo e(Utility::superAdminsettings()['CHAT_MODULE'] == 'yes' ? 'checked="checked"' : ''); ?>>
                                            <label class="custom-control-label" for="enable_chat"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_id"
                                                class="form-label"><?php echo e(__('Pusher App Id')); ?></label>
                                            <input class="form-control" placeholder="Enter Pusher App Id"
                                                name="pusher_app_id" type="text"
                                                value="<?php echo e(!empty($settings['PUSHER_APP_ID']) ? $settings['PUSHER_APP_ID'] : ''); ?>"
                                                id="pusher_app_id" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_key"
                                                class="form-label"><?php echo e(__('Pusher App Key')); ?></label>
                                            <input class="form-control " placeholder="Enter Pusher App Key"
                                                name="pusher_app_key" type="text"
                                                value="<?php echo e(!empty($settings['PUSHER_APP_KEY']) ? $settings['PUSHER_APP_KEY'] : ''); ?>"
                                                id="pusher_app_key" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_secret"
                                                class="form-label"><?php echo e(__('Pusher App Secret')); ?></label>
                                            <input class="form-control " placeholder="Enter Pusher App Secret"
                                                name="pusher_app_secret" type="text"
                                                value="<?php echo e(!empty($settings['PUSHER_APP_SECRET']) ? $settings['PUSHER_APP_SECRET'] : ''); ?>"
                                                id="pusher_app_secret" required>
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="pusher_app_cluster"
                                                class="form-label"><?php echo e(__('Pusher App Cluster')); ?></label>
                                            <input class="form-control " placeholder="Enter Pusher App Cluster"
                                                name="pusher_app_cluster" type="text"
                                                value="<?php echo e(!empty($settings['PUSHER_APP_CLUSTER']) ? $settings['PUSHER_APP_CLUSTER'] : ''); ?>"
                                                id="pusher_app_cluster" required>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>"
                                        class="btn btn-primary btn-block btn-submit text-white">
                                </div>
                            </form>
                        </div>



                        <div id="recaptcha-settings" class="card pb-4">
                            <form method="POST" action="<?php echo e(route('recaptcha.settings.store')); ?>"
                                accept-charset="UTF-8">
                                <?php echo csrf_field(); ?>
                                <div
                                    class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                                    <div class="col-6">
                                        <h5><?php echo e(__('ReCaptcha Settings')); ?></h5>
                                        <a href="https://phppot.com/php/how-to-get-google-recaptcha-site-and-secret-key/"
                                            target="_blank" class="text-blue">
                                            <small>(<?php echo e(__('How to Get Google reCaptcha Site and Secret key')); ?>)</small>
                                        </a>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                                class="" name="recaptcha_module" id="recaptcha_module"
                                                <?php echo e(Utility::superAdminsettings()['RECAPTCHA_MODULE'] == 'yes' ? 'checked="checked"' : ''); ?>>

                                            <label class="custom-control-label" for="recaptcha_module"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_key"
                                                class="form-label"><?php echo e(__('Google Recaptcha Key')); ?></label>
                                            <input class="form-control"
                                                placeholder="<?php echo e(__('Enter Google Recaptcha Key')); ?>"
                                                name="google_recaptcha_key" type="text"
                                                value="<?php echo e(!empty($settings['NOCAPTCHA_SITEKEY']) ? $settings['NOCAPTCHA_SITEKEY'] : ''); ?>"
                                                id="google_recaptcha_key">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                            <label for="google_recaptcha_secret"
                                                class="form-label"><?php echo e(__('Google Recaptcha Secret')); ?></label>
                                            <input class="form-control "
                                                placeholder="<?php echo e(__('Enter Google Recaptcha Secret')); ?>"
                                                name="google_recaptcha_secret" type="text"
                                                value="<?php echo e(!empty($settings['NOCAPTCHA_SECRET']) ? $settings['NOCAPTCHA_SECRET'] : ''); ?>"
                                                id="google_recaptcha_secret">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <input type="submit" value="<?php echo e(__('Save Changes')); ?>"
                                        class="btn btn-primary btn-block btn-submit text-white">
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Admin'): ?>
                        <div id="ticket-fields-settings" class="card">
                            <div class="custom-fields" data-value="<?php echo e(json_encode($customFields)); ?>">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div class="">
                                        <h5 class=""><?php echo e(__('Ticket Fields Settings')); ?></h5>
                                        <label class="form-check-label pe-5 text-muted"
                                            for="enable_chat"><?php echo e(__('You can easily change order of fields using drag & drop.')); ?></label>
                                    </div>
                                    <button data-repeater-create type="button"
                                        class="btn btn-sm btn-primary btn-icon m-1 float-end ms-2"
                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="<?php echo e(__('Create Custom Field')); ?>">
                                        <i class="ti ti-plus mr-1"></i>
                                    </button>
                                </div>
                                <div class="card-body table-border-style">
                                    <form method="post" action="<?php echo e(route('custom-fields.store')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <div class="table-responsive m-0 custom-field-table">

                                            <table class="table dataTable-table" id="pc-dt-simple"
                                                data-repeater-list="fields">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th></th>
                                                        <th><?php echo e(__('Labels')); ?></th>
                                                        <th><?php echo e(__('Placeholder')); ?></th>
                                                        <th><?php echo e(__('Type')); ?></th>
                                                        <th><?php echo e(__('Require')); ?></th>
                                                        <th><?php echo e(__('Width')); ?></th>
                                                        <th class="text-right"><?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr data-repeater-item>
                                                        <td><i class="ti ti-arrows-maximize sort-handler"></i></td>
                                                        <td>
                                                            <input type="hidden" name="id" id="id" />
                                                            <input type="hidden" class="custom_id" name="custom_id"
                                                                id="custom_id" />

                                                            <input type="text" name="name"
                                                                class="form-control mb-0" required />
                                                        </td>
                                                        <td>
                                                            <input type="text" name="placeholder"
                                                                class="form-control mb-0" required />
                                                        </td>

                                                        <td>
                                                            <select class="form-control select-field field_type mr-2"
                                                                name="type">
                                                                <?php $__currentLoopData = \App\Models\CustomField::$fieldTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($key); ?>">
                                                                        <?php echo e($value); ?>


                                                                    </option>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <select class="form-control select-field field_type"
                                                                name="is_required">
                                                                <option value="1"><?php echo e(__('Yes')); ?></option>
                                                                <option value="0"><?php echo e(__('No')); ?></option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="form-control select-field" name="width">
                                                                <option value="3">25%</option>
                                                                <option value="4">33%</option>
                                                                <option value="6">50%</option>
                                                                <option value="8">66%</option>
                                                                <option value="12">100%</option>
                                                            </select>
                                                        </td>
                                                        <td class="text-center">
                                                            <a data-repeater-delete class="delete-icon"><i
                                                                    class="fas fa-trash text-danger"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-right text-end float-end p-4">
                                                <button class="btn btn-primary btn-block btn-submit"
                                                    type="submit"><?php echo e(__('Save Changes')); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="" id="company-settings">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Company Settings')); ?></h5>
                                    <small class="text-muted">Edit your company details</small>

                                </div>
                                <?php echo e(Form::model($settings, ['route' => 'company.settings', 'method' => 'post'])); ?>

                                <div class="card-body">

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_name *', __('Company Name *'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('company_name', null, ['class' => 'form-control '])); ?>


                                            <?php $__errorArgs = ['company_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-company_name" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_address', __('Address'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('company_address', null, ['class' => 'form-control '])); ?>

                                            <?php $__errorArgs = ['company_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-company_address" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_city', __('City'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('company_city', null, ['class' => 'form-control '])); ?>

                                            <?php $__errorArgs = ['company_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-company_city" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_state', __('State'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('company_state', null, ['class' => 'form-control '])); ?>

                                            <?php $__errorArgs = ['company_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-company_state" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_zipcode', __('Zip/Post Code'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('company_zipcode', null, ['class' => 'form-control'])); ?>

                                            <?php $__errorArgs = ['company_zipcode'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-company_zipcode" role="alert">
                                                    <strong class="text-danger"><?php echo e($message); ?></strong>
                                                </span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_country', __('Country'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('company_country', null, ['class' => 'form-control '])); ?>

                                            <?php $__errorArgs = ['company_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-company_country" role="alert"><strong
                                                        class="text-danger"><?php echo e($message); ?></strong></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <?php echo e(Form::label('company_telephone', __('Telephone'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('company_telephone', null, ['class' => 'form-control'])); ?>

                                            <?php $__errorArgs = ['company_telephone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <span class="invalid-company_telephone" role="alert"><strong
                                                        class="text-danger"><?php echo e($message); ?></strong></span>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="form-group col-md-6 mt-2">
                                            <?php echo e(Form::label('timezone', __('Timezone'), ['class' => 'form-label'])); ?>


                                            <select name="timezone" id="timezone" class="form-control select2">
                                                <option value=""><?php echo e(__('Select Timezone')); ?></option>
                                                <?php $__currentLoopData = $timezones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $timezone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if(App\Models\Utility::getValByName('timezone') == $k): ?> selected <?php endif; ?>
                                                        value="<?php echo e($k); ?>"><?php echo e($timezone); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 mt-2">
                                            <?php echo e(Form::label('app_url', __('Application URL'), ['class' => 'form-label'])); ?>

                                            <br />
                                            <?php echo e(Form::text('app_url', env('APP_URL'), ['class' => 'form-control', 'placeholder' => __('App Name')])); ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn-submit btn btn-primary" type="submit">
                                        <?php echo e(__('Save Changes')); ?>

                                    </button>
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>


                        <div class="" id="slack-settings">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Slack Settings')); ?></h5>
                                    
                                </div>

                                <?php echo e(Form::model($settings, ['route' => 'slack.setting', 'id' => 'setting-form', 'method' => 'post'])); ?>


                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h4 class="small-title"><?php echo e(__('Slack Webhook URL')); ?></h4>
                                            <div class="col-md-8">
                                                <?php echo e(Form::text('slack_webhook', isset($settings['slack_webhook']) ? $settings['slack_webhook'] : '', ['class' => 'form-control w-100', 'placeholder' => __('Enter Slack Webhook URL'), 'required' => 'required'])); ?>

                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-4 mb-2">
                                            <h4 class="small-title"><?php echo e(__('Module Setting')); ?></h4>
                                        </div>

                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><?php echo e(__('New User')); ?></span>
                                                    <div class="form-check form-switch d-inline-block custom-switch-v1">
                                                        <?php echo e(Form::checkbox('user_notification', '1', isset($settings['user_notification']) && $settings['user_notification'] == '1' ? 'checked' : '', ['class' => 'form-check-input', 'id' => 'user_notification'])); ?>

                                                        <label class="form-check-label" for="user_notification"></label>
                                                    </div>
                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><?php echo e(__('New Ticket')); ?></span>
                                                    <div class="form-check form-switch d-inline-block custom-switch-v1">
                                                        <?php echo e(Form::checkbox('ticket_notification', '1', isset($settings['ticket_notification']) && $settings['ticket_notification'] == '1' ? 'checked' : '', ['class' => 'form-check-input', 'id' => 'ticket_notification'])); ?>

                                                        <label class="form-check-label"
                                                            for="ticket_notification"></label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><?php echo e(__('New Ticket Reply')); ?></span>
                                                    <div class="form-check form-switch d-inline-block custom-switch-v1">
                                                        <?php echo e(Form::checkbox('reply_notification', '1', isset($settings['reply_notification']) && $settings['reply_notification'] == '1' ? 'checked' : '', ['class' => 'form-check-input', 'id' => 'reply_notification'])); ?>

                                                        <label class="form-check-label"
                                                            for="reply_notification"></label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn-submit btn btn-primary" type="submit">
                                        <?php echo e(__('Save Changes')); ?>

                                    </button>
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>


                        <div class="" id="telegram-settings">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Telegram Settings')); ?></h5>
                                    
                                </div>
                                <?php echo e(Form::model($settings, ['route' => 'telegram.setting', 'id' => 'setting-form', 'method' => 'post'])); ?>


                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="form-label mb-0"><?php echo e(__('Telegram AccessToken')); ?></label>
                                            <br>
                                            <?php echo e(Form::text('telegram_accestoken', isset($settings['telegram_accestoken']) ? $settings['telegram_accestoken'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Telegram AccessToken')])); ?>

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="form-label mb-0"><?php echo e(__('Telegram ChatID')); ?></label>
                                            <br>
                                            <?php echo e(Form::text('telegram_chatid', isset($settings['telegram_chatid']) ? $settings['telegram_chatid'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Telegram ChatID')])); ?>

                                        </div>
                                        <div class="col-md-12 mt-4 mb-2">
                                            <h4 class="small-title"><?php echo e(__('Module Setting')); ?></h4>
                                        </div>

                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><?php echo e(__('New User')); ?></span>
                                                    <div class="form-check form-switch d-inline-block custom-switch-v1">
                                                        <?php echo e(Form::checkbox('telegram_user_notification', '1', isset($settings['telegram_user_notification']) && $settings['telegram_user_notification'] == '1' ? 'checked' : '', ['class' => 'form-check-input', 'id' => 'telegram_user_notification'])); ?>

                                                        <label class="form-check-label"
                                                            for="telegram_user_notification"></label>
                                                    </div>

                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><?php echo e(__('New Ticket')); ?></span>
                                                    <div class="form-check form-switch d-inline-block custom-switch-v1">
                                                        <?php echo e(Form::checkbox('telegram_ticket_notification', '1', isset($settings['telegram_ticket_notification']) && $settings['telegram_ticket_notification'] == '1' ? 'checked' : '', ['class' => 'form-check-input', 'id' => 'telegram_ticket_notification'])); ?>

                                                        <label class="form-check-label"
                                                            for="telegram_ticket_notification"></label>
                                                    </div>

                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-md-4">
                                            <ul class="list-group">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span><?php echo e(__('New Ticket Reply')); ?></span>
                                                    <div class="form-check form-switch d-inline-block custom-switch-v1">
                                                        <?php echo e(Form::checkbox('telegram_reply_notification', '1', isset($settings['telegram_reply_notification']) && $settings['telegram_reply_notification'] == '1' ? 'checked' : '', ['class' => 'form-check-input', 'id' => 'telegram_reply_notification'])); ?>

                                                        <label class="form-check-label"
                                                            for="telegram_reply_notification"></label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>

                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn-submit btn btn-primary" type="submit">
                                        <?php echo e(__('Save Changes')); ?>

                                    </button>
                                </div>
                                <?php echo e(Form::close()); ?>

                            </div>
                        </div>
                        <div class="" id="domain-settings">
                            <div class="card">
                                <div class="card-header">
                                    <h5><?php echo e(__('Domain Settings')); ?></h5>

                                </div>
                                <?php echo e(Form::model($settings, ['route' => 'domain.settings', 'method' => 'post'])); ?>

                                <div class="card-body">
                                    <div class="d-flex">
                                        <?php if($plan->enable_custdomain == 'on' || $plan->enable_custsubdomain == 'on'): ?>
                                            <div class="radio-button-group mts mb-3">

                                                <input type="radio" class="btn-check domain_click"
                                                    name="custom_setting" id="enable_storelink-outlined"
                                                    autocomplete="off" value="enable_storelink" checked>
                                                <label class="btn btn-outline-primary"
                                                    for="enable_storelink-outlined"><?php echo e(__('Copy Link')); ?></label>

                                                <?php if($plan->enable_custdomain == 'on'): ?>
                                                    <input type="radio" class="btn-check domain_click"
                                                        name="custom_setting" id="enable_domain-outlined"
                                                        autocomplete="off" value="enable_domain">
                                                    <label class="btn btn-outline-primary" for="enable_domain-outlined">
                                                        <?php echo e(__('Domain')); ?></label>
                                                <?php endif; ?>
                                                <?php if($plan->enable_custsubdomain == 'on'): ?>
                                                    <input type="radio" class="btn-check domain_click"
                                                        name="custom_setting" id="enable_subdomain-outlined"
                                                        autocomplete="off" value="enable_subdomain">
                                                    <label class="btn btn-outline-primary"
                                                        for="enable_subdomain-outlined"><?php echo e(__('Sub Domain')); ?></label>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mt-4">
                                        <div class="form-group col-md-8 d-block" id="StoreLink">
                                            <?php echo e(Form::label('copy_link', __('Copy Link'), ['class' => 'form-label'])); ?>

                                            <div class="input-group">
                                                <input type="text" value="<?php echo e($store_settings['store_url']); ?>"
                                                    id="myInput" class="form-control d-inline-block"
                                                    aria-label="Recipient's username" aria-describedby="button-addon2"
                                                    readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary" type="button"
                                                        onclick="myFunction()" id="button-addon2"><i
                                                            class="far fa-copy"></i>
                                                        <?php echo e(__('Copy Link')); ?></button>
                                                </div>
                                            </div>
                                        </div>
                                        <?php if($plan->enable_custdomain == 'on' || $plan->enable_custsubdomain == 'on'): ?>
                                            <div class="row domain_div d-none">

                                                    <div class="form-group col-md-4">
                                                        <?php echo e(Form::label('domain_switch', __('Custom Domain'), ['class' => 'form-label'])); ?>

                                                        <div class="form-check form-switch custom-switch-v1 mt-1">
                                                            <input type="hidden" name="domain_switch"
                                                                value="off">
                                                            <input type="checkbox" class="form-check-input"
                                                                name="domain_switch" id="domain_switch"
                                                                <?php echo e(isset($settings['domain_switch']) && $settings['domain_switch'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                        </div>
                                                    </div>


                                                <div class="form-group col-md-8 <?php echo e($settings['domain_switch'] == 'on' ? ' ' : 'd-none'); ?>" id="domain">
                                                    <?php echo e(Form::label('domain', __('Custom Domain'), ['class' => 'form-label'])); ?>

                                                    <?php echo e(Form::text('domain', null, ['class' => 'form-control', 'placeholder' => __('xyz.com')])); ?>

                                                    <div class="text-sm mt-2 d-none" id="domainnote">
                                                        <?php echo e(__('Note : Before add custom domain, your domain A record is pointing to our server IP :')); ?><?php echo e($serverIp); ?>

                                                        <br>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group col-md-8 d-none" id="sundomain">
                                                <?php echo e(Form::label('subdomain', __('Sub Domain'), ['class' => 'form-label'])); ?>

                                                <div class="input-group">
                                                    <?php echo e(Form::text('subdomain', null, ['class' => 'form-control', 'placeholder' => __('Enter Domain')])); ?>


                                                    <div class="input-group-append">
                                                        <span class="input-group-text"
                                                            id="basic-addon2">.<?php echo e($subdomain_name); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <button class="btn-submit btn btn-primary" type="submit">
                                        <?php echo e(__('Save Changes')); ?>

                                    </button>
                                </div>
                                <?php echo e(Form::close()); ?>


                        </div>

                            <div class="" id="webhook-settings">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-lg-8 col-md-8 col-sm-8">
                                                <h5><?php echo e(__('Webhook Settings')); ?></h5>
                                                <small class="text-muted">Edit your webhook details</small>

                                            </div>
                                            <div class="col-lg-4 col-md-4 text-end">
                                                <div class="form-check custom-control custom-switch">
                                                    <a href="#" class="btn btn-sm btn-primary btn-icon"
                                                        title="<?php echo e(__('Create')); ?>" data-bs-toggle="tooltip"
                                                        data-bs-placement="top" data-ajax-popup="true"
                                                        data-title="<?php echo e(__('Create New Webhook')); ?>"
                                                        data-url="<?php echo e(route('webhook.create')); ?>"><i
                                                            class="ti ti-plus"></i></a>

                                                    <label class="custom-control-label form-label"
                                                        for="is_enabled"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-border-style">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead class="thead-light">
                                                    <tr class="col-md-6">
                                                        <th scope="col" class="sort" data-sort="module">
                                                            <?php echo e(__('Module')); ?></th>
                                                        <th scope="col" class="sort" data-sort="url">
                                                            <?php echo e(__('URL')); ?></th>
                                                        <th scope="col" class="sort" data-sort="method">
                                                            <?php echo e(__('Method')); ?></th>
                                                        <th scope="col" class="sort" data-sort="">
                                                            <?php echo e(__('Action')); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $webhooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $webhook): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        
                                                        <tr class="Action">
                                                            <td>
                                                                <label for="module"
                                                                    class="control-label text-decoration-none tag-lable-<?php echo e($webhook->id); ?>"><?php echo e($webhook->module); ?></label>
                                                            </td>
                                                            <td>
                                                                <label for="url"
                                                                    class="control-label text-decoration-none tag-lable-<?php echo e($webhook->id); ?>"><?php echo e($webhook->url); ?></label>
                                                            </td>
                                                            <td>
                                                                <label for="method"
                                                                    class="control-label text-decoration-none tag-lable-<?php echo e($webhook->id); ?>"><?php echo e($webhook->method); ?></label>
                                                            </td>
                                                            <td class="">
                                                                <div class="action-btn bg-info ms-2">
                                                                    <a class="mx-3 btn btn-sm  align-items-center"
                                                                        data-url="<?php echo e(route('webhook.edit', $webhook->id)); ?>"
                                                                        data-size="md" data-bs-toggle="tooltip"
                                                                        data-bs-original-title="<?php echo e(__('Edit')); ?>"
                                                                        data-bs-placement="top" data-ajax-popup="true"
                                                                        data-title="<?php echo e(__('Edit WebHook')); ?>"
                                                                        class="edit-icon"
                                                                        data-original-title="<?php echo e(__('Edit')); ?>"><i
                                                                            class="ti ti-pencil text-white"></i></a>
                                                                </div>
                                                                <div class="action-btn bg-danger ms-2">
                                                                    <?php echo Form::open(['method' => 'DELETE', 'route' => ['webhook.destroy', $webhook->id]]); ?>

                                                                    <a href="#!"
                                                                        class="mx-3 btn btn-sm align-items-center text-white show_confirm"
                                                                        data-bs-toggle="tooltip" title='Delete'>
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
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="payment-settings" class="card">
                            <div class="card-header">
                                <h5><?php echo e(__('Payment Settings')); ?></h5>
                                <small
                                    class="text-muted"><?php echo e(__('These details will be used to collect subscription plan payments.Each subscription plan will have a payment button based on the below configuration.')); ?></small>
                            </div>


                            <form method="post" action="<?php echo e(route('payment.settings')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">

                                                <?php
                                                    $payment = Utility::payment_settings();
                                                ?>

                                                <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                                    <label class="col-form-label"><?php echo e(__('Currency')); ?> *</label>
                                                    <input type="text" name="currency" class="form-control"
                                                        id="currency"
                                                        value="<?php echo e(!isset($payment['currency']) || is_null($payment['currency']) ? '' : $payment['currency']); ?>"
                                                        required>
                                                    <small class="text-xs">
                                                        <?php echo e(__('Note: Add currency code as per three-letter ISO code')); ?>.
                                                        <a href="https://stripe.com/docs/currencies"
                                                            target="_blank"><?php echo e(__('You can find out how to do that here.')); ?></a>
                                                    </small>
                                                </div>
                                                <div class="col-lg-6 col-md-6 col-sm-6 form-group">
                                                    <label for="currency_symbol"
                                                        class="col-form-label"><?php echo e(__('Currency Symbol')); ?> *</label>
                                                    <input type="text" name="currency_symbol" class="form-control"
                                                        id="currency_symbol"
                                                        value="<?php echo e(!isset($payment['currency_symbol']) || is_null($payment['currency_symbol']) ? '' : $payment['currency_symbol']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="faq justify-content-center">
                                        <div class="col-sm-12 col-md-10 col-xxl-12">
                                            <div class="accordion accordion-flush setting-accordion"
                                                id="accordionExample">

                                                <!-- Manually -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-2">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#manually"
                                                            aria-expanded="true" aria-controls="manually">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Manually')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div class="form-check form-switch d-inline-block custom-switch-v1"
                                                                    style="">
                                                                    <input type="hidden" name="is_manually_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_manually_enabled"
                                                                        id="is_manually_enabled"
                                                                        <?php echo e(isset($payment['is_manually_enabled']) && $payment['is_manually_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="manually" class="accordion-collapse collapse">
                                                        <div class="accordion-body">
                                                            <p>Requesting Manual Payment For The Planned Amount For The
                                                                Subscriptions Plan.</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Bank Transfer -->

                                                <div class="accordion-item card">

                                                    <h2 class="accordion-header" id="heading-2-2">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#banktransfer"
                                                            aria-expanded="true" aria-controls="banktransfer">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Banktransfer')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div class="form-check form-switch d-inline-block custom-switch-v1"
                                                                    style="">
                                                                    <input type="hidden" name="is_banktransfer_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_banktransfer_enabled"
                                                                        id="is_banktransfer_enabled"
                                                                        <?php echo e(isset($payment['is_banktransfer_enabled']) && $payment['is_banktransfer_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="banktransfer" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-2"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row gy-4">
                                                                <div class="col-md-12 mt-3">
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('inputname', 'Bank Details', ['class' => 'col-form-label']); ?>

                                                                        <?php
                                                                            $bank_details = !empty(
                                                                                $payment['bank_details']
                                                                            )
                                                                                ? $payment['bank_details']
                                                                                : '';
                                                                        ?>
                                                                        <?php echo Form::textarea('bank_details', $bank_details, [
                                                                            'class' => 'form-control',
                                                                            'rows' => '6',
                                                                        ]); ?>

                                                                        <small class="text-xs">
                                                                            <?php echo e(__('Example : Bank : Bank Name <br> Account Number : 0000 0000 <br>')); ?>.
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Strip -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-2">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse1"
                                                            aria-expanded="true" aria-controls="collapse1">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Stripe')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div class="form-check form-switch d-inline-block custom-switch-v1"
                                                                    style="">

                                                                    <input type="hidden" name="is_stripe_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_stripe_enabled" id="is_stripe_enabled"
                                                                        <?php echo e(isset($payment['is_stripe_enabled']) && $payment['is_stripe_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>

                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse1" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-2"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="stripe_key"
                                                                            class="form-label"><?php echo e(__('Stripe Key')); ?></label>
                                                                        <input class="form-control"
                                                                            placeholder="<?php echo e(__('Stripe Key')); ?>"
                                                                            name="stripe_key" type="text"
                                                                            value="<?php echo e(!isset($payment['stripe_key']) || is_null($payment['stripe_key']) ? '' : $payment['stripe_key']); ?>"
                                                                            id="stripe_key">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="stripe_secret"
                                                                            class="form-label"><?php echo e(__('Stripe Secret')); ?></label>
                                                                        <input class="form-control "
                                                                            placeholder="<?php echo e(__('Stripe Secret')); ?>"
                                                                            name="stripe_secret" type="text"
                                                                            value="<?php echo e(!isset($payment['stripe_secret']) || is_null($payment['stripe_secret']) ? '' : $payment['stripe_secret']); ?>"
                                                                            id="stripe_secret">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Paypal -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-3">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse2"
                                                            aria-expanded="false" aria-controls="collapse2">
                                                            <span class="d-flex align-items-center">
                                                                <?php echo e(__('Paypal')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1"mt-1>
                                                                    <input type="hidden" name="is_paypal_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_paypal_enabled" id="is_paypal_enabled"
                                                                        <?php echo e(isset($payment['is_paypal_enabled']) && $payment['is_paypal_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>

                                                    </h2>
                                                    <div id="collapse2" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">

                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                    <div class="row pt-2">
                                                                        <label class="pb-2"
                                                                            for="paypal_mode"><?php echo e(__('Paypal Mode')); ?></label>
                                                                        <br>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2"
                                                                                style="margin-right: 15px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="paypal_mode"
                                                                                                value="sandbox"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(!isset($payment['paypal_mode']) || $payment['paypal_mode'] == '' || $payment['paypal_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Sandbox')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="paypal_mode"
                                                                                                value="live"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(isset($payment['paypal_mode']) && $payment['paypal_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Live')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="paypal_client_id"
                                                                            class="form-label"><?php echo e(__('Client ID')); ?></label>
                                                                        <input type="text" name="paypal_client_id"
                                                                            id="paypal_client_id" class="form-control"
                                                                            value="<?php echo e(!isset($payment['paypal_client_id']) || is_null($payment['paypal_client_id']) ? '' : $payment['paypal_client_id']); ?>"
                                                                            placeholder="<?php echo e(__('Client ID')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="paypal_secret_key"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text" name="paypal_secret_key"
                                                                            id="paypal_secret_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['paypal_secret_key']) || is_null($payment['paypal_secret_key']) ? '' : $payment['paypal_secret_key']); ?>"
                                                                            placeholder="<?php echo e(__('Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Paystack -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-4">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse3"
                                                            aria-expanded="true" aria-controls="collapse3">
                                                            <span class="d-flex align-items-center">
                                                                <?php echo e(__('Paystack')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_paystack_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_paystack_enabled"
                                                                        id="is_paystack_enabled"
                                                                        <?php echo e(isset($payment['is_paystack_enabled']) && $payment['is_paystack_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse3" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-4"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">


                                                            <div class="row">


                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="paypal_client_id"
                                                                            class="form-label"><?php echo e(__('Public Key')); ?></label>
                                                                        <input type="text" name="paystack_public_key"
                                                                            id="paystack_public_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['paystack_public_key']) || is_null($payment['paystack_public_key']) ? '' : $payment['paystack_public_key']); ?>"
                                                                            placeholder="<?php echo e(__('Public Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="paystack_secret_key"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text" name="paystack_secret_key"
                                                                            id="paystack_secret_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['paystack_secret_key']) || is_null($payment['paystack_secret_key']) ? '' : $payment['paystack_secret_key']); ?>"
                                                                            placeholder="<?php echo e(__('Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- FLUTTERWAVE -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-5">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse4"
                                                            aria-expanded="true" aria-controls="collapse4">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Flutterwave')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_flutterwave_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_flutterwave_enabled"
                                                                        id="is_flutterwave_enabled"
                                                                        <?php echo e(isset($payment['is_flutterwave_enabled']) && $payment['is_flutterwave_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>

                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse4" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-5"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">

                                                            <div class="row">

                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="paypal_client_id"
                                                                            class="form-label"><?php echo e(__('Public Key')); ?></label>
                                                                        <input type="text"
                                                                            name="flutterwave_public_key"
                                                                            id="flutterwave_public_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['flutterwave_public_key']) || is_null($payment['flutterwave_public_key']) ? '' : $payment['flutterwave_public_key']); ?>"
                                                                            placeholder="Public Key">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="paystack_secret_key"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text"
                                                                            name="flutterwave_secret_key"
                                                                            id="flutterwave_secret_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['flutterwave_secret_key']) || is_null($payment['flutterwave_secret_key']) ? '' : $payment['flutterwave_secret_key']); ?>"
                                                                            placeholder="Secret Key">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Razorpay -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-6">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse5"
                                                            aria-expanded="true" aria-controls="collapse5">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Razorpay')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_razorpay_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_razorpay_enabled"
                                                                        id="is_razorpay_enabled"
                                                                        <?php echo e(isset($payment['is_razorpay_enabled']) && $payment['is_razorpay_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse5" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-6"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">


                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="paypal_client_id"
                                                                            class="form-label"><?php echo e(__('Public Key')); ?></label>

                                                                        <input type="text" name="razorpay_public_key"
                                                                            id="razorpay_public_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['razorpay_public_key']) || is_null($payment['razorpay_public_key']) ? '' : $payment['razorpay_public_key']); ?>"
                                                                            placeholder="Public Key">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="paystack_secret_key"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text" name="razorpay_secret_key"
                                                                            id="razorpay_secret_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['razorpay_secret_key']) || is_null($payment['razorpay_secret_key']) ? '' : $payment['razorpay_secret_key']); ?>"
                                                                            placeholder="Secret Key">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Paytm -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-7">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse6"
                                                            aria-expanded="true" aria-controls="collapse6">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Paytm')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_paytm_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_paytm_enabled" id="is_paytm_enabled"
                                                                        <?php echo e(isset($payment['is_paytm_enabled']) && $payment['is_paytm_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse6" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-7"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">


                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                    <div class="row pt-2">
                                                                        <label class="pb-2"
                                                                            for="paypal_mode"><?php echo e(__('Paytm Environment')); ?></label>
                                                                        <br>

                                                                        <div class="d-flex">
                                                                            <div class="mr-2"
                                                                                style="margin-right: 15px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="paytm_mode"
                                                                                                value="local"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(!isset($payment['paytm_mode']) || $payment['paytm_mode'] == '' || $payment['paytm_mode'] == 'local' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('local')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="paytm_mode"
                                                                                                value="production"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(isset($payment['paytm_mode']) && $payment['paytm_mode'] == 'production' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Production')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="paytm_public_key"
                                                                            class="form-label"><?php echo e(__('Merchant ID')); ?></label>
                                                                        <input type="text" name="paytm_merchant_id"
                                                                            id="paytm_merchant_id" class="form-control"
                                                                            value="<?php echo e(!isset($payment['paytm_merchant_id']) || is_null($payment['paytm_merchant_id']) ? '' : $payment['paytm_merchant_id']); ?>"
                                                                            placeholder="Merchant ID">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="paytm_secret_key"
                                                                            class="form-label"><?php echo e(__('Merchant Key')); ?></label>
                                                                        <input type="text" name="paytm_merchant_key"
                                                                            id="paytm_merchant_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['paytm_merchant_key']) || is_null($payment['paytm_merchant_key']) ? '' : $payment['paytm_merchant_key']); ?>"
                                                                            placeholder="Merchant Key">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="paytm_industry_type"
                                                                            class="form-label"><?php echo e(__('Industry Type')); ?></label>
                                                                        <input type="text" name="paytm_industry_type"
                                                                            id="paytm_industry_type"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['paytm_industry_type']) || is_null($payment['paytm_industry_type']) ? '' : $payment['paytm_industry_type']); ?>"
                                                                            placeholder="Industry Type">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Mercado Pago-->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-8">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse7"
                                                            aria-expanded="true" aria-controls="collapse7">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Mercado Pago')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_mercado_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_mercado_enabled"
                                                                        id="is_mercado_enabled"
                                                                        <?php echo e(isset($payment['is_mercado_enabled']) && $payment['is_mercado_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse7" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-8"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">

                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                    <div class="row pt-2">
                                                                        <label class="pb-2"
                                                                            for="paypal_mode"><?php echo e(__('Mercado Mode')); ?></label>
                                                                        <br>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2"
                                                                                style="margin-right: 15px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="mercado_mode"
                                                                                                value="sandbox"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(!isset($payment['mercado_mode']) || $payment['mercado_mode'] == '' || $payment['mercado_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>

                                                                                            <?php echo e(__('Sandbox')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="mercado_mode"
                                                                                                value="live"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(isset($payment['mercado_mode']) && $payment['mercado_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Live')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="mercado_access_token"
                                                                            class="form-label"><?php echo e(__('Access Token')); ?></label>
                                                                        <input type="text"
                                                                            name="mercado_access_token"
                                                                            id="mercado_access_token"
                                                                            class="form-control"
                                                                            value="<?php echo e(isset($payment['mercado_access_token']) ? $payment['mercado_access_token'] : ''); ?>" />
                                                                        <?php if($errors->has('mercado_secret_key')): ?>
                                                                            <span class="invalid-feedback d-block">
                                                                                <?php echo e($errors->first('mercado_access_token')); ?>

                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Mollie -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-9">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse8"
                                                            aria-expanded="true" aria-controls="collapse8">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Mollie')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_mollie_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_mollie_enabled" id="is_mollie_enabled"
                                                                        <?php echo e(isset($payment['is_mollie_enabled']) && $payment['is_mollie_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse8" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-9"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">

                                                                <div class="row mt-2">
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="mollie_api_key"
                                                                                class="form-label"><?php echo e(__('Mollie Api Key')); ?></label>
                                                                            <input type="text" name="mollie_api_key"
                                                                                id="mollie_api_key" class="form-control"
                                                                                value="<?php echo e(!isset($payment['mollie_api_key']) || is_null($payment['mollie_api_key']) ? '' : $payment['mollie_api_key']); ?>"
                                                                                placeholder="Mollie Api Key">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="mollie_profile_id"
                                                                                class="form-label"><?php echo e(__('Mollie Profile Id')); ?></label>
                                                                            <input type="text"
                                                                                name="mollie_profile_id"
                                                                                id="mollie_profile_id"
                                                                                class="form-control"
                                                                                value="<?php echo e(!isset($payment['mollie_profile_id']) || is_null($payment['mollie_profile_id']) ? '' : $payment['mollie_profile_id']); ?>"
                                                                                placeholder="Mollie Profile Id">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <div class="form-group">
                                                                            <label for="mollie_partner_id"
                                                                                class="form-label"><?php echo e(__('Mollie Partner Id')); ?></label>
                                                                            <input type="text"
                                                                                name="mollie_partner_id"
                                                                                id="mollie_partner_id"
                                                                                class="form-control"
                                                                                value="<?php echo e(!isset($payment['mollie_partner_id']) || is_null($payment['mollie_partner_id']) ? '' : $payment['mollie_partner_id']); ?>"
                                                                                placeholder="Mollie Partner Id">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Skrill -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-10">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse9"
                                                            aria-expanded="true" aria-controls="collapse9">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Skrill')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_skrill_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_skrill_enabled" id="is_skrill_enabled"
                                                                        <?php echo e(isset($payment['is_skrill_enabled']) && $payment['is_skrill_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse9" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-10"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">

                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="mollie_api_key"
                                                                            class="form-label"><?php echo e(__('Skrill Email')); ?></label>
                                                                        <input type="text" name="skrill_email"
                                                                            id="skrill_email" class="form-control"
                                                                            value="<?php echo e(!isset($payment['skrill_email']) || is_null($payment['skrill_email']) ? '' : $payment['skrill_email']); ?>"
                                                                            placeholder="Enter Skrill Email">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- CoinGate -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-11">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse10"
                                                            aria-expanded="true" aria-controls="collapse10">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('CoinGate')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>
                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_coingate_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_coingate_enabled"
                                                                        id="is_coingate_enabled"
                                                                        <?php echo e(isset($payment['is_coingate_enabled']) && $payment['is_coingate_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse10" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-11"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">



                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                    <div class="row pt-2">
                                                                        <label class="pb-2"
                                                                            for="paypal_mode"><?php echo e(__('CoinGate Mode')); ?></label>
                                                                        <br>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2"
                                                                                style="margin-right: 15px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="coingate_mode"
                                                                                                value="sandbox"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(!isset($payment['coingate_mode']) || $payment['coingate_mode'] == '' || $payment['coingate_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Sandbox')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="coingate_mode"
                                                                                                value="live"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(isset($payment['coingate_mode']) && $payment['coingate_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Live')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="coingate_auth_token"
                                                                            class="form-label"><?php echo e(__('CoinGate Auth Token')); ?></label>
                                                                        <input type="text" name="coingate_auth_token"
                                                                            id="coingate_auth_token"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['coingate_auth_token']) || is_null($payment['coingate_auth_token']) ? '' : $payment['coingate_auth_token']); ?>"
                                                                            placeholder="CoinGate Auth Token">
                                                                    </div>
                                                                    <?php if($errors->has('coingate_auth_token')): ?>
                                                                        <span class="invalid-feedback d-block">
                                                                            <?php echo e($errors->first('coingate_auth_token')); ?>

                                                                        </span>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- PaymentWall -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse11"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('PaymentWall')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>

                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_paymentwall_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_paymentwall_enabled"
                                                                        id="is_paymentwall_enabled"
                                                                        <?php echo e(isset($payment['is_paymentwall_enabled']) && $payment['is_paymentwall_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>

                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse11" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-12"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">


                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="paymentwall_public_key"
                                                                            class="form-label"><?php echo e(__('Public Key')); ?></label>
                                                                        <input type="text"
                                                                            name="paymentwall_public_key"
                                                                            id="paymentwall_public_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['paymentwall_public_key']) || is_null($payment['paymentwall_public_key']) ? '' : $payment['paymentwall_public_key']); ?>"
                                                                            placeholder="<?php echo e(__('Public Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="paymentwall_private_key"
                                                                            class="form-label"><?php echo e(__('Private Key')); ?></label>
                                                                        <input type="text"
                                                                            name="paymentwall_private_key"
                                                                            id="paymentwall_private_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['paymentwall_private_key']) || is_null($payment['paymentwall_private_key']) ? '' : $payment['paymentwall_private_key']); ?>"
                                                                            placeholder="<?php echo e(__('Private Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Toyyibpay -->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse12"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Toyyibpay')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable : ')); ?></span>

                                                                <div
                                                                    class="form-check form-switch d-inline-block custom-switch-v1">
                                                                    <input type="hidden" name="is_toyyibpay_enabled"
                                                                        value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_toyyibpay_enabled"
                                                                        id="is_toyyibpay_enabled"
                                                                        <?php echo e(isset($payment['is_toyyibpay_enabled']) && $payment['is_toyyibpay_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>

                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse12" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-12"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="toyyibpay_secret_key"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text"
                                                                            name="toyyibpay_secret_key"
                                                                            id="toyyibpay_secret_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['toyyibpay_secret_key']) || is_null($payment['toyyibpay_secret_key']) ? '' : $payment['toyyibpay_secret_key']); ?>"
                                                                            placeholder="<?php echo e(__('Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="toyyibpay_category_code"
                                                                            class="form-label"><?php echo e(__('Category Code')); ?></label>
                                                                        <input type="text"
                                                                            name="toyyibpay_category_code"
                                                                            id="toyyibpay_category_code"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['toyyibpay_category_code']) || is_null($payment['toyyibpay_category_code']) ? '' : $payment['toyyibpay_category_code']); ?>"
                                                                            placeholder="<?php echo e(__('Category Code')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse13"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Payfast')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_payfast_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_payfast_enabled"
                                                                        id="is_payfast_enabled"
                                                                        <?php echo e(isset($payment['is_payfast_enabled']) && $payment['is_payfast_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_payfast_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse13" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                    <div class="row pt-2">
                                                                        <label class="pb-2"
                                                                            for="payfast_mode"><?php echo e(__('Payfast Mode')); ?></label>
                                                                        <br>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2"
                                                                                style="margin-right: 15px; width: 190px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="payfast_mode"
                                                                                                value="sandbox"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(!isset($payment['payfast_mode']) || $payment['payfast_mode'] == '' || $payment['payfast_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Sandbox')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2" style="width: 190px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="payfast_mode"
                                                                                                value="live"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(isset($payment['payfast_mode']) && $payment['payfast_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Live')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="payfast_public_key"
                                                                            class="form-label"><?php echo e(__('Merchant ID')); ?></label>
                                                                        <input type="text" name="payfast_merchant_id"
                                                                            id="payfast_merchant_id"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['payfast_merchant_id']) || is_null($payment['payfast_merchant_id']) ? '' : $payment['payfast_merchant_id']); ?>"
                                                                            placeholder="Merchant ID">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="payfast_secret_key"
                                                                            class="form-label"><?php echo e(__('Merchant Key')); ?></label>
                                                                        <input type="text"
                                                                            name="payfast_merchant_key"
                                                                            id="payfast_merchant_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['payfast_merchant_key']) || is_null($payment['payfast_merchant_key']) ? '' : $payment['payfast_merchant_key']); ?>"
                                                                            placeholder="Merchant Key">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="payfast_signature"
                                                                            class="form-label"><?php echo e(__('Salt Passphrase')); ?></label>
                                                                        <input type="text" name="payfast_signature"
                                                                            id="payfast_signature" class="form-control"
                                                                            value="<?php echo e(!isset($payment['payfast_signature']) || is_null($payment['payfast_signature']) ? '' : $payment['payfast_signature']); ?>"
                                                                            placeholder="Salt Passphrase">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse14"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Iyzipay')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_iyzipay_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_iyzipay_enabled"
                                                                        id="is_iyzipay_enabled"
                                                                        <?php echo e(isset($payment['is_iyzipay_enabled']) && $payment['is_iyzipay_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_iyzipay_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse14" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                    <div class="row pt-2">
                                                                        <label class="pb-2"
                                                                            for="iyzipay_mode"><?php echo e(__('Iyzipay Mode')); ?></label>
                                                                        <br>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2"
                                                                                style="margin-right: 15px; width: 190px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="iyzipay_mode"
                                                                                                value="sandbox"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(!isset($payment['iyzipay_mode']) || $payment['iyzipay_mode'] == '' || $payment['iyzipay_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Sandbox')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2" style="width: 190px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="iyzipay_mode"
                                                                                                value="live"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(isset($payment['iyzipay_mode']) && $payment['iyzipay_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Live')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="iyzipay_key"
                                                                            class="form-label"><?php echo e(__('Iyzipay Key')); ?></label>
                                                                        <input type="text" name="iyzipay_key"
                                                                            id="iyzipay_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['iyzipay_key']) || is_null($payment['iyzipay_key']) ? '' : $payment['iyzipay_key']); ?>"
                                                                            placeholder="Iyzipay Key">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="iyzipay_secret"
                                                                            class="form-label"><?php echo e(__('Iyzipay Secret')); ?></label>
                                                                        <input class="form-control "
                                                                            placeholder="<?php echo e(__('Iyzipay Secret')); ?>"
                                                                            name="iyzipay_secret" type="text"
                                                                            value="<?php echo e(!isset($payment['iyzipay_secret']) || is_null($payment['iyzipay_secret']) ? '' : $payment['iyzipay_secret']); ?>"
                                                                            id="iyzipay_secret">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse15"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('SsPay')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_sspay_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_sspay_enabled" id="is_sspay_enabled"
                                                                        <?php echo e(isset($payment['is_sspay_enabled']) && $payment['is_sspay_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_sspay_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse15" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">


                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="sspay_category_code"
                                                                            class="form-label"><?php echo e(__('Sspay Category Code')); ?></label>
                                                                        <input type="text" name="sspay_category_code"
                                                                            id="sspay_category_code"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['sspay_category_code']) || is_null($payment['sspay_category_code']) ? '' : $payment['sspay_category_code']); ?>"
                                                                            placeholder="<?php echo e(__('Category Code')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="sspay_secret_key"
                                                                            class="form-label"><?php echo e(__('Sspay Secret')); ?></label>
                                                                        <input type="text" name="sspay_secret_key"
                                                                            id="sspay_secret_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['sspay_secret_key']) || is_null($payment['sspay_secret_key']) ? '' : $payment['sspay_secret_key']); ?>"
                                                                            placeholder="<?php echo e(__('Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                

                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse16"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Paytab')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_paytab_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_paytab_enabled" id="is_paytab_enabled"
                                                                        <?php echo e(isset($payment['is_paytab_enabled']) && $payment['is_paytab_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paytab_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse16" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="paytab_profile_id"
                                                                            class="form-label"><?php echo e(__('Profile Id')); ?></label>
                                                                        <input type="text" name="paytab_profile_id"
                                                                            id="paytab_profile_id" class="form-control"
                                                                            value="<?php echo e(!isset($payment['paytab_profile_id']) || is_null($payment['paytab_profile_id']) ? '' : $payment['paytab_profile_id']); ?>"
                                                                            placeholder="<?php echo e(__('Profile Id')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="paytab_server_key"
                                                                            class="form-label"><?php echo e(__('Server Key')); ?></label>
                                                                        <input type="text" name="paytab_server_key"
                                                                            id="paytab_server_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['paytab_server_key']) || is_null($payment['paytab_server_key']) ? '' : $payment['paytab_server_key']); ?>"
                                                                            placeholder="<?php echo e(__('Server Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="paytab_region"
                                                                            class="form-label"><?php echo e(__('Region')); ?></label>
                                                                        <input type="text" name="paytab_region"
                                                                            id="paytab_region" class="form-control"
                                                                            value="<?php echo e(!isset($payment['paytab_region']) || is_null($payment['paytab_region']) ? '' : $payment['paytab_region']); ?>"
                                                                            placeholder="<?php echo e(__('Region')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse17"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Benefit')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_benefit_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_benefit_enabled"
                                                                        id="is_benefit_enabled"
                                                                        <?php echo e(isset($payment['is_benefit_enabled']) && $payment['is_benefit_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_benefit_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>

                                                    <div id="collapse17" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="benefit_api_key"
                                                                            class="form-label"><?php echo e(__('Benefit Key')); ?></label>
                                                                        <input type="text" name="benefit_api_key"
                                                                            id="benefit_api_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['benefit_api_key']) || is_null($payment['benefit_api_key']) ? '' : $payment['benefit_api_key']); ?>"
                                                                            placeholder="<?php echo e(__('Benefit Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="benefit_secret_key"
                                                                            class="form-label"><?php echo e(__('Benefit Secret Key')); ?></label>
                                                                        <input type="text" name="benefit_secret_key"
                                                                            id="benefit_secret_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['benefit_secret_key']) || is_null($payment['benefit_secret_key']) ? '' : $payment['benefit_secret_key']); ?>"
                                                                            placeholder="<?php echo e(__('Benefit Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                

                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse18"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('CasheFree')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_cashefree_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_cashefree_enabled"
                                                                        id="is_cashefree_enabled"
                                                                        <?php echo e(isset($payment['is_cashefree_enabled']) && $payment['is_cashefree_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_cashefree_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse18" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="cashfree_key"
                                                                            class="form-label"><?php echo e(__('Cashfree Key')); ?></label>
                                                                        <input type="text" name="cashfree_key"
                                                                            id="cashfree_key" class="form-control"
                                                                            value="<?php echo e(!isset($payment['cashfree_key']) || is_null($payment['cashfree_key']) ? '' : $payment['cashfree_key']); ?>"
                                                                            placeholder="<?php echo e(__('Cashfree Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="cashfree_secret"
                                                                            class="form-label"><?php echo e(__('Cashfree Secret Key')); ?></label>
                                                                        <input type="text" name="cashfree_secret"
                                                                            id="cashfree_secret" class="form-control"
                                                                            value="<?php echo e(!isset($payment['cashfree_secret']) || is_null($payment['cashfree_secret']) ? '' : $payment['cashfree_secret']); ?>"
                                                                            placeholder="<?php echo e(__('Cashfree Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse20"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Aamarpay')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_aamarpay_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_aamarpay_enabled"
                                                                        id="is_aamarpay_enabled"
                                                                        <?php echo e(isset($payment['is_aamarpay_enabled']) && $payment['is_aamarpay_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_aamarpay_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse20" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="aamarpay_store_id"
                                                                            class="form-label"><?php echo e(__('Store Id')); ?></label>
                                                                        <input type="text" name="aamarpay_store_id"
                                                                            id="aamarpay_store_id" class="form-control"
                                                                            value="<?php echo e(!isset($payment['aamarpay_store_id']) || is_null($payment['aamarpay_store_id']) ? '' : $payment['aamarpay_store_id']); ?>"
                                                                            placeholder="<?php echo e(__('Store Id')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="aamarpay_signature_key"
                                                                            class="form-label"><?php echo e(__('Signature Key')); ?></label>
                                                                        <input type="text"
                                                                            name="aamarpay_signature_key"
                                                                            id="aamarpay_signature_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['aamarpay_signature_key']) || is_null($payment['aamarpay_signature_key']) ? '' : $payment['aamarpay_signature_key']); ?>"
                                                                            placeholder="<?php echo e(__('Signature Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="aamarpay_description"
                                                                            class="form-label"><?php echo e(__('Description')); ?></label>
                                                                        <input type="text"
                                                                            name="aamarpay_description"
                                                                            id="aamarpay_description"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['aamarpay_description']) || is_null($payment['aamarpay_description']) ? '' : $payment['aamarpay_description']); ?>"
                                                                            placeholder="<?php echo e(__('Description')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-12">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse21"
                                                            aria-expanded="true" aria-controls="collapse11">
                                                            <span class="d-flex align-items-center">

                                                                <?php echo e(__('Pay TR')); ?>

                                                            </span>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?>:</span>
                                                                <div class=" form-check form-switch custom-switch-v1">
                                                                    <input type="hidden"
                                                                        name="is_paytr_enabled"value="off">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_paytr_enabled" id="is_paytr_enabled"
                                                                        <?php echo e(isset($payment['is_paytr_enabled']) && $payment['is_paytr_enabled'] == 'on' ? 'checked' : ''); ?>>
                                                                    <label class="custom-control-label form-control-label"
                                                                        for="is_paytr_enabled"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse21" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-3"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <?php echo e(Form::label('paytr_merchant_id', __('Merchant Id'), ['class' => 'form-label'])); ?>

                                                                        <?php echo e(Form::text('paytr_merchant_id', isset($payment['paytr_merchant_id']) ? $payment['paytr_merchant_id'] : '', ['class' => 'form-control', 'placeholder' => __('Merchant Id')])); ?><br>
                                                                        <?php if($errors->has('paytr_merchant_id')): ?>
                                                                            <span class="invalid-feedback d-block">
                                                                                <?php echo e($errors->first('paytr_merchant_id')); ?>

                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <?php echo e(Form::label('paytr_merchant_key', __('Merchant Key'), ['class' => 'form-label'])); ?>

                                                                        <?php echo e(Form::text('paytr_merchant_key', isset($payment['paytr_merchant_key']) ? $payment['paytr_merchant_key'] : '', ['class' => 'form-control', 'placeholder' => __('Merchant Key')])); ?><br>
                                                                        <?php if($errors->has('paytr_merchant_key')): ?>
                                                                            <span class="invalid-feedback d-block">
                                                                                <?php echo e($errors->first('paytr_merchant_key')); ?>

                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <?php echo e(Form::label('paytr_merchant_salt', __('Merchant Salt'), ['class' => 'form-label'])); ?>

                                                                        <?php echo e(Form::text('paytr_merchant_salt', isset($payment['paytr_merchant_salt']) ? $payment['paytr_merchant_salt'] : '', ['class' => 'form-control', 'placeholder' => __('Merchant Salt')])); ?><br>
                                                                        <?php if($errors->has('paytr_merchant_salt')): ?>
                                                                            <span class="invalid-feedback d-block">
                                                                                <?php echo e($errors->first('paytr_merchant_salt')); ?>

                                                                            </span>
                                                                        <?php endif; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-22">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse22"
                                                            aria-expanded="true" aria-controls="collapse22">
                                                            <span class="d-flex align-items-center">
                                                                <?php echo e(__('Yookassa')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_yookassa_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_yookassa_enabled"
                                                                        id="is_yookassa_enabled"
                                                                        <?php echo e(isset($payment['is_yookassa_enabled']) && $payment['is_yookassa_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="customswitchv1-2"></label>
                                                                </div>
                                                            </div>

                                                        </button>
                                                    </h2>

                                                    <div id="collapse22"
                                                        class="accordion-collapse collapse"aria-labelledby="heading-2-22"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="yookassa_shop_id"
                                                                            class="form-label"><?php echo e(__('Shop ID Key')); ?></label>
                                                                        <input type="text" name="yookassa_shop_id"
                                                                            id="yookassa_shop_id" class="form-control"
                                                                            value="<?php echo e(!isset($payment['yookassa_shop_id']) || is_null($payment['yookassa_shop_id']) ? '' : $payment['yookassa_shop_id']); ?>"
                                                                            placeholder="<?php echo e(__('Shop ID Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="yookassa_secret"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text" name="yookassa_secret"
                                                                            id="yookassa_secret" class="form-control"
                                                                            value="<?php echo e(!isset($payment['yookassa_secret']) || is_null($payment['yookassa_secret']) ? '' : $payment['yookassa_secret']); ?>"
                                                                            placeholder="<?php echo e(__('Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-23">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse23"
                                                            aria-expanded="true" aria-controls="collapse23">
                                                            <span class="d-flex align-items-center">
                                                                <?php echo e(__('Midtrans')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_midtrans_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_midtrans_enabled"
                                                                        id="is_midtrans_enabled"
                                                                        <?php echo e(isset($payment['is_midtrans_enabled']) && $payment['is_midtrans_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="customswitchv1-2"></label>
                                                                </div>
                                                            </div>

                                                        </button>
                                                    </h2>

                                                    <div id="collapse23"
                                                        class="accordion-collapse collapse"aria-labelledby="heading-2-23"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pb-4">
                                                                    <div class="row pt-2">
                                                                        <label class="pb-2"
                                                                            for="midtrans_mode"><?php echo e(__('Midtrans Mode')); ?></label>
                                                                        <br>
                                                                        <div class="d-flex">
                                                                            <div class="mr-2"
                                                                                style="margin-right: 15px; width: 190px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="midtrans_mode"
                                                                                                value="sandbox"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(!isset($payment['midtrans_mode']) || $payment['midtrans_mode'] == '' || $payment['midtrans_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Sandbox')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="mr-2" style="width: 190px;">
                                                                                <div class="border card p-3">
                                                                                    <div class="form-check">
                                                                                        <label
                                                                                            class="form-check-labe text-dark">
                                                                                            <input type="radio"
                                                                                                name="midtrans_mode"
                                                                                                value="live"
                                                                                                class="form-check-input"
                                                                                                <?php echo e(isset($payment['midtrans_mode']) && $payment['midtrans_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                            <?php echo e(__('Live')); ?>

                                                                                        </label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="midtrans_secret"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text" name="midtrans_secret"
                                                                            id="midtrans_secret" class="form-control"
                                                                            value="<?php echo e(!isset($payment['midtrans_secret']) || is_null($payment['midtrans_secret']) ? '' : $payment['midtrans_secret']); ?>"
                                                                            placeholder="<?php echo e(__('Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-24">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse24"
                                                            aria-expanded="true" aria-controls="collapse24">
                                                            <span class="d-flex align-items-center">
                                                                <?php echo e(__('Xendit')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_xendit_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_xendit_enabled" id="is_xendit_enabled"
                                                                        <?php echo e(isset($payment['is_xendit_enabled']) && $payment['is_xendit_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="customswitchv1-2"></label>
                                                                </div>
                                                            </div>

                                                        </button>
                                                    </h2>

                                                    <div id="collapse24"
                                                        class="accordion-collapse collapse"aria-labelledby="heading-2-24"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">

                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="xendit_api"
                                                                            class="form-label"><?php echo e(__('API Key')); ?></label>
                                                                        <input type="text" name="xendit_api"
                                                                            id="xendit_api" class="form-control"
                                                                            value="<?php echo e(!isset($payment['xendit_api']) || is_null($payment['xendit_api']) ? '' : $payment['xendit_api']); ?>"
                                                                            placeholder="<?php echo e(__('API Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="xendit_token"
                                                                            class="form-label"><?php echo e(__('Token')); ?></label>
                                                                        <input type="text" name="xendit_token"
                                                                            id="xendit_token" class="form-control"
                                                                            value="<?php echo e(!isset($payment['xendit_token']) || is_null($payment['xendit_token']) ? '' : $payment['xendit_token']); ?>"
                                                                            placeholder="<?php echo e(__('Token')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Paiement Pro-->
                                                <div class="accordion-item card">
                                                        <h2 class="accordion-header" id="heading-2-25">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapse25"
                                                                aria-expanded="true" aria-controls="collapse25">
                                                                <span class="d-flex align-items-center">
                                                                    <?php echo e(__('Paiement Pro')); ?>

                                                                </span>

                                                                <div class="d-flex align-items-center">
                                                                    <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                    <div class="form-check form-switch custom-switch-v1">
                                                                        <input type="hidden" name="is_paiementpro_enabled"
                                                                            value="off">
                                                                        <input type="checkbox"
                                                                            class="form-check-input input-primary"
                                                                            name="is_paiementpro_enabled"
                                                                            id="is_paiementpro_enabled"
                                                                            <?php echo e(isset($payment['is_paiementpro_enabled']) && $payment['is_paiementpro_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                        <label class="form-check-label"
                                                                            for="customswitchv1-2"></label>
                                                                    </div>
                                                                </div>
                                                            </button>
                                                        </h2>

                                                        <div id="collapse25"
                                                            class="accordion-collapse collapse"aria-labelledby="heading-2-25"
                                                            data-bs-parent="#accordionExample">
                                                            <div class="accordion-body">
                                                                <div class="row">
                                                                    <div class="col-12 py-2">
                                                                        <small><?php echo e(__('Note: This detail will use for make checkout of plan.')); ?></small>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="form-group">
                                                                            <label for="paiementpro_merchant_id"
                                                                                class="form-label"><?php echo e(__('Merchant Id')); ?></label>
                                                                            <input type="text"
                                                                                name="paiementpro_merchant_id"
                                                                                id="paiementpro_merchant_id"
                                                                                class="form-control"
                                                                                value="<?php echo e(!isset($payment['paiementpro_merchant_id']) || is_null($payment['paiementpro_merchant_id']) ? '' : $payment['paiementpro_merchant_id']); ?>"
                                                                                placeholder="<?php echo e(__('Merchant Id')); ?>">
                                                                            <?php if($errors->has('paiementpro_merchant_id')): ?>
                                                                                <span class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('paiementpro_merchant_id')); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>

                                                </div>

                                                <!-- Nepalste-->
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-26">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse26"
                                                            aria-expanded="true" aria-controls="collapse26">
                                                            <span class="d-flex align-items-center">
                                                                <?php echo e(__('Nepalste')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_nepalste_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_nepalste_enabled"
                                                                        id="is_nepalste_enabled"
                                                                        <?php echo e(isset($payment['is_nepalste_enabled']) && $payment['is_nepalste_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="customswitchv1-2"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>

                                                    <div id="collapse26"
                                                        class="accordion-collapse collapse"aria-labelledby="heading-2-26"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="nepalste_public_key"
                                                                            class="form-label"><?php echo e(__('Public Key')); ?></label>
                                                                        <input type="text" name="nepalste_public_key"
                                                                            id="nepalste_public_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['nepalste_public_key']) || is_null($payment['nepalste_public_key']) ? '' : $payment['nepalste_public_key']); ?>"
                                                                            placeholder="<?php echo e(__('Public Key')); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mt-3">
                                                                    <div class="form-group">
                                                                        <label for="nepalste_secret_key"
                                                                            class="form-label"><?php echo e(__('Secret Key')); ?></label>
                                                                        <input type="text" name="nepalste_secret_key"
                                                                            id="nepalste_secret_key"
                                                                            class="form-control"
                                                                            value="<?php echo e(!isset($payment['nepalste_secret_key']) || is_null($payment['nepalste_secret_key']) ? '' : $payment['nepalste_secret_key']); ?>"
                                                                            placeholder="<?php echo e(__('Secret Key')); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                  <!-- Fedapay-->
                                                  <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-27">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapse27"
                                                            aria-expanded="true" aria-controls="collapse27">
                                                            <span class="d-flex align-items-center">
                                                                <?php echo e(__('Fedapay')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_fedapay_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_fedapay_enabled"
                                                                        id="is_fedapay_enabled"
                                                                        <?php echo e(isset($payment['is_fedapay_enabled']) && $payment['is_fedapay_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="customswitchv1-2"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>

                                                    <div id="collapse27"
                                                    class="accordion-collapse collapse"aria-labelledby="heading-2-26"
                                                    data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-12 pb-4">
                                                                    <label
                                                                        class="fedapay-label form-label text-dark"
                                                                        for="fedapay_mode"><?php echo e(__('Fedapay Mode')); ?></label>
                                                                    <br>
                                                                    <div class="d-flex">
                                                                        <div class="mr-2"
                                                                            style="margin-right: 15px;">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark"
                                                                                        style="margin-left:15px;">
                                                                                        <input type="radio"
                                                                                            name="fedapay_mode"
                                                                                            value="sandbox"
                                                                                            class="form-check-input"
                                                                                            <?php echo e(!isset($payment['fedapay_mode']) || $payment['fedapay_mode'] == '' || $payment['fedapay_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                                                        <?php echo e(__('Sandbox')); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mr-2">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark"
                                                                                        style="margin-left:15px;">
                                                                                        <input type="radio"
                                                                                            name="fedapay_mode"
                                                                                            value="live"
                                                                                            class="form-check-input"
                                                                                            <?php echo e(isset($payment['fedapay_mode']) && $payment['fedapay_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                        <?php echo e(__('Live')); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="fedapay_client_id"
                                                                                class="form-label text-dark"><?php echo e(__('Public Key')); ?></label>
                                                                            <input type="text"
                                                                                name="fedapay_public_key"
                                                                                id="fedapay_public_key"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['fedapay_public_key']) ? $payment['fedapay_public_key'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('public key')); ?>" />
                                                                            <?php if($errors->has('fedapay_public_key')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('fedapay_public_key')); ?>

                                                                                </span>
                                                                            <?php endif; ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="fedapay_secret_key"
                                                                                class="form-label text-dark"><?php echo e(__('Secret Key')); ?></label>
                                                                            <input type="text"
                                                                                name="fedapay_secret_key"
                                                                                id="fedapay_secret_key"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['fedapay_secret_key']) ? $payment['fedapay_secret_key'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('Secret Key')); ?>" />
                                                                            <?php if($errors->has('fedapay_secret_key')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('fedapay_secret_key')); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>

                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-28">
                                                        <button class="accordion-button collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse28"
                                                            aria-expanded="false"
                                                            aria-controls="collapse28">
                                                            <span
                                                                class="d-flex align-items-center col-form-label text-dark">
                                                                <?php echo e(__('Cinetpay')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_cinetpay_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_cinetpay_enabled"
                                                                        id="is_cinetpay_enabled"
                                                                        <?php echo e(isset($payment['is_cinetpay_enabled']) && $payment['is_cinetpay_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="customswitchv1-2"></label>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapse28" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-28"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="cinetpay_api_key"
                                                                                class="form-label text-dark"><?php echo e(__('Api Key')); ?></label>
                                                                            <input type="text"
                                                                                name="cinetpay_api_key"
                                                                                id="cinetpay_api_key"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['cinetpay_api_key']) ? $payment['cinetpay_api_key'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('Public Key')); ?>" />
                                                                            <?php if($errors->has('cinetpay_api_key')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('cinetpay_api_key')); ?>

                                                                                </span>
                                                                            <?php endif; ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="cinetpay_secret_key"
                                                                                class="form-label text-dark"><?php echo e(__('Secret Key')); ?></label>
                                                                            <input type="text"
                                                                                name="cinetpay_secret_key"
                                                                                id="cinetpay_secret_key"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['cinetpay_secret_key']) ? $payment['cinetpay_secret_key'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('Secret Key')); ?>" />
                                                                            <?php if($errors->has('cinetpay_secret_key')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('cinetpay_secret_key')); ?>

                                                                                </span>
                                                                            <?php endif; ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="cinetpay_site_id"
                                                                                class="form-label text-dark"><?php echo e(__('Site Id')); ?></label>
                                                                            <input type="text"
                                                                                name="cinetpay_site_id"
                                                                                id="cinetpay_site_id"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['cinetpay_site_id']) ? $payment['cinetpay_site_id'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('Secret Key')); ?>" />
                                                                            <?php if($errors->has('cinetpay_site_id')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('cinetpay_site_id')); ?>

                                                                                </span>
                                                                            <?php endif; ?>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                
                                                <div class="accordion-item card">
                                                    <h2 class="accordion-header" id="heading-2-29">
                                                        <button class="accordion-button collapsed"
                                                            type="button" data-bs-toggle="collapse"
                                                            data-bs-target="#collapse29"
                                                            aria-expanded="false" aria-controls="collapse29">
                                                            <span
                                                                class="d-flex align-items-center col-form-label text-dark">
                                                                <?php echo e(__('PayHere')); ?>

                                                            </span>

                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?php echo e(__('Enable')); ?></span>
                                                                <div class="form-check form-switch custom-switch-v1">
                                                                    <input type="hidden" name="is_payhere_enabled"
                                                                        value="off">
                                                                    <input type="checkbox"
                                                                        class="form-check-input input-primary"
                                                                        name="is_payhere_enabled"
                                                                        id="is_payhere_enabled"
                                                                        <?php echo e(isset($payment['is_payhere_enabled']) && $payment['is_payhere_enabled'] == 'on' ? 'checked="checked"' : ''); ?>>
                                                                    <label class="form-check-label"
                                                                        for="customswitchv1-2"></label>
                                                                </div>
                                                            </div>

                                                        </button>
                                                    </h2>
                                                    <div id="collapse29" class="accordion-collapse collapse"
                                                        aria-labelledby="heading-2-29"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <div class="row">
                                                                <div class="col-md-12 pb-4">
                                                                    <label
                                                                        class="fedapay-label form-label text-dark"
                                                                        for="payhere_mode"><?php echo e(__('PayHere Mode')); ?></label>
                                                                    <br>
                                                                    <div class="d-flex">
                                                                        <div class="mr-2"
                                                                            style="margin-right: 15px;">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark"
                                                                                        style="margin-left:15px;">
                                                                                        <input type="radio"
                                                                                            name="payhere_mode"
                                                                                            value="sandbox"
                                                                                            class="form-check-input"
                                                                                            <?php echo e(!isset($payment['payhere_mode']) || $payment['payhere_mode'] == '' || $payment['payhere_mode'] == 'sandbox' ? 'checked="checked"' : ''); ?>>
                                                                                        <?php echo e(__('Sandbox')); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mr-2">
                                                                            <div class="border card p-3">
                                                                                <div class="form-check">
                                                                                    <label
                                                                                        class="form-check-labe text-dark"
                                                                                        style="margin-left:15px;">
                                                                                        <input type="radio"
                                                                                            name="payhere_mode"
                                                                                            value="live"
                                                                                            class="form-check-input"
                                                                                            <?php echo e(isset($payment['payhere_mode']) && $payment['payhere_mode'] == 'live' ? 'checked="checked"' : ''); ?>>
                                                                                        <?php echo e(__('Live')); ?>

                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="payhere_merchant_id"
                                                                                class="form-label text-dark"><?php echo e(__('Merchant Id')); ?></label>
                                                                            <input type="text"
                                                                                name="payhere_merchant_id"
                                                                                id="payhere_merchant_id"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['payhere_merchant_id']) ? $payment['payhere_merchant_id'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('Merchant Id')); ?>" />
                                                                            <?php if($errors->has('payhere_merchant_id')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('payhere_merchant_id')); ?>

                                                                                </span>
                                                                            <?php endif; ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="payhere_merchant_secret_key"
                                                                                class="form-label text-dark"><?php echo e(__('Merchant Secret')); ?></label>
                                                                            <input type="text"
                                                                                name="payhere_merchant_secret_key"
                                                                                id="payhere_merchant_secret_key"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['payhere_merchant_secret_key']) ? $payment['payhere_merchant_secret_key'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('Secret Key')); ?>" />
                                                                            <?php if($errors->has('payhere_merchant_secret_key')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('payhere_merchant_secret_key')); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="payhere_app_id"
                                                                                class="form-label text-dark"><?php echo e(__('App Id')); ?></label>
                                                                            <input type="text"
                                                                                name="payhere_app_id"
                                                                                id="payhere_app_id"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['payhere_app_id']) ? $payment['payhere_app_id'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('App Id')); ?>" />
                                                                            <?php if($errors->has('payhere_app_id')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('payhere_app_id')); ?>

                                                                                </span>
                                                                            <?php endif; ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label for="payhere_app_secret_key"
                                                                                class="form-label text-dark"><?php echo e(__('App Secret')); ?></label>
                                                                            <input type="text"
                                                                                name="payhere_app_secret_key"
                                                                                id="payhere_app_secret_key"
                                                                                class="form-control"
                                                                                value="<?php echo e(isset($payment['payhere_app_secret_key']) ? $payment['payhere_app_secret_key'] : ''); ?>"
                                                                                placeholder="<?php echo e(__('Secret Key')); ?>" />
                                                                            <?php if($errors->has('payhere_app_secret_key')): ?>
                                                                                <span
                                                                                    class="invalid-feedback d-block">
                                                                                    <?php echo e($errors->first('payhere_app_secret_key')); ?>

                                                                                </span>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer text-end">
                                    <?php echo e(Form::submit(__('Save Changes'), ['class' => 'btn-submit btn btn-primary'])); ?>

                                </div>
                            </form>

                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="storage-settings" class="card mb-3">
                            <?php echo e(Form::open(['route' => 'storage.setting.store', 'enctype' => 'multipart/form-data'])); ?>

                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-10 col-md-10 col-sm-10">
                                        <h5 class=""><?php echo e(__('Storage Settings')); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="pe-2">
                                        <input type="radio" class="btn-check" name="storage_setting"
                                            id="local-outlined" autocomplete="off"
                                            <?php echo e($setting['storage_setting'] == 'local' ? 'checked' : ''); ?> value="local"
                                            checked>
                                        <label class="btn btn-outline-primary"
                                            for="local-outlined"><?php echo e(__('Local')); ?></label>
                                    </div>
                                    <div class="pe-2">
                                        <input type="radio" class="btn-check" name="storage_setting"
                                            id="s3-outlined" autocomplete="off"
                                            <?php echo e($setting['storage_setting'] == 's3' ? 'checked' : ''); ?> value="s3">
                                        <label class="btn btn-outline-primary" for="s3-outlined">
                                            <?php echo e(__('AWS S3')); ?></label>
                                    </div>

                                    <div class="pe-2">
                                        <input type="radio" class="btn-check" name="storage_setting"
                                            id="wasabi-outlined" autocomplete="off"
                                            <?php echo e($setting['storage_setting'] == 'wasabi' ? 'checked' : ''); ?>

                                            value="wasabi">
                                        <label class="btn btn-outline-primary"
                                            for="wasabi-outlined"><?php echo e(__('Wasabi')); ?></label>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div
                                        class="local-setting row <?php echo e($setting['storage_setting'] == 'local' ? ' ' : 'd-none'); ?>">
                                        <div class="form-group col-8 switch-width">
                                            <?php echo e(Form::label('local_storage_validation', __('Only Upload Files'), ['class' => ' form-label'])); ?>

                                            <select name="local_storage_validation[]" class="select2"
                                                id="choices-multiple-remove-button" multiple>
                                                <?php $__currentLoopData = $file_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php if(in_array($f, $local_storage_validations)): ?> selected <?php endif; ?>>
                                                        <?php echo e($f); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label"
                                                    for="local_storage_max_upload_size"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                                                <input type="number" name="local_storage_max_upload_size"
                                                    class="form-control"
                                                    value="<?php echo e(!isset($setting['local_storage_max_upload_size']) || is_null($setting['local_storage_max_upload_size']) ? '' : $setting['local_storage_max_upload_size']); ?>"
                                                    placeholder="<?php echo e(__('Max upload size')); ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="s3-setting row <?php echo e($setting['storage_setting'] == 's3' ? ' ' : 'd-none'); ?>">
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_key"><?php echo e(__('S3 Key')); ?></label>
                                                    <input type="text" name="s3_key" class="form-control"
                                                        value="<?php echo e(!isset($setting['s3_key']) || is_null($setting['s3_key']) ? '' : $setting['s3_key']); ?>"
                                                        placeholder="<?php echo e(__('S3 Key')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_secret"><?php echo e(__('S3 Secret')); ?></label>
                                                    <input type="text" name="s3_secret" class="form-control"
                                                        value="<?php echo e(!isset($setting['s3_secret']) || is_null($setting['s3_secret']) ? '' : $setting['s3_secret']); ?>"
                                                        placeholder="<?php echo e(__('S3 Secret')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_region"><?php echo e(__('S3 Region')); ?></label>
                                                    <input type="text" name="s3_region" class="form-control"
                                                        value="<?php echo e(!isset($setting['s3_region']) || is_null($setting['s3_region']) ? '' : $setting['s3_region']); ?>"
                                                        placeholder="<?php echo e(__('S3 Region')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_bucket"><?php echo e(__('S3 Bucket')); ?></label>
                                                    <input type="text" name="s3_bucket" class="form-control"
                                                        value="<?php echo e(!isset($setting['s3_bucket']) || is_null($setting['s3_bucket']) ? '' : $setting['s3_bucket']); ?>"
                                                        placeholder="<?php echo e(__('S3 Bucket')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_url"><?php echo e(__('S3 URL')); ?></label>
                                                    <input type="text" name="s3_url" class="form-control"
                                                        value="<?php echo e(!isset($setting['s3_url']) || is_null($setting['s3_url']) ? '' : $setting['s3_url']); ?>"
                                                        placeholder="<?php echo e(__('S3 URL')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_endpoint"><?php echo e(__('S3 Endpoint')); ?></label>
                                                    <input type="text" name="s3_endpoint" class="form-control"
                                                        value="<?php echo e(!isset($setting['s3_endpoint']) || is_null($setting['s3_endpoint']) ? '' : $setting['s3_endpoint']); ?>"
                                                        placeholder="<?php echo e(__('S3 Bucket')); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-8 switch-width">
                                                <div>
                                                    <label class="form-label"
                                                        for="s3_storage_validation"><?php echo e(__('Only Upload Files')); ?></label>
                                                </div>
                                                <select class="form-control" name="s3_storage_validation[]"
                                                    id="choices-multiple-remove-button1"
                                                    placeholder="This is a placeholder" multiple>
                                                    <?php $__currentLoopData = $file_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php if(in_array($f, $s3_storage_validations)): ?> selected <?php endif; ?>>
                                                            <?php echo e($f); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_max_upload_size"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                                                    <input type="number" name="s3_max_upload_size"
                                                        class="form-control"
                                                        value="<?php echo e(!isset($settings['s3_max_upload_size']) || is_null($settings['s3_max_upload_size']) ? '' : $settings['s3_max_upload_size']); ?>"
                                                        placeholder="<?php echo e(__('Max upload size')); ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div
                                        class="wasabi-setting row <?php echo e($setting['storage_setting'] == 'wasabi' ? ' ' : 'd-none'); ?>">
                                        <div class=" row ">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_key"><?php echo e(__('Wasabi Key')); ?></label>
                                                    <input type="text" name="wasabi_key" class="form-control"
                                                        value="<?php echo e(!isset($setting['wasabi_key']) || is_null($setting['wasabi_key']) ? '' : $setting['wasabi_key']); ?>"
                                                        placeholder="<?php echo e(__('Wasabi Key')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_secret"><?php echo e(__('Wasabi Secret')); ?></label>
                                                    <input type="text" name="wasabi_secret" class="form-control"
                                                        value="<?php echo e(!isset($setting['wasabi_secret']) || is_null($setting['wasabi_secret']) ? '' : $setting['wasabi_secret']); ?>"
                                                        placeholder="<?php echo e(__('Wasabi Secret')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="s3_region"><?php echo e(__('Wasabi Region')); ?></label>
                                                    <input type="text" name="wasabi_region" class="form-control"
                                                        value="<?php echo e(!isset($setting['wasabi_region']) || is_null($setting['wasabi_region']) ? '' : $setting['wasabi_region']); ?>"
                                                        placeholder="<?php echo e(__('Wasabi Region')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_bucket"><?php echo e(__('Wasabi Bucket')); ?></label>
                                                    <input type="text" name="wasabi_bucket" class="form-control"
                                                        value="<?php echo e(!isset($setting['wasabi_bucket']) || is_null($setting['wasabi_bucket']) ? '' : $setting['wasabi_bucket']); ?>"
                                                        placeholder="<?php echo e(__('Wasabi Bucket')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_url"><?php echo e(__('Wasabi URL')); ?></label>
                                                    <input type="text" name="wasabi_url" class="form-control"
                                                        value="<?php echo e(!isset($setting['wasabi_url']) || is_null($setting['wasabi_url']) ? '' : $setting['wasabi_url']); ?>"
                                                        placeholder="<?php echo e(__('Wasabi URL')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_root"><?php echo e(__('Wasabi Root')); ?></label>
                                                    <input type="text" name="wasabi_root" class="form-control"
                                                        value="<?php echo e(!isset($setting['wasabi_root']) || is_null($setting['wasabi_root']) ? '' : $setting['wasabi_root']); ?>"
                                                        placeholder="<?php echo e(__('Wasabi Bucket')); ?>">
                                                </div>
                                            </div>
                                            <div class="form-group col-8 switch-width">
                                                <?php echo e(Form::label('wasabi_storage_validation', __('Only Upload Files'), ['class' => 'form-label'])); ?>


                                                <select name="wasabi_storage_validation[]" class="select2"
                                                    id="choices-multiple-remove-button2" multiple>
                                                    <?php $__currentLoopData = $file_type; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option <?php if(in_array($f, $wasabi_storage_validations)): ?> selected <?php endif; ?>>
                                                            <?php echo e($f); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="wasabi_root"><?php echo e(__('Max upload size ( In KB)')); ?></label>
                                                    <input type="number" name="wasabi_max_upload_size"
                                                        class="form-control"
                                                        value="<?php echo e(!isset($setting['wasabi_max_upload_size']) || is_null($setting['wasabi_max_upload_size']) ? '' : $setting['wasabi_max_upload_size']); ?>"
                                                        placeholder="<?php echo e(__('Max upload size')); ?>">
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <input class="btn btn-print-invoice  btn-primary m-r-10" type="submit"
                                    value="<?php echo e(__('Save Changes')); ?>">
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="seo-settings" class="card mb-3">

                            <?php echo e(Form::open(['url' => route('seo.settings'), 'enctype' => 'multipart/form-data'])); ?>


                            <div
                                class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                                <h5><?php echo e(__('SEO Settings')); ?></h5>

                                <a class="btn btn-primary btn-sm float-end ms-2" href="#" data-size="lg"
                                    data-ajax-popup-over="true" data-url="<?php echo e(route('generate', ['seo'])); ?>"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>"
                                    data-title="<?php echo e(__('Generate Content with AI')); ?>"><i class="fas fa-robot">
                                        <?php echo e(__('Generate with AI')); ?></i></a>

                            </div>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('meta_keywords', __('Meta Keywords'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('meta_keywords', !empty($getSetting['meta_keywords']) ? $getSetting['meta_keywords'] : '', ['class' => 'form-control ', 'placeholder' => 'Meta Keywords'])); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('meta_description', __('Meta Description'), ['class' => 'form-label'])); ?>

                                            <?php echo e(Form::textarea('meta_description', !empty($getSetting['meta_description']) ? $getSetting['meta_description'] : '', ['class' => 'form-control ', 'rows' => '5', 'placeholder' => 'Enter Meta Description'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php echo e(Form::label('Meta Image', __('Meta Image'), ['class' => 'col-form-label'])); ?>

                                            <div class="">
                                                <?php
                                                    $src =
                                                        isset($getSetting['meta_image']) &&
                                                        !empty($getSetting['meta_image'])
                                                            ? asset(
                                                                Storage::url(
                                                                    'uploads/metaevent/' . $getSetting['meta_image'],
                                                                ),
                                                            )
                                                            : '';
                                                ?>
                                                <a href="<?php echo e($src); ?>" target="_blank">
                                                    <img src="<?php echo e($src); ?>" id="meta_image_pre"
                                                        class="img_setting" width="400px"
                                                        style="
                                                    height: 217px;" />
                                                </a>
                                            </div>

                                            <div class="choose-files mt-4">
                                                <label for="meta_image">
                                                    <div class="bg-primary m-auto">
                                                        <i class="ti ti-upload px-1"></i><?php echo e(__('Select Image')); ?>

                                                        <input style="margin-top: -40px;" type="file"
                                                            class="file" name="meta_image" id="meta_image"
                                                            data-filename="meta_image"
                                                            onchange="document.getElementById('meta_image_pre').src = window.URL.createObjectURL(this.files[0])" />

                                                    </div>
                                                </label>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn-submit btn btn-primary abcd" type="submit">
                                    <?php echo e(__('Save Changes')); ?>

                                </button>
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>




                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="cookie-settings" class="card mb-3">

                            <?php echo e(Form::model($settings, ['route' => 'cookie.setting', 'method' => 'post'])); ?>

                            <div
                                class="card-header flex-column flex-lg-row  d-flex align-items-lg-center gap-2 justify-content-between">
                                <h5><?php echo e(__('Cookie Settings')); ?></h5>
                                <div class="d-flex align-items-center">
                                    <?php echo e(Form::label('enable_cookie', __('Enable cookie'), ['class' => 'col-form-label p-0 fw-bold me-3'])); ?>

                                    <div class="custom-control custom-switch" onclick="enablecookie()">
                                        <input type="checkbox" data-toggle="switchbutton" data-onstyle="primary"
                                            name="enable_cookie" class="form-check-input input-primary "
                                            id="enable_cookie"
                                            <?php echo e($settings['enable_cookie'] == 'on' ? ' checked ' : ''); ?>>
                                        <label class="custom-control-label mb-1" for="enable_cookie"></label>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="card-body cookieDiv <?php echo e($settings['enable_cookie'] == 'off' ? 'disabledCookie ' : ''); ?>">
                                <div class="row">
                                    <div class="float-end">
                                        <a class="btn btn-primary btn-sm float-end " href="#" data-size="lg"
                                            data-ajax-popup-over="true" data-url="<?php echo e(route('generate', ['cookie'])); ?>"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="<?php echo e(__('Generate')); ?>"
                                            data-title="<?php echo e(__('Generate Content with AI')); ?>"><i class="fas fa-robot">
                                                <?php echo e(__('Generate with AI')); ?></i></a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1" id="cookie_log">
                                            <input type="checkbox" name="cookie_logging"
                                                class="form-check-input input-primary cookie_setting"
                                                id="cookie_logging"<?php echo e($settings['cookie_logging'] == 'on' ? ' checked ' : ''); ?>>
                                            <label class="form-check-label" style="margin-left:5px"
                                                for="cookie_logging"><?php echo e(__('Enable logging')); ?></label>
                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('cookie_title', __('Cookie Title'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('cookie_title', null, ['class' => 'form-control cookie_setting'])); ?>

                                        </div>
                                        <div class="form-group ">
                                            <?php echo e(Form::label('cookie_description', __('Cookie Description'), ['class' => ' form-label'])); ?>

                                            <?php echo Form::textarea('cookie_description', null, ['class' => 'form-control cookie_setting', 'rows' => '3']); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch custom-switch-v1 ">
                                            <input type="checkbox" name="necessary_cookies"
                                                class="form-check-input input-primary" id="necessary_cookies" checked
                                                onclick="return false">
                                            <label class="form-check-label" style="margin-left:5px"
                                                for="necessary_cookies"><?php echo e(__('Strictly necessary cookies')); ?></label>
                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('strictly_cookie_title', __(' Strictly Cookie Title'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('strictly_cookie_title', null, ['class' => 'form-control cookie_setting'])); ?>

                                        </div>
                                        <div class="form-group">
                                            <?php echo e(Form::label('strictly_cookie_description', __('Strictly Cookie Description'), ['class' => ' form-label'])); ?>

                                            <?php echo Form::textarea('strictly_cookie_description', null, [
                                                'class' => 'form-control cookie_setting ',
                                                'rows' => '3',
                                            ]); ?>

                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <h5><?php echo e(__('More Information')); ?></h5>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <?php echo e(Form::label('more_information_description', __('Contact Us Description'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('more_information_description', null, ['class' => 'form-control cookie_setting'])); ?>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <?php echo e(Form::label('contactus_url', __('Contact Us URL'), ['class' => 'col-form-label'])); ?>

                                            <?php echo e(Form::text('contactus_url', null, ['class' => 'form-control cookie_setting'])); ?>

                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <div
                                class="card-footer text-end d-flex align-items-center gap-2 flex-sm-column flex-lg-row justify-content-between">
                                <div>
                                    <?php if(isset($settings['cookie_logging']) && $settings['cookie_logging'] == 'on'): ?>
                                        <label for="file"
                                            class="form-label"><?php echo e(__('Download cookie accepted data')); ?></label>
                                        <a href="<?php echo e(asset(Storage::url('uploads/sample')) . '/data.csv'); ?>"
                                            class="btn btn-primary mr-2 ">
                                            <i class="ti ti-download"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <input type="submit" value="<?php echo e(__(' Save Changes')); ?>" class="btn btn-primary">
                            </div>
                            <?php echo e(Form::close()); ?>

                        </div>
                    <?php endif; ?>

                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="cache-settings" class="card mb-3">

                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-8 col-md-8 col-sm-8">
                                        <h5><?php echo e(__('Cache Setting')); ?></h5>
                                        <small class="text-muted">This is a page meant for more advanced users, simply
                                            ignore it if you don't understand what cache is.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">

                                <div class="row">
                                    <div class="row col-xl-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="size">Current cache size</label>
                                                <div class="input-group">
                                                    
                                                    <input id="size" name="size" type="text"
                                                        class="form-control" value="<?php echo e(Utility::GetCacheSize()); ?>"
                                                        readonly="readonly">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                            MB
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <a href="<?php echo e(url('config-cache')); ?>"
                                    class="btn btn-print-invoice btn-primary m-r-10"><?php echo e(__('Clear Cache')); ?></a>
                            </div>
                            <?php echo e(Form::close()); ?>


                        </div>
                    <?php endif; ?>


                    <?php if(\Auth::user()->type == 'Super Admin'): ?>
                        <div id="chatgpt-settings" class="card mb-3">

                            <?php echo e(Form::model($settings, ['route' => 'settings.chatgptkey', 'method' => 'post'])); ?>

                            <div class="card-header">
                                <h5><?php echo e(__('Chat GPT Key Settings')); ?></h5>
                                <small><?php echo e(__('Edit your key details')); ?></small>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <?php echo e(Form::label('chatgpt_key', __('Chat GPT Key'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::text('chatgpt_key', isset($settings['chatgpt_key']) ? $settings['chatgpt_key'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Chatgpt Key Here'), 'required' => 'required'])); ?>

                                    </div>

                                    <div class="form-group col-md-12">
                                        <?php echo e(Form::label('chat_gpt_model', __('Chat GPT Model Name'), ['class' => 'col-form-label'])); ?>

                                        <?php echo e(Form::text('chat_gpt_model', isset($settings['chat_gpt_model']) ? $settings['chat_gpt_model'] : '', ['class' => 'form-control', 'placeholder' => __('Enter Chat GPT Modal Name'), 'required' => 'required'])); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit"><?php echo e(__('Save Changes')); ?></button>
                            </div>
                            <?php echo e(Form::close()); ?>


                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $('.colorPicker').on('click', function(e) {

            $('body').removeClass('custom-color');
            if (/^theme-\d+$/) {
                $('body').removeClassRegex(/^theme-\d+$/);
            }
            $('body').addClass('custom-color');
            $('.themes-color-change').removeClass('active_color');
            $(this).addClass('active_color');
            const input = document.getElementById("color-picker");
            setColor();
            input.addEventListener("input", setColor);

            function setColor() {
                $(':root').css('--color-customColor', input.value);
            }

            $(`input[name='color_flag`).val('true');
        });

        $('.themes-color-change').on('click', function() {

            $(`input[name='color_flag`).val('false');

            var color_val = $(this).data('value');
            $('body').removeClass('custom-color');
            if (/^theme-\d+$/) {
                $('body').removeClassRegex(/^theme-\d+$/);
            }
            $('body').addClass(color_val);
            $('.theme-color').prop('checked', false);
            $('.themes-color-change').removeClass('active_color');
            $('.colorPicker').removeClass('active_color');
            $(this).addClass('active_color');
            $(`input[value=${color_val}]`).prop('checked', true);
        });

        $.fn.removeClassRegex = function(regex) {
            return $(this).removeClass(function(index, classes) {
                return classes.split(/\s+/).filter(function(c) {
                    return regex.test(c);
                }).join(' ');
            });
        };
    </script>
    <script src="<?php echo e(asset('js/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/repeater.js')); ?>"></script>
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        })

        $(".list-group-item").click(function() {
            $('.list-group-item').filter(function() {
                return this.href == id;
            }).parent().removeClass('text-primary');
        });
    </script>

    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        })
        $(".list-group-item").click(function() {
            $('.list-group-item').filter(function() {
                return this.href == id;
            }).parent().removeClass('text-primary');
        });

        function check_theme(color_val) {
            $('#theme_color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }

        $(document).on('change', '[name=storage_setting]', function() {
            if ($(this).val() == 's3') {
                $('.s3-setting').removeClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').addClass('d-none');
            } else if ($(this).val() == 'wasabi') {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').removeClass('d-none');
                $('.local-setting').addClass('d-none');
            } else {
                $('.s3-setting').addClass('d-none');
                $('.wasabi-setting').addClass('d-none');
                $('.local-setting').removeClass('d-none');
            }
        });
    </script>

    <script>
        function myFunction() {
            var copyText = document.getElementById("myInput");
            copyText.select();
            copyText.setSelectionRange(0, 99999)
            document.execCommand("copy");
            show_toastr('Success', "<?php echo e(__('Link copied')); ?>", 'success');
        }

        function check_theme(color_val) {
            $('.theme-color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
    <script type="text/javascript">
        function enablecookie() {
            const element = $('#enable_cookie').is(':checked');
            $('.cookieDiv').addClass('disabledCookie');
            if (element == true) {
                $('.cookieDiv').removeClass('disabledCookie');
                $("#cookie_logging").attr('checked', true);
            } else {
                $('.cookieDiv').addClass('disabledCookie');
                $("#cookie_logging").attr('checked', false);
            }
        }
    </script>
    <script type="text/javascript">
        $(document).on("click", ".email-template-checkbox", function() {
            var chbox = $(this);
            $.ajax({
                url: chbox.attr('data-url'),
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    status: chbox.val()
                },
                type: 'post',
                success: function(response) {
                    if (response.is_success) {
                        show_toastr('Success', response.success, 'success');
                        if (chbox.val() == 1) {
                            $('#' + chbox.attr('id')).val(0);
                        } else {
                            $('#' + chbox.attr('id')).val(1);
                        }
                    } else {
                        show_toastr('Error', response.error, 'error');
                    }
                },
                error: function(response) {
                    response = response.responseJSON;
                    if (response.is_success) {
                        show_toastr('Error', response.error, 'error');
                    } else {
                        show_toastr('Error', response, 'error');
                    }
                }
            })
        });
    </script>
    <script>
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );

        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button1', {
                removeItemButton: true,
            }
        );

        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button2', {
                removeItemButton: true,
            }
        );
    </script>
    <script>
        $(document).on("click", '.send_email', function(e) {

            e.preventDefault();
            var title = $(this).attr('data-title');

            var size = 'md';
            var url = $(this).attr('data-url');
            if (typeof url != 'undefined') {
                $("#commonModal .modal-title").html(title);
                $("#commonModal .modal-dialog").addClass('modal-' + size);
                $("#commonModal").modal('show');

                $.post(url, {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    mail_driver: $("#mail_driver").val(),
                    mail_host: $("#mail_host").val(),
                    mail_port: $("#mail_port").val(),
                    mail_username: $("#mail_username").val(),
                    mail_password: $("#mail_password").val(),
                    mail_encryption: $("#mail_encryption").val(),
                    mail_from_address: $("#mail_from_address").val(),
                    mail_from_name: $("#mail_from_name").val(),
                }, function(data) {
                    $('#commonModal .modal-body').html(data);
                });
            }
        });
        $(document).on('submit', '#test_email', function(e) {
            e.preventDefault();
            $("#email_sending").show();
            var post = $(this).serialize();
            var url = $(this).attr('action');
            $.ajax({
                type: "post",
                url: url,
                data: post,
                cache: false,
                beforeSend: function() {
                    $('#test_email .btn-create').attr('disabled', 'disabled');
                },
                success: function(data) {
                    if (data.is_success) {
                        show_toastr('Success', data.message, 'success');
                    } else {
                        show_toastr('Error', data.message, 'error');
                    }
                    $("#commonModal").modal('hide');
                    $("#email_sending").hide();
                },
                complete: function() {
                    $('#test_email .btn-create').removeAttr('disabled');
                },
            });
        });

        $(document).ready(function() {
            var $dragAndDrop = $("body .custom-fields tbody").sortable({
                handle: '.sort-handler'
            });

            var $repeater = $('.custom-fields').repeater({
                initEmpty: true,
                defaultValues: {},
                show: function() {
                    $(this).slideDown();
                    var eleId = $(this).find('input[type=hidden]').val();


                    if (eleId > 7 || eleId == '') {
                        $(this).find(".field_type option[value='file']").remove();
                        $(this).find(".field_type option[value='select']").remove();
                    }
                },
                hide: function(deleteElement) {
                    if (confirm('<?php echo e(__('Are you sure ? ')); ?>')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function(setIndexes) {
                    $dragAndDrop.on('drop', setIndexes);
                },
                isFirstItemUndeletable: true
            });

            var value = $(".custom-fields").attr('data-value');
            if (typeof value != 'undefined' && value.length != 0) {
                value = JSON.parse(value);
                $repeater.setList(value);
            }

            $.each($('[data-repeater-item]'), function(index, val) {
                var elementId = $(this).find('.custom_id').val();
                if (elementId <= 7) {
                    $.each($(this).find('.field_type'), function(index, val) {
                        $(this).prop('disabled', 'disabled');
                    });
                    $(this).find('.delete-icon').remove();
                }
            });
        });
    </script>
    <script>
        $(document).on('change', '#domain_switch', function() {
            if ($(this).is(':checked')) {
                $('#domain').attr("required", true);
                $('#domain').removeClass('d-none');
                $('#domainnote').removeClass('d-none');
            } else {
                $('#domain').val(null);
                $('#domain').addClass('d-none');
                $('#domainnote').addClass('d-none');
            }
        });
    </script>
    <script>
        $(document).on('change', '[name=custom_setting]', function() {
            if ($(this).val() == 'enable_subdomain') {
                $('#StoreLink').removeClass('d-block');
                $('#sundomain').removeClass('d-none');
                $('#StoreLink').addClass('d-none');
                $('.domain_div').addClass('d-none');


            } else if ($(this).val() == 'enable_domain') {
                $('#StoreLink').removeClass('d-block');
                $('#sundomain').addClass('d-none');
                $('#StoreLink').addClass('d-none');
                $('.domain_div').removeClass('d-none');
            } else {
                $('#sundomain').addClass('d-none');
                $('#StoreLink').removeClass('d-none');
                $('.domain_div').addClass('d-none');
            }
        });
    </script>
    <script>
        var custdarklayout = document.querySelector("#cust-darklayout");
        custdarklayout.addEventListener("click", function() {
            if (custdarklayout.checked) {

                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "<?php echo e(asset('assets/css/style-dark.css')); ?>");
                document.body.style.background = 'linear-gradient(141.55deg, #22242C 3.46%, #22242C 99.86%)';
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "<?php echo e(asset('/storage/uploads/logo/logo-light.png')); ?>");
            } else {

                document
                    .querySelector("#main-style-link")
                    .setAttribute("href", "<?php echo e(asset('assets/css/style.css')); ?>");
                document
                    .querySelector(".m-header > .b-brand > .logo-lg")
                    .setAttribute("src", "<?php echo e(asset('/storage/uploads/logo/logo-dark.png')); ?>");
                document.body.style.setProperty('background',
                    'linear-gradient(141.55deg, rgba(240, 244, 243, 0) 3.46%, #f0f4f3 99.86%)', 'important');

            }


        });


        var custthemebg = document.querySelector("#cust-theme-bg");

        custthemebg.addEventListener("click", function() {
            if (custthemebg.checked) {
                document.querySelector(".dash-sidebar").classList.add("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.add("transprent-bg");
            } else {
                document.querySelector(".dash-sidebar").classList.remove("transprent-bg");
                document
                    .querySelector(".dash-header:not(.dash-mob-header)")
                    .classList.remove("transprent-bg");
            }
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/users/setting.blade.php ENDPATH**/ ?>