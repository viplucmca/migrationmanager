@extends('layouts.admin_client_detail')
@section('title', 'Client Receipt List')

@section('styles')
<style>
    /* Modern Card Design */
    .card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
        margin: 20px 0;
        border: none;
        width: 100%;
    }

    .card-header {
        background: #fff;
        padding: 20px 30px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px 12px 0 0;
    }

    .card-header h4 {
        font-size: 1.25rem;
        color: #2d3748;
        font-weight: 600;
        margin: 0;
    }

    .card-body {
        padding: 30px;
        background: #fff;
        border-radius: 0 0 12px 12px;
    }

    /* Table Styling */
    .table-responsive {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 0 1px #f0f0f0;
    }

    .table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        font-size: 0.875rem;
        margin: 0;
    }

    .table thead th {
        background: #f8fafc;
        color: #4a5568 !important;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 16px;
        border-bottom: 2px solid #edf2f7;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 16px;
        border-bottom: 1px solid #edf2f7;
        color: #4a5568 !important;
        vertical-align: middle;
        transition: all 0.2s;
    }

    .table tbody tr:hover td {
        background-color: #f8fafc;
    }

    .table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Checkbox Styling */
    .custom-checkbox .custom-control-input:checked ~ .custom-control-label::before {
        background-color: #4299e1;
        border-color: #4299e1;
    }

    .custom-control-label::before {
        border-radius: 4px;
        border: 2px solid #cbd5e0;
    }

    /* Button Styling */
    .btn-primary.Validate_Receipt {
        background: #4299e1;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
        color: white;
    }

    .btn-primary.Validate_Receipt:hover {
        background: #3182ce;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px rgba(66, 153, 225, 0.1);
    }

    .btn-primary.Validate_Receipt i {
        font-size: 0.875rem;
    }

    /* Status Indicators */
    .text-success, .text-danger {
        font-weight: 500;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.875rem;
    }

    .text-success {
        background-color: #c6f6d5;
        color: #2f855a !important;
    }

    .text-danger {
        background-color: #fed7d7;
        color: #c53030 !important;
    }

    /* Pagination Styling */
    .card-footer {
        background: transparent;
        border-top: none;
        padding: 1rem 1.5rem;
    }

    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        justify-content: center;
    }

    .pagination li {
        margin: 0 3px;
    }

    .pagination li a,
    .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 32px;
        height: 32px;
        padding: 0 6px;
        font-size: 14px;
        color: #666;
        background: #fff;
        border: 1px solid #dee2e6;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.2s;
    }

    .pagination li.active span {
        background-color: #007bff;
        border-color: #007bff;
        color: #fff;
    }

    .pagination li.disabled span {
        color: #ccc;
        background-color: #fff;
        border-color: #dee2e6;
        cursor: not-allowed;
    }

    .pagination li a:hover:not(.disabled) {
        background-color: #e9ecef;
        border-color: #dee2e6;
        color: #0056b3;
        text-decoration: none;
    }

    /* Next/Previous buttons */
    .pagination li:first-child,
    .pagination li:last-child {
        margin: 0 5px;
    }

    .pagination li:first-child a,
    .pagination li:last-child a {
        padding: 0;
        font-size: 14px;
        color: #666;
    }

    .pagination li:first-child a:hover,
    .pagination li:last-child a:hover {
        color: #0056b3;
    }

    /* Text showing current range */
    .showing-text {
        color: #666;
        font-size: 14px;
        margin-bottom: 15px;
    }

    @media (max-width: 576px) {
        .pagination li a,
        .pagination li span {
            min-width: 30px;
            height: 30px;
            font-size: 13px;
        }

        .pagination li:first-child,
        .pagination li:last-child {
            margin: 0 3px;
        }
    }

    /* Column width adjustments */
    .table th:nth-child(1) { width: 4%; }
    .table th:nth-child(2) { width: 8%; }
    .table th:nth-child(3) { width: 10%; }
    .table th:nth-child(4) { width: 18%; }
    .table th:nth-child(5) { width: 10%; }
    .table th:nth-child(6) { width: 10%; }
    .table th:nth-child(7) { width: 8%; }
    .table th:nth-child(8) { width: 12%; }
    .table th:nth-child(9) { width: 8%; }
    .table th:nth-child(10) { width: 6%; }
    .table th:nth-child(11) { width: 6%; }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #718096;
    }

    /* Responsive Design */
    @media (max-width: 1200px) {
        .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .btn-primary.Validate_Receipt {
            width: 100%;
            justify-content: center;
        }
    }

    /* Loading State */
    .table tbody tr {
        transition: opacity 0.3s;
    }

    .table tbody tr.loading {
        opacity: 0.5;
    }

    /* Tooltip */
    [data-tooltip] {
        position: relative;
        cursor: help;
    }

    [data-tooltip]:before {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        padding: 4px 8px;
        background: #2d3748;
        color: white;
        font-size: 12px;
        border-radius: 4px;
        white-space: nowrap;
        opacity: 0;
        visibility: hidden;
        transition: all 0.2s;
    }

    [data-tooltip]:hover:before {
        opacity: 1;
        visibility: visible;
    }

    /* Validation Message Styling */
    .custom-error-msg {
        padding: 15px 20px;
        margin: 0;
        display: none;
    }

    .custom-error-msg.alert {
        display: block;
        border-radius: 4px;
        font-size: 14px;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .custom-error-msg.alert-success {
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        color: #155724;
    }

    .custom-error-msg.alert-danger {
        background-color: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .custom-error-msg.alert-warning {
        background-color: #fff3cd;
        border: 1px solid #ffeeba;
        color: #856404;
    }

    .custom-error-msg.alert-info {
        background-color: #d1ecf1;
        border: 1px solid #bee5eb;
        color: #0c5460;
    }

    /* Flash Message Styling */
    .alert {
        padding: 15px 20px;
        margin-bottom: 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-size: 14px;
        line-height: 1.5;
    }

    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }

    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeeba;
        color: #856404;
    }

    .alert-info {
        background-color: #d1ecf1;
        border-color: #bee5eb;
        color: #0c5460;
    }

    /* Close button for alerts */
    .alert .close {
        float: right;
        font-size: 20px;
        font-weight: bold;
        line-height: 1;
        color: #000;
        text-shadow: 0 1px 0 #fff;
        opacity: 0.2;
        background: transparent;
        border: 0;
        padding: 0;
        cursor: pointer;
    }

    .alert .close:hover {
        opacity: 0.5;
    }

    /* Animation for alerts */
    .alert {
        animation: fadeIn 0.3s ease-in;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Filter Panel Styling */
    .filter_panel {
        margin-bottom: 30px;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        display: none;
    }

    .filter_panel h4 {
        color: #4a5568 !important;
        font-size: 1.1rem;
        margin-bottom: 20px;
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div class="main-content">
    <section class="section" style="padding-top: 40px;">
        <div class="section-body">
            @include('../Elements/flash-message')

            <div class="card">
                <div class="custom-error-msg">
                </div>
                <div class="card-header">
                    <h4 style="color: #4a5568 !important;">All Clients Receipt List</h4>

                    <div class="d-flex align-items-center">
                        <a href="javascript:;" style="background: #394eea;color: white;"  class="btn btn-theme btn-theme-sm filter_btn mr-2"><i class="fas fa-filter"></i> Filter</a>
                    </div>

                    @if (Auth::user()->role == '1' && Auth::user()->email == 'celestyparmar.62@gmail.com')
                        <button class="btn btn-danger Delete_Receipt" style="margin-right: -270px;">
                            <i class="fas fa-trash-alt"></i>
                            Delete Receipt
                        </button>
                     @endif

                    <button class="btn btn-primary Validate_Receipt" style="background-color: #394eea !important;">
                        <i class="fas fa-check-circle"></i>
                        Validate Receipt
                    </button>
                </div>

                <div class="card-body">
                    <div class="filter_panel">
                        <h4>Search By Details</h4>
                        <form action="{{URL::to('/admin/clients/clientreceiptlist')}}" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="client_id" class="col-form-label" style="color:#4a5568 !important;">Client ID</label>
                                        <select name="client_id" id="client_id" class="form-control">
                                            <option value="">Select Client</option>
                                            @foreach($clientIds as $client)
                                                <option value="{{ $client->client_id }}" {{ request('client_id') == $client->client_id ? 'selected' : '' }}>
                                                    {{ $client->first_name.' '.$client->last_name.'('.$client->client_unique_id.')' }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="client_matter_id" class="col-form-label" style="color:#4a5568 !important;">Client Matter ID</label>
                                        <select name="client_matter_id" id="client_matter_id" class="form-control">
                                            <option value="">Select Matter</option>
                                            @foreach($matterIds as $matter)
                                                <option value="{{ $matter->client_matter_id }}" {{ request('client_matter_id') == $matter->client_matter_id ? 'selected' : '' }}>
                                                    {{ $matter->client_unique_id }}-{{ $matter->client_unique_matter_no }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="trans_date" class="col-form-label" style="color:#000;">Date</label>
                                        <input type="text" name="trans_date" value="{{ old('trans_date', Request::get('trans_date')) }}" class="form-control" data-valid="" autocomplete="off" placeholder="Date" id="trans_date">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="client_fund_ledger_type" class="col-form-label" style="color:#000;">Type</label>
                                        <select class="form-control" name="client_fund_ledger_type">
                                            <option value="">Select</option>
                                            <option value="Deposit" {{ request('client_fund_ledger_type') == 'Deposit' ? 'selected' : '' }}>Deposit</option>
                                            <option value="Fee Transfer" {{ request('client_fund_ledger_type') == 'Fee Transfer' ? 'selected' : '' }}>Fee Transfer</option>
                                            <option value="Disbursement" {{ request('client_fund_ledger_type') == 'Disbursement' ? 'selected' : '' }}>Disbursement</option>
                                            <option value="Refund" {{ request('client_fund_ledger_type') == 'Refund' ? 'selected' : '' }}>Refund</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-theme-lg">Search</button>
                                    <a class="btn btn-info" href="{{URL::to('/admin/clients/clientreceiptlist')}}">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <div class="custom-checkbox custom-control">
                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                            <label for="checkbox-all" class="custom-control-label"></label>
                                        </div>
                                    </th>
                                    <!--<th>SNo.</th>-->
                                    <th>Client ID</th>
                                    <th>Client Matter</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <!--<th>Entry Date</th>-->
                                    <th>Type</th>
                                    <th>Reference</th>

                                    <th>Funds In (+)</th>
                                    <th>Funds Out (-)</th>
                                    <th>Receipt Validate</th>
                                    <th>Validated By</th>
                                </tr>
                            </thead>
                            <tbody class="tdata">
                                @if(@$totalData !== 0)
                                    @foreach (@$lists as $list)
                                        <?php
                                        $client_info = \App\Admin::select('id','first_name','last_name','client_id')->where('id', $list->client_id)->first();
                                        $client_full_name = $client_info ? $client_info->first_name.' '.$client_info->last_name : '-';
                                        $client_id_display = $client_info ? $client_info->client_id : '-';

                                        $client_matter_info = \App\ClientMatter::select('client_unique_matter_no')->where('id', $list->client_matter_id)->first();
                                        $client_matter_display = $client_matter_info ? $client_id_display.'-'.$client_matter_info->client_unique_matter_no : '-';


                                        $id = $list->id ?? '-';
                                        $trans_date = $list->trans_date ?? '-';
                                        //$entry_date = $list->entry_date ?? '-';
                                        $Reference = $list->trans_no ?? '-';
                                        $client_fund_ledger_type = $list->client_fund_ledger_type ?? '-';
                                        $invoice_no = !empty($list->invoice_no) ? '('.$list->invoice_no.')' : '';
                                        $total_fund_in_amount = $list->deposit_amount ?? '-';
                                        $total_fund_out_amount = $list->withdraw_amount ?? '-';
                                        $receipt_validate = ($list->validate_receipt == 1) ? 'Yes' : 'No';

                                        if(isset($list->voided_or_validated_by) && $list->voided_or_validated_by != ""){
                                            $validate_by = \App\Admin::select('id','first_name','last_name','user_id')->where('id', $list->voided_or_validated_by)->first();
                                            $validate_by_full_name = $validate_by->first_name.' '.$validate_by->last_name;
                                        } else {
                                            $validate_by_full_name = "-";
                                        }
                                        ?>
                                        <tr id="id_{{@$list->id}}">
                                            <td class="text-center">
                                                <div class="custom-checkbox custom-control">
                                                    <input data-id="{{@$list->id}}"
                                                           data-email="{{@$list->email ?? ''}}"
                                                           data-name="{{$client_full_name}}"
                                                           data-clientid="{{$client_id_display}}"
                                                           data-receiptid="{{@$list->receipt_id}}"
                                                           type="checkbox"
                                                           data-checkboxes="mygroup"
                                                           class="cb-element custom-control-input your-checkbox"
                                                           id="checkbox-{{$loop->index}}">
                                                    <label for="checkbox-{{$loop->index}}" class="custom-control-label"></label>
                                                </div>
                                            </td>
                                            <!--<td>{{--$id--}}</td>-->
                                            <td>{{ $client_id_display }}</td>
                                            <td>{{ $client_matter_display }}</td>
                                            <td>{{ $client_full_name }}</td>
                                            <td id="verified_{{@$list->id}}">
                                                <?php
                                                if( $receipt_validate == 'Yes' )
                                                { ?>
                                                <span style="display: inline-flex;">
                                                    <i class="fas fa-check-circle" title="Verified Receipt" style="margin-top: 4px;"></i>
                                                </span>
                                                <?php
                                                } ?>
                                                {{ $trans_date }}
                                            </td>
                                            <td>{{ $client_fund_ledger_type }} {{$invoice_no }}</td>
                                            <td>{{ $Reference }}</td>
                                            <td id="deposit_{{@$list->id}}">{{ is_numeric($total_fund_in_amount) ? '$'.number_format((float)$total_fund_in_amount, 2) : '-' }}</td>
                                            <td id="withdraw_{{@$list->id}}">{{ is_numeric($total_fund_out_amount) ? '$'.number_format((float)$total_fund_out_amount, 2) : '-' }}</td>
                                            <td id="validate_{{@$list->id}}">
                                                <span class="{{ $receipt_validate == 'Yes' ? 'text-success' : 'text-danger' }}">
                                                    {{ $receipt_validate }}
                                                </span>
                                            </td>

                                            <td id="validateby_{{@$list->id}}">{{ $validate_by_full_name }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="11" class="empty-state">
                                            <div>
                                                <i class="fas fa-inbox fa-3x mb-3" style="color: #cbd5e0;"></i>
                                                <p>No records found</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="card-footer">
                    {!! $lists->appends(\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/css/bootstrap-datepicker.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<script>
jQuery(document).ready(function($){
    $('.filter_btn').on('click', function(){
		$('.filter_panel').slideToggle();
	});

    $('#trans_date').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true
    });

    $("[data-checkboxes]").each(function () {
        var me = $(this),
        group = me.data('checkboxes'),
        role = me.data('checkbox-role');

        me.change(function () {
            var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
            checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
            dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
            total = all.length,
            checked_length = checked.length;
            if (role == 'dad') {
                if (me.is(':checked')) {
                    all.prop('checked', true);

                } else {
                    all.prop('checked', false);

                }
            } else {
                if (checked_length >= total) {
                    dad.prop('checked', true);
                    $('.is_checked_client').show();
                    $('.is_checked_clientn').hide();
                } else {
                    dad.prop('checked', false);
                    $('.is_checked_client').hide();
                    $('.is_checked_clientn').show();
                }
            }

        });
    });

    var clickedReceiptIds = [];
    $(document).delegate('.your-checkbox', 'click', function(){
        var clicked_receipt_id = $(this).data('id');
        if ($(this).is(':checked')) {
            //clickedReceiptIds.push(clicked_receipt_id);

            // For deletion, allow only one receipt to be selected
            if ($('.Delete_Receipt').length > 0) {
                $('.your-checkbox').not(this).prop('checked', false);
                clickedReceiptIds = [clicked_receipt_id];
            } else {
                clickedReceiptIds.push(clicked_receipt_id);
            }
        } else {
            var index2 = clickedReceiptIds.indexOf(clicked_receipt_id);
            if (index2 !== -1) {
                clickedReceiptIds.splice(index2, 1);
            }
        }
    });

    //validate receipt
    $(document).delegate('.Validate_Receipt', 'click', function(){
        if ( clickedReceiptIds.length > 0)
        {
            var mergeStr = "Are you sure want to validate these receipt?";
            if (confirm(mergeStr)) {
                $.ajax({
                    type:'post',
                    url:"{{URL::to('/')}}/admin/validate_receipt",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    data: {clickedReceiptIds:clickedReceiptIds,receipt_type:1},
                    success: function(response){
                        var obj = $.parseJSON(response);
                        //location.reload(true);
                        var record_data = obj.record_data;
                        $.each(record_data, function(index, subArray) {
                            //console.log('index=='+index);
                            //console.log('subArray=='+subArray.id);
                            $('#validate_' + subArray.id +' span').removeClass('text-danger').addClass('text-success').text('Yes');
                            if(subArray.first_name != ""){
                                var validateby_full_name = subArray.first_name+" "+subArray.last_name;
                            } else {
                                var validateby_full_name = "-";
                            }
                            $('#validateby_'+subArray.id).text(validateby_full_name);

                            // Add check-circle icon to verified cell
                            $('#verified_' + subArray.id).html(
                                '<span style="display: inline-flex;">' +
                                '<i class="fas fa-check-circle" title="Verified Receipt" style="margin-top: 4px; margin-right: 5px;"></i>' +
                                '</span>' + subArray.trans_date
                            );
                        });
                        $('.custom-error-msg').text(obj.message);
                        $('.custom-error-msg').show();
                        $('.custom-error-msg').addClass('alert alert-success');
                    }
                });
            }
        } else {
            alert('Please select atleast 1 receipt.');
        }
    });

    // Delete receipt by super admin
    $(document).delegate('.Delete_Receipt', 'click', function(){
        if (clickedReceiptIds.length === 0) {
            alert('Please select a receipt to delete.');
            return;
        }
        if (clickedReceiptIds.length > 1) {
            alert('Please select only one receipt to delete.');
            return;
        }
        var mergeStr = "Are you sure want to delete this receipt?";
        if (confirm(mergeStr)) {
            $.ajax({
                type: 'post',
                url: "{{URL::to('/')}}/admin/delete_receipt",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: { receiptId: clickedReceiptIds[0], receipt_type: 1 },
                success: function(response) {
                    var obj = $.parseJSON(response);
                    if (obj.status) {
                        $('#id_' + clickedReceiptIds[0]).remove();
                        clickedReceiptIds = [];
                        $('.custom-error-msg').text(obj.message);
                        $('.custom-error-msg').show();
                        $('.custom-error-msg').addClass('alert alert-success');
                        // Check if table is empty after deletion
                        if ($('.tdata tr').length === 0) {
                            $('.tdata').html('<tr><td colspan="11" class="empty-state"><div><i class="fas fa-inbox fa-3x mb-3" style="color: #cbd5e0;"></i><p>No records found</p></div></td></tr>');
                        }
                    } else {
                        $('.custom-error-msg').text(obj.message);
                        $('.custom-error-msg').show();
                        $('.custom-error-msg').addClass('alert alert-danger');
                    }
                },
                error: function() {
                    $('.custom-error-msg').text('An error occurred while deleting the receipt.');
                    $('.custom-error-msg').show();
                    $('.custom-error-msg').addClass('alert alert-danger');
                }
            });
        }
    });

    $('.cb-element').change(function () {
        if ($('.cb-element:checked').length == $('.cb-element').length){
            $('#checkbox-all').prop('checked',true);
        } else {
            $('#checkbox-all').prop('checked',false);
        }
    });
});
</script>
@endsection
