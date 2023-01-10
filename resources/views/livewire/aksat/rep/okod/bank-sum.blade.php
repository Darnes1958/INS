<div>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >


    <div class="col-md-2 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>
      <div  class="col-md-2 ">
          <a  href="{{route('pdfbanksum')}}"
              class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
      </div>

  </div>

  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th>ت</th>
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
    <tbody id="addRow" class="addRow">
    @if ($RepTable )
      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td> {{ $key+1}} </td>
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
    @endif
    </tbody>
  </table>

  @if ($RepTable )
    {{ $RepTable->links('custom-pagination-links-view') }}
  @endif
</div>
@push('scripts')
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush


