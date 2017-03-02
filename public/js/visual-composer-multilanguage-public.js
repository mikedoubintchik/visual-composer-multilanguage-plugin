(function ($) {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
	 *
	 * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
	 *
	 * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */

    $(function () {

        // Add language toggle example
        // $('body').append('<p id="language-selector"><strong>Change Language To: </strong><a href="#" class="js-lang-option" data-lang-val="English">English</a><a href="#" class="js-lang-option" data-lang-val="Russian">Russian</a><a href="#" class="js-lang-option" data-lang-val="Portuguese">Portuguese</a></p>');

        var $defaultLang = 'English';
        var $languageSelector = $('#language-selector');

        /**
         * Save language to localstorage
         *
         * @param selectedLang
         */
        function saveSelectedLanguage(selectedLang) {
            if (!localStorage.selectedLang) {
                localStorage.selectedLang = $defaultLang;
            } else {
                localStorage.selectedLang = selectedLang;
            }
        }

        /**
         * Return saved language from localstorage or return default language if no localstorage
         *
         * @returns {*}
         */
        function returnSelectedLang() {
            return (localStorage.selectedLang) ? localStorage.selectedLang : $defaultLang;
        }

        /**
         * Toggle language selector
         *
         * @param e
         */
        function toggleLanguageSelector(e) {
            var selectedLang;

            // If language selector is clicked
            if (e) {
                e.preventDefault();
                selectedLang = e.target.dataset.langVal;
            }
            // If this is first page load
            else {
                selectedLang = returnSelectedLang();
            }

            $languageSelector.find('a.js-lang-option').show().end().find('[data-lang-val="' + selectedLang + '"]').hide();

            saveSelectedLanguage(selectedLang);
            toggleTranslatedContent(selectedLang);
        }

        /**
         * Show Translated content
         *
         * @param selectedLang
         */
        function toggleTranslatedContent(selectedLang) {

            // If language selector is clicked
            if (selectedLang) {
                $('body').find('.language').hide().end().find(('[data-lang="' + returnSelectedLang() + '"]')).show();
            }
            // If this is first page load
            else {
                $('body').find('.language').hide().end().find(('[data-lang="' + returnSelectedLang() + '"]')).show();
            }
        }

        /**
         * Bind the UI events
         */
        function bindEvents() {

            // change the selected language
            $languageSelector.on('click', 'a.js-lang-option', toggleLanguageSelector.bind(this));
        }

        // Initialize
        bindEvents();
        toggleLanguageSelector();

    });

})(jQuery);