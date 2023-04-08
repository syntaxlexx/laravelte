import dayjs from 'dayjs';

/**
 * convert snake case to sentence case, capitalizing all words
 * eg 'your_string' => 'Your String'
 */
export const snakeCaseToSentenceCaseCapitalizeWords = (value: string | null) => {
    if (!value) return "";
    value = value.replace(/(_)/g, " ");
    return value.replace(/\b\w/g, function (l) {
        return l.toUpperCase();
    });
};


/**
 * format a post date
 * @param dt Date
 * @param format string
 * @returns string
 */
export const formatDate = (dt: Date | null | undefined, format = 'DD MMMM, YYYY') => {
    if (!dt) return null;
    return dayjs(dt).format(format);
}
