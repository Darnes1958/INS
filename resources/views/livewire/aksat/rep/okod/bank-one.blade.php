<div>
  <div  x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
      <div x-show="$wire.ByTajmeehy=='Bank'" class="col-md-5">
          @livewire('aksat.rep.bank-comp',
          ['sender' => 'aksat.rep.okod.bank-one',])
      </div>
      <div x-show="$wire.ByTajmeehy=='Taj'" class="col-md-5">
          @livewire('aksat.rep.taj-comp',
          ['sender' => 'aksat.rep.okod.bank-one',])
      </div>

    <div class="col-md-3 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>
    <div class="col-md-4 my-2 ">
      <a  href="{{route('pdfbankone',['by'=>$ByTajmeehy,'TajNo'=>$TajNo,'bank_no'=>$bank_no,'column'=>$orderColumn,'sort'=>$sortOrder])}}"
          class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
      <a  href="{{route('bankoneex',['ByTjmeehy'=>$ByTajmeehy,'TajNo'=>$TajNo,'bank'=>$bank_no])}}"
          class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fas fa-file-excel"> &nbsp;&nbsp;إكسل&nbsp;&nbsp;</i></a>
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
      <th width="4%">ت</th>
      <th width="7%" class="sort text-primary" wire:click="sortOrder('no')" > رقم العقد {!! $sortLink !!}</th>
      <th width="12%" class="sort  text-primary" wire:click="sortOrder('acc')"> رقم الحساب {!! $sortLink !!}</th>
      <th  class="sort  text-primary" wire:click="sortOrder('name')"> الاسم {!! $sortLink !!}</th>
      <th width="7%" class="sort  text-primary" wire:click="sortOrder('sul_date')"> تاريخ العقد {!! $sortLink !!}</th>
      <th width="7%">اجمالي الفاتورة</th>
      <th width="7%">دفعة مقدما</th>
      <th width="7%">اجمالي التقسيط</th>
      <th width="7%">عدد الاقساط</th>
      <th width="7%">القسط</th>
      <th width="7%">المسدد</th>
      <th width="7">المطلوب</th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )

      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td > {{ $key+1 }} </td>
          <td > {{ $item->no }} </td>
          <td> {{ $item->acc }} </td>
          <td> {{ $item->name }} </td>
          <td> {{ $item->sul_date }} </td>
          <td> {{ $item->sul_tot }} </td>
          <td> {{ $item->dofa }} </td>
          <td> {{ $item->sul }} </td>
          <td> {{ $item->kst_count }} </td>
          <td> {{ $item->kst }} </td>
          <td> {{ $item->sul_pay }} </td>
          <td> {{ $item->raseed }} </td>

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

