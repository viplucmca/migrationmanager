<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Documents - E-Signature App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 font-sans antialiased">
    <div class="min-h-screen px-4 sm:px-6 lg:px-8 py-12">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Document
                </h1>

            </div>

            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
                <div class="mb-6 p-4 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded-lg">
                    {{ session('error') }}
                </div>
            @endif

            @if (isset($selectedDocument) && $selectedDocument)
                <div class="grid gap-6">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $selectedDocument->file_name }}
                                </h2>
                                <div class="flex items-center space-x-4 text-sm text-gray-600 dark:text-gray-400">
                                    <span>Status:
                                        <span class="font-medium px-2 py-1 rounded-full text-xs
                                            @if($selectedDocument->status === 'draft') bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200
                                            @elseif($selectedDocument->status === 'sent') bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200
                                            @elseif($selectedDocument->status === 'signed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                            @endif">
                                            {{ ucfirst($selectedDocument->status) }}
                                        </span>
                                    </span>
                                    <span>Uploaded: {{ $selectedDocument->created_at->format('M d, Y H:i') }}</span>
                                </div>
                            </div>
                            @if($selectedDocument->status === 'signed')
                                <a href="{{ route('download.signed', $selectedDocument->id) }}"
                                   class="px-3 py-1 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition">
                                    Download Signed
                                </a>
                            @endif
                        </div>

                        @if($selectedDocument->signers->count() > 0)
                            <div class="mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-3">Signer</h3>
                                <div class="space-y-3">
                                    @foreach($selectedDocument->signers as $signer)
                                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <div class="flex-shrink-0">
                                                    <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                                                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">
                                                            {{ strtoupper(substr($signer->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $signer->name }}</p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $signer->email }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center space-x-3">
                                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                                    @if($signer->status === 'signed') bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200
                                                    @elseif($signer->opened_at) bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200
                                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 @endif">
                                                    {{ $signer->status_display }}
                                                </span>
                                                @if($signer->status === 'pending')
                                                    <form method="POST" action="{{ route('documents.sendReminder', $selectedDocument->id) }}" class="inline">
                                                        @csrf
                                                        <input type="hidden" name="signer_id" value="{{ $signer->id }}">
                                                        <button type="submit"
                                                                class="px-3 py-1 bg-orange-600 text-white text-xs font-medium rounded-md hover:bg-orange-700 transition
                                                                       @if($signer->reminder_count >= 3 || ($signer->last_reminder_sent_at && $signer->last_reminder_sent_at->diffInHours(now()) < 24)) opacity-50 cursor-not-allowed @endif"
                                                                @if($signer->reminder_count >= 3 || ($signer->last_reminder_sent_at && $signer->last_reminder_sent_at->diffInHours(now()) < 24)) disabled @endif>
                                                            Remind ({{ $signer->reminder_count }}/3)
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                        @if($signer->opened_at && $signer->status === 'pending')
                                            <div class="ml-11 text-xs text-yellow-600 dark:text-yellow-400">
                                                Opened on {{ $signer->opened_at->format('M d, Y H:i') }} but not signed yet
                                            </div>
                                        @endif
                                        @if($signer->last_reminder_sent_at)
                                            <div class="ml-11 text-xs text-gray-500 dark:text-gray-400">
                                                Last reminder: {{ $signer->last_reminder_sent_at->format('M d, Y H:i') }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($selectedDocument->status === 'draft')
                            <div class="flex flex-col sm:flex-row gap-4">
                                <?php
                                if( isset($selectedDocument->doc_type) && $selectedDocument->doc_type == 'agreement')
                                { //agreement document ?>
                                    <!--<input type="text" name="client_id" id="client_id" value="{{$selectedDocument->client_id}}">
                                    <input type="text" name="client_matter_id" id="client_matter_id" value="{{$selectedDocument->client_matter_id}}">
                                    <input type="text" name="doc_type" id="doc_type" value="{{$selectedDocument->doc_type}}">-->
                                    <?php
                                    //$client_matter_info_arr = \App\ClientMatter::select('sel_matter_id')->where('id',$selectedDocument->client_matter_id)->first();
                                    ?>
                                    <!--<input type="text" name="sel_matter_id" id="sel_matter_id" value="{{--$client_matter_info_arr->sel_matter_id--}}">-->

                                    <button type="button" class="preview_email w-full sm:w-auto px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">Preview Email</button>
                                <?php
                                }
                                else
                                { //visa and personal document
                                ?>
                                    <form method="POST" action="{{ route('documents.sendSigningLink', $selectedDocument->id) }}" class="w-full sm:w-auto">
                                        @csrf
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <input type="email" name="signer_email" placeholder="Signer Email" class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                            </div>
                                            <div>
                                                <input type="text" name="signer_name" placeholder="Signer Name" class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                            </div>
                                        </div>
                                        <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">Send Signing Link</button>
                                    </form>
                                <?php
                                }?>
                                <a href="{{ route('documents.edit', $selectedDocument->id) }}" class="w-full sm:w-auto px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-900 dark:text-gray-100 font-medium rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 text-center">Edit Signatures</a>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="text-center text-gray-600 dark:text-gray-400">
                    No documents uploaded yet.
                </div>
            @endif
        </div>
    </div>

    <div id="preview_email_modal"  data-backdrop="static" data-keyboard="false" class="modal fade custom_modal" tabindex="-1" role="dialog" aria-labelledby="clientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clientModalLabel">Preview and Send</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?php
                $client_matter_info_arr = \App\ClientMatter::select('sel_matter_id')->where('id',$selectedDocument->client_matter_id)->first();
                ?>
                <div class="modal-body">
                    <form method="POST" action="{{ route('documents.sendSigningLink', $selectedDocument->id) }}" class="w-full sm:w-auto" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="client_id" id="mail_client_id" value="{{$selectedDocument->client_id}}">
                        <input type="hidden" name="client_matter_id" id="mail_client_matter_id" value="{{$selectedDocument->client_matter_id}}">
                        <input type="hidden" name="sel_matter_id" id="mail_sel_matter_id" value="{{$client_matter_info_arr->sel_matter_id}}">
                        <input type="hidden" name="doc_type" id="mail_doc_type" value="{{$selectedDocument->doc_type}}">
                        <?php
                        $cost_assignment_cnt = \App\CostAssignmentForm::where('client_id',$selectedDocument->client_id)->where('client_matter_id',$selectedDocument->client_matter_id)->count();
                        //dd($cost_assignment_cnt);
                        if($cost_assignment_cnt >0) {
                            $matter_info = \App\CostAssignmentForm::where('client_id',$selectedDocument->client_id)->where('client_matter_id',$selectedDocument->client_matter_id)->first();
                            //Get matter name
                            $matter_get = \App\Matter::select('title')->where('id',$client_matter_info_arr->sel_matter_id)->first();
                            if($matter_get){
                                $matter_info->title = $matter_get->title;
                            } else {
                                $matter_info->title = 'NA';
                            }
                        } else {
                            $matter_info = \App\Matter::where('id',$client_matter_info_arr->sel_matter_id)->first();
                        }
                        $mattertotalpayablefeeL = floatval($matter_info->TotalBLOCKFEE) + floatval($matter_info->TotalDoHASurcharges) + floatval($matter_info->additional_fee_1);
                        $mattertotalpayablefee = number_format($mattertotalpayablefeeL, 2, '.', '');
                        ?>
                        <?php

                        $fetchedData = \App\Admin::where('id',$selectedDocument->client_id )->first();
                        ?>
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="email_from">From <span class="span_req">*</span></label>
                                    <select class="form-control" name="email_from" required>
                                        <option value="">Select From</option>
                                        <?php
                                        $emails = \App\Email::select('email')->where('status', 1)->get();
                                        foreach($emails as $nemail){
                                        ?>
                                            <option value="<?php echo $nemail->email; ?>"><?php echo $nemail->email; ?></option>
                                        <?php
                                        }?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="signer_email">Signer Email <span class="span_req">*</span></label>
                                    <input type="email" name="signer_email" value="{{$fetchedData->email}}" placeholder="Signer Email" class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                </div>
                            </div>


                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="signer_email">Signer Name <span class="span_req">*</span></label>
                                    <input type="text" name="signer_name" value="{{$fetchedData->first_name.' '.$fetchedData->last_name}}" placeholder="Signer Name" class="w-full rounded-md border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="template">Select Matter Template <span class="span_req">*</span></label>
                                    <?php
                                    use Illuminate\Support\Str;
                                    $token = Str::random(64);
                                    $pdfurlforsign = url("/sign/{$selectedDocument->id}/{$token}");
                                    ?>
                                    <input type="hidden" name="pdf_sign_token" value="{{$token}}">
                                    <select class="form-control select2 selecttemplate" name="template" data-clientid="{{@$fetchedData->id}}" data-clientfirstname="{{@$fetchedData->first_name}}" data-clientvisaExpiry="{{@$fetchedData->visaExpiry}}" data-clientreference_number="{{@$fetchedData->client_id}}" data-clientassignee_name="{{@$fetchedData->first_name}}" data-mattertotalprofessionalfee="{{@$matter_info->TotalBLOCKFEE}}" data-mattertotaldepartmentfee="{{@$matter_info->additional_fee_1}}" data-mattertotalsurchargefee="{{@$matter_info->TotalDoHASurcharges}}" data-mattertotalpayablefee="{{@$mattertotalpayablefee}}" data-pdfurlforsign="{{@$pdfurlforsign}}" data-mattertitle="{{@$matter_info->title}}" required>
                                        <option value="">Select</option>
                                        @foreach( \App\MatterEmailTemplate::where('matter_id',$client_matter_info_arr->sel_matter_id)->orderBy('id', 'asc')->get() as $list)
                                            <option value="{{$list->id}}">{{$list->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label for="subject">Subject <span class="span_req">*</span></label>
                                    <input type="text" name="subject" id="compose_email_subject" class="form-control selectedsubject" autocomplete="off" placeholder="Enter Subject" value="" required/>
                                    @if ($errors->has('subject'))
                                        <span class="custom-error" role="alert">
                                            <strong>{{ @$errors->first('subject') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label for="message">Message <span class="span_req">*</span></label>
                                    <textarea class="summernote-simple selectedmessage" id="compose_email_message" name="message" required></textarea>
                                    @if ($errors->has('message'))
                                        <span class="custom-error" role="alert">
                                            <strong>{{ @$errors->first('message') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label>Attachment</label>
                                    <input type="file" name="attach[]" class="form-control" multiple>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="table-responsive uploadchecklists">
                                    <table id="mychecklist-datatable" class="table text_wrap table-2">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>File Name</th>
                                                <th>File</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\App\UploadChecklist::where('matter_id', $client_matter_info_arr->sel_matter_id)->get() as $uclist)
                                            <tr>
                                                <td><input type="checkbox" name="checklistfile[]" value="<?php echo $uclist->id; ?>"></td>
                                                <td><?php echo $uclist->name; ?></td>
                                                <td><a target="_blank" href="<?php echo URL::to('/checklists/'.$uclist->file); ?>"><?php echo $uclist->name; ?></a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="col-12 col-md-12 col-lg-12">
                                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition">Send Signing Link</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/summernote-bs4.css')}}">
    <link rel="stylesheet" href="{{asset('css/dataTables_min_latest.css')}}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/summernote-bs4.js')}}"></script>

    <script src="{{asset('js/datatables.min.js')}}"></script>
    <script src="{{asset('js/dataTables.bootstrap4.js')}}"></script>

    <script>
    $(document).ready(function() {
        $('#mychecklist-datatable').dataTable({"searching": true,});
        $(document).delegate('.preview_email', 'click', function(){
            $('#preview_email_modal').modal('show');
        });

        $(document).delegate('.selecttemplate', 'change', function(){
            var client_id = $(this).data('clientid'); //alert(client_id);
            var client_firstname = $(this).data('clientfirstname'); //alert(client_firstname);
            if (client_firstname) {
                client_firstname = client_firstname.charAt(0).toUpperCase() + client_firstname.slice(1);
            }
            var client_reference_number = $(this).data('clientreference_number'); //alert(client_reference_number);
            var company_name = 'Bansal Education Group';
            var visa_valid_upto = $(this).data('clientvisaExpiry');
            if ( visa_valid_upto != '' && visa_valid_upto != '0000-00-00') {
                visa_valid_upto = visa_valid_upto;
            } else {
                visa_valid_upto = '';
            }

            var clientassignee_name = $(this).data('clientassignee_name');
            if ( clientassignee_name != '') {
                clientassignee_name = clientassignee_name;
            } else {
                clientassignee_name = '';
            }

            var mattertitle = $(this).data('mattertitle');
            if ( mattertitle != '') {
                mattertitle = mattertitle;
            } else {
                mattertitle = '';
            }

            var Total_professional_fees = $(this).data('mattertotalprofessionalfee');
            if ( Total_professional_fees != '') {
                Total_professional_fees = Total_professional_fees;
            } else {
                Total_professional_fees = '';
            }

            var Total_surcharge_fees = $(this).data('mattertotalsurchargefee');
            if ( Total_surcharge_fees != '') {
                Total_surcharge_fees = Total_surcharge_fees;
            } else {
                Total_surcharge_fees = '';
            }

            var Total_department_fees = $(this).data('mattertotaldepartmentfee');
            if ( Total_department_fees != '') {
                Total_department_fees = Total_department_fees;
            } else {
                Total_department_fees = '';
            }



            var Total_payable_fees = $(this).data('mattertotalpayablefee');
            if ( Total_payable_fees != '') {
                Total_payable_fees = Total_payable_fees;
            } else {
                Total_payable_fees = '';
            }

            var PDF_url_for_sign = $(this).data('pdfurlforsign');
            if ( PDF_url_for_sign != '') {
                PDF_url_for_sign = PDF_url_for_sign;
            } else {
                PDF_url_for_sign = '';
            }

            var v = $(this).val();
            $.ajax({
                url: '{{URL::to('/admin/get-matter-templates')}}',
                type:'GET',
                datatype:'json',
                data:{id:v},
                success: function(response){
                    var res = JSON.parse(response);

                    var subjct_message = res.subject.replace('{ApplicantGivenNames}', client_firstname).replace('{ClientID}', client_reference_number);
                    $('.selectedsubject').val(subjct_message);
                    $("#preview_email_modal .summernote-simple").summernote('reset');

                    var subjct_description = res.description
                    .replace('{ApplicantGivenNames}', client_firstname)
                    .replace('{Company Name}', company_name)
                    .replace('{Visa Valid Upto}', visa_valid_upto)
                    .replace('{Client Assignee Name}', clientassignee_name)
                    .replace('{ClientID}', client_reference_number)
                    .replace('{Blocktotalfeesincltax}', Total_professional_fees)
                    .replace('{TotalDoHASurcharges}', Total_surcharge_fees)
                    .replace('{TotalEstimatedOthCosts}', Total_department_fees)
                    .replace('{GrandTotalFeesAndCosts}', Total_payable_fees)
                    .replace('{PDF_url_for_sign}', '<a href="' + PDF_url_for_sign + '" target="_blank">'+PDF_url_for_sign+'</a>')
                    .replace('{visa_apply}', mattertitle);

                    $("#preview_email_modal .summernote-simple").summernote('code', subjct_description);
                    $("#preview_email_modal .summernote-simple").val(subjct_description);
                }
            });
        });
    });
    </script>
</body>
</html>
