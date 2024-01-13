<?php

namespace Tests\Feature;

use App\Models\Link;
use App\Models\LinkList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class ManageLinkListsTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /** @test */
    public function a_user_can_create_a_link_list()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw();
        $attribute['owner_id'] = $user->id;
        $attribute['links'] = Link::factory(2)->raw();

        $this->actingAs($user)->get('/link-lists/create')->assertOK();

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertRedirect("/{$user->username}/{$attribute['slug']}");

        $this->assertDatabaseHas('link_lists', Arr::except($attribute, 'links'));

        $this->assertCount(2, LinkList::first()->links);
    }

    /** @test */
    public function guest_cannot_create_a_link_list()
    {
        $this->post('/link-lists', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function a_link_list_must_have_a_name()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw(['name' => '']);
        $attribute['links'] = Link::factory(2)->raw();

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_link_list_must_have_a_slug()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw(['slug' => '']);
        $attribute['links'] = Link::factory(2)->raw();

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_link_list_can_have_no_description()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw(['description' => '']);
        $attribute['links'] = Link::factory(2)->raw();

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertRedirect("/{$user->username}/{$attribute['slug']}");
    }

    /** @test */
    public function a_link_list_can_not_have_a_slug_that_already_exists_for_its_owner()
    {
        $user = User::factory()->create();

        LinkList::factory()->create(['slug' => 'test-slug', 'owner_id' => $user->id]);

        $attribute = LinkList::factory()->raw(['slug' => 'test-slug']);
        $attribute['links'] = Link::factory(2)->raw();

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('slug');

        $secondUser = User::factory()->create();

        $attribute = LinkList::factory()->raw(['slug' => 'test-slug']);
        $attribute['links'] = Link::factory(2)->raw();

        $this->actingAs($secondUser)
            ->post('/link-lists', $attribute)
            ->assertRedirect("/{$secondUser->username}/{$attribute['slug']}");
    }

    /** @test */
    public function a_link_list_must_have_valid_slug()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw(['slug' => 'test slug']);
        $attribute['links'] = Link::factory(2)->raw();

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('slug');
    }

    /** @test */
    public function a_link_must_have_name()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw();
        $attribute['links'][] = Link::factory()->raw(['name' => '']);

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('links.*.name');
    }

    /** @test */
    public function a_link_must_have_url()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw();
        $attribute['links'][] = Link::factory()->raw(['url' => '']);

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('links.*.url');
    }

    /** @test */
    public function a_link_must_have_valid_url()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw();
        $attribute['links'][] = Link::factory()->raw(['url' => 'invalid-url']);

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('links.*.url');
    }

    /** @test */
    public function a_link_must_have_order()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw();
        $attribute['links'][] = Link::factory()->raw(['order' => '']);

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('links.*.order');
    }

    /** @test */
    public function a_link_must_have_valid_order()
    {
        $user = User::factory()->create();

        $attribute = LinkList::factory()->raw();
        $attribute['links'][] = Link::factory()->raw(['order' => 'invalid-order']);

        $this->actingAs($user)
            ->post('/link-lists', $attribute)
            ->assertSessionHasErrors('links.*.order');
    }
}
