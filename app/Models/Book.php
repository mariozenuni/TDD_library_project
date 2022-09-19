<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Exception;
use Carbon\Carbon;

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



 public function checkedOut($user){

      $this->reservations()->create([
         'user_id' => $user->id,
         'checked_out_at' =>Carbon::today()
      ]);
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
