@extends('admin.admin_master')

@section('admin')


    <div class="page-content" dir="rtl" >
        <div class="container-fluid " >
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap table-striped "
                                   style="border-collapse: collapse; font-size: small; border-spacing: 0; line-height: .3; width: 100%;">
                                <thead>
                                <tr>
                                    <th>رقم المصرف</th>
                                    <th>اسم المصرف</th>
                                    <th>عدد العقود</th>
                                    <th>اجمالي العقود</th>
                                    <th>المسدد</th>
                                    <th>المتبقي</th>
                                    <th>الفائض</th>
                                    <th>الترجيع</th>
                                    <th>الخطأ</th>
                                </tr>
                                </thead>
                                <tbody >
                                  @foreach($datatable as $key => $item)
                                    <tr height="22px">
                                        <td> {{ $item->bank}} </td>
                                        <td> {{ $item->bank_name }} </td>
                                        <td> {{ $item->WCOUNT }} </td>
                                        <td> {{ $item->sumsul }} </td>
                                        <td> {{ $item->sumpay }} </td>
                                        <td> {{ $item->sumraseed }} </td>
                                        <td> {{ $item->over_kst }} </td>
                                        <td> {{ $item->tar_kst }} </td>
                                        <td> {{ $item->wrong_kst }} </td>
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


@endsection
