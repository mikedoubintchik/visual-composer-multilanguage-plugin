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

    /**
     *
     * Pseudo selector to check for empty selector
     *
     * @param obj
     * @param index
     * @param meta
     * @param stack
     * @returns {boolean}
     */
    $.expr[':'].nocontent = function (obj, index, meta, stack) {
        // obj - is a current DOM element
        // index - the current loop index in stack
        // meta - meta data about your selector
        // stack - stack of all elements to loop

        // Return true to include current element
        // Return false to explude current element
        return !($.trim($(obj).text()).length) && !($(obj).children().length)
    };

    $(function () {

        // Add language toggle example
        // $('body').append('<p id="language-selector"><strong>Change Language To: </strong><a href="#" class="js-lang-option" data-lang-val="English">English</a><a href="#" class="js-lang-option" data-lang-val="Russian">Russian</a><a href="#" class="js-lang-option" data-lang-val="Portuguese">Portuguese</a></p>');

        var $defaultLang = vc.defaultLanguage ? vc.defaultLanguage : 'English';
        var $languageSelector = $('#language-selector');
        var emptyTranslations = $('.vc_row.language .wpb_text_column .wpb_wrapper:nocontent');
        var firstTranslationContent = $('.vc_row.language .wpb_text_column .wpb_wrapper').eq(0).text();
        var firstTranslationLang = $('.vc_row.language .wpb_text_column .wpb_wrapper').eq(0).closest('.language').attr('data-lang');
        var pluginSettings = $('#plugin-settings');
        var googleApiKey = pluginSettings.attr('data-googleapikey');
        var autoTranslateStatus = (pluginSettings.attr('data-autotranslate') === 'autotranslate');
        var styling = (pluginSettings.attr('data-styling') === 'styling');

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
         * Translate all empty contents
         */
        function autoTranslate() {
            var i, language, currentTranslation, sourceLang;
            $.when(getLanguageCodes()).then(function (data) {
                sourceLang = data[firstTranslationLang];

                for (i = 0; i < emptyTranslations.length; i++) {
                    currentTranslation = emptyTranslations.eq(i);
                    language = currentTranslation.closest('.language').attr('data-lang');

                    $.when(translateContent(sourceLang, data[language]), currentTranslation).then(function (resp, currentTranslation) {
                        currentTranslation.text(resp[0].data.translations[0].translatedText);
                    });
                }

            });
        }

        /**
         *
         * Translate content with Google Cloud Translate API
         *
         * @param language
         * @returns {*}
         */
        function translateContent(sourceLang, targetLang, dataToKeep) {
            var df = $.Deferred();
            var url = "https://www.googleapis.com/language/translate/v2/?key=" + googleApiKey;
            url += "&q=" + encodeURI(firstTranslationContent);

            url += "&target=" + targetLang;
            url += "&source=" + sourceLang;

            $.ajax({
                url: url,
                type: "GET",
                data: "",
                dataType: "json",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json"
                }
            }).done(function (resp) {
                df.resolve(resp, dataToKeep);
            });

            return df.promise();
        }

        /**
         * Convert country name to country code
         * @returns {*}
         */
        function getLanguageCodes() {
            return $.getJSON("https://api.myjson.com/bins/v1mod");
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

        // If styling is turned on, add a class to the body
        if (styling) {
            $('body').addClass('multilanguage-styling');
        }

        // If auto translate is turned on, initiate translation
        if (autoTranslateStatus) {
            autoTranslate();
        }

    });

})(jQuery);