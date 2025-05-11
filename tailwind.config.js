import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php'
  ],
  
  theme: {
    extend: {
      fontFamily: {
        sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
        serif: ['Playfair Display', ...defaultTheme.fontFamily.serif],
      },
      colors: {
        'resort': {
          yellow: {
            100: '#fef3c7',
            500: '#f59e0b',
            600: '#d97706'
          },
          blue: {
            100: '#dbeafe',
            500: '#3b82f6',
            600: '#2563eb'
          }
        }
      }
    },
  },

  plugins: [
    forms,
    require('@tailwindcss/typography')
  ],
}