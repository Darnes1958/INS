<div x-data class="my-2">
  <input wire:model="search"  x-show="$wire.IsSearchable" type="search"  style="margin: 5px;" placeholder="ابحث هنا .......">
  <button type="button" class="btn btn-outline-primary btn-sm fa fa-plus"
          x-show="$wire.HasAdd"    wire:click="$emit('OpenMyTableAdd')">إضافة </button>
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable2" >
    <thead class="font-size-12">
    <tr>
      @php
        for ($x = 0; $x <count($this->ColHeader); $x++) {
            echo "<th>".$this->ColHeader[$x]."</th>";
   }
      @endphp
    </tr>
    </thead>
    <tbody id="addRow" class="addRow">
    @foreach($TableList as  $item)
      <tr class="font-size-12">
        @php
          for ($x = 0; $x <count($this->ColNames); $x++) {
             if ($x==0) {echo "<td>".$item->Col1."</td>";};
             if ($x==1) {echo "<td>".$item->Col2."</td>";};
             if ($x==2) {echo "<td>".$item->Col3."</td>";};
             if ($x==3) {echo "<td>".$item->Col4."</td>";};
             if ($x==4) {echo "<td>".$item->Col5."</td>";};
             if ($x==5) {echo "<td>".$item->Col6."</td>";};
             if ($x==6) {echo "<td>".$item->Col7."</td>";};
             if ($x==7) {echo "<td>".$item->Col8."</td>";};
             if ($x==8) {echo "<td>".$item->Col9."</td>";};
             if ($x==9) {echo "<td>".$item->Col10."</td>";};
     }
        @endphp
        <td x-show="$wire.HasDelete" style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click="selectItem({{ $item->Col1 }}, 'update')" class="btn btn-outline-primary btn-sm fa fa-edit editable-input" style="margin-left: 2px;"></i>
        </td>
        <td x-show="$wire.HasEdit" style="padding-top: 2px;padding-bottom: 2px; ">
          <i wire:click="$emit('OpenMyTableEdit')" class="btn btn-outline-danger btn-sm fa fa-times "></i>
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
  {{ $TableList->links() }}

  <!-- Modal Add -->
  <div class="modal fade" id="ModalMyTableAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button wire:click="$emit('CloseMyTableAdd')" type="button" class="btn-close" ></button>
          <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">ادخال {{$ModalTitle}} جديد</h1>
        </div>
        <div class="modal-body">
          @livewire($AddModal)
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Add -->

  <!-- Modal Edit -->
  <div class="modal fade" id="ModalMyTableEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button wire:click="$emit('CloseMyTableEdit')" type="button" class="btn-close" ></button>
          <h1 class="modal-title fs-5 mx-6" id="exampleModalLabel">تعديل {{$ModalTitle}} </h1>
        </div>
        <div class="modal-body">
          @livewire($EditModal)
        </div>
      </div>
    </div>
    <!-- End Modal Edit -->
  </div>

</div>

@push('scripts')
  <script>
      Livewire.on('OpenMyTableAdd', postId => {
          $("#ModalMyTableAdd").modal('show');
      })
      Livewire.on('CloseMyTableAdd', postId => {
          $("#ModalMyTableAdd").modal('hide');
      })
      Livewire.on('CloseMyTableEdit', postId => {
          $("#ModalMyTableEdit").modal('hide');
      })
      window.addEventListener('OpenMyTableEdit', event => {
          $("#ModalMyTableEdit").modal('show');
      })
      window.addEventListener('CloseMyTableEdit', event => {

          $("#ModalMyTableEdit").modal('hide');
      })






  </script>
@endpush
