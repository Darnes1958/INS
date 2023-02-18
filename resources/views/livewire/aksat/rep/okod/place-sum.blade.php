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

  <table class="table table-sm table-bordered table-striped table-light " width="100%"  id="mytable3" >
    <thead class="font-size-12">
    <tr>
      <th>ت</th>
      <th class="sort text-primary" wire:click="sortOrder('place_name')">اسم المصرف {!! $sortLink !!}</th>
      <th class="sort text-primary" wire:click="sortOrder('WCOUNT')">عدد العقود {!! $sortLink !!}</th>
      <th class="sort text-primary" wire:click="sortOrder('sumsul')">اجمالي العقود {!! $sortLink !!}</th>
      <th class="sort text-primary" wire:click="sortOrder('sumpay')">المسدد {!! $sortLink !!}</th>
      <th class="sort text-primary" wire:click="sortOrder('sumraseed')">المتبقي {!! $sortLink !!}</th>

    </tr>
    </thead>
    <tbody id="addRow" class="addRow">

    @if ($RepTable )
      @php $count=0;$sul=0;$pay=0;$raseed=0;$over=0;$tar=0;$wrong=0; @endphp
      @if ($RepChk)
      @foreach($RepTable2 as $key=>$item)
        <tr class="font-size-12">
          <td> {{ $key+1}} </td>
          <td> {{ $item->place_name }} </td>
          <td> {{  number_format($item->WCOUNT,0, '.', ',') }} </td>
          <td> {{  number_format($item->sumsul,0, '.', ',') }} </td>
          <td> {{  number_format($item->sumpay,0, '.', ',') }} </td>
          <td> {{  number_format($item->sumraseed,0, '.', ',') }} </td>
        </tr>
        @php $count+=$item->WCOUNT;$sul+=$item->sumsul;$pay+=$item->sumpay;$raseed+=$item->sumraseed;
             @endphp
      @endforeach
      @else
        @foreach($RepTable as $key=>$item)
          <tr class="font-size-12">
            <td> {{ $key+1}} </td>
            <td> {{ $item->place_name }} </td>
            <td> {{  number_format($item->WCOUNT,0, '.', ',') }} </td>
            <td> {{  number_format($item->sumsul,0, '.', ',') }} </td>
            <td> {{  number_format($item->sumpay,0, '.', ',') }} </td>
            <td> {{  number_format($item->sumraseed,0, '.', ',') }} </td>
          </tr>
          @php $count+=$item->WCOUNT;$sul+=$item->sumsul;$pay+=$item->sumpay;$raseed+=$item->sumraseed;
            @endphp
        @endforeach

      @endif
      <tr style="background: #9dc1d3;">
        <td colspan="2" style="text-align: center;"> إجمالي الصفحة </td>
        <td style="font-weight: bold"> {{ number_format($count,0, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($sul,0, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($pay,0, '.', ',') }} </td>
        <td style="font-weight: bold"> {{ number_format($raseed,0, '.', ',') }} </td>


      </tr>
    @endif
    </tbody>
      @if (! $RepChk)
      <tbody>
      <tr style="background: #9dc1d3;">
          <td colspan="2" style="text-align: center;"> الإجمــالي الكلي </td>
          <td style="font-weight: bold"> {{ number_format($ccount,0, '.', ',') }} </td>
          <td style="font-weight: bold"> {{ number_format($ssul,0, '.', ',') }} </td>
          <td style="font-weight: bold"> {{ number_format($ppay,0, '.', ',') }} </td>
          <td style="font-weight: bold"> {{ number_format($rraseed,0, '.', ',') }} </td>
      </tr>
      </tbody>
      @else
          <tbody>
          <tr style="background: #9dc1d3;">
              <td colspan="2" style="text-align: center;"> الإجمــالي الكلي </td>
              <td style="font-weight: bold"> {{ number_format($Rccount,0, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($Rssul,0, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($Rppay,0, '.', ',') }} </td>
              <td style="font-weight: bold"> {{ number_format($Rrraseed,0, '.', ',') }} </td>
              <td > </td>
              <td style="font-weight: bold">  </td>
              <td style="font-weight: bold">  </td>

          </tr>
          </tbody>
      @endif
  </table>

  @if ($RepTable )
    @if ($RepChk)
    {{ $RepTable2->links() }}
    @else
      {{ $RepTable->links() }}
    @endif
  @endif
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


