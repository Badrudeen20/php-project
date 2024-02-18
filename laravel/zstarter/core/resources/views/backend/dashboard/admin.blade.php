@php
    $statistics_1 = [
    [ 'a' => route('panel.orders.index'),'name'=>'Total Orders','bg_color'=>'bg-primary', "count"=>App\Models\Order::count(),
    "icon"=>"<i class='ik ik-shopping-cart'></i>" ,'col'=>'3', 'color'=> 'primary'],

    [ 'a' => route('panel.users.index','?role=User'),'name'=>'Total Users','bg_color'=>'bg-success', "count"=>App\User::count(),
    "icon"=>"<i class='ik ik-user'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.constant_management.article.index'),'name'=>'Total Article', 'bg_color'=>'bg-warning',"count"=>fetchAll('App\Models\Article')->count(), "icon"=>"<i
        class='ik ik-file f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.constant_management.user_enquiry.index'),'name'=>'Total Enquiry','bg_color'=>'bg-danger', "count"=>App\Models\UserEnquiry::count(), "icon"=>"<i
        class='ik ik-edit f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'red'],
    ];

    $statistics_2 = [
    [ 'a' => route('panel.orders.index'),'name'=>'Total --','text-color'=>'primary', "count"=>App\Models\Order::count(),
    "icon"=>"<i class='ik ik-shopping-cart f-24'></i>" ,'col'=>'3', 'color'=> 'primary'],

    [ 'a' => route('panel.users.index','?role=User'),'name'=>'Total --','text-color'=>'success', "count"=>App\User::count(),
    "icon"=>"<i class='ik ik-user f-24'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.constant_management.article.index'),'name'=>'Total --', 'text-color'=>'warning',"count"=>fetchAll('App\Models\Article')->count(), "icon"=>"<i
        class='ik ik-file f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'primary'],
    [ 'a' => route('panel.constant_management.user_enquiry.index'),'name'=>'Total --','text-color'=>'danger', "count"=>App\Models\UserEnquiry::count(), "icon"=>"<i
        class='ik ik-edit f-24 text-mute'></i>" ,'col'=>'3', 'color'=> 'red'],
    ];
  
@endphp

<div class="row clearfix">
    @foreach ($statistics_1 as $item_1)
        <a class="col-lg-3 col-md-6 col-sm-12" href="{{ $item_1['a'] }}">
            <div class="widget {{ $item_1['bg_color'] }}">
                <div class="widget-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="state">
                            <h6>{{ $item_1['name'] }}</h6>
                            <h2>{{ $item_1['count'] }}</h2>
                        </div>  
                        <div class="icon">
                            {!! $item_1['icon'] !!}
                        </div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    
</div>

<div class="row pp-main mb-4">
    @foreach ($statistics_2 as $item_2)
        <div class="col-xl-3 col-md-6">
            <a href="" class="card card-body">
                <div class="pp-cont">
                    <div class="row align-items-center mb-20">
                        <div class="col-auto">
                            {!! $item_2['icon'] !!}
                        </div>
                        <div class="col text-right">
                            <h2 class="mb-0 text-{{ $item_2['text-color'] }}">{{ $item_2['count'] }}</h2>
                        </div>
                    </div>
                    <div class="row align-items-center mb-15">
                        <div class="col-auto">
                            <p class="mb-0">{{ $item_2['name'] }}</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
  
@push('script')
@endpush
