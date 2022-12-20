<div x-data class="row gy-1 my-1" style="border:1px solid lightgray;background: white;">

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


<div x-show="$wire.TarGet" class="col-md-6 mb-2">
  <label  class="form-label align-right" >الغاء ترجيعات سابقة</label>
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th width="13%">الرقم الألي</th>
      <th width="13%">التاريخ</th>
      <th width="16%">المبلغ</th>
      <th width="10%"></th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList2 as  $item)
      <tr class="font-size-12">
        <td>{{$item->wrec_no}}</td>
        <td>{{$item->tar_date}}</td>
        <td>{{$item->kst}}</td>
        <td  style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click="selectItem({{ $item->wrec_no }},'delete')"
             class="btn btn-outline-danger btn-sm fa fa-times "></i>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList2->links() }}
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
      Livewire.on('gotodet',postid=>  {
          if (postid=='SaveBtn') {
              setTimeout(function() { document.getElementById('SaveBtn').focus(); },100);};
      })
  </script>
@endpush
