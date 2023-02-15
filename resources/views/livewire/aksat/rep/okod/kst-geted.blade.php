<div x-data>
  <div  x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-5">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.kst-geted',])
    </div>
    <div class="col-md-3 my-2 d-inline-flex ">
      <label  class="form-label mx-0 text-left " style="width: 30%; ">من تاريخ</label>
      <input wire:model="date1" wire:keydown.enter="Date1Chk"  class="form-control mr-0 text-center" type="date"  id="date1" style="width: 70%; ">
      @error('date1') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-3 my-2 d-inline-flex ">
      <label  class="form-label  text-right " style="width: 30%; ">إلي تاريخ</label>
      <input wire:model="date2" wire:keydown.enter="Date2Chk" class="form-control mr-0 text-center" type="date"  id="date2" style="width: 70%; ">
      @error('date2') <span class="error">{{ $message }}</span> @enderror
      <div wire:loading wire:target="date2" class="text-danger">
        يرجي الإنتظار...
      </div>
    </div>




   <!--  <div  class="col-md-2 my-2 ">
    <a  href="{{route('pdfwrong',['bank_no'=>$bank_no,'wrong_date1'=>$rep_date1,'wrong_date2'=>$rep_date2,'bank_name'=>$bank_name])}}"
          class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
   </div> -->
  </div>

<div class="row">
  <div class="col-md-5">

    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
      <caption class="caption-top text-center font-size-14 text-monospace pt-3 pb-1">اجمالي العقود المبرمة خلال الفترة</caption>
      <thead class="font-size-12">
      <tr>
        <th >الفرع</th>
        <th width="30%">اجمالي العقود</th>
        <th width="20%">النسبة المئوية</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @if ($OkodTable )
        @foreach($OkodTable as $key=>$item)
          <tr class="font-size-12">
            <td > {{ $item->place_name }} </td>
            <td> {{ number_format($item->sul_tot, 0, '.', ',') }} </td>
            <td class="text-center"> {{number_format($item->sul_tot/$SumOkod*100, 2, '.', ',').'%' }} </td>
          </tr>
        @endforeach
        <tr >
          <td class="font-size-12 text-primary font-weight-bold" > الاجمالي </td>
          <td class="font-size-12 text-primary font-weight-bold"> {{ number_format($SumOkod, 0, '.', ',') }} </td>
          <td>  </td>
        </tr>
      @endif
      </tbody>
    </table>
    @if ($OkodTable )
      {{ $OkodTable->links() }}
    @endif
  </div>
  <div class="col-md-4">
    <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
      <caption class="caption-top text-center font-size-14 text-monospace pt-3 pb-1">اجمالي الأقساط المحصلة خلال الفترة</caption>
      <thead class="font-size-12">
      <tr>
        <th >الفرع</th>
        <th width="30%">الأقساط المحصلة</th>
        <th width="20%">النسبة المئوية</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @if ($AksatTable )
        @foreach($AksatTable as $key=>$item)
          <tr class="font-size-12">
            <td > {{ $item->place_name }} </td>
            <td> {{ number_format($item->ksm, 0, '.', ',') }} </td>
            <td class="text-center">   {{number_format($item->ksm/$SumAksat*100, 2, '.', ',').'%' }} </td>
          </tr>
        @endforeach
        <tr >
          <td class="font-size-12 text-primary font-weight-bold" > الاجمالي </td>
          <td class="font-size-12 text-primary font-weight-bold"> {{ number_format($SumAksat, 0, '.', ',') }} </td>
          <td>  </td>
        </tr>
      @endif
      </tbody>
    </table>
    @if ($AksatTable )
      {{ $AksatTable->links() }}
    @endif

  </div>


</div>
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

