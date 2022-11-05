@extends('admin.admin_master')

@section('admin')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div  class="page-content" id="page-content" dir="rtl" >
        <div class="container-fluid " >

            <!-- start page title -->
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="col-sm-4">
                            <input type="text" name="search" id="search"
                                   class="form-control" placeholder="بحث ..">
                        </div>

                        <div class="card-body">
                            <a href="{{route('customer.add')}}" class="btn btn-dark waves-effect waves-light" style="float:right; margin-left: 20px;">اضافة</a>



                            {{$jeharep->links("pagination::bootstrap-5")}}
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; line-height: .3; width: 100%;">
                                <thead>
                                <tr>
                                    <th>تسلسل</th>
                                    <th>رقم الزبون</th>
                                    <th>اسم الزبون</th>
                                    <th>العنوان</th>
                                    <th>لبيانا</th>
                                    <th>مدار</th>
                                    <th>اخر</th>

                                </thead>


                                <tbody >

                                @foreach($jeharep as $key => $item)
                                    <tr>
                                        <td> {{ $key+1}} </td>
                                        <td> {{ $item->jeha_no }} </td>
                                        <td> {{ $item->jeha_name }} </td>
                                        <td> {{ $item->address }} </td>
                                        <td> {{ $item->libyana }} </td>
                                        <td> {{ $item->mdar }} </td>
                                        <td> {{ $item->others }} </td>

                                        <td style="padding-top: 2px;padding-bottom: 2px; ">
                                            <a href="{{route('customer.edit',$item->jeha_no)}}" class="btn btn-info " style ="height: 22px;width: 22px;
                                                padding: 1px;"  title="Edit Data">  <i class="fas fa-edit"></i> </a>

                                            <a href="{{route('customer.delete',$item->jeha_no)}}" class="btn btn-danger " style ="height: 22px;width: 22px;padding: 1px;" title="Delete Data" id="delete">  <i class="fas fa-trash-alt"></i> </a>

                                        </td>

                                    </tr>

                                @endforeach

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->



        </div> <!-- container-fluid -->
    </div>


    <script type="text/javascript">
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];

            bank(page)
        })

        function bank(page,b) {
            $.ajax({
                url: "/customer/all?page=" + page,
                success: function (res) {
                    $(".card-body").html(res);
                }
            })
        }

        $(function () {
            $(document).on('keyup', '#search',function (e){
                e.preventDefault();
                let search_string = $('#search').val();
                let bankid =  $('#bank_id').val();

                console.log(search_string);
                $.ajax({
                    url:"{{ route('search-customerall') }}",
                    method:'GET',
                    data:{search_string:search_string},
                    success:function (res){
                        $(".card-body").html(res);
                        if (res.status=='Nothing') {
                            $(".card-body").html('<span class="text-danger">'+'لا توجد بيانات'+'</span>');
                        }
                    }


                })
            }) });
    </script>
@endsection
