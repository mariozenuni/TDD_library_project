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
       //    $this->withoutExceptionHandling();
        
            $book = Book::factory()->create();
            // acting as a logged in user 
            $response = $this->actingAs($user = User::factory()->create())
                 ->post('/reservation/'.$book->id);
           
        $this->assertCount(1,Reservation::all());
        $this->assertEquals($book->id,Reservation::first()->book_id);
        $this->assertEquals($user->id,Reservation::first()->user_id);
        $this->assertEquals(today(),Reservation::first()->checked_out_at);

        $response->assertRedirect('/reservation/'.$book->id);
        
    }
}
