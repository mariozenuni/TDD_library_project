<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
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

    $response =  $this->post('/books',array_merge($this->data(),['author_id'=>'']));

    $response->assertSessionHasErrors('author_id');

  }

  /** @test */

  /** @test */
  public function a_book_can_be_updated()
  {
      $this->post('/books', $this->data());

      $book = Book::first();
        
      $response = $this->put($book->path(), [
          'title' => 'New Title',
          'author_id' => 'New Author',
      ]); 

      $book = $book->first()->fresh(); 
      
      $author=Author::find($book->author_id);


      $this->assertEquals($author->id, $book->author_id);
   
      $this->assertEquals('New Title', $book->title);
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



    /** @test */

    public function a_new_author_is_automatcally_added()
    {
      $this->withoutExceptionHandling();
   
     $this->post('/books',  $this->data()); 


      $book= Book::first();
      $author = Author::first(); 
      $this->assertCount(1, Book::all());
      $this->assertCount(1, Author::all());
      $this->assertEquals($author->id ,$book->author_id); 
     
  
   
  
      
   }


  private function data()
  {
    return [
      'title'=> 'Test title',
      'author_id' => 'test'
    ];
  }

}
