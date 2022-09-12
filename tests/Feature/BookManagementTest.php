<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
use RefreshDatabase;

  /** @test */
  public function a_book_can_be_added_to_the_library()
  {
   //$this->withoutExceptionHandling();

  $response = $this->post('/books',$this->data()); 

  $book = Book::first();
    //$response->assertOk();
    $this->assertCount(1, Book::all());

    $response->assertRedirect('books/'.Book::first()->id);
    
  } 
  /** @test */
  public function a_title_is_required()
  {
   // $this->withoutExceptionHandling();

    $response =  $this->post('/books',array_merge($this->data(),['title'=>'']));

    $response->assertSessionHasErrors('title');

  }

  /** @test */
  public function a_author_is_required()
  {
   // $this->withoutExceptionHandling();

    $response =  $this->post('/books',array_merge($this->data(),['author'=>'']));

    $response->assertSessionHasErrors('author');

  }

  /** @test */

  public function a_book_can_be_updated()
  { 
   $this->withoutExceptionHandling();

     $response = $this->post('/books',$this->data());

     $book = Book::first();
     
     $response = $this->patch($book->path(),[
        'title'=> 'New Test 1',
        'author' => 'New Agnie'
      ]);
   

      $this->assertSame('New Test 1',$book->title);
      $this->assertSame('New Agnie',$book->author);

      $response->assertRedirect($book->fresh()->path());

  }

  /** @test */

    public function a_book_can_be_deleted()
    {
      $this->withoutExceptionHandling();

      $response = $this->post('/books',$this->data());
      
      $this->assertCount(1,Book::all());
      $book = Book::first();
      $response = $this->delete($book->path());

      $this->assertCount(0,Book::all());

      $response->assertRedirect('/books');

    }

  private function data()
  {
    return [
      'title'=> 'New Test 1',
      'author' => 'New Agnie'
    ];
  }

}
