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
 // $this->withoutExceptionHandling();

  $response = $this->post('books',$this->data()); 

    $response->assertStatus(200);
    $this->assertCount(1, Book::all());
    
  } 
  /** @test */
  public function a_title_is_required()
  {
   // $this->withoutExceptionHandling();

    $response =  $this->post('books',array_merge($this->data(),['title'=>'']));

    $response->assertSessionHasErrors('title');

  }

  /** @test */
  public function a_author_is_required()
  {
   // $this->withoutExceptionHandling();

    $response =  $this->post('books',array_merge($this->data(),['author'=>'']));

    $response->assertSessionHasErrors('author');

  }

  /** @test */

  public function a_book_can_be_updated()
  { 
   $this->withoutExceptionHandling();

     $response = $this->post('books',$this->data());

      $this->patch('book/'.Book::first()->id,[
        'title'=> 'New Test 1',
        'author' => 'New Agnie'
      ]);

      $this->assertSame('New Test 1',Book::first()->title);
      $this->assertSame('New Agnie',Book::first()->author);


  }

  private function data()
  {
    return [
      'title'=> 'New Test 1',
      'author' => 'New Agnie'
    ];
  }

}
