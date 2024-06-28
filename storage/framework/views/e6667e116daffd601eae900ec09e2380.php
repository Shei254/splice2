<?php
    $dir = asset(Storage::url('uploads/plan'));
?>
<?php $__env->startPush('scripts'); ?>
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
        function check_theme(color_val) {
            $('#theme_color').prop('checked', false);
            $('input[value="' + color_val + '"]').prop('checked', true);
        }
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300
        })
    </script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script type="text/javascript">
        $(document).ready(function() {

        });

        // $(document).on('click', '.apply-coupon', function(e) {
        //     e.preventDefault();
        //     var where = $(this).attr('data-from');

        //     applyCoupon($('#' + where + '_coupon').val(), where);
        // })

        function applyCoupon(coupon_code, where) {


            if (coupon_code != null && coupon_code != '') {
                $.ajax({
                    url: '<?php echo e(route('apply.coupon')); ?>',
                    datType: 'json',
                    data: {
                        plan_id: '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>',
                        coupon: coupon_code
                    },

                    success: function(data) {
                        if (data.is_success) {
                            $('.' + where + '-coupon-tr').show().find('.' + where + '-coupon-price').text(data
                                .discount_price);
                            $('.' + where + '-final-price').text(data.final_price);
                            show_toastr('success', data.message, 'success');

                        } else {
                            $('.' + where + '-coupon-tr').hide().find('.' + where + '-coupon-price').text('');
                            $('.' + where + '-final-price').text(data.final_price);
                            show_toastr('Error', data.message, 'error');
                        }
                    }
                })
            } else {
                show_toastr('Error', '<?php echo e(__('Invalid Coupon Code.')); ?>', 'error');
                $('.' + where + '-coupon-tr').hide().find('.' + where + '-coupon-price').text('');
            }
        }
    </script>

    <script type="text/javascript">
        <?php if(isset($admin_payment_setting['is_stripe_enabled']) &&
                $admin_payment_setting['is_stripe_enabled'] == 'on' &&
                !empty($admin_payment_setting['stripe_key']) &&
                !empty($admin_payment_setting['stripe_secret'])): ?>

            var stripe = Stripe('<?php echo e($admin_payment_setting['stripe_key']); ?>');
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    // Add your base input styles here. For example:
                    fontSize: '14px',
                    color: '#32325d',
                },
            };

            // Create an instance of the card Element.
            var card = elements.create('card', {
                style: style
            });

            // Add an instance of the card Element into the `card-element` <div>.
            card.mount('#card-element');

            // Create a token or display an error when the form is submitted.
            var form = document.getElementById('payment-form');

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                stripe.createToken(card).then(function(result) {
                    if (result.error) {
                        $("#card-errors").html(result.error.message);
                        toastrs('Error', result.error.message, 'error');
                    } else {
                        // Send the token to your server.
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                // Submit the form
                form.submit();
            }
        <?php endif; ?>



        $(document).ready(function() {
            $(document).on('click', '.apply-coupon', function() {
                // alert('hello')

                var ele = $(this);
                var coupon = ele.closest('.row').find('.coupon').val();

                $.ajax({
                    url: '<?php echo e(route('apply.coupon')); ?>',
                    datType: 'json',
                    data: {
                        plan_id: '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>',
                        coupon: coupon
                    },
                    // alert(data)
                    success: function(data) {
                        $('.final-price').text(data.final_price);
                        console.log(data)
                        $('#stripe_coupon, #paypal_coupon').val(coupon);
                        if (data != '') {
                            if (data.is_success == true) {
                                show_toastr('success', data.message, 'success');
                            } else {
                                show_toastr('Error', data.message, 'error');
                            }

                        } else {
                            show_toastr('Error', "<?php echo e(__('Coupon code required.')); ?>", 'error');
                        }
                    }
                })
            });
        });
    </script>
    <script>
        $(document).ready(function(e) {
            get_payfast_status(amount = 0, coupon = null);
        })

        $("#payfast_coupon_submit").click(function() {
            var amount = "<?php echo e($plan->price); ?>"
            var coupon = $('#payfast_coupon').val();

            get_payfast_status(amount, coupon);
        });

        function get_payfast_status(amount, coupon) {
            var plan_id = '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>';

            if (amount != 0.00 && coupon != null) {

                var currency_symbol = '<?php echo e($admin_payment_setting['currency_symbol']); ?>';

                $.ajax({
                    url: '<?php echo e(route('payfast.payment')); ?>',
                    method: 'POST',
                    data: {
                        'plan_id': plan_id,
                        'coupon_amount': amount,
                        'coupon_code': coupon,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.success == true) {
                            $("#get-payfast-inputs").empty();
                            $('#get-payfast-inputs').append(data.inputs);
                            $('.payfast-coupon-tr').show();
                            $('.payfast-coupon-price').text($("input[name='amount']").val() - amount);
                            $('.payfast-final-price').text(currency_symbol + $("input[name='amount']").val());
                        } else {
                            show_toastr('error', data.inputs)
                        }
                        setTimeout(() => {
                            toastrs('<?php echo e(__('Success')); ?>', data.msg, 'success');
                            window.location.href = "<?php echo e(route('plan.index')); ?>";
                        }, 2000);
                    }
                });
            } else {

                $.ajax({
                    url: '<?php echo e(route('payfast.payment')); ?>',
                    method: 'POST',
                    data: {
                        'plan_id': plan_id,
                        'coupon_amount': amount,
                        'coupon_code': coupon,
                    },

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {

                        if (data.success == true) {
                            $('#get-payfast-inputs').append(data.inputs);
                        } else {
                            show_toastr('error', data.inputs)
                        }
                    }
                });
            }
        }
    </script>
    <script>
        <?php if(isset($admin_payment_setting['paystack_public_key'])): ?>


            $(document).on("click", "#pay_with_paystack", function() {
                $('#paystack-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {
                        var paystack_callback = "<?php echo e(url('/plan/paystack')); ?>";
                        var order_id = '<?php echo e(time()); ?>';
                        var coupon_id = res.coupon;
                        var handler = PaystackPop.setup({
                            key: '<?php echo e($admin_payment_setting['paystack_public_key']); ?>',
                            email: res.email,
                            amount: res.total_price * 100,
                            currency: 'NGN',
                            ref: 'pay_ref_id' + Math.floor((Math.random() * 1000000000) +
                                1
                            ), // generates a pseudo-unique reference. Please replace with a reference you generated. Or remove the line entirely so our API will generate one for you
                            metadata: {
                                custom_fields: [{
                                    display_name: "Email",
                                    variable_name: "email",
                                    value: res.email,
                                }]
                            },

                            callback: function(response) {
                                console.log(response.reference, order_id);
                                window.location.href = paystack_callback + '/' + response
                                    .reference + '/' + '<?php echo e(encrypt($plan->id)); ?>' +
                                    '?coupon_id=' + coupon_id
                            },
                            onClose: function() {
                                alert('window closed');
                            }
                        });
                        handler.openIframe();
                    } else if (res.flag == 2) {

                    }

                }).submit();
            });
        <?php endif; ?>
    </script>

    <?php if(
        !empty($admin_payment_setting['is_flutterwave_enabled']) &&
            isset($admin_payment_setting['is_flutterwave_enabled']) &&
            $admin_payment_setting['is_flutterwave_enabled'] == 'on'): ?>
        <script src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>

        <script>
            //    Flaterwave Payment
            $(document).on("click", "#pay_with_flaterwave", function() {

                $('#flaterwave-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {
                        var coupon_id = res.coupon;
                        var API_publicKey = '';
                        if ("<?php echo e(isset($admin_payment_setting['flutterwave_public_key'])); ?>") {
                            API_publicKey = "<?php echo e($admin_payment_setting['flutterwave_public_key']); ?>";
                        }
                        var nowTim = "<?php echo e(date('d-m-Y-h-i-a')); ?>";
                        var flutter_callback = "<?php echo e(url('/plan/flaterwave')); ?>";
                        var x = getpaidSetup({
                            PBFPubKey: API_publicKey,
                            customer_email: '<?php echo e(Auth::user()->email); ?>',
                            amount: res.total_price,
                            currency: res.currency,
                            txref: nowTim + '__' + Math.floor((Math.random() * 1000000000)) +
                                'fluttpay_online-' +
                                <?php echo e(date('Y-m-d')); ?>,
                            meta: [{
                                metaname: "payment_id",
                                metavalue: "id"
                            }],
                            onclose: function() {},
                            callback: function(response) {
                                var txref = response.tx.txRef;
                                if (
                                    response.tx.chargeResponseCode == "00" ||
                                    response.tx.chargeResponseCode == "0"
                                ) {
                                    window.location.href = flutter_callback + '/' + txref + '/' +
                                        '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>?coupon_id=' +
                                        coupon_id + '&payment_frequency=' + res.payment_frequency;
                                } else {
                                    // redirect to a failure page.
                                }
                                x.close(); // use this to close the modal immediately after payment.
                            }
                        });
                    } else if (res.flag == 2) {

                    } else {
                        show_toastr('Error', data.message, 'msg');
                    }

                }).submit();
            });
        </script>
    <?php endif; ?>

    <?php if(
        !empty($admin_payment_setting['is_razorpay_enabled']) &&
            isset($admin_payment_setting['is_razorpay_enabled']) &&
            $admin_payment_setting['is_razorpay_enabled'] == 'on'): ?>
        <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
        <script>
            // Razorpay Payment

            $(document).on("click", "#pay_with_razorpay", function() {
                $('#razorpay-payment-form').ajaxForm(function(res) {
                    if (res.flag == 1) {

                        var razorPay_callback = '<?php echo e(url('/plan/razorpay')); ?>';
                        var totalAmount = res.total_price * 100;
                        var coupon_id = res.coupon;
                        var API_publicKey = '';
                        if ("<?php echo e(isset($admin_payment_setting['razorpay_public_key'])); ?>") {
                            API_publicKey = "<?php echo e($admin_payment_setting['razorpay_public_key']); ?>";
                        }
                        var options = {
                            "key": API_publicKey, // your Razorpay Key Id
                            "amount": totalAmount,
                            "name": 'Plan',
                            "currency": res.currency,
                            "description": "",
                            "handler": function(response) {
                                window.location.href = razorPay_callback + '/' + response
                                    .razorpay_payment_id + '/' +
                                    '<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>?coupon_id=' +
                                    coupon_id + '&payment_frequency=' + res.payment_frequency;
                            },
                            "theme": {
                                "color": "#528FF0"
                            }
                        };
                        var rzp1 = new Razorpay(options);
                        rzp1.open();
                    } else if (res.flag == 2) {

                    } else {
                        show_toastr('Error', data.message, 'msg');
                    }

                }).submit();
            });
        </script>
    <?php endif; ?>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js"
        integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script>
