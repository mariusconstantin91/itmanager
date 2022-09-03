import $ from "jquery";
import Choices from "choices.js";
import flatpickr from "flatpickr";
window.jQuery = window.$ = $;

window.Choices = (element, options) => {
    return new Choices(element, options);
};

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

require("./custom");
window.flatpickr = flatpickr;
