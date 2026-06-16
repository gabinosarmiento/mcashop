<?php
define('DISCOUNT', 2);

define('IMAGES', ['png', 'jpg', 'jpeg', 'webp']);

define('MODULE', ['administracion' => 'Administración', 'soporte' => 'Soporte', 'auxiliar' => 'Auxiliar', 'venta' => 'Ventas']);

define('DEPARTMENT', ['Gerencia', 'Sistemas', 'Compras', 'Ventas', 'Diseño']);

define('CREDIT', [0 => '0.00', 7 => '2.00', 14 => '4.00', 21 => '6.00', 28 => '8.00', 45 => '10.00', 60 => '12.00']);

define('ESCHEDULE', ['0:00:00', '6:00:00', '12:00:00', '18:00:00']);

define('TAX', ['type' => '002', 'description' => 'IVA', 'factor' => 'Tasa', 'rate' => '0.160000']);

define('BANKS', [158 => 'BBVA', 159 => 'Banamex', 160 => 'Santander', 163 => 'Banorte', 164 => 'HSBC', 165 => 'Scotiabank', 1039 => 'Banco Azteca', 1023 => 'Inbursa', 1022 => 'Banregio', 1046 => 'Bancoppel']);

define('DIMENSIONS', ['width' => ['Ancho (sin base)', 'Ancho', 'Ancho del paquete'], 'height' => ['Altura (sin base)', 'Altura', 'Alto del paquete', 'Altura del paquete'], 'length' => ['Profundidad (sin base)', 'Profundidad', 'Largo', 'Largo del paquete', 'Longitud del paquete', 'Profundidad del paquete'], 'weight' => ['Peso (sin base)', 'Peso', 'Peso del paquete']]);

define('REGIME', [601 => 'General de Ley Personas Morales', 603 => 'Personas Morales con Fines No Lucrativos', 605 => 'Sueldos y Salarios e Ingresos Asimilados a Salarios', 606 => 'Arrendamiento', 607 => 'Régimen de Enajenación o Adquisición de Bienes', 608 => 'Demás Ingresos', 609 => 'Consolidación', 610 => 'Residentes en el Extranjero Sin Establecimiento Permanente en México', 611 => 'Ingresos por Dividendos(Socios y Accionistas)', 612 => 'Personas Físicas con Actividades Empresariales y Profesionales', 614 => 'Ingresos por Intereses', 615 => 'Régimen de los Ingresos por Obtención de Premios', 616 => 'Sin Obligaciones Fiscales', 620 => 'Sociedades Cooperativas de Producción que Optan por Diferir sus Ingresos', 621 => 'Incorporación Fiscal', 622 => 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras', 623 => 'Opcional para Grupos de Sociedades', 624 => 'Coordinados', 625 => 'Régimen de las Actividades Empresariales con Ingresos a través de Plataformas Tecnológicas', 626 => 'Régimen Simplificado de Confianza', 628 => 'Hidrocarburos', 629 => 'De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales', 630 => 'Enajenación de Acciones en Bolsa de Valores']);

define('MERCADOPAGO_STATUS', ['approved' => 'Pago aprobado y acreditado correctamente.', 'authorized' => 'Pago autorizado, pendiente de captura o confirmación.', 'in_process' => 'Pago en proceso de validación por parte de Mercado Pago o el banco.', 'pending' => 'Pago pendiente de confirmación o acreditación.', 'rejected' => 'Pago rechazado.', 'cancelled' => 'Pago cancelado.', 'refunded' => 'Pago reembolsado total o parcialmente.', 'charged_back' => 'Pago desconocido por el titular y revertido por el banco.', 'in_mediation' => 'Pago en mediación por una disputa o reclamo.']);

define('MERCADOPAGO_DETAIL', ['cc_rejected_bad_filled_card_number' => 'Revisa el número de tu tarjeta.', 'cc_rejected_bad_filled_date' => 'Revisa la fecha de vencimiento.', 'cc_rejected_bad_filled_security_code' => 'Revisa el código de seguridad.', 'cc_rejected_bad_filled_cardholder_name' => 'Revisa el nombre del titular de la tarjeta.', 'cc_rejected_bad_filled_identification_number' => 'Revisa el número de identificación.', 'cc_rejected_bad_filled_identification_type' => 'Revisa el tipo de identificación.', 'cc_rejected_bad_filled_email' => 'Revisa el correo electrónico.', 'cc_rejected_bad_filled_other' => 'Revisa los datos de tu tarjeta.', 'cc_rejected_blacklist' => 'No fue posible procesar el pago.', 'cc_rejected_call_for_authorize' => 'Debes autorizar el pago con tu banco.', 'cc_rejected_card_disabled' => 'La tarjeta se encuentra deshabilitada.', 'cc_rejected_card_error' => 'No fue posible procesar la tarjeta.', 'cc_rejected_duplicated_payment' => 'Ya existe un pago muy similar reciente.', 'cc_rejected_high_risk' => 'El pago fue rechazado por motivos de seguridad.', 'cc_rejected_insufficient_amount' => 'Fondos insuficientes.', 'cc_rejected_invalid_installments' => 'La cantidad de mensualidades no es válida.', 'cc_rejected_max_attempts' => 'Has excedido el número de intentos permitidos.', 'cc_rejected_other_reason' => 'Tu banco rechazó el pago.', 'cc_rejected_3ds_challenge' => 'No se pudo completar la validación de seguridad.', 'cc_rejected_3ds_mandatory' => 'El pago requiere validación de seguridad adicional.', 'cc_rejected_time_out' => 'No fue posible procesar el pago en este momento.', 'bank_error' => 'Ocurrió un error con el banco.', 'rejected_by_bank' => 'La operación fue rechazada por el banco.', 'rejected_insufficient_data' => 'Faltan datos para procesar el pago.', 'cc_amount_rate_limit_exceeded' => 'El monto excede el límite permitido para este método de pago.', 'Invalid transaction_amount' => 'El monto no está permitido para el método de pago seleccionado.']);

define('MERCADOPAGO_METHOD', ['oxxo' => 'OXXO', 'paycash' => 'Pago en efectivo', 'account_money' => 'Dinero en cuenta Mercado Pago', 'bank_transfer' => 'Transferencia bancaria', 'debin_transfer' => 'Transferencia DEBIN', 'visa' => 'Visa', 'master' => 'Mastercard', 'amex' => 'American Express', 'naranja' => 'Naranja', 'cabal' => 'Cabal', 'maestro' => 'Maestro']);

define('MERCADOPAGO_TYPE', ['credit_card' => 'Tarjeta de crédito', 'debit_card' => 'Tarjeta de débito', 'prepaid_card' => 'Tarjeta prepagada', 'ticket' => 'Pago en efectivo', 'bank_transfer' => 'Transferencia bancaria', 'account_money' => 'Saldo de Mercado Pago']);
