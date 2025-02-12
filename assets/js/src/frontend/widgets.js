((window) => {
    "use strict";

    const { elementorModules, elementorFrontend, jQuery, _ } = window

    class MaterializorProgress extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    progress: '.mtz-progress',
                }
            }
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors')
            return {
                $progress: this.$element.find(selectors.progress),
            }
        }

        onInit(...args) {
            super.onInit(...args)

            const data = this.elements.$progress.data()

            if (data.incrementer === 'yes') {
                this.addIncrementer(data.incrementerStart, data.incrementerDuration, data.incrementerHide)
            }
            if (data.timeout) {
                this.addTimeout(data.timeout)
            }
        }

        addIncrementer(start, duration, hide) {
            start = Math.min(100, Math.max(0, parseFloat(start) || 0))
            duration = Math.max(1, parseFloat(duration) || 1)
            hide = !this.isEdit && (hide === 'yes' || hide === true)

            const perTick = (100 - start) / (duration * 5)

            const $element = this.$element
            const $progress = this.elements.$progress
            $progress.mtzProgress(start)

            const timer = setInterval(() => {
                if ($progress.mtzProgress() >= 100) {
                    clearInterval(timer)
                    if (hide) {
                        $element.hide()
                        $progress.trigger('progress.hide')
                    }
                } else {
                    $progress.mtzProgress('increment', perTick)
                }
            }, 200)
        }

        addTimeout(timeout) {
            if (this.isEdit) return

            timeout = Math.max(0, parseInt(timeout) || 0)
            if (timeout) {
                const $element = this.$element
                const $progress = this.elements.$progress

                setTimeout(() => {
                    $element.hide()
                    $progress.trigger('progress.hide')
                }, timeout)
            }
        }
    }

    class MaterializorSpinner extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    wrapper: '.mtz-preloader-wrapper',
                }
            }
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors')
            return {
                $wrapper: this.$element.find(selectors.wrapper),
            }
        }

        onInit(...args) {
            super.onInit(...args)

            const data = this.elements.$wrapper.data()
            if (data.timeout) this.addTimeout(data.timeout)
        }

        addTimeout(timeout) {
            if (this.Edit) return

            timeout = Math.max(0, parseInt(timeout) || 0)
            if (timeout) {
                const $element = this.$element
                const $wrapper = this.elements.$wrapper

                setTimeout(() => {
                    $element.hide()
                    $wrapper.trigger('spinner.hide')
                }, timeout)
            }
        }

    }

    class MaterializorChip extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    chip: '.mtz-chip',
                    close: '.mtz-chip .mtz-close'
                }
            }
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors')
            return {
                $chip: this.$element.find(selectors.chip),
                $close: this.$element.find(selectors.close),
            }
        }

        bindEvents() {
            if (!this.isEdit) {
                this.elements.$close.on('click', () => {
                    this.$element.hide()
                    this.elements.$chip.trigger('chip.close')
                })
            }
        }
    }

    class MaterializorCollapsible extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    collapsible: '.mtz-collapsible',
                }
            }
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors')
            return {
                $collapsible: this.$element.find(selectors.collapsible),
            }
        }

        onInit(...args) {
            super.onInit(...args)
            this.elements.$collapsible.mtzCollapsible();
        }
    }

    class MaterializorTabs extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    tabs: 'ul.mtz-tabs',
                }
            }
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors')
            return {
                $tabs: this.$element.find(selectors.tabs),
            }
        }

        onInit(...args) {
            super.onInit(...args)
            this.elements.$tabs.mtzTabs();
        }
    }

    class MaterializorFixedActionButton extends elementorModules.frontend.handlers.Base {
        onInit(...args) {
            super.onInit(...args)
            if (!this.isSingle()) this.$element.mtzFixedActionButton()
        }

        isSingle() {
            return this.$element.find('.mtz-fixed-action-btn.mtz-single').length
        }
    }

    class MaterializorCard extends elementorModules.frontend.handlers.Base {
        getDefaultSettings() {
            return {
                selectors: {
                    card: '.mtz-card',
                    cardImage: '.mtz-card-image'
                }
            }
        }

        getDefaultElements() {
            const selectors = this.getSettings('selectors')
            return {
                $card: this.$element.find(selectors.card),
                $cardImage: this.$element.find(selectors.cardImage),
            }
        }

        onInit(...args) {
            super.onInit(...args)

            const { $card, $cardImage } = this.elements

            if ($cardImage.length && $cardImage.hasClass('mtz-add-activator')) {
                $cardImage.find('img').addClass('mtz-activator')
            }

            this.elements.$card.mtzCard();
        }
    }


    jQuery(window).on("elementor/frontend/init", () => {
        elementorFrontend.elementsHandler.attachHandler("materializor-progress", MaterializorProgress);
        elementorFrontend.elementsHandler.attachHandler("materializor-spinner", MaterializorSpinner);
        elementorFrontend.elementsHandler.attachHandler("materializor-chip", MaterializorChip);
        elementorFrontend.elementsHandler.attachHandler("materializor-collapsible", MaterializorCollapsible);
        elementorFrontend.elementsHandler.attachHandler("materializor-tabs", MaterializorTabs);
        elementorFrontend.elementsHandler.attachHandler("materializor-fixed-action-button", MaterializorFixedActionButton);
        elementorFrontend.elementsHandler.attachHandler("materializor-card", MaterializorCard);
    });

})(window)