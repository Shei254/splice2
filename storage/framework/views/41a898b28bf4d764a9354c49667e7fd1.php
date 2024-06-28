   <?php
       $setting = Utility::settings();
       if (\Auth::user()->type == 'Admin') {
           $logo = $setting['company_logo'];

           if ($setting['cust_darklayout'] == 'on') {
               $logo = $setting['company_logo_light'];
           }
       } else {
           $logo = Utility::get_superadmin_logo();

       }
       $logos = \App\Models\Utility::get_file('uploads/logo/');
       $emailTemplate = App\Models\EmailTemplate::first();
   ?>

   <?php if(isset($setting['cust_theme_bg']) && $setting['cust_theme_bg'] == 'on'): ?>
       <nav class="dash-sidebar light-sidebar transprent-bg">
       <?php else: ?>
           <nav class="dash-sidebar light-sidebar">
   <?php endif; ?>

   <div class="navbar-wrapper">
       <div class="m-header main-logo">
           <a href="<?php echo e(route('home')); ?>" class="b-brand">
               <!-- ========   change your logo hear   ============ -->
               <img src="<?php echo e($logos . (isset($logo) && !empty($logo) ? $logo .'?'.time() : 'logo-dark.png'.'?'.time())); ?>"
                   alt="<?php echo e(config('app.name', 'TicketGo SaaS')); ?>" class="logo logo-lg">
           </a>
       </div>
       <div class="navbar-content">
           <ul class="dash-navbar">
               <li class="dash-item <?php echo e(request()->is('*dashboard*') ? ' active' : ''); ?>">
                   <a href="<?php echo e(route('home')); ?>" class="dash-link "><span class="dash-micon"><i
                               class="ti ti-home"></i></span><span class="dash-mtext"><?php echo e(__('Dashboard')); ?></span></a>
               </li>

               <?php if(\Auth::user()->type == 'Super Admin' || \Auth::user()->type == 'Admin'): ?>
                   <li class="dash-item <?php echo e(request()->is('*users*') ? ' active' : ''); ?>">
                       <a href="<?php echo e(route('users.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                   class="ti ti-users"></i></span><span
                               class="dash-mtext"><?php echo e(__('Users')); ?></span></a>
                   </li>
               <?php endif; ?>


               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-tickets')): ?>
                   <li class="dash-item <?php echo e(request()->is('*ticket*') ? ' active' : ''); ?>">
                       <a href="<?php echo e(route('tickets.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                   class="ti ti-ticket"></i></span><span class="dash-mtext"><?php echo e(__('Tickets')); ?></span></a>
                   </li>
               <?php endif; ?>


               <?php if(\Auth::user()->type == "Admin"): ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-faq')): ?>
                   <?php if(Utility::getSettingValByName('FAQ') == 'on'): ?>
                       <li class="dash-item <?php echo e(request()->is('*faq*') ? ' active' : ''); ?>">
                           <a href="<?php echo e(route('faq')); ?>" class="dash-link"><span class="dash-micon"><i
                                       class="ti ti-question-mark"></i></span><span
                                   class="dash-mtext"><?php echo e(__('FAQ')); ?></span></a>
                       </li>
                   <?php endif; ?>
               <?php endif; ?>
               <?php endif; ?>

               <?php if(\Auth::user()->type != 'Super Admin'): ?>
                   <?php if(Utility::settingsById(1)['CHAT_MODULE'] == 'yes'): ?>
                       <li class="dash-item <?php echo e(request()->is('*Messenger*') ? ' active' : ''); ?>">
                           <a href="<?php echo e(route('chats')); ?>" class="dash-link"><span class="dash-micon"><i
                                       class="ti ti-brand-hipchat"></i></span><span
                                   class="dash-mtext"><?php echo e(__('Messenger')); ?></span></a>
                       </li>
                   <?php endif; ?>
               <?php endif; ?>

               <?php if(\Auth::user()->type == "Admin"): ?>
               <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage-knowledge')): ?>
                   <?php if(Utility::getSettingValByName('Knowlwdge_Base') == 'on'): ?>
                       <li class="dash-item <?php echo e(request()->is('*knowledge*') ? ' active' : ''); ?>">
                           <a href="<?php echo e(route('knowledge')); ?>" class="dash-link"><span class="dash-micon"><i
                                       class="ti ti-school"></i></span><span
                                   class="dash-mtext"><?php echo e(__('Knowledge Base')); ?></span></a>
                       </li>
                   <?php endif; ?>
               <?php endif; ?>
               <?php endif; ?>
               <?php if(\Auth::user()->awsCustomer): ?>
                   <li
                       class="dash-item <?php echo e(Request::segment(1) == 'plan' || Request::route()->getName() == 'plan.payment' ? 'active' : ''); ?>">
                       <a class="dash-link" href="#">
                           <span class="dash-micon"><i class="ti ti-trophy"></i></span><span
                               class="dash-mtext"><?php echo e(__('Billing Handled By AWS')); ?></span>
                       </a>
                   </li>
               <?php else: ?>
                   <?php if(\Auth::user()->type == 'Super Admin' || \Auth::user()->type == 'Admin'): ?>
                       <li
                           class="dash-item <?php echo e(Request::segment(1) == 'plan' || Request::route()->getName() == 'plan.payment' ? 'active' : ''); ?>">
                           <a class="dash-link" href="<?php echo e(route('plan.index')); ?>">
                               <span class="dash-micon"><i class="ti ti-trophy"></i></span><span
                                   class="dash-mtext"><?php echo e(__('Plan')); ?></span>
                           </a>
                       </li>
                   <?php endif; ?>

                   <?php if(\Auth::user()->type == 'Super Admin'): ?>
                       <li
                           class="dash-item  <?php echo e(\Request::route()->getName() == 'plan_request' || \Request::route()->getName() == 'plan_request.show' || \Request::route()->getName() == 'plan_request.edit' ? ' active' : ''); ?>">
                           <a href="<?php echo e(route('plan_request.index')); ?>" class="dash-link">
                               <span class="dash-micon"><i class="ti ti-brand-telegram"></i></span><span
                                   class="dash-mtext"><?php echo e(__('Plan Request')); ?></span>
                           </a>
                       </li>
                       <li class="dash-item   <?php echo e(Request::segment(1) == 'referral-program' ? 'active' : ''); ?>">
                           <a href="<?php echo e(route('referral-programs.index')); ?>" class="dash-link">
                               <span class="dash-micon"><i class="ti ti-trophy"></i></span><span
                                   class="dash-mtext"><?php echo e(__('Referral Program')); ?></span>
                           </a>
                       </li>

                       <li
                           class="dash-item  <?php echo e(\Request::route()->getName() == 'custom_domain_request' || \Request::route()->getName() == 'custom_domain_request.show' || \Request::route()->getName() == 'custom_domain_request.edit' ? ' active' : ''); ?>">
                           <a href="<?php echo e(route('custom_domain_request.index')); ?>" class="dash-link">
                               <span class="dash-micon"><i class="ti ti-browser"></i></span><span
                                   class="dash-mtext"><?php echo e(__('Domain Request')); ?></span>
                           </a>
                       </li>
                   <?php endif; ?>
               <?php endif; ?>

               <?php if(\Auth::user()->type == 'Admin'): ?>
                <li class="dash-item <?php echo e((\Request::route()->getName()=='referral-program') ? ' active' : ''); ?>">
                    <a href="<?php echo e(route('referral-program.company')); ?>" class="dash-link"><span class="dash-micon"><i class="ti ti-trophy"></i></span><span class="dash-mtext"><?php echo e(__('Referral Program')); ?></span></a>
                </li>
               <?php endif; ?>

               <?php if(\Auth::user()->type == 'Super Admin'): ?>
                   <li class="dash-item <?php echo e(Request::segment(1) == 'coupons' ? 'active' : ''); ?>">
                       <a class="dash-link" href="<?php echo e(route('coupon.index')); ?>">
                           <span class="dash-micon"><i class="ti ti-gift"></i></span><span
                               class="dash-mtext"><?php echo e(__('Coupons')); ?></span>
                       </a>
                   </li>
               <?php endif; ?>

               <?php if(\Auth::user()->type == 'Super Admin' || \Auth::user()->type == 'Admin'): ?>
                   <li class="dash-item <?php echo e(\Request::route()->getName() == 'order' ? ' active' : ''); ?>">
                       <a href="<?php echo e(route('order.index')); ?>" class="dash-link">
                           <span class="dash-micon"><i class="ti ti-shopping-cart-plus"></i></span><span
                               class="dash-mtext"><?php echo e(__('Order')); ?></span>
                       </a>
                   </li>
               <?php endif; ?>

               <?php if(\Auth::user()->type == 'Super Admin'): ?>
                   <li class="dash-item <?php echo e(request()->is('*email*') ? ' active' : ''); ?>">
                       <a href="<?php echo e(route('manage.email.language', [$emailTemplate->id, \Auth::user()->lang])); ?>"
                           class="dash-link"><span class="dash-micon"><i class="ti ti-template"></i></span><span
                               class="dash-mtext"><?php echo e(__('Email Template')); ?></span></a>
                   </li>
               <?php endif; ?>
               <?php if(\Auth::user()->type == 'Admin'): ?>
               <li class="dash-item">
                           <a href="<?php echo e(route('category')); ?>" class="dash-link"><span class="dash-micon"><i
                            class="ti ti-layout-2"></i></span><span
                        class="dash-mtext"><?php echo e(__('Setup')); ?></span></a>


               </li>
               <?php endif; ?>

               <?php if(\Auth::user()->type == 'Admin'): ?>
               <li class="dash-item <?php echo e((\Request::route()->getName()=='notification-templates') ? ' active' : ''); ?>">
                <a href="<?php echo e(route('notification-templates.index')); ?>" class="dash-link"><span class="dash-micon"><i class="ti ti-notification"></i></span><span class="dash-mtext"><?php echo e(__('Notification')); ?></span></a>
                </li>
              <?php endif; ?>


              <?php if(\Auth::user()->type == 'Super Admin'): ?>
                <?php echo $__env->make('landingpage::menu.landingpage', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <?php endif; ?>

               <?php if(\Auth::user()->type == 'Super Admin' || \Auth::user()->type == 'Admin'): ?>
                   <li class="dash-item <?php echo e(request()->is('*setting*') ? ' active' : ''); ?>">
                       <a href="<?php echo e(route('settings.index')); ?>" class="dash-link"><span class="dash-micon"><i
                                   class="ti ti-settings"></i></span><span
                               class="dash-mtext"><?php echo e(__('Settings')); ?></span></a>
                   </li>
               <?php endif; ?>

           </ul>
       </div>
   </div>
   </nav>
<?php /**PATH /home/shei/Desktop/splice/resources/views/admin/partials/sidebar.blade.php ENDPATH**/ ?>