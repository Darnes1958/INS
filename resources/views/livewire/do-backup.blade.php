<div class="col-md-10 col-lg-12">

        <div class="row g-3">
            <div class="col-md-6">
                <input type="button"  id="savebtns"
                       class="w-100 btn btn-outline-success  waves-effect waves-light  my-2 "
                       wire:click.prevent="DoBackup"   value="تنفيذ" />
            </div>
            <div class="col-md-6">
                <input type="button"  id="savebtns"
                       class="w-100 btn btn-outline-success  waves-effect waves-light  my-2 "
                       wire:click.prevent="DeleteTheFile"   value="مسح" />
            </div>

        </div>
</div>
