<?php
/**
 * Frontend Template: Floating Privacy Trigger Badge
 *
 * @var array<string, mixed> $settings
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$badge_position = esc_attr((string) ($settings['badge_position'] ?? 'bottom-left'));
?>
<button type="button" id="in9-cookie-trigger-badge" class="in9-cookie-trigger-badge in9-badge-pos-<?php echo $badge_position; ?>" aria-label="<?php echo esc_attr__('Gerenciar preferências de cookies e privacidade', 'in9-cookies'); ?>" title="<?php echo esc_attr__('Preferências de Privacidade e Cookies', 'in9-cookies'); ?>">
    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
        <path d="m9 12 2 2 4-4"/>
    </svg>
    <span class="in9-badge-tooltip"><?php echo esc_html__('Privacidade e cookies', 'in9-cookies'); ?></span>
</button>
