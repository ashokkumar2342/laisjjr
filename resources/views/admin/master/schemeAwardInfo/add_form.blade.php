<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">{{ @$rec_id>0? 'Edit' : 'Add' }}</h4>
            <button type="button" id="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('admin.master.scheme.award.store', Crypt::encrypt($rec_id)) }}" method="post" class="add_form" button-click="btn_close" select-triger="scheme_select_box">
                {{ csrf_field() }}
                <div class="box-body">
                    @if ($rec_id == 0)
                        <div class="form-group">
                            <label for="exampleInputEmail1">District</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="district" class="form-control select2" id="district_select_box" onchange="callAjax(this,'{{ route('admin.common.district.wise.tehsil') }}','tehsil_select_box')" required>
                                <option selected disabled>Select District</option>
                                @foreach ($rs_district as $val_rec)
                                <option value="{{ Crypt::encrypt($val_rec->opt_id) }}">{{ $val_rec->opt_text }}</option>    
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tehsil</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="tehsil" class="form-control select2" id="tehsil_select_box"  onchange="callAjax(this,'{{ route('admin.common.tehsil.wise.village') }}','village_select_box')" required>
                                <option selected disabled>Select Tehsil</option> 
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Village</label>
                            <span class="fa fa-asterisk"></span>
                            <select name="village" class="form-control select2" id="village_select_box" required>
                                <option selected disabled>Select Village</option> 
                            </select>
                        </div>    
                        <input type="hidden" name="scheme_id" value="{{Crypt::encrypt($scheme_id)}}">
                    @endif
                    
                    <div class="form-group">
                        <label>Award No.</label>
                        <span class="fa fa-asterisk"></span>
                        <input type="text" name="award_no" class="form-control" placeholder="Enter Award No." maxlength="10" required value="{{ @$rs_records[0]->award_no }}"> 
                    </div>
                    <div class="form-group">
                        <label>Award Date (DD-MM-YYYY)</label>
                        <span class="fa fa-asterisk"></span>
                        <input type="text" name="award_date" class="form-control" placeholder="DD-MM-YYYY" value="{{@$rs_records[0]->awd_date}}" maxlength="10" minlength="10" required onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45) || (event.charCode == 47)'>
                    </div>
                    <div class="form-group">
                        <label>Jamabandi Year (YYYY-YYYY)</label>
                        <span class="fa fa-asterisk"></span>
                        <input type="text" name="year" class="form-control" placeholder="YYYY-YYYY" value="{{@$rs_records[0]->year}}" maxlength="10" required onkeypress='return (event.charCode >= 48 && event.charCode <= 57) || (event.charCode == 45) || (event.charCode == 47)'>
                    </div> 
                    <div class="form-group">
                        <label>Unit</label>
                        <span class="fa fa-asterisk"></span>
                        <select name="unit" id="unit" class="form-control">
                            <option value="1" {{@$rs_records[0]->area_unit==1?'selected':''}}>Kanal Marla</option>
                            <option value="2" {{@$rs_records[0]->area_unit==2?'selected':''}}>Bigha Biswa</option>
                        </select>
                    </div>             
                </div>
                <div class="modal-footer card-footer justify-content-between">
                    <button type="submit" class="btn btn-success form-control">{{ @$rec_id>0? 'Update' : 'Submit' }}</button>
                    <button type="button" class="btn btn-danger form-control" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

