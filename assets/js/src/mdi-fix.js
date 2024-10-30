((jQuery) => {
    "use strict";

    jQuery(() => {
        setInterval(() => {
            jQuery('i.material-icons[class*="mdi-"]:not(.touched)')
                .each(function () {
                    const $this = jQuery(this)
                    const match = $this.attr('class').match(/mdi-(?<icon>[\w-]+)/)
                    if (match) $this.html(match.groups.icon.replace(/-/g, '_'))
                    $this.addClass('touched')
                })
        }, 300)
    })
})(jQuery)