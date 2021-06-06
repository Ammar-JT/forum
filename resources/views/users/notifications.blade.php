@extends('layouts.app')

@section('content')
<div class="card">
    
    <div class="card-header">Notifications</div>

    <div class="card-body">
        @foreach ($notifications as $notification)
            <li class="list-group-item">
                @if ($notification->type === 'App\Notifications\NewReplyAdded')
                    A new reply was added to your discussion  <strong>{{$notification->data['discussion']['title']}}</strong>
                    <!-- why $notification->data['discussion']['slug']? cuz this is the data we store using the NewReplyAdded.php
                        as we store the whole record of the discussion -->
                    <a href="{{route('discussions.show', $notification->data['discussion']['slug'])}}" class="btn float-right btn-sm btn-info ">
                        View Discussion
                    </a>
                @elseif($notification->type === 'App\Notifications\ReplyMarkedAsBestReply')
                    Your reply was marked as best reply in the discussion <strong>{{$notification->data['discussion']['title']}}</strong>
                    <a href="{{route('discussions.show', $notification->data['discussion']['slug'])}}" class="btn float-right btn-sm btn-info ">
                        View Discussion
                    </a>
                 
                @endif
            </li>
        @endforeach
    </div>
</div>
@endsection
