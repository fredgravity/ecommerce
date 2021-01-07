{{-- EDIT CATEGORY MODAL--}}
<div class="reveal" id="item-{{ $category['id'] }}" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" >
    <div class="notification callout primary"></div>
    <h2>Edit Category</h2>
    {{-- EDIT FORM --}}
    <form>
        <div class="input-group">

            <input type="text" name="name" id="item-name-{{ $category['id'] }}" value="{{ $category['name'] }}">
            <div>
                <input type="submit" data-token="{{ \App\Classes\CSRFToken::generate() }}" value="Update" class="button update-category" id="{{ $category['id'] }}" >
            </div>

        </div>
    </form>
    {{--END EDIT FORM--}}

    <a href="/admin/product/categories" class="close-button" aria-label="Close modal" type="button">
        <span aria-hidden="true">&times;</span>
    </a>
</div>
{{-- END EDIT CATEGORY MODAL--}}