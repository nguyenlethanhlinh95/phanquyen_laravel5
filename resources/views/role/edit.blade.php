@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <form action="{{ route('role.update', ['id' => $role->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" value="{{ $role->name }}" class="form-control" name="name" id="name" placeholder="Enter name">
                    </div>
                    <div class="form-group">
                        <label for="display_name">Display name:</label>
                        <input type="text" value="{{ $role->display_name }}" class="form-control" name="display_name" id="display_name" placeholder="Enter display name">
                    </div>

                    @foreach($permissions as $permission)
                        <div class="form-check">
                            <input
                                <?php
                                    foreach ($getAllRolePermissions as $getAllRolePermission)
                                    {
                                        if ($permission->id == $getAllRolePermission)
                                            echo 'checked';
                                    }
                                ?>
                                    type="checkbox" class="form-check-input" id="exampleCheck1" name="permission[]" value="{{ $permission->id }}">
                            <label class="form-check-label">{{ $permission->display_name }}</label>
                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection