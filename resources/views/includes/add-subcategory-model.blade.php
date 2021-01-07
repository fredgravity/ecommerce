{{-- EDIT CATEGORY MODAL--}}
<div class="reveal" id="add-subcategory-{{ $category['id'] }}" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h2>Add Sub Category</h2>
    {{-- EDIT FORM --}}
    <form>
        <div class="input-group">

            <input type="text" id="subcategory-name-{{ $category['id'] }}">
            <div>
                <input type="submit" id="{{ $category['id'] }}" data-token="{{ \App\Classes\CSRFToken::generate() }}" value="Create" class="button add-subcategory"                                                                     update-category" id="{{ $category['id'] }}" >
            </div>

        </div>
    </form>
    {{--END EDIT FORM--}}

    <a href="/admin/product/categories" class="close-button" aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
{{-- END EDIT CATEGORY MODAL--}}