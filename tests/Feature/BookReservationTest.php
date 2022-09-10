<?php

namespace Tests\Feature;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookReservationTest extends TestCase
{

   use RefreshDatabase;
  /** @test */
  public function a_book_can_be_added_to_the_library()
  {
    $this->withoutExceptionHandling();

   $response =  $this->post('/book',[
        'title' => 'The Queen',
        'author' => 'Agnie'
     ]);

     $response->assertOk();
     $this->assertCount(1,Book::all());
  }
}
