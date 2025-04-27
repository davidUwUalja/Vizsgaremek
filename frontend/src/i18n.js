import { createI18n } from 'vue-i18n';
import { landingMessages } from './i18n/landingTranslator';
import { blogMessages } from './i18n/blogPageTranslator';
import { contactMessages } from './i18n/contactTranslator';
import { productListMessages } from './i18n/productListTranslator';
import { settingsMessages } from './i18n/settingsTranslator';
import { navbarMessages } from './i18n/navbarTranslator';
import { cartCheckoutMessages } from './i18n/CartCheckoutTranslator';
import { cartPanelMessages } from './i18n/CartPanelTranslator';
import { productFilterMessages } from './i18n/productFilterTranslator';
import { wishlistPanelMessages } from './i18n/wishlistPanelTranslator';
import { productDetailsMessages } from './i18n/productDetailsTranslator';
import { loginMessages } from './i18n/loginTranslator';
const messages = {
  hu: {
    ...landingMessages.hu,
    ...blogMessages.hu,
    ...contactMessages.hu,
    ...productListMessages.hu,
    ...settingsMessages.hu,
    ...navbarMessages.hu,
    ...cartCheckoutMessages.hu,
    ...cartPanelMessages.hu,
    ...productFilterMessages.hu,
    ...wishlistPanelMessages.hu,
    ...productDetailsMessages.hu,
    ...loginMessages.hu,
  },
  en: {
    ...landingMessages.en,
    ...blogMessages.en,
    ...contactMessages.en,
    ...productListMessages.en,
    ...settingsMessages.en,
    ...navbarMessages.en,
    ...cartCheckoutMessages.en,
    ...cartPanelMessages.en,
    ...productFilterMessages.en,
    ...wishlistPanelMessages.en,
    ...productDetailsMessages.en,
    ...loginMessages.en,

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