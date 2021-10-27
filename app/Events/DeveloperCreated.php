<?php

namespace App\Events;

use App\Models\Developer;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DeveloperCreated
{
    use Dispatchable, SerializesModels;

    private Developer $developer;

    public function __construct(Developer $developer)
    {
        $this->developer = $developer;
    }

    public function developer(): Developer
    {
        return $this->developer;
    }
}
