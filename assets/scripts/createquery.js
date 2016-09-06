var qD = {};
var tmpexpfldid = 0;
var queryData = new Array();
var tableData = new Array();
var expertData = new Array();

$('body').on('click', '.ccbtn', function (e) {
	e.preventDefault();
	var el = $(this).parents("#cqbase");
	var ttl = '#cqbasetitle';
	var bdy = '#cqbasebody';
	ajaxHandler( el, $(this).attr('id'), ttl, bdy );	
});

$('body').on( 'change', '#curelevelselect', function() {
	var selval = $(this).val();
	queryData['experts'] = new Array();
	for( var k = 0; k < 3; k++ ) {
		queryData['experts'][k] = 0;
	}
  	if( selval != 0 ) {
  		//$('#curehelpline').css( 'display', 'none' );
  		$('#curehelpline').html( "Keeping the expert names blank will assign experts randomly.<br>Data will be cured by the experts according to their level in ascending order." );
		var html = "";
		for( var i = 1; i <= selval; i++ ) {
			html = html + "<div class='input-append' style='margin-bottom: 2px;'><input id='expertfld"+i+"' class='expinp m-wrap medium' type='text'>";
			html = html + "<span class='add-on addexpert' style='cursor: pointer' id='expertbtn"+i+"'><i class='icon-group' style='cursor: pointer'></i></span></div>";
			html = html + "<span class='help-inline'>Expert"+i+"</span>";
		}
		$("#expertselect").html( html );
		$("#expertselectdiv").css('display','block');
	}
	else {
		$('#curehelpline').html( "Default curation level will assign 3 experts randomly to cure extracted data." );
		$('#curehelpline').css( 'display', 'block' );
		$("#expertselect").html( "" );
		$("#expertselectdiv").css('display','none');
	}
});

$('body').on('click', '.addexpert', function () {
	var el = $(this).attr('id');
	tmpexpfldid = el.substr(el.length - 1);
	showSelectExpertTable();
});

$('body').on('focus', '.expinp', function() {
	var el = $(this).attr('id');
	tmpexpfldid = el.substr(el.length - 1);
	showSelectExpertTable();
});

$('#modal-add-expert').click( function() {
	var expertid = $("input[name='exptableopt']:checked").val();
	if( expertid ) {
		for( var i = 0, len = expertData.length; i < len; i++ ) {
			if( expertid == expertData[i]['id'] ) {
				$('#expertfld'+tmpexpfldid).val( expertData[i]['name'] );
				queryData['experts'][tmpexpfldid-1] = parseInt( expertData[i]['id'] );
				$('#my-modal-close-btn').trigger( 'click' );
				break;
			}
		}
	}
	else {
		var msg = '<div class="alert alert-error hide" style="display: block;"><button class="close" data-dismiss="alert"></button><span>Please select an expert before adding.</span></div>';
		$('#add-expert-msg').html( msg );
	}
});

function showSelectExpertTable() {
	var html = getExpertTableForModal();
	$('#modal-expert-table').html( html );
	var tmpexpname = $('#expertfld'+tmpexpfldid).val();
	if( tmpexpname != "" ) {
		for( var i = 0, len = expertData.length; i < len; i++ ) {
			if( expertData[i]['name'] == tmpexpname ) {
				$("#expertradio"+expertData[i]['id']).attr('checked', 'checked');
			}
		}		
	}
	$('#modal-caller-btn').trigger( 'click' );
	TableManaged.init();
}

function ajaxHandler( base, chc, ttl, bdy ) {
	if( chc == "oldtablebtn" ) {
		getOldTables( base, ttl, bdy );
		return;
	}
	if( chc == "gotofinalise" ) {
		var tablename = $("input[name='tableopt']:checked").val();
		if( tablename ) {
			$( "#ppitablediv" ).fadeOut( "slow" );
			$( "#msginsertkey" ).fadeOut( "slow" );
			$( '#msginsertkey' ).html( "" ); 
			queryData['tablename'] = tablename;
			queryData['columnnames'] = tableData[tablename];
			getAndSaveExperts( base, ttl, bdy );
			$(ttl).html( 'Finalise Qurey' );
			//$(bdy).html( "<a class=' btn yellow' href='#static' data-toggle='modal'>View Demo</a>");
			$(bdy).html( "<div class='form-horizontal' id='lala'></div>" );
			$("#lala").append( getSearchKeysFields() );
			$( "#keydiv" ).fadeIn( "slow" );
		}
		else {
			var msg = '<div class="alert alert-error hide" style="display: block;"><button class="close" data-dismiss="alert"></button><span>Please select a table using the buttons in the left most column.</span></div>';
			$('#msginsertkey').html( msg );
		}
		return;
	}
	if( chc == "enterkeybtn" ) {
		var emtfds = true;
		for( var i = 0; i < queryData['keys'].length; i++ ) {
			var lala = $('#' + queryData['keys'][i]).val();
			if( lala != "" ) {
				emtfds = false;
			}
			queryData['keysvalues'][queryData['keys'][i]] = lala;
		}
		if( !emtfds ) {
			$( '#msgenterkeybtn' ).fadeOut( "slow" );
			$( '#msgenterkeybtn' ).html( "" );
			//alert( "kam korse" );
			//$( '#enterkeybtn' ).fadeOut();
			$( '#modiv' ).css( 'display', 'none' );
			$( "#lala2" ).append( getMoreQueryOptions() );
			UIJQueryUI.init();
		}
		else {
			var msg = '<div class="alert alert-error hide" style="display: block;"><button class="close" data-dismiss="alert"></button><span>Please provide at least one key to search.</span></div>';
			$('#msgenterkeybtn').html( msg );
		}
	}
	if( chc == "submitquerybtn" ) {
		//alert( "haha" );
		var curelvl = $( "#curelevelselect" ).val();
		queryData['curelevel'] = curelvl;
		queryData['deadline'] = $('#ui_date_picker_with_button_bar').val();
		
		if( queryData['deadline'] == "" ) {
			//queryData['deadline'] = "00-00-0000";
			$( '#msgenterkeybtn' ).fadeOut( "slow" );
			$( '#msgenterkeybtn' ).html( "" );
			
			submitQueryToServer( base, ttl, bdy );
		}
		else {
			var inputDate = new Date(queryData['deadline']);
			var todaysDate = new Date();
			//alert( "haha" );
			if( inputDate.setHours(0,0,0,0) <= todaysDate.setHours(0,0,0,0) ) {
				//alert( "thik nai" );
				var msg = '<div class="alert alert-error hide" style="display: block;"><button class="close" data-dismiss="alert"></button><span>Please slect deadline date after today\'s date.</span></div>';
				$('#msgenterkeybtn').html( msg );
				$('#msgenterkeybtn').fadeIn( "fast" );
				$("html, body").animate({ scrollTop: 0 }, "fast");
			}
			else {
				//alert( "thik ase" );
				$( '#msgenterkeybtn' ).fadeOut( "slow" );
				$( '#msgenterkeybtn' ).html( "" );
				
				submitQueryToServer(  base, ttl, bdy  );
			}
		}
	}
}

function getOldTables( base, ttl, bdy ) {
	$(ttl).html( 'Please Wait...' );
	$(bdy).html( '<br><br><br><br>' );
	App.blockUI( base );
	$.ajax({
		url: 'getppitables',
		type: 'POST',
		async: false,
		success: function( data ) {
			data = $.parseJSON( data );
			var newhtml = getOldTablesHTML( data.content );
			window.setTimeout(function () {
				App.unblockUI(base);
				$(ttl).html( "Select Table" );
      			$(bdy).html( newhtml );
			}, 1);
		},
		error: function( e ) {
			window.setTimeout(function () {
				App.unblockUI(base);
			}, 1);
		}
	});	
}

function getOldTablesHTML( data ) {
	var html = "";
	html = html + "<div id='ppitablediv'>";
	html = html + "<table class='table table-striped table-bordered table-hover' id='oldtable'>";
	html = html + "<thead><tr>";
	html = html + "<th style='width:10px;'>&nbsp;</th>";
	html = html + "<th style='width:90px;'>Table Name</th>";
	html = html + "<th style='width:150px;'>Search Keys</th>";
	html = html + "<th>Description</th>";
	html = html + "</tr></thead>";
	html = html + "<tbody>";
	for( var i = 0, l = data.length; i < l; i++ ) {
		html = html + "<tr class='odd gradeX'>";
		var tmp = new Array();
		for( obj in data[i] ) {
			if( obj == "tablename" ) tmp[0] = data[i][obj];
			else if( obj == "displayname" ) tmp[1] = data[i][obj];
			else if( obj == "searchkeys" ) tmp[2] = data[i][obj];
			else if( obj == "description" ) tmp[3] = data[i][obj];
			else {
				tableData[tmp[0]] = new Array();
				var nmp = data[i][obj];
				for( var j = 0; j < nmp.length; j++ ) {
					tableData[tmp[0]][j] = new Array();
					tableData[tmp[0]][j]['cdname'] = nmp[j]['cdname'];
					tableData[tmp[0]][j]['cname'] = nmp[j]['cname'];

				}
			}
		}
		html = html + "<td><input type='radio' value='" + tmp[0] + "' name='tableopt'></td>";
		html = html + "<td>" + tmp[1] + "</td>";
		html = html + "<td>" + tmp[2] + "</td>";
		html = html + "<td style='text-align:justify;'>" + tmp[3] + "</td>";
		html = html + "</tr>";
	}
	html = html + "</tbody></table>";
	html = html + "<div id='msggotofinalise'></div>";
	html = html + "<div style='text-align: center;'><a class='btn green ccbtn' href='#' id='gotofinalise'>";
	html = html + "Insert Search Key <i class='m-icon-swapright m-icon-white'></i></a></div>";
	html = html + "</div>";
	return html;
}

