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
      @php $count=0;$sul=0;$pay=0;$raseed=0;$over=0;$tar=0;$wrong=0; @endphp
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
        @php $count+=$item->WCOUNT;$sul+=$item->sumsul;$pay+=$item->sumpay;$raseed+=$item->sumraseed;
            $over+=$item->over_kst;$tar+=$item->tar_kst;$wrong+=$item->wrong_kst; @endphp
      @endforeach
      <tr style="background: #9dc1d3;">
        <td colspan="3" style="text-align: center;"> الإجمــــــالي </td>
        <td style="font-weight: bold"> {{ number_format($count,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($sul,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($pay,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($raseed,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($over,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($tar,2, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($wrong,2, '.', ',') }} </td>

      </tr>
    @endif
    </tbody>
  </table>

  @if ($RepTable )
    {{ $RepTable->links() }}
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


