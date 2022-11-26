<div  class="row gy-1 my-1" style="border:1px solid lightgray;background: white;" >

    <div class="modal fade" id="ModalMini" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button wire:click="CloseMini" type="button" class="btn-close" ></button>
                    <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">{{$ModalTitle}}</h1>
                </div>
                <div class="modal-body">
                    @livewire('haf.haf-mini-rep')
                </div>
            </div>
        </div>
    </div>

  <div class="col-md-4">
    <label  for="bank" class="form-label ">المصرف</label>
    <input wire:model="bank"  wire:keydown.Enter="ChkBankAndGo" type="text" class=" form-control "
           id="bank_no"   autofocus >
    @error('bankno') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div   class="col-md-8" >
    <label   class="form-label " style="color: #0a53be"> حافظة رقم : {{$hafitha}} </label>
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
      @if ($HafHeadDetail )
      @foreach($HafHeadDetail as  $item)
        <tr>
          <td > {{ $item->kst_type_name }} </td>
          <td > {{ $item->wcount }} </td>
          <td> {{ $item->sumkst }} </td>
            <td style="padding-top: 2px;padding-bottom: 2px; ">
                <i  class="btn btn-outline-primary btn-sm fa fa-info"
                    wire:click.prevent="OpenMini({{ $item->kst_type}},'{{$item->kst_type_name }}')"></i>
            </td>
        </tr>
      @endforeach
      @endif
      </tbody>

    </table><br>

      <div class="my-3 py-3 align-center justify-content-center  "  style="display: flex;border: solid lightgray 1px;">

        <i   id="add-btn"  class=" mx-2 btn btn-outline-success    fa fa-plus "
                 >&nbsp;&nbsp; حافظة جديدة</i>
        <i  id="del-btn"  class=" mx-2 btn btn-outline-danger    fas fa-times "
                 >&nbsp;&nbsp;الغاء الحافظة</i>
        <i   id="tar-btn"  class=" mx-2 btn btn-outline-info      fas fa-external-link-alt"
                  >&nbsp;&nbsp;ترحيل الحافظة</i>
      </div>
  </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('CloseMiniModal', event => {
            $("#ModalMini").modal('hide');
        })
        window.addEventListener('OpenMiniModal', event => {
            $("#ModalMini").modal('show');
        })
    </script>
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
