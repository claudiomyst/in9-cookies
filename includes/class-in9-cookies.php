<?php
/**
 * Main Plugin Coordinator Class
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

final class In9_Cookies {

    /**
     * Singleton instance.
     *
     * @var In9_Cookies|null
     */
    private static ?In9_Cookies $instance = null;

    /**
     * Blocker & Tracking manager.
     *
     * @var In9_Cookies_Blocker
     */
    public In9_Cookies_Blocker $blocker;

    /**
     * Frontend manager.
     *
     * @var In9_Cookies_Frontend
     */
    public In9_Cookies_Frontend $frontend;

    /**
     * Admin manager.
     *
     * @var In9_Cookies_Admin
     */
    public In9_Cookies_Admin $admin;

    /**
     * Returns the singleton instance.
     */
    public static function instance(): In9_Cookies {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Private constructor.
     */
    private function __construct() {
        $this->blocker  = new In9_Cookies_Blocker();
        $this->frontend = new In9_Cookies_Frontend();
        $this->admin    = new In9_Cookies_Admin();
    }

    /**
     * Initialize all modules and hooks.
     */
    public function init(): void {
        load_plugin_textdomain('in9-cookies', false, dirname(IN9_COOKIES_BASENAME) . '/languages');

        $this->blocker->init();
        $this->frontend->init();

        if (is_admin()) {
            $this->admin->init();
            add_filter('plugin_action_links_' . IN9_COOKIES_BASENAME, [$this, 'add_action_links']);
        }
    }

    /**
     * Add settings link to Plugins list table.
     *
     * @param array<string> $links
     * @return array<string>
     */
    public function add_action_links(array $links): array {
        $settings_link = sprintf(
            '<a href="%s">%s</a>',
            esc_url(admin_url('admin.php?page=in9-cookies')),
            esc_html__('Configurações', 'in9-cookies')
        );
        array_unshift($links, $settings_link);
        return $links;
    }
}
