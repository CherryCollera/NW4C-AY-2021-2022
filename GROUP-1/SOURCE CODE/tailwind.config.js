const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    mode: "jit",
    purge: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Nunito", ...defaultTheme.fontFamily.sans],
            },

            colors: {
                green: {
                    450: "#75b23d",
                    650: "#549816",
                },
                brown: {
                    500: "#866139",
                    900: "#5C4033",
                },
            },
        },
    },

    variants: {
        extend: {
            opacity: ["disabled"],
        },
    },

    plugins: [
        require("@tailwindcss/forms"),
        require("@tailwindcss/typography"),
    ],
};
