<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class WelcomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws \Throwable
     */
    public function testIndex()
    {
        $this->browse(function (Browser $browser) {

            $browser->visit('/')
                ->assertSee(config('app.name', 'Laravel'))
                ->assertSee('Login')
                ->assertSee('Register');

            $user = factory(User::class)->create([
                'email' => 'hello@example.com',
            ]);

            $browser->loginAs($user)
                ->visit('/')
                ->assertSee(config('app.name', 'Laravel'))
                ->assertSee('Home');
        });
    }
}
