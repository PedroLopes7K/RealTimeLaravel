<?php

namespace Tests\Browser;

use App\Models\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ChatTest extends DuskTestCase
{
    /**
     * A Dusk test example.
     */
    public function testTwoUsersInChat(): void
    {
        $this->browse(function (Browser $first, Browser $second) {
            $first->loginAs(User::find(1))
            ->visit('/chat')
            ->waitForText('Chat');
   
      $second->loginAs(User::find(2))
             ->visit('/chat')
             ->waitForText('Chat')
             ->type('message', 'Oi Tiago')
             ->press('Send');
   
      $first->waitForText('Oi Tiago')
            ->assertSee('pedro');
        });
    }
}
