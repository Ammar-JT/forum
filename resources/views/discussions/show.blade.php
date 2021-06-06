@extends('layouts.app')

@section('content')


<div class="card mb-5">
    @include('partials.discussion-header')


    <div class="card-body">
        <div class="text-center">    
            <strong>{!!$discussion->title!!}</strong>
        </div>
        <hr>
        {!!$discussion->content!!}
        <hr>
        @if ($discussion->bestReply)
            <div class="card bg-success" style="color:white;">
                <div class="card-header">
                    
                    <div class="d-flex justify-content-between">
                        <div>
                            <img width='40px' style='border-radius:50%;' src="{{Gravatar::src($discussion->bestReply->email)}}" alt="">
                            <span>{{$discussion->bestReply->owner->name}}</span>
                        </div>
        
                        <div>
                            Best Reply
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    {!!$discussion->bestReply->content!!}
                </div>
            </div>
        @endif
    </div>
</div>   

<!-- replies -->
@foreach ($discussion->replies()->paginate(3) as $reply)
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <div>
                    <img width='40px' style='border-radius:50%;' src="{{Gravatar::src($reply->owner->email)}}" alt="">
                    <span>{{$reply->owner->name}}</span>
                </div>

                <div>
                    @auth
                        @if (auth()->user()->id === $discussion->user_id)
                        <form action="{{route('discussion.best-reply', ['discussion' => $discussion->slug, 'reply' => $reply->id])}}" method='POST'>
                            @csrf
                            <button type='submit' class='btn btn-sm btn-primary'>Mark as Best</button>
                        </form>
                        @endif
                    @endauth  
                </div>
            </div>
        </div>

        <div class="card-body">
            {!! $reply->content !!}
        </div>
    </div>
@endforeach
{{$discussion->replies()->paginate(3)->links()}}


<!-- add reply -->
<div class="card my-5">

    <div class="card-header">
        Add a reply
    </div>

    <div class="card-body">
        @include('partials.messages')
        @auth
            <form action="{{route('replies.store', $discussion->slug)}}" method="POST">
                @csrf
                <input type="hidden" name="content" id="content">
                <trix-editor input="content"></trix-editor>
                <button class="btn btn-success btn-sm my-2" type="submit">
                    Add Reply
                </button>
            </form>
        @else
            <a href="{{route('login')}}" class="btn btn-info w-100">Sign in to add a reply</a>
        @endauth
    </div>
</div>



@endsection


@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.css">
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.3.1/trix.js"></script>
@endsection