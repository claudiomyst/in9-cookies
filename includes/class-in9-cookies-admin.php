<?php
/**
 * Admin Panel & Settings Controller
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

final class In9_Cookies_Admin {

    /**
     * Page hook suffix.
     *
     * @var string
     */
    private string $page_hook = '';

    /**
     * Initialize admin hooks.
     */
    public function init(): void {
        add_action('admin_menu', [$this, 'register_admin_menu']);
        add_action('admin_enqueue_scripts', [$this, 'enqueue_admin_assets']);
        add_action('admin_post_in9_cookies_save_settings', [$this, 'handle_save_settings']);
    }

    /**
     * Register Admin Menu.
     */
    public function register_admin_menu(): void {
        $icon_svg = 'data:image/svg+xml;base64,' . base64_encode(
            '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#a6bbd1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>'
        );

        $this->page_hook = add_menu_page(
            __('Cookies & LGPD', 'in9-cookies'),
            __('Cookies & LGPD', 'in9-cookies'),
            'manage_options',
            'in9-cookies',
            [$this, 'render_settings_page'],
            $icon_svg,
            81
        );
    }

    /**
     * Enqueue Admin Styles and Scripts.
     *
     * @param string $hook
     */
    public function enqueue_admin_assets(string $hook): void {
        if ($hook !== $this->page_hook) {
            return;
        }

        wp_enqueue_style(
            'in9-cookies-admin',
            IN9_COOKIES_URL . 'assets/css/in9-cookies-admin.min.css',
            [],
            IN9_COOKIES_VERSION
        );

        wp_enqueue_script(
            'in9-cookies-admin',
            IN9_COOKIES_URL . 'assets/js/in9-cookies-admin.min.js',
            ['jquery'],
            IN9_COOKIES_VERSION,
            true
        );
    }

    /**
     * Render the Settings Page template.
     */
    public function render_settings_page(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Você não tem permissão para acessar esta página.', 'in9-cookies'));
        }

        $settings = in9_cookies_get_settings();
        $active_tab = isset($_GET['tab']) ? sanitize_key($_GET['tab']) : 'general';
        $notice = isset($_GET['notice']) ? sanitize_key($_GET['notice']) : '';

        include IN9_COOKIES_PATH . 'templates/admin/settings-page.php';
    }

    /**
     * Handle saving settings securely with CSRF verification and permission check.
     */
    public function handle_save_settings(): void {
        if (!current_user_can('manage_options')) {
            wp_die(esc_html__('Permissão negada.', 'in9-cookies'));
        }

        check_admin_referer('in9_cookies_save_action', 'in9_cookies_nonce');

        $active_tab = isset($_POST['active_tab']) ? sanitize_key($_POST['active_tab']) : 'general';
        $current_settings = in9_cookies_get_settings();
        $updated_settings = $current_settings;

        if ($active_tab === 'general') {
            $updated_settings['enabled'] = !empty($_POST['enabled']) ? 1 : 0;
            
            $pos = sanitize_key($_POST['position'] ?? 'bottom-right');
            $updated_settings['position'] = in_array($pos, ['bottom-right', 'bottom-left', 'bottom-center', 'bottom-bar'], true) ? $pos : 'bottom-right';

            $theme = sanitize_key($_POST['theme'] ?? 'light');
            $updated_settings['theme'] = in_array($theme, ['light', 'dark'], true) ? $theme : 'light';

            $badge_pos = sanitize_key($_POST['badge_position'] ?? 'bottom-left');
            $updated_settings['badge_position'] = in_array($badge_pos, ['bottom-left', 'bottom-right'], true) ? $badge_pos : 'bottom-left';

            $updated_settings['show_floating_badge'] = !empty($_POST['show_floating_badge']) ? 1 : 0;
            $updated_settings['consent_expiry_days'] = max(1, min(365, absint($_POST['consent_expiry_days'] ?? 180)));

            $updated_settings['privacy_policy_url']  = esc_url_raw(trim((string) ($_POST['privacy_policy_url'] ?? '')));
            $updated_settings['privacy_policy_text'] = sanitize_text_field(trim((string) ($_POST['privacy_policy_text'] ?? '')));
            $updated_settings['banner_title']        = sanitize_text_field(trim((string) ($_POST['banner_title'] ?? '')));
            $updated_settings['banner_text']         = sanitize_textarea_field(trim((string) ($_POST['banner_text'] ?? '')));
        } elseif ($active_tab === 'tracking') {
            $updated_settings['enable_consent_mode'] = !empty($_POST['enable_consent_mode']) ? 1 : 0;

            // GA4 ID validation (G-XXXXX)
            $ga4 = sanitize_text_field(trim((string) ($_POST['ga4_id'] ?? '')));
            $updated_settings['ga4_id'] = preg_match('/^[A-Za-z0-9_-]+$/', $ga4) ? $ga4 : '';

            // GTM ID validation (GTM-XXXXX)
            $gtm = sanitize_text_field(trim((string) ($_POST['gtm_id'] ?? '')));
            $updated_settings['gtm_id'] = preg_match('/^[A-Za-z0-9_-]+$/', $gtm) ? $gtm : '';

            // Meta Pixel ID (numeric)
            $pixel = sanitize_text_field(trim((string) ($_POST['meta_pixel_id'] ?? '')));
            $updated_settings['meta_pixel_id'] = preg_match('/^[0-9]+$/', $pixel) ? $pixel : '';

            // Custom scripts textareas
            if (current_user_can('unfiltered_html')) {
                $updated_settings['custom_scripts_preferences'] = trim((string) ($_POST['custom_scripts_preferences'] ?? ''));
                $updated_settings['custom_scripts_analytics']   = trim((string) ($_POST['custom_scripts_analytics'] ?? ''));
                $updated_settings['custom_scripts_marketing']   = trim((string) ($_POST['custom_scripts_marketing'] ?? ''));
            } else {
                $updated_settings['custom_scripts_preferences'] = wp_kses_post(trim((string) ($_POST['custom_scripts_preferences'] ?? '')));
                $updated_settings['custom_scripts_analytics']   = wp_kses_post(trim((string) ($_POST['custom_scripts_analytics'] ?? '')));
                $updated_settings['custom_scripts_marketing']   = wp_kses_post(trim((string) ($_POST['custom_scripts_marketing'] ?? '')));
            }
        } elseif ($active_tab === 'categories') {
            $updated_settings['essential_title']   = sanitize_text_field(trim((string) ($_POST['essential_title'] ?? '')));
            $updated_settings['essential_desc']    = sanitize_textarea_field(trim((string) ($_POST['essential_desc'] ?? '')));
            $updated_settings['preferences_title'] = sanitize_text_field(trim((string) ($_POST['preferences_title'] ?? '')));
            $updated_settings['preferences_desc']  = sanitize_textarea_field(trim((string) ($_POST['preferences_desc'] ?? '')));
            $updated_settings['analytics_title']   = sanitize_text_field(trim((string) ($_POST['analytics_title'] ?? '')));
            $updated_settings['analytics_desc']    = sanitize_textarea_field(trim((string) ($_POST['analytics_desc'] ?? '')));
            $updated_settings['marketing_title']   = sanitize_text_field(trim((string) ($_POST['marketing_title'] ?? '')));
            $updated_settings['marketing_desc']    = sanitize_textarea_field(trim((string) ($_POST['marketing_desc'] ?? '')));
        }

        update_option(IN9_COOKIES_OPTION_KEY, $updated_settings);

        $redirect_url = add_query_arg([
            'page'   => 'in9-cookies',
            'tab'    => $active_tab,
            'notice' => 'saved'
        ], admin_url('admin.php'));

        wp_safe_redirect($redirect_url);
        exit;
    }
}
