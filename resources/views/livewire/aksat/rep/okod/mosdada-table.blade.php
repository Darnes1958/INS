<div>
  <div  x-data="{ open:@entangle('ShowTar'), progress: @entangle('ArcProgress'),count: @entangle('ArcCount')}"
        class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-4">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.mosdada-table',])
    </div>
    <div class="col-md-3 my-2  ">
      <input wire:model="search" class="form-control mx-0 text-center" type="search"   placeholder="ابحث هنا .......">
    </div>
    <div class="col-md-2 my-2 mx-0 d-inline-flex ">
      <label for="baky" class="form-label mx-0 text-right " style="width: 30%; ">الباقي</label>
      <input wire:model="baky" class="form-control mx-0 text-center" type="number"  min="-5" max="5"  id="baky" style="width: 70%; ">
    </div>
    <div  class="col-md-2 my-2 ">
      <button x-show="open" wire:click="ArcTarheel" class="  btn btn-outline-warning
      " style="height: 30px;" >نقل للأرشيف</button>
      <progress wire:loading wire:target="ArcTarheel" x-bind:max="count" x-bind:value="progress"></progress>
    </div>
    <div  x-show="open" class="col-md-1  my-2 checkbox">
      <label>
        <input wire:click="DoCheckAll" type="checkbox" class="check" id="checkAll"> تحديد الكل
      </label>
    </div>

  </div>


  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>

      <th width="7%">رقم العقد</th>
      <th width="12%">رقم الحساب</th>
      <th width="16%">الاسم</th>
      <th width="8%">تاريخ العقد</th>
      <th width="9%">اجمالي الفاتورة</th>
      <th width="6%">دفعة</th>
      <th width="9%">اجمالي التقسيط</th>
      <th width="7%">عدد الاقساط</th>
      <th width="7%">القسط</th>
      <th width="8%">المسدد</th>
      <th width="8">المطلوب</th>
      <th width="3%">&nbsp;</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )

    @foreach($RepTable as $key=>$item)
      <tr class="font-size-12">

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
        <td><input class="form-check-input" type="checkbox" wire:model="mychecked.{{$item->no}}"
                   value="1" id="flexCheckDefault"></td>
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

