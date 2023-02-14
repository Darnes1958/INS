<header>

 <div  id="header" class="row ">

 @role('info')
     <div class="d-flex col-md-8 mt-0 pt-0" style="height: 40px"></div>
 @else
  <div class="d-flex col-md-2 mt-0 pt-0" style="height: 40px">
    <button type="button" id="sidebarCollapse" class="btn btn-outline-primary border-0">
        <i class="fa fa-bars"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>
  </div>
  <div class="d-flex col-md-2 mt-0 py-1" style="height: 40px">
      <a x-show="!openScr" @click="openScr=!openScr"
         class="btn btn-outline-primary border-0 fa fa-expand waves-effect " onclick="openFullscreen();"></a>
      <a x-show="openScr" @click="openScr=!openScr"
         class="btn btn-outline-danger border-0 fas fa fa-expand waves-effect " onclick="closeFullscreen();"></a>
  </div>
  <div class="d-flex col-md-2 mt-0 py-1" style="height: 40px;">
    <a href="{{ url('/home') }}"
       class="btn btn-outline-primary border-0 fas fa-home waves-effect " ></a>
  </div>
     <div class="d-flex col-md-2 mt-0 py-1" style="height: 40px;">
       <a href="{{ url('/dodownload') }}"
          class="btn btn-outline-primary border-0 fas fa-database waves-effect " ></a>
     </div>
 @endrole
    @auth
         @php
               $id = Auth::user()->id;
               $admindata = App\Models\User::find($id);
         @endphp
     @endauth
         <div class="d-flex col-md-1 mt-0 py-1" style="height: 40px;color: white">
             @auth
             @if ($id==1)
                 <label style="font-size: 14px; color: blue;">{{$admindata->company}}</label>
             @endif
             @endauth
         </div>

         <div class="col-md-3  align-right justify-content-end mt-0 pt-0"  style="display: flex; height: 40px;">
            <div class="dropdown d-inline-block user-dropdown  mt-0 pt-0" style="height: 40px;">
                <button type="button" class="btn header-item waves-effect mb-5 p-0" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height: 40px;color: blue">
                    <img class="rounded-circle header-profile-user mt-0 pt-0" src="{{
                      (!empty($admindata->profile_image))? url('upload/admin_images/'.$admindata->profile_image):
                      url('upload/no_image.jpg')}}" >
                    @if (isset( $admindata)) <span class="d-none d-xl-inline-block mt-0 pt-0 text-primary">{{$admindata->name}}</span>@endif
                    <i class="mdi mdi-chevron-down d-none d-xl-inline-block mt-0 pt-0"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end  mt-0 pt-0" >
                    <!-- item-->
                    <a class="dropdown-item" href="{{route('admin.profile')}}">
                        <i class="ri-user-line align-middle me-1"></i> تعديل البيانات الشخصية</a>
                    <a class="dropdown-item" href="{{route('pass.edit')}}"><i class="ri-wallet-2-line align-middle me-1"></i> تعديل الرقم السري</a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="{{route('admin.logout')}}">
                        <i class="ri-shut-down-line align-middle me-1 text-danger"></i> تسجيل الخروج</a>
                </div>
            </div>
  </div>



 </div>

</header>
