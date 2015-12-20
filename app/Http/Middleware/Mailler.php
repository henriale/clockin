<?php


namespace App\Http\Middleware;


use Mailgun\Mailgun;

class Mailler
{
    private $Mailgun;
    private $hash;

    public $destinatary;
    public $subject;
    public $body;
    public $username;

    public function __construct()
    {
        $this->Mailgun = new Mailgun(env('MAILGUN_SECRET'));
    }

    private function prepareContent()
    {
        return [
            'from' => env('MAIL_FROM_ADDRESS'),
            'to' => $this->destinatary,
            'subject' => $this->subject,
            'html' => $this->body
        ];
    }

    /**
     * Send message
     */
    public function sendMessage()
    {
        $this->Mailgun->sendMessage(env('MAILGUN_DOMAIN'), $this->prepareContent());
    }

    /**
     * Make subscribe user
     * @param $username
     * @param $destinatary
     */
    public function subscribe($username, $destinatary)
    {
        $this->username = $username;
        $this->destinatary = $destinatary;

        $this->Mailgun->post('lists/'.env('MAILGUN_LIST').'/members', [
            'name' => $this->username,
            'address' => $this->destinatary,
            'subscribed' => 'yes'
        ]);

        $this->subject = 'Welcome to ClockIn';
        $this->body = 'Thanks for using ClockIn';
        $this->sendMessage();
    }

}