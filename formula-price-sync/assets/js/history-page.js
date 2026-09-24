/**
 * FPS History page helpers
 */
(function ($) {
	"use strict";

	$(function () {
		// Optional: filter / pagination helpers can be added here.
		var $table = $(".fps-history-table");
		if (!$table.length) {
			return;
		}

		// Example: highlight rows with errors
		$table.find("tr").each(function () {
			var $row = $(this);
			if ($row.find(".fps-status-error").length) {
				$row.css("background-color", "#fef2f2");
			}
		});
	});
})(jQuery);
