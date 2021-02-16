const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

module.exports = {
    purge: ['./storage/framework/views/*.php', './resources/views/**/*.blade.php','./resources/**/*.js',
        +     './resources/**/*.vue',],

    colors: {
        transparent: 'transparent',
        current: 'currentColor',
        black: colors.black,
        white: colors.white,
        gray: colors.trueGray,
        indigo: colors.indigo,
        red: colors.red,
        yellow: colors.amber,
        blue: colors.blue
    },

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
            textOpacity: ['dark'],
            padding: ['hover']
        },
    },

    plugins: [require('@tailwindcss/forms')],

};
