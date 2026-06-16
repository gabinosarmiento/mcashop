/**
 * MercadoPago Integration Script for mcashop.mx
 *
 * Description: Provides functions for handling MercadoPago payment processes
 * within mcashop.mx, including initialization, validation, and
 * transaction handling.
 *
 * Property of: mcashop.mx
 * Developed by: @gabinosarmiento
 * Last Updated: November 14, 2024
 * Version: 1.1
 */
var mercadopago_script = document.createElement("script");
mercadopago_script.src = "https://sdk.mercadopago.com/js/v2";
document.head.appendChild(mercadopago_script);
mercadopago_script.onload = function() {
    const mp = new MercadoPago(MERCADOPAGO.KEY, {
        locale: "es-MX",
    });
    const bricks_builder = mp.bricks();
    const render_payment_brick = async () => {
        // Si ya existe un Brick montado, primero desmontarlo
        if (window.paymentBrickController) {
            window.paymentBrickController.unmount();
            window.paymentBrickController = null;
        }
        const settings = {
            initialization: {
                amount: MERCADOPAGO.TOTAL,
                preferenceId: MERCADOPAGO.PREFERENCE_ID
            },
            customization: {
                visual: {
                    style: {
                        customVariables: {
                            formPadding: "12px",
                            borderRadiusMedium: "16px"
                        }
                    }
                },
                paymentMethods: {
                    atm: "all",
                    ticket: "all",
                    creditCard: "all",
                    debitCard: "all",
                    bankTransfer: "all",
                    wallet_purchase: "all",
                    maxInstallments: 12,
                },
            },
            callbacks: {
                onReady: () => {},
                onSubmit: ({
                    selectedPaymentMethod,
                    formData
                }) => {
                    return new Promise((resolve, reject) => {
                        fetch(MERCADOPAGO.PAY_ORDER, {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": MERCADOPAGO.CSRF,
                            },
                            body: JSON.stringify(formData),
                        }).then((response) => {
                            if (!response.ok) {
                                return response.json().then(data => {
                                    throw new Error(data.message);
                                });
                            }
                            return response.json();
                        }).then((response) => {
                            document.body.notification({
                                body: response.message,
                                type: 'success'
                            });
                            setTimeout(() => {
                                window.location.href = MERCADOPAGO.REDIRECT_URL;
                            }, 5000);
                            resolve();
                        }).catch((error) => {
                            document.body.notification({
                                body: error.message,
                                type: 'danger'
                            });
                            reject();
                        });
                    });
                },
                onError: (error) => {
                    console.error("Resultado error: ", error);
                },
            },
        };
        // Crear un nuevo Brick limpio
        window.paymentBrickController = await bricks_builder.create("payment", "payment_container", settings);
    };
    // Renderizar la primera vez
    render_payment_brick();
};