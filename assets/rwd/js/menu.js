import Mmenu from "mmenu-js";

document.addEventListener(
  "DOMContentLoaded", () => {

    // Mmenu
    const mobileMenu = new Mmenu( "#mobile_nav", {
      "slidingSubmenus": false,
      "offCanvas": {
        "position": "right"
      },
      "theme": "light",
      "navbars": [
        {
          "position": "top",
          "content": [
            "prev",
            "<div class='mobileNav__logoWrapper'><img class='mobileNav__logo' src='" + window.images['logo-color'] + "' /></div>",
            "close"
          ]
        }
      ]
    });
  }
);

