@extends('admin.layout.base')
@section('title', 'Edit Product')
@section('data-page-id', 'adminProduct')

@section('content')

    <div class="add-product admin_shared grid-container full">

        <div class="grid-x grid-padding-x">
            <div class="cell">
                <h2 class="text-center">Edit - {{ $products->name }}</h2><hr>
            </div>
        </div>

        @include('includes.message')

        <form action="/admin/product/edit" method="post" enctype="multipart/form-data">

            <div class="grid-x grid-padding-x">


                    {{-- PRODUCT NAME --}}
                    <div class="small-12 medium-6 cell">
                        <label for="name">Product Name</label>
                        <input type="text" name="name"  value="{{ $products->name }}">
                    </div>

                    {{-- PRODUCT PRICE --}}
                    <div class="small-12 medium-6 cell">
                        <label for="price">Product Price</label>
                        <input type="text" name="price" value="{{ $products->price }} ">
                    </div>




                    {{-- PRODUCT CATEGORY --}}
                    <div class="small-12 medium-6 cell">
                        <label for="category">Product Category</label>
                        <select name="category" id="product-category">
                            <option value="{{ $products->category->id }}">
                                {{ $products->category->name }}
                            </option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                @endforeach
                        </select>
                    </div>


                    {{-- PRODUCT SUBCATEGORY --}}
                    <div class="small-12 medium-6 cell">
                        <label for="subcategory">Product Subcategory</label>
                        <select name="subcategory" id="product-subcategory">
                            <option value="{{ $products->subCategory->id }}">
                                {{ $products->subCategory->name }}
                            </option>
                        </select>
                    </div>





                    {{-- PRODUCT QUANTITY --}}
                    <div class="small-12 medium-6 cell">
                        <label for="quantity">Product Quantity</label>
                        <select name="quantity" id="product-quantity">
                            <option value="{{ $products->quantity }}">
                                {{ $products->quantity }}
                            </option>

                            @for($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}"> {{ $i }} </option>
                                @endfor

                        </select>
                    </div>


                    {{-- PRODUCT IMAGE --}}
                    <div class="small-12 medium-6 cell">
                        <br>
                        <div class="input-group">
                            <span class="input-group-label">Product Image</span>
                            <input type="file" name="productImage" class="input-group-field">
                        </div>
                    </div>


                    {{-- PRODUCT DESCRIPTION --}}
                    <div class="small-12 cell">
                        <label for="description">Description</label>
                        <textarea name="description" id="" placeholder="Description">{{ $products->description }}</textarea>
                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                        <input type="hidden" name="product_id" value="{{ $products->id }}">
                        <input class="button warning float-right" type="submit" value="Update Product">
                    </div>



            </div>

        </form>

        {{--DELETE BUTTON--}}
        <div class="grid-x grid-padding-x">

            <div class="small-12 medium-11 cell">
                <table data-form="deleteForm">
                    <tr style="border-style: hidden !important;">
                        <td style="border-style: hidden !important;">
                            <form action="/admin/product/{{ $products->id }}/delete" method="post" class="delete-item">
                                <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                <button type="submit" class="button alert float-left">Delete Product</button>
                            </form>
                        </td>
                    </tr>
                </table>
            </div>

        </div>


    </div>
        @include('includes.delete-model')




@endsection

