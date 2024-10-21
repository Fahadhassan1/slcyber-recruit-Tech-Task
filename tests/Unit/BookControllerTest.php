<?php

namespace Tests\Feature;

use App\Http\Controllers\BookController;
use App\Models\Book;
use App\Http\Requests\UpdateRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Book::create([
            'title' => 'Original Title',
            'author' => 'Original Author',
            'rating' => 5,
        ]);
    }

    /** @test */
    public function it_updates_a_book_successfully()
    {
        // Arrange
        $book = Book::first();
        $data = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'rating' => 4,
        ];

        $response = $this->json('PUT', route('books.update', $book->id), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Successfully updated the book.',
                'data' => [
                    'title' => 'Updated Title',
                    'author' => 'Updated Author',
                    'rating' => 4,
                ],
            ]);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'rating' => 4,
        ]);
    }

    /** @test */
    public function it_fails_to_update_a_book_with_invalid_data()
    {
        // Arrange
        $book = Book::first();
        $data = [
            'title' => '',
        ];

        $response = $this->json('PUT', route('books.update', $book->id), $data);

        $response->assertStatus(422); // Unprocessable Entity for validation errors
        $response->assertJsonStructure(['message', 'errors']);
    }

    /** @test */
    public function it_returns_404_if_book_not_found()
    {
        $data = [
            'title' => 'Updated Title',
            'author' => 'Updated Author',
            'rating' => 4,
        ];

        $response = $this->json('PUT', route('books.update', 999), $data);

        $response->assertStatus(404);
    }
}
