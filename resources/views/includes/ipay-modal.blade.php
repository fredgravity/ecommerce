<div class="reveal" id="myipay" data-reveal data-close-on-click="false" data-close-on-esc="false" data-animation-in="scale-in-up" style="width: 400px;">
    <h5 class="modal-title text-center">Pay Artisao with these Information</h5>
    <div class="text-center" ><p id="myipay_notify" style="color: red;"></p></div>


    <form action="">
        <div class="row">
            <div class=" " id="shopping_cart">
                <label for="fullname">Full Name:</label>
                <input type="text" name="fullname" value="{{ user()->fullname }}" disabled>

                <label for="email">Email:</label>
                <input type="text" name="email" value="{{ user()->email }}" disabled>

                <label for="channel">Select Network</label>
                <select name="channel" id="channel">
                    <option value="mtn">MTN</option>
                    <option value="airtel">Airtel</option>
                    <option value="vodafone">Vodafone</option>
                    <option value="tigo">Tigo</option>
                </select>

                <label for="phone">Phone #:</label>
                +233<input type="text" name="phone" id="phone" value="{{ user()->phone }}">

                            <div class="expanded button-group">
                                <div >
                                    <button class="button primary" @click="myipay_btn" id="myipay-btn" data-token="{{ \App\Classes\CSRFToken::generate() }}">Pay</button>
                                </div>
                            </div>


                <a href="/cart" class="close-button" aria-label="Close modal" data-close type="button">
                    <span aria-hidden="true">&times;</span>
                </a>

            </div>
        </div>
    </form>

</div>