<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    // ログインしていないユーザーはブック一覧にアクセスできない
    public function test_guest_cannot_access_books_index()
    {
        $response = $this->get(route('books.index'));

        $response->assertRedirect(route('login'));
    }

    // ログインしているユーザーはブック一覧にアクセスできる
    public function test_user_can_accsess_books_index()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('books.index'));

        $response->assertStatus(200);
        $response->assertSee($book->title);
    }

    // ログインしていないユーザーはブック詳細ページにアクセスできない
    public function test_guest_cannot_books_show()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('books.show', $book));

        $response->assertRedirect(route('login'));
    }

    // ログインしているユーザーはブック詳細にアクセスできる
    public function test_user_can_access_books_show()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('books.show', $book));

        $response->assertStatus(200);
        $response->assertSee($book->title);
    }

    // ログインしていないユーザーはブック作成ページにアクセスできない
    public function test_guest_cannot_access_books_create()
    {
        $response = $this->get(route('books.create'));

        $response->assertRedirect('login');
    }

    // ログインしているユーザーはブック作成ページにアクセスできる
    public function test_user_can_access_books_create()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('books.create'));

        $response->assertStatus(200);
    }

    // ログインしていないユーザーはブックを作成できない
    public function test_guest_cannot_access_books_store()
    {
        $book = [
            'title' => 'テストブック',
            'description' => 'テスト用のブックです。'
        ];

        $response = $this->post(route('books.store'), $book);

        $this->assertDatabaseMissing('books', $book);
        $response->assertRedirect(route('login'));
    }

    // ログインしているユーザーはブックを作成できる
    public function test_user_can_access_books_store()
    {
        $user = User::factory()->create();

        $book = [
            'title' => 'テストブック',
            'description' => 'テスト用のブックです。'
        ];

        $response = $this->actingAs($user)->post(route('books.store'), $book);

        $this->assertDatabaseHas('books', $book);
        $response->assertRedirect(route('books.index'));
    }
}
