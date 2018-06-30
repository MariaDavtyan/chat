@extends('layout.base')
@section('content')
    <div class="container">
        <div class="row">
           {{-- User info & chat list container--}}
            <div class="col-6">
                {{--Authentificated users block--}}
                @if(Auth::user())
                    <span>Welcome <strong>{{{ isset(Auth::user()->name) ? Auth::user()->name : Auth::user()->email }}}</strong></span>
                    <span>
                        <a href="{{ url('logout') }}">Logout</a>
                    </span>
                    <p>
                        <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#demo">Add group</button>
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{session('success')}}
                        </div>
                    @endif
                    <div id="demo" class="collapse">
                        <form action="{{ route('addgroup') }}" method="post" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" class="form-control" id="group-name" name="chat_name" required>
                                @if($errors->has('chat_name'))
                                    {{ $errors->first('chat_name') }}
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="image">Image:</label>
                                <input type="file" class="form-control-file border" name="image" required>
                                @if($errors->has('image'))
                                    {{ $errors->first('image') }}
                                @endif
                            </div>
                            <div class="form-group">
                                <span>User access to chat:</span>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="radio1">
                                    <input type="radio" class="form-check-input" id="radio1" name="optradio" value="allusers" checked>All users
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="radio2">
                                    <input type="radio" class="form-check-input" id="radio2" name="optradio" value="loggedinusers">Logged in users
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="radio2">
                                    <input type="radio" class="form-check-input" id="radio3" name="optradio" value="privatechat">Private chat
                                </label>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success addgroup-submit">Submit</button>
                            </div>
                        </form>
                    </div>
                    </p>
                @else
                    {{--Logged out users block--}}
                    <button data-toggle="collapse" data-target="#login" class="btn btn-default btn-md">Login</button>
                    <div id="login" class="collapse">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{session('error')}}
                            </div>
                        @endif
                        <form action="{{ route('login') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                @if($errors->has('email'))
                                    {{ $errors->first('email') }}
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="pwd">Password:</label>
                                <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password">
                                @if($errors->has('password'))
                                    {{ $errors->first('password') }}
                                @endif
                            </div>
                            <button type="submit" class="btn btn-success">Submit</button>
                        </form>
                    </div>
                @endif
                {{--Chats' list--}}
                <div class="list-group"  style="margin-top:30px;">
                    @foreach($chats as $value)
                        <div class="list-group-item list-group-item-action" >
                            <img src="/storage/group_images/{{$value->image}}" class="img-thumbnail chat-thumbnail" alt="" width="100" height="100">
                            <div class="chat-info-container">
                                <a href="#{{ $value->chat_name }}" data-toggle="collapse" class="chat-name-link" data-id="{{ $value->id }}">
                                    {{ $value->chat_name }}
                                </a>
                                @if($value->access == "privatechat")
                                    <p>
                                        <p>Private chat access link:</p>
                                        <a href="{{$base_url. '/privatechat/'. $value->private_chat }}" target="_blank">
                                            {{$base_url. '/privatechat/'. $value->private_chat }}
                                        </a>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

           {{-- messages container--}}
            <div class="col-6 chat-container"></div>
        </div>
    </div>
@endsection