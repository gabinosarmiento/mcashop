/**
 * Flatcomplete (Vanilla JavaScript)
 *
 * A lightweight autocomplete component built with native DOM APIs,
 * designed for fast search suggestions without external dependencies.
 *
 * @author   Gabino Sarmiento
 * @updated  June 26, 2026
 * @version  1.1
 */
function flatcomplete(selector, options = {}) {
    const input = document.querySelector(selector);
    if (!input) return;

    const settings = Object.assign({
        delay: 300,
        minLength: 2,
        limit: 10,
        data: [],
        url: null,
        key: "key",
        value: "value",
        extra: null,
        target: null,
        color: "#066AC4",
        onSelect: null
    }, options);

    const target = settings.target ? document.querySelector(settings.target) : null;

    let timeout = null;
    let container = null;
    let isOpen = false;
    let controller = null;
    let suggestions = [];
    let selectedIndex = -1;
    let selectedText = "";
    let lastQuery = "";
    let lastResults = [];

    function close() {
        if (container) {
            container.remove();
            container = null;
        }

        selectedIndex = -1;
        isOpen = false;
    }

    function open(items, query) {
        close();

        suggestions = items.slice(0, settings.limit);
        lastQuery = query;
        lastResults = suggestions;

        container = document.createElement("div");
        container.className = "autocomplete-suggestions";
        container.style.position = "absolute";

        suggestions.forEach((item, idx) => {
            const text = item[settings.value];

            let extraText = "";
            if (settings.extra) {
                if (item[settings.extra] !== null && item[settings.extra] !== undefined) {
                    extraText = String(item[settings.extra]);
                }
            }

            const div = document.createElement("div");
            div.className = "autocomplete-suggestion";
            div.dataset.index = idx;

            div.innerHTML = highlight(text, query);

            if (extraText.trim() !== "") {
                const small = document.createElement("small");
                small.textContent = " " + extraText;
                small.style.color = settings.color;
                small.style.fontSize = "14px";
                small.style.fontWeight = "600";
                div.appendChild(small);
            }

            div.addEventListener("mouseenter", function () {
                select(idx);
            });

            div.addEventListener("mousedown", function (e) {
                e.preventDefault();

                input.value = text;
                selectedText = text;

                if (target) {
                    target.value = item[settings.key];
                }

                if (typeof settings.onSelect === "function") {
                    settings.onSelect(item);
                }

                close();
            });

            container.appendChild(div);
        });

        const rect = input.getBoundingClientRect();
        container.style.top = rect.bottom + window.scrollY + "px";
        container.style.left = rect.left + window.scrollX + "px";
        container.style.width = rect.width + "px";

        document.body.appendChild(container);
        isOpen = true;
    }

    function select(index) {
        if (!container) return;

        selectedIndex = index;

        container.querySelectorAll(".autocomplete-suggestion").forEach(function (el) {
            el.classList.remove("autocomplete-selected");
        });

        const item = container.querySelector('[data-index="' + index + '"]');

        if (item) {
            item.classList.add("autocomplete-selected");
        }
    }

    function highlight(text, query) {
        const safe = query.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
        const re = new RegExp("(" + safe + ")", "ig");

        return String(text).replace(re, "<strong>$1</strong>");
    }

    function search(query) {
        clearTimeout(timeout);

        if (target && input.value !== selectedText) {
            target.value = "";
        }

        if (query.length < settings.minLength) {
            close();
            return;
        }

        timeout = setTimeout(() => {
            if (settings.url) {
                if (controller) {
                    controller.abort();
                }

                controller = new AbortController();

                fetch(settings.url + "?search=" + encodeURIComponent(query) + "&limit=" + settings.limit, {
                    signal: controller.signal
                })
                    .then(res => res.json())
                    .then(results => {
                        if (!Array.isArray(results)) {
                            results = results.data || [];
                        }

                        if (results.length) {
                            open(results, query);
                            return;
                        }

                        close();
                    })
                    .catch(error => {
                        if (error.name !== "AbortError") {
                            close();
                        }
                    });
            }

            if (!settings.url) {
                const results = settings.data.filter(item =>
                    String(item[settings.value]).toLowerCase().includes(query.toLowerCase())
                );

                if (results.length) {
                    open(results, query);
                    return;
                }

                close();
            }
        }, settings.delay);
    }

    input.addEventListener("input", function () {
        search(input.value.trim());
    });

    input.addEventListener("focus", function () {
        if (input.value.trim() === lastQuery && lastResults.length) {
            open(lastResults, lastQuery);
        }
    });

    input.addEventListener("keydown", function (e) {
        if (!isOpen || !container) return;

        if (e.key === "ArrowDown") {
            e.preventDefault();

            if (selectedIndex < suggestions.length - 1) {
                select(selectedIndex + 1);
            } else {
                select(0);
            }
        }

        if (e.key === "ArrowUp") {
            e.preventDefault();

            if (selectedIndex > 0) {
                select(selectedIndex - 1);
            } else {
                select(suggestions.length - 1);
            }
        }

        if (e.key === "Enter") {
            if (selectedIndex >= 0) {
                e.preventDefault();

                const item = suggestions[selectedIndex];

                input.value = item[settings.value];
                selectedText = item[settings.value];

                if (target) {
                    target.value = item[settings.key];
                }

                if (typeof settings.onSelect === "function") {
                    settings.onSelect(item);
                }

                close();
            }
        }

        if (e.key === "Escape") {
            close();
        }
    });

    document.addEventListener("mousedown", e => {
        if (isOpen && container && !container.contains(e.target) && e.target !== input) {
            close();
        }
    });
}