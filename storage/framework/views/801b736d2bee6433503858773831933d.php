<div class="card sticky-top" style="top:30px">
    <div class="list-group list-group-flush" id="useradd-sidenav">
        <a href="<?php echo e(route('category')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'category' ) ? ' active' : ''); ?>"><?php echo e(__('Category')); ?> <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('group')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'group' ) ? 'active' : ''); ?>"><?php echo e(__('Group')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('operating_hours.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'operating_hours.index' ) ? 'active' : ''); ?>"><?php echo e(__('Operating Hours')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('priority.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'priority.index' ) ? 'active' : ''); ?>"><?php echo e(__('Priority')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

        <a href="<?php echo e(route('policiy.index')); ?>" class="list-group-item list-group-item-action border-0 <?php echo e((Request::route()->getName() == 'policiy.index' ) ? 'active' : ''); ?>"><?php echo e(__('SLA Policy Setting')); ?><div class="float-end"><i class="ti ti-chevron-right"></i></div></a>

    </div>
</div>

<?php /**PATH /home/splibrjd/public_html/resources/views/layouts/setup.blade.php ENDPATH**/ ?>