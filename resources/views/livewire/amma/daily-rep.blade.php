<div   class="row gy-1 my-1" style="border:1px solid lightgray;background: white; " >
    <div class="col-md-2 my-1 d-inline-flex align-items-center">
        <label for="date" class="form-label mx-1 my-1" >التاريخ</label>
        <input wire:model="RepDate" wire:keydown.enter="ChkDateAndGo"
               class="form-control"
               name="date" type="date"  id="date" >
        @error('tran_date') <span class="error">{{ $message }}</span> @enderror
    </div>
    <div class="col-md-10 my-2">
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio"   value="buys_view">
            <label class="form-check-label" >مشتريات</label>
        </div><div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" wire:click="ChangeRep"  value="sell">
            <label class="form-check-label" >مبيعات</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" wire:click="ChangeRep"  value="Tran">
            <label class="form-check-label" >ايصالات</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" wire:click="ChangeRep"  value="Aksat">
            <label class="form-check-label" >أقساط</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" wire:click="ChangeRep"  value="Over">
            <label class="form-check-label" >فائض</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" wire:click="ChangeRep"  value="Wrong">
            <label class="form-check-label" >بالخطأ</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" wire:click="ChangeRep"  value="Tar">
            <label class="form-check-label" >ترجيع</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" wire:model="RepRadio" wire:click="ChangeRep"  value="Main">
            <label class="form-check-label" >عقود</label>
        </div>
    </div>
    <div>
        @livewire('amma.daily-rep-table',['tablename'=>$RepRadio,'inpdate'=>$RepDate,'searachfield1'=>$RepSearch1 ])
    </div>

</div>

@push('scripts')
    <script>

    </script>
@endpush
