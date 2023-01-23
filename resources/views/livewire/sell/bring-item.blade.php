<div x-data    class="row gy-3 my-1" style="border:1px solid lightgray;background: white; " >
  <div class="col-md-10">
    <table class="table-sm table-bordered " width="100%"  id="hafheadertable" >
      <thead>
      <tr>
        <th width="60%">المكان</th>
        <th width="60%">الكمية</th>
      </tr>
      </thead>
      <tbody id="addRow" class="addRow">

        @foreach($second as  $item)
          <tr>
            <td > <a @click="$wire.TakeMe({{$item->raseed}},'{{$item->place_type}}','{{$item->place_no}}')" href="#">{{ $item->place_name }}</a>  </td>
            <td > <a @click="$wire.TakeMe({{$item->raseed}},'{{$item->place_type}}','{{$item->place_no}}')"  href="#">{{ $item->raseed }}</a>  </td>

          </tr>
        @endforeach

      </tbody>

    </table>
  </div>
  <div class="col-md-5"  >
    <label   class="form-label-me ">رقم اذن الصرف</label>
    <input  wire:model="themax"   type="text" class=" form-control "  style="color: blue"   readonly   >

  </div>

  <div class="col-md-6 ">
    <label for="quantbring" class="form-label-me " >الكمية</label>
    <input wire:model="quantbring" wire:keydown.enter="ChkQuant"  x-bind:disabled="!$wire.Place1Geted"
           class="form-control "  type="number" value="1"
           id="quantbring"  style="text-align: center" >
    @error('quantbring') <span class="error">{{ $message }}</span> @enderror
  </div>
  <div class="col-md-6 ">
    <label for="raseed" class="form-label-me " >الرصيد</label>
    <input wire:model="raseed"   readonly    class="form-control "  type="number"    id="quant"  style="text-align: center" >

  </div>


  <div  class="my-4 align-center justify-content-center "  style="display: flex">
    <input  type="button"  id="head-btnbring"   class=" btn btn-outline-success  waves-effect waves-light   "
            x-bind:disabled="!$wire.QuantGeted " wire:click.prevent="Save"   value=" موافق " />
  </div>

</div>

@push('scripts')


  <script type="text/javascript">
      Livewire.on('goto',postid=>  {

          if (postid=='place_no1') {  $("#place_no1").focus();$("#place_no1").select(); }
          if (postid=='quantbring') {  $("#quantbring").focus();$("#quantbring").select(); }

          if (postid=='head-btnbring') {

              setTimeout(function() { document.getElementById('head-btnbring').focus(); },100);};
      })
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });

      $(document).ready(function ()
      {
          $('#Place_L1').select2({
              closeOnSelect: true
          });
          $('#Place_L1').on('change', function (e) {
              var data = $('#Place_L1').select2("val");
          @this.set('place_no1', data);
          @this.set('ThePlace1ListIsSelected', 1);
          });
      });
      window.livewire.on('place1-change-event',()=>{
          $('#Place_L1').select2({
              closeOnSelect: true
          });
      });




  </script>
@endpush

