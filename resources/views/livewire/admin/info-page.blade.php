<div x-data class="row justify-content-center">
    <div x-show=" ! $wire.showokod && ! $wire.showokodarc" class="col-md-8 ">
        <div class="card justify-content-center">
            <div class="card-header">مرحبا بكم {{$CompanyName}}</div>
            <div class="card-body">
                <button  wire:click="Okod" class="col-md-6  my-4 btn btn-primary"
                         style="margin-right: 25%;margin-left: 25%;">
                    استفسار عن عقود قائمة
                </button>
                <button  wire:click="OkodArc" class="col-md-6  my-4 btn btn-primary"
                         style="margin-right: 25%;margin-left: 25%;">
                    استفسار عن عقود من الأرشيف
                </button>
            </div>
        </div>
    </div>
    <div x-show="$wire.showokod"  class="row mb-3 ">
        <div  class="col-md-6 themed-grid-col">
            @livewire('aksat.rep.okod.rep-main-head')
            @livewire('aksat.rep.okod.rep-main-data')
        </div>
        <div  class="col-md-6 themed-grid-col px-1">
            @livewire('aksat.rep.okod.rep-main-trans')
        </div>
    </div>
    <div x-show="$wire.showokodarc" class="row mb-3 ">
        <div  class="col-md-6 themed-grid-col">
            @livewire('aksat.rep.okod.rep-main-head-arc')
            @livewire('aksat.rep.okod.rep-main-data-arc')
        </div>
        <div  class="col-md-6 themed-grid-col px-1">
            @livewire('aksat.rep.okod.rep-main-trans-arc')
        </div>
    </div>
</div>
