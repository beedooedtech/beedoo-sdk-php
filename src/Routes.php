<?php

namespace Beedoo;

use Beedoo\Anonymous;

class Routes
{
    /**
     * @return Anonymous
     */
    public static function accessToken(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "beehub/v1/user/accessToken";
        };

        return $anonymous;
    }

    /**
     * @return Anonymous
     */
    public static function beehubWiki(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "beehub/v1/wiki";
        };

        return $anonymous;
    }

    /**
     * @return Anonymous
     */
    public static function groups(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "admin/api/v1/groups";
        };

        return $anonymous;
    }

    /**
     * @return Anonymous
     */
    public static function wiki(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "api/v1/wiki/isreadarticle";
        };

        $anonymous->saveArticleRead = static function () {
            return "api/v1/wiki/save-article-read";
        };

        return $anonymous;
    }

    /**
     * @return Anonymous
     */
    public static function team(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->avatar = static function () {
            return "admin/api/v1/avatar";
        };

        return $anonymous;
    }

    /**
     * @return Anonymous
     */
    public static function upload(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->url = static function () {
            return "admin/api/v1/upload";
        };

        return $anonymous;
    }

    /**
     * @return Anonymous
     */
    public static function visualIdentity(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "admin/api/v1/visualidentity";
        };

        return $anonymous;
    }
    
    /**
     * @return Anonymous
     */
    public static function user(): Anonymous
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

    /**
     * @return Anonymous
     */
    public static function auth(): Anonymous
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "login";
        };

        return $anonymous;
    }
}
