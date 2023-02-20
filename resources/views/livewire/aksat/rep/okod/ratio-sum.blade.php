<div x-data>
  <div class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >


    <div class="col-md-2 my-2 ">
      <input wire:model="search"  type="search"   placeholder="ابحث هنا .......">
    </div>

    <div class="col-md-6 my-2 d-inline-flex ">
      <div class="mx-3  d-inline-flex ">
        <input class="form-check-input "  name="repchk" type="checkbox" wire:model="RepChk"  >
        <label class="form-check-label mx-1"  style="color: blue" for="repchk">بالتاريخ</label>
      </div>
      <label  class="form-label mx-1  " >من تاريخ</label>
      <input x-bind:disabled="!$wire.RepChk" wire:model="date1" wire:keydown.enter="Date1Chk"  class="form-control mx-2  w-25" type="date"  id="date1" >
      @error('date1') <span class="error">{{ $message }}</span> @enderror

      <label  class="form-label  mx-1 " >إلي تاريخ</label>
      <input x-bind:disabled="!$wire.RepChk" wire:model="date2" wire:keydown.enter="Date2Chk" class="form-control mx-2  w-25" type="date"  id="date2" >
      @error('date2') <span class="error">{{ $message }}</span> @enderror
    </div>
      <div  class="col-md-2 ">

      </div>

  </div>
<div class="row">
 <div class="col-md-6">
  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th class="sort text-primary" wire:click="sortOrder('place_name')">نقطة البيع {!! $sortLink !!}</th>

      <th class="sort text-primary" wire:click="sortOrder('sumsul')">اجمالي العقود {!! $sortLink !!}</th>
      <th class="sort text-primary" wire:click="sortOrder('sumpay')">المسدد {!! $sortLink !!}</th>
      <th class="sort text-primary" wire:click="sortOrder('sumraseed')">المتبقي {!! $sortLink !!}</th>
      <th class="sort text-primary" wire:click="sortOrder('ratio')">العمولة {!! $sortLink !!}</th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">

    @if ($RepTable )

        @foreach($RepTable as $key=>$item)
          <tr class="font-size-12">
            <td><a wire:click="selectItem({{ $item->place_type }},{{ $item->place_no }},'{{ $item->place_name }}')" href="#">{{ $item->place_name }}</a>  </td>

            <td> {{  number_format($item->sumsul,0, '.', ',') }} </td>
            <td> {{  number_format($item->sumpay,0, '.', ',') }} </td>
            <td> {{  number_format($item->sumraseed,0, '.', ',') }} </td>
            <td> {{  number_format($item->ratio,0, '.', ',') }} </td>
          </tr>
        @endforeach


    </tbody>

          <tbody>
          <tr style="background: #9dc1d3;">
              <td  style="text-align: center;"> الإجمــالي  </td>

              <td style="font-weight: bold"> {{ number_format($ssul,0, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($ppay,0, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($rraseed,0, '.', ',') }} </td>
              <td > </td>
              <td style="font-weight: bold">  </td>
              <td style="font-weight: bold">  </td>

          </tr>
          </tbody>

  </table>
   @endif
  @if ($RepTable )

      {{ $RepTable->links() }}

  @endif
 </div>

 <div class="col-md-6">
     <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
         <caption class="caption-top">{{$PlaceName}}</caption>
         <thead class="font-size-12">
         <tr>
             <th>اسم المصرف</th>

             <th>اجمالي العقود</th>
             <th>المسدد</th>
             <th>المتبقي</th>
           <th>العمولة</th>
         </tr>
         </thead>
         <tbody id="addRow" class="addRow">

         @if ($BankTable )
                 @foreach($BankTable as $key=>$item)
                     <tr class="font-size-12">
                         <td> {{ $item->bank_name }} </td>

                         <td> {{ number_format($item->sumsul,0, '.', ',') }} </td>
                         <td> {{ number_format($item->sumpay,0, '.', ',') }} </td>
                         <td> {{ number_format($item->sumraseed,0, '.', ',') }} </td>
                         <td> {{ number_format($item->ratio,0, '.', ',') }} </td>

                     </tr>
                 @endforeach
         @endif
         </tbody>

     </table>

     @if ($BankTable )

             {{ $BankTable->links() }}

     @endif
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
  </script>
@endpush


