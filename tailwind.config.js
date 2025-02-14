import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
		'./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
		 './storage/framework/views/*.php',
		 './resources/**/*.blade.php',
		 './resources/**/*.js',
		 './resources/**/*.vue',
		 "./vendor/robsontenorio/mary/src/View/Components/**/*.php"
	],
    theme: {
        extend: {
        },
    },

    daisyui: {
        darkTheme: "light",
        base: true,
        styled: true,
        themes: ["light",
            {
                mbr: {
                    ...require("daisyui/src/theming/themes")["light"],
                    "primary": "#232f54",
                    "secondary": "#e2e2e2",
                    "accent": "#a12733",
                    "neutral": "#2a323c",// light text
                    "base-100": "#ffffff", // "#1d232a" modal background
                    "info": "#1d48e8", //#00b5ff
                    "success": "#114e32",
                    "warning": "#a17b07",
                    "error": "#a12733",
                },
            },
        ],
    },


    plugins: [
		require("daisyui")
	],
};
