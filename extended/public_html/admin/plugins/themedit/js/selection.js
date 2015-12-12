function insert_var(var_name){
	var o_text   = document.getElementById('theme_contents');
	
	// Get caret position
	var s = new Selection(o_text);
	var res = s.create();
	var ca_begin = res.start;
	var ca_end   = res.end;
	var part1    = o_text.value.substr(0, ca_begin);
	var part2    = o_text.value.substr(ca_end, o_text.value.length - ca_end + 1);
	var data     = '{' + var_name + '}';
	var data_len = data.length;
	
	// Insert {template_var}
	o_text.value = part1 + data + part2;
	
	// Set caret position
	if (document.all) { // IE
	} else { // FF
		o_text.selectionStart = ca_begin + data_len;
		o_text.selectionEnd   = o_text.selectionStart;
	}
	o_text.focus();
}

// Cross Browser selectionStart/selectionEnd
// Version 0.1
// Copyright (c) 2005 KOSEKI Kengo
// 
// This script is distributed under the MIT licence.
// http://www.opensource.org/licenses/mit-license.php

function Selection(textareaElement) {
	this.element = textareaElement;
}

Selection.prototype.create = function() {
	if (document.selection != null && this.element.selectionStart == null) {
		return this._ieGetSelection();
	} else {
		return this._mozillaGetSelection();
	}
}

Selection.prototype._mozillaGetSelection = function() {
	return { 
		start: this.element.selectionStart, 
		end: this.element.selectionEnd 
	};
}

Selection.prototype._ieGetSelection = function() {
	this.element.focus();
	
	var range = document.selection.createRange();
	var bookmark = range.getBookmark();
	
	var contents = this.element.value;
	var originalContents = contents;
	var marker = this._createSelectionMarker();
	while(contents.indexOf(marker) != -1) {
		marker = this._createSelectionMarker();
	}
	var selection = range.text;
	
	var parent = range.parentElement();
	if (parent == null || parent.type != "textarea") {
		return { start: 0, end: 0 };
	}
	range.text = marker + range.text + marker;
	contents = this.element.value;
	
	var result = {};
	result.start = contents.indexOf(marker);
	contents = contents.replace(marker, "");
	result.end = contents.indexOf(marker);
	
	this.element.value = originalContents;
	range.moveToBookmark(bookmark);
	range.select();
	
	return result;
}

Selection.prototype._createSelectionMarker = function() {
	return "##SELECTION_MARKER_" + Math.random() + "##";
}
