function hhEndnotes_show(pid) {
	jQuery('#hhendnotes-' + pid + ' ol').show();
	hhEndnotes_updateLabel(pid);
}

function hhEndnotes_toggleVisible(pid) {
	jQuery('#hhendnotes-' + pid + ' ol').toggle();
	hhEndnotes_updateLabel(pid);
	return false;
}

function hhEndnotes_updateLabel(pid) {
	if (jQuery('#hhendnotes-' + pid + ' ol').is(':visible')) {
		jQuery('#hhendnotes-' + pid + ' .endnotesshow').hide();
	} else {
		jQuery('#hhendnotes-' + pid + ' .endnotesshow').show();
	}
}

jQuery(document).ready( function() {
	try {
		var target = window.location.hash;
		if (target.substr(0,4) == '#en-') {
			var pieces = target.split('-');
			if (pieces.length == 3) {
				var pid = pieces[1];
				hhEndnotes_show(pid);
			}
		}
	} catch (ex) {}
});