const defaultTheme = require("tailwindcss/defaultTheme");

module.exports = {
    content: [
        "./app/**/*.php",
        "./resources/**/*.{html,blade.php,js,jsx,ts,tsx,php,vue,twig}",
        "./modules/**/*.{html,blade.php,js,jsx,ts,tsx,php,vue,twig}",
        "./public/index.html",
    ],
    theme: {
        extend: {
            transitionDuration: {
                400: "400ms",
            },
            fontFamily: {
                sans: ["Inter", "system-ui"],
                serif: ["ui-serif", "Georgia"],
                mono: ["ui-monospace", "SFMono-Regular"],
                display: ["Inter"],
                body: ['"Inter"'],
            },
            colors: {
                neutral: {
                    100: "#F6F7FB",
                    200: "#e5e5e5",
                },
                gray: {
                    50: "#F9FAFD",
                    100: "#F2F4FD",
                    200: "#E5E7EB",
                    300: "#DADADA",
                    400: "#D5D5DC",
                    // 500: "#6B7280",
                    600: "#42526E",
                    800: "#172B4D",
                    900: "#111928",
                },
                green: {
                    50: "#F1FAF9",
                    700: "#06746D",
                },
                black: {
                    100: "#5E6C84",
                    500: "#1F2A37",
                },
                blue: {
                    500: "#3F83F8",
                },
            },
        },
    },
};
