<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WelcomeUsersTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function test_it_welcomes_users_with_nickname()
    {
        $this->get('/saludo/thaimy/miyuki')
            ->assertStatus(200)
            ->assertSee('Bienvenido Thaimy, tu apodo es miyuki');
    }

    public function test_it_welcomes_users_without_nickname()
    {
        $this->get('/saludo/thaimy')
            ->assertStatus(200)
            ->assertSee('Bienvenido Thaimy');
    }
}
