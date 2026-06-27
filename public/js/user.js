(function() {
    let requests = 0;

    let keyupDelay = null;

    let pathName = window.location.pathname;

    const inputTypes = ['text', 'select-one'];

    const checkTypes = ['radio', 'checkbox'];

    const clickHandlers = [{
        selector: '[id^="action-"]',
        run: element => ajax_request(element)
    }, {
        selector: '[id^="delete-"]',
        run: (element, e) => confirm_action(element, e, '¿Deseas *eliminar* el registro?')
    }, {
        selector: '[id^="cancel-"]',
        run: (element, e) => confirm_action(element, e, '¿Deseas cancelar el registro?')
    }];

    document.addEventListener('submit', function (e) {
        const ajax = e.target.closest('form[id^="ajax-"]');
        if (ajax) {
            e.preventDefault();
            ajax_request(e.target);
        }
    });

    document.addEventListener('click', function(e) {
        for (const handler of clickHandlers) {
            const click = e.target.closest(handler.selector);
            if (click) {
                e.preventDefault();
                handler.run(click, e);
                break;
            }
        }
    });

    document.addEventListener('focusin', function(e) {
        const change = e.target.closest('[id^="change-"]');
        if (change) {
            change.previousValue = change.value;
        }
    });

    document.addEventListener('change', function(e) {
        const submit = e.target.closest('[id^="submit-"]');
        if (submit) {
            const form = submit.closest('form');

            if (form) {
                form.requestSubmit();
            }
        }
    });

    document.addEventListener('change', function(e) {
        const change = e.target.closest('[id^="change-"]');
        if (change) {
            e.preventDefault();
            if (!validate_change(change)) {
                return;
            }
            ajax_request(change);
        }
    });

    document.addEventListener('fetchStop', (e) => {});

    document.addEventListener('fetchStart', (e) => {
        document.body.insertAdjacentHTML('afterbegin', '<process></process>');
    });

    document.addEventListener('fetchComplete', (e) => {
        let element = document.querySelector('process');

        element.style.transition = 'opacity 0.5s';
        element.style.opacity = 0;

        setTimeout(() => element.remove(), 500);
    });

    document.addEventListener('fetchError', (e) => {
        const { response, error } = e.detail;

        if (response) {
            response.json().then(item => {
                let message = 'Error desconocido';

                if (item.message) {
                    message = item.message;
                }

                if (item.errors) {
                    message = '';

                    Object.values(item.errors).forEach(array => {
                        array.forEach(detail => {
                            message += detail + '<br>';
                        });
                    });
                }

                document.body.notification({ body:message, type:'danger' });
            }).catch(() => {
                document.body.notification({ body:'Sin respuesta del servidor', type:'danger' });
            });
        }

        if (error) {
            document.body.notification({ body:error.message, type:'danger' });
        }
    });

    window.fetchWithEvents = function (url, options) {
        if (requests === 0) {
            document.dispatchEvent(new CustomEvent('fetchStart'));
        }

        requests++;

        return fetch(url, options).then(response => {
            document.dispatchEvent(new CustomEvent('fetchComplete', { detail: { response } }));

            if (!response.ok) {
                document.dispatchEvent(new CustomEvent('fetchError', { detail: { response } }));

                // evitamos throw para no entrar otra vez en el catch
                return response;
            }

            return response;
        }).catch(error => {
            document.dispatchEvent(new CustomEvent('fetchError', { detail: { error } }));

            // en errores de red sí lo relanzamos
            throw error;
        }).finally(() => {
            requests--;

            if (requests === 0) {
                document.dispatchEvent(new CustomEvent('fetchStop'));
            }
        });
    };

    window.ajax_request = function(element) {
        var instance = Object.assign({}, element.dataset);
        if (instance.action) {
            instance.url = instance.action;
        }
        if (instance.route) {
            instance.url = pathName.replace(/\/+$/, '') + '/' + String(instance.route).replace(/^\/+/, '');
        }
        if (!instance.method) {
            instance.method = 'get';
        }
        instance.method = instance.method.toLowerCase();
        var options = {
            method: instance.method,
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        };
        if (instance.method === 'get') {
            if (element.tagName === 'FORM') {
                var query = new URLSearchParams(new FormData(element)).toString();
                if (query) {
                    instance.url += (instance.url.includes('?') ? '&' : '?') + query;
                }
            }
            if (inputTypes.includes(element.type)) {
                const param = encodeURIComponent(element.name) + '=' + encodeURIComponent(element.value);
                instance.url += (instance.url.includes('?') ? '&' : '?') + param;
            }
            if (checkTypes.includes(element.type)) {
                if (element.checked) {
                    const param = encodeURIComponent(element.name) + '=' + encodeURIComponent(element.value);
                    instance.url += (instance.url.includes('?') ? '&' : '?') + param;
                }
            }
        }
        if (instance.method === 'post') {
            if (element.tagName === 'FORM') {
                options.body = new FormData(element);
            }
            if (inputTypes.includes(element.type)) {
                const formData = new FormData();
                formData.append(element.name, element.value);
                options.body = formData;
            }
            if (checkTypes.includes(element.type)) {
                if (element.checked) {
                    const formData = new FormData();
                    formData.append(element.name, element.value);
                    options.body = formData;
                }
            }
        }
        return fetchWithEvents(instance.url, options).then(function(response) {
            let content = '';
            if (!response.ok) {
                throw response;
            }
            if (response.headers.has('Content-Type')) {
                content = response.headers.get('Content-Type').toLowerCase();
            }
            if (content.indexOf('application/json') !== -1) {
                return response.json();
            }
            return response.text();
        }).then(function(result) {
            if (result.message) {
                document.body.notification({ body: result.message });
            }

            if (result.update) {
                update_action(result.update);
            }

            if (instance.overlapShow) {
                var overlapShow = document.querySelector(instance.overlapShow);

                if (overlapShow) {
                    overlapShow.overlap('show');
                }
            }

            if (instance.overlapHide) {
                var overlapHide = document.querySelector(instance.overlapHide);

                if (overlapHide) {
                    overlapHide.overlap('hide');
                }
            }

            if (element.tagName === 'FORM') {
                if (element.dataset.reset !== 'false') {
                    element.reset();
                }
            }

            if (result.redirect) {
                window.location.replace(result.redirect);

                return;
            }
        }).catch(function(error) {
            // throw error;
        });
    }

    function validate_change(element) {
        const validate = element.dataset.validate;

        if (validate) {
            let valid = true;

            const value = element.value;
            const rules = validate.split('|');

            for (const rule of rules) {
                const [name, param] = rule.split(':');

                if (name == 'integer') {
                    valid = Number.isInteger(Number(value));
                }

                if (name == 'min') {
                    valid = Number(value) >= Number(param);
                }

                if (name == 'max') {
                    valid = Number(value) <= Number(param);
                }

                if (name == 'regex') {
                    valid = new RegExp(param).test(value);
                }

                if (valid === false) {
                    element.value = element.previousValue;
                    element.shakeIt();

                    return false;
                }
            }
        }

        return true;
    }

    function update_action(render) {
        Object.keys(render).forEach(function(id) {
            var element = document.getElementById(id);

            if (element) {
                var item = render[id];
                var place = 'inner';
                var content = item;

                if (item.content) {
                    content = item.content;
                }

                if (item.place) {
                    place = item.place;
                }

                if (place === 'inner') {
                    element.innerHTML = content;

                    execute_scripts(element);
                }

                if (place === 'outer') {
                    element.outerHTML = content;

                    var replacement = document.getElementById(id);

                    if (replacement) {
                        execute_scripts(replacement);
                    }
                }

                if (place === 'before') {
                    element.insertAdjacentHTML('beforebegin', content);
                    execute_scripts(element.parentElement);
                }

                if (place === 'after') {
                    element.insertAdjacentHTML('afterend', content);
                    execute_scripts(element.parentElement);
                }
            }
        });
    }

    function confirm_action(element, e, message) {
        document.body.confirm({
            message: {
                text: message
            },
            actions: {
                confirm: {
                    text: 'Continuar',
                    callback: function(close) {
                        ajax_request(element);
                    }
                }
            },
            event: e
        });
    }

    function execute_scripts(element) {
        element.querySelectorAll('script').forEach(function(oldScript) {
            var newScript = document.createElement('script');

            Array.prototype.slice.call(oldScript.attributes).forEach(function(attr) {
                newScript.setAttribute(attr.name, attr.value);
            });

            newScript.textContent = oldScript.textContent;

            oldScript.replaceWith(newScript);
        });
    }
})();