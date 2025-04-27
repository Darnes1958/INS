<div x-data class="col-md-8" style="border:1px solid lightgray;background: white;">
  <div class="row my-3 mx-1">

      @role('info')
      <div class="col-md-11" >
          @livewire('stores.item-select')
      </div>
      <div class="col-md-1">
          <button wire:click="$emit('CloseItemRep')"  type="button" class="btn btn-outline-danger btn-sm far fa-window-close" ></button>
      </div>
      @else
          <div class="col-md-12" >
              @livewire('stores.item-select')
          </div>
      @endrole

    <div class="col-md-4" >
        <label  for="itemno" class="form-label-me ">رقم الصنف</label>
        <input wire:model="itemno"  wire:keydown.enter="ChkItemAndGo"  x-bind:disabled="!$wire.DetailOpen"
               type="text" class="form-control"  id="itemno" name="itemno" style="text-align: center;height: 39px;">
    </div>
    <div class="col-md-8">
        <label   class="form-label-me ">اسم الصنف</label>
        <textarea wire:model="item_name" name="item_name" class="form-control"
                  style="color: #0b5ed7; "
                  readonly id="item_name" ></textarea>
    </div>
    <div class="col-md-8">
        <label   class="form-label-me ">نوع الصنف</label>
        <textarea wire:model="type_name"  class="form-control"
                  style="color: #0b5ed7; "  readonly ></textarea>
    </div>
          <div class="col-4 ">
              <label  class="form-label-me" >الرصيد الكلي</label>
              <input wire:model="raseed" class="form-control " type="text" style="text-align: center;height: 39px;" readonly>
          </div>

              <div class="col-6 "></div>



      <div class="my-3 col-md-12 " >
          <label  class="form-label-me" >أسعار البيع</label>
          <table class="table-sm table-bordered " style="width: 100%">
              <thead style="background: lightgray">
              <tr>
                  <th style="width: 25%">الرقم الألي</th>
                  <th style="width: 50%">البيان </th>
                  <th style="width: 25%">السعر </th>
              </tr>
              </thead>
              <tbody >
              @foreach($pricetable as $key => $item)
                  <tr>
                      <td style="color: #0c63e4; text-align: center"> {{ $item->price_type }} </td>
                      <td > {{ $item->type_name }} </td>
                      <td> {{ $item->price }} </td>
                  </tr>
              @endforeach
              </tbody>
          </table>
      </div>





  </div>
</div>
@push('scripts')
    <script type="text/javascript">
        Livewire.on('gotonext',postid=>  {
            if (postid=='itemno') {  $("#itemno").focus(); $("#itemno").select();};
        });

        $(document).ready(function ()
        {
            $('#Item_L').select2({
                closeOnSelect: true
            });
            $('#Item_L').on('change', function (e) {
                var data = $('#Item_L').select2("val");
            @this.set('itemno', data);
            @this.set('TheItemIsSelected', 1);
            });
        });
        window.livewire.on('item-change-event',()=>{
            $('#Item_L').select2({
                closeOnSelect: true
            });
        });
    </script>

@endpush


