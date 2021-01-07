@extends('admin.layout.base')
@section('title', 'Manage Inventory')
@section('data-page-id', 'adminProduct')

@section('content')

    <div class="products admin_shared grid-container">
{{--{{ pnd($products) }}--}}
        <div class="cell">
                <h2 class="text-center">Search Inventory Results ({{ $total }})</h2><hr>
        </div>


        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-7 cell">
                <form action="" method="post" class="grid-x grid-padding-x">

                    <div class="input-group medium-6 cell">
                        <input type="text" class="input-group-field" placeholder="Search by name" name="search_field" value="{{ \App\classes\Request::oldData('post','search_field') }}">
                        <div class="input-group-button">
                            <input type="submit" value="Search" class="button search-product" >
                        </div>

                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                    </div>

                    <div class="medium-3 cell">
                        <select name="category" id="product-category">
                            <option value="{{ \App\classes\Request::oldData('post', 'category')? : '' }}">
                                {{ 'Select Category' }}
                            </option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="medium-3 cell">
                        <select name="subCategory" id="product-subcategory">
                            <option value="{{ \App\classes\Request::oldData('post', 'subcategory')? : '' }}">
                                {{ 'Select Subcategory' }}
                            </option>
                        </select>
                    </div>

                </form>
            </div>

        </div>

        {{--INCLUDE MESSAGE--}}
        @include('includes.message')


        <div class="grid-x grid-padding-x">
            <div class="cell search-table">

                @if(count($products))
                    {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                    <table class="hover unstriped table-data-scroll" data-form="deleteForm">

                        <thead>
                        <tr>
                            <td>Image</td>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Quantity</td>
                            <td>Category</td>
                            <td>Subcategory</td>
                            <td>Created On</td>
                            <td width="70">Action</td>
                        </tr>

                        <tbody id="body-scroll">

                                @foreach($products as $product)

                                    <tr>
                                        <td><img src="/{{ $product['image_path'] }}" alt="{{ $product['name'] }}" width="40" height="40"></td>
                                        <td>{{ $product['name'] }}</td>
                                        <td>{{ $product['price'] }}</td>
                                        <td>{{ $product['quantity'] }}</td>
                                        <td>{{ $product['category']['name'] }}</td>
                                        <td>{{ $product['subCategory']['name'] }}</td>
                                        <td>{{ $product['created_at'] }}</td>

                                        <td width="70" class="text-right">

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Product">
                                                <a href="/admin/product/{{ $product['id'] }}/edit"> Edit <i class="fa fa-edit"></i></a>
                                            </span>

                                        </td>
                                        @endforeach
                                    </tr>

                        </tbody>

                    </table>
                    {{--@if($productLinks)--}}
                        {{-- DISPLAY CATEGORY LINKS --}}
                        {{--{!! $productLinks !!}--}}

                    {{--@endif--}}


                    @else
                    <div class="cell">
                        <h2>There is no Product Available</h2>
                    </div>

                @endif

            </div>
        </div>

    </div>

{{-- ------------------------------------------------------------------------------------------------------------------- --}}



@endsection

