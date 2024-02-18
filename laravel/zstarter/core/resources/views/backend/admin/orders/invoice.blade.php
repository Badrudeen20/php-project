@extends('backend.layouts.empty') 
@section('title', 'Invoice')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-12 justify-content-center mx-auto mt-4">
                <div class="card html-content">
                    <div class="card-header"><h3 class="d-block w-100">{{config('app.name')}}<small class="float-right">{{ __('Date: 12/11/2018')}}</small></h3></div>
                    <div class="card-body">
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{{config('app.name')}},</strong><br>
                                    @if($order->from != null)
                                        @php
                                            $from = json_decode($order->from, true);
                                        @endphp
                                    @endif
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ fetchFirst('App\User',$order->user_id,'name') }}</strong><br>
                                    @if($order->to != null)
                                            @php
                                            $to = json_decode($order->to, true);
                                        @endphp
                                    @endif
                                </address>
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>{{ __('Order ID:')}}</b> {{ "INV".getPrefixZeros($order->id)}}<br>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{ __('Item Type')}}</th>
                                            <th>{{ __('Product')}}</th>
                                            <th>{{ __('Qty')}}</th>
                                            <th>{{ __('Price')}}</th>
                                            <th>{{ __('Amount')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td> Product Type (Product, Service, etc) </td>
                                                <td>{{ $item->item_id }} (Product Name or title from table)</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{format_price($item->price) }}</td>
                                                <td>{{ format_price($item->price * $item->qty) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
        
                        <div class="row">
                            <div class="col-6">
                            </div>
                            <div class="col-6">
                                <p class="lead">{{ __('Amount Due ')}} {{ getFormattedDate($order->created_at) }}</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th class="th-50">{{ __('Subtotal')}}:</th>
                                            <td>{{ $order->sub_total}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Tax (9.3%)')}}</th>
                                            <td>{{ $order->tax}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Discount')}}:</th>
                                            <td>- {{  $order->discount}}</td>
                                        </tr>
                                        <tr>
                                            <th>{{ __('Total')}}:</th>
                                            <td>{{$order->total}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row no-print">
                            <div class="col-12">
                                <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> {{ __('Submit Payment')}}</button>
                                <a href="javascript:void(0)" onclick="CreatePDFfromHTML()" title="Download PDF"  class="btn btn-primary pull-right" type="button">Print this page</a>
                                {{-- <a href="javascript:void(0);" title="Download PDF" class="btn btn-primary pull-right" onclick="CreatePDFfromHTML()"><i class="fa fa-download"></i> {{ __('Generate PDF')}}</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script>
        @if ($order->id != null) 
            var invoice_Id = "ZTR{{ $order->id }}";
        @endif

        //Create PDf from HTML...
        function CreatePDFfromHTML() {
            var HTML_Width = $(".html-content").width();
            var HTML_Height = $(".html-content").height();
            var top_left_margin = 15;
            var PDF_Width = HTML_Width + (top_left_margin * 2);
            var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
            var canvas_image_width = HTML_Width;
            var canvas_image_height = HTML_Height;

            var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

            html2canvas($(".html-content")[0], {background :'#FFFFFF',}).then(function (canvas) {
                var imgData = canvas.toDataURL("image/jpeg", 1.0);
                var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
                pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width, canvas_image_height);
                for (var i = 1; i <= totalPDFPages; i++) { 
                    pdf.addPage(PDF_Width, PDF_Height);
                    pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
                }
                pdf.save(invoice_Id);
            });
        }  
    </script>

@endpush

