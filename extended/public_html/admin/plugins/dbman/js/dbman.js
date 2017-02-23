var dbman = {};

dbman.checkTable = function(num_table, v) {
	var i, d = document;
	
	for (i = 0; i < num_table; i ++) {
		d.getElementById("restore_structure" + String(i)).checked = v;
	}
}

dbman.checkData = function(num_table, v) {
	var i, d = document;
	
	for (i = 0; i < num_table; i ++) {
		d.getElementById("restore_data" + String(i)).checked = v;
	}
}
