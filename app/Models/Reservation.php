<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Reservation extends Model
{
    use HasFactory;

    protected $guarded; 

  public function reservation(){
    return $this->belongsTo(Book::class);
  }

  public function reservations(){
    return $this->hasMany(User::class);
  }

}
