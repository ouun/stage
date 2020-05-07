<?php

namespace Stage\Providers;

use Roots\Acorn\ServiceProvider;

class ShopCheckout extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Helper errors to validate step if no other error present
         */
        add_action(
            'woocommerce_after_checkout_validation',
            function ($data, $errors) {
                $step = filter_input(INPUT_POST, 'current_step');

                if (empty($errors->errors) && 'address' === $step) {
                    $errors->add(
                        'digthis',
                        __('<span id="digthis-prevent-error">Successfully validated ' . $step . '</span>', 'stage')
                    );
                }

                if (wc_terms_and_conditions_checkbox_enabled() && empty($errors->errors) && 'address' === $step) {
                    $errors->add(
                        'digthis',
                        __('<span id="digthis-prevent-error">Successfully validated ' . $step . '</span>', 'stage')
                    );
                }
            },
            9999,
            2
        );

        /**
         * Bypass terms error for first step, get value from hidden form field
         */
        add_filter(
            'woocommerce_checkout_posted_data',
            function ($data) {
                $step = filter_input(INPUT_POST, 'current_step');

                if (wc_terms_and_conditions_checkbox_enabled() && 'address' === $step) {
                    $data['terms'] = 1;
                }

                return $data;
            }
        );

        /**
         * Add multi-step indicator HTML
         */
        add_action(
            'woocommerce_before_checkout_form',
            function ($checkout) {
                $steps = [
                    'cart'     => esc_html__('Cart', 'stage'),
                    'address'  => esc_html__('Invoice & Shipping', 'stage'),
                    'payment'  => esc_html__('Review & Payment', 'stage'),
                    'thankyou' => esc_html__('Order Confirmation', 'stage'),
                ];

                echo '<div id="checkout-step-indicator" class="hidden">';
                echo '<ol class="multi-steps triangle">';
                foreach ($steps as $key => $value) {
                    if ('cart' === $key) {
                        echo '<li class="step done step-' . esc_html($key) . '" data-step="' . esc_html($key) . '">';
                        echo '<a href="' . esc_html(wc_get_cart_url()) . '"
                                 data-step="' . esc_html($key) . '">' . esc_html($value) . '</a>';
                        echo '</li>';
                    } else {
                        echo '<li class="step step-' . esc_html($key) . '" data-step="' . esc_html($key) . '">';
                        echo '<span data-step="' . esc_html($key) . '">' . esc_html($value) . '</span>';
                        echo '</li>';
                    }
                }
                echo '</ol>';
                echo '</div>';
            },
            5 // Change to 10 to show after "Have a coupon?".
        );

        /**
         * Adjust DOM for multi-steps
         */
        add_action(
            'woocommerce_checkout_before_customer_details',
            function () {
                echo '<div id="checkout-address" class="steps w-full mt-12">';
            }
        );

        /**
         * Adjust DOM for multi-steps
         */
        add_action(
            'woocommerce_checkout_after_customer_details',
            function () {
                ?>
                <div class="form-row">
                    <input type="hidden" name="current_step" id="current_step" value="address">
                    <button type="submit"
                            name="verify-checkout"
                            id="verify-checkout"
                            class="checkout button w-full"
                            data-current="address"
                            data-next="payment">
                        <?php esc_html_e('Proceed to payment', 'stage'); ?>
                    </button>
                </div>
                </div> <!-- closing: #checkout-address -->
                <?php
            }
        );

        /**
         * Adjust DOM for multi-steps
         */
        add_action(
            'woocommerce_checkout_before_order_review_heading',
            function () {
                echo ' <div id="checkout-payment" class="steps w-full mt-12">';
            }
        );

        /**
         * Adjust DOM for multi-steps
         */
        add_action(
            'woocommerce_checkout_after_order_review_heading',
            function () {
                echo '</div>';
            }
        );
    }
}
