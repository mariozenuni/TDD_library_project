<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Book;
use App\Models\User;
use Tests\TestCase;
use App\Models\Reservation;
use Facade\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;
    /** @test **/
    public function a_book_can_be_check_out_by_a_singed_in_user()
    {
            $book = Book::factory()->create();
            // acting as a logged in user 
            $response = $this->actingAs($user = User::factory()->create())
                 ->post('/reservation/checkout'.$book->id);

        $this->assertCount(1,Reservation::all());
        $this->assertEquals($book->id,Reservation::first()->book_id);
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals(today(),Reservation::first()->checked_out_at);

        $response->assertRedirect('/reservation/'.$book->id);
        
    }
        /** @test **/
    public function only_singed_in_user_can_checkout_a_book()
    {
         
              $book = Book::factory()->create();
            
              $response=$this->post('/reservation/'.$book->id);
       
              $response->assertRedirect('/login');

              $this->assertCount(0,Reservation::all());

       
    }

    /** @test **/
    public function only_real_book_can_be_check_out()
    {
        // acting as a logged in user 
        $response = $this->actingAs($user = User::factory()->create())
             ->post('/reservation/12345')
             ->assertStatus(404);
       $this->assertCount(0,Reservation::all());
    }
     /** @test **/
     public function a_book_can_be_check_in_by_a_signed_in_user()
     {
     
       $book = Book::factory()->create();
        //checkout
       $response = $this->actingAs($user = User::factory()->create())
       ->post('/reservation/checkout/'.$book->id);
        //chechin
        $response = $this->actingAs($user)
             ->post('/reservation/checkin/'.$book->id);

    $this->assertCount(1,Reservation::all());
    $this->assertEquals($book->id,Reservation::first()->book_id);
    $this->assertEquals($user->id,Reservation::first()->user_id);
    $this->assertEquals(today(),Reservation::first()->checked_out_at);
    $this->assertEquals(today(),Reservation::first()->checked_in_at);
       $response->assertRedirect('/reservation/'.$book->id);
     }

          /** @test **/
    public function only_singed_in_user_can_check_in_a_book()
    {
        //$this->withoutExceptionHandling();
              
        $book = Book::factory()->create();

              $response = $this->actingAs($user = User::factory()->create())

                 ->post('/reservation/checkout/'.$book->id);

                //logout user before trying to check in 
            Auth::logout();
       
          $response=$this->post('/reservation/checkin/'.$book->id);

          $response->assertRedirect('/login');

              $this->assertCount(1,Reservation::all());
              $this->assertNull(Reservation::first()->checked_in_at);

       
    }

     /** @test **/
     public function only_real_book_can_be_check_in()
     {
       // $this->withoutExceptionHandling();
         // acting as a logged in user 
         $response = $this->actingAs($user = User::factory()->create())
              ->post('/reservation/checkin/12345')
              ->assertStatus(404);
        $this->assertCount(0,Reservation::all());
     }
}
