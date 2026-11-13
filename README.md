# IN9 Cookies & LGPD Privacy Manager

[![WordPress Version](https://img.shields.io/badge/WordPress-6.0%2B-blue.svg)](https://wordpress.org)
[![PHP Version](https://img.shields.io/badge/PHP-8.0%2B-777bb4.svg)](https://php.net)
[![LGPD & ANPD](https://img.shields.io/badge/ANPD%20%26%20LGPD-Compliant-success.svg)](https://www.gov.br/anpd/pt-br)
[![Google Consent Mode](https://img.shields.io/badge/Google%20Consent%20Mode-v2-orange.svg)](https://developers.google.com/tag-platform/security/guides/consent)

> **Gerenciador de Consentimento e Privacidade (CMP)** profissional para WordPress e plataformas SaaS, com bloqueio real de scripts em tempo de execução, suporte nativo ao Google Consent Mode v2 e conformidade estrita com a LGPD e as orientações da ANPD.

Recusar cookies em um site **não deve interromper o funcionamento da plataforma**. O **IN9 Cookies** garante que cookies essenciais (sessão, login, integridade CSRF, carrinho e agendamentos) continuem operando normalmente, enquanto ferramentas opcionais de estatísticas e marketing são bloqueadas até que o visitante conceda autorização explícita.

---

## 🚀 Principais Recursos

- **Conformidade ANPD (Consentimento Prévio / Opt-in)**: Scripts e cookies de rastreamento não essenciais iniciam bloqueados por padrão.
- **Bloqueio Real de Scripts**: Scripts de terceiros iniciam como `type="text/plain"` e são executados dinamicamente na página no instante do aceite, sem necessidade de recarregamento.
- **Google Consent Mode v2 Nativo**: Define parâmetros como `denied` no `<head>` (`analytics_storage`, `ad_storage`, etc.) e emite `gtag('consent', 'update')` dinamicamente conforme a decisão do usuário.
- **4 Categorias Granulares**:
  - **Essenciais (Obrigatório)**: Sessão, segurança, login e integridade. Sempre ativo e protegido contra desativação.
  - **Preferências (Opcional)**: Idioma, personalizações e preferências de interface.
  - **Estatísticas / Desempenho (Opcional)**: Google Analytics 4, GTM e métricas de tráfego.
  - **Marketing & Remarketing (Opcional)**: Meta Pixel, campanhas e anúncios personalizados.
- **Design System Moderno**:
  - **Temas**: Claro (*Light SaaS*) e Escuro (*Dark Navy* com gradiente radial).
  - **Posicionamento Flexível**: Canto inferior direito, Canto inferior esquerdo, Centro inferior (Card flutuante) e Barra inferior (Largura total).
  - **Botões com Ícones SVG**: Ações visuais claras com ícones dedicados (*Aceitar todos*, *Rejeitar opcionais*, *Personalizar*).
- **Revogação Fácil a Qualquer Momento**: Selo flutuante inteligente (*Floating Badge*) posicionado nas margens da tela com expansão lateral para dentro, sem cortar o texto.
- **API JavaScript Global & Eventos**: Acesso via `window.in9Cookies` e escuta do evento customizado `in9_cookie_consent_updated`.
- **Acessibilidade & Responsividade (A11y)**: Navegação por teclado, captura de foco no modal, tecla `Esc` e versão adaptada para mobile em formato *bottom-sheet* com alvos de toque mínimos de 44px.

---

## 📁 Estrutura de Pastas

```text
in9-cookies/
├── in9-cookies.php                         # Arquivo principal do plugin (Bootstrap)
├── README.md                               # Documentação do projeto
├── includes/
│   ├── class-in9-cookies.php               # Coordenador principal
│   ├── class-in9-cookies-admin.php         # Painel administrativo e sanitização
│   ├── class-in9-cookies-blocker.php       # Injeção, bloqueio e Consent Mode v2
│   └── class-in9-cookies-frontend.php      # Renderização de templates e scripts
├── assets/
│   ├── css/
│   │   ├── in9-cookies-admin.css           # Estilo do admin
│   │   ├── in9-cookies-admin.min.css       # Versão minificada do admin
│   │   ├── in9-cookies-frontend.css        # Estilo do banner, modal e selo
│   │   └── in9-cookies-frontend.min.css    # Versão minificada do frontend
│   └── js/
│       ├── in9-cookies-admin.js            # JavaScript do admin
│       ├── in9-cookies-admin.min.js        # Versão minificada do JS admin
│       ├── in9-cookies-cmp.js              # Motor CMP (Universal ES5)
│       └── in9-cookies-cmp.min.js          # Versão minificada do CMP
└── templates/
    ├── admin/
    │   └── settings-page.php               # Painel de configurações com abas
    └── frontend/
        ├── banner.php                      # Banner inicial de consentimento
        ├── floating-badge.php              # Selo flutuante de privacidade
        └── preferences-modal.php           # Central de preferências de cookies
```

---

## 🛠️ Instalação e Ativação

1. Clone ou copie a pasta `in9-cookies` para o diretório de plugins do seu WordPress:
   ```bash
   wp-content/plugins/in9-cookies
   ```
2. Acesse o painel do WordPress em **Plugins** e clique em **Ativar** no **IN9 Cookies & LGPD Privacy Manager**.
3. Acesse o menu lateral **Cookies & LGPD** para configurar o banner e inserir seus IDs de rastreamento.

---

## ⚙️ Configurações do Painel

No menu **Cookies & LGPD**, você encontrará 4 abas de configuração:

1. **Geral & Exibição**:
   - Ativação do banner.
   - Posição do Banner (Direita, Esquerda, Centro flutuante ou Barra total).
   - Tema Visual (Claro ou Escuro).
   - Duração da validade do consentimento (ex: 180 dias).
   - Exibição e posição do Selo Flutuante de revogação.
   - URL e texto do link da Política de Privacidade.
2. **Rastreamento & Tags**:
   - Google Consent Mode v2 (Ativado por padrão).
   - ID do Google Analytics 4 (`G-XXXXXXXXXX`).
   - ID do Google Tag Manager (`GTM-XXXXXXX`).
   - ID do Meta Pixel (`123456789012345`).
   - Campos de texto para scripts adicionais por categoria.
3. **Categorias & Textos**:
   - Edição de títulos e descrições das 4 categorias de cookies apresentadas no modal.
4. **Guia Técnico de Integração**:
   - Exemplos rápidos de código para desenvolvedores de temas e plugins.

---

## 💻 Guia Técnico para Desenvolvedores

### 1. Bloqueando scripts de terceiros manualmente no HTML/PHP
Substitua `type="text/javascript"` por `type="text/plain"` e informe a categoria no atributo `data-in9-category`:

```html
<!-- Script bloqueado até que o visitante autorize Marketing -->
<script type="text/plain" data-in9-category="marketing" data-in9-src="https://exemplo.com/pixel.js"></script>
<script type="text/plain" data-in9-category="marketing">
    console.log('Script de marketing liberado pelo visitante!');
</script>
```

### 2. Verificando consentimento via JavaScript (API Global)
```javascript
if (window.in9Cookies && window.in9Cookies.hasConsent('analytics')) {
    // Coletar métrica customizada de estatísticas
}
```

### 3. Ouvinte de eventos em tempo real
Reaja imediatamente quando o visitante aceitar, rejeitar ou alterar as preferências:
```javascript
window.addEventListener('in9_cookie_consent_updated', function (event) {
    console.log('Categorias atualizadas:', event.detail.categories);
    // Exemplo: { essential: true, preferences: false, analytics: true, marketing: false }
});
```

### 4. Link no rodapé do tema para abrir o modal de preferências
Adicione o atributo `data-in9-cookies-open` em qualquer link ou botão do seu tema:
```html
<a href="#" data-in9-cookies-open>Preferências de Privacidade e Cookies</a>
```

### 5. Shortcode do WordPress
```text
[in9_cookie_script category="marketing"]
    console.log("Rastreamento de conversão executado!");
[/in9_cookie_script]
```

---

## 🔒 Segurança & Boas Práticas

- Sanitização e validação de todos os dados de entrada no servidor (`sanitize_text_field`, `esc_url_raw`).
- Proteção contra ataques CSRF via verificação de Nonces em todas as requisições de salvamento.
- Verificação de capacidade do usuário (`current_user_can('manage_options')`).
- Código JavaScript universal em conformidade com **ES5**, compatível com qualquer minificador e navegador.

---

## 📄 Licença

Desenvolvido por **IN9 Mídia**. Distribuído sob a licença [GPL-2.0-or-later](https://www.gnu.org/licenses/gpl-2.0.html).
