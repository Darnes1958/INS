<div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">
<div class="col-md-5">
  <div class="col-md-8 mb-2">
    <label   class="form-label-me"> عدد الصكوك المستلمة</label>
    <input  wire:model="chk_in"   class="form-control  "    type="number"  readonly >

  </div>
  <div class="col-md-8 mb-2">
    <label   class="form-label-me">عدد الصكوك المرجعة</label>
    <input  wire:model="chk_out"   class="form-control  "    type="number"  readonly >
  </div>
  <div class="col-md-8 mb-2">
    <label for="wdate" class="form-label-me">التاريخ</label>
    <input x-bind:disabled="!$wire.OpenDetail" wire:model="wdate" wire:keydown.enter="$emit('gotodet','chk_count')"
           class="form-control  "
           type="date"  id="wdate" >
    @error('wdate') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-8 mb-2">
    <label  for="chk_count" class="form-label-me">عدد الصكوك</label>
    <input x-bind:disabled="!$wire.OpenDetail" wire:model="chk_count" wire:keydown.enter="$emit('gotodet','SaveBtn')"
           class="form-control  "
           type="number"  id="chk_count" >
    @error('chk_count') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="my-3 align-center justify-content-center "  style="display: flex">
    <input x-bind:disabled="!$wire.OpenDetail" type="button"  id="SaveBtn"
           class=" btn btn-outline-success  waves-effect waves-light   "
           wire:click.prevent="DoSave"   value="تخزين" />
  </div>
</div>

<div class="col-md-7">
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="13%">الرقم الألي</th>
      <th >التاريخ</th>
      <th width="16%">العدد</th>
      <th width="5%"></th>
      <th width="5%"></th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList as  $item)
      <tr class="font-size-12">
        <td>{{$item->rec_no}}</td>
        <td>{{$item->wdate}}</td>
        <td>{{$item->chk_count}}</td>

        <td  style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click="selectItem({{ $item->rec_no }},{{$item->chk_count}})"
             class="btn btn-outline-danger btn-sm fa fa-times "></i>
        </td>
        <td  style="padding-top: 2px;padding-bottom: 2px; ">
          <a href="{{route('pdfchk',['bank_name'=>$bank_name,'name'=>$name,'acc'=>$acc,'chk_count'=>$item->chk_count,'wdate'=>$item->wdate])}}"
             class="btn btn-outline-primary btn-sm fa fa-print "></a>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links() }}
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

</div>

@push('scripts')
<script type="text/javascript">
    window.addEventListener('OpenMyDelete', event => {
        $("#ModalMyDelete").modal('show');
    })
    window.addEventListener('CloseMyDelete', event => {
        $("#ModalMyDelete").modal('hide');
    })
    window.addEventListener('mmsg',function(e){
        MyMsg.fire({
            confirmButtonText:  e.detail,
        })
    });
    Livewire.on('gotodet',postid=>  {

        if (postid=='chk_count') {  $("#chk_count").focus();$("#chk_count").select(); }
        if (postid=='wdate') {  $("#wdate").focus();$("#wdate").select(); }
        if (postid=='SaveBtn') {
            setTimeout(function() { document.getElementById('SaveBtn').focus(); },100);};
    })
</script>
@endpush
