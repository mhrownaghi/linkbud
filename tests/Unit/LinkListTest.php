<?php

namespace Tests\Unit;

use App\Models\LinkList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_a_link()
    {
        $linkList = LinkList::factory()->create();

        $link = $linkList->addLink([
            'name' => 'test',
            'url' => 'http://test.com',
            'order' => 1,
        ]);

        $this->assertCount(1, $linkList->links);
        $this->assertTrue($linkList->links->contains($link));
    }
}
