<?php

namespace App\Models;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function path()
    {
       return 'books/'.$this->id;
       // return 'books/'.$this->id . '-' . Str::slug($this->title);
    }


   public function setAuthoridAttribute($author){
         $this->attributes['author_id'] = ( Author::firstOrCreate(
            [ 'name' => $author]))->id;
 }



 public function checkedOut(User $user){
    return (Auth::user())?
      $this->reservations()->create([
         'user_id' => $user->id,
         'checked_out_at' =>Carbon::today()
      ]) : false;
 }

 public function reservations(){
   return $this->hasMany(Reservation::class);
 }
 public function checkedIn($user){

   $reservation = $this->reservations()
   ->where('user_id',$user->id)
   ->whereNotNull('checked_out_at')
   ->whereNull('checked_in_at')
   ->first();

   if(is_null($reservation)){
       throw new Exception('Error: you cannot check in without first check out');
   }
   $reservation->update([
      'checked_in_at' => Carbon::today()
   ]);
}
}
