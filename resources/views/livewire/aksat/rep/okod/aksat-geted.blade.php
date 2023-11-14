<div x-data>
  <div  x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-4">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.aksat-geted',])
    </div>
    <div class="col-md-2 my-2 d-inline-flex ">
      <label  class="form-label mx-0 text-left " style="width: 30%; ">من تاريخ</label>
      <input wire:model="date1" wire:keydown.enter="Date1Chk"  class="form-control mr-0 text-center" type="date"  id="date1" style="width: 70%; ">
      @error('date1') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-2 my-2 d-inline-flex ">
      <label  class="form-label  text-right " style="width: 30%; ">إلي تاريخ</label>
      <input wire:model="date2" wire:keydown.enter="Date2Chk" class="form-control mr-0 text-center" type="date"  id="date2" style="width: 70%; ">
      @error('date2') <span class="error">{{ $message }}</span> @enderror
      <div wire:loading wire:target="date2" class="text-danger">
        يرجي الإنتظار...
      </div>
    </div>
    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="Geted">
        <label class="form-check-label" for="inlineRadio1">المحصلة</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="NotGeted">
        <label class="form-check-label" for="inlineRadio2">الغير محصلة</label>
      </div>

    </div>
      <div class="col-md-2 my-2 mx-0 d-inline-flex ">
          <label for="baky" class="form-label mx-0 text-right " style="width: 30%; ">الباقي</label>
          <input wire:model="baky" class="form-control mx-0 text-center" type="number"  min="-10" max="200"  id="baky" style="width: 70%; ">
      </div>

     <div  class="col-md-2 my-2 ">
    <a  href="{{route('pdfksm',['bank_no'=>$bank_no,'rep_date1'=>$rep_date1,'rep_date2'=>$rep_date2,'bank_name'=>$bank_name,'RepRadio'=>$RepRadio])}}"
          class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
   </div>
  </div>

<div class="row">


    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
      @if ($GetedTable && $RepRadio=='Geted')
        <caption class="caption-top text-center font-size-14 text-monospace pt-3 pb-1">الاقساط المحصلة خلال الفترة</caption>
      @endif
      @if ($NotGetedTable && $RepRadio=='NotGeted')
        <caption class="caption-top text-center font-size-14 text-monospace pt-3 pb-1">الاقساط الغير محصلة خلال الفترة</caption>
      @endif


      <thead class="font-size-12">
      <tr>
        <th width="7%" class="sort text-primary" wire:click="sortOrder('no')" > رقم العقد {!! $sortLink !!}</th>
        <th width="12%" class="sort  text-primary" wire:click="sortOrder('acc')"> رقم الحساب {!! $sortLink !!}</th>
        <th  class="sort  text-primary" wire:click="sortOrder('name')"> الاسم {!! $sortLink !!}</th>
        <th width="8%" class="sort  text-primary" wire:click="sortOrder('sul_date')"> تاريخ العقد {!! $sortLink !!}</th>
        <th width="9%">اجمالي التقسيط</th>
        <th width="7%">عدد الاقساط</th>
        <th width="8%">المسدد</th>
        <th width="8">المطلوب</th>
        <th width="7%">القسط</th>
        @if ($GetedTable && $RepRadio=='Geted')
        <th width="7%">تاريخ الخصم</th>
        <th width="7%">الخصم</th>
        @endif
        @if ($NotGetedTable && $RepRadio=='NotGeted')
          <th width="7%">تاريخ اخر قسط سدد</th>
        @endif

      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @if ($GetedTable && $RepRadio=='Geted')
        @foreach($GetedTable as $key=>$item)
          <tr class="font-size-12">
            <td > {{ $item->no }} </td>
            <td> {{ $item->acc }} </td>
            <td> {{ $item->name }} </td>
            <td> {{ $item->sul_date }} </td>

            <td> {{ $item->sul }} </td>
            <td> {{ $item->kst_count }} </td>
            <td> {{ $item->sul_pay }} </td>
            <td> {{ $item->raseed }} </td>
            <td> {{ $item->kst }} </td>
            <td> {{ $item->ksm_date }} </td>
            <td> {{ $item->ksm }} </td>
          </tr>
        @endforeach
      @endif
      @if ($NotGetedTable && $RepRadio=='NotGeted')
        @foreach($NotGetedTable as $key=>$item)
          <tr class="font-size-12">
            <td > {{ $item->no }} </td>
            <td> {{ $item->acc }} </td>
            <td> {{ $item->name }} </td>
            <td> {{ $item->sul_date }} </td>

            <td> {{ $item->sul }} </td>
            <td> {{ $item->kst_count }} </td>
            <td> {{ $item->sul_pay }} </td>
            <td> {{ $item->raseed }} </td>
            <td> {{ $item->kst }} </td>
            <td> {{ $item->ksm_date }} </td>
          </tr>
        @endforeach
      @endif

      </tbody>
    </table>
    @if ($GetedTable && $RepRadio=='Geted')
      {{ $GetedTable->links() }}
    @endif
  @if ($NotGetedTable && $RepRadio=='NotGeted')
    {{ $NotGetedTable->links() }}
  @endif



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

