@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="{{ route('user.update', ['id' => $user->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">name:</label>
                        <input value="{{ $user->name }}" type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="email">email:</label>
                        <input value="{{ $user->email }}" type="email" class="form-control" name="email" id="email" placeholder="Enter email">
                    </div>
                    {{--<div class="form-group">--}}
                    {{--<label for="re-password">re-password:</label>--}}
                    {{--<input type="password" class="form-control" name="re-password" id="re-password" placeholder="Enter re-password">--}}
                    {{--</div>--}}
                    <div class="form-group">
                        <select name="roles[]" id="roles" multiple="multiple">
                            @foreach($roles as $role)
                                <option
                                        <?php
                                            foreach ($listRoleOfUser as $role_user)
                                                {
                                                    if ($role_user->role_id == $role->id)
                                                        echo 'selected';
                                                }
                                        ?>
                                        value="{{ $role->id }}">
                                    {{ $role->display_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{--@foreach($listRoleOfUser as $list)--}}
                        {{--@if($list->user_id == $role->id)--}}
                            {{--{{ 'selected' }}--}}
                        {{--@endif--}}
                        {{--{{ $list->id }}--}}
                    {{--@endforeach--}}
                    <?php //var_dump($listRoleOfUser) ?>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection