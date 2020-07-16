import moment from "moment";

/**
 * Provide Date Formats for german and <input>
 */
class DateFormat {

    static getNativeInput (date) {
        return moment(date, 'DD.MM.YYYY').format('YYYY-MM-DD');
    }

    static getNativeInputFromDateTime (date) {
        return moment(date).format('YYYY-MM-DD');
    }

    static fromInput (date) {
        return moment(date).format('DD.MM.YYYY');
    }

    static cutTime (date) {
        return moment(date).format('YYYY-MM-DD');
    }

    /**
     * without time
     * @param date
     * @returns {string}
     */
    static getGermanDate (date) {
        return moment(date).format('DD.MM.YYYY');
    }

    /**
     * without time
     * @param date
     * @returns {string}
     */
    static getGermanDateTime (date) {
        return moment(date).format('DD.MM.YYYY H:mm:ss');
    }

    static getToday () {
        return moment().format('YYYY-MM-DD');
    }

    static getPlusOneYear () {
        return moment().add('1', 'year').format('YYYY-MM-DD');
    }
}

export default DateFormat;
