<?php
/**
 * Created by PhpStorm.
 * User: bartl
 * Date: 27/10/2016
 * Time: 22:04
 */

namespace App\Traits;


trait validateSlackToken
{

    /**
     * @param $token
     * @param $slashCommand
     * @return bool
     */
    public function checkToken($token, $slashCommand)
    {
        if ($slashCommand['token'] == $token) {
            return true;
        }
        echo env('UNAUTH_MSG');
        exit;
    }
}