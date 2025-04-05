
@auth
    @php
         $id = Auth::user()->id;
         $company = Auth::user()->company;
         $admindata = App\Models\User::find($id);
    @endphp
@endauth
    <div id="sidebar"  >
        <ul class="list-unstyled ps-0">
            @canany(['ادخال مشتريات','الغاء مشتريات','تعديل مشتريات','ترجيع مشتريات'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded   border-0 collapsed"
                        data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="true">
                    &nbsp <i class="fa  fa-cart-arrow-down" aria-hidden="true"></i>&nbsp;  مشتريات</button>
                <div class="collapse " id="home-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @can('ادخال مشتريات')
                         <!--   <li><a href="{{route('order_buy.add')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مشتريات</a></li> -->
                            <li><a href="{{route('orderbuy')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مشتريات</a></li>
                        @endcan
                        @canany(['الغاء مشتريات','تعديل مشتريات'])
                        <li><a href="{{route('order_buy.edit')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تعديل فاتورة مشتريات</a></li>
                        @endcanany
                        @can('ترجيع مشتريات')
                        <li><a href="{{route('tarbuy')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ترجيع مشتريات (مردودات)</a></li>
                        @endcan


                    </ul>
                </div>
            </li>
            @endcanany
            @canany(['تعديل مبيعات','الغاء مبيعات','ادخال مبيعات'])
                <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded    border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#dashboard-collapse" aria-expanded="false">
                    &nbsp  <i class="fa fas fa-cart-plus" aria-hidden="true"></i>&nbsp;  مبيعات
                </button>
                <div class="collapse" id="dashboard-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @can('ادخال مبيعات')
                          <li><a href="{{route('order_sell.add',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مبيعات بالتقسيط</a></li>
                          <li><a href="{{route('order_sell.add',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مبيعات نقدية</a></li>
                        @endcan
                        @canany(['تعديل مبيعات','الغاء مبيعات'])
                          <li><a href="{{route('order_sell.edit')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تعديل والغاء فاتورة</a></li>
                        @endcanany
                    </ul>
                </div>
            </li>
            @endcanany
            @canany(['ادخال ايصالات قبض','ادخال ايصالات دفع','ادخال مصروفات',
                     'سحب من المرتب','ادخال مرتبات','خصم واضافة وسحب','اعداد مرتبات'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded    border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#trans-collapse" aria-expanded="false">
                    &nbsp  <i class="fa fas fa-hand-holding-usd" aria-hidden="true"></i>&nbsp;  إيصالات قبض ودفع
                </button>
                <div class="collapse" id="trans-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                        @canany(['ادخال ايصالات قبض','ادخال ايصالات دفع'])
                        <li><a href="{{route('trans.input')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">إيصال قبض أو دفع</a></li>
                        @endcanany
                        @can('ادخال مصروفات')
                        <li><a href="{{route('inpmasr')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مصروفات</a></li>
                        @endcan

                    </ul>
                </div>
            </li>
            @endcanany
            @can('ادخال مخازن')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#stores-collapse" aria-expanded="false">
                    &nbsp   <i class="fa  fas fas fas fa-city" aria-hidden="true"></i>&nbsp;  مخازن</button>
                </button>
                <div class="collapse" id="stores-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('stores.add',11)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من مخزن لمخزن</a></li>
                        <li><a href="{{route('stores.add',12)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من مخزن لصالة</a></li>
                        <li><a href="{{route('stores.add',21)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من صالة لمخزن</a></li>
                        <li><a href="{{route('stores.add',22)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">من صالة لصالة</a></li>
                        <li><a href="{{route('repamma','DelPer')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الغاء اذن صرف</a></li>
                        @if( \App\Models\LarSetting::query()->first()->canChangePrice )
                            <li><a href="{{route('itemprices')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تغيير أسعار لصنف</a></li>
                        @else
                            @role('admin')
                              <li><a href="{{route('itemprices')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تغيير أسعار لصنف</a></li>
                            @endrole
                        @endif

                        @can('سعر الشراء')
                        <li><a href="{{route('itemdamage')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">توحيد صنف</a></li>
                        @endcan
                      @if (Auth()->User()->company=='Motahedon' || Auth()->User()->company=='Taleb' || Auth()->User()->company=='Bentaher2'
                         || Auth()->User()->company=='Sohol')
                        <li><a href="{{route('jaradraseed')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تعديل ارصدة بعد الجرد</a></li>
                       @endif

                    </ul>
                </div>
            </li>
            @endcan

            <li class="border-top my-3"></li>
            @can('ادخال عقود')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#okod-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-file-alt" aria-hidden="true"></i>&nbsp عقود</button>
                <div class="collapse" id="okod-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('main.input',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ادخال عقد جديد</a></li>
                        <li><a href="{{route('main.edit',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تعديل عقد</a></li>
                        <li><a href="{{route('main.edit',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الغاء عقد</a></li>
                        <li><a href="{{route('main.edit',3)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الغاء عقد بعد التعاقد</a></li>
                        <li><a href="{{route('main.input',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ضم عقد</a></li>
                        <li><a href="{{route('over.input','chk')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تسليم صكوك (من القائم)</a></li>
                        <li><a href="{{route('over.input','chk_a')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تسليم صكوك (من الأرشيف)</a></li>
                    </ul>
                </div>
            </li>
            @endcan
            @canany(['ادخال أقساط','ادخال حوافظ'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#account-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-coins" aria-hidden="true"></i>&nbsp اقساط</button>
                <div class="collapse" id="account-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('kst.input')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">قسط مصرفي</a></li>
                        <li><a href="{{route('kst2.input')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">قسط مصرفي 2</a></li>
                        <li><a href="{{route('haf.input')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">حافظة </a></li>

                    </ul>
                </div>
            </li>
            @endcanany
            @can('ادخال فائض وترجيع')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#over-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-chart-line" aria-hidden="true"></i>&nbsp فائض وترجيع</button>
                <div class="collapse" id="over-collapse">

                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                        <li><a href="{{route('over.input','over')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">خصم بالفائض</a></li>
                        <li><a href="{{route('over.input','over_a')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">خصم بالفائض من الأرشيف</a></li>
                        <li><a href="{{route('over.input','wrong')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مبلغ وارد بالخطأ</a></li>
                        <li><a href="{{route('over.input','tar_list')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ترجيع مبالغ من الفائض او الخطأ</a></li>
                        <li><a href="{{route('over.input','tar_maksoom')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ترجع مبلغ مخصوم من عقد</a></li>
                        <li><a href="{{route('over.input','stop_kst')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ايقاف خصم</a></li>
                        <li><a href="{{route('stopkst2')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ايقاف خصم بدون عقد</a></li>

                    </ul>
                </div>
            </li>
            @endcan
            @can('مصارف')
                <li class="mb-1">
                    <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#other-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-chart-line" aria-hidden="true"></i>&nbsp زبائن مصارف ...</button>
                    <div class="collapse" id="other-collapse">

                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">

                            <li><a href="{{route('banksinput','bank')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مصارف</a></li>
                            <li><a href="{{route('banksinput','taj')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مصارف تجميعية</a></li>
                            <li><a href="{{route('banksinput','bankratio')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">احتساب عمولة مصرف</a></li>
                            <li><a href="{{route('inpcust',1)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">زبائن</a></li>
                            <li><a href="{{route('inpcust',2)}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">موردين</a></li>

                        </ul>
                    </div>
                </li>
            @endcan

            <li class="border-top my-3"></li>


            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repokod-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير عقود</button>
                <div class="collapse" id="repokod-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @canany(['عقود','استفسار عقود فقط'])
                            <li><a href="{{route('repmain.all')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن عقد</a></li>
                            <li><a href="{{route('repmain.arc')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن عقد من الأرشيف</a></li>
                            @if($company=='Daibany')
                            <li><a href="{{route('repmain.arc2')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن عقد من أرشيف الأرشيف</a></li>
                            @endif
                            <li><a href="{{route('repmainall')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">جميع العقود لزبون</a></li>
                            <li><a href="{{route('repmain.del')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن عقد ملغي</a></li>
                        @endcanany
                        @can('عقود')
                            <li><a href="{{route('rep.okod','mosdada')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">العقود المسددة</a></li>
                            <li><a href="{{route('rep.okod','kamla')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">العقود الخاملة</a></li>
                            <li><a href="{{route('rep.okod','before')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تجهيز كشف المصرف</a></li>
                            <li><a href="{{route('rep.okod','aksatgeted')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الاقساط المحصلة والغير محصلة</a></li>
                            <li><a href="{{route('rep.okod','kstgeted')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">إجمالي الاقساط المحصلة</a></li>
                            <li><a href="{{route('rep.okod','over')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">خصم بالفائض</a></li>
                            <li><a href="{{route('rep.okod','tar')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ترجيع أقساط</a></li>
                            <li><a href="{{route('rep.okod','wrong')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اقساط واردة بالخظأ</a></li>
                            <li><a href="{{route('rep.okod','stop')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">إيقاف الخصم</a></li>
                            <li><a href="{{route('rep.okod','haf')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">حوافظ</a></li>
                            <li><a href="{{route('rep.okod','aksatdeffer')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اقساط غير متطابقة</a></li>
                        @endcan
                    </ul>
                </div>
            </li>

            @can('مصارف')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repbank-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-school" aria-hidden="true"></i>&nbsp تقارير مصارف</button>
                <div class="collapse" id="repbank-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                       <li><a href="{{route('rep.okod','banksum')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اجمالي المصارف</a></li>
                        <li><a href="{{route('rep.okod','placesum')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اجمالي الفروع</a></li>
                        <li><a href="{{route('rep.okod','ratiosum')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اجمالي الفروع بالعمولات</a></li>
                       <li><a href="{{route('rep.okod','bankone')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">كشف تقصيلي بالمصرف</a></li>
                       <li><a href="{{route('banksinput','repbankratio')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0"> عمولات المصارف</a></li>
                        <li><a href="{{route('rep.okod','bankkstcount')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">عدد الأقساط المتبقية</a></li>
                        <li><a href="{{route('rep.okod','kaema')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">العقود القائمة بالمصارف</a></li>
                        <li><a href="{{route('rep.okod','mahjoza')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الأقساط المحجوزة</a></li>
                    </ul>
                </div>
            </li>
            @endcan
            @can('المخزون')
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repmak-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير مخزون</button>
                <div class="collapse" id="repmak-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        <li><a href="{{route('repamma','mak')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن المخزون</a></li>
                        <li><a href="{{route('repamma','RepStoresTrans')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الحركة اليومية للمخزون</a></li>
                        <li><a href="{{route('repamma','RepPer')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن اذن صرف</a></li>
                        <li><a href="{{route('repamma','itemrep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن صنف</a></li>
                        <li><a href="{{route('repamma','RepItemTran')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن حركة صنف</a></li>
                        <li><a href="{{route('repamma','RepItemStoresTran')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0"> تقرير عن حركة  المخزون لصنف</a></li>
                        <li><a href="{{route('repamma','RepItemKsmTran')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0"> تقرير عن حركة  الأقساط لصنف</a></li>

                    </ul>
                </div>
            </li>
            @endcan
            @canany(['اليومية','المصروفات','فاتورة مبيعات','فاتورة مشتريات','العملاء','الايصالات'])
            <li class="mb-1">
                <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repamma-collapse" aria-expanded="false">
                    &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير عامة</button>
                <div class="collapse" id="repamma-collapse">
                    <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                        @can('اليومية')
                          <li><a href="{{route('repamma','daily')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">الحركة اليومية</a></li>
                          <li><a href="{{route('repamma','RepKlasa')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">خلاصة الحركة اليومية</a></li>
                        @endcan
                        @can('فاتورة مبيعات')
                        <li><a href="{{route('order_sell.rep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مبيعات</a></li>
                            @endcan
                        @if($company=='Daibany')
                            @can('فاتورة مبيعات')
                                <li><a href="{{route('order_sell_arc.rep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مبيعات من الارشيف</a></li>
                            @endcan
                        @endif

                       @can('فاتورة مشتريات')
                       <li><a href="{{route('order_buy.rep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">فاتورة مشتريات</a></li>
                       @endcan
                       @can('العملاء')
                    <!--   <li><a href="{{route('customer.all')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">عرض الزبائن</a></li> -->
                       <li><a href="{{route('repamma','jehatran')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">حركة زبون</a></li>
                     @if($company!='Daibany')  <li><a href="{{route('repamma','RepCustomers')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن الزبائن</a></li>
                     @endif
                       @endcan
                       @can('الايصالات')
                       <li><a href="{{route('repamma','RepTrans')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن ايصالات القبض والدفع</a></li>
                            @endcan
                       @can('المصروفات')
                       <li><a href="{{route('repamma','RepMas')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن المصروفات</a></li>
                            @endcan
                    </ul>
                </div>
            </li>
            @endcanany

                @canany(['سحب من المرتب','خصم واضافة وسحب','ادخال مرتبات','اعداد مرتبات'])
                <li class="mb-1">
                    <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#salary-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp مرتبات</button>
                    <div class="collapse" id="salary-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            @can('سحب من المرتب')
                                <li><a href="{{route('salarysaheb')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">سحب من المرتب</a></li>
                            @endcan

                            @can('ادخال مرتبات')
                                <li><a href="{{route('idrajsalary')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">ادراج مرتبات</a></li>
                            @endcan
                            @can('خصم واضافة وسحب')
                                <li><a href="{{route('salarytrans')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اضافات وخصومات للمرتبات</a></li>
                            @endcan

                            @can('تقارير مرتبات')
                                    <li><a href="{{route('repsaltot')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير اجمالي المرتبات مع التفاصيل</a></li>
                                    <li><a href="{{route('repsalary')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير مرتبات عن شهر معين</a></li>

                                    <li><a href="{{route('repsaltran')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير حركة مرتب</a></li>
                                @endcan

                            @can('اعداد مرتبات')
                                <li><a href="{{route('inpsalary')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">اعداد مرتبات</a></li>
                            @endcan

                        </ul>
                    </div>
                </li>
                @endcanany

                @can('تقارير الموردين')
                <li class="mb-1">
                    <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#repmali-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp تقارير مالية</button>
                    <div class="collapse" id="repmali-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            @can('تقارير الموردين')
                            <li><a href="{{route('repamma','RepMordeen')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقرير عن الموردين</a></li>
                            @endcan
                            @role('admin')
                            <li><a href="{{route('repamma','RepMali')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">التقرير المالي</a></li>
                            @endrole

                        </ul>
                    </div>
                </li>
                @endcan

                @role('admin')
                <li class="mb-1">
                    <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#manager-collapse" aria-expanded="false">
                        &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp صلاحيات و مراقبة</button>
                    <div class="collapse" id="manager-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                            <li><a href="{{route('manager')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">منح الصلاحيات والمستخدمين</a></li>
                            <li><a href="{{route('oper')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مراقبة عمليات التعديل والالغاء</a></li>

                        </ul>
                    </div>
                </li>
                @else
                    @can('مراقبة التعديل')
                    <li class="mb-1">
                        <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#manager-collapse" aria-expanded="false">
                            &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp مراقبة</button>
                        <div class="collapse" id="manager-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <li><a href="{{route('oper')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">مراقبة عمليات التعديل والالغاء</a></li>
                            </ul>
                        </div>
                    </li>
                    @endcan

                @endrole
                    @if(\Illuminate\Support\Facades\Auth::user()->id==1)
                        <li class="mb-1">
                            <button class="font-size-14 btn btn-toggle d-inline-flex align-items-center rounded border-0 collapsed" data-bs-toggle="collapse" data-bs-target="#Cus-collapse" aria-expanded="false">
                                &nbsp <i class="fa  fas fa-list-ul" aria-hidden="true"></i>&nbsp شئون الشركات</button>
                            <div class="collapse" id="Cus-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                    <li><a href="{{route('custransinp')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">استلام مبالغ</a></li>
                                    <li><a href="{{route('custransrep')}}" class="link-dark d-inline-flex text-decoration-none rounded font-size-14 h4 my-0 py-0">تقارير</a></li>
                                </ul>
                            </div>
                        </li>
                    @endif

        </ul>
    </div>
