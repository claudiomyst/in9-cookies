/**
 * IN9 Cookies — Consent Management Platform (CMP) Frontend Engine
 * Compliance with LGPD, ANPD guidelines and Google Consent Mode v2.
 */

(function () {
    'use strict';

    // Retrieve localized configuration or fallback
    var config = window.in9CookiesConfig || {
        cookieName: 'in9_cookie_consent',
        cookieExpiryDays: 180,
        enableConsentMode: true,
        bannerPosition: 'bottom-right',
        badgePosition: 'bottom-left',
        showFloatingBadge: true,
        i18n: {
            preferencesSaved: 'Preferências de privacidade salvas com sucesso!',
            allAccepted: 'Todos os cookies foram autorizados.',
            nonEssentialRejected: 'Apenas os cookies essenciais foram mantidos.',
        }
    };

    var activeTriggerElement = null;

    /**
     * Cookie Helpers
     */
    var CookieUtil = {
        get: function (name) {
            var matches = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + '=([^;]*)'));
            return matches ? decodeURIComponent(matches[1]) : null;
        },
        set: function (name, value, days) {
            var maxAge = days * 24 * 60 * 60;
            var cookieString = encodeURIComponent(name) + '=' + encodeURIComponent(value) +
                '; path=/; max-age=' + maxAge + '; SameSite=Lax';

            if (window.location.protocol === 'https:') {
                cookieString += '; Secure';
            }
            document.cookie = cookieString;
        },
        remove: function (name) {
            document.cookie = encodeURIComponent(name) + '=; path=/; max-age=0; SameSite=Lax';
        }
    };

    /**
     * Storage Manager (LocalStorage with Cookie fallback/sync)
     */
    var ConsentStorage = {
        load: function () {
            var data = null;
            try {
                var local = localStorage.getItem(config.cookieName);
                if (local) {
                    data = JSON.parse(local);
                }
            } catch (e) {
                // Ignore localStorage errors
            }

            if (!data) {
                var cookieVal = CookieUtil.get(config.cookieName);
                if (cookieVal) {
                    try {
                        data = JSON.parse(cookieVal);
                    } catch (e) {
                        // Ignore parsing errors
                    }
                }
            }

            // Validate format
            if (data && typeof data === 'object' && data.categories) {
                return data;
            }
            return null;
        },
        save: function (categories) {
            var payload = {
                version: '1.0',
                timestamp: Math.floor(Date.now() / 1000),
                categories: {
                    essential: true, // Always true
                    preferences: Boolean(categories.preferences),
                    analytics: Boolean(categories.analytics),
                    marketing: Boolean(categories.marketing)
                }
            };

            var json = JSON.stringify(payload);

            try {
                localStorage.setItem(config.cookieName, json);
            } catch (e) {
                // Ignore storage errors
            }

            CookieUtil.set(config.cookieName, json, config.cookieExpiryDays || 180);
            return payload;
        },
        clear: function () {
            try {
                localStorage.removeItem(config.cookieName);
            } catch (e) {}
            CookieUtil.remove(config.cookieName);
        }
    };

    /**
     * Google Consent Mode v2 Integrator
     */
    var ConsentMode = {
        update: function (categories) {
            if (!config.enableConsentMode) {
                return;
            }

            window.dataLayer = window.dataLayer || [];
            function gtag() {
                window.dataLayer.push(arguments);
            }

            var consentUpdate = {
                'analytics_storage': categories.analytics ? 'granted' : 'denied',
                'ad_storage': categories.marketing ? 'granted' : 'denied',
                'ad_user_data': categories.marketing ? 'granted' : 'denied',
                'ad_personalization': categories.marketing ? 'granted' : 'denied',
                'personalization_storage': categories.preferences ? 'granted' : 'denied',
                'functionality_storage': 'granted',
                'security_storage': 'granted'
            };

            gtag('consent', 'update', consentUpdate);
        }
    };

    /**
     * Dynamic Script Blocker & Activator
     */
    var ScriptManager = {
        activateCategory: function (category) {
            if (!category) return;

            // Find all plain text scripts tagged with this category
            var scripts = document.querySelectorAll('script[type="text/plain"][data-in9-category="' + category + '"]');

            scripts.forEach(function (script) {
                if (script.getAttribute('data-in9-executed') === 'true') {
                    return;
                }

                var newScript = document.createElement('script');
                newScript.type = 'text/javascript';

                // Copy attributes
                var src = script.getAttribute('data-in9-src');
                if (src) {
                    newScript.src = src;
                } else if (script.src) {
                    newScript.src = script.src;
                }

                if (script.id) newScript.id = script.id;
                if (script.className) newScript.className = script.className;
                if (script.hasAttribute('async')) newScript.async = true;
                if (script.hasAttribute('defer')) newScript.defer = true;

                // Inline code
                if (!newScript.src) {
                    newScript.textContent = script.textContent || script.innerHTML;
                }

                newScript.setAttribute('data-in9-loaded-by', 'in9-cookies');
                script.setAttribute('data-in9-executed', 'true');

                // Append new script to DOM
                if (script.parentNode) {
                    script.parentNode.insertBefore(newScript, script.nextSibling);
                } else {
                    document.head.appendChild(newScript);
                }
            });
        },
        applyConsents: function (categories) {
            if (!categories) return;
            if (categories.preferences) this.activateCategory('preferences');
            if (categories.analytics) this.activateCategory('analytics');
            if (categories.marketing) this.activateCategory('marketing');
        }
    };

    /**
     * UI Controller
     */
    var UI = {
        banner: null,
        modalWrapper: null,
        badge: null,
        toastTimeout: null,

        init: function () {
            this.banner = document.getElementById('in9-cookies-banner');
            this.modalWrapper = document.getElementById('in9-preferences-modal-wrapper');
            this.badge = document.getElementById('in9-cookie-trigger-badge');

            this.bindEvents();
        },

        showBanner: function () {
            if (this.banner) {
                this.banner.style.display = 'block';
            }
        },

        hideBanner: function () {
            if (this.banner) {
                this.banner.style.display = 'none';
            }
        },

        openModal: function (triggerEl) {
            activeTriggerElement = triggerEl || document.activeElement;

            // Reflect current saved consent state in toggles
            var currentConsent = ConsentStorage.load();
            var cats = currentConsent ? currentConsent.categories : { preferences: false, analytics: false, marketing: false };

            var prefToggle = document.getElementById('in9-cat-preferences');
            var analToggle = document.getElementById('in9-cat-analytics');
            var markToggle = document.getElementById('in9-cat-marketing');

            if (prefToggle) prefToggle.checked = Boolean(cats.preferences);
            if (analToggle) analToggle.checked = Boolean(cats.analytics);
            if (markToggle) markToggle.checked = Boolean(cats.marketing);

            if (this.modalWrapper) {
                this.modalWrapper.style.display = 'flex';
                this.modalWrapper.setAttribute('aria-hidden', 'false');
                document.body.classList.add('in9-modal-open');

                // Set focus to close button
                var closeBtn = document.getElementById('in9-modal-close');
                if (closeBtn) closeBtn.focus();
            }
        },

        closeModal: function () {
            if (this.modalWrapper) {
                this.modalWrapper.style.display = 'none';
                this.modalWrapper.setAttribute('aria-hidden', 'true');
                document.body.classList.remove('in9-modal-open');

                if (activeTriggerElement && typeof activeTriggerElement.focus === 'function') {
                    activeTriggerElement.focus();
                }
            }
        },

        showToast: function (message) {
            var toast = document.getElementById('in9-toast');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'in9-toast';
                toast.className = 'in9-toast';
                document.body.appendChild(toast);
            }

            toast.textContent = message;
            toast.classList.add('is-visible');

            if (this.toastTimeout) {
                clearTimeout(this.toastTimeout);
            }

            this.toastTimeout = setTimeout(function () {
                toast.classList.remove('is-visible');
            }, 3500);
        },

        bindEvents: function () {
            var self = this;

            // Banner Actions
            var btnAcceptAll = document.getElementById('in9-btn-accept-all');
            if (btnAcceptAll) {
                btnAcceptAll.addEventListener('click', function () {
                    CMP.acceptAll();
                });
            }

            var btnRejectAll = document.getElementById('in9-btn-reject-all');
            if (btnRejectAll) {
                btnRejectAll.addEventListener('click', function () {
                    CMP.rejectNonEssential();
                });
            }

            var btnCustomize = document.getElementById('in9-btn-customize');
            if (btnCustomize) {
                btnCustomize.addEventListener('click', function (e) {
                    self.openModal(e.currentTarget);
                });
            }

            // Modal Actions
            var modalClose = document.getElementById('in9-modal-close');
            if (modalClose) {
                modalClose.addEventListener('click', function () {
                    self.closeModal();
                });
            }

            var modalBackdrop = document.getElementById('in9-modal-backdrop');
            if (modalBackdrop) {
                modalBackdrop.addEventListener('click', function () {
                    self.closeModal();
                });
            }

            var modalBtnSave = document.getElementById('in9-modal-btn-save');
            if (modalBtnSave) {
                modalBtnSave.addEventListener('click', function () {
                    CMP.saveCustomPreferences();
                });
            }

            var modalBtnAcceptAll = document.getElementById('in9-modal-btn-accept-all');
            if (modalBtnAcceptAll) {
                modalBtnAcceptAll.addEventListener('click', function () {
                    CMP.acceptAll();
                });
            }

            var modalBtnRejectAll = document.getElementById('in9-modal-btn-reject-all');
            if (modalBtnRejectAll) {
                modalBtnRejectAll.addEventListener('click', function () {
                    CMP.rejectNonEssential();
                });
            }

            // Floating Trigger Badge
            if (this.badge) {
                this.badge.addEventListener('click', function (e) {
                    self.openModal(e.currentTarget);
                });
            }

            // Global trigger selector support for themes/custom links: [data-in9-cookies-open]
            document.addEventListener('click', function (e) {
                var trigger = e.target.closest('[data-in9-cookies-open]');
                if (trigger) {
                    e.preventDefault();
                    self.openModal(trigger);
                }
            });

            // Accessibility: Escape key and Focus trapping in modal
            document.addEventListener('keydown', function (e) {
                if (self.modalWrapper && self.modalWrapper.style.display === 'flex') {
                    if (e.key === 'Escape' || e.keyCode === 27) {
                        self.closeModal();
                    } else if (e.key === 'Tab' || e.keyCode === 9) {
                        // Focus trap
                        var focusables = self.modalWrapper.querySelectorAll('button:not([disabled]), input:not([disabled]), [tabindex]:not([tabindex="-1"])');
                        if (focusables.length === 0) return;

                        var first = focusables[0];
                        var last = focusables[focusables.length - 1];

                        if (e.shiftKey) {
                            if (document.activeElement === first) {
                                e.preventDefault();
                                last.focus();
                            }
                        } else {
                            if (document.activeElement === last) {
                                e.preventDefault();
                                first.focus();
                            }
                        }
                    }
                }
            });
        }
    };

    /**
     * Main CMP Coordinator
     */
    var CMP = {
        init: function () {
            UI.init();

            var savedConsent = ConsentStorage.load();

            if (savedConsent) {
                // Apply stored preferences immediately
                ScriptManager.applyConsents(savedConsent.categories);
                ConsentMode.update(savedConsent.categories);
                UI.hideBanner();
            } else {
                // Prior consent required: show banner, wait for decision
                UI.showBanner();
            }
        },

        acceptAll: function () {
            var consent = ConsentStorage.save({
                preferences: true,
                analytics: true,
                marketing: true
            });

            ScriptManager.applyConsents(consent.categories);
            ConsentMode.update(consent.categories);

            UI.hideBanner();
            UI.closeModal();
            UI.showToast(config.i18n.allAccepted);

            this.dispatchConsentEvent(consent);
        },

        rejectNonEssential: function () {
            var consent = ConsentStorage.save({
                preferences: false,
                analytics: false,
                marketing: false
            });

            // Do not execute optional scripts
            ConsentMode.update(consent.categories);

            UI.hideBanner();
            UI.closeModal();
            UI.showToast(config.i18n.nonEssentialRejected);

            this.dispatchConsentEvent(consent);
        },

        saveCustomPreferences: function () {
            var prefToggle = document.getElementById('in9-cat-preferences');
            var analToggle = document.getElementById('in9-cat-analytics');
            var markToggle = document.getElementById('in9-cat-marketing');

            var choices = {
                preferences: prefToggle ? prefToggle.checked : false,
                analytics: analToggle ? analToggle.checked : false,
                marketing: markToggle ? markToggle.checked : false
            };

            var consent = ConsentStorage.save(choices);

            ScriptManager.applyConsents(consent.categories);
            ConsentMode.update(consent.categories);

            UI.hideBanner();
            UI.closeModal();
            UI.showToast(config.i18n.preferencesSaved);

            this.dispatchConsentEvent(consent);
        },

        dispatchConsentEvent: function (consent) {
            var event = new CustomEvent('in9_cookie_consent_updated', {
                detail: consent
            });
            window.dispatchEvent(event);
            document.dispatchEvent(event);
        },

        hasConsent: function (category) {
            if (category === 'essential') return true;
            var consent = ConsentStorage.load();
            if (!consent || !consent.categories) return false;
            return Boolean(consent.categories[category]);
        },

        getConsent: function () {
            return ConsentStorage.load();
        },

        resetConsent: function () {
            ConsentStorage.clear();
            window.location.reload();
        }
    };

    // Public API exposed on window.in9Cookies
    window.in9Cookies = {
        hasConsent: function (category) {
            return CMP.hasConsent(category);
        },
        getConsent: function () {
            return CMP.getConsent();
        },
        acceptAll: function () {
            CMP.acceptAll();
        },
        rejectNonEssential: function () {
            CMP.rejectNonEssential();
        },
        openPreferences: function () {
            UI.openModal();
        },
        closePreferences: function () {
            UI.closeModal();
        },
        resetConsent: function () {
            CMP.resetConsent();
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            CMP.init();
        });
    } else {
        CMP.init();
    }
})();
