// tailwind.config.js
module.exports = {
  content: ['./app/Views/**/*.php'],
  theme: {
    extend: {
      colors: {
        primary: {
          600: 'var(--color-primary-600)',
          700: 'var(--color-primary-700)',
        },
      },
    },
  },
  plugins: [],
};
