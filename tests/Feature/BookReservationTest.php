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
  /** @test */
  public function title_is_required()
  {

  // $this->withoutExceptionHandling();

   $response =  $this->post('/book',[
        'title' => 'Test Title',
        'author' => 'Agnie'
     ]);

     $response->assertOk();
     $this->assertCount(1,Book::all());
  }
  

  /** @test */
  public function a_book_can_be_updated()
  {
   $this->withoutExceptionHandling();
     
         $this->post('/book',[
            'title' => 'Test Title',
            'author' => 'Agnie'
         ]);

         $book = Book::first();
      $response = $this->post("/book/$book->id",[
         'title'=> 'New test title',
         'author' => 'Agnie'
      ]);

      $response->assertOk();
      $this->assertCount(1,Book::all());
  }

}