<?php $__env->stopPush(); ?>

<?php
    $dir = asset(Storage::url('uploads/plan'));
    $dir_payment = asset(Storage::url('uploads/payments'));
?>

<?php $__env->startSection('page-title'); ?>
    <?php echo e(__('Order Summary')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>"><?php echo e(__('Home')); ?></a></li>
    <li class="breadcrumb-item"><a href="<?php echo e(route('plan.index')); ?>"><?php echo e(__('Plan')); ?></a></li>
    <li class="breadcrumb-item"><?php echo e(__('Order Summary')); ?></li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('action-btn'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
            <div class="row">
                <div class="col-xl-3">
                    <div class=" sticky-top" style="top:30px">

                        <div class="card">

                            <div class="list-group list-group-flush " id="useradd-sidenav">

                                <?php if(isset($admin_payment_setting['is_manually_enabled']) && $admin_payment_setting['is_manually_enabled'] == 'on'): ?>
                                    <a href="#useradd-14"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Manually')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_banktransfer_enabled']) &&
                                        $admin_payment_setting['is_banktransfer_enabled'] == 'on'): ?>
                                    <a href="#useradd-15"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Banktransfer')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_stripe_enabled']) && $admin_payment_setting['is_stripe_enabled'] == 'on'): ?>
                                    <a href="#useradd-1"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Stripe')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_paypal_enabled']) && $admin_payment_setting['is_paypal_enabled'] == 'on'): ?>
                                    <a href="#useradd-2"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Paypal')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_paystack_enabled']) && $admin_payment_setting['is_paystack_enabled'] == 'on'): ?>
                                    <a href="#useradd-3"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Paystack')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on'): ?>
                                    <a href="#useradd-4"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Flutterwave')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on'): ?>
                                    <a href="#useradd-5"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Razorpay')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on'): ?>
                                    <a href="#useradd-6"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Paytm')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on'): ?>
                                    <a href="#useradd-7"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Mercado Pago')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on'): ?>
                                    <a href="#useradd-8"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Mollie')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on'): ?>
                                    <a href="#useradd-9"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Skrill')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on'): ?>
                                    <a href="#useradd-10"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Coingate')); ?> <div
                                            class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_paymentwall_enabled']) && $admin_payment_setting['is_paymentwall_enabled'] == 'on'): ?>
                                    <a href="#useradd-11"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('PaymentWall')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_toyyibpay_enabled']) && $admin_payment_setting['is_toyyibpay_enabled'] == 'on'): ?>
                                    <a href="#useradd-12"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Toyyibpay')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_payfast_enabled']) && $admin_payment_setting['is_payfast_enabled'] == 'on'): ?>
                                    <a href="#useradd-13"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Payfast')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>
                                <?php if(isset($admin_payment_setting['is_iyzipay_enabled']) && $admin_payment_setting['is_iyzipay_enabled'] == 'on'): ?>
                                    <a href="#useradd-16"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Iyzipay')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_sspay_enabled']) && $admin_payment_setting['is_sspay_enabled'] == 'on'): ?>
                                    <a href="#useradd-17"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Sspay')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_paytab_enabled']) && $admin_payment_setting['is_paytab_enabled'] == 'on'): ?>
                                    <a href="#useradd-18"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Paytab')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_benefit_enabled']) && $admin_payment_setting['is_benefit_enabled'] == 'on'): ?>
                                    <a href="#useradd-19"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Benefit')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_cashefree_enabled']) && $admin_payment_setting['is_cashefree_enabled'] == 'on'): ?>
                                    <a href="#useradd-20"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('CasheFree')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_aamarpay_enabled']) && $admin_payment_setting['is_aamarpay_enabled'] == 'on'): ?>
                                    <a href="#useradd-21"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Aamarpay')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_paytr_enabled']) && $admin_payment_setting['is_paytr_enabled'] == 'on'): ?>
                                    <a href="#useradd-22"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Paytr')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_yookassa_enabled']) && $admin_payment_setting['is_yookassa_enabled'] == 'on'): ?>
                                    <a href="#useradd-23"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Yookassa')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_midtrans_enabled']) && $admin_payment_setting['is_midtrans_enabled'] == 'on'): ?>
                                    <a href="#useradd-24"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Midtrans')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_xendit_enabled']) && $admin_payment_setting['is_xendit_enabled'] == 'on'): ?>
                                    <a href="#useradd-25"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Xendit')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_paiementpro_enabled']) && $admin_payment_setting['is_paiementpro_enabled'] == 'on'): ?>
                                    <a href="#useradd-26"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Paiement Pro')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>


                                <?php if(isset($admin_payment_setting['is_nepalste_enabled']) &&
                                        $admin_payment_setting['is_nepalste_enabled'] == 'on' &&
                                        !empty($admin_payment_setting['nepalste_public_key']) &&
                                        !empty($admin_payment_setting['nepalste_secret_key'])): ?>
                                    <a href="#useradd-27"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Nepalste')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_fedapay_enabled']) &&
                                $admin_payment_setting['is_fedapay_enabled'] == 'on' &&
                                !empty($admin_payment_setting['fedapay_secret_key']) &&
                                !empty($admin_payment_setting['fedapay_public_key'])): ?>
                                    <a href="#useradd-28"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Fedapay')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_cinetpay_enabled']) &&
                                $admin_payment_setting['is_cinetpay_enabled'] == 'on' &&
                                !empty($admin_payment_setting['cinetpay_api_key']) &&
                                !empty($admin_payment_setting['cinetpay_site_id']) &&
                                !empty($admin_payment_setting['cinetpay_secret_key'])): ?>
                                    <a href="#useradd-29"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Cinetpay')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>

                                <?php if(isset($admin_payment_setting['is_payhere_enabled']) &&
                                $admin_payment_setting['is_payhere_enabled'] == 'on' &&
                                !empty($admin_payment_setting['payhere_merchant_id']) &&
                                !empty($admin_payment_setting['payhere_merchant_secret_key']) &&
                                !empty($admin_payment_setting['payhere_app_secret_key']) &&
                                !empty($admin_payment_setting['payhere_app_id'])): ?>
                                    <a href="#useradd-30"
                                        class="list-group-item list-group-item-action border-0"><?php echo e(__('Payhere')); ?>

                                        <div class="float-end"><i class="ti ti-chevron-right"></i></div>
                                    </a>
                                <?php endif; ?>



                            </div>
                        </div>

                        <div class="card price-card price-1 wow animate__fadeInUp " data-wow-delay="0.2s"
                            style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <div class="card-body">
                                <span class="price-badge bg-primary"><?php echo e($plan->name); ?></span>

                                <span
                                    class="mb-4 f-w-600 p-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e(number_format($plan->price)); ?><small
                                        class="text-sm">/ <?php echo e($plan->duration); ?></small></span>
                                <p class="mb-0">
                                    <?php echo e($plan->name); ?> <?php echo e(__('Plan')); ?>

                                </p>
                                <?php if($plan->description): ?>
                                    <p class="mb-0">
                                        <?php echo e($plan->description); ?><br />
                                    </p>
                                <?php endif; ?>


                                <ul class="list-unstyled d-inline-block my-5">
                                    <li>
                                        <span class="theme-avtar">
                                            <i class="text-primary ti ti-circle-plus"></i></span>
                                        <?php echo e($plan->max_agent < 0 ? __('Unlimited') : $plan->max_agent); ?>

                                        <?php echo e(__('Agent')); ?>

                                    </li>
                                    <?php if($plan->storage_limit == '-1'): ?>
                                        <li class="d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i class="text-primary ti ti-circle-plus"></i></span><?php echo e(__('Unlimited')); ?>

                                        </li>
                                    <?php else: ?>
                                        <li class="d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i
                                                    class="text-primary ti ti-circle-plus"></i></span><?php echo e($plan->storage_limit); ?>

                                            <?php echo e(__(' MB Storage')); ?>

                                        </li>
                                    <?php endif; ?>
                                    <?php if($plan->enable_custdomain == 'on'): ?>
                                        <li class="d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i
                                                    class="text-primary ti ti-circle-plus"></i></span><?php echo e(__('Custom Domain')); ?>

                                        </li>
                                    <?php else: ?>
                                        <li class="text-danger d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i
                                                    class="text-danger ti ti-circle-plus"></i></span><?php echo e(__('Custom Domain')); ?>

                                        </li>
                                    <?php endif; ?>
                                    <?php if($plan->enable_custsubdomain == 'on'): ?>
                                        <li class="d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i
                                                    class="text-primary ti ti-circle-plus"></i></span><?php echo e(__('Sub Domain')); ?>

                                        </li>
                                    <?php else: ?>
                                        <li class="text-danger d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i class="text-danger ti ti-circle-plus"></i></span><?php echo e(__('Sub Domain')); ?>

                                        </li>
                                    <?php endif; ?>
                                    <?php if($plan->enable_chatgpt == 'on'): ?>
                                        <li class="d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i class="text-primary ti ti-circle-plus"></i></span><?php echo e(__('Chatgpt')); ?>

                                        </li>
                                    <?php else: ?>
                                        <li class="text-danger d-flex align-items-center">
                                            <span class="theme-avtar">
                                                <i class="text-danger ti ti-circle-plus"></i></span><?php echo e(__('Chatgpt')); ?>

                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="col-xl-9">

                    <?php if(isset($admin_payment_setting['is_manually_enabled']) && $admin_payment_setting['is_manually_enabled'] == 'on'): ?>
                        <div id="useradd-14" class="card">
                            <div class="card-header">
                                <h5 class=" h6 mb-0"><?php echo e(__('Manually')); ?></h5>
                            </div>
                            <div class="card-body">
                                <form role="form"
                                    action="<?php echo e(route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])); ?>"
                                    method="post">
                                    <?php echo csrf_field(); ?>
                                    <div class="border p-3 rounded stripe-payment-div">
                                        <div class="row">
                                            <div class="col-sm-8">
                                                <div class="custom-radio">
                                                    <label
                                                        class="font-weight-bold"><?php echo e(__('Requesting manual payment for the planned amount for the subscriptions plan.')); ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 px-2">
                                        <div class="text-end">
                                            <?php if(\Auth::user()->requested_plan != $plan->id): ?>
                                                <a href="<?php echo e(route('send.request', [\Illuminate\Support\Facades\Crypt::encrypt($plan->id)])); ?>"
                                                    class="btn btn-primary btn-icon"
                                                    data-title="<?php echo e(__('Send Request')); ?>"
                                                    title="<?php echo e(__('Send Request')); ?>" data-bs-toggle="tooltip">
                                                    <span class="btn-inner--icon"><i
                                                            class="mdi mdi-cash-multiple mr-1"></i><?php echo e(__('Send Request')); ?></span>
                                                </a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('request.cancel', \Auth::user()->id)); ?>"
                                                    class="btn btn-danger btn-icon"
                                                    data-title="<?php echo e(__('Cancle Request')); ?>"
                                                    title="<?php echo e(__('Cancle Request')); ?>" data-bs-toggle="tooltip">
                                                    <span class="btn-inner--icon"><i
                                                            class="mdi mdi-cash-multiple mr-1"></i><?php echo e(__('Cancel Request')); ?></span>
                                                </a>
                                            <?php endif; ?>
                                        </div>

                                    </div>


                                </form>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_banktransfer_enabled']) &&
                            $admin_payment_setting['is_banktransfer_enabled'] == 'on'): ?>
                        <div id="useradd-15" class="card">
                            <form role="form" action="<?php echo e(route('plan.pay.with.banktransfer')); ?>" method="post"
                                enctype="multipart/form-data" id="banktransfer-payment-form"
                                class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5 class=" h6 mb-0"><?php echo e(__('Banktransfer')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-4">
                                        <div class="col-md-6 mt-3">
                                            <div class="form-group">
                                                <?php if(isset($admin_payment_setting['bank_details']) && !empty($admin_payment_setting['bank_details'])): ?>
                                                    <?php echo $admin_payment_setting['bank_details']; ?>

                                                <?php endif; ?>
                                            </div>

                                        </div>

                                        <div class="col-6">
                                            <?php echo e(Form::label('payment_receipt', __('Payment Receipt'), ['class' => 'form-label'])); ?>

                                            <div class="choose-file form-group">
                                                

                                                <input type="file" name="payment_receipt" id="file"
                                                    class="form-control">


                                                <p class="upload_file"></p>
                                            </div>
                                        </div>


                                        <div class="row mt-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="banktransfer_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="banktransfer_coupon" name="coupon"
                                                        class="form-control coupon" data-from="banktransfer"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-auto coupon-apply-btn">
                                                <div class="form-group apply-banktransfer-btn-coupon pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="banktransfer"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            


                                            <div class="row">
                                                <div class="col-6 ">
                                                    <div class="custom-radio">
                                                        <label class="font-16 font-bold"><?php echo e(__('Plan Price')); ?> :</label>
                                                        <?php echo e(env('CURRENCY_SYMBOL') ? env('CURRENCY_SYMBOL') : '$'); ?><?php echo e($plan->price); ?></small>
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="custom-radio">
                                                        <label class="font-16 font-bold"><?php echo e(__('Net Amount')); ?> :
                                                        </label>
                                                        <span
                                                            class="final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>
                                                    </div>
                                                    (<small class=""><?php echo e(__('After coupon apply')); ?></small>)
                                                </div>

                                            </div>
                                            <div class="mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_banktransfer">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="banktransfer-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div>

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($admin_payment_setting['is_stripe_enabled']) && $admin_payment_setting['is_stripe_enabled'] == 'on'): ?>
                        <div id="useradd-1" class="card">
                            <div class="card-header">
                                <h5 class=" h6 mb-0"><?php echo e(__('Pay Using Stripe')); ?></h5>
                            </div>
                            <div class="card-body">
                                <form role="form" action="<?php echo e(route('stripe.post')); ?>" method="post"
                                    class="require-validation" id="payment-form">
                                    <?php echo csrf_field(); ?>
                                    <div class="mb-3 rounded stripe-payment-div">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="card-name-on"
                                                        class="form-label"><?php echo e(__('Name on card')); ?></label>
                                                    <input type="text" name="name" id="card-name-on"
                                                        class="form-control"
                                                        placeholder="<?php echo e(\Auth::user()->name); ?>"required22>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div id="card-element"></div>
                                                <div id="card-errors" role="alert"></div>
                                            </div>
                                            <div class="col-md-10">
                                                <br>
                                                <div class="form-group">
                                                    <label class="form-label" for="stripe_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="stripe_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn mt-5">
                                                <div class="form-group apply-stripe-btn-coupon">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary coupon-apply-btn apply-coupon btn-m"
                                                        data-from="stripe"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-end">
                                        <input type="hidden" name="plan_id"
                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                        <button type="submit" class="btn btn-primary"><i
                                                class="mdi mdi-cash-multiple mr-1"></i><?php echo e(__('Pay Now')); ?> (<span
                                                class="paypal-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($admin_payment_setting['is_paypal_enabled']) && $admin_payment_setting['is_paypal_enabled'] == 'on'): ?>
                        <div id="useradd-2" class="card">
                            <form class="w3-container w3-display-middle w3-card-4" method="POST"
                                id="paypal-payment-form" action="<?php echo e(route('plan.pay.with.paypal')); ?>">
                                <?php echo csrf_field(); ?> <div class="card-header">
                                    <h5><?php echo e(__('Paypal')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Details about your plan paypal payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label class="form-label" for="paypal_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paypal_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>


                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group apply-paypal-btn-coupon pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="paypal"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paypal-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="paypal-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="paypal-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_paystack_enabled']) && $admin_payment_setting['is_paystack_enabled'] == 'on'): ?>
                        <div id="useradd-3" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.paystack')); ?>" method="post"
                                id="paystack-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Paystack')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Paystack payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="paystack_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paystack_coupon" name="coupon"
                                                        class="form-control coupon" data-from="paystack"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-auto coupon-apply-btn">
                                                <div class="form-group apply-paystack-btn-coupon pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="paystack"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paystack-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="paystack-coupon-price"></b>
                                            </div>
                                            <div class="mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_paystack">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="paystack-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_flutterwave_enabled']) && $admin_payment_setting['is_flutterwave_enabled'] == 'on'): ?>
                        <div id="useradd-4" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.flaterwave')); ?>" method="post"
                                class="w3-container w3-display-middle w3-card-4" id="flaterwave-payment-form">
                                <?php echo csrf_field(); ?> <div class="card-header">
                                    <h5><?php echo e(__('Flutterwave')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Flutterwave payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="flaterwave_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="flaterwave_coupon" name="coupon"
                                                        class="form-control coupon" data-from="flaterwave"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 applyCoupon coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="flaterwave"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>

                                            

                                            <div class="col-12 text-right flaterwave-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="flaterwave-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_flaterwave">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="flaterwave-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_razorpay_enabled']) && $admin_payment_setting['is_razorpay_enabled'] == 'on'): ?>
                        <div id="useradd-5" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.razorpay')); ?>" method="post"
                                class="w3-container w3-display-middle w3-card-4" id="razorpay-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Razorpay')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Razorpay payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="razorpay_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="razorpay_coupon" name="coupon"
                                                        class="form-control coupon" data-from="razorpay"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="razorpay"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right razorpay-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="razorpay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_razorpay">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="razorpay-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_paytm_enabled']) && $admin_payment_setting['is_paytm_enabled'] == 'on'): ?>
                        <div id="useradd-6" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.paytm')); ?>" method="POST"
                                class="w3-container w3-display-middle w3-card-4" id="paytm-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Paytm')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Details about your plan Paytm payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="paytm_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Mobile Number')); ?></label>
                                                    <input type="text" id="mobile" name="mobile"
                                                        class="form-control mobile" data-from="mobile"
                                                        placeholder="<?php echo e(__('Enter Mobile Number')); ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <label for="paytm_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paytm_coupon" name="coupon"
                                                        class="form-control coupon" data-from="paytm"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="paytm"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paytm-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="paytm-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_paytm">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="paytm-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_mercado_enabled']) && $admin_payment_setting['is_mercado_enabled'] == 'on'): ?>
                        <div id="useradd-7" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.mercado')); ?>" method="post"
                                class="w3-container w3-display-middle w3-card-4" id="mercado-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Mercado Pago')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Mercado Pago payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="mercado_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="mercado_coupon" name="coupon"
                                                        class="form-control coupon" data-from="mercado"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="mercado"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right mercado-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="mercado-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_paytm">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="mercado-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_mollie_enabled']) && $admin_payment_setting['is_mollie_enabled'] == 'on'): ?>
                        <div id="useradd-8" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.mollie')); ?>" method="post"
                                class="w3-container w3-display-middle w3-card-4" id="mollie-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Mollie')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Details about your plan Mollie payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="mollie_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="mollie_coupon" name="coupon"
                                                        class="form-control coupon" data-from="mollie"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="mollie"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right mollie-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="mollie-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_mollie">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="mollie-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_skrill_enabled']) && $admin_payment_setting['is_skrill_enabled'] == 'on'): ?>
                        <div id="useradd-9" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.skrill')); ?>" method="post"
                                class="w3-container w3-display-middle w3-card-4" id="skrill-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Skrill')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Details about your plan Skrill payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="skrill_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="skrill_coupon" name="coupon"
                                                        class="form-control coupon" data-from="skrill"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="skrill"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right skrill-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="skrill-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_skrill">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="skrill-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                            $skrill_data = [
                                                'transaction_id' => md5(
                                                    date('Y-m-d') . strtotime('Y-m-d H:i:s') . 'user_id',
                                                ),
                                                'user_id' => 'user_id',
                                                'amount' => 'amount',
                                                'currency' => 'currency',
                                            ];
                                            session()->put('skrill_data', $skrill_data);
                                        ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_coingate_enabled']) && $admin_payment_setting['is_coingate_enabled'] == 'on'): ?>
                        <div id="useradd-10" class="card ">
                            <form role="form" action="<?php echo e(route('plan.pay.with.coingate')); ?>" method="post"
                                class="w3-container w3-display-middle w3-card-4" id="coingate-payment-form">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Coingate')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Coingate payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="coingate_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="coingate_coupon" name="coupon"
                                                        class="form-control coupon" data-from="coingate"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="coingate"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right coingate-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="coingate-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_coingate">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="coingate-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_paymentwall_enabled']) && $admin_payment_setting['is_paymentwall_enabled'] == 'on'): ?>
                        <div id="useradd-11" class="card ">
                            <form role="form" action="<?php echo e(route('paymentwall')); ?>" method="post"
                                id="paymentwall-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('PaymentWall')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan PaymentWall payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paymentwall_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paymentwall_coupon" name="coupon"
                                                        class="form-control coupon" data-from="paymentwall"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group apply-paymentwall-btn-coupon">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="paymentwall"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paymentwall-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="paymentwall-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_paymentwall">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="paymentwall-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)</button>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_toyyibpay_enabled']) && $admin_payment_setting['is_toyyibpay_enabled'] == 'on'): ?>
                        <div id="useradd-12" class="card">
                            <form role="form" action="<?php echo e(route('plan.pay.with.toyyibpay')); ?>" method="post"
                                id="toyyibpay-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Toyyibpay')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Toyyibpay payment')); ?></small>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="toyyibpay_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="toyyibpay_coupon" name="coupon"
                                                        class="form-control coupon" data-from="toyyibpay"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="toyyibpay"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right toyyibpay-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="toyyibpay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_toyyibpay">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="toyyibpay-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_payfast_enabled']) && $admin_payment_setting['is_payfast_enabled'] == 'on'): ?>
                        <div id="useradd-13" class="card">
                            <div class="card-header">
                                <h5><?php echo e(__('Payfast')); ?></h5>
                            </div>

                            <?php if(
                                $admin_payment_setting['is_payfast_enabled'] == 'on' &&
                                    !empty($admin_payment_setting['payfast_merchant_id']) &&
                                    !empty($admin_payment_setting['payfast_merchant_key']) &&
                                    !empty($admin_payment_setting['payfast_signature']) &&
                                    !empty($admin_payment_setting['payfast_mode'])): ?>
                                <div
                                    <?php echo e(($admin_payment_setting['is_payfast_enabled'] == 'on' && !empty($admin_payment_setting['payfast_merchant_id']) && !empty($admin_payment_setting['payfast_merchant_key'])) == 'on' ? 'active' : ''); ?>>
                                    <?php
                                        $pfHost =
                                            $admin_payment_setting['payfast_mode'] == 'sandbox'
                                                ? 'sandbox.payfast.co.za'
                                                : 'www.payfast.co.za';
                                    ?>


                                    <form role="form" action=<?php echo e('https://' . $pfHost . '/eng/process'); ?>

                                        method="post" class="require-validation" id="payfast-form">
                                        <div class="border p-3 rounded-0">

                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="payfast_coupon"
                                                            class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                        <input type="text" id="payfast_coupon" name="coupon"
                                                            class="form-control coupon" data-from="payfast"
                                                            placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group pt-3 mt-3">

                                                        <a href="javascript:void(0)" id="payfast_coupon_submit"
                                                            class="btn btn-primary align-items-center apply-coupon"
                                                            data-from="payfast"><?php echo e(__('Apply')); ?></a>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right payfast-coupon-tr" style="display: none">
                                                    <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                        class="payfast-coupon-price"></b>
                                                </div>

                                                <div id="get-payfast-inputs"></div>
                                                <div class="row mt-2">
                                                    <div class="col-sm-12">
                                                        <div class="float-end">
                                                            <input type="hidden" name="plan_id" id="plan_id"
                                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                            <button class="btn btn-primary d-flex align-items-center"
                                                                type="submit" id="pay_with_payfast">
                                                                <i class="mdi mdi-cash-multiple mr-1"></i>
                                                                <?php echo e(__('Pay Now')); ?>

                                                                (<span
                                                                    class="payfast-final-price"><?php echo e($admin_payment_setting['currency_symbol']); ?><?php echo e($plan->price); ?></span>)
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_iyzipay_enabled']) && $admin_payment_setting['is_iyzipay_enabled'] == 'on'): ?>
                        <div id="useradd-16" class="card">


                            <form role="form" action="<?php echo e(route('iyzipay.payment.init')); ?>" method="POST"
                                class="w3-container w3-display-middle w3-card-4" id="paytm-payment-form">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('Iyzipay')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="coingate_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="coingate_coupon" name="coupon"
                                                        class="form-control coupon" data-from="coingate"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="coingate"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right coingate-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="coingate-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_coingate">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="coingate-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($admin_payment_setting['is_sspay_enabled']) && $admin_payment_setting['is_sspay_enabled'] == 'on'): ?>
                        <div id="useradd-17" class="card">


                            <form role="form" action="<?php echo e(route('sspay.prepare.plan')); ?>" method="POST"
                                class="w3-container w3-display-middle w3-card-4" id="paytm-payment-form">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('Sspay')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="sspay_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="sspay_coupon" name="coupon"
                                                        class="form-control coupon" data-from="sspay"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="sspay"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right sspay-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="sspay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_sspay">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="sspay-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_paytab_enabled']) && $admin_payment_setting['is_paytab_enabled'] == 'on'): ?>
                        <div id="useradd-18" class="card">
                            <form role="form" action="<?php echo e(route('plan.pay.with.paytab')); ?>" method="post"
                                id="paytab-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('Paytab')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Details about your plan Paytab payment')); ?></small>
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="paytab_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paytab_coupon" name="coupon"
                                                        class="form-control coupon" data-from="paytab"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="paytab"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paytab-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="paytab-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_paytab">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="paytab-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($admin_payment_setting['is_benefit_enabled']) && $admin_payment_setting['is_benefit_enabled'] == 'on'): ?>
                        <div id="useradd-19" class="card">
                            <form role="form" action="<?php echo e(route('benefit.initiate')); ?>" method="post"
                                id="paytab-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('Benefit')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Details about your plan Benift payment')); ?></small>
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="cashefree_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="benefit_coupon" name="coupon"
                                                        class="form-control coupon" data-from="benefit"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="benefit"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right benefit-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="benefit-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_benefit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="benefit-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_cashefree_enabled']) && $admin_payment_setting['is_cashefree_enabled'] == 'on'): ?>
                        <div id="useradd-20" class="card">
                            <form role="form" action="<?php echo e(route('cashfree.payment')); ?>" method="post"
                                id="cashfree-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('CasheFree')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Cashefree payment')); ?></small>
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="cashefree_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="cashefree_coupon" name="coupon"
                                                        class="form-control coupon" data-from="cashefree"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="cashefree"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right cashefree-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="cashefree-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_cashefree">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="cashefree-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_aamarpay_enabled']) && $admin_payment_setting['is_aamarpay_enabled'] == 'on'): ?>
                        <div id="useradd-21" class="card">
                            <form role="form" action="<?php echo e(route('pay.aamarpay.payment')); ?>" method="post"
                                id="paytab-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('Aamarpay')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Aamarpay payment')); ?></small>
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="aamarpay_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="aamarpay_coupon" name="coupon"
                                                        class="form-control coupon" data-from="aamarpay"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="aamarpay"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right aamarpay-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="aamarpay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_aamarpay">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="aamarpay-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_paytr_enabled']) && $admin_payment_setting['is_paytr_enabled'] == 'on'): ?>
                        <div id="useradd-22" class="card">
                            <form role="form" action="<?php echo e(route('pay.paytr.payment')); ?>" method="post"
                                id="paytr-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('Paytr')); ?></h5>
                                    <small class="text-muted"><?php echo e(__('Details about your plan Paytr payment')); ?></small>
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="paytr_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paytr_coupon" name="coupon"
                                                        class="form-control coupon" data-from="paytr"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="paytr"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paytr-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b class="paytr-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_paytr">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="paytr-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($admin_payment_setting['is_yookassa_enabled']) && $admin_payment_setting['is_yookassa_enabled'] == 'on'): ?>
                        <div id="useradd-23" class="card">
                            <form role="form" action="<?php echo e(route('plan.pay.with.yookassa')); ?>" method="get"
                                id="yookassa-payment-form" class="w3-container w3-display-middle w3-card-4">
                                <?php echo csrf_field(); ?>

                                <div class="card-header">
                                    <h5><?php echo e(__('Yookassa')); ?></h5>
                                    <small
                                        class="text-muted"><?php echo e(__('Details about your plan Yookassa payment')); ?></small>
                                </div>
                                <div class="card-body">

                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-10">
                                                <div class="form-group">
                                                    <label for="yookassa_coupon"
                                                        class="form-label text-dark"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="yookassa_coupon" name="coupon"
                                                        class="form-control coupon" data-from="yookassa"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>

                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group pt-3 mt-3">
                                                    <a href="javascript:;"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="yookassa"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right yookassa-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="yookassa-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit" id="pay_with_yookassa">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?> (<span
                                                                class="yookassa-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_midtrans_enabled']) && $admin_payment_setting['is_midtrans_enabled'] == 'on'): ?>
                        <div id="useradd-24" class="card  shadow-none rounded-0 border-bottom ">
                            <form class="w3-container w3-display-middle w3-card-4" method="get"
                                id="midtrans-payment-form" action="<?php echo e(route('plan.get.midtrans')); ?>">
                                <?php echo csrf_field(); ?> <div class="card-header">
                                    <h5><?php echo e(__('Midtrans')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="midtrans_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="midtrans_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3 apply-midtrans-btn-coupon">
                                                    <a href="#"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="midtrans"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right midtrans-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="iyzipay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="paytr-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_xendit_enabled']) && $admin_payment_setting['is_xendit_enabled'] == 'on'): ?>
                        <div id="useradd-25" class="card  shadow-none rounded-0 border-bottom ">
                            <form class="w3-container w3-display-middle w3-card-4" method="get"
                                id="midtrans-payment-form" action="<?php echo e(route('plan.xendit.payment')); ?>">
                                <?php echo csrf_field(); ?> <div class="card-header">
                                    <h5><?php echo e(__('Xendit')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="sspay_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="sspay_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3 apply-sspay-btn-coupon">
                                                    <a href="#"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="sspay"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right sspay-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="iyzipay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="paytr-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($admin_payment_setting['is_paiementpro_enabled']) && $admin_payment_setting['is_paiementpro_enabled'] == 'on'): ?>
                        <div id="useradd-26" class="card  shadow-none rounded-0 border-bottom ">
                            <form class="w3-container w3-display-middle w3-card-4" method="get"
                                id="paiementpro-payment-form" action="<?php echo e(route('plan.get.paiementpro')); ?>">
                                <?php echo csrf_field(); ?> <div class="card-header">
                                    <h5><?php echo e(__('Paiement Pro')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>

                                        <div class="row mt-3">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="paiementpro_mobile_number"
                                                        class="form-label text-dark"><?php echo e(__('Mobile Number')); ?></label>
                                                    <input type="text" id="paiementpro_mobile_number"
                                                        name="mobile_number" class="form-control mobile_number"
                                                        data-from="paiementpro"
                                                        placeholder="<?php echo e(__('Enter Mobile Number')); ?>">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="paiementpro_channel"
                                                        class="form-label text-dark"><?php echo e(__('Channel')); ?></label>
                                                    <input type="text" id="paiementpro_channel" name="channel"
                                                        class="form-control channel" data-from="paiementpro"
                                                        placeholder="<?php echo e(__('Enter Channel')); ?>">
                                                    <small class="text-danger">Example : OMCIV2 , MOMO , CARD , FLOOZ ,
                                                        PAYPAL</small>
                                                </div>
                                            </div>

                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="paiementpro_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="paiementpro_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3 apply-paiementpro-btn-coupon">
                                                    <a href="#"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="paiementpro"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right paiementpro-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="iyzipay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="paytr-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_nepalste_enabled']) &&
                    $admin_payment_setting['is_nepalste_enabled'] == 'on' &&
                    !empty($admin_payment_setting['nepalste_public_key']) &&
                    !empty($admin_payment_setting['nepalste_secret_key'])): ?>
                        <div id="useradd-27" class="card  shadow-none rounded-0 border-bottom ">
                            <form class="w3-container w3-display-middle w3-card-4" method="get"
                                id="nepalste-payment-form" action="<?php echo e(route('plan.pay.with.nepalste')); ?>">
                                <?php echo csrf_field(); ?> <div class="card-header">
                                    <h5><?php echo e(__('Nepalste')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="nepalste_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="nepalste_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3 apply-nepalste-btn-coupon">
                                                    <a href="#"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="nepalste"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right nepalste-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="iyzipay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="paytr-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($admin_payment_setting['is_fedapay_enabled']) &&
                    $admin_payment_setting['is_fedapay_enabled'] == 'on' &&
                    !empty($admin_payment_setting['fedapay_public_key']) &&
                    !empty($admin_payment_setting['fedapay_secret_key'])): ?>
                            <div id="useradd-28" class="card  shadow-none rounded-0 border-bottom ">
                                <form class="w3-container w3-display-middle w3-card-4" method="get"
                                    id="fedapay-payment-form" action="<?php echo e(route('plan.pay.with.fedapay')); ?>">
                                    <?php echo csrf_field(); ?> <div class="card-header">
                                        <h5><?php echo e(__('Fedapay')); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form>
                                            <div class="row mt-3">
                                                <div class="col-md-10">
                                                    <div class="form-group">
                                                        <label for="fedapay_coupon"
                                                            class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                        <input type="text" id="fedapay_coupon" name="coupon"
                                                            class="form-control coupon"
                                                            placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 coupon-apply-btn">
                                                    <div class="form-group pt-3 mt-3 apply-fedapay-btn-coupon">
                                                        <a href="#"
                                                            class="btn btn-primary align-items-center apply-coupon"
                                                            data-from="fedapay"><?php echo e(__('Apply')); ?></a>
                                                    </div>
                                                </div>
                                                <div class="col-12 text-right fedapay-coupon-tr" style="display: none">
                                                    <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                        class="iyzipay-coupon-price"></b>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-sm-12">
                                                        <div class="float-end">
                                                            <input type="hidden" name="plan_id"
                                                                value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                            <button class="btn btn-primary d-flex align-items-center"
                                                                type="submit">
                                                                <i class="mdi mdi-cash-multiple mr-1"></i>
                                                                <?php echo e(__('Pay Now')); ?>

                                                                (<span
                                                                    class="fedapay-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="error" style="display: none;">
                                                        <div class='alert-danger alert'>
                                                            <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </form>
                            </div>
                    <?php endif; ?>


                    <?php if(isset($admin_payment_setting['is_cinetpay_enabled']) &&
                    $admin_payment_setting['is_cinetpay_enabled'] == 'on' &&
                    !empty($admin_payment_setting['cinetpay_api_key']) &&
                    !empty($admin_payment_setting['cinetpay_secret_key'])): ?>
                        <div id="useradd-29" class="card  shadow-none rounded-0 border-bottom ">
                            <form class="w3-container w3-display-middle w3-card-4" method="get"
                                id="cinetpay-payment-form" action="<?php echo e(route('plan.cinetpay.payment')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Cinetpay')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="fedapay_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="fedapay_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3 apply-fedapay-btn-coupon">
                                                    <a href="#"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="fedapay"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right fedapay-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="iyzipay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="fedapay-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>


                    <?php if(isset($admin_payment_setting['is_payhere_enabled']) &&
                    $admin_payment_setting['is_payhere_enabled'] == 'on' &&
                    !empty($admin_payment_setting['payhere_merchant_id']) &&
                    !empty($admin_payment_setting['payhere_merchant_secret_key']) &&
                    !empty($admin_payment_setting['payhere_app_id']) &&
                    !empty($admin_payment_setting['payhere_app_secret_key'])): ?>
                        <div id="useradd-30" class="card  shadow-none rounded-0 border-bottom ">
                            <form class="w3-container w3-display-middle w3-card-4" method="get"
                                id="payhere-payment-form" action="<?php echo e(route('plan.pay.with.payhere')); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <h5><?php echo e(__('Payhere')); ?></h5>
                                </div>
                                <div class="card-body">
                                    <form>
                                        <div class="row mt-3">
                                            <div class="col-md-10">
                                                <div class="form-group">
                                                    <label for="payhere_coupon"
                                                        class="form-label"><?php echo e(__('Coupon')); ?></label>
                                                    <input type="text" id="payhere_coupon" name="coupon"
                                                        class="form-control coupon"
                                                        placeholder="<?php echo e(__('Enter Coupon Code')); ?>">
                                                </div>
                                            </div>
                                            <div class="col-md-2 coupon-apply-btn">
                                                <div class="form-group pt-3 mt-3 apply-payhere-btn-coupon">
                                                    <a href="#"
                                                        class="btn btn-primary align-items-center apply-coupon"
                                                        data-from="payhere"><?php echo e(__('Apply')); ?></a>
                                                </div>
                                            </div>
                                            <div class="col-12 text-right payhere-coupon-tr" style="display: none">
                                                <b><?php echo e(__('Coupon Discount')); ?></b> : <b
                                                    class="iyzipay-coupon-price"></b>
                                            </div>

                                            <div class="row mt-2">
                                                <div class="col-sm-12">
                                                    <div class="float-end">
                                                        <input type="hidden" name="plan_id"
                                                            value="<?php echo e(\Illuminate\Support\Facades\Crypt::encrypt($plan->id)); ?>">
                                                        <button class="btn btn-primary d-flex align-items-center"
                                                            type="submit">
                                                            <i class="mdi mdi-cash-multiple mr-1"></i>
                                                            <?php echo e(__('Pay Now')); ?>

                                                            (<span
                                                                class="payhere-final-price"><?php echo e($admin_payment_setting['currency_symbol'] ? $admin_payment_setting['currency_symbol'] : '$'); ?><?php echo e($plan->price); ?></span>)
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="error" style="display: none;">
                                                    <div class='alert-danger alert'>
                                                        <?php echo e(__('Please correct the errors and try again.')); ?></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                </div>

            </div>
            <!-- [ sample-page ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/splibrjd/public_html/resources/views/plan/payments.blade.php ENDPATH**/ ?>