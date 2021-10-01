<?php

namespace Beedoo;

use Beedoo\Anonymous;

class Routes
{
    /**
     * @return Anonymous
     */
    public static function accessToken()
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
    public static function beehubWiki()
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
    public static function groups()
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
    public static function wiki()
    {
        $anonymous = new Anonymous();

        $anonymous->isReadArticle = static function () {
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
    public static function team()
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
    public static function upload()
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
    public static function visualIdentity()
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
    public static function user()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "admin/api/v1/users";
        };

        $anonymous->details = static function ($identity) {
            return "admin/api/v1/users/{$identity}";
        };

        return $anonymous;
    }

    /**
     * @return Anonymous
     */
    public static function auth()
    {
        $anonymous = new Anonymous();

        $anonymous->base = static function () {
            return "login";
        };

        return $anonymous;
    }
}
