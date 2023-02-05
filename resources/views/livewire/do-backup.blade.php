<div class="col-md-12 ">
  <div class="card">
    <div class="card-header" style="background: lightblue">النسخ الاحتياطي</div>
    <div class="card-body">
      <div class="row my-1">

            <div class="col-md-8">
                <p>الخظوة الأولي : إضغط علي "تنفيذ" وانتظر قليلا</p>
            </div>
            <div class="col-md-4">
                <input type="button"  id="savebtns"
                       class="w-100 btn btn-outline-success  waves-effect waves-light   "
                       wire:click.prevent="DoBackup"   value="تنفيذ" />
                <div wire:loading wire:target="DoBackup">
                    يرجي الانتظار...
                </div>

            </div>
             <div class="col-md-8">
                  <p>الخظوة الثانية : إضغط علي "تنزيل" وانتظر حتي يتم تنزيل الملف </p>
             </div>
              <div class="col-md-4">
                  <input type="button"  id="downbtn"
                         class="w-100 btn btn-outline-success  waves-effect waves-light   "
                         wire:click.prevent="DoDownLoad"   value="تنزيل" />
                <div wire:loading wire:target="DoDownLoad">
                  يرجي الانتظار...
                </div>


              </div>

        <!--            <div class="col-md-12">
                    <p>الخظوة الثانية : إضغط علي "تنزيل" </p>
                  </div>
                  <div class="col-md-4">
                    <input type="button"  id="downbtn"
                           class="w-100 btn btn-outline-success  waves-effect waves-light   "
                           wire:click.prevent="DoDel"   value="delete" />

                  </div>

                    <div class="col-md-12 my-4">
                      <p>الخظوة الثانية : إضغط علي "مسح" ليتم مسح الملف من السيرفر</p>
                    </div>
                    <div class="col-md-4">
                        <input type="button"  id="delbtn"
                               class="w-100 btn btn-outline-success  waves-effect waves-light   "
                               wire:click.prevent="DeleteTheFile"   value="مسح" />
                      <div wire:loading wire:target="DeleteTheFile">
                        يرجي الانتظار...
                      </div>
                    </div> -->


      </div>
    </div>
  </div>
</div>
