 <nav class="toolbox sticky-header" data-sticky-options="{'mobile': true}">
                            <div class="toolbox-left">


                                <div class="toolbox-right toolbox-sort mt-3">

                                    <form name="sortProducts" id="sortProducts">
                                        <input type="hidden" name="url" id="url" value="{{ $url }}">
                                        <select class="form-control getsort" name="sort" id="sort">
                                            <option value="">Sort By</option>
                                            <option value="lowest_price" @if(request()->get('sort')=='lowest_price') selected @endif>
                                                Sort By: Lowest Price
                                            </option>
                                           <option value="highest_price" @if(request()->get('sort')=='highest_price') selected @endif>
                                                Sort By: Highest Price
                                            </option>
                                           <option value="product_latest" @if(request()->get('sort')=='product_latest') selected @endif>
                                                Sort By: Latest Products
                                            </option>
                                           <option value="best_selling" @if(request()->get('sort')=='best_selling') selected @endif>
                                                Sort By: Best Selling
                                            </option>
                                           <option value="featured_items" @if(request()->get('sort')=='featured_items') selected @endif>
                                                Sort By: Featured Products
                                            </option>
                                          <option value="discounted_items" @if(request()->get('sort')=='discounted_items') selected @endif>
                                                Sort By: Discounted Products
                                            </option>
                                        </select>
                                    </form>


                                    {{-- <form method="GET" id="sortForm">
                                    <div class="dropdown ml-4">
                                        <button class="btn btn-light border dropdown-toggle" type="button" data-toggle="dropdown">
                                            Sort By
                                        </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" type="submit" name="sort" value="latest"
                                         {{ $selectedSort == 'latest' ? 'disabled' : '' }}>Latest</button>
                                        <button class="dropdown-item" type="submit" name="sort" value="low_to_high"
                                         {{ $selectedSort == 'low_to_high' ? 'disabled' : '' }}>Lowest Price</button>
                                        <button class="dropdown-item" type="submit" name="sort" value="high_to_low"
                                         {{ $selectedSort == 'high_to_low' ? 'disabled' : '' }}>Highest Price</button>
                                        <button class="dropdown-item" type="submit" name="sort" value="best_selling"
                                         {{ $selectedSort == 'best_selling' ? 'disabled' : '' }}>Best Selling</button>
                                        <button class="dropdown-item" type="submit" name="sort" value="featured"
                                         {{ $selectedSort == 'featured' ? 'disabled' : '' }}>Featured</button>
                                        <button class="dropdown-item" type="submit" name="sort" value="discounted"
                                         {{ $selectedSort == 'discounted' ? 'disabled' : '' }}>Discounted</button>

                                    </div>

                                    </div>
                                </form> --}}


                                </div>

                                <!-- End .toolbox-item -->
                            </div>
                            <!-- End .toolbox-left -->


                            <!-- End .toolbox-right -->
                        </nav>
