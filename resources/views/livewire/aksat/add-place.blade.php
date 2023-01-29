<div class="col-md-12 col-lg-12 ">


  <div class="col-md-12 my-2">
    <label for="name" class="form-label">جهة العمل</label>
    <input wire:model="place_name"  wire:keydown.enter="SaveOne" type="text" class="form-control" id="place_name" placeholder="" autofocus>
    @error('place_name') <span class="error">{{ $message }}</span> @enderror
  </div>
  @if (session()->has('message'))
    <div class="alert alert-success">
      {{ session('message') }}
    </div>
  @endif



  <table class="table-sm table-bordered " width="100%"  id="itemtype" >
    <thead>
    <tr>
      <th width="30%">الرقم الألي</th>
      <th>البيان</th>
      <th width="5%"> </th>
      <th width="5%"> </th>
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($place as $key => $item)
      <tr>
        <td style="color: #0c63e4; text-align: center"> {{ $item['place_no'] }} </td>
        <td > {{ $item['place_name'] }} </td>
        <td><i wire:click="EditOne({{ $item['place_no'] }},'{{$item['place_name']}}')"
               class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i></td>
        <td><i wire:click="DeleteOne({{ $item['place_no'] }})"
               class="btn btn-outline-danger btn-sm fa fa-times" style="margin-left: 2px;"></i></td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $place->links() }}

</div>

@push('scripts')
  <script type="text/javascript">
      Livewire.on('gotoedit',postid=>  {


          if (postid=='place_name') {  $("#place_name").focus();$("#place_name").select(); }
      })
      window.addEventListener('ClosePlace', event => {
          $("#PlaceModal").modal('hide');
      })
      window.addEventListener('OpenPlace', event => {
          $("#PlaceModal").modal('show');
      })
      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });

  </script>
@endpush
