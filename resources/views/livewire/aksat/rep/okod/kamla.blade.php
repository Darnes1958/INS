<div>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-6">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.kamla',])
    </div>

    <div class="col-md-4 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>
    <div class="col-md-4 my-2 d-inline-flex ">
      <label for="baky" class="form-label mx-0 text-right " style="width: 50%; ">عدد الأشهر</label>
      <input wire:model="months" class="form-control mx-0 text-center" type="number"  min="1" max="100"  id="baky" style="width: 50%; ">
    </div>
    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="RepAll">
        <label class="form-check-label" for="inlineRadio1">كل العقود الخاملة</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="RepSome">
        <label class="form-check-label" for="inlineRadio2">خاملة ولم تسدد بعد</label>
      </div>
    </div>
    <div class="col-md-4 d-flex">

        <a  href="{{route('pdfkamla',['bank_no'=>$bank_no,'months'=>$months,'bank_name'=>$bank_name,'RepRadio'=>$RepRadio])}}"
            class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>

        <a  href="{{route('khamlaex',['bank'=>$bank_no,'months'=>$months,'RepRadio'=>$RepRadio])}}"
                class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fas fa-file-excel"> &nbsp;&nbsp;إكسل&nbsp;&nbsp;</i></a>

    </div>

  </div>

  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12 " style="color: #8a8f97">
    <tr>
      <th width="4%">ت</th>
      <th width="8%" class="sort text-primary" wire:click="sortOrder('no')" > رقم العقد {!! $sortLink !!}</th>
      <th width="14%" class="sort  text-primary" wire:click="sortOrder('acc')"> رقم الحساب {!! $sortLink !!}</th>
      <th  class="sort  text-primary" wire:click="sortOrder('name')"> الاسم {!! $sortLink !!}</th>
      <th width="8%" class="sort  text-primary" wire:click="sortOrder('sul_date')"> تاريخ العقد {!! $sortLink !!}</th>
      <th width="8%">اجمالي التقسيط</th>
      <th width="8%">القسط</th>
      <th width="8%">المسدد</th>
      <th width="8">المطلوب</th>
      <th width="10%" class="sort  text-primary" wire:click="sortOrder('ksm_date')"> تاريخ أخر قسط سدد {!! $sortLink !!}</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )
      @php $sumkst=0;$sumraseed=0;$sumsul_pay=0;$sumsul=0; @endphp
      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td > {{ $key+1 }} </td>
          <td > {{ $item->no }} </td>
          <td> {{ $item->acc }} </td>
          <td> {{ $item->name }} </td>
          <td> {{ $item->sul_date }} </td>
          <td> {{ $item->sul }} </td>
          <td> {{ $item->kst }} </td>
          <td> {{ $item->sul_pay }} </td>
          <td> {{ $item->raseed }} </td>
          <td> {{ $item->ksm_date }} </td>
        </tr>
        @php $sumkst+=$item->kst;$sumraseed+=$item->raseed;$sumsul_pay+=$item->sul_pay;$sumsul+=$item->sul; @endphp
      @endforeach
      <tr class="font-size-12 " style="font-weight: bold">
        <td colspan="5">الإجمــــــــالي  </td>
        <td> {{number_format($sumsul, 2, '.', ',')}}  </td>
        <td> {{number_format($sumkst, 2, '.', ',')}} </td>
        <td> {{number_format($sumsul_pay, 2, '.', ',')}}  </td>
        <td> {{number_format($sumraseed, 2, '.', ',')}}  </td>
        <td></td>
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


