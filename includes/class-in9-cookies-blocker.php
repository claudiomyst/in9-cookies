<?php
/**
 * Script Blocker and Tracking Tag Manager
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

final class In9_Cookies_Blocker {

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
     * Initialize blocker hooks.
     */
    public function init(): void {
        $this->settings = in9_cookies_get_settings();

        if (empty($this->settings['enabled'])) {
            return;
        }

        // 1. Google Consent Mode v2 initialization in <head> at priority 1
        if (!empty($this->settings['enable_consent_mode'])) {
            add_action('wp_head', [$this, 'render_consent_mode_v2_snippet'], 1);
        }

        // 2. Render managed tracking scripts (categorized as text/plain)
        add_action('wp_head', [$this, 'render_head_tracking_scripts'], 2);
        add_action('wp_footer', [$this, 'render_footer_custom_scripts'], 99);

        // 3. Shortcode for custom scripts conditional blocking
        add_shortcode('in9_cookie_script', [$this, 'shortcode_cookie_script']);
    }

    /**
     * Injects standard Google Consent Mode v2 default configuration.
     * Starts with all optional consents in 'denied' mode (opt-in requirement).
     */
    public function render_consent_mode_v2_snippet(): void {
        ?>
        <!-- IN9 Cookies — Google Consent Mode v2 Initial State (Prior Consent Default) -->
        <script id="in9-consent-mode-init">
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('consent', 'default', {
                'ad_storage': 'denied',
                'ad_user_data': 'denied',
                'ad_personalization': 'denied',
                'analytics_storage': 'denied',
                'personalization_storage': 'denied',
                'functionality_storage': 'granted',
                'security_storage': 'granted',
                'wait_for_update': 500
            });
        </script>
        <?php
    }

    /**
     * Renders configured tracking tags as blocked text/plain scripts in <head>.
     */
    public function render_head_tracking_scripts(): void {
        // Google Analytics 4
        $ga4_id = trim((string) ($this->settings['ga4_id'] ?? ''));
        if (!empty($ga4_id) && preg_match('/^[A-Za-z0-9_-]+$/', $ga4_id)) {
            $ga4_url = esc_url("https://www.googletagmanager.com/gtag/js?id={$ga4_id}");
            $safe_id = esc_js($ga4_id);
            echo "<!-- IN9 Cookies — Google Analytics 4 (Conditional) -->\n";
            echo "<script type=\"text/plain\" data-in9-category=\"analytics\" data-in9-src=\"{$ga4_url}\" async></script>\n";
            echo "<script type=\"text/plain\" data-in9-category=\"analytics\">\n";
            echo "  window.dataLayer = window.dataLayer || [];\n";
            echo "  function gtag(){dataLayer.push(arguments);}\n";
            echo "  gtag('js', new Date());\n";
            echo "  gtag('config', '{$safe_id}', { 'anonymize_ip': true });\n";
            echo "</script>\n";
        }

        // Google Tag Manager
        $gtm_id = trim((string) ($this->settings['gtm_id'] ?? ''));
        if (!empty($gtm_id) && preg_match('/^[A-Za-z0-9_-]+$/', $gtm_id)) {
            $safe_gtm = esc_js($gtm_id);
            echo "<!-- IN9 Cookies — Google Tag Manager (Conditional) -->\n";
            echo "<script type=\"text/plain\" data-in9-category=\"analytics\">\n";
            echo "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':\n";
            echo "new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],\n";
            echo "j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=\n";
            echo "'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);\n";
            echo "})(window,document,'script','dataLayer','{$safe_gtm}');\n";
            echo "</script>\n";
        }

        // Meta Pixel
        $pixel_id = trim((string) ($this->settings['meta_pixel_id'] ?? ''));
        if (!empty($pixel_id) && preg_match('/^[0-9]+$/', $pixel_id)) {
            $safe_pixel = esc_js($pixel_id);
            echo "<!-- IN9 Cookies — Meta Pixel (Conditional) -->\n";
            echo "<script type=\"text/plain\" data-in9-category=\"marketing\">\n";
            echo "!function(f,b,e,v,n,t,s)\n";
            echo "{if(f.fbq)return;n=f.fbq=function(){n.callMethod?\n";
            echo "n.callMethod.apply(n,arguments):n.queue.push(arguments)};\n";
            echo "if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';\n";
            echo "n.queue=[];t=b.createElement(e);t.async=!0;\n";
            echo "t.src=v;s=b.getElementsByTagName(e)[0];\n";
            echo "s.parentNode.insertBefore(t,s)}(window, document,'script',\n";
            echo "'https://connect.facebook.net/en_US/fbevents.js');\n";
            echo "fbq('init', '{$safe_pixel}');\n";
            echo "fbq('track', 'PageView');\n";
            echo "</script>\n";
        }
    }

    /**
     * Renders custom categorized scripts in <footer>.
     */
    public function render_footer_custom_scripts(): void {
        $categories = ['preferences', 'analytics', 'marketing'];

        foreach ($categories as $cat) {
            $key = "custom_scripts_{$cat}";
            $raw_code = trim((string) ($this->settings[$key] ?? ''));

            if (!empty($raw_code)) {
                echo "\n<!-- IN9 Cookies — Custom Scripts ({$cat}) -->\n";
                // Strip existing <script> tags to wrap cleanly in our controlled container
                $cleaned = preg_replace('/<\/?script[^>]*>/i', '', $raw_code);
                if (!empty($cleaned)) {
                    echo "<script type=\"text/plain\" data-in9-category=\"" . esc_attr($cat) . "\">\n";
                    echo $cleaned . "\n"; // Cleaned code for admin-provided scripts
                    echo "</script>\n";
                }
            }
        }
    }

    /**
     * Shortcode to wrap any custom inline script with consent category.
     * Usage: [in9_cookie_script category="marketing"]...javascript code...[/in9_cookie_script]
     *
     * @param array<string, mixed> $atts
     * @param string|null $content
     * @return string
     */
    public function shortcode_cookie_script($atts, ?string $content = null): string {
        $atts = shortcode_atts([
            'category' => 'analytics',
            'src'      => '',
        ], $atts, 'in9_cookie_script');

        $category = in_array($atts['category'], ['preferences', 'analytics', 'marketing', 'essential'], true)
            ? $atts['category']
            : 'analytics';

        if ($category === 'essential') {
            if (!empty($atts['src'])) {
                return '<script src="' . esc_url($atts['src']) . '"></script>';
            }
            return '<script>' . ($content ?? '') . '</script>';
        }

        $src_attr = !empty($atts['src']) ? ' data-in9-src="' . esc_url($atts['src']) . '"' : '';
        return '<script type="text/plain" data-in9-category="' . esc_attr($category) . '"' . $src_attr . '>' . ($content ?? '') . '</script>';
    }
}