function getSearchKeysFields() {
	var html = "";
	html = html + "<div class='row-fluid' id='keydiv' style='display: none;'>";
	html = html + "<div class='span2'></div>";	
	html = html + "<div class='span8' id='lala2'>";
	html = html + "<h4>Search Keys</h4>";
	var cols = queryData['columnnames'];
	queryData['keysvalues'] = new Array();
	queryData['keys'] = new Array();	
	for( var i = 0; i < cols.length; i++ ) {
		queryData['keysvalues'][cols[i]['cname']] = "";
		queryData['keys'][i] = cols[i]['cname'];
		html = html + "<div class='control-group'>";
			html = html + "<label class='control-label'>" + cols[i]['cdname'] + "</label>";
			html = html + "<div class='controls'>";
				html = html + "<input class='m-wrap medium' type='text' id='" + cols[i]['cname'] + "'>";
				//html = html + "<span class='help-inline'>Some hint here</span>";
			html = html + "</div>";
		html = html + "</div>";
	}
	html = html + "</div>";
	html = html + "<div class='span2'></div>";
	html = html + "</div>";
	html = html + "<div style='display: block;' id='modiv'><div style='text-align: center;'><a class='btn green ccbtn' href='#' id='enterkeybtn'>";
	html = html + "More Options <i class='m-icon-swapdown m-icon-white'></i></a></div></div>";
	return html;
}

function getMoreQueryOptions() {
	var html = "";
	html = html + "<h4>Curation Options</h4>";
	html = html + "<div class='control-group'>";
		html = html + "<label class='control-label'>Level of Curation</label>";
		html = html + "<div class='controls'>";
			html = html + "<select class='small m-wrap' tabindex='1' id='curelevelselect'>";
				html = html + "<option value='0'>Default</option>";
				html = html + "<option value='1'>1</option>";
				html = html + "<option value='2'>2</option>";
				html = html + "<option value='3'>3</option>";
			html = html + "</select>";
			html = html + "<span class='help-inline' id='curehelpline'>Default curation level will assign 3 experts randomly to cure extracted data.</span>";
		html = html + "</div>";
	html = html + "</div>";
	html = html + "<div class='control-group' id='expertselectdiv' style='display: none;'>";
		html = html + "<label class='control-label'>Experts</label>";
		html = html + "<div class='controls' id='expertselect'>";
			
		html = html + "</div>";
	html = html + "</div>";
	html = html + "<div class='control-group'>";
		html = html + "<label class='control-label'>Curation Deadline</label>";
		html = html + "<div class='controls'>";
			html = html + "<input class='m-wrap medium' type='text' id='ui_date_picker_with_button_bar'>";
			html = html + "<span class='help-inline' id='curehelpline'>Blank deadline will keep the query active for curation till it is moved to archive.</span>";
		html = html + "</div>";
	html = html + "</div>";
	html = html + "<div><div style='text-align: center;'><a class='btn green ccbtn' href='#' id='submitquerybtn'>";
	html = html + "Submit Query <i class='m-icon-swapright m-icon-white'></i></a></div></div>";
	return html;
}

function getAndSaveExperts( base, ttl, bdy ) {
	$(ttl).html( 'Please Wait...' );
	$(bdy).html( '<br><br><br><br>' );
	App.blockUI( base );
	$.ajax({
		url: 'getexpertsall',
		type: 'POST',
		async: false,
		success: function( data ) {
			data = $.parseJSON( data );
			//var newhtml = getOldTablesHTML( data.content );
			window.setTimeout(function () {
				keepExpertStored( data.content );
				App.unblockUI(base);
				return;
				//$(ttl).html( "Select Table" );
      			//$(bdy).html( newhtml );
			}, 1);
		},
		error: function( e ) {
			window.setTimeout(function () {
				App.unblockUI(base);
			}, 1);
		}
	});	
}

function keepExpertStored( data ) {
	for( var i = 0, len = data.length; i < len; i++ ) {
		expertData[i] = new Array();
		for( obj in data[i] ) {
			expertData[i][obj] = data[i][obj];
		}		
	}
}

