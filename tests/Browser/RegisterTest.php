<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws \Throwable
     */
    public function testRegister()
    {
        $this->browse(function (Browser $browser) {

            $browser->logout();

            $browser->visit('/register')
                ->type('name', 'Example')
                ->type('email', 'hello@example.com')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Register')
                ->assertPathIs('/email/verify');
        });
    }

    /**
     * @throws \Throwable
     */
    public function testRegisterFailureEmailUnique()
    {
        factory(User::class)->create([
            'email' => 'hello@example.com',
        ]);

        $this->browse(function (Browser $browser) {

            $browser->logout();

            $browser->visit('/register')
                ->type('name', 'Example')
                ->type('email', 'hello@example.com')
                ->type('password', 'secret')
                ->type('password_confirmation', 'secret')
                ->press('Register')
                ->assertPathIs('/register')
                ->assertSee(__('validation.unique', ['attribute' => 'email'], 'en'));
        });
    }
}
