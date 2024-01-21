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

    // ログインしていないユーザーは投稿編集ページにアクセスできない
    public function test_guest_cannot_access_books_edit()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('books.edit', $book));

        $response->assertRedirect(route('login'));
    }

    // ログインユーザーは他のユーザーのブック編集ページにアクセスできない
    public function test_user_cannot_access_others_books_edit()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_book = Book::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->get(route('books.edit', $others_book));

        $response->assertRedirect(route('books.index'));
    }

    // ログインユーザは自身のブック編集ページにアクセスできる
    public function test_user_can_access_own_books_edit()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('books.edit', $book));

        $response->assertStatus(200);
    }

    // ログインしていないユーザーはブックを更新できない
    public function test_guest_cannot_update_book()
    {
        $user = User::factory()->create();
        $old_book = Book::factory()->create(['user_id' => $user->id]);

        $new_book = [
            'title' => 'updated title',
            'description' => 'updated description'
        ];

        $response = $this->patch(route('books.update', $old_book), $new_book);

        $this->assertDatabaseMissing('books', $new_book);
        $response->assertRedirect(route('login'));
    }

    // ログインユーザは他のユーザのブックを更新できない
    public function test_user_cannot_update_others_book()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_old_book = Book::factory()->create(['user_id' => $other_user->id]);

        $new_book = [
            'title' => 'updated title',
            'description' => 'updated description'
        ];

        $response = $this->actingAs($user)->patch(route('books.update', $others_old_book), $new_book);

        $this->assertDatabaseMissing('books', $new_book);
        $response->assertRedirect(route('books.index'));
    }

    // ログインユーザは自身のブックを更新できる
    public function test_user_can_update_own_book()
    {
        $user = User::factory()->create();
        $old_book = Book::factory()->create(['user_id' => $user->id]);

        $new_book = [
            'title' => 'updated title',
            'description' => 'updated description'
        ];

        $response = $this->actingAs($user)->patch(route('books.update', $old_book), $new_book);

        $this->assertDatabaseHas('books', $new_book);
        $response->assertRedirect(route('books.show', $old_book));
    }

    // ログインしていないユーザはブックを削除できない
    public function test_guest_cannot_delete_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->delete(route('books.destroy', $book));

        $this->assertDatabaseHas('books', ['id' => $book->id]);
        $response->assertRedirect('login');
    }

    // ログインユーザは他のユーザのブックを削除出来ない
    public function test_user_cannot_delete_others_book()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_book = Book::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->delete(route('books.destroy', $others_book));

        $this->assertDatabaseHas('books', ['id' => $others_book->id]);
        $response->assertRedirect(route('books.index'));
    }

    // ログインユーザは自身のブックを削除できる
    public function test_user_can_delete_own_book()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->delete(route('books.destroy', $book));

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
        $response->assertRedirect(route('books.index'));
    }
}
