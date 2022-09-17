<?php

namespace Tests\Feature;

use App\Models\Author;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PharIo\Manifest\Author as ManifestAuthor;
use Tests\TestCase;

class AuthorManagementTest extends TestCase
{
 use RefreshDatabase;

  /** @test */
  public function a_author_can_be_added_to_the_library()
  {
    $this->withoutExceptionHandling();

   $data = [
    'name'=> 'Agnieszka',
    'dob' => '06/14/1992'
   ];
    $response = $this->post('/authors', $data);

    $response->assertOk();
    $authors= Author::all();
     $this->assertCount(1,Author::all());
     $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
     $this->assertEquals('1992/06/14',$authors->first()->dob->format('Y/m/d'));
  } 
  

}
