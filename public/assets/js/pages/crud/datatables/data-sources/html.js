"use strict";
var KTDatatablesDataSourceHtml = function() {

	var initTable1 = function() {
		var table = $('#kt_table_1');

		// begin first table
		table.DataTable({
			responsive: true,
            sortable: true,
            aaSorting: [[0, 'desc']],
			columnDefs: [
				
				
				
			],
		});

	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	KTDatatablesDataSourceHtml.init();
});