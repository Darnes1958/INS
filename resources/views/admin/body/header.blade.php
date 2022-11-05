<header>

 <div id="header" class="row">
  <div class="d-flex col-md-2" >
            <div class="custom-menu" style="margin-left: 4px">
                <button type="button" id="sidebarCollapse" class="btn btn-primary">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Toggle Menu</span>
                </button>
            </div>
  </div>

  <div class="d-flex col-md-2" >
      <div class="dropdown d-none d-lg-inline-block ms-1" >
          <button type="button" class="btn header-item not-icon waves-effect"  data-toggle="fullscreen">
              <i class="ri-fullscreen-line"></i>
          </button>
      </div>
  </div>

  <div class="d-flex col-md-4" >
      <!-- Do some thing -->
  </div>
    @php
       $id = Auth::user()->id;
       $admindata = App\Models\User::find($id);
    @endphp
  <div class="col-md-4  align-right justify-content-end "  style="display: flex">
            <div class="dropdown d-inline-block user-dropdown " >
                <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="rounded-circle header-profile-user" src="{{
                      (!empty($admindata->profile_image))? url('upload/admin_images/'.$admindata->profile_image):
                      url('upload/no_image.jpg')}}"
                         alt="Header Avatar">
                    <span class="d-none d-xl-inline-block ms-1">{{$admindata->name}}</span>
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end">
                    <!-- item-->
                    <a class="dropdown-item" href="{{route('admin.profile')}}">
                        <i class="ri-user-line align-middle me-1"></i> Profile</a>
                    <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My Wallet</a>
                    <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                    <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{route('admin.logout')}}">
                        <i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout</a>
                </div>
            </div>
  </div>




 </div>

</header>
