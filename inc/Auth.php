<?php

class Auth
{
    public function user()
    {
        return wp_get_current_user();
    }

    public function check()
    {
        $current_user = wp_get_current_user();
        return $current_user->ID != 0;
    }
}