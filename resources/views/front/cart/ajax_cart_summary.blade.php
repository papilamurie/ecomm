                <div class="cart-summary">
                    <h3>CART TOTALS</h3>

                    <!-- ✅ Add this for coupon messages -->
                    <div id="coupon-msg" class="mb-3"></div>

                    <table class="table table-totals">
                        <tbody>
                            <tr>
                                <td>Subtotal</td>
                                <td>${{ number_format($subtotal) }}</td>
                            </tr>
                            <tr>
                                <td>Discount</td>
                                <td>${{ number_format($discount) }}</td>
                            </tr>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td>Total</td>
                                <td>${{ number_format($total) }}</td>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="checkout-methods">
                        <a href="#" class="btn btn-block btn-dark">Proceed to Checkout
                            <i class="fa fa-arrow-right"></i></a>
                    </div>

                    @if(session('applied_coupon'))
                    <div class="text-center mt-2">
                        <button id="removeCouponBtn" class="btn btn-link">
                            Remove Coupon {{ session('applied_coupon') }}
                        </button>
                    </div>
                    @endif
                </div>
