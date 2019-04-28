@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="{{ route('user.store') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">name:</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">email:</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                    </div>
                    {{--<div class="form-group">--}}
                        {{--<label for="re-password">re-password:</label>--}}
                        {{--<input type="password" class="form-control" name="re-password" id="re-password" placeholder="Enter re-password">--}}
                    {{--</div>--}}

                    <select name="roles[]" id="roles" multiple="multiple">
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-default">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection