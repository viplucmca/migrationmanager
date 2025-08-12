<?php
require '../../vendor/autoload.php';

use Hfig\MAPI;
use Hfig\MAPI\OLE\Pear;

// message parsing and file IO are kept separate
$messageFactory = new MAPI\MapiMessageFactory();
$documentFactory = new Pear\DocumentFactory(); 

$ole = $documentFactory->createFromFile('ForSale.msg');
//die('@@@');
$message = $messageFactory->parseMessage($ole);

// raw properties are available from the "properties" member
echo "subject==".$message->properties['subject'], "<br/>";

// some properties have helper methods
echo "Sender==".$message->getSender(), "<br/>";
echo "Body==".$message->getBody(), "<br/>";

// recipients and attachments are composed objects
foreach ($message->getRecipients() as $recipient) {
    // eg "To: John Smith <john.smith@example.com>
    echo sprintf('%s: %s', $recipient->getType(), (string)$recipient), "\n";
}
?>




<div class="tab-content" id="conversationContent">
	<div class="tab-pane fade show active" id="email" role="tabpanel" aria-labelledby="email-tab">
		<div class="row">
			<div class="col-md-12" style="text-align: right;    margin-bottom: 10px;">
				<a class="btn btn-outline-primary btn-sm uploadmail"  href="javascript:;">Upload Mail</a>
			</div>
		</div>
		<ul class="nav nav-pills round_tabs" id="client_mail_tabs" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" id="sent-tab" href="#sent" role="tab" aria-controls="sent" aria-selected="false">Sent</a>
			</li>
			<li class="nav-item">
				<a class="nav-link " data-toggle="tab" id="inbox-tab" href="#inbox" role="tab" aria-controls="inbox" aria-selected="true">Inbox</a>
			</li>
		</ul>

		<div class="tab-content" id="conversationContent">
			<div class="tab-pane fade" id="inbox" role="tabpanel" aria-labelledby="inbox-tab">
			<?php
			$mailreports = \App\MailReport::where('client_id',$fetchedData->id)->where('type','client')->where('mail_type',1)->whereNull('conversion_type')->orderby('created_at', 'DESC')->get();
			foreach($mailreports as $mailreport){
			?>
				<div class="conversation_list" >
					<div class="conversa_item">
						<div class="ds_flex">
							<div class="title">
								<span>{{@$mailreport->subject}}</span>
							</div>
							<div class="conver_action">
								<div class="date">
									<span>{{date('h:i A', strtotime(@$mailreport->created_at))}}</span>
								</div>
							</div>
						</div>

						<div class="email_info">
							<div class="avatar_img">
								<span>{{substr(@$mailreport->from_mail, 0, 1)}}</span>
							</div>
							<div class="email_content">
								<span class="email_label">Sent by:</span>
								<span class="email_sentby"><strong>{{@$mailreport->from_mail}}</strong> </span>
								<span class="label success">Delivered</span>
								<span class="span_desc">
									<span class="email_label">Sent To</span>
									<span class="email_sentby"><i class="fa fa-angle-left"></i>{{@$mailreport->to_mail}}<i class="fa fa-angle-right"></i></span>
								</span>
							</div>
						</div>

						<div class="divider"></div>
						<div class="email_desc">
							@if(@$mailreport->attachments != '')
							<?php
							/*  $decodeatta = json_decode($mailreport->attachments);
							if(!empty($decodeatta)){
							?>
								<div class="attachments">
									<ul style="list-style: none;">
									@foreach($decodeatta as $attaa)
										<li style="display:inline-block;padding: 0px 11px;
										border-radius: 4px;
										box-shadow: 0 3px 8px 0 rgb(0 0 0 / 8%), 0 1px 2px 0 rgb(0 0 0 / 10%);"><a href="<?php echo URL::to('/checklists/'.$attaa->file_url); ?>" target="_blank">{{$attaa->file_name}}</a></li>
																			@endforeach
									</ul>
								</div>
							<?php } */ ?>
							@endif
							{!!$mailreport->message!!}
						</div>
						<div class="divider"></div>
						<?php
						/* if($mailreport->reciept_id != ''){
							if(\App\InvoicePayment::where('id',$mailreport->reciept_id)->exists()){
								$invpayment = \App\InvoicePayment::where('id',$mailreport->reciept_id)->first();
						?>
							<div class="email_attachment">
								<span class="attach_label"><i class="fa fa-link"></i> Attachments:</span>
								<div class="attach_file_list">
									<div class="attach_col">
										<a href="{{URL::to('admin/payment/view/')}}/{{base64_encode(convert_uuencode(@$invpayment->id))}}">receipt_{{$invpayment->id}}.pdf</a>
									</div>
								</div>
							</div>
							<?php } ?>
						<?php } */ ?>
					</div>
				</div>
			<?php } ?>
			</div>

			<div class="tab-pane fade  show active" id="sent" role="tabpanel" aria-labelledby="sent-tab">
				<?php
				$mailreports = \App\MailReport::whereRaw('FIND_IN_SET("'.$fetchedData->id.'", to_mail)')->where('type','client')->where('mail_type',0)->orderby('created_at', 'DESC')->get();
				foreach($mailreports as $mailreport){
					$admin = \App\Admin::where('id', $mailreport->user_id)->first();

					$client = \App\Admin::Where('id', $fetchedData->id)->first();
					$subject = str_replace('{Client First Name}',$client->first_name, $mailreport->subject);
					$message = $mailreport->message;
					$message = str_replace('{Client First Name}',$client->first_name, $message);
					$message = str_replace('{Client Assignee Name}',$client->first_name, $message);
					$message = str_replace('{Company Name}',Auth::user()->company_name, $message);
				?>
					<div class="conversation_list" >
						<div class="conversa_item">
							<div class="ds_flex">
								<div class="title">
									<span>{{$subject}}</span>
								</div>
								<div class="conver_action">
									<div class="date">
										<span>{{date('h:i A', strtotime($mailreport->created_at))}}</span>
									</div>
									<div class="conver_link">
										<a datamailid="{{$mailreport->id}}" datasubject="{{$subject}}" class="create_note" datatype="mailnote" href="javascript:;" ><i class="fas fa-file-alt"></i></a>
										<a datamailid="{{$mailreport->id}}" datasubject="{{$subject}}" href="javascript:;" class="opentaskmodal"><i class="fas fa-shopping-bag"></i></a>
									</div>
								</div>
							</div>
							<div class="email_info">
								<div class="avatar_img">
									<span>{{substr($admin->first_name, 0, 1)}}</span>
								</div>
								<div class="email_content">
									<span class="email_label">Sent by:</span>
									<span class="email_sentby"><strong>{{@$admin->first_name}}</strong> [{{$mailreport->from_mail}}]</span>
									<span class="label success">Delivered</span>
									<span class="span_desc">
										<span class="email_label">Sent To</span>
										<span class="email_sentby"><i class="fa fa-angle-left"></i>{{$client->email}}<i class="fa fa-angle-right"></i></span>
									</span>
								</div>
							</div>
							<div class="divider"></div>
							<div class="email_desc">
								 @if($mailreport->attachments != '')
								 <?php
								 $decodeatta = json_decode($mailreport->attachments);
								 if(!empty($decodeatta)){
								 ?>
									<div class="attachments">
										<ul style="list-style: none;">
											@foreach($decodeatta as $attaa)
												<li style="display:inline-block;padding: 0px 11px;
												border-radius: 4px;
												box-shadow: 0 3px 8px 0 rgb(0 0 0 / 8%), 0 1px 2px 0 rgb(0 0 0 / 10%);"><a href="<?php echo URL::to('/checklists/'.$attaa->file_url); ?>" target="_blank">{{$attaa->file_name}}</a></li>
											@endforeach
										</ul>
									</div>
										<?php } ?>
								@endif
								{!!$message!!}
							</div>
							<div class="divider"></div>
							<?php
							if($mailreport->reciept_id != ''){
								if(\App\InvoicePayment::where('id',$mailreport->reciept_id)->exists()){
									$invpayment = \App\InvoicePayment::where('id',$mailreport->reciept_id)->first();
							?>
							<div class="email_attachment">
								<span class="attach_label"><i class="fa fa-link"></i> Attachments:</span>
								<div class="attach_file_list">
									<div class="attach_col">
										<a href="{{URL::to('admin/payment/view/')}}/{{base64_encode(convert_uuencode(@$invpayment->id))}}">receipt_{{$invpayment->id}}.pdf</a>
									</div>
								</div>
							</div>
							<?php } ?>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
		</div>


	<div class="tab-pane fade" id="sms" role="tabpanel" aria-labelledby="sms-tab">
		<!--<span>sms</span>-->
		<div class="row">
			<div class="col-md-12" style="text-align: right;margin-bottom: 10px;">
				<a class="btn btn-outline-primary btn-sm uploadAndFetchMail" href="javascript:;">Upload Mail</a>
			</div>
		</div>
		
		<ul class="nav nav-pills round_tabs" id="client_mail_tabs" role="tablist">
			
			<li class="nav-item">
				<a class="nav-link active" data-toggle="tab" id="fetchemail-tab" href="#fetchemail" role="tab" aria-controls="fetchemail" aria-selected="true">List11</a>
			</li>
		</ul>
		
		<div class="tab-content" id="conversationContent">
			<div class="tab-pane fade" id="fetchemail" role="tabpanel" aria-labelledby="fetchemail-tab">
			<?php
			$mailreports = \App\MailReport::where('client_id',$fetchedData->id)->where('type','client')->where('mail_type',1)->whereNotNull('conversion_type')->orderby('created_at', 'DESC')->get();
			foreach($mailreports as $mailreport){
			?>
				<div class="conversation_list" >
					<div class="conversa_item">
						<div class="ds_flex">
							<div class="title">
								<span>{{@$mailreport->subject}}</span>
							</div>
							<div class="conver_action">
								<div class="date">
									<span>{{date('h:i A', strtotime(@$mailreport->created_at))}}</span>
								</div>
							</div>
						</div>

						<div class="email_info">
							<div class="avatar_img">
								<span>{{substr(@$mailreport->from_mail, 0, 1)}}</span>
							</div>
							<div class="email_content">
								<span class="email_label">Sent by:</span>
								<span class="email_sentby"><strong>{{@$mailreport->from_mail}}</strong> </span>
								<span class="label success">Delivered</span>
								<span class="span_desc">
									<span class="email_label">Sent To</span>
									<span class="email_sentby"><i class="fa fa-angle-left"></i>{{@$mailreport->to_mail}}<i class="fa fa-angle-right"></i></span>
								</span>
							</div>
						</div>

						<div class="divider"></div>
						<div class="email_desc">
							@if(@$mailreport->attachments != '')
							<?php
							/*  $decodeatta = json_decode($mailreport->attachments);
							if(!empty($decodeatta)){
							?>
								<div class="attachments">
									<ul style="list-style: none;">
									@foreach($decodeatta as $attaa)
										<li style="display:inline-block;padding: 0px 11px;
										border-radius: 4px;
										box-shadow: 0 3px 8px 0 rgb(0 0 0 / 8%), 0 1px 2px 0 rgb(0 0 0 / 10%);"><a href="<?php echo URL::to('/checklists/'.$attaa->file_url); ?>" target="_blank">{{$attaa->file_name}}</a></li>
																			@endforeach
									</ul>
								</div>
							<?php } */ ?>
							@endif
							{!!$mailreport->message!!}
						</div>
						<div class="divider"></div>
						<?php
						/* if($mailreport->reciept_id != ''){
							if(\App\InvoicePayment::where('id',$mailreport->reciept_id)->exists()){
								$invpayment = \App\InvoicePayment::where('id',$mailreport->reciept_id)->first();
						?>
							<div class="email_attachment">
								<span class="attach_label"><i class="fa fa-link"></i> Attachments:</span>
								<div class="attach_file_list">
									<div class="attach_col">
										<a href="{{URL::to('admin/payment/view/')}}/{{base64_encode(convert_uuencode(@$invpayment->id))}}">receipt_{{$invpayment->id}}.pdf</a>
									</div>
								</div>
							</div>
							<?php } ?>
						<?php } */ ?>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>
		
		
	</div>
</div>