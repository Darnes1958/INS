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
    <div class="row ">
      <div class="col-md-4  gx-3">
         <label  for="bank_no" class="form-label ">المصرف</label>
      </div>
      <div class="col-md-8  gx-3">
         <input wire:model="bank"  wire:keydown.Enter="ChkBankAndGo" type="number" class=" form-control "
           id="bank_no"   autofocus >
          @error('bankno') <span class="error">{{ $message }}</span> @enderror
      </div>
    </div>
  </div>
  <div   class="col-md-8" >

    @livewire('bank.bank-haf-select')
  </div>
  <div class="col-md-4">
      <label   class="form-label " style="color: #0a53be"> حافظة رقم : {{$hafitha}} </label>
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
      <div x-data="{isUploading:  @entangle('HafUpload'), progress: @entangle('HafProgress'),count: @entangle('HafCount'),
          ShowNew : @entangle('ShowHafNew'),ShowDel : @entangle('ShowHafDel'),ShowTarheel : @entangle('ShowHafTarheel')}">
        <div  class="my-3 py-3 align-center justify-content-center  "  style="display: flex;border: solid lightgray 1px;">
          <i  @click="ShowNew = true" id="add-btn"  class=" mx-2 btn btn-outline-success    fa fa-plus "
                   >&nbsp;&nbsp; حافظة جديدة</i>
          <i  x-show="ShowDel" wire:click="DeleteHafitha" id="del-btn"  class=" mx-2 btn btn-outline-danger    fas fa-times "
                   >&nbsp;&nbsp;الغاء الحافظة</i>
          <i  x-show="ShowTarheel" id="tar-btn"  wire:click="TarheelHafitha" class=" mx-2 btn btn-outline-info      fas fa-external-link-alt"
                   >&nbsp;&nbsp;ترحيل الحافظة</i>
        </div>



          <div x-show="isUploading" class=" my-2 py-2 px-2 align-center justify-content-center "  style="display: flex;border: solid lightgray 1px;">
            <progress max="count" x-bind:value="progress"></progress>
          </div>



        <div  x-show="ShowNew" @click.outside="ShowNew = false"
              >
          <div class="row">
            <div class="col-md-4 mb-2">
              <label  for="bank_l_no" class="form-label mb-0 ">المصرف</label>
              <input wire:model="bank_l"  wire:keydown.enter="ChkBankList" type="text" class=" form-control "
                     id="bank_l_no"   autofocus >
              @error('bank_l') <span class="error">{{ $message }}</span> @enderror
            </div>
            <div   class="col-md-8" >
              <label  class="form-label mb-0 " style="color: #0a53be">&nbsp;</label>
              @livewire('bank.bank-select')
            </div>
          <div class="col-md-4">
            <label for="no" class="form-label mb-0">تاريخ الحافظة</label>
            <input wire:model="hafitha_date_new"  wire:keydown.enter="$emit('goto','hafitha_tot_new')" class="form-control" type="date"  id="hafitha_date_new" >
            @error('hafitha_date_new') <span class="error">{{ $message }}</span> @enderror
          </div>
          <div class="col-md-4" >
            <label  for="acc" class="form-label mb-0">المبلغ</label>
            <input  wire:model="hafitha_tot_new" wire:keydown.enter="$emit('goto','Save-new-btn')" class="form-control"  type="text"  id="hafitha_tot_new" >
            @error('hafitha_tot_new') <span class="error">{{ $message }}</span> @enderror
          </div>
          <div class=" col-md-4 align-center justify-content-end" style="display: flex;">
            <input type="button"  id="Save-new-btn"
                   class=" btn btn-outline-success  waves-effect waves-light "
                   wire:click.prevent="SaveNewBtn"  value="تخزين الحافظة" />
          </div>

          </div>

        </div>
    </div>
  </div>
</div>

@push('scripts')
  <script type="text/javascript">


      Livewire.on('goto',postid=>  {

          if (postid=='bank') {  $("#bank_no").focus();$("#bank_no").select(); }
          if (postid=='hafitha_date_new') {  $("#hafitha_date_new").focus();$("#hafitha_date_new").select(); }
          if (postid=='hafitha_tot_new') {  $("#hafitha_tot_new").focus();$("#hafitha_tot_new").select(); }
          if (postid=='Save-new-btn') {
              setTimeout(function() { document.getElementById('Save-new-btn').focus(); },100);}

      })
      window.addEventListener('DelHafitha',function(e){
          MyConfirm.fire({
          }).then((result) => {
              if (result.isConfirmed) {
                  Livewire.emit('DoDeleteHafitha');
              }
          })
      });
      window.addEventListener('TarHafitha',function(e){
          MyConfirm.fire({
          }).then((result) => {
              if (result.isConfirmed) {
                  Livewire.emit('DoTarheelHafitha');
              }
          })
      });

  </script>
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

          @this.set('bank_l', data);
          @this.set('TheBankListIsSelectd', 1);
          });
      });
      window.livewire.on('bank-change-event',()=>{
          $('#Bank_L').select2({
              closeOnSelect: true
          });
      });
      $(document).ready(function ()
      {
          $('#Bank_L_H').select2({
              closeOnSelect: true
          });
          $('#Bank_L_H').on('change', function (e) {
              var data = $('#Bank_L_H').select2("val");
          @this.set('bank', data);
          @this.set('TheBankHafIsSelectd', 1);

          });
      });
      window.livewire.on('bank-haf-change-event',()=>{
          $('#Bank_L_H').select2({
              closeOnSelect: true
          });
      });


  </script>
@endpush
