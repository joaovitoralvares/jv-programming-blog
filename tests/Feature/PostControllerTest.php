<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_admin_can_create_post()
    {
        $this->withoutExceptionHandling();
        User::factory()->admin()->create();
        $user= User::first();
        $response = $this->actingAs($user)->post('/posts',[
            'title' => 'How to test laravel applications',
            'meta_title' => 'How to test laravel applications',
            'summary' => 'a brief summary',
            'content' => 'the content of the blog post',
            'published' => true
        ]);
        $post = Post::first();
        $response->assertStatus(302);
        $this->assertEquals(1,Post::count());
        $this->assertEquals('How to test laravel applications', $post->title);
        $this->assertEquals('How to test laravel applications', $post->meta_title);
        $this->assertEquals('a brief summary', $post->summary);
        $this->assertEquals('the content of the blog post', $post->content);
        $this->assertEquals('how-to-test-laravel-applications', $post->slug);
        $this->assertEquals($user->id, $post->author_id);
    }

    public function test_user_cant_create_post()
    {
        User::factory()->create();
        $user= User::first();
        $response = $this->actingAs($user)->post('/posts',[
            'title' => 'How to test laravel applications',
            'meta_title' => 'meta title content',
            'summary' => 'a brief summary',
            'content' => 'the content of the blog post'
        ]);
        $response->assertStatus(403);
        $this->assertEquals(0,Post::count());
    }

    public function test_post_can_be_shown()
    {
        $this->withExceptionHandling();
        $user = User::factory()->admin()->create();
        $post = Post::factory()->create([
            'author_id' => $user->id
        ],$user);
        $response = $this->get("/posts/$post->slug");
        $response->assertStatus(200);
    }
}
