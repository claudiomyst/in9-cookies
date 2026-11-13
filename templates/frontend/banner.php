<?php
/**
 * Frontend Template: Cookie Consent Banner
 *
 * @var array<string, mixed> $settings
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$position = esc_attr((string) ($settings['position'] ?? 'bottom-right'));
$theme    = esc_attr((string) ($settings['theme'] ?? 'light'));
$title    = esc_html((string) ($settings['banner_title'] ?? __('Privacidade e Controle de Cookies', 'in9-cookies')));
$text     = esc_html((string) ($settings['banner_text'] ?? ''));
$policy_url  = esc_url((string) ($settings['privacy_policy_url'] ?? ''));
$policy_text = esc_html((string) ($settings['privacy_policy_text'] ?? __('Consulte nossa Política de Privacidade', 'in9-cookies')));
?>
<aside id="in9-cookies-banner" class="in9-cookies-banner in9-pos-<?php echo $position; ?> in9-theme-<?php echo $theme; ?>" role="region" aria-label="<?php echo esc_attr__('Aviso de Privacidade e Cookies', 'in9-cookies'); ?>" style="display: none;">
    <div class="in9-banner-content">
        <div class="in9-banner-header">
            <span class="in9-banner-icon" aria-hidden="true">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    <path d="m9 12 2 2 4-4"/>
                </svg>
            </span>
            <h3 class="in9-banner-title"><?php echo $title; ?></h3>
        </div>

        <div class="in9-banner-body">
            <p class="in9-banner-description">
                <?php echo $text; ?>
                <?php if (!empty($policy_url)) : ?>
                    <a href="<?php echo $policy_url; ?>" class="in9-banner-link" target="_blank" rel="noopener noreferrer">
                        <?php echo $policy_text; ?>
                    </a>
                <?php endif; ?>
            </p>
        </div>

        <div class="in9-banner-actions">
            <button type="button" class="in9-btn in9-btn-primary" id="in9-btn-accept-all">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
                <span><?php echo esc_html__('Aceitar todos', 'in9-cookies'); ?></span>
            </button>
            <button type="button" class="in9-btn in9-btn-secondary" id="in9-btn-reject-all">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                </svg>
                <span><?php echo esc_html__('Rejeitar opcionais', 'in9-cookies'); ?></span>
            </button>
            <button type="button" class="in9-btn in9-btn-secondary" id="in9-btn-customize">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <line x1="4" y1="21" x2="4" y2="14"></line>
                    <line x1="4" y1="10" x2="4" y2="3"></line>
                    <line x1="12" y1="21" x2="12" y2="12"></line>
                    <line x1="12" y1="8" x2="12" y2="3"></line>
                    <line x1="20" y1="21" x2="20" y2="16"></line>
                    <line x1="20" y1="12" x2="20" y2="3"></line>
                    <line x1="1" y1="14" x2="7" y2="14"></line>
                    <line x1="9" y1="8" x2="15" y2="8"></line>
                    <line x1="17" y1="16" x2="23" y2="16"></line>
                </svg>
                <span><?php echo esc_html__('Personalizar', 'in9-cookies'); ?></span>
            </button>
        </div>
    </div>
</aside>
