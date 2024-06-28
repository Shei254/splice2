<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Dashboard')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-button'); ?>
    <?php if(\Auth::user()->type == 'Admin'): ?>
        <a href="#" class="btn btn-sm btn-primary btn-icon cp_link" data-link="<?php echo e(url(\Auth::user()->slug . '/tickets')); ?>"
            data-toggle="tooltip" data-original-title="<?php echo e(__('Click To Copy Support Ticket Url')); ?>"
            title="<?php echo e(__('Click To Copy Support Ticket Url')); ?>" data-bs-toggle="tooltip" data-bs-placement="top">
            <i class="ti ti-copy"></i>
        </a>
    <?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <?php if(\Auth::user()->type != 'Super Admin'): ?>
                    <div class="col-xxl-7">
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <div class="card">
                                    <div class="card-body dash_card_height">
                                        <div class="theme-avtar bg-primary">
                                            <i class="fas fa-list-alt"></i>
                                        </div>
                                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total')); ?></p>
                                        <h6 class="mb-3"><?php echo e(__('Categories')); ?></h6>
                                        <h3 class="mb-0"><?php echo e($categories); ?></h3>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="card">
                                    <div class="card-body dash_card_height">
                                        <div class="theme-avtar bg-info">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Open')); ?></p>
                                        <h6 class="mb-3"><?php echo e(__('Tickets')); ?></h6>
                                        <h3 class="mb-0"><?php echo e($open_ticket); ?> </h3>

                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-lg-3 col-6">
                                <div class="card">
                                    <div class="card-body dash_card_height">
                                        <div class="theme-avtar bg-warning">
                                            <i class="fas fa-ticket-alt"></i>
                                        </div>
                                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Closed')); ?></p>
                                        <h6 class="mb-3"><?php echo e(__('Tickets')); ?></h6>
                                        <h3 class="mb-0"><?php echo e($close_ticket); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="card">
                                    <div class="card-body dash_card_height">
                                        <div class="theme-avtar bg-danger">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total')); ?></p>
                                        <h6 class="mb-3"><?php echo e(__('Agents')); ?></h6>
                                        <h3 class="mb-0"><?php echo e($agents); ?></h3>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-xxl-5">
                        <div class="card">

                            <div class="card-header d-flex justify-content-between">
                                <h5 class=""><?php echo e(__('Storage Status')); ?></h5>
                                <span class="storage"><?php echo e($user->storage_limit); ?> <?php echo e(__('MB')); ?> /
                                    <?php echo e($plan->storage_limit); ?> <?php echo e(__('MB')); ?></span>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-12">
                                        <div id="device-chart"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-7">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo e(__('This Year Tickets')); ?></h5>
                            </div>
                            <div class="card-body">
                                <div id="chartBar"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-5">
                        <div class="card">
                            <div class="card-header">
                                <h5><?php echo e(__('Tickets by Category')); ?></h5>
                            </div>
                            <div class="card-body">
                                <div id="categoryPie"></div>
                            </div>
                        </div>
                    </div>


                    
                <?php endif; ?>

                <?php if(\Auth::user()->type == 'Super Admin'): ?>
                    <div class="col-xxl-7">
                        <div class="row">
                            <div class="col-lg-4 col-4">
                                <div class="card">
                                    <div class="card-body" style="min-height:215px;">
                                        <div class="theme-avtar bg-primary mb-3">
                                            <i class="ti ti-users"></i>
                                        </div>
                                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Paid Users')); ?> : <span
                                                class="text-dark"><?php echo e(number_format($user['total_paid_user'])); ?></span></p>
                                        <h6 class="mb-3"><?php echo e(__('Total Users')); ?></h6>
                                        <h3 class="mb-0"><?php echo e($user['total_user']); ?></h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="card">
                                    <div class="card-body" style="min-height:215px;">
                                        <div class="theme-avtar bg-info mb-3">
                                            <i class="ti ti-shopping-cart-plus"></i>
                                        </div>
                                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total Order Amount')); ?> : <span
                                                class="text-dark"><?php echo e(number_format($user['total_orders_price'])); ?></span>
                                        </p>
                                        <h6 class="mb-2"><?php echo e(__('Total Orders')); ?></h6>
                                        <h3 class="mb-0"><?php echo e($user['total_orders']); ?></h3>

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-4">
                                <div class="card">
                                    <div class="card-body" style="min-height:215px;">
                                        <div class="theme-avtar bg-danger mb-3">
                                            <i class="ti ti-trophy"></i>
                                        </div>
                                        <p class="text-muted text-sm mt-4 mb-2"><?php echo e(__('Total Purchase Plan')); ?> : <span
                                                class="text-dark"><?php echo e(number_format($user['most_purchese_plan'])); ?></span>
                                        </p>
                                        <h6 class="mb-3"><?php echo e(__('Total Plans')); ?></h6>
                                        <h3 class="mb-0"><?php echo e($user['total_plan']); ?></h3>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="col-xxl-5">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between">
                                <h5><?php echo e(__('Recent Order')); ?></h5>
                                <h6 class="last-day-text"><?php echo e(__('Last 7 Days')); ?></h6>
                            </div>
                            <div class="card-body p-1">
                                <div id="chart-sales" height="200" class="p-3"> </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset('assets/js/plugins/apexcharts.min.js')); ?>"></script>

    <script>
        $('.cp_link').on('click', function() {
            var value = $(this).attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(value).select();
            document.execCommand("copy");
            $temp.remove();
            show_toastr('Success', '<?php echo e(__('Link Copy on Clipboard')); ?>', 'success')
        });
    </script>
    <script>
        (function() {
            var chartBarOptions = {
                series: [{
                    name: '<?php echo e(__('Tickets')); ?>',
                    data: <?php echo json_encode(array_values($monthData)); ?>

                }, ],

                chart: {
                    height: 150,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: <?php echo json_encode(array_keys($monthData)); ?>,
                    title: {
                        text: '<?php echo e(__('Months')); ?>'
                    }
                },
                colors: ['#ffa21d', '#FF3A6E'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                markers: {
                    size: 4,
                    colors: ['#ffa21d', '#FF3A6E'],
                    opacity: 0.9,
                    strokeWidth: 2,
                    hover: {
                        size: 7,
                    }
                },
                yaxis: {
                    title: {
                        text: '<?php echo e(__('Tickets')); ?>'
                    },
                    tickAmount: 3,
                    min: 10,
                    max: 70,
                }
            };
            var arChart = new ApexCharts(document.querySelector("#chartBar"), chartBarOptions);
            arChart.render();
        })();
        (function() {
            var categoryPieOptions = {
                chart: {
                    height: 140,
                    type: 'donut',
                },
                dataLabels: {
                    enabled: false,
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                        }
                    }
                },
                series: <?php echo json_encode($chartData['value']); ?>,
                colors: <?php echo json_encode($chartData['color']); ?>,
                labels: <?php echo json_encode($chartData['name']); ?>,
                legend: {
                    show: true
                }
            };
            var categoryPieChart = new ApexCharts(document.querySelector("#categoryPie"), categoryPieOptions);
            categoryPieChart.render();
        })();



        (function() {
            var chartBarOptions = {
                series: [{
                    name: 'Order',
                    data: <?php echo json_encode($chartDatas['data']); ?>,
                }, ],
                chart: {
                    height: 250,
                    type: 'area',
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 10,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                title: {
                    text: '',
                    align: 'left'
                },
                xaxis: {
                    categories: ["15-Jun", "16-Jun", "17-Jun", "18-Jun", "19-Jun", "20-Jun", "21-Jun"],
                    title: {
                        text: ''
                    }
                },
                colors: ['#1260CC'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                yaxis: {
                    title: {
                        text: ''
                    },

                }
            };
            var arChart = new ApexCharts(document.querySelector("#chart-sales"), chartBarOptions);
            arChart.render();
        })();



        (function() {
            var options = {
                series: [<?php echo e($storage_limit); ?>],
                chart: {
                    height: 350,
                    type: 'radialBar',
                    offsetY: -20,
                    sparkline: {
                        enabled: true
                    }
                },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        track: {
                            background: "#e7e7e7",
                            strokeWidth: '97%',
                            margin: 5, // margin is in pixels
                        },
                        dataLabels: {
                            name: {
                                show: true
                            },
                            value: {
                                offsetY: -50,
                                fontSize: '20px'
                            }
                        }
                    }
                },
                grid: {
                    padding: {
                        top: -10
                    }
                },
                colors: ["#6FD943"],
                labels: ['Used'],
            };
            var chart = new ApexCharts(document.querySelector("#device-chart"), options);
            chart.render();
        })();
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/shei/Desktop/splice/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>