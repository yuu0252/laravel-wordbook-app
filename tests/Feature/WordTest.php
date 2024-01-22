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
}
