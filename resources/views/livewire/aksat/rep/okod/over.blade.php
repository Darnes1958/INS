<div>
  <div  x-data >
   <div    class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-4">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.over',])
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
    </div>

    <div class="col-md-2 my-2  ">
      <input wire:model="search" class="form-control mx-0 text-center" type="search"   placeholder="ابحث هنا .......">
    </div>

    <div  class="col-md-2 my-2 ">

    <a  href="{{route('pdfover',['bank_no'=>$bank_no,'over_date1'=>$over_date1,'over_date2'=>$over_date2,'bank_name'=>$bank_name,'Table'=>$Table,'letters'=>$letters])}}"
          class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
   </div>
  </div>
  <div class="row" >
    <div class="col-md-3">
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" wire:model="Table"   value="over_kst">
      <label class="form-check-label" >من القائم</label>
    </div>
    <div class="form-check form-check-inline ">
      <input class="form-check-input" type="radio" wire:model="Table"   value="over_kst_a">
      <label class="form-check-label" >من الأرشيف</label>
    </div>
    </div>
    <div class="col-md-3">
      <div class="form-check form-check-inline ">
        <input class="form-check-input" type="radio" wire:model="letters"   value="0">
        <label class="form-check-label" >غير مرحلة</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="letters"   value="1">
        <label class="form-check-label" >مرحلة</label>
      </div>
    </div>
    </div>

  </div>

  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="7%">رقم ألي</th>
      <th width="7%">رقم العقد</th>
      <th width="12%">رقم الحساب</th>
      <th width="16%">الاسم</th>
      <th width="8%">تاريخ القسط</th>
      <th width="7%">القسط</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )

      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td > {{ $item->wrec_no }} </td>
          <td> {{ $item->no }} </td>
          <td> {{ $item->acc }} </td>
          <td> {{ $item->name }} </td>
          <td> {{ $item->tar_date }} </td>
          <td> {{ $item->kst }} </td>
        </tr>
      @endforeach
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

