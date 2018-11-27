<?php

namespace Tests\Browser;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ResetPasswordTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws \Throwable
     */
    public function testSendLink()
    {
        $user = factory(User::class)->create([
            'email' => 'hello@example.com',
        ]);

        $this->browse(function (Browser $browser) use ($user) {

            $browser->logout();

            $browser->visit('/password/reset')
                ->type('email', $user->email)
                ->press('Send Link')
                ->assertSee('We have e-mailed your password reset link!');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testResetPassword()
    {
        $user = factory(User::class)->create([
            'email' => 'hello@example.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $this->browse(function (Browser $browser) use ($user) {

            $token = Password::broker()->createToken($user);

            $browser->logout();

            $browser->visit('/password/reset/'.$token)
                ->type('email', $user->email)
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Reset Password')
                ->assertPathIs('/home')
                ->assertSee('Your password has been reset!');
        });
    }
}
