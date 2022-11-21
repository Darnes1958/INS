<div x-data  class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
  <div class="col-md-4">
    <label  for="bank" class="form-label-me ">المصرف</label>
    <input wire:model="bank"  wire:keydown.enter="ChkBankAndGo" type="text" class=" form-control "
           id="bank_no"   autofocus >
    @error('bankno') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-8" >
    <label  class="form-label-me"> &nbsp </label>
    @livewire('bank.bank-haf-select')
  </div>

  <div class="col-md-4">
    <div >
      <label for="no" class="form-label-me">تاريخ الحافظة</label>
      <input wire:model="hafitha_date"  class="form-control" type="text"  id="hafitha_date" readonly>
    </div>
    <div  >
      <label  for="acc" class="form-label-me">المبلغ</label>
      <input  wire:model="hafitha_tot"  class="form-control"  type="text"  id="hafitha_tot" readonly>
    </div>
    <div  >
      <label  for="acc" class="form-label-me">تم ادخاله</label>
      <input  wire:model="hafitha_enter"  class="form-control"  type="text"  id="hafitha_enter" readonly>
    </div>
    <div  >
      <label  for="acc" class="form-label-me">المتبقي</label>
      <input  wire:model="hafitha_differ"  class="form-control"  type="text"  id="hafitha_differ" readonly>
    </div>
    <br>
  </div>

  <div   class="col-md-8" >

    <table class="table-sm table-bordered " width="100%"  id="hafheadertable" >
      <thead>
      <tr>
        <th width="40%">البيان</th>
        <th width="30%">العدد</th>
        <th width="30%">الاجمالي</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @if ($HafHeadDetail)
      @foreach($HafHeadDetail as $key => $item)

        <tr>
          <td > {{ $item->kst_type_name }} </td>
          <td > {{ $item->wcount }} </td>
          <td> {{ $item->sumkst }} </td>
        </tr>
      @endforeach
      @endif
      </tbody>

    </table><br>

  </div>
</div>

@push('scripts')

  <script>
      $(document).ready(function ()
      {
          $('#Bank_L').select2({
              closeOnSelect: true
          });
          $('#Bank_L').on('change', function (e) {
              var data = $('#Bank_L').select2("val");
          @this.set('bank', data);
          @this.set('TheBankListIsSelectd', 1);

          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
      });


  </script>
@endpush
