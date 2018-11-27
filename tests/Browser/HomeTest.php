<?php

namespace Tests\Browser;

use App\User;
use Carbon\Carbon;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends DuskTestCase
{
    use DatabaseMigrations;

    /**
     * @throws \Throwable
     */
    public function testExample()
    {
        $user = factory(User::class)->create([
            'email' => 'hello@example.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $this->browse(function (Browser $browser) use ($user) {

            $browser->loginAs($user);

            $browser->visit('/home')
                ->assertSee(config('app.name', 'Laravel'))
                ->assertSee('Dashboard')
                ->assertSee('You are logged in!');
        });
    }
}
