<?php

namespace Beedoo;

use Beedoo\Anonymous;

class Routes
{
    public static function accessToken()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "beehub/v1/user/accessToken";
        };

        return $anonymous;
    }

    public static function beehubWiki()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "beehub/v1/wiki";
        };

        return $anonymous;
    }

    public static function wiki()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "api/v1/wiki/isreadarticle";
        };

        return $anonymous;
    }

    public static function team()
    {
        $anonymous = new Anonymous();

        $anonymous->avatar = static function () {
            return "admin/api/v1/avatar";
        };

        return $anonymous;
    }
    
    public static function user()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "admin/api/v1/users";
        };

        $anonymous->details = static function ($userId) {
            return "admin/api/v1/users/{$userId}";
        };

        return $anonymous;
    }
}
