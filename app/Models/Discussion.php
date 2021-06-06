<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Notifications\ReplyMarkedAsBestReply;

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

        //this means if the owner of discussion make his reply as best reply,
        //.. he won't recieve a notification for that: 
        if($reply->owner->id === $this->author->id){
            return;
        }

        $reply->owner->notify(new ReplyMarkedAsBestReply($reply->discussion));
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


    public function scopeFilterByChannels($builder){
        if(request()->query('channel')){
            //filter
            $channel = Channel::where('slug', request()->query('channel'))->first();

            if($channel){
                return $builder->where('channel_id', $channel->id);
            }
        };

        return $builder;
    }
}
