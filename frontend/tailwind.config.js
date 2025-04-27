import { fa } from '@formkit/i18n/index.cjs';

/** @type {import('tailwindcss').Config} */
export default {
  darkMode: false,
  content: [
    "./index.html",
    "./src/**/*.{vue,js,ts,jsx,tsx}",
  ],
  theme: {
    extend: {},
  },
  plugins: [
    import('@tailwindcss/aspect-ratio'),
    import('@tailwindcss/container-queries'),
    import('@tailwindcss/forms'),
    import('@tailwindcss/typography')
  ],
}