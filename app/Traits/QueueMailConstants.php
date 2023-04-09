<?php

namespace App\Traits;

use App\Library\SiteConstants;

trait QueueMailConstants
{
    /**
     * Get no-reply email for mailing
     *
     * @return array
     */
    public function noReplyEmail($domain = null) : array
    {
        $email = env('MAIL_FROM_ADDRESS');
        $name = env('MAIL_FROM_NAME') . ' - ' . env('APP_NAME');

        return [
            'email' => $email,
            'name' => $name,
        ];
    }

    /**
     * Get Company Email
     *
     * @return string
     */
    public function organizationEmail()
    {
        return env('MAIL_FROM_ADDRESS');
    }

    /**
     * Get Company Name
     *
     * @return string
     */
    public function organizationName()
    {
        return env('APP_NAME');
    }
}
