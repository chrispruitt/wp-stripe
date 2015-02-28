<?php

class WPStripe {
    function __construct() {
        $stripe = array(
            'secret_key'      => 'sk_test_COkxTNWdVFrfHcwJtqp6LBid',
            'publishable_key' => 'pk_test_fpJbqfr3gzCWFeSJaTBL6uhu'
        );

        Stripe::setApiKey($stripe['secret_key']);
    }

    function create_customer($user_id, $email = "", $description = "") {
        $stripe_cus_id = get_user_meta($user_id, 'stripe_cus_id', true);
        if( !empty ($stripe_cus_id)) {
            $customer = Stripe_Customer::retrieve($stripe_cus_id);
        } else {
            $customer = Stripe_Customer::create(array(
                "description" => $description,
                "email" => $email
            ));
            update_user_meta( get_current_user_id(), 'stripe_cus_id', $customer['id']);
        }
        return $customer;
    }

    function delete_customer($user_id) {
        $customer = Stripe_Customer::retrieve(get_user_meta($user_id, 'stripe_cus_id', true));
        $customer->delete();
        delete_usermeta(get_current_user_id(), 'stripe_cus_id');
    }

    function get_customer($user_id) {
        $customer = Stripe_Customer::retrieve(get_user_meta($user_id, 'stripe_cus_id', true));
        return $customer;
    }

    function update_payment_info($user_id, $card) {
        $customer = $this->get_customer($user_id);
        $customer->card = $card;
        $customer->save();
    }
}