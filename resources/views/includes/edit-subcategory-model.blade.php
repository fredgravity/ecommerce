{{-- EDIT CATEGORY MODAL--}}
<div class="reveal" id="item-subcategory-{{ $subcategory['id'] }}" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h2>Edit Sub Category</h2>
    {{-- EDIT FORM --}}
    <form>
        <div class="input-group">

            <input type="text" name="name" id="item-subcategory-name-{{ $subcategory['id'] }}" value="{{ $subcategory['name'] }}">

            <label >Change Category
                <select  id="item-category-{{ $subcategory['category_id'] }}">

                    @foreach(\App\Models\Category::all() as $category)
                        @if($category->id == $subcategory['category_id'])
                            <option selected="selected" value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif

                        <option value="{{ $category->id }}">{{ $category->name }}</option>

                        @endforeach

                </select>
            </label>

            <div>
                <input type="submit" data-token="{{ \App\Classes\CSRFToken::generate() }}" value="Update" class="button update-subcategory" id="{{ $subcategory['id'] }}" data-category-id="{{ $subcategory['category_id'] }}" >
            </div>

        </div>
    </form>
    {{--END EDIT FORM--}}

    <a href="/admin/product/categories" class="close-button hollow" aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
{{-- END EDIT CATEGORY MODAL--}}