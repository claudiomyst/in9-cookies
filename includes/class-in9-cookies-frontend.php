<?php
/**
 * Frontend Assets & Template Renderer
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

final class In9_Cookies_Frontend {

    /**
     * Plugin settings.
     *
     * @var array<string, mixed>
     */
    private array $settings = [];

    /**
     * Constructor.
     */
    public function __construct() {
        $this->settings = in9_cookies_get_settings();
    }

    /**
     * Initialize frontend hooks.
     */
    public function init(): void {
        $this->settings = in9_cookies_get_settings();

        if (empty($this->settings['enabled'])) {
            return;
        }

        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
        add_action('wp_footer', [$this, 'render_templates'], 50);
    }

    /**
     * Enqueue CSS and CMP engine JavaScript.
     */
    public function enqueue_assets(): void {
        // Enqueue Frontend Stylesheet
        wp_enqueue_style(
            'in9-cookies-frontend',
            IN9_COOKIES_URL . 'assets/css/in9-cookies-frontend.min.css',
            [],
            IN9_COOKIES_VERSION
        );

        // Enqueue Frontend CMP Engine
        wp_enqueue_script(
            'in9-cookies-cmp',
            IN9_COOKIES_URL . 'assets/js/in9-cookies-cmp.min.js',
            [],
            IN9_COOKIES_VERSION,
            true // Load in footer
        );

        // Pass localized data to the CMP script
        $config = [
            'cookieName'        => 'in9_cookie_consent',
            'cookieExpiryDays'  => (int) ($this->settings['consent_expiry_days'] ?? 180),
            'enableConsentMode' => !empty($this->settings['enable_consent_mode']),
            'bannerPosition'    => esc_attr((string) ($this->settings['position'] ?? 'bottom-right')),
            'badgePosition'     => esc_attr((string) ($this->settings['badge_position'] ?? 'bottom-left')),
            'showFloatingBadge' => !empty($this->settings['show_floating_badge']),
            'i18n'              => [
                'preferencesSaved' => __('Preferências de privacidade salvas com sucesso!', 'in9-cookies'),
                'allAccepted'      => __('Todos os cookies foram autorizados.', 'in9-cookies'),
                'nonEssentialRejected' => __('Apenas os cookies essenciais foram mantidos.', 'in9-cookies'),
            ],
        ];

        wp_localize_script('in9-cookies-cmp', 'in9CookiesConfig', $config);
    }

    /**
     * Render banner, preferences modal, and floating trigger in footer.
     */
    public function render_templates(): void {
        $settings = $this->settings;

        // Banner template
        $banner_template = IN9_COOKIES_PATH . 'templates/frontend/banner.php';
        if (file_exists($banner_template)) {
            include $banner_template;
        }

        // Modal template
        $modal_template = IN9_COOKIES_PATH . 'templates/frontend/preferences-modal.php';
        if (file_exists($modal_template)) {
            include $modal_template;
        }

        // Floating trigger badge
        if (!empty($settings['show_floating_badge'])) {
            $badge_template = IN9_COOKIES_PATH . 'templates/frontend/floating-badge.php';
            if (file_exists($badge_template)) {
                include $badge_template;
            }
        }
    }
}
