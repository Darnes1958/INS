<div class="row">
  <div class="col-md-5">
    <div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">
      <div class="col-md-5">
        <label  for="bank_no" class="form-label-me ">المصرف</label>
        <input wire:model="bankno"  wire:keydown.enter="ChkBankAndGo" type="text" class=" form-control "
               id="bank_no"   autofocus >
        @error('bankno') <span class="error">{{ $message }}</span> @enderror
      </div>
      <div   class="col-md-7" >
        <label  class="form-label-me">.</label>
        @livewire('bank.bank-select')
      </div>


      <div class="col-md-5 mb-2" >
        <label  for="acc" class="form-label-me">رقم الحساب</label>
        <input   wire:model="acc" wire:keydown.enter="$emit('goto','name')"
                 class="form-control"  name="acc" type="text"  id="acc" >
        @error('acc') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="col-md-7 mb-2" >
        <label  for="name" class="form-label-me">الإسم</label>
        <input   wire:model="name" wire:keydown.enter="$emit('goto','stop_date')"
                 class="form-control"   type="text"  id="name" >
        @error('name') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="col-md-6 mb-2">
        <label for="stop_date" class="form-label-me">التاريخ</label>
        <input  wire:model="stop_date" wire:keydown.enter="$emit('goto','SaveBtn')"
                class="form-control  "
                type="date"  id="stop_date" >
        @error('stop_date') <span class="error">{{ $message }}</span> @enderror
      </div>

      <div class="my-3 align-center justify-content-center "  style="display: flex">
        <input  type="button"  id="SaveBtn"
                class=" btn btn-outline-success  waves-effect waves-light   "
                wire:click.prevent="DoSave"   value="تخزين" />
      </div>
    </div>
  </div>
  <div class="col-md-7 my-1">
    <table class="table table-sm table-bordered table-striped table-light "   id="mytable3" >
      <thead class="font-size-12">
      <tr>
        <th width="12%">الرقم الألي</th>
        <th width="18%">رقم الحساب</th>
        <th >الاسم</th>
        <th width="13%">التاريخ</th>
        <th width="5%"></th>
        <th width="5%"></th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as  $item)
        <tr class="font-size-12">
          <td>{{$item->rec_no}}</td>
          <td>{{$item->acc}}</td>
          <td>{{$item->name}}</td>
          <td>{{$item->stop_date}}</td>
          <td  style="padding-top: 2px;padding-bottom: 2px; ">
            <i wire:click="selectItem({{ $item->rec_no }},'delete')"
               class="btn btn-outline-danger btn-sm fa fa-times "></i>
          </td>
          <td  style="padding-top: 2px;padding-bottom: 2px; ">
            <a  href="{{route('pdfstopone',['name'=>$item->name,'bank_tajmeeh'=>$item->bank_tajmeeh ,
                                              'acc'=>$item->acc,'kst'=>0])}}"
                class="btn btn-outline-primary btn-sm fa fa-print "></a>
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $TableList->links() }}
  </div>

  <div class="modal fade" id="ModalMyDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">تأكيد الحذف</h5>
          <button wire:click="CloseDeleteDialog" type="button" class="close"  >
            <span aria-hidden="true close-btn">×</span>
          </button>
        </div>
        <div class="modal-body">
          <h5>هل أنت متأكد من الإلغاء ?</h5>
        </div>
        <div class="modal-footer">
          <button  wire:click="CloseDeleteDialog" type="button" class="btn btn-secondary close-btn" >تراجع</button>
          <button type="button" wire:click.prevent="delete()" class="btn btn-danger close-modal" data-dismiss="modal">نعم متأكد</button>
        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
<script type="text/javascript">
    window.addEventListener('OpenMyDelete', event => {
        $("#ModalMyDelete").modal('show');
    })
    window.addEventListener('CloseMyDelete', event => {
        $("#ModalMyDelete").modal('hide');
    })

    Livewire.on('goto',postid=>  {
        if (postid=='bankno') {  $("#bank_no").focus();$("#bank_no").select(); }
        if (postid=='acc') {  $("#acc").focus();$("#acc").select(); }
        if (postid=='name') {  $("#name").focus();$("#name").select(); }
        if (postid=='stop_date') {  $("#stop_date").focus();$("#stop_date").select(); }
        if (postid=='SaveBtn') {
            setTimeout(function() { document.getElementById('SaveBtn').focus(); },100);};
    })
    $(document).ready(function ()
    {
        $('#Bank_L').select2({
            closeOnSelect: true
        });
        $('#Bank_L').on('change', function (e) {
            var data = $('#Bank_L').select2("val");
        @this.set('bankno', data);
        @this.set('TheBankListIsSelected', 1);
        });
    });
    window.livewire.on('bank-change-event',()=>{
        $('#Bank_L').select2({
            closeOnSelect: true
        });
    });
</script>
@endpush
