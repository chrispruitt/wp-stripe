<?php

class WPStripe {

    public static function create_customer($user_id, $email = "", $description = "") {
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

    public static function delete_customer($user_id) {
        $customer = Stripe_Customer::retrieve(get_user_meta($user_id, 'stripe_cus_id', true));
        $customer->delete();
        delete_usermeta(get_current_user_id(), 'stripe_cus_id');
    }

    public static function get_customer($user_id) {
        $customer = Stripe_Customer::retrieve(get_user_meta($user_id, 'stripe_cus_id', true));
        return $customer;
    }

    public static function update_payment_info($user_id, $card) {
        $customer = get_customer($user_id);
        $customer->card = $card;
        $customer->save();
    }
}