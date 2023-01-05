<div>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >

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

    <div class="col-md-4">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="1">
        <label class="form-check-label" >ايصالات قبض</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="2">
        <label class="form-check-label" >ايصالات دفع</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio3" value="0">
        <label class="form-check-label" >الكل</label>
      </div>
    </div>
    <div class="col-md-2">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="checkbox" wire:model="Supp_Only"  name="inlineRadioOptions" id="inlineRadio1" value="false">
        <label class="form-check-label" >الموردين فقط</label>
      </div>
    </div>

    <div class="col-md-2 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>

  </div>

  <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
    <thead class="font-size-12">
    <tr>
      <th style="width: 8%;">الرقم الالي</th>
      <th style="width: 8%;">التاريخ</th>
      <th style="width: 20%;">العميل</th>
      <th style="width: 8%;">المبلغ</th>
      <th style="width: 8%;">البيان</th>
      <th style="width: 8%;">النوع</th>
      <th style="width: 8%;">طريقة الدفع</th>
      <th >ملاحظات</th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @if ($RepTable )
      @foreach($RepTable as $key=>$item)
        <tr class="font-size-12">
          <td > {{ $item->tran_no }} </td>
          <td> {{ $item->tran_date }} </td>
          <td> {{ $item->jeha_name }} </td>
          <td> {{ $item->val }} </td>
          <td> {{ $item->who_name }} </td>
          <td> {{ $item->imp_exp_name }} </td>
          <td> {{ $item->type_name }} </td>
          <td> {{ $item->notes }} </td>
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
