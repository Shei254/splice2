<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Create Ticket')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('tickets.index')); ?>"><?php echo e(__('Tickets')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Create')); ?></li>
<?php $__env->stopSection(); ?>

<?php
$plansettings = \App\Models\Utility::plansettings();
?>
<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('tickets.store')); ?>" class="mt-3" method="post" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-md-6">

                            <h6><?php echo e(__('Ticket Information')); ?></h6>
                        </div>
                        <?php if($plansettings["enable_chatgpt"] == 'on'): ?>
                        <div class="col-md-6">
                            <a class="btn btn-primary btn-sm float-end ms-2" href="#" data-size="lg" data-ajax-popup-over="true" data-url="<?php echo e(route('generate',['support'])); ?>" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Generate')); ?>" data-title="<?php echo e(__('Generate Content with AI')); ?>"><i class="fas fa-robot"> <?php echo e(__('Generate with AI')); ?></i></a>

                        </div>
                        <?php endif; ?>

                    </div>

                    <div class="card-body">

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Name')); ?></label>
                                <input class="form-control <?php echo e((!empty($errors->first('name')) ? 'is-invalid' : '')); ?>" type="text" name="name" required="" placeholder="<?php echo e(__('Name')); ?>">
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('name')); ?>

                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Email')); ?></label>
                                <input class="form-control <?php echo e((!empty($errors->first('email')) ? 'is-invalid' : '')); ?>" type="email" name="email" required="" placeholder="<?php echo e(__('Email')); ?>">
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('email')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Category')); ?></label>
                                <select class="form-control <?php echo e((!empty($errors->first('category')) ? 'is-invalid' : '')); ?>" name="category" required="">
                                    <option value=""><?php echo e(__('Select Category')); ?></option>

                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('category')); ?>

                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Status')); ?></label>
                                <select class="form-control <?php echo e((!empty($errors->first('status')) ? 'is-invalid' : '')); ?>" name="status" required="">
                                    <option value=""><?php echo e(__('Select Status')); ?></option>
                                    <option value="New Ticket"><?php echo e(__('New Ticket')); ?></option>
                                    <option value="In Progress"><?php echo e(__('In Progress')); ?></option>
                                    <option value="On Hold"><?php echo e(__('On Hold')); ?></option>
                                    <option value="Closed"><?php echo e(__('Closed')); ?></option>
                                    <option value="Resolved"><?php echo e(__('Resolved')); ?></option>
                                </select>




                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('status')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Subject')); ?></label>
                                <input class="form-control <?php echo e((!empty($errors->first('subject')) ? 'is-invalid' : '')); ?>" type="text" name="subject" required="" placeholder="<?php echo e(__('Subject')); ?>">
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('subject')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label class="require form-label"><?php echo e(__('Attachments')); ?> <small>(<?php echo e(__('You can select multiple files')); ?>)</small> </label>
                                <div class="choose-file form-group">
                                    <label for="file" class="form-label d-block">

                                        <input type="file" name="attachments[]" id="file" class="form-control mb-2 <?php echo e($errors->has('attachments') ? ' is-invalid' : ''); ?>" multiple=""  data-filename="multiple_file_selection" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                                        <img src="" id="blah" width="20%"/>
                                        <div class="invalid-feedback">
                                            <?php echo e($errors->first('attachments.*')); ?>

                                        </div>
                                    </label>
                                </div>
                                <p class="multiple_file_selection mx-4"></p>
                            </div>

                            <div class="form-group col-md-6">

                                    <label class="require form-label"><?php echo e(__('Priority')); ?></label>
                                    <select class="form-control <?php echo e((!empty($errors->first('priority')) ? 'is-invalid' : '')); ?>" name="priority" required="">
                                        <option value=""><?php echo e(__('Select Priority')); ?></option>

                                        <?php $__currentLoopData = $priorities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                            <option value="<?php echo e($priority->id); ?>"><?php echo e($priority->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e($errors->first('priority')); ?>

                                    </div>

                            </div>
                            <div class="form-group col-md-12">
                                <label class="require form-label"><?php echo e(__('Description')); ?></label>
                                <textarea name="description" id="description" class="form-control ckdescription <?php echo e((!empty($errors->first('description')) ? 'is-invalid' : '')); ?>"></textarea>
                                <div class="invalid-feedback">
                                    <?php echo e($errors->first('description')); ?>

                                </div>
                            </div>
                            <?php if(!$customFields->isEmpty()): ?>
                                <?php echo $__env->make('admin.customFields.formBuilder', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-end text-end">
                            <a class="btn btn-secondary btn-light btn-submit" href="<?php echo e(route('tickets.index')); ?>"><?php echo e(__('Cancel')); ?></a>
                            <button class="btn btn-primary btn-submit ms-2" type="submit"><?php echo e(__('Submit')); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="//cdn.ckeditor.com/4.12.1/basic/ckeditor.js"></script>
    <script src="<?php echo e(asset('js/editorplaceholder.js')); ?>"></script>
    <script>
    $(document).ready(function () {
        $.each($('.ckdescription'), function (i, editor) {

            CKEDITOR.replace(editor, {
                extraPlugins: 'editorplaceholder',
                editorplaceholder: editor.placeholder,
                removeButtons : 'Source,Save,NewPage,ExportPdf,Preview,Print,Templates,Cut,Copy,Paste,PasteText,PasteFromWord,Undo,Redo,Find,Replace,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,Subscript,Superscript,CopyFormatting,RemoveFormat,Blockquote,BidiLtr,BidiRtl,Language,Anchor,Image,Table,HorizontalRule,Smiley,SpecialChar,PageBreak,Iframe,About,Maximize,ShowBlocks,TextColor,BGColor,Format,Font,FontSize'
            });
        });
    });

    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/tickets/create.blade.php ENDPATH**/ ?>