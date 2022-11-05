@extends('admin.admin_master')
@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">صفحة اضافة زبائن </h4><br><br>

                            <form method="post" action="{{route('customer.store')}}" id="myForm">
                                @csrf

                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">اسم الزبون</label>
                                    <div class="col-sm-10 form-group">
                                        <input name="jeha_name" class="form-control" type="text"   >
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">العنوان</label>
                                    <div class="col-sm-10 form-group">
                                        <input name="address" class="form-control" type="text"  >
                                    </div>
                                </div>
                                <!-- end row -->


                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">لبيانا</label>
                                    <div class="col-sm-10 form-group">
                                        <input name="libyana" class="form-control" type="text"  >
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">المدار</label>
                                    <div class="col-sm-10 form-group">
                                        <input name="mdar" class="form-control" type="text"  >
                                    </div>
                                </div>
                                <!-- end row -->
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">رقم الهوية</label>
                                    <div class="col-sm-10 form-group">
                                        <input name="others" class="form-control" type="text"  >
                                    </div>
                                </div>
                                <!-- end row -->


                                <div class="col text-center">
                                 <input type="submit" class="btn btn-info waves-effect waves-light " value="حفظ">
                                </div>
                            </form>



                        </div>
                    </div>
                </div> <!-- end col -->
            </div>



        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function (){
            $('#myForm').validate({
                rules: {
                    jeha_name: {
                        required : true,
                    },
                },
                messages :{
                    jeha_name: {
                        required : 'يجب ادخال اسم العميل',
                    },
                },
                errorElement : 'span',
                errorPlacement: function (error,element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight : function(element, errorClass, validClass){
                    $(element).addClass('is-invalid');
                },
                unhighlight : function(element, errorClass, validClass){
                    $(element).removeClass('is-invalid');
                },
            });
        });

    </script>


@endsection

