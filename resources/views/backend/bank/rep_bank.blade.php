@extends('admin.admin_master')

@section('admin')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <div class="page-content" dir="rtl" >
        <div class="container-fluid " >


            <!-- start page title -->

            <div class="col-12">

                <form method="get" action="" >
                    @csrf
                    <div class="row col-sm-12" >
                        <div class="col-sm-6">
                            <select name="bank_id" id="bank_id"
                                    class="form-select select2  form-control"
                                    aria-label="default select example" >
                                <option value="">Open this select menu</option>
                                @foreach($banklist as $list)
                                    <option value="{{$list->bank_no}}" >{{$list->bank_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input name="bankno" class="form-control" type="text"
                                   id="bankno">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="search" id="search"
                                   class="form-control" placeholder="بحث ..">
                        </div>

                    </div>
                </form>

            </div>

            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" id="tag_container">

                            <table id="gridtable"  class="table table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; line-height: .3; width: 100%;">
                                <thead>
                                <tr>
                                    <th>تسلسل</th>
                                    <th>رقم العقد</th>
                                    <th>اسم الزبون</th>
                                    <th>تاريخ العقد</th>
                                    <th>اجمالي العقد</th>
                                    <th>القسط</th>
                                    <th>المسدد</th>
                                    <th>المتبقي</th>
                                </thead>


                                <tbody >

                                @foreach($datatable as $key => $item)
                                    <tr >
                                        <td> {{ $key+1}} </td>
                                        <td> {{ $item->no }} </td>
                                        <td> {{ $item->name }} </td>
                                        <td> {{ $item->sul_date }} </td>
                                        <td> {{ $item->sul }} </td>
                                        <td> {{ $item->kst }} </td>
                                        <td> {{ $item->sul_pay }} </td>
                                        <td> {{ $item->raseed }} </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-12">
                                {!! $datatable->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>

    <script type="text/javascript">

          $(function () {
              $(document).on('change', '#bank_id', function (e) {
                  e.preventDefault();
                  let b = $(this).val();
                  //let d=document.getElementById("bank_id");
                  //$('h5').text(d.options[d.selectedIndex].text);
                  document.getElementById('bankno').value = b;

                  $.ajax({
                      url: "/pagi_rep_bank/" + b,
                      success: function (res) {

                          $(".card-body").html(res);
                      }
                  })
              })
          });

          $(document).on('click', '.pagination a', function (e) {
              e.preventDefault();
              let page = $(this).attr('href').split('page=')[1];
              let b = document.getElementById('bank_id').value;
              bank(page,b)
          })

          function bank(page,b) {
              $.ajax({
                  url: "/pagi_rep_bank/" + b + "?page=" + page,
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

            //console.log(search_string);
              $.ajax({
                  url:"{{ route('search-rep_bank') }}",
                  method:'GET',
                  data:{search_string:search_string,bankid:bankid},
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
