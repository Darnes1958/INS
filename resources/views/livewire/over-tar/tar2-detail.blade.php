<div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">
    <div x-show="$wire.NoGet" class="col-md-4 mb-2">
        <label for="tar_date" class="form-label-me">تاريخ الترجيع</label>
        <input wire:model="tar_date"
               class="form-control  "
               type="date"  id="tar_date" >
        @error('tar_date') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div x-show="$wire.NoGet" class="col-md-8 mb-2">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions1" id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">نقدا</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions2" id="inlineRadio2" value="2">
                <label class="form-check-label" for="inlineRadio2">مصرفي</label>
            </div>


            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions3" id="inlineRadio3" value="3">
                <label class="form-check-label" for="inlineRadio3">صك</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" wire:model="ksm_type"  name="inlineRadioOptions4" id="inlineRadio4" value="4">
                <label class="form-check-label" for="inlineRadio4">الكتروني</label>
            </div>
    </div>




  <div  x-show="$wire.NoGet" class="col-md-6 mb-2">
    <label  class="form-label align-right" >قم باختيار القسط المراد ترجيعه</label>
    <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
      <thead class="font-size-12">
      <tr>
        <th width="13%">ت</th>
        <th width="13%">تاريخ الخصم</th>
        <th width="16%">المبلغ</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($TableList as  $item)
        <tr class="font-size-12">
          <td > <a wire:click="selectItem({{ $item->ser}},{{$item->ksm }})" href="#">{{$item->ser}}</a>
          <td > <a wire:click="selectItem({{ $item->ser}},{{$item->ksm }})" href="#">{{$item->ksm_date}}</a>
          <td > <a wire:click="selectItem({{ $item->ser}},{{$item->ksm }})" href="#" >{{$item->ksm}}</a>
        </tr>
      @endforeach
      </tbody>
    </table>
    {{ $TableList->links() }}
  </div>
    <div  x-show="$wire.TarGet" class="col-md-6 mb-2">
        <label  class="form-label align-right" >الغاء ترجيعات سابقة</label>
        <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
            <thead class="font-size-12">
            <tr>
                <th width="13%">الرقم الألي</th>
                <th width="13%">التاريخ</th>
                <th width="16%">المبلغ</th>
                <th width="5%"></th>

            </tr>
            </thead>
            <tbody id="addRow" class="addRow">
            @foreach($TableList2 as  $item)
                <tr class="font-size-12">
                    <td>{{$item->wrec_no}}</td>
                    <td>{{$item->tar_date}}</td>
                    <td>{{$item->kst}}</td>
                    <td  style="padding-top: 2px;padding-bottom: 2px; ">
                        <i wire:click="selectItem2({{ $item->wrec_no }})"
                           class="btn btn-outline-danger btn-sm fa fa-times "></i>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $TableList2->links() }}
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
                        <button type="button" wire:click.prevent="DoSomeThing()" class="btn btn-danger close-modal" data-dismiss="modal">نعم متأكد</button>
                    </div>
                </div>
            </div>
        </div>
    </div>




</div>

@push('scripts')
  <script type="text/javascript">
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
      window.addEventListener('OpenMyDelete', event => {
          $("#ModalMyDelete").modal('show');
      })
      window.addEventListener('CloseMyDelete', event => {
          $("#ModalMyDelete").modal('hide');
      })
      Livewire.on('gotodet',postid=>  {
          if (postid=='SaveBtn') {
              setTimeout(function() { document.getElementById('SaveBtn').focus(); },100);};
      })
  </script>
@endpush
