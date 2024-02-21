<div xdata >
  <div   class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-5">
      @livewire('aksat.rep.taj-comp-mahjoza',
      ['sender' => 'aksat.rep.okod.rep-mahjoza',])
    </div>
    <div class="col-md-3 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>

    <div class="col-md-3">
      <div class="form-check form-check-inline my-1 mx-1">
        <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="Yes">
        <label class="form-check-label" for="inlineRadio1">المحجوزة</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="Not">
        <label class="form-check-label" for="inlineRadio2">الغير محجوزة</label>
      </div>
    </div>

  <div x-show="$wire.RepRadio=='Not'" class="col-md-1 ">
      <a  href="{{route('pdfmahjoza',['TajNo'=>$TajNo,])}}"
          class="btn btn-success waves-effect waves-light"><i class="fa fa-print"></i></a>
  </div>
  </div>


  <div class="row">
    <div class="col-md-8">
      @if($RepRadio=='Yes')
      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <caption class="caption-top text-center text-warning font-size-18" >الحجوزات القائمة</caption>
        <thead class="font-size-12">
        <tr>
          <th width="10%" class="sort  text-primary" wire:click="sortOrder('no')"> رقم العقد {!! $sortLink !!}</th>
          <th width="16%" class="sort  text-primary" wire:click="sortOrder('acc')"> رقم الحساب {!! $sortLink !!}</th>
          <th  class="sort  text-primary" wire:click="sortOrder('name')"> الاسم {!! $sortLink !!}</th>
          <th width="16%" class="sort  text-primary" wire:click="sortOrder('sal_date')"> تاريخ اخر مرتب {!! $sortLink !!}</th>
          <th width="12%">الأقساط المحجوزة</th>
          <th width="10%">عددها</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @if ($RepTable )

          @foreach($RepTable as $key=>$item)
            <tr class="font-size-12">
              <td > {{ $item->no }} </td>
              <td > {{ $item->acc }} </td>
              <td >  {{ $item->name }} </td>
              <td > {{ $item->sal_date }} </td>
              <td >{{ number_format($item->aksat_tot,2, '.', '') }}  </td>
              <td > {{ $item->aksat_count }} </td>
            </tr>
          @endforeach
        @endif
        </tbody>
      </table>

      @if ($RepTable )
        {{ $RepTable->links() }}
      @endif

     @endif


      @if($RepRadio=='Not')

          <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
            <caption class="caption-top text-center text-warning font-size-18" >الغير محجوزة</caption>

            <thead class="font-size-12">
            <tr>
              <th width="10%" class="sort  text-primary" wire:click="sortOrder2('no')"> رقم العقد {!! $sortLink !!}</th>
              <th width="16%" class="sort  text-primary" wire:click="sortOrder2('acc')"> رقم الحساب {!! $sortLink !!}</th>
              <th  class="sort  text-primary" wire:click="sortOrder2('name')"> الاسم {!! $sortLink !!}</th>
              <th width="14%" class="sort  text-primary" wire:click="sortOrder2('sul_date')"> تاريخ العقد {!! $sortLink !!}</th>


              <th width="10%">القسط</th>
            </tr>
            </thead>
            <tbody id="addRow" class="addRow">
            @if ($RepNot )

              @foreach($RepNot as $key=>$item)
                <tr class="font-size-12">
                  <td > {{ $item->no }} </td>
                  <td > {{ $item->acc }} </td>
                  <td >  {{ $item->name }} </td>
                  <td >  {{ $item->sul_date }} </td>

                  <td >{{ number_format($item->kst,2, '.', '') }}  </td>
                </tr>
              @endforeach
            @endif
            </tbody>
          </table>

          @if ($RepNot)
            {{ $RepNot->links() }}
          @endif


      @endif
    </div>

</div>
@push('scripts')
  <script type="text/javascript">

      window.addEventListener('mmsg',function(e){
          MyMsg.fire({
              confirmButtonText:  e.detail,
          })
      });
  </script>
@endpush

