<!DOCTYPE html>
<html>
<head>
	<style>
	@page { footer: html_otherpagesfooter; 
		header: html_otherpageheader;
	}  
</style>
</head>
<body>
	<htmlpagefooter name="otherpagesfooter" style="display:none">
		<div style="text-align:right;">
			{nbpg}  {PAGENO}
		</div>
	</htmlpagefooter>
	<htmlpageheader name="otherpageheader" style="display:none"> 
	</htmlpageheader>
		<p style="text-align:center;font-size: 18px;font-weight: bold;">Award Statement</p> 
		<table id="first_table" width="100%" style="font-size: 14px;">
			<tbody>
				<tr>
					<td width="100%" style="font-weight: bold;">Award No.:1 Date: 03-10-2018 Village: Jhajjar Tehsil: Jhajjar District: Jhajjar</td>
				</tr>
			</tbody>
		</table>
		<table style="border-collapse: collapse; width: 100%;" border="1">
			<thead>
				<tr> 
					<th>Sr.No.</th>                
	                <th>Khewat No.</th>
	                <th>Khata No.</th>
	                <th>Khasra No.</th>
	                <th>Unit</th>
	                <th>Kanal</th>
	                <th>Marla</th>
	                <th>Sirsai</th>
	                <th>Value</th>
	                <th>Factor Value</th>
	                <th>Solatium Value</th>
	                <th>Additional Charge Value</th> 
				</tr>
			</thead>
			<tbody>
				@php
					$sr_no = 1;
				@endphp
				@foreach($rs_result as $key => $rs_val)
		            <tr>
		                <td>{{ $sr_no++ }}</td>
		                <td>{{ $rs_val->khewat_no }}</td>
		                <td>{{ $rs_val->khata_no }}</td>
		                <td>{{ $rs_val->khasra_no }}</td>
		                <td>{{ $rs_val->unit==1?'Kanal Marla':'Bigha Biswa'}}</td>
		                <td>{{ $rs_val->kanal }}</td>
		                <td>{{ $rs_val->marla }}</td>
		                <td>{{ $rs_val->sirsai }}</td>
		                <td>{{ $rs_val->value }}</td>
		                <td>{{ $rs_val->factor_value }}</td>
		                <td>{{ $rs_val->solatium_value }}</td>
		                <td>{{ $rs_val->additional_charge_value }}</td>
		            </tr>
	            	@php
			            $rs_records = DB::select(DB::raw("SELECT * from `award_beneficiary_detail` where `award_detail_id` = $rs_val->id;"));
			        @endphp
			        <tr>
                            <th>Sr.No.</th>                
                            <th>Name 1</th>
                            <th>Name 1 Hindi</th>
                            <th>Relation 1</th>
                            <th>Name 2</th>
                            <th>Name 2 Hindi</th>
                            <th>Relation 2</th>
                            <th>Name 3</th>
                            <th>Name 3 Hindi</th>
                            <th>Hissa Numerator</th>
                            <th>Hissa Denominator</th>
                            <th>Value</th>
                            <th>Award Detail File</th>
                            <th>Page No.</th>
                        </tr>
                        @php
                            $sr_no = 1;
                        @endphp
                        @foreach($rs_records as $value)
                            <tr>
                                <td>{{ $sr_no++ }}</td>
                                <td>{{$value->name_1_e}}</td>
                                <td>{{$value->name_1_l}}</td>
                                <td>{{$value->relation_1_id}}</td>
                                <td>{{$value->name_2_e}}</td>
                                <td>{{$value->name_2_l}}</td>
                                <td>{{$value->relation_2_id}}</td>
                                <td>{{$value->name_3_e}}</td>
                                <td>{{$value->name_3_l}}</td>
                                <td>{{$value->hissa_numerator}}</td>
                                <td>{{$value->hissa_denominator}}</td>
                                <td>{{$value->value}}</td>
                                <td>{{$value->award_detail_file_id}}</td>
                                <td>{{$value->page_no}}</td>
                            </tr>
                        @endforeach
				@endforeach  
			</tbody>
		</table>
		<pagebreak>
	</body>
	</html>
