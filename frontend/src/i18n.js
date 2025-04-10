import { createI18n } from 'vue-i18n';
import { landingMessages } from './i18n/landingTranslator';
import { blogMessages } from './i18n/blogPageTranslator';
import { contactMessages } from './i18n/contactTranslator';
import { productListMessages } from './i18n/productListTranslator';
import { settingsMessages } from './i18n/settingsTranslator';
import { navbarMessages } from './i18n/navbarTranslator';

const messages = {
  hu: {
    ...landingMessages.hu,
    ...blogMessages.hu,
    ...contactMessages.hu,
    ...productListMessages.hu,
    ...settingsMessages.hu,
    ...navbarMessages.hu,
  },
  en: {
    ...landingMessages.en,
    ...blogMessages.en,
    ...contactMessages.en,
    ...productListMessages.en,
    ...settingsMessages.en,
    ...navbarMessages.en,
  },
  de: {
    ...landingMessages.de,
    ...blogMessages.de,
    ...contactMessages.de,
    ...productListMessages.de,
    ...settingsMessages.de,
    ...navbarMessages.de,
  }
  
};

const i18n = createI18n({
  locale: 'hu', // Default language
  fallbackLocale: 'en',
  messages,
});

export default i18n;