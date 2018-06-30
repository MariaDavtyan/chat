@extends('layout.base')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="list-group">
                    <div class="list-group-item list-group-item-action">
                        <div class="float-left">
                            <img src="/storage/group_images/{{ $chat_info->image }}" class="img-thumbnail" alt="" width="100" height="100">
                        </div>
                        <h1 class="text-justify">{{ $chat_info->chat_name }}</h1>
                    </div>
                </div>
                <div id="{{ $chat_info->chat_name }}" class="chat-div chat-div-private">
                    <ul class="list-group message-container media border {{ $chat_info->chat_name }}">
                        @foreach($privatechat as $value)
                            <div class="media-body">
                                <h5>
                                    {{ $value->username }}
                                    <small><i>Posted on {{ $value->created_at }}</i></small>
                                </h5>
                                <li class="list-group-item">{{ $value->message }}</li>
                            </div>
                        @endforeach
                    </ul>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control message_area" rows="5" name="text"></textarea>
                    </div>
                    <button type="button" class="btn btn-primary send-message" data-id="{{ $chat_info->id }}">Send</button>
                </div>
            </div>
        </div>
    </div>
@endsection
