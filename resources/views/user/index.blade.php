@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session('succ'))
                <div class="alert alert-success alertBox">
                    {{ session('thongbao') }}
                </div>
            @endif
            <a class="btn btn-primary" href="{{ route('user.add') }}">Add</a>
        </div>
        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                {{--display user--}}
                @foreach($listUser as $user)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{ route('user.edit', ['id'=>$user->id] ) }}" class="btn btn-primary" role="button">Edit</a>
                            <a href="{{ route('user.delete', ['id'=>$user->id]) }}" class="btn btn-danger" role="button">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection