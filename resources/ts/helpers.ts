
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
