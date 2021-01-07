@extends('admin.layout.base')
@section('title', 'Create Product')
@section('data-page-id', 'adminProduct')

@section('content')

    <div class="add-product admin_shared grid-container full" >

        <div class="grid-x grid-padding-x">
            <div class="cell medium-12">
                <h2 class="text-center">Add Product</h2><hr>
            </div>
        </div>

        @include('includes.message')

        <form action="/admin/product/create/update" method="post" enctype="multipart/form-data">

            <div class="grid-x grid-padding-x">


                    {{-- PRODUCT NAME --}}
                    <div class="small-12 medium-6 cell">
                        <label for="name">Product Name</label>
                        <input type="text" name="name" placeholder="Product Name" value="{{ \App\classes\Request::oldData('post', 'name') }}">
                    </div>

                    {{-- PRODUCT PRICE --}}
                    <div class="small-12 medium-6 cell">
                        <label for="price">Product Price</label>
                        <input type="text" name="price" placeholder="Product Price" value="{{ \App\classes\Request::oldData('post', 'price') }}">
                    </div>




                    {{-- PRODUCT CATEGORY --}}
                    <div class="small-12 medium-6 cell">
                        <label for="product-category">Product Category</label>
                        <select name="category" id="product-category">
                            <option value="{{ \App\classes\Request::oldData('post', 'category')? : '' }}">
                                {{ 'Select Category' }}
                            </option>

                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                @endforeach
                        </select>
                    </div>

                    {{-- PRODUCT SUBCATEGORY --}}
                    <div class="small-12 medium-6 cell">
                        <label for="subcategory">Product Subcategory</label>
                        <select name="product-subcategory" id="product-subcategory">
                            <option value="{{ \App\classes\Request::oldData('post', 'subcategory')? : '' }}">
                                {{ 'Select Subcategory' }}
                            </option>
                        </select>
                    </div>





                    {{-- PRODUCT QUANTITY --}}
                    <div class="small-12 medium-6 cell">
                        <label for="quantity">Product Quantity</label>
                        <select name="quantity" id="product-quantity">
                            <option value="{{ \App\classes\Request::oldData('post', 'quantity')? : '' }}">
                                {{ \App\classes\Request::oldData('post', 'quantity')? : 'Select Quantity' }}
                            </option>

                            @for($i = 1; $i <= 50; $i++)
                                <option value="{{ $i }}"> {{ $i }} </option>
                                @endfor

                        </select>
                    </div>

                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

                    {{-- PRODUCT IMAGE --}}
                    <div class="small-12 medium-6 cell">
                        <br>
                        <div class="input-group">
                            {{--<span class="input-group-label">Product Image</span>--}}

                            <label for="upload-file" class="button"><i class="fa fa-upload" aria-hidden="true"></i> &nbsp; Upload Image</label>
                            <input type="file" name="productImage" class="input-group-field show-for-sr" id="upload-file" >
                        </div>
                    </div>

                    {{-- PRODUCT DESCRIPTION --}}
                    <div class="cell">
                        <label for="description">Description</label>
                        <textarea name="description" id="" placeholder="Description">{{\App\classes\Request::oldData('post', 'description')}}</textarea>
                        <button class="button alert" type="reset">Reset</button>
                        <input class="button success float-right" type="submit" value="Save Product">
                    </div>



            </div>

        </form>



    </div>
        @include('includes.delete-model')
@endsection

