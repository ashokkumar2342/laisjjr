@if (@$show_disabled == 1)
	<option selected disabled>Select {{$box_caption}}</option>
@endif
@if (@$show_all == 1)
	<option selected value="0">All</option>
@endif
@foreach ($rs_records as $val_record)
 	<option value="{{ $val_record->opt_id }}">{{ $val_record->opt_text }}</option> 
@endforeach 