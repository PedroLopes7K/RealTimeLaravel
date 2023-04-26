<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Chrome;

class RegisterTest extends DuskTestCase
{
    public function testShouldSeePasswordValidationFail()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                    ->type('name', 'José Filho')
                    ->type('email', 'teste@gmail.com')
                    ->type('password', '123')
                    ->type('password_confirmation', '123')
                    ->press('Register')
                    ->assertSee('The password field must be at least 8 characters');
        });
    }

}
