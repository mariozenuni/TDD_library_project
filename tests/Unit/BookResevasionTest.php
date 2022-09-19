<?php

namespace Tests\Unit;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Book;
use App\Models\User;
use App\Models\Reservation;
use Carbon\Carbon;
use Exception;

class BookResevasionTest extends TestCase
{
   use  RefreshDatabase;

    /** @test **/
    public function a_book_can_be_checked_out()
    {
        //$this->withExceptionHandling();
        $book = Book::factory()->create();

        $user =  User::factory()->create();


        $book->checkedOut($user);

        $this->assertModelExists($book);
        $this->assertModelExists($user);
        $this->assertCount(1,Reservation::all());
        $this->assertEquals($book->id,Reservation::first()->book_id);
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals(today(),Reservation::first()->checked_out_at);

    }

    //a book can be checked in 

    /** @test **/

    public function a_book_can_be_checked_in(){
        
        $book = Book::factory()->create();
        
        $user =  User::factory()->create();

        $book->checkedOut($user);
        
        $book->checkedIn($user);

        $this->assertCount(1,Reservation::all());
      
        $this->assertEquals($book->id,Reservation::first()->book_id);
     
        $this->assertEquals($user->id,Reservation::first()->user_id);
     
        $this->assertEquals(today(),Reservation::first()->checked_in_at);


    }

    //a book if not chekced out trown an exeption
    
    /** @test **/

    public function a_book_cannot_be_ckecked_in_without_being_first_checked_out()
    {   
        $this->expectException(Exception::class);

        $book = Book::factory()->create();
        
        $user =  User::factory()->create();

        $book->checkedIn($user);

        $this->assertCount(1,Reservation::all());
      
        $this->assertEquals($book->id,Reservation::first()->book_id);
     
        $this->assertEquals($user->id,Reservation::first()->user_id);
     
        $this->assertEquals(today(),Reservation::first()->checked_in_at);
    }
    
    
          /** @test **/
        public function a_book_can_be_checked_out_twice()
        {
            $book = Book::factory()->create();
        
            $user =  User::factory()->create();
    
            $book->checkedOut($user);
            
            $book->checkedIn($user);

            $book->checkedOut($user);

            $this->assertCount(2,Reservation::all());
      
            $this->assertEquals($book->id,Reservation::first()->book_id);
         
            $this->assertEquals($user->id,Reservation::first()->user_id);
         
            $this->assertEquals(today(),Reservation::first()->checked_in_at);
        }

}
