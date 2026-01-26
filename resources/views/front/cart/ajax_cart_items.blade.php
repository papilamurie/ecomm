  @forelse($cartItems as $item)
									<tr class="product-row">
										<td>
											<figure class="product-image-container">
												<a href="{{ url($item['product_url']) }}" class="product-image">
													<img src="{{ $item['image'] }}" alt="product">
												</a>


											</figure>
										</td>
										<td class="product-col">
											<h5 class="product-title">
												<a href="{{ url($item['product_url']) }}">{{ $item['product_name'] }}</a>
											</h5>
										</td>
                                        <td class="product-col">
											<h5 class="product-title">
												{{ $item['size'] }}
											</h5>
										</td>
										<td>${{ number_format($item['unit_price']) }}</td>
										<td>
											<div class="product-single-qty">
												<div class="input-group quantity mx-auto" style="width:100px;">
                                                    <div class="input-group-btn">
                                                     <button type="button" class="btn btn-sm btn-primary btn-minus updateCartQty"
                                                     data-cart-id={{ $item['cart_id'] }}
                                                     data-dir="down">
                                                     <i class="fa fa-minus"></i>
                                                     </button>
                                                    </div>
                                                    <input type="text" class="form-control form-control-sm bg-secondary text-center cart-qty"
                                                    value="{{ $item['qty'] }}"
                                                    data-cart-id="{{ $item['cart_id'] }}">
                                                     <div class="input-group-btn">
                                                     <button type="button" class="btn btn-sm btn-primary btn-plus updateCartQty"
                                                     data-cart-id={{ $item['cart_id'] }}
                                                     data-dir="up">
                                                     <i class="fa fa-plus"></i>
                                                     </button>
                                                    </div>
                                                </div>
											</div><!-- End .product-single-qty -->
										</td>
										<td class="text-right"><span class="subtotal-price">${{ number_format($item['line_total']) }}</span></td>
                                        <td class="text-right">
                                            <button type="button"
                                            class="btn btn-sm btn-primary removeCartItem"
                                            data-cart-id="{{ $item['cart_id'] }}">
                                            <i class="fa fa-times"></i>
                                            </button>
                                        </td>
									</tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Your Cart is Empty.</td>
                                    </tr>
                                    @endforelse