function getRandomExpert() {
	return "";
}

function getExpertTableForModal() {
	var html = "";
	html = html + "<div class='portlet box grey' style='margin-bottom: 0;'>";
	html = html + "<div class='portlet-title'><div class='caption'><i class='icon-user'></i>Experts</div></div>";
	html = html + "<div class='portlet-body'>";
	html = html + "<table class='table-striped table-hover' id='sample_2' style='width: 100%'>";
		html = html + "<thead>";
			html = html + "<tr style='text-align: left'>";
				html = html + "<th>&nbsp;</th>";
				html = html + "<th>Name</th>";
				html = html + "<th>Affiliation</th>";
				html = html + "<th>Institution</th>";
				html = html + "<th>Country</th>";
			html = html + "</tr>";
		html = html + "</thead>";
		html = html + "</tbody>";
		for( var i = 0, len = expertData.length; i < len; i++ ) {
			for( var z = 0; z < 3; z++ ) {
				if( queryData['experts'][z] == expertData[i]['id'] ) break;
			}
			if( z < 3 ) continue;
			html = html + "<tr>";
				html = html + "<td style='text-align: center'><input type='radio' value='"+expertData[i]['id']+"' name='exptableopt' id='expertradio"+expertData[i]['id']+"'></td>";
				html = html + "<td>" + expertData[i]['name'] + "</td>";
				html = html + "<td>" + expertData[i]['affiliation'] + "</td>";
				html = html + "<td>" + expertData[i]['institution'] + "</td>";
				html = html + "<td>" + expertData[i]['country'] + "</td>";
			html = html + "</tr>";
		}
		/*for( var j = 0, len = 20; j < len; j++ ) {
			var i = j % expertData.length;
			html = html + "<tr>";
				html = html + "<td style='text-align: center'><input type='radio' value='"+expertData[i]['id']+"' name='exptableopt' id='expertradio"+expertData[i]['id']+"'></td>";
				html = html + "<td>" + expertData[i]['name'] + "</td>";
				html = html + "<td>" + expertData[i]['affiliation'] + "</td>";
				html = html + "<td>" + expertData[i]['institution'] + "</td>";
				html = html + "<td>" + expertData[i]['country'] + "</td>";
			html = html + "</tr>";
		}*/
		html = html + "</tbody>";
	html = html + "</table>";
	html = html + "</div>";
	html = html + "</div>";
	html = html + "<div style='margin-top: 5px;' id='add-expert-msg'></div>"
	return html;
}

function submitQueryToServer( base, ttl, bdy ) {
	var qD = prepareDataForSubmit();
	$("html, body").animate({ scrollTop: 0 }, "fast");
	$(ttl).html( 'Please Wait...' );
	$(bdy).html( '<br><br><br><br>' );
	App.blockUI( base );
	$.ajax({
		url: 'submitquery',
		type: 'POST',
		data: { qD: qD },
		dataType: 'json',
		async: false,
		success: function( data ) {
			//data = $.parseJSON( data );
			var newhtml = "";
			window.setTimeout(function () {
				App.unblockUI(base);
				$(ttl).html( "Query Submission Complete" );
      			$(bdy).html( getConfirmationHtml( data ) );
			}, 1);
		},
		error: function( e ) {
			window.setTimeout(function () {
				App.unblockUI(base);
			}, 1);
		}
	});
} 

function prepareDataForSubmit() {
	qD['cureLevel'] = queryData['curelevel'];	
	if( qD['cureLevel'] > 0 ) {
		qD['experts'] = {};
		for( var i = 0; i < qD['cureLevel']; i++ ) {
			qD['experts'][i] = queryData['experts'][i];
		}
	}

	if( queryData['deadline'] != "" ) qD['deadLine'] = queryData['deadline'];
	else qD['deadLine'] = "00-00-0000";

	qD['table'] = queryData['tablename'];
	qD['keys'] = {};
	for( var i = 0, len = queryData['keys'].length; i < len; i++ ) {
		if( queryData['keysvalues'][queryData['keys'][i]] != "" ) {
			qD['keys'][queryData['keys'][i]] = queryData['keysvalues'][queryData['keys'][i]];
		}
	}
	return JSON.stringify( qD );
}

function getConfirmationHtml() {
	var html = "";
	html = html + "<div class='well' style='text-align: center;'>Your query has been received with ID # " + data.serial + "<br>";
	html = html + "Check the status of the query in your Pending Queries Page.<br>";
	html = html + "<a class='btn green' href='ongoingquery' id='submitquerybtn'>";
	html = html + "Pending Queries</i></a>";
	html = html + "</div>";
}