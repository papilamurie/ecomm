<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
            <!--begin::Brand Image-->
            <img
              src="{{ asset('admin/img/AdminLTELogo.png') }}"
              alt="AdminLTE Logo"
              class="brand-image opacity-75 shadow"
            />
            <!--end::Brand Image-->
            <!--begin::Brand Text-->
            <span class="brand-text fw-light">AdminLTE 4</span>
            <!--end::Brand Text-->
          </a>
          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item {{ in_array(Session::get('page'), ['dashboard','update-details','update-password','subadmins']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Session::get('page'), ['dashboard','update-details','update-password','subadmins']) ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer"></i>
                  <p>
                    Admin Management
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/dashboard') }}" class="nav-link {{ (Session::get('page')=='dashboard')? 'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Dashboard</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('admin/update-details') }}" class="nav-link {{ (Session::get('page')=='update-details')? 'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Update Details</p>
                    </a>
                  </li>
                   <li class="nav-item">
                    <a href="{{ url('admin/update-password') }}" class="nav-link {{ (Session::get('page')=='update-password')? 'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Update Password</p>
                    </a>
                  </li>
                  @if (Auth::guard('admin')->user()->role=='admin')
                  <li class="nav-item">
                    <a href="{{ url('admin/subadmins') }}" class="nav-link {{ (Session::get('page')=='subadmins')? 'active':'' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sub-Admins</p>
                    </a>
                  </li>
                    @endif
                 </ul>
              </li>
               <li class="nav-item {{ in_array(Session::get('page'), ['categories','products','filters']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Session::get('page'), ['categories','products','filters']) ? 'active' : '' }}">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>
                    Categories Management

                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('admin/categories') }}" class="nav-link {{ (Session::get('page')=='categories')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Categories</p>
                </a>
                  </li>

                <li class="nav-item">
                    <a href="{{ url('admin/products') }}" class="nav-link {{ (Session::get('page')=='products')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Products</p>
                </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('admin/filters') }}" class="nav-link {{ (Session::get('page')=='filters')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Filters</p>
                </a>
                  </li>
                </ul>
              </li>


               <li class="nav-item {{ in_array(Session::get('page'), ['brands','banners']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Session::get('page'), ['brands','banners']) ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam-fill"></i>
                  <p>
                    Banner Management

                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('admin/brands') }}" class="nav-link {{ (Session::get('page')=='brands')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Brands</p>
                </a>
                  </li>


                  <li class="nav-item">
                    <a href="{{ url('admin/banners') }}" class="nav-link {{ (Session::get('page')=='banners')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Banners</p>
                </a>
                  </li>

                </ul>
              </li>

                <li class="nav-item {{ in_array(Session::get('page'), ['coupons']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Session::get('page'), ['coupons']) ? 'active' : '' }}">
                  <i class="nav-icon bi bi-tree-fill"></i>
                  <p>
                    Coupon Management

                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('admin/coupons') }}" class="nav-link {{ (Session::get('page')=='coupons')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Coupons</p>
                </a>
                  </li>
                  </ul>
              </li>

              <li class="nav-item {{ in_array(Session::get('page'), ['users']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Session::get('page'), ['users']) ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam-fill"></i>
                  <p>
                    User Management

                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('admin/users') }}" class="nav-link {{ (Session::get('page')=='users')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Users</p>
                </a>
                  </li>




                </ul>
              </li>

              <li class="nav-item {{ in_array(Session::get('page'), ['currencies']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ in_array(Session::get('page'), ['currencies']) ? 'active' : '' }}">
                  <i class="nav-icon bi bi-box-seam-fill"></i>
                  <p>
                    Currency Management

                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('admin/currencies') }}" class="nav-link {{ (Session::get('page')=='currencies')? 'active':'' }}">
                 <i class="nav-icon bi bi-circle"></i>
                  <p>Currencies</p>
                </a>
                  </li>




                </ul>
              </li>



              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-tree-fill"></i>
                  <p>
                    UI Elements
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./UI/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/icons.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Icons</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/timeline.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Timeline</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-pencil-square"></i>
                  <p>
                    Forms
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./forms/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General Elements</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Tables
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./tables/simple.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Simple Tables</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">EXAMPLES</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-box-arrow-in-right"></i>
                  <p>
                    Auth
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="./examples/lockscreen.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Lockscreen</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">DOCUMENTATIONS</li>
              <li class="nav-item">
                <a href="./docs/introduction.html" class="nav-link">
                  <i class="nav-icon bi bi-download"></i>
                  <p>Installation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/layout.html" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Layout</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/color-mode.html" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Color Mode</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-ui-checks-grid"></i>
                  <p>
                    Components
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/components/main-header.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Header</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./docs/components/main-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Sidebar</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-filetype-js"></i>
                  <p>
                    Javascript
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/javascript/treeview.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Treeview</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="./docs/browser-support.html" class="nav-link">
                  <i class="nav-icon bi bi-browser-edge"></i>
                  <p>Browser Support</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/how-to-contribute.html" class="nav-link">
                  <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                  <p>How To Contribute</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/faq.html" class="nav-link">
                  <i class="nav-icon bi bi-question-circle-fill"></i>
                  <p>FAQ</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./docs/license.html" class="nav-link">
                  <i class="nav-icon bi bi-patch-check-fill"></i>
                  <p>License</p>
                </a>
              </li>
              <li class="nav-header">MULTI LEVEL EXAMPLE</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>
                    Level 1
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Level 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li>
              <li class="nav-header">LABELS</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-danger"></i>
                  <p class="text">Important</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-warning"></i>
                  <p>Warning</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-info"></i>
                  <p>Informational</p>
                </a>
              </li>
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>
