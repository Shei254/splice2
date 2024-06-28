<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create User')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('users.index')); ?>"><?php echo e(__('Users')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Create')); ?></li>
<?php $__env->stopSection(); ?>

<?php
    $settings = App\Models\Utility::settings();

?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" class="needs-validation" action="<?php echo e(route('users.store')); ?>"
                        enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label"><?php echo e(__('Name')); ?></label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="text" placeholder="<?php echo e(__('Full name of the user')); ?>" name="name"
                                        class="form-control <?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>"
                                        value="<?php echo e(old('name')); ?>" autofocus>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('name')); ?>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label"><?php echo e(__('Email')); ?></label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="email" placeholder="<?php echo e(__('Email address (should be unique)')); ?>"
                                        name="email"
                                        class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>"
                                        value="<?php echo e(old('email')); ?>">
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('email')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(\Auth::user()->type == 'Admin'): ?>
                            <div class="col-12 form-group">
                                <?php echo e(Form::label('categories', __('Category'), ['class' => 'col-form-label'])); ?>

                                <?php echo e(Form::select('categories[]', $categories, null, ['class' => 'form-control multi-select ', 'id' => 'choices-multiple', 'multiple' => ''])); ?>

                            </div>
                        <?php endif; ?>

                        <div class="col-md-5 mb-3">
                            <span><?php echo e(__('Login is enable')); ?></span>
                            <div class="form-check form-switch d-inline-block custom-switch-v1">
                                <?php echo e(Form::checkbox('password_switch', '1', isset($settings['password_switch']) && $settings['password_switch'] == '1' ? 'checked' : '', ['class' => 'form-check-input', 'id' => 'password_switch'])); ?>

                                <label class="form-check-label" for="password_switch"></label>

                                <input type="checkbox" name="password_switch"
                                    class="form-check-input input-primary pointer" value="on" id="password_switch"
                                    <?php echo e(isset($settings['password_switch']) && $settings['password_switch'] == 'on' ? 'checked="checked"' : ''); ?>>
                            </div>
                        </div>
                        <div class="row ps_div d-none">
                            <div class="form-group col-md-6">
                                <label class="form-label"><?php echo e(__('Password')); ?></label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="password" name="password"
                                        placeholder="<?php echo e(__('Set an account password')); ?>"
                                        class="form-control <?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>">
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('password')); ?>

                                    </div>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="form-label"><?php echo e(__('Confirm Password')); ?></label>
                                <div class="col-sm-12 col-md-12">
                                    <input type="password" name="password_confirmation"
                                        placeholder="<?php echo e(__('Confirm account password')); ?>"
                                        class="form-control <?php echo e($errors->has('password_confirmation') ? ' is-invalid' : ''); ?>">
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
                                                <input type="file" name="avatar" id="avatar"
                                                    class="form-control <?php echo e($errors->has('avatar') ? ' is-invalid' : ''); ?>"
                                                    onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"
                                                    data-filename="avatar_selection">
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
                                        
                                        <img src="" id="blah" width="25%" class="rounded-pill" />
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label class="form-label"></label>
                                <div class="col-sm-12 col-md-12 text-end">
                                    <button
                                        class="btn btn-primary btn-block mt-2 btn-submit"><span><?php echo e(__('Add')); ?></span></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        <?php $__env->stopSection(); ?>
        <?php $__env->startPush('scripts'); ?>
            <script src="//cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>
            <script src="<?php echo e(asset('js/editorplaceholder.js')); ?>"></script>
            <script>
                $(document).ready(function() {
                    $.each($('.ckdescription'), function(i, editor) {

                        CKEDITOR.replace(editor, {
                            extraPlugins: 'editorplaceholder',
                            editorplaceholder: editor.placeholder,
                            removeButtons: 'Image,TextColor,BGColor,ShowBlocks,Maximize,FontSize,Format,Styles,Font,Strike,Subscript,Superscript,CopyFormatting,RemoveFormat,Blockquote,CreateDiv,JustifyLeft,JustifyCenter,JustifyBlock,JustifyRight,BidiLtr,BidiRtl,Language,Anchor,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,Checkbox,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Scayt,SelectAll,Find,Undo,Redo,Replace,Source,Save,NewPage,ExportPdf,Preview,Print,PasteFromWord,PasteText,Paste,Copy,Cut,Templates,About'

                        });
                    });
                });
            </script>
            <script>
                $(document).on('change', '#password_switch', function() {
                    if ($(this).is(':checked')) {
                        $('.ps_div').removeClass('d-none');
                        $('#password').attr("required", true);

                    } else {
                        $('.ps_div').addClass('d-none');
                        $('#password').val(null);
                        $('#password').removeAttr("required");
                    }
                });
            </script>
        <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/users/create.blade.php ENDPATH**/ ?>