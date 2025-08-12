@extends('layouts.admin')
@section('title', 'Journal Receipt List')

@section('content')
<style>
.ag-space-between {
    justify-content: space-between;
}
.ag-align-center {
    align-items: center;
}
.ag-flex {
    display: flex;
}
.ag-align-start {
    align-items: flex-start;
}
.ag-flex-column {
    flex-direction: column;
}
.col-hr-1 {
    margin-right: 5px!important;
}
.text-semi-bold {
    font-weight: 600!important;
}
.small, small {
    font-size: 85%;
}
.ag-align-end {
    align-items: flex-end;
}

.ui.yellow.label, .ui.yellow.labels .label {
    background-color: #fbbd08!important;
    border-color: #fbbd08!important;
    color: #fff!important;
}
.ui.label:last-child {
    margin-right: 0;
}
.ui.label:first-child {
    margin-left: 0;
}
.field .ui.label {
    padding-left: 0.78571429em;
    padding-right: 0.78571429em;
}

.ag-list__title{background-color: #fcfcfc;border: 1px solid #f2f2f2;padding: 0.8rem 1.2rem;}
.ag-list__item{font-size: 12px;margin: 0;padding: 0.8rem 2.6rem;}
.filter_panel {background: #f7f7f7;margin-bottom: 10px;border: 1pxsolid #eee;display: none;}
.card .card-body .filter_panel { padding: 20px;}
.strike-through {text-decoration: line-through;}
</style>
<!-- Main Content -->
<div class="main-content">
	<section class="section">
		<div class="section-body">
			<div class="server-error">
				@include('../Elements/flash-message')
			</div>
			<div class="custom-error-msg">
			</div>
			<div class="row">

				<div class="col-12 col-md-12 col-lg-12">
					<div class="card">
						<div class="card-header">
							<h4>All Journal Receipt List</h4>
							<div class="card-header-action">
                                <ul class="nav nav-pills" id="client_tabs" role="tablist">
                                    <li class="nav-item Validate_Receipt" style="display:bock;">
                                        <a class="btn btn-primary" href="javascript:;">Validate Receipt</a>
                                    </li>
                                </ul>
                            </div>
						</div>
						<div class="card-body">
                                <div class="tab-pane fade show active" id="clients" role="tabpanel" aria-labelledby="clients-tab">
									<div class="table-responsive common_table client_table_data">
										<table class="table text_wrap">
											<thead>
												<tr>
                                                    <th class="text-center" style="width:30px;">
                                                        <div class="custom-checkbox custom-checkbox-table custom-control">
                                                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                                                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </th>
                                                    <th>Receipt Id</th>
													<th>Client Id</th>
                                                    <th>Name</th>
                                                    <th>Trans. Date</th>
                                                    <th>Entry Date</th>
                                                    <th>Trans. No</th>
                                                    <th>Invoice No</th>
                                                    <th>Amount</th>
                                                    <th>Receipt Validate</th>
													<th>Validate By</th> <!-- New field -->
                                                </tr>
											</thead>

											<tbody class="tdata">
												@if(@$totalData !== 0)
													<?php $i=0; ?>

												@foreach (@$lists as $list)
                                                <?php
                                                $client_info = \App\Admin::select('id','first_name','last_name','client_id')->where('id', $list->client_id)->first();
                                                if(isset($list->voided_or_validated_by) && $list->voided_or_validated_by != ""){
                                                    $validate_by = \App\Admin::select('id','first_name','last_name','user_id')->where('id', $list->user_id)->first();
                                                    $validate_by_full_name = $validate_by->first_name.' '.$validate_by->last_name;
                                                } else {
                                                    $validate_by_full_name = "-";
                                                }?>
                                                <tr id="id_{{@$list->id}}">
                                                    <td style="white-space: initial;" class="text-center">
                                                        <div class="custom-checkbox custom-control">
                                                            <input data-id="{{@$list->id}}" data-receiptid="{{@$list->receipt_id}}" data-email="{{@$list->email}}" data-name="{{@$list->first_name}} {{@$list->last_name}}" data-clientid="{{@$list->client_id}}" type="checkbox" data-checkboxes="mygroup" class="cb-element custom-control-input  your-checkbox" id="checkbox-{{$i}}">
                                                            <label for="checkbox-{{$i}}" class="custom-control-label">&nbsp;</label>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $list->receipt_id;?></td>
													<td><?php echo $client_info->client_id;?></td>
                                                    <td><?php echo $client_info->first_name.' '.$client_info->last_name;?></td>
                                                    <td><?php echo $list->trans_date;?></td>
                                                    <td><?php echo $list->entry_date;?></td>
                                                    <td><?php echo $list->trans_no;?></td>
                                                    <td><?php echo $list->invoice_no;?></td>
                                                    <td id="deposit_{{@$list->id}}"><?php echo "$".$list->total_withdrawal_amount;?></td>
                                                    <?php
                                                    if($list->validate_receipt == 1) {
                                                        $color = "color:blue;";
                                                    } else {
                                                        $color = "color:red;";
                                                    }
                                                    ?>
                                                    <td id="validate_{{@$list->id}}" style="font-size: 17px; <?php echo $color;?>"><?php if($list->validate_receipt == 1) { echo "Yes";} else { echo "No"; };?></td>
													<td id="validateby_{{@$list->id}}"><?php echo $validate_by_full_name;?></td> <!-- New field data -->
                                                </tr>
												<?php $i++; ?>
												@endforeach
											</tbody>
											@else
											<tbody>
												<tr>
													<td style="text-align:center;" colspan="17">
														No Record found
													</td>
												</tr>
											</tbody>
											@endif
										</table>
									</div>
								</div>

							</div>
						</div>
						<div class="card-footer">
							{!! $lists->appends(\Request::except('page'))->render() !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection
@section('scripts')
<script>
jQuery(document).ready(function($){
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
        var clicked_receipt_id = $(this).data('receiptid');
        if ($(this).is(':checked')) {
            clickedReceiptIds.push(clicked_receipt_id);
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
                    data: {clickedReceiptIds:clickedReceiptIds,receipt_type:4},
                    success: function(response){
                        var obj = $.parseJSON(response);
                        //location.reload(true);
                        var record_data = obj.record_data;
                        $.each(record_data, function(index, subArray) {
                            //console.log('index=='+index);
                            //console.log('subArray=='+subArray.id);
                            $('#validate_'+subArray.id).text("Yes");
                            $('#validate_'+subArray.id).css("color",'blue');
                            if(subArray.first_name != ""){
                                var validateby_full_name = subArray.first_name+" "+subArray.last_name;
                            } else {
                                var validateby_full_name = "-";
                            }
                            $('#validateby_'+subArray.id).text(validateby_full_name);
                        });
                    }
                });
            }
        } else {
            alert('Please select atleast 1 receipt.');
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


