<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discussion extends Model
{
    use HasFactory;
//--------------------------------------------------------------------------
//                  Customize Models Relationship (functions name)
//--------------------------------------------------------------------------
    public function author(){
        //here we must specify the forign key cuz we change the function name to author()
        return $this->belongsTo(User::class, 'user_id');
        
    }


//--------------------------------------------------------------------------
//                  OverRide Route's Model Binding (discussions/{id} to dissussions/{slug or title or..})
//--------------------------------------------------------------------------

    public function getRouteKeyName(){
        return 'slug';
    }

    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function markAsBestReply(Reply $reply){
        $this->update([
            'reply_id' => $reply->id
        ]);
    }

    /*
    public function getBestReply(){
        return Reply::find($this->reply->id)
    }
    */
    //or we can use a relationship: 
    public function bestReply(){
        return $this->belongsTo(Reply::class, 'reply_id');
    }
}
