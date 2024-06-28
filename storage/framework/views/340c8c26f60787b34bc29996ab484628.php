<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Manage Tickets')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Tickets')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('multiple-action-button'); ?>
    <div class="row justify-content-end">
        <div class="col-auto">
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create-tickets')): ?>
                <div class="btn btn-sm btn-primary btn-icon m-1 float-end ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Create Ticket')); ?>">
                    <a href="<?php echo e(route('tickets.create')); ?>" class=""><i class="ti ti-plus text-white"></i></a>
                </div>
            <?php endif; ?>
            <div class="btn btn-sm btn-primary btn-icon m-1 ms-2" data-bs-toggle="tooltip" data-bs-placement="top" title="<?php echo e(__('Export Tickets CSV file')); ?>">
                <a href="<?php echo e(route('tickets.export')); ?>" class="" ><i class="ti ti-file-export text-white"></i></a>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <?php if(session()->has('ticket_id') || session()->has('smtp_error')): ?>
                <div class="alert alert-info">
                    <?php if(session()->has('ticket_id')): ?>
                        <?php echo Session::get('ticket_id'); ?>

                        <?php echo e(Session::forget('ticket_id')); ?>

                    <?php endif; ?>
                    <?php if(session()->has('smtp_error')): ?>
                        <?php echo Session::get('smtp_error'); ?>

                        <?php echo e(Session::forget('smtp_error')); ?>

                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-sm-12">
            <div class="mt-2 " id="multiCollapseExample1">
                <div class="card">
                    <div class="card-body">
                    <?php echo e(Form::open(array('route' => array('tickets.index'),'method' => 'GET','id'=>'ticket_index'))); ?>


                        <div class="row align-items-center justify-content-end">
                            <div class="col-xl-5">
                                <div class="row">

                                    <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                                <?php echo e(Form::label('category', __('Category'),['class'=>'form-label'])); ?>

                                                <?php echo e(Form::select('category',$categories,isset($_GET['category'])?$_GET['category']:'', array('class' => 'form-control select'))); ?>

                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">

                                        <div class="btn-box">
                                            <?php echo e(Form::label('status', __('Status'),['class'=>'form-label'])); ?>

                                            <select name="status" class="form-control select" id="">
                                                <option value="All"><?php echo e(__('Select Status')); ?></option>
                                                <?php $__currentLoopData = $statues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option <?php echo e(isset($_GET['status']) && $_GET['status'] == $item ? 'selected' : ""); ?>  value="<?php echo e($item); ?>"><?php echo e($item); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12 col-12">
                                        <div class="btn-box">
                                                <?php echo e(Form::label('priority', __('Priority'),['class'=>'form-label'])); ?>

                                                <?php echo e(Form::select('priority',$priorities,isset($_GET['priority'])?$_GET['priority']:'', array('class' => 'form-control select'))); ?>

                                        </div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row">
                                    <div class="col-auto mt-4">
                                        <a href="#" class="btn btn-sm btn-primary" onclick="document.getElementById('ticket_index').submit(); return false;" data-bs-toggle="tooltip" title="<?php echo e(__('Apply')); ?>" data-original-title="<?php echo e(__('apply')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-search"></i></span>
                                        </a>
                                        <a href="<?php echo e(route('tickets.index')); ?>" class="btn btn-sm btn-danger " data-bs-toggle="tooltip"  title="<?php echo e(__('Reset')); ?>" data-original-title="<?php echo e(__('Reset')); ?>">
                                            <span class="btn-inner--icon"><i class="ti ti-trash-off text-white-off "></i></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php echo e(Form::close()); ?>

                    </div>
                </div>
            </div>
        </div>

    </div>

        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">
                        <table id="pc-dt-simple" class="table">
                            <thead class="thead-light">
                            <tr>

                                <th><?php echo e(__('Ticket ID')); ?></th>
                                <th class="w-10"><?php echo e(__('Name')); ?></th>
                                <th><?php echo e(__('Email')); ?></th>
                                <th><?php echo e(__('Category')); ?></th>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Priority')); ?></th>
                                <th><?php echo e(__('Timing')); ?></th>
                                <th><?php echo e(__('Created')); ?></th>
                                <th class="text-end me-3"><?php echo e(__('Action')); ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="Id sorting_1">
                                        <a class="btn btn-outline-primary" href="<?php echo e(route('tickets.edit',$ticket->id)); ?>">
                                            <?php echo e($ticket->ticket_id); ?>

                                        </a>
                                    </td>
                                    <td><span class="white-space"><?php echo e($ticket->name); ?></span></td>
                                    <td><?php echo e($ticket->email); ?></td>

                                    <td>
                                        <span class="badge  p-2 px-3 rounded fix_badge" style="background: <?php echo e($ticket->color); ?>"><?php echo e($ticket->category_name); ?></span>
                                    </td>


                                    <td><span class="badge fix_badge <?php if($ticket->status == 'New Ticket'): ?> bg-secondary <?php elseif($ticket->status == 'In Progress'): ?>bg-info  <?php elseif($ticket->status == 'On Hold'): ?> bg-warning <?php elseif($ticket->status == 'Closed'): ?> bg-primary <?php else: ?> bg-success <?php endif; ?>  p-2 px-3 rounded"><?php echo e(__($ticket->status)); ?></span></td>
                                    <td>
                                        <span class="badge  p-2 px-3 rounded fix_badge" style="background: <?php echo e($ticket->priorities_color); ?>"><?php echo e($ticket->priorities_name); ?></span>
                                    </td>

                                    

                                    <td>
                                        <span>
                                            <?php if((string)$ticket->responseTimeconvertinhours == 'off'): ?>
                                            <?php echo e(__('Response In')); ?>: <?php echo e($ticket->priorities->policies->response_within); ?> <?php echo e($ticket->priorities->policies->response_time); ?> <br>

                                            <?php else: ?>
                                                <?php if($ticket->responseTimeconvertinhours): ?>
                                                <span class="text-danger" ><?php echo e(__('Response Overdue')); ?></span>
                                                <?php else: ?>
                                                 <?php echo e(__('Response time')); ?>

                                                <?php endif; ?> : <?php echo e($ticket->responsetime); ?>  <br>
                                            <?php endif; ?>
                                        </span>
                                        <span>

                                            <?php if($ticket->status=='Resolved'): ?>
                                                <?php if($ticket->resolveTimeconvertinhours): ?>
                                                <span class="text-danger" > <?php echo e(__('Resolve Overdue')); ?></span>
                                                <?php else: ?>
                                                <?php echo e(__('Resolve Time')); ?>

                                                <?php endif; ?> : <?php echo e($ticket->resolvetime); ?>

                                            <?php else: ?>
                                            <?php echo e(__('Resolve In')); ?>: <?php echo e($ticket->priorities->policies->resolve_within); ?> <?php echo e($ticket->priorities->policies->resolve_time); ?>

                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td><?php echo e($ticket->created_at->diffForHumans()); ?></td>
                                    <td class="text-end">
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('reply-tickets')): ?>
                                            <div class="action-btn bg-info ms-2">
                                                <a href="<?php echo e(route('tickets.edit', $ticket->id)); ?>" class="mx-3 btn btn-sm d-inline-flex align-items-center"  data-bs-toggle="tooltip" title="<?php echo e(__('Reply')); ?>"> <span class="text-white"> <i class="ti ti-corner-up-left"></i></span></a>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete-tickets')): ?>
                                            <div class="action-btn bg-danger ms-2">
                                                <form method="POST" action="<?php echo e(route('tickets.destroy',$ticket->id)); ?>" id="user-form-<?php echo e($ticket->id); ?>">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button type="submit" class="mx-3 btn btn-sm d-inline-flex align-items-center show_confirm"  data-bs-toggle="tooltip"
                                                    title='Delete'>
                                                        <span class="text-white"> <i class="ti ti-trash"></i></span>
                                                    </button>
                                                </form>
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

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/admin/tickets/index.blade.php ENDPATH**/ ?>