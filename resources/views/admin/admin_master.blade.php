<!doctype html>
<html lang="ar">

<head>
    <style>
        .sorticon{
            visibility: hidden;
            color: darkgray;
        }
        .sort:hover .sorticon{
            visibility: visible;
        }
        .sort:hover{
            cursor: pointer;
        }
    </style>
    @livewireStyles
    <meta charset="utf-8" />
    <title>Dashboard | Upcube - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <!-- App favicon -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{asset('backend/assets/css/sidebars.css')}}" rel="stylesheet" >


    <link rel="shortcut icon" href="{{asset('backend/assets/images/favicon.ico')}}">

    <!-- Select 2 -->
    <link href="{{asset('backend/assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <!-- jquery.vectormap css -->
    <link href="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />

    <!-- DataTables -->
    <link href="{{asset('backend/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{asset('backend/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{asset('backend/assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('backend/assets/css/icons.min.cs')}}s" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('backend/assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.9.5/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.9.5/dist/cdn.min.js"></script>



</head>

<body   >

<!-- <body data-layout="horizontal" data-topbar="dark"> -->

<!-- Begin page -->
 <div x-data="{openScr : false}" id="layout-wrapper" >


    @include('admin.body.header')
    <div class=" wrapper d-flex align-items-stretch "  >
        <!-- ========== Left Sidebar Start ========== -->
        @unlessrole('info')
         @include('admin.body.slidebar')
        @endunlessrole

        <div  id="content" class="p-1 p-md-1 pt-1"  dir="rtl">

            @yield('admin')

        </div>
    </div>


 </div>


<!-- JAVASCRIPT -->
<script src="{{asset('backend/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/node-waves/waves.min.js')}}"></script>


<!-- apexcharts -->
<!-- <script src="{{asset('backend/assets/libs/apexcharts/apexcharts.min.js')}}"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script> -->

<!-- jquery.vectormap map -->
<script src="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.j')}}s"></script>

<!-- Required datatable js -->
<script src="{{asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

<!-- Responsive examples -->
<script src="{{asset('backend/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

<script src="{{asset('backend/assets/js/pages/dashboard.init.js')}}"></script>

<!-- App js -->
<script src="{{asset('backend/assets/js/app.js')}}"></script>


<script src="{{asset('backend/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('backend/assets/js/popper.js')}}"></script>
<script src="{{asset('backend/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('backend/assets/js/main.js')}}"></script>




<script>
    @if(Session::has('message'))
    var type = "{{ Session::get('alert-type','info') }}"
    switch(type){
        case 'info':
            toastr.info(" {{ Session::get('message') }} ");
            break;

        case 'success':
            toastr.success(" {{ Session::get('message') }} ");
            break;

        case 'warning':
            toastr.warning(" {{ Session::get('message') }} ");
            break;

        case 'error':
            toastr.error(" {{ Session::get('message') }} ");
            break;
    }
    @endif

</script>

<script src="{{asset('backend/assets/js/sidebars.js')}}"></script>

<script src="{{ asset('backend/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/assets/libs/select2/js/select2.min.js') }}"></script>

<script src="{{ asset('backend/assets/js/pages/datatables.init.js') }}"></script>
<script src="{{ asset('backend/assets/js/pages/form-advanced.init.js') }}"></script>

<script src="{{asset('backend/assets/js/validate.min.js')}}"></script>



<script src="{{ asset('backend/assets/js/code.js') }}"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    const MyConfirm = Swal.mixin({
        toast: true,
        title: 'هل انت متأكد ؟',
        showCancelButton: true,
        confirmButtonText: 'نعم متأكد',
        cancelButtonText: `تراجع`,
        cancelButtonColor: 'red',
        icon: 'question',

        background: '#e1e7de',
        width: 300,

    })
</script>

<script>
    const KstWrong = Swal.mixin({
        toast: true,
        title: 'هذا الحساب غير مخزون بهذا المصرف .. هل هو قسط وارد بالخطأ ؟',
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-thumbs-up"></i> نعم , هو قسط وارد بالخطأ ',
        cancelButtonText:   '<i class="fa fa-thumbs-down">&nbsp;لا تراجع</i>',
        cancelButtonColor: 'red',
        icon: 'question',
        background: '#e1e7de',
    })
</script>

<script>
    const MyMsg = Swal.mixin({
        toast: true,
        padding: '3em',

        background: '#e1e7de',
        icon: 'question',
        timer: 5000,
        timerProgressBar: true,

    })

</script>
<script>
    const Succ = Swal.mixin({
        position : top,
        toast: true,
        title: 'تم تحزين البيانات',
        timerProgressBar: true,

    })

</script>
<script>
    var elem = document.documentElement;
    function openFullscreen() {

            if (elem.requestFullscreen) {
                elem.requestFullscreen();
            } else if (elem.webkitRequestFullscreen) { /* Safari */
                elem.webkitRequestFullscreen();
            } else if (elem.msRequestFullscreen) { /* IE11 */
                elem.msRequestFullscreen();
            }

    }

    function closeFullscreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.webkitExitFullscreen) { /* Safari */
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) { /* IE11 */
            document.msExitFullscreen();
        }
    }
</script>


@livewireScripts
 @livewireChartsScripts
  <!-- <script src="public/vendor/livewire-charts/app.js"></script> -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    window.addEventListener('alert', event => {

        toastr[event.detail.type](event.detail.message, event.detail.title ?? '' , toastr.options = {
            "closeButton": true,
            "progressBar": true,

        })
    });
</script>
@stack('scripts')

</body>

</html>
