class Utils {

    /**
     * Build String, leave fraction empty if null.
     * @param args
     * @returns {string}
     */
    static notNullConcat (...args) {
        let s = ''
        args.forEach(arg => {
            if (arg != null) {
                s += arg
            }
        })
        return s
    }

    /**
     * Build String and replace if null
     * @param source Array
     * @param replacement Array
     * @returns {string}
     */
    static notNullConcatReplace (source, replacement) {
        let s = ''
        for (let i=0; i < source.length; i++) {
            if (source[i] != null) {
                s += source[i];
            } else {
                s += replacement[i];
            }
        }
        return s
    }

    /**
     * Build String and replace if null
     * @param source Array
     * @param replacement Array
     * @returns {string}
     */
    static notEmptyConcatReplace (source, replacement) {
        let s = ''
        for (let i=0; i < source.length; i++) {
            if (source[i] != null && source[i] !== '') {
                s += source[i];
            } else {
                s += replacement[i];
            }
        }
        return s
    }

    static getScreenHeight () {
        return screen.height
    }

    static pixelByPercent (pixel, percent) {
        return Math.floor(pixel * (percent/100))
    }
}


export default Utils