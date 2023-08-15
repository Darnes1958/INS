<div>
  <div  x-data
        class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-4">
      @livewire('aksat.rep.bank-comp',
      ['sender' => 'aksat.rep.okod.aksat-deffer',])
    </div>

    <div class="col-md-2 my-2 mx-0 d-inline-flex ">
      <label for="baky" class="form-label mx-0 text-right " style="width: 30%; ">الفرق أكبر من </label>
      <input wire:model="deffer" class="form-control mx-0 text-center" type="number"  min="-10" max="50"  id="baky" style="width: 70%; ">
    </div>
    <div class="col-md-2 my-2  ">
      <input wire:model="search" class="form-control mx-0 text-center" type="search"   placeholder="ابحث هنا .......">
    </div>

    

  </div>


  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="7%">رقم العقد</th>
      <th width="12%">رقم الحساب</th>
      <th width="16%">الاسم</th>
      <th width="8%">القسط</th>
      <th width="8%">الخصم</th>
      <th width="8%">تاريخ الخصم</th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )

      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td > {{ $item->no }} </td>
          <td> {{ $item->acc }} </td>
          <td> {{ $item->name }} </td>
          <td> {{ $item->kst }} </td>
          <td> {{ $item->ksm }} </td>
          <td> {{ $item->ksm_date }} </td>

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

