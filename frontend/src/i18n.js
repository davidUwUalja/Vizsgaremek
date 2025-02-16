import { createI18n } from 'vue-i18n';

const messages = {
  hu: {
    language: "Nyelv",
    welcome: 'Üdvözlünk a Főoldalon!',
    browse: 'Böngéssz termékeink között, vagy vedd fel velünk a kapcsolatot!',
    viewProducts: 'Termékek megtekintése',
    
  },
  en: {
    language: "Language",
    welcome: 'Welcome to the Homepage!',
    browse: 'Browse our products or get in touch with us!',
    viewProducts: 'View Products',
  },

  de: {
    language: "Sprache",
    welcome: 'Herzlich Willkommen auf der Homepage!',
    browse: 'Browse our products or get in touch with us!',
    viewProducts: 'View Products',
  }
};

const i18n = createI18n({
  locale: 'hu', // Alapértelmezett nyelv
  fallbackLocale: 'en',
  messages,
});

export default i18n;
