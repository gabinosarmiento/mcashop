import Echo from "laravel-echo";
import Pusher from "pusher-js";

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: "reverb",
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: parseInt(import.meta.env.VITE_REVERB_PORT),
    wssPort: parseInt(import.meta.env.VITE_REVERB_PORT),
    forceTLS: import.meta.env.VITE_REVERB_SCHEME === "https",
    enabledTransports: ["ws", "wss"],
});

const cartToken = document
    .querySelector('meta[name="cart-token"]')
    .getAttribute("content");

window.Echo.channel("cart." + cartToken).listen(".CartEvent", function (e) {
    const cartBadge = document.getElementById("cart");

    cartBadge.innerHTML = e.cartItems;
});
