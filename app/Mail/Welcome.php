<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable;
    use SerializesModels;

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function build(): self
    {
        return $this->markdown('emails.welcome')->with(['developerName' => $this->name]);
    }
}
