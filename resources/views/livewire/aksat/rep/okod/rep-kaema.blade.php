<div xdata >
  <div   class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-5">
      @livewire('aksat.rep.taj-comp',
      ['sender' => 'aksat.rep.okod.rep-kaema',])
    </div>
    <div class="col-md-3 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>
    <div class="col-md-3">
      <div class="form-check form-check-inline my-1 mx-1">
        <input class="form-check-input" type="radio" wire:model="RepRadio"  name="inlineRadioOptions" id="inlineRadio1" value="Our">
        <label class="form-check-label" for="inlineRadio1">غير موجودة لدينا</label>
      </div>
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" wire:model="RepRadio" name="inlineRadioOptions" id="inlineRadio2" value="There">
        <label class="form-check-label" for="inlineRadio2">غير موجودة بالمصرف</label>
      </div>
    </div>


  </div>


  <div class="row">
    <div class="col-md-6">
      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <caption class="caption-top text-center text-warning font-size-18" >العقود القائمة</caption>

        <thead class="font-size-12">
        <tr>
          <th width="24%" class="sort  text-primary" wire:click="sortOrder('acc')"> رقم الحساب {!! $sortLink !!}</th>
          <th  class="sort  text-primary" wire:click="sortOrder('name')"> الاسم {!! $sortLink !!}</th>
          <th width="20%" class="sort  text-primary" wire:click="sortOrder('sul_date')"> تاريخ الصلاحية {!! $sortLink !!}</th>
          <th width="16%">القسط</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @if ($RepTable )

          @foreach($RepTable as $key=>$item)
            <tr class="font-size-12">
              <td > {{ $item->acc }} </td>
              <td >  {{ $item->name }} </td>
              <td > {{ $item->sul_date }} </td>
              <td >{{ number_format($item->kst,2, '.', '') }}  </td>
            </tr>
          @endforeach
        @endif
        </tbody>
      </table>

      @if ($RepTable )
        {{ $RepTable->links() }}
      @endif

    </div>
    @if($RepRadio=='Our')
    <div class="col-md-6" x-show="$wire.TajNo ">
      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >

        <div class="row">
          <div class="col-md-8">
            <div class="w-25 m-auto">
              <label class="form-label font-size-18 text-primary  ">غير موجودة لدينا</label>
            </div>

          </div>
          <div class="col-md-4">
            <a href="{{route('pdfkaemaNotOur',['TajNo'=>$TajNo])}}"
              class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
          </div>

        </div>
        <thead class="font-size-12">
        <tr>

          <th width="24%"  >رقم الحساب</th>
          <th   > الاسم </th>
          <th width="20%"  > تاريخ الصلاحية </th>
          <th width="16%">القسط</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @if ($RepOur )

          @foreach($RepOur as $key=>$item)
            <tr class="font-size-12">

              <td > {{ $item->acc }} </td>
              <td >  {{ $item->name }} </td>
              <td > {{ $item->sul_date }} </td>
              <td >{{ number_format($item->kst,2, '.', '') }}  </td>
            </tr>
          @endforeach
        @endif
        </tbody>
      </table>

      @if ($RepOur )
        {{ $RepOur->links() }}
      @endif

    </div>
    @endif
    @if($RepRadio=='There')
    <div class="col-md-6" x-show="$wire.TajNo ">
      <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
        <div class="row">
          <div class="col-md-8">
            <div class="w-35 m-auto">
              <label class="form-label font-size-18 text-primary  ">غير موجودة لدي المصرف</label>
            </div>

          </div>
          <div class="col-md-4">
            <a href="{{route('pdfkaemaNotThere',['TajNo'=>$TajNo])}}"
               class="btn btn-outline-success waves-effect waves-light border-0 mx-2"><i class="fa fa-print"> &nbsp;&nbsp;طباعة&nbsp;&nbsp;</i></a>
          </div>

        </div>

        <thead class="font-size-12">
        <tr>
          <th width="20%"  > رقم العقد </th>
          <th width="24%"  >رقم الحساب</th>
          <th   > الاسم </th>
          <th width="16%">القسط</th>
        </tr>
        </thead>
        <tbody id="addRow" class="addRow">
        @if ($RepThere )

          @foreach($RepThere as $key=>$item)
            <tr class="font-size-12">
              <td > {{ $item->no }} </td>
              <td > {{ $item->acc }} </td>
              <td >  {{ $item->name }} </td>

              <td >{{ number_format($item->kst,2, '.', '') }}  </td>
            </tr>
          @endforeach
        @endif
        </tbody>
      </table>

      @if ($RepThere )
        {{ $RepThere->links() }}
      @endif

    </div>
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

