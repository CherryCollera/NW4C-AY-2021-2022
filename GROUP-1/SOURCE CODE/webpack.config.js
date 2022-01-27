const path = require("path");

module.exports = {
    resolve: {
        alias: {
            "@": path.resolve("resources/js"),
            "@css": path.resolve("resources/css"),
            "@utils": path.resolve("resources/js/Utilities"),
            "@services": path.resolve("resources/js/Services"),
        },
    },
};
