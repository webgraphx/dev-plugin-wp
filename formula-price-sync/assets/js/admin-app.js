/**
 * Formula Price Sync – Admin App (main settings / bulk / formula UI)
 * Depends on jQuery and window.FPSAdmin = { ajaxUrl, nonce, i18n, ... }
 */
(function ($) {
	"use strict";

	if (typeof FPSAdmin === "undefined") {
		console.warn("FPSAdmin config missing");
		return;
	}

	var i18n = FPSAdmin.i18n || {};

	function notice($container, msg, type) {
		type = type || "info";
		var cls = "fps-notice fps-notice-" + type;
		$container.find(".fps-notice").remove();
		$container.prepend(
			$("<div/>", { class: cls, text: msg || "" })
		);
	}

	function setBusy($btn, busy) {
		if (!$btn || !$btn.length) return;
		$btn.prop("disabled", !!busy);
		if (busy) {
			$btn.data("orig-text", $btn.text());
			$btn.text(i18n.working || "…");
		} else if ($btn.data("orig-text")) {
			$btn.text($btn.data("orig-text"));
		}
	}

	// Save settings
	$(document).on("click", "#fps-save-settings", function (e) {
		e.preventDefault();
		var $btn = $(this);
		var $form = $("#fps-settings-form");
		if (!$form.length) return;

		setBusy($btn, true);
		$.ajax({
			url: FPSAdmin.ajaxUrl,
			type: "POST",
			dataType: "json",
			data: $form.serialize() + "&action=fps_save_settings&nonce=" + encodeURIComponent(FPSAdmin.nonce),
			timeout: 30000
		})
			.done(function (res) {
				if (res && res.success) {
					notice($form, res.data && res.data.message || i18n.saved || "Saved", "success");
				} else {
					notice($form, (res && res.data && res.data.message) || i18n.error || "Error", "error");
				}
			})
			.fail(function () {
				notice($form, i18n.error || "Error", "error");
			})
			.always(function () {
				setBusy($btn, false);
			});
	});

	// Bulk formula apply
	$(document).on("click", "#fps-bulk-apply", function (e) {
		e.preventDefault();
		var $btn = $(this);
		var $form = $("#fps-bulk-form");
		if (!$form.length) return;

		if (!window.confirm(i18n.confirmBulk || "Apply formula to selected products?")) {
			return;
		}

		setBusy($btn, true);
		$.ajax({
			url: FPSAdmin.ajaxUrl,
			type: "POST",
			dataType: "json",
			data: $form.serialize() + "&action=fps_bulk_apply&nonce=" + encodeURIComponent(FPSAdmin.nonce),
			timeout: 60000
		})
			.done(function (res) {
				if (res && res.success) {
					notice($form, res.data && res.data.message || i18n.bulkOk || "Done", "success");
				} else {
					notice($form, (res && res.data && res.data.message) || i18n.error || "Error", "error");
				}
			})
			.fail(function () {
				notice($form, i18n.error || "Error", "error");
			})
			.always(function () {
				setBusy($btn, false);
			});
	});

	// Test formula
	$(document).on("click", "#fps-test-formula", function (e) {
		e.preventDefault();
		var $btn = $(this);
		var formula = $("#fps-formula-input").val() || "";
		var $result = $("#fps-test-result");

		setBusy($btn, true);
		$result.text("");
		$.ajax({
			url: FPSAdmin.ajaxUrl,
			type: "POST",
			dataType: "json",
			data: {
				action: "fps_test_formula",
				nonce: FPSAdmin.nonce,
				formula: formula
			},
			timeout: 20000
		})
			.done(function (res) {
				if (res && res.success && res.data) {
					$result.text(res.data.result || JSON.stringify(res.data));
				} else {
					$result.text((res && res.data && res.data.message) || i18n.error || "Error");
				}
			})
			.fail(function () {
				$result.text(i18n.error || "Error");
			})
			.always(function () {
				setBusy($btn, false);
			});
	});

	// Provider test connection
	$(document).on("click", ".fps-test-provider", function (e) {
		e.preventDefault();
		var $btn = $(this);
		var provider = $btn.data("provider") || "";
		var $status = $btn.closest(".fps-form-row").find(".fps-provider-status");

		setBusy($btn, true);
		$status.text("");
		$.ajax({
			url: FPSAdmin.ajaxUrl,
			type: "POST",
			dataType: "json",
			data: {
				action: "fps_test_provider",
				nonce: FPSAdmin.nonce,
				provider: provider
			},
			timeout: 25000
		})
			.done(function (res) {
				if (res && res.success) {
					$status.text(res.data && res.data.message || "OK").css("color", "#059669");
				} else {
					$status.text((res && res.data && res.data.message) || i18n.error || "Error").css("color", "#dc2626");
				}
			})
			.fail(function () {
				$status.text(i18n.error || "Error").css("color", "#dc2626");
			})
			.always(function () {
				setBusy($btn, false);
			});
	});

	// Toggle sections
	$(document).on("click", ".fps-toggle", function (e) {
		e.preventDefault();
		var target = $(this).data("target");
		if (target) {
			$(target).slideToggle(150);
		}
	});

})(jQuery);
