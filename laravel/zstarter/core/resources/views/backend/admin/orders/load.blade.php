<div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <div>
                <label for="">Show
                    <select name="length" style="width:60px;height:30px;border: 1px solid #eaeaea;" id="length">
                        <option value="10"{{ $orders->perPage() == 10 ? 'selected' : ''}}>10</option>
                        <option value="25"{{ $orders->perPage() == 25 ? 'selected' : ''}}>25</option>
                        <option value="50"{{ $orders->perPage() == 50 ? 'selected' : ''}}>50</option>
                        <option value="100"{{ $orders->perPage() == 100 ? 'selected' : ''}}>100</option>
                    </select>
                    entries
                </label>
            </div>
            <div>
                <button type="button" id="export_button" class="btn btn-success btn-sm">Excel</button>
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Column Visibility</button>
                <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                        <li class="dropdown-item p-0 col-btn" data-val="col_1"><a href="javascript:void(0);"  class="btn btn-sm">User  </a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_2"><a href="javascript:void(0);"  class="btn btn-sm">Txn No</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_3"><a href="javascript:void(0);"  class="btn btn-sm">Discount</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_4"><a href="javascript:void(0);"  class="btn btn-sm">Tax</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_5"><a href="javascript:void(0);"  class="btn btn-sm">Sub Total</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_6"><a href="javascript:void(0);"  class="btn btn-sm">Total</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_7"><a href="javascript:void(0);"  class="btn btn-sm">Status</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_8"><a href="javascript:void(0);"  class="btn btn-sm">Payment Gateway</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_9"><a href="javascript:void(0);"  class="btn btn-sm">Remarks</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_10"><a href="javascript:void(0);"  class="btn btn-sm">From</a></li>                    <li class="dropdown-item p-0 col-btn" data-val="col_11"><a href="javascript:void(0);"  class="btn btn-sm">To</a></li>                                    </ul>
                <a href="javascript:void(0);" id="print" data-url="{{ route('panel.orders.print') }}"  data-rows="{{json_encode($orders) }}" class="btn btn-primary btn-sm">Print</a>
            </div>
            <input type="text" name="search" class="form-control" placeholder="Search" id="search" value="{{request()->get('search') }}" style="width:unset;">
        </div>
        <div class="table-responsive">
            <table id="table" class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th class="no-export">Actions</th>
                        <th  class="no-export">S.No <div class="table-div"><i class="ik ik-arrow-up  asc  " data-val="id"></i><i class="ik ik ik-arrow-down desc" data-val="id"></i></div></th>
                        <th class="col_1">Customer </th>                       
                        <th class="col_2">Txn No</th>
                        <th class="col_2">Items</th>
                        <th class="col_6">Amount</th> 
                        <th class="col_7">Status</th>
                        <th class="col_7">Created At</th>
                    </tr>
                </thead>
                <tbody>
                    @if($orders->count() > 0)
                         @foreach($orders as  $order)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="no-export">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action<i class="ik ik-chevron-right"></i></button>
                                        <ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.orders.show', $order->id) }}" title="Show Order" class="btn btn-sm">Show</a></li>
                                            <li class="dropdown-item p-0"><a href="{{ route('panel.orders.invoice', $order->id) }}" title="Invoice" target="_blank" class="btn btn-sm">Invoice</a></li>
                                        </ul>
                                    </div> 
                                </td>
                                  <td> <a href="{{ route('panel.orders.show', $order->id) }}" class="btn btn-link p-0">{{  getOrderHashCode($order->id) }}</a></td>
                                  <td class="col_1">{{fetchFirst('App\User',$order->user_id,'first_name','--')}}</td>
                                  <td class="col_2">{{$order->txn_no }}</td>
                                  <td>
                                      <ul>
                                          @foreach($order->items as $item)
                                            <li>{{ $item->item_type.": #".$item->item_id }}</li>
                                          @endforeach
                                      </ul>
                                  </td>
                                  <td class="col_6">{{format_price($order->total) }}</td>
                                  <td class="col_7"><div class="badge badge-{{ orderStatus($order->status)['color'] }}">{{orderStatus($order->status)['name'] }}</div></td>
                                  <td>{{ getFormattedDateTime($order->created_at) }}</td>
                            </tr>
                        @endforeach
                    @else 
                        <tr>
                            <td class="text-center" colspan="15">No Data Found...</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between">
        <div class="pagination">
            {{ $orders->appends(request()->except('page'))->links() }}
        </div>
        <div>
           @if($orders->lastPage() > 1)
                <label for="">Jump To: 
                    <select name="page" style="width:60px;height:30px;border: 1px solid #eaeaea;"  id="jumpTo">
                        @for ($i = 1; $i <= $orders->lastPage(); $i++)
                            <option value="{{ $i }}" {{ $orders->currentPage() == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </label>
           @endif
        </div>
    </div>
