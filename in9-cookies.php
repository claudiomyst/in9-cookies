<?php
/**
 * Plugin Name: In9 Cookies & LGPD Privacy Manager
 * Plugin URI: https://in9midia.com
 * Description: Gerenciador de Consentimento e Privacidade (CMP) com bloqueio real de scripts, suporte a Google Consent Mode v2 e conformidade com a LGPD e ANPD.
 * Version: 1.0.0
 * Author: IN9 Mídia
 * Author URI: https://in9midia.com
 * Text Domain: in9-cookies
 * Domain Path: /languages
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

// Plugin Constants
define('IN9_COOKIES_VERSION', '1.0.0');
define('IN9_COOKIES_FILE', __FILE__);
define('IN9_COOKIES_PATH', plugin_dir_path(__FILE__));
define('IN9_COOKIES_URL', plugin_dir_url(__FILE__));
define('IN9_COOKIES_BASENAME', plugin_basename(__FILE__));
define('IN9_COOKIES_OPTION_KEY', 'in9_cookies_settings');

// Include required classes
require_once IN9_COOKIES_PATH . 'includes/class-in9-cookies-blocker.php';
require_once IN9_COOKIES_PATH . 'includes/class-in9-cookies-frontend.php';
require_once IN9_COOKIES_PATH . 'includes/class-in9-cookies-admin.php';
require_once IN9_COOKIES_PATH . 'includes/class-in9-cookies.php';

/**
 * Returns default settings for the plugin.
 *
 * @return array<string, mixed>
 */
function in9_cookies_get_default_settings(): array {
    return [
        'enabled'                     => 1,
        'position'                    => 'bottom-right', // 'bottom-right', 'bottom-left', 'bottom-center', 'bottom-bar'
        'theme'                       => 'light',        // 'light', 'dark'
        'banner_title'                => 'Privacidade e Controle de Cookies',
        'banner_text'                 => 'Utilizamos cookies essenciais para garantir o funcionamento do sistema e tecnologias opcionais (como estatísticas e marketing) para aprimorar sua experiência. Você pode aceitar todos, rejeitar os opcionais ou personalizar suas preferências a qualquer momento.',
        'privacy_policy_url'          => '/politica-de-privacidade',
        'privacy_policy_text'         => 'Consulte nossa Política de Privacidade',
        'consent_expiry_days'         => 180,
        'show_floating_badge'         => 1,
        'badge_position'              => 'bottom-left', // 'bottom-left', 'bottom-right'
        
        // Consent Mode v2 & Tracking IDs
        'enable_consent_mode'         => 1,
        'ga4_id'                      => '', // e.g. G-XXXXXXX
        'gtm_id'                      => '', // e.g. GTM-XXXXXXX
        'meta_pixel_id'               => '', // e.g. 1234567890
        
        // Custom Scripts per category
        'custom_scripts_preferences'  => '',
        'custom_scripts_analytics'    => '',
        'custom_scripts_marketing'    => '',

        // Category descriptions
        'essential_title'             => 'Cookies Estritamente Necessários',
        'essential_desc'              => 'Essenciais para o funcionamento do sistema, login de usuários, segurança contra CSRF, integridade de sessões e agendamentos. Não podem ser desativados.',
        'preferences_title'           => 'Cookies de Preferências',
        'preferences_desc'            => 'Permitem lembrar preferências de idioma, tema visual e personalizações de interface para sua próxima visita.',
        'analytics_title'             => 'Cookies Estatísticos e de Desempenho',
        'analytics_desc'              => 'Coletam dados anônimos de navegação para análise de tráfego e melhoria contínua dos serviços (ex: Google Analytics).',
        'marketing_title'             => 'Cookies de Marketing e Remarketing',
        'marketing_desc'              => 'Permitem mensurar conversões de campanhas publicitárias e exibir anúncios relevantes com base no seu interesse (ex: Meta Pixel).',
    ];
}

/**
 * Helper to fetch settings merged with defaults.
 *
 * @return array<string, mixed>
 */
function in9_cookies_get_settings(): array {
    $defaults = in9_cookies_get_default_settings();
    $saved = get_option(IN9_COOKIES_OPTION_KEY, []);
    if (!is_array($saved)) {
        $saved = [];
    }
    return array_merge($defaults, $saved);
}

/**
 * Activation hook callback.
 */
function in9_cookies_activate(): void {
    $current = get_option(IN9_COOKIES_OPTION_KEY, null);
    if ($current === null) {
        add_option(IN9_COOKIES_OPTION_KEY, in9_cookies_get_default_settings(), '', 'yes');
    }
}
register_activation_hook(__FILE__, 'in9_cookies_activate');

/**
 * Initialize Plugin
 */
add_action('plugins_loaded', function () {
    In9_Cookies::instance()->init();
});
