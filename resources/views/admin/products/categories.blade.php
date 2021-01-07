@extends('admin.layout.base')
@section('title', 'Product Category')
@section('data-page-id', 'adminCategory')

@section('content')

    <div class="category admin_shared grid-container full">

        <div class="grid-x grid-padding-x">
            <div class="cell">
                <h2 class="text-center">Product Categories</h2><hr>
            </div>
        </div>


        <div class="grid-padding-x grid-x">
            {{--SEARCH CONTAINER--}}
            <div class="small-12 medium-6 cell">
                {{--SEARCH FORM--}}
                <form action="" method="post">
                    {{--SEARCH INPUT CONTAINER--}}
                    <div class="input-group">
                        <input type="text" class="input-group-field" placeholder="Search by name">

                        <div class="input-group-button">
                            <input type="submit" value="Search" class="button">
                        </div>
                    </div>

                    {{--END SEARCH INPUT CONTAINER--}}
                </form>
                {{--END SEARCH FORM--}}
            </div>
            {{--END SEARCH CONTAINER--}}

            {{--CATEGORY CONTAINER--}}
            <div class="small-12 medium-6 end cell">
                {{--CATEGORY FORM--}}
                <form action="" method="post">
                    {{--CATEGORY INPUT CONTAINER--}}
                    <div class="input-group">
                        <input type="text" class="input-group-field" name="name" placeholder="Category Name">
                        <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                        <div class="input-group-button">
                            <input type="submit" value="Create" class="button">
                        </div>
                    </div>

                    {{--END CATEGORY INPUT CONTAINER--}}
                </form>
                {{--END CATEGORY FORM--}}
            </div>
            {{--END CATEGORY CONTAINER--}}

        </div>
        {{-- INCLUDE MESSAGE FILE --}}

        <div class="cell">
            @include('includes.message')
        </div>


        <div class="grid-x grid-padding-x">
            <div class="small-12 medium-12 cell">

                @if(count($categories))

                    {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                    <table class="hover unstriped" data-form="deleteForm">
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Slug</td>
                                <td>Created On</td>
                                <td width="70">Action</td>
                            </tr>
                        </thead>

                        <tbody>

                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category['name'] }}</td>
                                        <td>{{ $category['slug'] }}</td>
                                        <td>{{ $category['added'] }}</td>

                                        <td width="70" class="text-right">
                                            <span data-tooltip class="has-tip top" tabindex="1" title="Add Sub-Category">
                                                <a data-open="add-subcategory-{{ $category['id'] }}"><i class="fa fa-plus"></i></a>
                                            </span>

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Category">
                                                <a data-open="item-{{ $category['id'] }}"><i class="fa fa-edit"></i></a>
                                            </span>

                                            <span style="display: inline-block" data-tooltip class="has-tip top" tabindex="1" title="Delete Category">
                                                <form action="/admin/product/categories/{{ $category['id'] }}/delete" method="post" class="delete-item">
                                                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                    <button type="submit"><i class="fa fa-times delete"></i></button>
                                                </form>

                                            </span>

                                            @include('includes.add-subcategory-model')
                                            @include('includes.edit-model')
                                            @include('includes.delete-model')
                                        </td>
                                        @endforeach
                                    </tr>

                        </tbody>
                    </table>
                    @if($catLinks)
                        {{-- DISPLAY CATEGORY LINKS --}}
                        {!! $catLinks !!}

                    @endif

                    @else
                    <div class="cell">
                        <h2>There is no Category Available</h2>
                    </div>

                @endif

            </div>
        </div>

    </div>

{{-- ------------------------------------------------------------------------------------------------------------------- --}}

    <div class="subcategory admin_shared grid-container full">

        <div class="grid-x grid-padding-x">
            <div class="cell medium-11">
                <h2 class="text-center">Product Sub Categories</h2><hr>
            </div>

        </div>



        <div class="grid-padding-x grid-x">
            <div class="small-12 medium-16 cell">

                @if(count($subcategories))

                    {{-- POPULATE THE TABLE WITH THE DB CATEGORY VALUES--}}
                    <table class="hover unstriped" data-form="deleteForm">
                        <thead>
                        <tr>
                            <td>Name</td>
                            <td>Slug</td>
                            <td>Created On</td>
                            <td width="50">Action</td>
                        </tr>
                        </thead>

                        <tbody>

                        @foreach($subcategories as $subcategory)
                            <tr>
                                <td>{{ $subcategory['name'] }}</td>
                                <td>{{ $subcategory['slug'] }}</td>
                                <td>{{ $subcategory['added'] }}</td>

                                <td width="50" class="text-right">

                                            <span data-tooltip class="has-tip top" tabindex="1" title="Edit Sub Category">
                                                <a data-open="item-subcategory-{{ $subcategory['id'] }}"><i class="fa fa-edit"></i></a>
                                            </span>
                                            {{--DELETE FORM--}}
                                            <span style="display: inline-block" data-tooltip class="has-tip top" tabindex="1" title="Delete Sub Category">
                                                <form action="/admin/product/subcategory/{{ $subcategory['id'] }}/delete" method="post" class="delete-item">
                                                    <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">
                                                    <button type="submit"><i class="fa fa-times delete"></i></button>
                                                </form>

                                            </span>

                                    @include('includes.edit-subcategory-model')
                                    @include('includes.delete-model')
                                </td>
                                @endforeach
                            </tr>

                        </tbody>
                    </table>

                    {{-- DISPLAY CATEGORY LINKS --}}

                    {!! $subcategoryLinks !!}

                @else
                        <h3>There is no Sub Category Available</h3>

                @endif

            </div>
        </div>

    </div>

@endsection

