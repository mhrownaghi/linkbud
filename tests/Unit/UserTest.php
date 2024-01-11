<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_link_list()
    {
        $user = User::factory()->create();

        $linkList = $user->addLinkList([
            'name' => 'My List',
            'slug' => 'my-list',
            'description' => 'My list',
        ]);

        $this->assertCount(1, $user->linkLists);

        $this->assertTrue($user->linkLists->contains($linkList));
    }
}
