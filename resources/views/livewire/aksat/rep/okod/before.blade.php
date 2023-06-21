<div>
  <div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div x-show="$wire.ByTajmeehy=='Bank'" class="col-md-4">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.before',])
    </div>
    <div x-show="$wire.ByTajmeehy=='Taj'" class="col-md-4">
      @livewire('aksat.rep.taj-comp',
      ['sender' => 'aksat.rep.okod.before',])
    </div>


    <div class="col-md-2 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>
    <div class="col-md-2 my-2 d-inline-flex ">
      <label for="month" class="form-label mx-0 text-right " style="width: 50%; ">عن شهر</label>
      <input wire:model="month" class="form-control mx-0 text-center" type="text"    id="month"  readonly>
    </div>
    <div class="col-md-2 my-2 d-inline-flex ">
          <input class="form-check-input "  name="repchk" type="checkbox" wire:model="Not_pay"  >
        <label class="form-check-label mx-1"  style="color: blue" for="repchk">لم تسدد بعد</label>
    </div>

    <div class="col-md-2">
        <a  href="{{route('pdfbefore',['ByTjmeehy'=>$ByTajmeehy,'bank_no'=>$bank_no,'TajNo'=>$TajNo,'TajName'=>$TajName,'month'=>$month,'bank_name'=>$bank_name,'Not_pay'=>$Not_pay])}}"
            class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
    </div>

  </div>
  <div class="col-md-3">
    <div class="form-check form-check-inline my-1 mx-1">
      <input class="form-check-input" type="radio" wire:model="ByTajmeehy"  name="inlineRadioOptions" id="inlineRadio1" value="Bank">
      <label class="form-check-label" for="inlineRadio1">بفروع المصارف</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="ByTajmeehy" name="inlineRadioOptions" id="inlineRadio2" value="Taj">
      <label class="form-check-label" for="inlineRadio2">بالتجميعي</label>
    </div>
  </div>

  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="8%" class="sort text-primary" wire:click="sortOrder('no')" > رقم العقد {!! $sortLink !!}</th>
      <th width="12%" class="sort  text-primary" wire:click="sortOrder('acc')"> رقم الحساب {!! $sortLink !!}</th>
      <th  class="sort  text-primary" wire:click="sortOrder('name')"> الاسم {!! $sortLink !!}</th>
      <th width="8%" class="sort  text-primary" wire:click="sortOrder('sul_date')"> تاريخ العقد {!! $sortLink !!}</th>

      <th width="8%">اجمالي التقسيط</th>
      <th width="8%">القسط</th>

      <th width="8%">المسدد</th>
      <th width="8%">المطلوب</th>
      <th width="8">عدد المسددة</th>
      <th width="8%">عدد المتأخرة</th>
      <th width="8%">مجموعها</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )
      @php $sumkst_late=0;$sumraseed=0;$sumsul_pay=0;$sumsul=0; @endphp
      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">

          <td > {{ $item->no }} </td>
          <td> {{ $item->acc }} </td>
          <td> {{ $item->name }} </td>
          <td> {{ $item->sul_date }} </td>
          <td> {{ $item->sul }} </td>
            <td> {{ $item->kst }} </td>

          <td> {{ $item->sul_pay }} </td>
          <td> {{ $item->raseed }} </td>
          <td> {{number_format($item->pay_count, 0, '.', ',')}} </td>
          <td> {{ $item->late }} </td>
          <td> {{ $item->kst_late }} </td>
        </tr>
        @php $sumkst_late+=$item->kst_late;$sumraseed+=$item->raseed;$sumsul_pay+=$item->sul_pay;$sumsul+=$item->sul; @endphp
      @endforeach
      <tr class="font-size-12 " style="font-weight: bold">
        <td colspan="4">الإجمــــــــالي  </td>
        <td> {{number_format($sumsul, 2, '.', ',')}}  </td>
          <td></td>
        <td> {{number_format($sumsul_pay, 2, '.', ',')}}  </td>
        <td> {{number_format($sumraseed, 2, '.', ',')}} </td>
        <td></td>
        <td></td>
        <td> {{number_format($sumkst_late, 2, '.', ',')}}  </td>

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


