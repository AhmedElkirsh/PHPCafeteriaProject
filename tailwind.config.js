/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./views/**/*.php", "./public/**/*.php", "./resources/**/*.css"],
  theme: {
    extend: {
      colors: {
        text: {
          DEFAULT: "#0b0b03",
          50: "#d1d1c7", // Light shade
          100: "#b5b5a0",
          200: "#9a9a79",
          300: "#7f7f52",
          400: "#646432",
          500: "#4b4b1c",
          600: "#333312",
          700: "#1e1d09",
          800: "#0b0b03",
          900: "#000000",
        },
        background: {
          DEFAULT: "#fdfdf8",
          50: "#ffffff", // Light shade
          100: "#fcfcf4",
          200: "#f9f9e8",
          300: "#f7f7dd",
          400: "#f4f4d1",
          500: "#f1f1c6",
          600: "#dedec0",
          700: "#bcbcb2",
          800: "#9a9a9d",
          900: "#78787b",
        },
        primary: {
          DEFAULT: "#f6ff5a",
          50: "#ffffc4", // Light shade
          100: "#ffffa8",
          200: "#ffff7e",
          300: "#ffff54",
          400: "#ffff2a",
          500: "#f6ff5a",
          600: "#d4e620",
          700: "#b3c510",
          800: "#8a9e00",
          900: "#6b7e00",
        },
        secondary: {
          DEFAULT: "#bee18f",
          50: "#f2f9e0", // Light shade
          100: "#e5f2c2",
          200: "#d0eaa2",
          300: "#b9e683",
          400: "#a2e264",
          500: "#bee18f",
          600: "#9dca6b",
          700: "#7db747",
          800: "#5d8e29",
          900: "#46681d",
        },
        accent: {
          DEFAULT: "#94d86f",
          50: "#e0f8c4", // Light shade
          100: "#c4f2a8",
          200: "#a8eb8d",
          300: "#8ee26e",
          400: "#74d74d",
          500: "#94d86f",
          600: "#76b953",
          700: "#579b3d",
          800: "#3a7a2c",
          900: "#23601e",
        },
      },
    },
  },
  plugins: [],
};
