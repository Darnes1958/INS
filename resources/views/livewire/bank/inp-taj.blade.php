<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header" style="background: #0e8cdb;color: white;font-size: 14pt;">ادخال مصارف تجميعية</div>

        <div class="card-body">

            <div class="row mb-3">
              <label for="id" class="col-md-4 col-form-label text-md-end">الشركة</label>
              <div class="col-md-6">
                <select  wire:model="CompNo"   id="comp_id" class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"    >
                  <option >اختيار</option>
                  @foreach($CompTable as $s)
                    <option value="{{ $s->CompNo }}">{{ $s->CompName }}</option>
                  @endforeach
                </select>
                @error('CompNo') <span class="error">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label   class="col-md-4 col-form-label text-md-end">رقم الحساب </label>
              <div class="col-md-6">
              <input wire:model="TajAcc" wire:keydown.enter="$emit('gotome','TajName')" id="TajAcc" type="number" class="form-control "  >
                @error('TajAcc') <span class="error">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label  class="col-md-4 col-form-label text-md-end">اسم المصرف</label>
              <div class="col-md-6">
                <input wire:model="TajName" wire:keydown.enter="$emit('gotome','btn-save')" id="TajName" type="text" class="form-control "  >
                @error('TajName') <span class="error">{{ $message }}</span> @enderror
              </div>
            </div>

            <div class="row mb-0">
              <div class="col-md-4 " style="margin-right: 40%">
                <button type="submit" wire:click="Save" class="btn btn-primary" id="btn-save">
                  نخزين
                </button>
              </div>
            </div>

        </div>

      </div>
    </div>
    <div class="col-md-6">
      <div class="card">
        <div class="card-body">
          <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
            <thead class="font-size-12">
            <tr>
              <th width="12%">الرقم الألي</th>
              <th width="25%">رقم الحساب</th>
              <th >اسم المصرف التجميعي</th>
              <th width="5%"></th>
              <th width="5%"></th>
            </tr>
            </thead>
            <tbody id="addRow" class="addRow">
            @foreach($TajTable as  $item)
              <tr class="font-size-12">
                <td>{{$item->TajNo}}</td>
                <td>{{$item->TajAcc}}</td>
                <td>{{$item->TajName}}</td>

                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                  <i wire:click="selectItem({{ $item->TajNo }},'update')"
                     class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
                </td>
                <td  style="padding-top: 2px;padding-bottom: 2px; ">
                  <i wire:click="selectItem({{ $item->TajNo }},'delete')"
                     class="btn btn-outline-danger btn-sm fa fa-times "></i>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
          {{ $TajTable->links() }}
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
    </div>
  </div>
</div>
@push('scripts')

  <script>
      Livewire.on('gotome',postid=>  {
          if (postid=='TajAcc') {  $("#TajAcc").focus();$("#TajAcc").select(); }
          if (postid=='TajName') {  $("#TajName").focus();$("#TajName").select(); }


          if (postid=='btn-save') {
              setTimeout(function() { document.getElementById('btn-save').focus(); },100);};
      })
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
  </script>
@endpush

