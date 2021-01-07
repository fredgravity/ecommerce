@extends('admin.layout.base')
@section('title', 'Edit User')
@section('data-page-id', 'editUser')

@section('content')

    <div class="edit-user admin_shared" id="edit-user">

        @foreach($users as $user)

        <div class="row expanded">
            <div class="column medium-11">
                <h2 class="text-center">Edit {{ ucfirst($user->role) }}</h2>
                <hr>
            </div>
        </div>

        @include('includes.message')

        <div class="row expanded">

            <div class="column small-12 medium-6">
                <form action="/admin/user/{{$user->id}}/update" method="post" enctype="multipart/form-data">

                    <fieldset class="fieldset">
                        <legend><h2>{{ ucfirst($user->role) }} Details</h2></legend>

                        <div>
                            <label for="username">Username:</label>
                            <input type="text" name="username" value="{{ $user->username }}" readonly="readonly">
                        </div>

                        <div>
                            <label for="fullname">Fullname:</label>
                            <input type="text" name="fullname" value="{{ $user->fullname }}">
                        </div>

                        <div>
                            <label for="email">Email:</label>
                            <input type="text" name="email" value="{{ $user->email }}" disabled>
                        </div>

                        <div>
                            <label for="country">Country:</label>
                            <input type="text" name="country" value="{{ $user->country_name }}">
                        </div>

                        <div>
                            <label for="state">State Name:</label>
                            <input type="text" name="state" value="{{ $user->state_name }}">
                        </div>


                        <div>
                            <label for="phone">Phone #:</label>
                            <input type="text" name="phone" value="{{ $user->phone }}">
                        </div>


                        <div>
                            <label for="city">Address:</label>
                            <input type="text" name="city" value="{{ $user->city }}">
                        </div>


                        <div>
                            <label for="upload" class="button">Upload Picture</label>
                            <input type="file" id="upload" name="upload" class="show-for-sr" >
                        </div>

                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                        <input type="submit" value="Update" class="button warning float-right">


                    </fieldset>

                </form>
            </div>



            <div class="column small-12 medium-5 end">

                <form action="/admin/user/{{ $user->id }}/changepassword" method="post" >
                    <fieldset class="fieldset">
                        <legend><h2>Change Password</h2></legend>
                        <div>
                            <label for="old_password">Old Password:</label>
                            <input type="password" name="old_password" placeholder="type in the old password">
                        </div>

                        <div>
                            <label for="new_password">New Password:</label>
                            <input type="password" name="new_password" placeholder="type in the new password">
                        </div>

                        <div>
                            <label for="confirm_password">Confirm Password:</label>
                            <input type="password" name="confirm_password" placeholder="confirm password">
                        </div>

                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                        <input type="submit"  value="Change" class="button warning float-right">
                    </fieldset>
                </form>

            </div>

        </div>



        @endforeach
    </div>













    @endsection