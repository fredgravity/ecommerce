@extends('admin.layout.base')
@section('title', 'Vendor Verify')
@section('data-page-id', 'vendorVerify')

@section('content')


    <div class="vendor admin_shared grid-container full" id="vendor-search">

            <div class="grid-x grid-padding-x">
                <div class="cell medium-12">
                    <h2 class="text-center">Verify Certificate</h2><hr>
                </div>
            </div>

        <div class="notify text-center"></div>

        <div class="grid-padding-x grid-x">
            <div class="small-12 medium-6 cell">
                <form action="" method="post" class="small-12 medium-5 ">
                    <div class=" input-group">
                        <input type="text" class="input-group-field" placeholder="Search Certificate" id="searchVendorField" name="search_field" value="{{ \App\classes\Request::oldData('post','search_field') }}" data-token="{{ \App\Classes\CSRFToken::generate() }}">
                        <div class="input-group-button">
                            <input type="button" value="Search" class="button search-vendor" @click.prevent="search">
                        </div>
                    </div>
                </form>

            </div>


            <div class="text-center">
                <img src="/images/spinners/cube.gif" alt="loader" v-show="loading" class="cube-loader" style="width: 100px; height: 100px; padding-bottom: 3rem;" >
            </div>

            <div class="notification callout primary"></div>

            <div v-if="showSearch" class="small-12 medium-12 cell">




                            {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                            <table class="hover unstriped small-12" data-form="userDelete">
                                <thead>
                                <tr>
                                    <td>Brand Name</td>
                                    <td>Id Card</td>
                                    <td>Business Certificate</td>
                                    <td>Date</td>
                                    <td width="70">Approval</td>
                                </tr>
                                </thead>

                                <tbody>



                                    <tr v-for="searchUser in searchUsers" v-cloak>

                                        <td>@{{ searchUser.vendor_detail.brand_name }}</td>
                                        <td><img :src="'/'+searchUser.vendor_detail.id_card" alt="" style="width: 300px; height: 200px;"></td>
                                        <td><img :src="'/'+searchUser.vendor_detail.business_cert" alt="" style="width: 300px; height: 200px;"></td>
                                        <td>@{{ searchUser.vendor_detail.updated_at }}</td>

                                        <td width="50" class="text-center">
                                            <input type="checkbox" class="switch-input" name="switch_input"  :id="'checkbox'+searchUser.id" @change="approved(searchUser.id)" data-token="{{ \App\Classes\CSRFToken::generate() }}" :data-user="searchUser.id">
                                            <label :for="'checkbox'+searchUser.id" class="switch-paddle">
                                                <span class="show-for-sr"></span>
                                                <span class="switch-active" aria-hidden="true">Yes</span>
                                                <span class="switch-inactive" aria-hidden="false">No</span>

                                            </label>

                                        </td>

                                    </tr>



                                @include('includes.delete-model')

                                </tbody>
                            </table>



                <div v-if="searchUsers.length == 0">
                    <div class="column">
                        <h2>The {{ $role }} you are looking for is not available</h2>
                    </div>
                </div>


            </div >

            <div v-else class="small-12 medium-12 cell" >
                {{--{{ pnd($users) }}--}}
                @if(count($users))



                            {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                            <table class="hover unstriped" data-form="userDelete">
                                <thead>
                                <tr>
                                    <td>Brand Name</td>
                                    <td>Id Card</td>
                                    <td>Business Certificate</td>
                                    <td>Date
                                    <td width="70">Approval</td>
                                </tr>
                                </thead>

                                <tbody>

                                @foreach($users as $user)

                                    <tr>
                                        <td>{{ $user['brandname'] }}</td>
                                        <td><img src="/{{ $user['id_card'] }}" alt="" style="width: 300px; height: 200px;"></td>
                                        <td><img src="/{{ $user['cert'] }}" alt="" style="width: 300px; height: 200px;"></td>
                                        <td>{{ $user['updated'] }}</td>

                                        <td width="50" class="text-center">
                                            <input type="checkbox" class="switch-input" name="switch_input" id="checkbox{{ $user['id'] }}" @change="approved({{ $user['id'] }})" data-token="{{ \App\Classes\CSRFToken::generate() }}" data-user="{{ $user['id'] }}">
                                            <label for="checkbox{{ $user['id'] }}" class="switch-paddle">
                                                <span class="show-for-sr"></span>
                                                <span class="switch-active" aria-hidden="true">Yes</span>
                                                <span class="switch-inactive" aria-hidden="false">No</span>

                                            </label>

                                        </td>


                                    </tr>

                                @endforeach

                                @include('includes.delete-model')

                                </tbody>
                            </table>

                            @if(count($links))
                                {!! $links !!}

                            @endif

                @else
                    <div class="grid-x grid-padding-x">
                        <div class="cell">
                            <h2>The {{ $role }} you are looking for is not available</h2>
                        </div>
                    </div>

                @endif
            </div>





        </div>



        @endsection


    </div>

