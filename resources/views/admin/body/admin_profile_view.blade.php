@extends('admin.admin_master')
@section('admin')

    <div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-6">
                <div class="card"><br><br>
                    <center>
                    <img class="rounded-circle avatar-xl" src="{{
                      (!empty($admindata->profile_image))? url('upload/admin_images/'.$admindata->profile_image):
                      url('upload/no_image.jpg')}}" alt="Card image cap">
                    </center>
                    <div class="card-body">
                        <h4 class="card-title">الإسم {{$admindata->name}}</h4>
                        <hr>
                        <h4 class="card-title" dir="rtl"><b>البريد الإلكتروني : </b>{{$admindata->email}}</h4>
                        <hr>
                        <h4 class="card-title">تاريخ التسجيل {{$admindata->created_at}}</h4>
                        <hr>
                        <a href="{{route('edit.profile')}}" class="btn btn-secondary btn-rounded waves-effect waves-light">تعديل البيانات</a>


                        </p>
                    </div>
                </div>
            </div>





        </div>

    </div>
    </div>

@endsection('admin')
