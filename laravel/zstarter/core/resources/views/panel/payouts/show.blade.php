@extends('backend.layouts.main') 
@section('title', 'Payout')
@section('content')
@php
/**
* Payout 
*
* @category  zStarter
*
* @ref  zCURD
* @author    Defenzelite <hq@defenzelite.com>
* @license  https://www.defenzelite.com Defenzelite Private Limited
* @version  <zStarter: 1.1.0>
* @link        https://www.defenzelite.com
*/
$breadcrumb_arr = [
    ['name'=>'Payouts', 'url'=> route('panel.payouts.index'), 'class' => ''],
    ['name'=>'Show Payout', 'url'=> "javascript:void(0);", 'class' => '']
]
@endphp
    <!-- push external head elements to head -->
    @push('head')
    <link rel="stylesheet" href="{{ asset('backend/plugins/mohithg-switchery/dist/switchery.min.css') }}">
    <style>
        .error{
            color:red;
        }
        .table thead {
            background-color: #fff;
        }
        .table thead th {
            border-bottom: 0px;
        }
    </style>
    @endpush

    <div class="container-fluid">
    	<div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="ik ik-grid bg-blue"></i>
                        <div class="d-inline">
                            <h5>Show Payout: #ORD{{ $payout->id }}</h5>
                            <span>Show Payout Details of #ORD{{ $payout->id }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    @include('backend.include.breadcrumb')
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- start message area-->
               @include('backend.include.message')
                <!-- end message area-->
                <div class="card ">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="mb-0">Show Payout</h3>
                        <span class="badge badge-{{ getPayoutStatus($payout->status)['color'] }}">{{ getPayoutStatus($payout->status)['name'] }}</span>
                    </div>
                    <div class="card-body">
                        <table class="table mb-3">
                            <thead>
                                <tr>
                                    <th>Payout Id</th>
                                    <td>PAYID{{ $payout->id }}</td>
                                </tr>
                                <tr>
                                    <th>User Details</th>
                                    <td>
                                        <ul>
                                            <li>Name :{{ NameById($payout->user_id) ?? '--' }}</li>
                                            <li>Email :{{ $user_details['email'] ?? '' }}</li>
                                            <li>Phone :{{ $user_details['phone'] ?? '' }}</li>
                                            <li>Address :{{ $user_details['address'] ?? '' }}</li>
                                        </ul>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>Payout Details</th>
                                    <td>
                                        @if($payout->type == 0)
                                        <span>UPI Details</span>
                                        <ul>
                                            <li>UPI Number : {{ $bank_details['upi_number'] ?? '' }}</li>
                                        </ul>
                                        @else
                                        <span>Bank Details</span>
                                        <ul>
                                            <li>Bank Name : {{ $bank_details['bank_name'] ?? '' }}</li>
                                            <li>Bank Account Number : {{ $bank_details['bank_account_number'] ?? '' }}</li>
                                            <li>IFSC Code : {{$bank_details['ifsc_code'] ?? ''}}</li>
                                            <li>Account Holder Name : {{$bank_details['acc_holder_name'] ?? ''}}</li>
                                            <li>Remark : {{$bank_details['remark'] ?? ''}}</li>
                                        </ul>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>{{ format_price($payout->amount) }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ getFormattedDate($payout->created_at) }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ getFormattedDate($payout->updated_at) }}</td>
                                </tr>
                            </thead>
                        </table>
                        <hr>
                            <form action="{{ route('panel.payouts.status',[$payout->id]) }}" method="post" class="mt-4">
                                @csrf
                                <div class="form-radio">
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio"  class="updateStatusBtn" name="status" value="1" @if($payout->status == 1) checked @endif>
                                            <i class="helper"></i>Accept
                                        </label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <label>
                                            <input type="radio" class="updateStatusBtn" name="status" value="2" @if($payout->status == 2 ) checked @endif>
                                            <i class="helper"></i>Reject
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group d-none txn-wrap mt-2">
                                    <label for="">Transaction Number</label>
                                    <input type="text" class="form-control" placeholder="Enter Transaction Number" name="txn_no" value="">
                                </div>
                                <div class="form-group d-none remark-wrap mt-2">
                                    <label for="">Reason</label>
                                    <input type="text" class="form-control" placeholder="Enter Reason" name="remark" value="">
                                </div>
                                <div class="mt-3 d-flex justify-content-end">
                                    <button @if($payout->status == 1 || $payout->status == 2) disabled @endif class="btn btn-primary" type="submit">Update Status</button>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   


  
    <!-- push external js -->
    @push('script')
  
    <script>
        $(document).ready(function(){
                @if($payout->status == 1 || $payout->status == 2)
                    $(".updateStatusBtn").prop("disabled",true);
                @endif
                $('.transactionCreate').on('click',function(){
                    var status = $(this).data('status');
                    $('#status').val(status);
                    $('#transactionCreate').modal('show');
                });
                $('.updateStatusBtn').on('click',function(){    
                   if($(this).val() == 1){
                    $('.txn-wrap').removeClass('d-none');
                    $('.remark-wrap').addClass('d-none');
                }else{
                    $('.remark-wrap').removeClass('d-none');
                    $('.txn-wrap').addClass('d-none');
                   }
                });

               
            });
    </script>
    @endpush
@endsection
