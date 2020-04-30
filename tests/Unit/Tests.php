<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class Tests extends TestCase
{

    public function testThatUnauthenticatedUserIsRedirected()
    {
        $this->get('/dashboard')->assertRedirect();
    }

}
