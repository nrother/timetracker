/*
    TimeTracker
    Copyright (C) 2016 Niklas Rother

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
*/

$(document).ready(function() {
	//Times-Table
	$('#times').dataTable( {
		"bProcessing": true,
		"bJQueryUI": true,
		"sAjaxSource": 'gettimes.php',
		"oLanguage": {
			"sProcessing":   "Bitte warten...",
			"sLengthMenu":   "_MENU_ Einträge anzeigen",
			"sZeroRecords":  "Keine Einträge vorhanden.",
			"sInfo":         "_START_ bis _END_ von _TOTAL_ Einträgen",
			"sInfoEmpty":    "0 bis 0 von 0 Einträgen",
			"sInfoFiltered": "(gefiltert von _MAX_  Einträgen)",
			"sInfoPostFix":  "",
			"sSearch":       "Suchen",
			"sUrl":          "",
			"oPaginate": {
				"sFirst":    "Erster",
				"sPrevious": "Zurück",
				"sNext":     "Nächster",
				"sLast":     "Letzter"
			}
		},
		"aoColumns": [
			{ "sTitle": "Datum", "sClass": "center" },
			{ "sTitle": "Dauer", "sClass": "center" },
			{ "sTitle": "Kommentar" },
		]
	} );
	
	//Sum
	$("#sum").load("getsum.php");
	
	//Filter
	$(".filter").change(function() {
		setFilter($(this).attr("value"), $(this).attr("name"));
	});
	
	function setFilter(value, what)
	{
		$.post("setfilter.php", {
			value: value,
			what: what
		}, function() {
			$("#times").dataTable().fnReloadAjax();
			$("#sum").load("getsum.php");
		});
	}
	
	//Neuer Eintrag
	Globalize.culture("de-DE");
	jQuery(function($){
        $.datepicker.regional['de'] = {clearText: 'löschen', clearStatus: 'aktuelles Datum löschen',
                closeText: 'schließen', closeStatus: 'ohne Änderungen schließen',
                prevText: '<zurück', prevStatus: 'letzten Monat zeigen',
                nextText: 'Vor>', nextStatus: 'nächsten Monat zeigen',
                currentText: 'heute', currentStatus: '',
                monthNames: ['Januar','Februar','März','April','Mai','Juni',
                'Juli','August','September','Oktober','November','Dezember'],
                monthNamesShort: ['Jan','Feb','Mär','Apr','Mai','Jun',
                'Jul','Aug','Sep','Okt','Nov','Dez'],
                monthStatus: 'anderen Monat anzeigen', yearStatus: 'anderes Jahr anzeigen',
                weekHeader: 'Wo', weekStatus: 'Woche des Monats',
                dayNames: ['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'],
                dayNamesShort: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayNamesMin: ['So','Mo','Di','Mi','Do','Fr','Sa'],
                dayStatus: 'Setze DD als ersten Wochentag', dateStatus: 'Wähle D, M d',
                dateFormat: 'dd.mm.yy', firstDay: 1, 
                initStatus: 'Wähle ein Datum', isRTL: false};
        $.datepicker.setDefaults($.datepicker.regional['de']);
	});
	$("#date").datepicker();
	$("#date").datepicker("option", "dateFormat", "dd.mm.y");
	$("#duration").timespinner().val("00:00");
	var durationTimer;
	$("#save").button().click(function(event){
		if(!$('#date').val().match(/[0-3][0-9]\.[0-1][0-9]\.[1-2][0-9]/) || !$('#duration').val().match(/[0-2][0-9]:[0-5][0-9]/))
		{
			$("#dialog-error").dialog({
				width: 400,
				modal: true,
				draggable: false,
				resizable: false
			});
		}
		else
		{
			$("#saving").show();
			$.post("savetime.php", {
				date: $("#date").val(),
				duration: $("#duration").val(),
				comment: $("#comment").val()
			}, function(data){
				if(data.trim().length != 0)
					alert("Es gab einen Fehler beim Speichern!\nAusgabe: " + data);
				else
				{
					$("#times").dataTable().fnReloadAjax();
					$("#sum").load("getsum.php");
					$("#saving").hide();
					$("#saved").show().delay(1000).fadeOut(500);
				}
			});
		}
	});
	$("#comment").keypress(function(e){ //submit form on enter in comment field
		if(e.which == 13)
		{
			$("#save").focus().click();
			e.preventDefault();
		}
	});
} );

//Timespinner Widget
$.widget( "ui.timespinner", $.ui.spinner, {
	options: {
		// seconds
		step: 60 * 1000,
		// hours
		page: 60
	},

	_parse: function( value ) {
		if ( typeof value === "string" ) {
			// already a timestamp
			if ( Number( value ) == value ) {
				return Number( value );
			}
			return +Globalize.parseDate( value );
		}
		return value;
	},

	_format: function( value ) {
		return Globalize.format( new Date(value), "t" );
	}
});

//Datatable Plugin
$.fn.dataTableExt.oApi.fnReloadAjax = function ( oSettings, sNewSource, fnCallback, bStandingRedraw )
{
    if ( typeof sNewSource != 'undefined' && sNewSource != null ) {
        oSettings.sAjaxSource = sNewSource;
    }
 
    // Server-side processing should just call fnDraw
    if ( oSettings.oFeatures.bServerSide ) {
        this.fnDraw();
        return;
    }
 
    this.oApi._fnProcessingDisplay( oSettings, true );
    var that = this;
    var iStart = oSettings._iDisplayStart;
    var aData = [];
  
    this.oApi._fnServerParams( oSettings, aData );
      
    oSettings.fnServerData.call( oSettings.oInstance, oSettings.sAjaxSource, aData, function(json) {
        /* Clear the old information from the table */
        that.oApi._fnClearTable( oSettings );
          
        /* Got the data - add it to the table */
        var aData =  (oSettings.sAjaxDataProp !== "") ?
            that.oApi._fnGetObjectDataFn( oSettings.sAjaxDataProp )( json ) : json;
          
        for ( var i=0 ; i<aData.length ; i++ )
        {
            that.oApi._fnAddData( oSettings, aData[i] );
        }
          
        oSettings.aiDisplay = oSettings.aiDisplayMaster.slice();
          
        if ( typeof bStandingRedraw != 'undefined' && bStandingRedraw === true )
        {
            oSettings._iDisplayStart = iStart;
            that.fnDraw( false );
        }
        else
        {
            that.fnDraw();
        }
          
        that.oApi._fnProcessingDisplay( oSettings, false );
          
        /* Callback user function - for event handlers etc */
        if ( typeof fnCallback == 'function' && fnCallback != null )
        {
            fnCallback( oSettings );
        }
    }, oSettings );
};