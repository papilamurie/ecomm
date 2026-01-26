@extends('front.layout.layout')
 @section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">
 <main class="main">
			<div class="container">
				<ul class="checkout-progress-bar d-flex justify-content-center flex-wrap">
					<li class="active">
						<a href="{{ url('/cart') }}">Shopping Cart</a>
					</li>
					<li>
						<a href="#">Checkout</a>
					</li>
					<li class="disabled">
						<a href="#">Order Complete</a>
					</li>
				</ul>

				<div class="row">
					<div class="col-lg-8">
						<div class="cart-table-container">
							<table class="table table-cart">
								<thead>
									<tr>
										<th class="thumbnail-col"></th>
										<th class="product-col">Product</th>
                                        <th class="product-col">Size</th>
										<th class="price-col">Price</th>
										<th class="qty-col">Quantity</th>
                                        <th class="text-right">Subtotal</th>
                                        <th class="qty-col">Remove</th>

									</tr>
								</thead>
								<tbody id="cart-items-body">
                                  <tr>
                                    <td colspan="5">
                                                Loading......
                                    </td>
                                  </tr>
								</tbody>


								<tfoot>
									<tr>
										<td colspan="5" class="clearfix">
											<div class="float-left">
												<div class="cart-discount">
													<form action="#">
														<div class="input-group">
															<input type="text" class="form-control form-control-sm"
																placeholder="Coupon Code" required>
															<div class="input-group-append">
																<button class="btn btn-sm" type="submit">Apply
																	Coupon</button>
															</div>
														</div><!-- End .input-group -->
													</form>
												</div>
											</div><!-- End .float-left -->

											<div class="float-right">
												<button type="submit" class="btn btn-shop btn-update-cart">
													Update Cart
												</button>
											</div><!-- End .float-right -->
										</td>
									</tr>
								</tfoot>
							</table>
						</div><!-- End .cart-table-container -->
					</div><!-- End .col-lg-8 -->

					<div class="col-lg-4" id="cart-summary-container">
						<div class="cart-summary">
							<h3>CART TOTALS</h3>

							<table class="table table-totals">
								<tbody>
									<tr>
										<td>Subtotal</td>
										<td>$0</td>
									</tr>
                                    <tr>
										<td>Discount</td>
										<td>$0</td>
									</tr>

									{{-- <tr>
										<td colspan="2" class="text-left">
											<h4>Shipping</h4>

											<div class="form-group form-group-custom-control">
												<div class="custom-control custom-radio">
													<input type="radio" class="custom-control-input" name="radio"
														checked>
													<label class="custom-control-label">Local pickup</label>
												</div><!-- End .custom-checkbox -->
											</div><!-- End .form-group -->

											<div class="form-group form-group-custom-control mb-0">
												<div class="custom-control custom-radio mb-0">
													<input type="radio" name="radio" class="custom-control-input">
													<label class="custom-control-label">Flat rate</label>
												</div><!-- End .custom-checkbox -->
											</div><!-- End .form-group -->

											<form action="#">
												<div class="form-group form-group-sm">
													<label>Shipping to <strong>NY.</strong></label>
													<div class="select-custom">
														<select class="form-control form-control-sm">
															<option value="USA">United States (US)</option>
															<option value="Turkey">Turkey</option>
															<option value="China">China</option>
															<option value="Germany">Germany</option>
														</select>
													</div><!-- End .select-custom -->
												</div><!-- End .form-group -->

												<div class="form-group form-group-sm">
													<div class="select-custom">
														<select class="form-control form-control-sm">
															<option value="NY">New York</option>
															<option value="CA">California</option>
															<option value="TX">Texas</option>
														</select>
													</div><!-- End .select-custom -->
												</div><!-- End .form-group -->

												<div class="form-group form-group-sm">
													<input type="text" class="form-control form-control-sm"
														placeholder="Town / City">
												</div><!-- End .form-group -->

												<div class="form-group form-group-sm">
													<input type="text" class="form-control form-control-sm"
														placeholder="ZIP">
												</div><!-- End .form-group -->

												<button type="submit" class="btn btn-shop btn-update-total">
													Update Totals
												</button>
											</form>
										</td>
									</tr> --}}
								</tbody>

								<tfoot>
									<tr>
										<td>Total</td>
										<td>$0</td>
									</tr>
								</tfoot>
							</table>

							<div class="checkout-methods">
								<a href="cart.html" class="btn btn-block btn-dark">Proceed to Checkout
									<i class="fa fa-arrow-right"></i></a>
							</div>
						</div><!-- End .cart-summary -->
					</div><!-- End .col-lg-4 -->
				</div><!-- End .row -->
			</div><!-- End .container -->

			<div class="mb-6"></div><!-- margin -->
		</main><!-- End .main -->


 @endsection
