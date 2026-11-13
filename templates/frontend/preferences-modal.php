<?php
/**
 * Frontend Template: Cookie Preferences Modal
 *
 * @var array<string, mixed> $settings
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$essential_title   = esc_html((string) ($settings['essential_title'] ?? __('Cookies Estritamente Necessários', 'in9-cookies')));
$essential_desc    = esc_html((string) ($settings['essential_desc'] ?? ''));
$preferences_title = esc_html((string) ($settings['preferences_title'] ?? __('Cookies de Preferências', 'in9-cookies')));
$preferences_desc  = esc_html((string) ($settings['preferences_desc'] ?? ''));
$analytics_title   = esc_html((string) ($settings['analytics_title'] ?? __('Cookies Estatísticos e de Desempenho', 'in9-cookies')));
$analytics_desc    = esc_html((string) ($settings['analytics_desc'] ?? ''));
$marketing_title   = esc_html((string) ($settings['marketing_title'] ?? __('Cookies de Marketing e Remarketing', 'in9-cookies')));
$marketing_desc    = esc_html((string) ($settings['marketing_desc'] ?? ''));
$theme             = esc_attr((string) ($settings['theme'] ?? 'light'));
?>
<div id="in9-preferences-modal-wrapper" class="in9-modal-wrapper in9-theme-<?php echo $theme; ?>" style="display: none;" aria-hidden="true">
    <div class="in9-modal-backdrop" id="in9-modal-backdrop" tabindex="-1"></div>

    <div class="in9-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="in9-modal-title" aria-describedby="in9-modal-desc">
        <header class="in9-modal-header">
            <div class="in9-modal-header-text">
                <h2 id="in9-modal-title" class="in9-modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="in9-modal-icon" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <?php echo esc_html__('Central de Preferências de Privacidade', 'in9-cookies'); ?>
                </h2>
                <p id="in9-modal-desc" class="in9-modal-subtitle">
                    <?php echo esc_html__('Gerencie suas autorizações para cada categoria de tecnologia. De acordo com a LGPD e orientações da ANPD, você tem autonomia total para escolher quais dados podem ser coletados durante sua navegação.', 'in9-cookies'); ?>
                </p>
            </div>
            <button type="button" class="in9-modal-close" id="in9-modal-close" aria-label="<?php echo esc_attr__('Fechar modal', 'in9-cookies'); ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </header>

        <div class="in9-modal-body">
            <!-- Categoria 1: Essenciais -->
            <div class="in9-category-card">
                <div class="in9-category-top">
                    <div class="in9-category-info">
                        <div class="in9-category-heading">
                            <h3 class="in9-category-name"><?php echo $essential_title; ?></h3>
                            <span class="in9-badge in9-badge-success"><?php echo esc_html__('Sempre Ativo', 'in9-cookies'); ?></span>
                        </div>
                        <p class="in9-category-desc"><?php echo $essential_desc; ?></p>
                    </div>
                    <div class="in9-toggle-wrapper">
                        <label class="in9-toggle is-disabled" for="in9-cat-essential">
                            <input type="checkbox" id="in9-cat-essential" checked disabled aria-label="<?php echo esc_attr($essential_title); ?>">
                            <span class="in9-toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Categoria 2: Preferências -->
            <div class="in9-category-card">
                <div class="in9-category-top">
                    <div class="in9-category-info">
                        <div class="in9-category-heading">
                            <h3 class="in9-category-name"><?php echo $preferences_title; ?></h3>
                        </div>
                        <p class="in9-category-desc"><?php echo $preferences_desc; ?></p>
                    </div>
                    <div class="in9-toggle-wrapper">
                        <label class="in9-toggle" for="in9-cat-preferences">
                            <input type="checkbox" id="in9-cat-preferences" aria-label="<?php echo esc_attr($preferences_title); ?>">
                            <span class="in9-toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Categoria 3: Estatísticas -->
            <div class="in9-category-card">
                <div class="in9-category-top">
                    <div class="in9-category-info">
                        <div class="in9-category-heading">
                            <h3 class="in9-category-name"><?php echo $analytics_title; ?></h3>
                        </div>
                        <p class="in9-category-desc"><?php echo $analytics_desc; ?></p>
                    </div>
                    <div class="in9-toggle-wrapper">
                        <label class="in9-toggle" for="in9-cat-analytics">
                            <input type="checkbox" id="in9-cat-analytics" aria-label="<?php echo esc_attr($analytics_title); ?>">
                            <span class="in9-toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Categoria 4: Marketing -->
            <div class="in9-category-card">
                <div class="in9-category-top">
                    <div class="in9-category-info">
                        <div class="in9-category-heading">
                            <h3 class="in9-category-name"><?php echo $marketing_title; ?></h3>
                        </div>
                        <p class="in9-category-desc"><?php echo $marketing_desc; ?></p>
                    </div>
                    <div class="in9-toggle-wrapper">
                        <label class="in9-toggle" for="in9-cat-marketing">
                            <input type="checkbox" id="in9-cat-marketing" aria-label="<?php echo esc_attr($marketing_title); ?>">
                            <span class="in9-toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <footer class="in9-modal-footer">
            <div class="in9-modal-actions">
                <button type="button" class="in9-btn in9-btn-primary" id="in9-modal-btn-save">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span><?php echo esc_html__('Salvar minhas preferências', 'in9-cookies'); ?></span>
                </button>
                <button type="button" class="in9-btn in9-btn-secondary" id="in9-modal-btn-accept-all">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <polyline points="20 6 9 17 4 12"></polyline>
                    </svg>
                    <span><?php echo esc_html__('Aceitar todos', 'in9-cookies'); ?></span>
                </button>
                <button type="button" class="in9-btn in9-btn-secondary" id="in9-modal-btn-reject-all">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                    </svg>
                    <span><?php echo esc_html__('Rejeitar opcionais', 'in9-cookies'); ?></span>
                </button>
            </div>
        </footer>
    </div>
</div>
