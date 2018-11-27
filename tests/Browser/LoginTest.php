<?php

namespace Tests\Browser;

use App\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws \Throwable
     */
    public function testLogin()
    {
        $user = factory(User::class)->create([
            'email' => 'hello@example.com',
        ]);

        $this->browse(function (Browser $browser) use ($user) {

            $browser->logout();

            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/email/verify');

            $user->email_verified_at = Carbon::now();
            $user->save();

            $browser->visit('/login')
                ->assertPathIs('/home');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testLoginFailureIncorrectEmail()
    {
        $user = factory(User::class)->create([
            'email' => 'hello@example.com',
        ]);

        $this->browse(function (Browser $browser) use ($user) {

            $browser->logout();

            $browser->visit('/login')
                ->type('email', 'bye@example.com')
                ->type('password', 'secret')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSee(__('auth.failed', [], 'en'));
        });
    }

    /**
     * @throws \Throwable
     */
    public function testLoginFailureIncorrectPassword()
    {
        $user = factory(User::class)->create([
            'email' => 'hello@example.com',
        ]);

        $this->browse(function (Browser $browser) use ($user) {

            $browser->logout();

            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'not secret')
                ->press('Login')
                ->assertPathIs('/login')
                ->assertSee(__('auth.failed', [], 'en'));
        });
    }
}
