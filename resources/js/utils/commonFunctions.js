/**
 * Transforma el valor entrante en tipo Number
 * Quita las comas
 *
 * @param {Any} value
 */
export function toNumberParse(value) {
    // Forzamos el valor a tipo String y quitamos todas las comas
    const stringValue = String(value).replaceAll(",", "");
    const resNumber   = Number(stringValue);
    // Verificamos que el valor tenga formato de número
    if (isNaN(resNumber)) {
        console.error(`Invalid number, given: "${value}"`);
        return 0;
    } else {
        return resNumber;
    }
}

/**
 *
 * @param {Number} value
 * @param {Number} decimals
 *
 * Transforma valor tipo number a string con comas
 * e.j.     99999 => "99,999.00"
 */
export function stringFormatCommas(value, decimals = 2) {
    let number           = toNumberParse(value); // Convierte el valor a int
    let numberWithCommas = number.toFixed(decimals).replace(/\B(?=(\d{3})+(?!\d))/g, ","); // Formatea el valor
    return `${numberWithCommas}`;
}