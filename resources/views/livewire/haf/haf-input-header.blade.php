<div  class="row gy-1 my-1" style="border:1px solid lightgray;background: white;" >
  <div class="col-md-4">
    <label  for="bank" class="form-label ">المصرف</label>
    <input wire:model="bank"  wire:keydown.Enter="ChkBankAndGo" type="text" class=" form-control "
           id="bank_no"   autofocus >
    @error('bankno') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-8" >
    <label  class="form-label"> حافظة رقم : {{$hafitha}} </label>
    @livewire('bank.bank-haf-select')
  </div>
  <div class="col-md-4">
    <div >
      <label for="no" class="form-label">تاريخ الحافظة</label>
      <input wire:model="hafitha_date"  class="form-control" type="text"  id="hafitha_date" readonly>
    </div>
    <div  >
      <label  for="acc" class="form-label">المبلغ</label>
      <input  wire:model="hafitha_tot"  class="form-control"  type="text"  id="hafitha_tot" readonly>
    </div>
    <div  >
      <label  for="acc" class="form-label">تم ادخاله</label>
      <input  wire:model="hafitha_enter"  class="form-control"  type="text"  id="hafitha_enter" readonly>
    </div>
    <div  >
      <label  for="acc" class="form-label">المتبقي</label>
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
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>

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
