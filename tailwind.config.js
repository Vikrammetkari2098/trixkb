/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  theme: {
    fontSize: {
      'xs': ['0.75rem', { lineHeight: '1rem' }],     // 12px
      'sm': ['0.875rem', { lineHeight: '1.25rem' }], // 14px
      'base': ['0.75rem', { lineHeight: '1rem' }],   // 12px (default)
      'lg': ['1.125rem', { lineHeight: '1.75rem' }], // 18px
      'xl': ['1.25rem', { lineHeight: '1.75rem' }],  // 20px
      '2xl': ['1.5rem', { lineHeight: '2rem' }],     // 24px
      '3xl': ['1.875rem', { lineHeight: '2.25rem' }], // 30px
      '4xl': ['2.25rem', { lineHeight: '2.5rem' }],  // 36px
      '5xl': ['3rem', { lineHeight: '1' }],          // 48px
      '6xl': ['3.75rem', { lineHeight: '1' }],       // 60px
      '7xl': ['4.5rem', { lineHeight: '1' }],        // 72px
      '8xl': ['6rem', { lineHeight: '1' }],          // 96px
      '9xl': ['8rem', { lineHeight: '1' }],          // 128px
    },
    extend: {
      fontFamily: {
        sans: ['ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'Noto Sans', 'sans-serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    // Add other plugins here as needed
  ],
}

