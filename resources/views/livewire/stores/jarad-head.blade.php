<div>
  <div class="row">
  <div class="col-md-4">
   <div class="col-md-6">
     <select  wire:model="place_nameL"   class="form-control  form-select " style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"  >
       <option value="">اختيار من القائمة</option>
       @foreach($places as $place)
         <option value="{{ $place->place_name }}">{{ $place->place_name }}</option>
       @endforeach
     </select>
   </div>
   <div class="col-md-6">
     <select  wire:model="item_typeL"   class="form-control  form-select "  style="vertical-align: middle ;font-size: 12px;height: 26px;padding-bottom:0;padding-top: 0;"  >
       <option value="">اختيار من القائمة</option>
       @foreach($item_types as $type)
         <option value="{{ $type->type_no }}">{{ $type->type_name }}</option>
       @endforeach
     </select>
   </div>
     <div class="col-md-4">
       <label for="item_no" class="form-label">رقم الصنف</label>
       <input wire:model="item_no"  wire:keydown.enter="ChkItem"  type="text" class="form-control" id="item_no"  >
       @error('item_no') <span class="error">{{ $message }}</span> @enderror
     </div>
     <div class="col-md-8">
       <label for="item_name" class="form-label">اسم الصنف</label>
       <input wire:model="item_name"  type="text" class="form-control" id="item_name" readonly >
     </div>
     <div class="col-md-4">
       <label for="JarRaseed" class="form-label">رصيد المكان</label>
       <input wire:model="JarRaseed"  wire:keydown.enter="SaveRas"  type="text" class="form-control" id="JarRaseed"  >
       @error('JarRaseed') <span class="error">{{ $message }}</span> @enderror
     </div>
     <div class="col-md-8">
       <label for="raseed" class="form-label">الرصيد الكلي</label>
       <input wire:model="raseed"  type="text" class="form-control"  readonly >
     </div>
   </div>
  <div class="col-md-6">
    <table class="table table-sm table-bordered table-striped table-light " width="100%"   >
      <thead class="font-size-12">
      <tr>
        <th width="10%">رقم الصنف</th>
        <th >اسم الصنف</th>
        <th width="10%">الرصيد الكلي</th>
        <th width="10%">رصيد المكان</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">
      @foreach($RepMak as $item)
        <tr class="font-size-12">
          <td > {{ $item->item_no }} </td>
          <td> {{ $item->item_name }} </td>
          <td> {{ $item->raseed }} </td>
          <td> {{ $item->place_ras }} </td>
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

          if (postid=='item_no') {  $("#item_no").focus(); $("#item_no").select();};
          if (postid=='JarRaseed') {  $("#JarRaseed").focus(); $("#JarRaseed").select();};


      })

  </script>
@endpush
