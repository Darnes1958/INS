<div>
  <div  x-data
        class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-4">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.wrong',])
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
    <a  href="{{route('pdfwrong',['bank_no'=>$bank_no,'wrong_date1'=>$wrong_date1,'wrong_date2'=>$wrong_date2,'bank_name'=>$bank_name])}}"
          class="btn btn-success waves-effect waves-light"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
    </div>
  </div>


  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="7%">رقم ألي</th>
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
          <td > {{ $item->wrong_no }} </td>
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

