<?php


Route::group(['middleware' => ['preventBackHistory','web']], function() {
	Route::get('login', 'Auth\LoginController@login')->name('admin.login'); 
	Route::post('logout', 'Auth\LoginController@logout')->name('admin.logout.get');
	Route::get('logout_time', 'Auth\LoginController@logout')->name('admin.logout_time.get');
	Route::get('refreshcaptcha', 'Auth\LoginController@refreshCaptcha')->name('admin.refresh.captcha');
	Route::post('login-post', 'Auth\LoginController@loginPost')->name('admin.login.post');
});

Route::group(['middleware' => ['preventBackHistory','admin','web']], function() {
	Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');

	Route::prefix('account')->group(function () {
		//Create New User
	    Route::get('create-new-user', 'AccountController@addNewUser')->name('admin.account.add.new.user');
	    Route::post('store', 'AccountController@store')->name('admin.account.new.user.store');

	    //User List
		Route::get('user-list', 'AccountController@userList')->name('admin.account.user.list');
		Route::get('user-edit/{rec_id}', 'AccountController@userEdit')->name('admin.account.user.edit');
		Route::post('user-update/{rec_id}', 'AccountController@userUpdate')->name('admin.account.user.update');
		Route::get('user-status/{id}', 'AccountController@userStatus')->name('admin.account.user.status');

		//Change Password
		Route::get('change-password', 'AccountController@changePassword')->name('admin.account.change.password');
		Route::post('change-password-store', 'AccountController@changePasswordStore')->name('admin.account.change.password.store');

		//Reset Password
		Route::get('reset-password', 'AccountController@resetPassWord')->name('admin.account.reset.password'); 
		Route::post('reset-password-change', 'AccountController@resetPassWordChange')->name('admin.account.reset.password.change');

		//Districts Assign
		Route::get('district-assign-index', 'AccountController@districtAssignIndex')->name('admin.account.district.assign.index');
		Route::get('district-assign-table', 'AccountController@districtAssignTable')->name('admin.account.district.assign.table');
		Route::post('district-assign-store', 'AccountController@districtAssignStore')->name('admin.account.district.assign.store');
		Route::get('district-assign-delete/{rec_id}', 'AccountController@districtAssignDelete')->name('admin.account.district.assign.delete');

		//Tehsil Assign
		Route::get('tehsil-assign-index', 'AccountController@tehsilAssignIndex')->name('admin.account.tehsil.assign.index');
		Route::get('tehsil-assign-table', 'AccountController@tehsilAssignTable')->name('admin.account.tehsil.assign.table');
		Route::post('tehsil-assign-store', 'AccountController@tehsilAssignStore')->name('admin.account.tehsil.assign.store');
		Route::get('tehsil-assign-delete/{rec_id}', 'AccountController@tehsilAssignDelete')->name('admin.account.tehsil.assign.delete');

		// Village Assign
		Route::get('village-assign-index', 'AccountController@villageAssignIndex')->name('admin.account.village.assign.index');
		Route::get('village-assign-table', 'AccountController@villageAssignTable')->name('admin.account.village.assign.table');
		Route::post('village-assign-store', 'AccountController@villageAssignStore')->name('admin.account.village.assign.store');
		Route::get('village-assign-delete/{rec_id}', 'AccountController@villageAssignDelete')->name('admin.account.village.assign.delete');
	});

	Route::group(['prefix' => 'common'], function() {
	    Route::get('ShowPdfFile/{path}', 'CommonController@ShowPdfFile')->name('admin.common.showPdfFile');
    	Route::get('pdf-popup/{path}', 'CommonController@pdfPopup')->name('admin.common.pdf.popup');
		Route::get('pdf-viewer/{path}', 'CommonController@pdfviewer')->name('admin.common.pdf.viewer');
		
    	Route::get('district-wise-tehsil', 'CommonController@districtWiseTehsil')->name('admin.common.district.wise.tehsil');
	    Route::get('tehsil-wise-village', 'CommonController@tehsilWiseVillage')->name('admin.common.tehsil.wise.village');
	    Route::get('scheme-wise-schemeAwardInfo', 'CommonController@schemeWiseSchemeAwardInfo')->name('admin.common.scheme.wise.schemeAwardInfo');
	    Route::get('schemeAwardInfo-wise-awardDetail', 'CommonController@schemeAwardInfoWiseAwardDetail')->name('admin.common.schemeAwardInfoWiseAwardDetail');
	    Route::get('awardDetail-wise-awardBeneficiaryDetail', 'CommonController@awardDetailWiseAwardBeneficiaryDetail')->name('admin.common.awardDetailWiseAwardBeneficiaryDetail');

	    Route::get('getTraData', 'CommonController@getTranslateData')->name('admin.common.getTranslateData');
	    Route::get('getTraDataPop', 'CommonController@getTraDataPop')->name('admin.common.getTraDataPop');
	    Route::get('getTraDataPopUpdate', 'CommonController@getTraDataPopUpdate')->name('admin.common.getTraDataPopUpdate');

	});

    Route::group(['prefix' => 'Master'], function() {
    	//Create State
    	Route::get('state-index', 'MasterController@stateIndex')->name('admin.master.state.index');
    	Route::get('state-addform/{rec_id}', 'MasterController@stateAddForm')->name('admin.master.state.addform');
    	Route::post('state-store/{rec_id}', 'MasterController@stateStore')->name('admin.master.state.store');
	    
	    //Create District
	    Route::get('district-index', 'MasterController@districtIndex')->name('admin.master.district.index');
	    Route::get('district-table', 'MasterController@districtTable')->name('admin.master.district.table');
	    Route::get('district-addform/{rec_id}', 'MasterController@districtAddForm')->name('admin.master.district.addform');
	    Route::post('district-store/{rec_id}', 'MasterController@districtStore')->name('admin.master.district.store');

	    //Create Tehsils
	    Route::get('tehsil-index', 'MasterController@tehsilIndex')->name('admin.master.tehsil.index');
	    Route::get('tehsil-table', 'MasterController@tehsilTable')->name('admin.master.tehsil.table');
	    Route::get('tehsil-addform/{rec_id}', 'MasterController@tehsilAddForm')->name('admin.master.tehsil.addform');
	    Route::post('tehsil-store/{rec_id}', 'MasterController@tehsilStore')->name('admin.master.tehsil.store');

	    //Create Village
	    Route::get('village-index', 'MasterController@villageIndex')->name('admin.master.village.index');
	    Route::get('village-table', 'MasterController@villageTable')->name('admin.master.village.table');
	    Route::get('village-addform/{rec_id}', 'MasterController@villageAddForm')->name('admin.master.village.addform');
	    Route::post('village-store/{rec_id}', 'MasterController@villageStore')->name('admin.master.village.store');

	    //Create schemes
	    Route::get('scheme-index', 'MasterController@schemeIndex')->name('admin.master.scheme.index');
	    Route::get('scheme-addform/{rec_id}', 'MasterController@schemeAddForm')->name('admin.master.scheme.addform');
	    Route::post('scheme-store/{rec_id}', 'MasterController@schemeStore')->name('admin.master.scheme.store');

	    //Scheme Award Info
	    Route::get('scheme-award-index', 'MasterController@schemeAwardIndex')->name('admin.master.scheme.award.index');
	    Route::get('scheme-award-table', 'MasterController@schemeAwardTable')->name('admin.master.scheme.award.table');
	    Route::get('scheme-award-addform/{rec_id}', 'MasterController@schemeAwardAddForm')->name('admin.master.scheme.award.addform');
	    Route::post('scheme-award-store/{rec_id}', 'MasterController@schemeAwardStore')->name('admin.master.scheme.award.store');

	    //Scheme Award Info File
	    Route::get('scheme-award-file-index', 'MasterController@schemeAwardFileIndex')->name('admin.master.scheme.award.file.index');
	    Route::get('scheme-award-file-table', 'MasterController@schemeAwardFileTable')->name('admin.master.scheme.award.file.table');
	    Route::get('scheme-award-file.addform/{rec_id}', 'MasterController@schemeAwardFileAddForm')->name('admin.master.scheme.award.file.addform');
	    Route::post('scheme-award-file-store/{rec_id}', 'MasterController@schemeAwardFileStore')->name('admin.master.scheme.award.file.store');

	    //Award Detail
	    Route::get('award-detail-index', 'MasterController@awardDetailIndex')->name('admin.master.award.detail.index');
	    Route::get('award-detail-table', 'MasterController@awardDetailTable')->name('admin.master.award.detail.table');
	    Route::get('award-detail.addform/{rec_id}', 'MasterController@awardDetailAddForm')->name('admin.master.award.detail.addform');
	    Route::post('award-detail-store/{rec_id}', 'MasterController@awardDetailStore')->name('admin.master.award.detail.store');

	    //Award Detail File
	    Route::get('award-detail-file-index', 'MasterController@awardDetailFileIndex')->name('admin.master.award.detail.file.index');
	    Route::get('award-detail-file-table', 'MasterController@awardDetailFileTable')->name('admin.master.award.detail.file.table');
	    Route::get('award-detail-file.addform/{rec_id}', 'MasterController@awardDetailFileAddForm')->name('admin.master.award.detail.file.addform');
	    Route::post('award-detail-file-store/{rec_id}', 'MasterController@awardDetailFileStore')->name('admin.master.award.detail.file.store');

	    //Create Relation
	    Route::get('relation-index', 'MasterController@relationIndex')->name('admin.master.relation.index');
	    Route::get('relation-addform/{rec_id}', 'MasterController@relationAddForm')->name('admin.master.relation.addform');
	    Route::post('relation-store/{rec_id}', 'MasterController@relationStore')->name('admin.master.relation.store');

	    //Award Beneficiary Detail
	    Route::get('award-beneficiary-index', 'MasterController@awardBeneficiaryIndex')->name('admin.master.award.beneficiary.index');
	    Route::get('award-beneficiary-table', 'MasterController@awardBeneficiaryTable')->name('admin.master.award.beneficiary.table');
	    Route::get('award-beneficiary.addform/{rec_id}', 'MasterController@awardBeneficiaryAddForm')->name('admin.master.award.beneficiary.addform');
	    Route::post('award-beneficiary-store/{rec_id}', 'MasterController@awardBeneficiaryStore')->name('admin.master.award.beneficiary.store');

	    //Award Beneficiary Payment Detail
	    Route::get('award-beneficiary-payment-index', 'MasterController@awardBeneficiaryPaymentIndex')->name('admin.master.award.beneficiary.payment.index');
	    Route::get('award-beneficiary-payment-table', 'MasterController@awardBeneficiaryPaymentTable')->name('admin.master.award.beneficiary.payment.table');
	    Route::get('award-beneficiary-payment.addform/{rec_id}', 'MasterController@awardBeneficiaryPaymentAddForm')->name('admin.master.award.beneficiary.payment.addform');
	    Route::post('award-beneficiary-payment-store/{rec_id}', 'MasterController@awardBeneficiaryPaymentStore')->name('admin.master.award.beneficiary.payment.store');
	});

	Route::group(['prefix' => 'report'], function() {
	    Route::get('report-index', 'ReportController@reportIndex')->name('admin.report.index');
    	Route::post('report-result', 'ReportController@reportResult')->name('admin.report.result');
    	Route::get('report-print', 'ReportController@reportPrint')->name('admin.report.print');
	});

 });
