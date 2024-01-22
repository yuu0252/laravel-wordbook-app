<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WordTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;

    // ログインしていないユーザはワード一覧ページにアクセスできない
    public function test_guest_cannot_access_word_index()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);
        $word = Word::factory()->create(['book_id' => $book->id]);

        $request = $this->get(route('words.index', $book, $word));

        $request->assertRedirect('login');
    }

    // ログインユーザは他のユーザのワード一覧ページにアクセスできない
    public function test_user_cannot_access_others_word()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_book = Book::factory()->create(['user_id' => $other_user->id]);
        $others_word = Word::factory()->create(['book_id' => $others_book->id]);

        $response = $this->actingAs($user)->get(route('words.index', $others_book, $others_word));

        $response->assertRedirect(route('books.index'));
    }

    // ログインユーザは自身のワード一覧にアクセスできる
    public function test_user_can_access_own_word_index()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);
        $word = Word::factory()->create(['book_id' => $book->id]);

        $response = $this->actingAs($user)->get(route('words.index', $book, $word));

        $response->assertStatus(200);
        $response->assertSee($word->english);
    }

    // ログインしていないユーザはワード作成ページにアクセスできない
    public function test_guest_cannot_access_word_create()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('words.create', $book));

        $response->assertRedirect(route('login'));
    }

    // ログインユーザは他のユーザのワード作成ページにアクセスできない
    public function test_user_cannot_access_others_word_create()
    {
        $user = User::factory()->create();
        $other_user = User::factory()->create();
        $others_book = Book::factory()->create(['user_id' => $other_user->id]);

        $response = $this->actingAs($user)->get(route('words.create', $others_book));

        $response->assertRedirect(route('books.index'));
    }

    // ログインユーザは自身のワード作成ページにアクセスできる
    public function test_user_can_access_own_word_create()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('words.create', $book));

        $response->assertStatus(200);
    }

    // ログインしていないユーザはワードを作成できない
    public function test_guest_cannot_create_word()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $new_word = [
            'english' => 'test',
            'japanese' => 'テスト',
            'memo' => 'メモ'
        ];

        $response = $this->post(route('words.store', $book), $new_word);

        $this->assertDatabaseMissing('words', $new_word);
        $response->assertRedirect('login');
    }

    // ログインユーザは自身のワードを作成できる
    public function test_user_can_create_own_word()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['user_id' => $user->id]);

        $new_word = [
            'english' => 'test',
            'japanese' => 'テスト',
            'memo' => 'メモ'
        ];

        $response = $this->actingAs($user)->post(route('words.store', $book), $new_word);

        $this->assertDatabaseHas('words', $new_word);
        $response->assertRedirect(route('words.index', $book));
    }
}
