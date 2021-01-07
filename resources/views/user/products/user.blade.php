@extends('admin.layout.base')
@section('title', 'Users Details')
@section('data-page-id', 'users')

@section('content')


    <div class="users admin_shared grid-container full" id="user-search">

            <div class="grid-x grid-padding-x">
                <div class="cell">
                    <h2 class="text-center">Manage {{ ucfirst($role) }}</h2><hr>
                </div>
            </div>


        <div class="row expanded">
            <div class="small-12 medium-12 column">
                <form action="" method="post" class="small-12 medium-5 ">
                    <div class=" input-group">
                        <input type="text" class="input-group-field" placeholder="Search User" id="searchUserField" name="search_field" value="{{ \App\classes\Request::oldData('post','search_field') }}" data-token="{{ \App\Classes\CSRFToken::generate() }}">
                        <div class="input-group-button">
                            <input type="button" value="Search" class="button search-user" @click.prevent="search_{{ $role }}">
                        </div>
                    </div>
                </form>

            </div>
            {{--DISPLAY SPINNER CUBE IF VUE JS LOADING IS TRUE--}}
            <div class="text-center">
                <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >
            </div>

            <div v-if="showSearch" >


                    <div class="row expanded">
                        <div class="small-12 medium-11 column">
                            {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                            <table class="hover unstriped small-12" data-form="userDelete">
                                <thead>
                                <tr>
                                    <td>Username</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Phone#</td>
                                    <td>Location</td>
                                    <td>Role</td>
                                    <td width="70">Action</td>
                                </tr>
                                </thead>

                                <tbody>



                                    <tr v-for="searchUser in searchUsers" v-cloak>
                                        {{--<td><img src="/{{ $product['image_path'] }}" alt="{{ $product['name'] }}" width="40" height="40"></td>--}}
                                        <td>@{{ searchUser.username }}</td>
                                        <td>@{{ searchUser.fullname }}</td>
                                        <td>@{{ searchUser.email }}</td>
                                        <td>@{{ searchUser.phone }}</td>
                                        <td>@{{ searchUser.country_name }}</td>
                                        <td>@{{ searchUser.role }}</td>


                                        <td width="50" class="text-center">
                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit User" >
                                                <a :href="'/admin/user/'+searchUser.id+'/edit'"><i class="fa fa-edit" title="Edit User"></i></a>
                                            </span>
                                                &nbsp;

                                                <span data-tooltip class="has-tip top" tabindex="1" title="Delete User">
                                                <form :action="'/admin/user/'+searchUser.id+'/deleteuser'" method="post" class="delete-user">
                                                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                    <button type="button"><i class="fa fa-times delete" @click="confirmDelete"></i></button>
                                                </form>
                                            </span>

                                        </td>


                                    </tr>



                                @include('includes.delete-model')

                                </tbody>
                            </table>

                            {{--@if(count($links))--}}
                                {{--{!! $links !!}--}}

                            {{--@endif--}}


                        </div>
                    </div>

                <div v-if="searchUsers.length == 0">
                    <div class="column">
                        <h2>The {{ $role }} you are looking for is not available</h2>
                    </div>
                </div>


            </div >

            <div v-else>
                @if(count($users))

                    <div class="row expanded">
                        <div class="small-12 medium-11 column">
                            {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                            <table class="hover unstriped small-12" data-form="userDelete">
                                <thead>
                                <tr>
                                    <td>Username</td>
                                    <td>Full Name</td>
                                    <td>Email</td>
                                    <td>Phone#</td>
                                    <td>Location</td>
                                    <td>Role</td>
                                    <td width="70">Action</td>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($users as $user)

                                    <tr>
                                        {{--<td><img src="/{{ $product['image_path'] }}" alt="{{ $product['name'] }}" width="40" height="40"></td>--}}
                                        <td>{{ $user['username'] }}</td>
                                        <td>{{ $user['fullname'] }}</td>
                                        <td>{{ $user['email'] }}</td>
                                        <td>{{ $user['phone'] }}</td>
                                        <td>{{ $user['country_name'] }}</td>
                                        <td>{{ $user['role'] }}</td>


                                        <td width="50" class="text-center">
                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit User" >
                                                <a href="/admin/user/{{ $user['id'] }}/edit"><i class="fa fa-edit" title="Edit User"></i></a>
                                            </span>
                                                &nbsp;

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Delete User">
                                                <form action="/admin/user/{{ $user['id'] }}/deleteuser" method="post" class="delete-user">
                                                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                    <button type="button"><i class="fa fa-times delete" @click="confirmDelete"></i></button>
                                                </form>
                                            </span>

                                        </td>


                                    </tr>

                                @endforeach

                                @include('includes.delete-model')

                                </tbody>
                            </table>

                            @if(count($links))
                                {!! $links !!}

                            @endif


                        </div>
                    </div>

                @else
                    <div class="row expanded">
                        <div class="column small-12">
                            <h2>The {{ $role }} you are looking for is not available</h2>
                        </div>
                    </div>

                @endif
            </div>





        </div>



        @endsection


    </div>

