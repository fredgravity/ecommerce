
<div class="reveal contact-seller-modal row align-center" id="product-modal" data-reveal data-animation-in="slide-in-down" data-animation-out="slide-out-up" >

    <h3 class="modal-title text-center column">Contact Vendor</h3>

    <div class="column">

        <form action="/contact-vendor/{{ $product->user->id }}" method="post" class="small-12 medium-12" id="contact-seller-modal-form">

            <h5>Customer Info</h5>
            <hr>

            @if(isAuthenticated())
                <label for="username">Username: </label>
                <input type="text" id="username" name="username" value="{{ user()->username }}" readonly>

                <label for="email">Email: </label>
                <input type="text" id="email" name="email" value="{{ user()->email }}" readonly>
                @endif


            <h5>Vendor Info</h5>
            <hr>

            <label for="country">Vendor's Country </label>
            <input type="text" id="country" name="country" value="{{ $product->user->country_name }}" readonly>


            <label for="product_name">Product: </label>
            <input type="text" id="product_name" name="product_name" value="{{ $product->name}}" readonly>

            <label for="quantity">Product: </label>
            <select name="quantity" id="quantity">
                @for($i = 1; $i <= 50; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>readonly
                    @endfor
            </select>

            <div>
                <div class="float-left">
                    <h2>$ {{ $product->price }}</h2>
                </div>

                <div class="float-right">
                    @if($product->quantity > 0)
                        <input class="success hollow button " value="Order Now!" id="order-now" type="submit">
                        @else
                        <input class="success hollow button " value="Order Now!" id="order-now" type="submit" disabled="">
                        @endif

                    <button class="button warning hollow" data-close aria-label="close modal" type="button">Cancel</button>
                </div>

                <input type="hidden" name="token" value="{{ \App\Classes\CSRFToken::generate() }}">

            </div>

        </form>
    </div>



    {{--<span class="float-right">--}}
        {{----}}
    {{--</span>--}}



</div>