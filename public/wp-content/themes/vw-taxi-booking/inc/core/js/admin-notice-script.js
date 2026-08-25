jQuery(document).ready(function ($) {
    // Attach click event to the dismiss button
    $(document).on('click', '.notice[data-notice="get-start"] button.notice-dismiss', function () {
        // Dismiss the notice via AJAX
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                action: 'vw_taxi_booking_dismissed_notice',
            },
            success: function () {
                // Remove the notice on success
                $('.notice[data-notice="example"]').remove();
            }
        });
    });
});

// Plugin – AI Content Writer plugin activation
document.addEventListener('DOMContentLoaded', function () {
    const vw_taxi_booking_button = document.getElementById('install-activate-button');

    if (!vw_taxi_booking_button) return;

    vw_taxi_booking_button.addEventListener('click', function (e) {
        e.preventDefault();

        const vw_taxi_booking_redirectUrl = vw_taxi_booking_button.getAttribute('data-redirect');

        // Step 1: Check if plugin is already active
        const vw_taxi_booking_checkData = new FormData();
        vw_taxi_booking_checkData.append('action', 'check_plugin_activation');

        fetch(installPluginData.ajaxurl, {
            method: 'POST',
            body: vw_taxi_booking_checkData,
        })
        .then(res => res.json())
        .then(res => {
            if (res.success && res.data.active) {
                // Plugin is already active → just redirect
                window.location.href = vw_taxi_booking_redirectUrl;
            } else {
                // Not active → proceed with install + activate
                vw_taxi_booking_button.textContent = 'Installing & Activating...';

                const vw_taxi_booking_installData = new FormData();
                vw_taxi_booking_installData.append('action', 'install_and_activate_required_plugin');
                vw_taxi_booking_installData.append('_ajax_nonce', installPluginData.nonce);

                fetch(installPluginData.ajaxurl, {
                    method: 'POST',
                    body: vw_taxi_booking_installData,
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        window.location.href = vw_taxi_booking_redirectUrl;
                    } else {
                        alert('Activation error: ' + (res.data?.message || 'Unknown error'));
                        vw_taxi_booking_button.textContent = 'Try Again';
                    }
                })
                .catch(error => {
                    alert('Request failed: ' + error.message);
                    vw_taxi_booking_button.textContent = 'Try Again';
                });
            }
        })
        .catch(error => {
            alert('Check request failed: ' + error.message);
        });
    });
});
