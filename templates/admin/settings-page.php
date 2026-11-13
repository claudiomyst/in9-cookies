<?php
/**
 * Admin View: IN9 Cookies Settings
 *
 * @var array<string, mixed> $settings
 * @var string $active_tab
 * @var string $notice
 */

declare(strict_types=1);

if (!defined('ABSPATH')) {
    exit;
}

$valid_tabs = ['general', 'tracking', 'categories', 'guide'];
$active_tab = in_array($active_tab, $valid_tabs, true) ? $active_tab : 'general';
?>
<div class="in9-admin-wrap">
    <!-- Header -->
    <header class="in9-admin-header">
        <div class="in9-admin-header-content">
            <div class="in9-admin-title-group">
                <div class="in9-admin-badge-lgpd">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="m9 12 2 2 4-4"/>
                    </svg>
                    <span>ANPD & LGPD Compliant</span>
                </div>
                <h1 class="in9-admin-title"><?php echo esc_html__('Controle de Cookies e Privacidade', 'in9-cookies'); ?></h1>
                <p class="in9-admin-subtitle">
                    <?php echo esc_html__('Gerenciador de consentimento real (CMP) capaz de controlar a execução de scripts e respeitar as escolhas dos visitantes sem quebrar a plataforma.', 'in9-cookies'); ?>
                </p>
            </div>
        </div>
    </header>

    <!-- Feedback Notice -->
    <?php if ($notice === 'saved') : ?>
        <div class="in9-admin-alert in9-alert-success">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <div>
                <strong><?php echo esc_html__('Configurações salvas com sucesso!', 'in9-cookies'); ?></strong>
                <p><?php echo esc_html__('As diretrizes de consentimento e bloqueio de scripts foram atualizadas.', 'in9-cookies'); ?></p>
            </div>
        </div>
    <?php endif; ?>

    <!-- Navigation Tabs -->
    <div class="in9-admin-tabs-nav">
        <a href="<?php echo esc_url(admin_url('admin.php?page=in9-cookies&tab=general')); ?>"
           class="in9-tab-link <?php echo $active_tab === 'general' ? 'is-active' : ''; ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>
            <?php echo esc_html__('Geral & Exibição', 'in9-cookies'); ?>
        </a>
        <a href="<?php echo esc_url(admin_url('admin.php?page=in9-cookies&tab=tracking')); ?>"
           class="in9-tab-link <?php echo $active_tab === 'tracking' ? 'is-active' : ''; ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"></path><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"></path></svg>
            <?php echo esc_html__('Rastreamento & Tags', 'in9-cookies'); ?>
        </a>
        <a href="<?php echo esc_url(admin_url('admin.php?page=in9-cookies&tab=categories')); ?>"
           class="in9-tab-link <?php echo $active_tab === 'categories' ? 'is-active' : ''; ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
            <?php echo esc_html__('Categorias & Textos', 'in9-cookies'); ?>
        </a>
        <a href="<?php echo esc_url(admin_url('admin.php?page=in9-cookies&tab=guide')); ?>"
           class="in9-tab-link <?php echo $active_tab === 'guide' ? 'is-active' : ''; ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            <?php echo esc_html__('Guia Técnico de Integração', 'in9-cookies'); ?>
        </a>
    </div>

    <!-- Form Section -->
    <?php if ($active_tab !== 'guide') : ?>
        <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="in9-admin-form">
            <?php wp_nonce_field('in9_cookies_save_action', 'in9_cookies_nonce'); ?>
            <input type="hidden" name="action" value="in9_cookies_save_settings">
            <input type="hidden" name="active_tab" value="<?php echo esc_attr($active_tab); ?>">

            <?php if ($active_tab === 'general') : ?>
                <!-- ABA 1: GERAL & EXIBIÇÃO -->
                <div class="in9-admin-card">
                    <div class="in9-card-header">
                        <h2><?php echo esc_html__('Comportamento do Banner e Consentimento', 'in9-cookies'); ?></h2>
                        <p><?php echo esc_html__('Defina as regras de ativação e aparência do aviso inicial no site.', 'in9-cookies'); ?></p>
                    </div>

                    <div class="in9-card-body">
                        <div class="in9-form-row">
                            <label class="in9-checkbox-label" for="in9_enabled">
                                <input type="checkbox" id="in9_enabled" name="enabled" value="1" <?php checked(!empty($settings['enabled'])); ?>>
                                <span class="in9-checkbox-custom"></span>
                                <div>
                                    <strong><?php echo esc_html__('Ativar Gerenciador de Cookies no Frontend', 'in9-cookies'); ?></strong>
                                    <p class="in9-field-hint"><?php echo esc_html__('Quando ativado, o banner será exibido para novos visitantes e scripts não essenciais serão bloqueados até o consentimento.', 'in9-cookies'); ?></p>
                                </div>
                            </label>
                        </div>

                        <div class="in9-grid-3col">
                            <div class="in9-form-group">
                                <label for="in9_position" class="in9-label"><?php echo esc_html__('Posição do Banner', 'in9-cookies'); ?></label>
                                <select id="in9_position" name="position" class="in9-select">
                                    <option value="bottom-right" <?php selected($settings['position'], 'bottom-right'); ?>><?php echo esc_html__('Canto inferior direito (Card flutuante)', 'in9-cookies'); ?></option>
                                    <option value="bottom-left" <?php selected($settings['position'], 'bottom-left'); ?>><?php echo esc_html__('Canto inferior esquerdo (Card flutuante)', 'in9-cookies'); ?></option>
                                    <option value="bottom-center" <?php selected($settings['position'], 'bottom-center'); ?>><?php echo esc_html__('Centro inferior (Card flutuante)', 'in9-cookies'); ?></option>
                                    <option value="bottom-bar" <?php selected($settings['position'], 'bottom-bar'); ?>><?php echo esc_html__('Barra inferior (Largura total)', 'in9-cookies'); ?></option>
                                </select>
                            </div>

                            <div class="in9-form-group">
                                <label for="in9_theme" class="in9-label"><?php echo esc_html__('Tema Visual', 'in9-cookies'); ?></label>
                                <select id="in9_theme" name="theme" class="in9-select">
                                    <option value="light" <?php selected($settings['theme'] ?? 'light', 'light'); ?>><?php echo esc_html__('Claro (Light SaaS)', 'in9-cookies'); ?></option>
                                    <option value="dark" <?php selected($settings['theme'] ?? 'light', 'dark'); ?>><?php echo esc_html__('Escuro (Dark Navy)', 'in9-cookies'); ?></option>
                                </select>
                            </div>

                            <div class="in9-form-group">
                                <label for="in9_consent_expiry_days" class="in9-label"><?php echo esc_html__('Duração do Consentimento (dias)', 'in9-cookies'); ?></label>
                                <input type="number" id="in9_consent_expiry_days" name="consent_expiry_days" min="1" max="365" class="in9-input" value="<?php echo esc_attr((string) $settings['consent_expiry_days']); ?>">
                                <p class="in9-field-hint"><?php echo esc_html__('Recomendação ANPD: revalidar periodicamente (ex: 180 dias / 6 meses).', 'in9-cookies'); ?></p>
                            </div>
                        </div>

                        <div class="in9-form-row in9-divider-top">
                            <label class="in9-checkbox-label" for="in9_show_floating_badge">
                                <input type="checkbox" id="in9_show_floating_badge" name="show_floating_badge" value="1" <?php checked(!empty($settings['show_floating_badge'])); ?>>
                                <span class="in9-checkbox-custom"></span>
                                <div>
                                    <strong><?php echo esc_html__('Exibir Selo Flutuante de Revogação', 'in9-cookies'); ?></strong>
                                    <p class="in9-field-hint"><?php echo esc_html__('Obrigatoriedade ANPD: O usuário deve poder alterar ou revogar seu consentimento a qualquer momento de forma simples.', 'in9-cookies'); ?></p>
                                </div>
                            </label>
                        </div>

                        <div class="in9-grid-2col">
                            <div class="in9-form-group">
                                <label for="in9_badge_position" class="in9-label"><?php echo esc_html__('Posição do Selo Flutuante', 'in9-cookies'); ?></label>
                                <select id="in9_badge_position" name="badge_position" class="in9-select">
                                    <option value="bottom-left" <?php selected($settings['badge_position'], 'bottom-left'); ?>><?php echo esc_html__('Canto inferior esquerdo', 'in9-cookies'); ?></option>
                                    <option value="bottom-right" <?php selected($settings['badge_position'], 'bottom-right'); ?>><?php echo esc_html__('Canto inferior direito', 'in9-cookies'); ?></option>
                                </select>
                            </div>

                            <div class="in9-form-group">
                                <label for="in9_policy_url" class="in9-label"><?php echo esc_html__('URL da Política de Privacidade', 'in9-cookies'); ?></label>
                                <input type="text" id="in9_policy_url" name="privacy_policy_url" class="in9-input" value="<?php echo esc_attr($settings['privacy_policy_url']); ?>" placeholder="/politica-de-privacidade">
                            </div>
                        </div>

                        <div class="in9-form-group">
                            <label for="in9_policy_text" class="in9-label"><?php echo esc_html__('Texto do Link da Política', 'in9-cookies'); ?></label>
                            <input type="text" id="in9_policy_text" name="privacy_policy_text" class="in9-input" value="<?php echo esc_attr($settings['privacy_policy_text']); ?>">
                        </div>

                        <div class="in9-form-group">
                            <label for="in9_banner_title" class="in9-label"><?php echo esc_html__('Título do Banner', 'in9-cookies'); ?></label>
                            <input type="text" id="in9_banner_title" name="banner_title" class="in9-input" value="<?php echo esc_attr($settings['banner_title']); ?>">
                        </div>

                        <div class="in9-form-group">
                            <label for="in9_banner_text" class="in9-label"><?php echo esc_html__('Texto Explicativo do Banner', 'in9-cookies'); ?></label>
                            <textarea id="in9_banner_text" name="banner_text" rows="3" class="in9-textarea"><?php echo esc_textarea($settings['banner_text']); ?></textarea>
                        </div>
                    </div>

                    <div class="in9-card-footer">
                        <button type="submit" class="in9-btn-admin in9-btn-admin-primary">
                            <?php echo esc_html__('Salvar Alterações', 'in9-cookies'); ?>
                        </button>
                    </div>
                </div>

            <?php elseif ($active_tab === 'tracking') : ?>
                <!-- ABA 2: RASTREAMENTO & TAGS -->
                <div class="in9-admin-card">
                    <div class="in9-card-header">
                        <h2><?php echo esc_html__('Gerenciamento de Tags e Google Consent Mode v2', 'in9-cookies'); ?></h2>
                        <p><?php echo esc_html__('Conecte suas ferramentas de análise e anúncios. O plugin assegura que nenhum script seja executado antes da autorização.', 'in9-cookies'); ?></p>
                    </div>

                    <div class="in9-card-body">
                        <div class="in9-form-row">
                            <label class="in9-checkbox-label" for="in9_consent_mode">
                                <input type="checkbox" id="in9_consent_mode" name="enable_consent_mode" value="1" <?php checked(!empty($settings['enable_consent_mode'])); ?>>
                                <span class="in9-checkbox-custom"></span>
                                <div>
                                    <strong><?php echo esc_html__('Ativar Google Consent Mode v2 (Recomendado)', 'in9-cookies'); ?></strong>
                                    <p class="in9-field-hint"><?php echo esc_html__('Inicia parâmetros de medição do Google no modo negado (denied) e atualiza dinamicamente conforme consentimento do usuário.', 'in9-cookies'); ?></p>
                                </div>
                            </label>
                        </div>

                        <div class="in9-grid-3col">
                            <div class="in9-form-group">
                                <label for="in9_ga4_id" class="in9-label"><?php echo esc_html__('Google Analytics 4 (GA4 ID)', 'in9-cookies'); ?></label>
                                <input type="text" id="in9_ga4_id" name="ga4_id" class="in9-input" placeholder="G-XXXXXXXXXX" value="<?php echo esc_attr($settings['ga4_id']); ?>">
                                <p class="in9-field-hint"><?php echo esc_html__('Classificado como Estatísticas.', 'in9-cookies'); ?></p>
                            </div>

                            <div class="in9-form-group">
                                <label for="in9_gtm_id" class="in9-label"><?php echo esc_html__('Google Tag Manager (GTM ID)', 'in9-cookies'); ?></label>
                                <input type="text" id="in9_gtm_id" name="gtm_id" class="in9-input" placeholder="GTM-XXXXXXX" value="<?php echo esc_attr($settings['gtm_id']); ?>">
                                <p class="in9-field-hint"><?php echo esc_html__('Classificado como Estatísticas.', 'in9-cookies'); ?></p>
                            </div>

                            <div class="in9-form-group">
                                <label for="in9_meta_pixel_id" class="in9-label"><?php echo esc_html__('Meta Pixel (Facebook Pixel ID)', 'in9-cookies'); ?></label>
                                <input type="text" id="in9_meta_pixel_id" name="meta_pixel_id" class="in9-input" placeholder="123456789012345" value="<?php echo esc_attr($settings['meta_pixel_id']); ?>">
                                <p class="in9-field-hint"><?php echo esc_html__('Classificado como Marketing.', 'in9-cookies'); ?></p>
                            </div>
                        </div>

                        <div class="in9-divider-top">
                            <h3 class="in9-subheading"><?php echo esc_html__('Scripts Adicionais Categorizados', 'in9-cookies'); ?></h3>
                            <p class="in9-field-hint"><?php echo esc_html__('Cole apenas o código JavaScript (sem as tags <script>). O plugin encapsulará e só executará quando a respectiva categoria for autorizada.', 'in9-cookies'); ?></p>
                        </div>

                        <div class="in9-form-group">
                            <label for="in9_scripts_analytics" class="in9-label"><?php echo esc_html__('Scripts Adicionais — Estatísticas & Desempenho (Analytics)', 'in9-cookies'); ?></label>
                            <textarea id="in9_scripts_analytics" name="custom_scripts_analytics" rows="4" class="in9-textarea in9-code-font" placeholder="// Exemplo: Hotjar, Clarity, etc."><?php echo esc_textarea($settings['custom_scripts_analytics']); ?></textarea>
                        </div>

                        <div class="in9-form-group">
                            <label for="in9_scripts_marketing" class="in9-label"><?php echo esc_html__('Scripts Adicionais — Marketing & Remarketing', 'in9-cookies'); ?></label>
                            <textarea id="in9_scripts_marketing" name="custom_scripts_marketing" rows="4" class="in9-textarea in9-code-font" placeholder="// Exemplo: TikTok Pixel, LinkedIn Insight Tag, etc."><?php echo esc_textarea($settings['custom_scripts_marketing']); ?></textarea>
                        </div>

                        <div class="in9-form-group">
                            <label for="in9_scripts_preferences" class="in9-label"><?php echo esc_html__('Scripts Adicionais — Preferências', 'in9-cookies'); ?></label>
                            <textarea id="in9_scripts_preferences" name="custom_scripts_preferences" rows="3" class="in9-textarea in9-code-font" placeholder="// Exemplo: scripts para salvar layout personalizado, tradutores, etc."><?php echo esc_textarea($settings['custom_scripts_preferences']); ?></textarea>
                        </div>
                    </div>

                    <div class="in9-card-footer">
                        <button type="submit" class="in9-btn-admin in9-btn-admin-primary">
                            <?php echo esc_html__('Salvar Alterações', 'in9-cookies'); ?>
                        </button>
                    </div>
                </div>

            <?php elseif ($active_tab === 'categories') : ?>
                <!-- ABA 3: CATEGORIAS & TEXTOS -->
                <div class="in9-admin-card">
                    <div class="in9-card-header">
                        <h2><?php echo esc_html__('Descrições das Categorias no Modal', 'in9-cookies'); ?></h2>
                        <p><?php echo esc_html__('Textos apresentados na Central de Preferências para orientar o visitante com clareza e transparência.', 'in9-cookies'); ?></p>
                    </div>

                    <div class="in9-card-body">
                        <!-- Essenciais -->
                        <div class="in9-cat-setting-box">
                            <div class="in9-cat-setting-title">
                                <span class="in9-admin-pill in9-pill-success"><?php echo esc_html__('Essencial (Obrigatório)', 'in9-cookies'); ?></span>
                                <input type="text" name="essential_title" class="in9-input" value="<?php echo esc_attr($settings['essential_title']); ?>">
                            </div>
                            <textarea name="essential_desc" rows="2" class="in9-textarea"><?php echo esc_textarea($settings['essential_desc']); ?></textarea>
                        </div>

                        <!-- Preferências -->
                        <div class="in9-cat-setting-box">
                            <div class="in9-cat-setting-title">
                                <span class="in9-admin-pill in9-pill-info"><?php echo esc_html__('Preferências (Opcional)', 'in9-cookies'); ?></span>
                                <input type="text" name="preferences_title" class="in9-input" value="<?php echo esc_attr($settings['preferences_title']); ?>">
                            </div>
                            <textarea name="preferences_desc" rows="2" class="in9-textarea"><?php echo esc_textarea($settings['preferences_desc']); ?></textarea>
                        </div>

                        <!-- Estatísticas -->
                        <div class="in9-cat-setting-box">
                            <div class="in9-cat-setting-title">
                                <span class="in9-admin-pill in9-pill-info"><?php echo esc_html__('Estatísticas (Opcional)', 'in9-cookies'); ?></span>
                                <input type="text" name="analytics_title" class="in9-input" value="<?php echo esc_attr($settings['analytics_title']); ?>">
                            </div>
                            <textarea name="analytics_desc" rows="2" class="in9-textarea"><?php echo esc_textarea($settings['analytics_desc']); ?></textarea>
                        </div>

                        <!-- Marketing -->
                        <div class="in9-cat-setting-box">
                            <div class="in9-cat-setting-title">
                                <span class="in9-admin-pill in9-pill-info"><?php echo esc_html__('Marketing (Opcional)', 'in9-cookies'); ?></span>
                                <input type="text" name="marketing_title" class="in9-input" value="<?php echo esc_attr($settings['marketing_title']); ?>">
                            </div>
                            <textarea name="marketing_desc" rows="2" class="in9-textarea"><?php echo esc_textarea($settings['marketing_desc']); ?></textarea>
                        </div>
                    </div>

                    <div class="in9-card-footer">
                        <button type="submit" class="in9-btn-admin in9-btn-admin-primary">
                            <?php echo esc_html__('Salvar Alterações', 'in9-cookies'); ?>
                        </button>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    <?php else : ?>
        <!-- ABA 4: GUIA TÉCNICO & DESENVOLVEDOR -->
        <div class="in9-admin-card">
            <div class="in9-card-header">
                <h2><?php echo esc_html__('Como Integrar Tecnologias e Scripts ao CMP', 'in9-cookies'); ?></h2>
                <p><?php echo esc_html__('Instruções para desenvolvedores garantirem que novos recursos do tema ou plugins respeitem o consentimento.', 'in9-cookies'); ?></p>
            </div>

            <div class="in9-card-body in9-guide-body">
                <div class="in9-guide-section">
                    <h3>1. Bloqueio Manual no HTML/PHP</h3>
                    <p>Para impedir a execução automática de um script sem depender do recarregamento de página, substitua o atributo <code>type="text/javascript"</code> por <code>type="text/plain"</code> e adicione <code>data-in9-category="SUA_CATEGORIA"</code>:</p>
                    <pre class="in9-code-block"><code>&lt;!-- Script bloqueado até consentimento de marketing --&gt;
&lt;script type="text/plain" data-in9-category="marketing" data-in9-src="https://exemplo.com/pixel.js"&gt;&lt;/script&gt;
&lt;script type="text/plain" data-in9-category="marketing"&gt;
    console.log('Script de marketing liberado pelo visitante!');
&lt;/script&gt;</code></pre>
                </div>

                <div class="in9-guide-section">
                    <h3>2. Verificação via JavaScript (API Global)</h3>
                    <p>Qualquer script pode checar se determinada tecnologia tem autorização ativa antes de registrar cookies:</p>
                    <pre class="in9-code-block"><code>if (window.in9Cookies &amp;&amp; window.in9Cookies.hasConsent('analytics')) {
    // Coletar métrica customizada
}</code></pre>
                </div>

                <div class="in9-guide-section">
                    <h3>3. Ouvinte de Atualização de Consentimento (Eventos)</h3>
                    <p>Reaja em tempo real quando o usuário aceitar ou alterar escolhas na tela:</p>
                    <pre class="in9-code-block"><code>window.addEventListener('in9_cookie_consent_updated', function(event) {
    console.log('Novo consentimento:', event.detail.categories);
});</code></pre>
                </div>

                <div class="in9-guide-section">
                    <h3>4. Link no Rodapé do Site para Reabrir a Central de Preferências</h3>
                    <p>Adicione em qualquer link do rodapé do tema o atributo <code>data-in9-cookies-open</code>:</p>
                    <pre class="in9-code-block"><code>&lt;a href="#" data-in9-cookies-open&gt;Preferências de Cookies e Privacidade&lt;/a&gt;</code></pre>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
